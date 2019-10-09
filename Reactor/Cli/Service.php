<?php

namespace Reactor\Cli;

use \Reactor\Application\MultiService;
use \Reactor\Common\ValueScope;
use Symfony\Component\Yaml\Yaml;

class Service extends MultiService {
    
    public function handleCli($args) {
        $call = new \Reactor\Common\ValueScope\ValueScopeArray($args);
        $path = $call->get(1, '/');
        $method = $call->get(2, null);
        if ($path == '/' and $method === null) {
            $this->help();
        }
        if (count($args) > 3) {
            array_shift($args);
            array_shift($args);
            array_shift($args);
        } else {
            $args = array();
        }
        try {
            $obj = $this->app->getByPath($path, false);
        } catch (\Throwable $e) {
            $obj = null;
        }
        if ($obj === false) {
            echo "Error: Path not found method $path\n\n";
            $obj = $this->app->getByPath('/', false);
            $method = null;
        }
        if ($method !== null) {
            $need_args = $this->getParameters($obj, $method);
            if ($need_args === false) {
                echo "Error: Not found method $method\n\n";
                $method = null;
            } elseif (count($args) < $this->getCntNeedeParams($need_args)) {
                echo "Error: Too few arguments to method $method\n\n";
                $method = null;
            }
        }

        $rez = $this->app->callService($path, $method, $args);
        if ($rez !== null) {
            $this->nicePrint($rez);
        }
        echo "\n";
    }

    public function help() {
        echo "Usage: /Service/Path [method = handler] [argument ...]  \n";
    }

    protected function nicePrint($mixed) {
        if (is_subclass_of($mixed, 'Reactor\ServiceContainer\ServiceContainer')) {
            echo "Available paths:\n";
            $path = $mixed->getFullName();
            foreach ($mixed as $key => $value) {
                echo $path.$key." - ";
                if (is_object($value)) {
                    echo get_class($value)."\n";    
                } else {
                    echo gettype($value)."\n";
                }
            }
        } elseif (is_array($mixed)) {
            echo $this->dumpArray($mixed);
        } elseif (is_object($mixed)) {
            echo "Class is ".get_class($mixed)."\n"; 
            echo "Avaiable methods:\n";
            $ref = new \ReflectionClass($mixed);
            foreach ($ref->getMethods() as $method) {
                if ($method->isPublic()) {
                    echo "{$method->name}";
                    foreach($method->getParameters() as $parameter) {
                        echo ' $'.$parameter->name;
                        if ($parameter->isDefaultValueAvailable()) {
                            echo ' ['.str_replace(\PHP_EOL,'', var_export($parameter->getDefaultValue(), true)).'] ';
                        }
                    }
                    echo "\n";
                }
            }
        } else {
            var_export($mixed);
        }
    }

    protected function getParameters($obj, $method_name) {
        $ref = new \ReflectionClass($obj);
        if (!$ref->hasMethod($method_name)) {
            return false;
        }
        $method = $ref->getMethod($method_name);
        return $method->getParameters();
    }

    protected function getCntNeedeParams($params) {
        $cnt = 0;
        foreach ($params as $parameter) {
            if (!$parameter->isDefaultValueAvailable()) {
                $cnt++;
            }
        }
        return $cnt;
    }

    protected function dumpArray($data, $level = 0) {
        $rez = '';
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $rez .= str_repeat(' ', $level*4).$key.': ';
                if (is_array($value)) {
                    $rez .= "\n";
                }
                $rez .= $this->dumpArray($value, $level + 1);
            }
        } elseif (is_object($data)) {
            $rez .= gettype($data).' '.get_class($data)."\n";
        } else {
            $rez .= var_export($data, true)."\n"; 
        }
        return $rez;
    }

}
