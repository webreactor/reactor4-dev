<?php

namespace Reactor\Application;

use Reactor\ServiceContainer\ServiceContainerConfigurator;

class ApplicationLoader {

    public $application_class;
    public $config_file;

    public function __construct($application_class, $config_file)  {
        $this->application_class = $application_class; 
        $this->config_file = $config_file;
    }

    public function loadApplication() {
        $application_class = $this->application_class;
        $application = new $application_class();

        $configurator = new ServiceContainerConfigurator($application);
        $file_configurator = new ConfigurationFileLoader($configurator);
        
        $file_configurator->load($this->config_file);
        $application->loadModules();
        return $application;
    }

}
