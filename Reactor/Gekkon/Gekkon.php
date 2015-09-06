<?php

namespace Reactor\Gekkon;

class Gekkon {
    var $version = '4.3';
    var $gekkon_path;
    var $compiler;
    var $settings;
    var $loaded;
    var $data;
    var $tplProvider;
    var $binTplProvider;
    var $cacheProvider;

    function __construct($tpl_path, $bin_path)
    {
        $this->gekkon_path = dirname(__file__).'/';
        $this->compiler = null;
        $this->settings = DefaultSettings::get();
        $this->loaded = array();
        $this->data = new \ArrayObject();
        $this->data['global'] = $this->data;
        $this->tplProvider = new TemplateProviderFS('');
        $this->binTplProvider = new BinTplProviderFS($this, $bin_path);
        $this->cacheProvider = new CacheProviderFS($bin_path);
        $this->tplGroup = new TemplateGroup($this);
        $this->tplGroup->push($tpl_path);
    }

    function assign($name, $data)
    {
        $this->data[$name] = $data;
    }

    function register($name, $data)
    {
        $this->data[$name] = $data;
    }

    function push_group($group)
    {
        $this->tplGroup->push($group);
    }

    function pop_group()
    {
        return $this->tplGroup->pop();
    }

    function display($tpl_name, $scope_data = false, $group = null)
    {
        if ($group) $this->push_group($group);
        if(($binTemplate = $this->template($tpl_name)) !== false)
                $binTemplate->display($this->get_scope($scope_data));
        if ($group) $this->pop_group();
    }

    function get_display($tpl_name, $scope_data = false)
    {
        ob_start();
        $this->display($tpl_name, $scope_data);
        return ob_get_clean();
    }

    function template($tpl_name)
    {
        $tpl_full_name = $this->tplProvider->get_full_name($tpl_name);
        if(isset($this->loaded[$tpl_full_name]))
                return $this->loaded[$tpl_full_name];

        if(($template = $this->tplProvider->load($tpl_name)) === false)
                return $this->error('Template '.$tpl_name.' cannot be found at '.$tpl_full_name,
                            'gekkon');

        if($this->settings['force_compile']) $binTpl = false;
        else $binTpl = $this->binTplProvider->load($template);

        if($binTpl === false || !$template->check_bin($binTpl))
        {
            if(($binTpl = $this->compile($template)) === false)
                    return $this->error('Cannot compile '.$tpl_name, 'gekkon');
            $this->cacheProvider->clear_cache($binTpl);
        }
        return $this->loaded[$tpl_full_name] = $binTpl;
    }

    function clear_cache($tpl_name, $id = '')
    {
        if(($template = $this->tplProvider->load($tpl_name)) === false)
                return $this->error('Template '.$tpl_name.' cannot be found at '.$tpl_file,
                            'gekkon');
        if(($binTpl = $this->binTplProvider->load($template)) !== false)
                $this->cacheProvider->clear_cache($binTpl, $id);

        //$this->binTplProvider->clear_cache($template); // clear_bin_cache?
    }

    function get_group() {
        return $this->tplGroup->group;
    }

    function get_scope($data = false)
    {
        if($data !== false && $data !== $this->data)
        {
            $scope = new \ArrayObject($data);
            $scope['global'] = $this->data;
            return $scope;
        }
        return $this->data;
    }

    function compile($template)
    {
        if(!$this->compiler)
        {
            $this->compiler = new Compiler\Compiler($this);
        }
        $this->binTplProvider->save($template,
                $this->compiler->compile($template));
        return $this->binTplProvider->load($template);
    }

    function error($msg, $object = false)
    {
        $message = 'Gekkon:';
        if($object !== false) $message .= ' ['.$object.']';
        $message .= ' '.nl2br($msg."\n");

        if($this->settings['display_errors'])
                echo '<div class="gekkon_error">'.$message.'</div>';

        error_log(trim(strip_tags($message)));
        return false;
    }

    function settingsSetAll($value)
    {
        $this->settings = $value;
    }

    function settingsSet($name, $value)
    {
        $this->settings[$name] = $value;
    }

    function addTagSystem($name, $open, $close)
    {
        $this->settings['tag_systems'][$name] = array(
            'open' => $open,
            'close' => $close,
        );
    }

    function removeTagSystem($name)
    {
        unset($this->settings['tag_systems'][$name]);
    }

    static function clear_dir($path)
    {
        $path = rtrim($path, '/').'/';
        if(is_dir($path))
        {
            foreach(scandir($path) as $file)
            {
                if($file[0] != '.')
                {
                    if(is_dir($path.$file)) Gekkon::clear_dir($path.$file.'/');
                    else unlink($path.$file);
                }
            }
        }
    }

    static function create_dir($path)
    {
        $path = rtrim($path, '/');
        if(!is_dir($path))
        {
            Gekkon::create_dir(dirname($path));
            mkdir($path);
        }
    }

}
