<?php

namespace Reactor\ServiceContainer;

/**
 * @package Reactor\ServiceContainer
 * Service factory.
 * Scenario based. Service is an object or value.
 * Can cache instance to share it.
 * If scenario steps arguments that implement ServiceProviderInterface - will be resolved when scenario is executed
 */
class ServiceProvider implements ServiceProviderInterface {
    /**
     * @var array
     */
    protected $scenario = array();
    /**
     * @var bool
     */
    protected $shared = false;
    /**
     * @var null
     */
    protected $instance = null;

    /**
     * @param mixed $igniter classname or callable or ServiceProviderInterface object
     * @param array $arguments list or arguments in case of $igniter is classname or callable
     *  
     */
    public function __construct($igniter = null, $arguments = array()) {
        $this->createScenario($igniter, $arguments);
    }

    /**
     * Cache result value after scenario has been execured
     * @param bool $flag 
     * @return $this
     */
    public function shared($flag = true) {
        $this->shared = (bool) $flag;
        return $this;
    }

    /**
     * Check provider is shared or not
     * @return bool
     */
    public function isShared() {
        return $this->shared;
    }

    /**
     * Start new scenario
     * @param mixed $igniter classname or callable or ServiceProviderInterface object
     * @param array $arguments list or arguments in case of $igniter is classname or callable
     * @return $this
     */
    public function createScenario($igniter = null, $arguments = array()) {
        $this->scenario = array();
        $this->scenario[] = array(
            'type' => 'create',
            'igniter' => $igniter,
            'arguments' => $arguments,
        );
        return $this;
    }

    /**
     * Add Factory call step in scenario
     * @param mixed $factory callable or method name
     *  $factory can be callable only if addFactory is the first step
     *  Returned value will be used as service
     * @param array $arguments list or arguments in case of $igniter is classname or callable
     * @return $this
     */
    public function addFactory($factory, $arguments = array()) {
        $this->scenario[] = array(
            'type' => 'factory',
            'igniter' => $factory,
            'arguments' => $arguments,
        );
        return $this;
    }

    /**
     * Add Callable step in scenario
     * @param string $method_name
     * @param array $arguments
     * @return $this
     */
    public function addCall($method_name, $arguments = array()) {
        $this->scenario[] = array(
            'type' => 'call',
            'igniter' => $method_name,
            'arguments' => $arguments,
        );
        return $this;
    }

    /**
     * Add Configurator call step in scenario
     * @param mixed $configurator
     * @param array $arguments
     * @return $this
     */
    public function addConfigurator($configurator, $arguments = array()) {
        $this->scenario[] = array(
            'type' => 'configurator',
            'igniter' => $configurator,
            'arguments' => $arguments,
        );
        return $this;
    }

    /**
     * @param ServiceContainer $container
     * @return mixed|null
     */
    public function getService($container = null) {
        if ($this->instance) {
            return $this->instance;
        }
        $instance = $this->createInstance($container);
        if ($this->shared) {
            $this->instance = $instance;
        }
        return $instance;
    }

    /**
     * @param ServiceContainer $container
     * @return mixed|null
     */
    public function createInstance($container) {
        $scenario = $container->resolveProviders($this->scenario);
        $instance = null;
        foreach($scenario as $step) {
            $instance = call_user_func_array(array($this, 'step_'.$step['type']), array($instance, $step['igniter'], $step['arguments']));
        }

        return $instance;
    }

    /**
     * @param null $instance not yet used
     * @param mixed $igniter
     * @param array $arguments
     * @return mixed|object
     */
    protected function step_create($instance, $igniter, $arguments) {
        if (is_callable($igniter)) {
            $instance = call_user_func_array($igniter, $arguments);
        } elseif (is_string($igniter)) {
            $class_reflection = new \ReflectionClass($igniter);
            $instance = $class_reflection->newInstanceArgs($arguments);
        } else {
            $instance = $igniter;
        }
        return $instance;
    }

    /**
     * @param object|null $instance
     * @param callable $igniter
     * @param array $arguments
     * @return mixed
     */
    protected function step_factory($instance, $igniter, $arguments) {
        if ($instance === null) {
            return call_user_func_array($igniter, $arguments);
        } else {
            return call_user_func_array(array($instance, $igniter), $arguments);
        }
    }

    /**
     * @param object $instance
     * @param callable $igniter
     * @param array $arguments
     * @return object
     */
    protected function step_call($instance, $igniter, $arguments) {
        call_user_func_array(array($instance, $igniter), $arguments);
        return $instance;
    }

    /**
     * @param object $instance
     * @param callable $igniter
     * @param array $arguments
     * @return object
     */
    protected function step_configurator($instance, $igniter, $arguments) {
        call_user_func_array($igniter, array_merge(array($instance), $arguments));
        return $instance;
    }

    /**
     * reset
     */
    public function reset() {
        $this->instance = null;
    }

}
