Reactor\ServiceContainer\ServiceProvider
===============






* Class name: ServiceProvider
* Namespace: Reactor\ServiceContainer
* This class implements: [Reactor\ServiceContainer\ServiceProviderInterface](Reactor-ServiceContainer-ServiceProviderInterface.md)




Properties
----------


### $scenario

    protected mixed $scenario = array()





* Visibility: **protected**


### $shared

    protected mixed $shared = false





* Visibility: **protected**


### $instance

    protected mixed $instance = null





* Visibility: **protected**


Methods
-------


### __construct

    mixed Reactor\ServiceContainer\ServiceProvider::__construct($igniter, $arguments)





* Visibility: **public**


#### Arguments
* $igniter **mixed**
* $arguments **mixed**



### shared

    mixed Reactor\ServiceContainer\ServiceProvider::shared($flag)





* Visibility: **public**


#### Arguments
* $flag **mixed**



### isShared

    mixed Reactor\ServiceContainer\ServiceProvider::isShared()





* Visibility: **public**




### createScenario

    mixed Reactor\ServiceContainer\ServiceProvider::createScenario($igniter, $arguments)





* Visibility: **public**


#### Arguments
* $igniter **mixed**
* $arguments **mixed**



### addFactory

    mixed Reactor\ServiceContainer\ServiceProvider::addFactory($factory, $arguments)





* Visibility: **public**


#### Arguments
* $factory **mixed**
* $arguments **mixed**



### addCall

    mixed Reactor\ServiceContainer\ServiceProvider::addCall($method_name, $arguments)





* Visibility: **public**


#### Arguments
* $method_name **mixed**
* $arguments **mixed**



### addConfigurator

    mixed Reactor\ServiceContainer\ServiceProvider::addConfigurator($configurator, $arguments)





* Visibility: **public**


#### Arguments
* $configurator **mixed**
* $arguments **mixed**



### getService

    mixed Reactor\ServiceContainer\ServiceProviderInterface::getService($container)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ServiceProviderInterface](Reactor-ServiceContainer-ServiceProviderInterface.md)


#### Arguments
* $container **mixed**



### createInstance

    mixed Reactor\ServiceContainer\ServiceProvider::createInstance($container)





* Visibility: **public**


#### Arguments
* $container **mixed**



### resolveProviders

    mixed Reactor\ServiceContainer\ServiceProvider::resolveProviders($data, $container)





* Visibility: **public**


#### Arguments
* $data **mixed**
* $container **mixed**



### step_create

    mixed Reactor\ServiceContainer\ServiceProvider::step_create($instance, $igniter, $arguments)





* Visibility: **protected**


#### Arguments
* $instance **mixed**
* $igniter **mixed**
* $arguments **mixed**



### step_factory

    mixed Reactor\ServiceContainer\ServiceProvider::step_factory($instance, $igniter, $arguments)





* Visibility: **protected**


#### Arguments
* $instance **mixed**
* $igniter **mixed**
* $arguments **mixed**



### step_call

    mixed Reactor\ServiceContainer\ServiceProvider::step_call($instance, $igniter, $arguments)





* Visibility: **protected**


#### Arguments
* $instance **mixed**
* $igniter **mixed**
* $arguments **mixed**



### step_configurator

    mixed Reactor\ServiceContainer\ServiceProvider::step_configurator($instance, $igniter, $arguments)





* Visibility: **protected**


#### Arguments
* $instance **mixed**
* $igniter **mixed**
* $arguments **mixed**



### reset

    mixed Reactor\ServiceContainer\ServiceProviderInterface::reset()





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ServiceProviderInterface](Reactor-ServiceContainer-ServiceProviderInterface.md)



