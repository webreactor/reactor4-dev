Reactor\Database\Module
===============






* Class name: Module
* Namespace: Reactor\Database
* Parent class: [Reactor\Application\Module](Reactor-Application-Module.md)





Properties
----------


### $dir

    protected mixed $dir = null





* Visibility: **protected**


### $name

    protected mixed $name





* Visibility: **protected**


### $path

    protected mixed $path





* Visibility: **protected**


### $data

    protected mixed $data = array()





* Visibility: **protected**


### $parent

    protected mixed $parent = null





* Visibility: **protected**


Methods
-------


### init

    mixed Reactor\Application\Module::init()





* Visibility: **protected**
* This method is defined by [Reactor\Application\Module](Reactor-Application-Module.md)




### __construct

    mixed Reactor\Application\Module::__construct($name, $container, $data)





* Visibility: **public**
* This method is defined by [Reactor\Application\Module](Reactor-Application-Module.md)


#### Arguments
* $name **mixed**
* $container **mixed**
* $data **mixed**



### getModulePath

    mixed Reactor\Application\Module::getModulePath()





* Visibility: **public**
* This method is defined by [Reactor\Application\Module](Reactor-Application-Module.md)




### loadModule

    mixed Reactor\Application\Module::loadModule($name, $module_class)





* Visibility: **public**
* This method is defined by [Reactor\Application\Module](Reactor-Application-Module.md)


#### Arguments
* $name **mixed**
* $module_class **mixed**



### getDir

    mixed Reactor\Application\Module::getDir()





* Visibility: **public**
* This method is defined by [Reactor\Application\Module](Reactor-Application-Module.md)




### getName

    mixed Reactor\Application\Module::getName()





* Visibility: **public**
* This method is defined by [Reactor\Application\Module](Reactor-Application-Module.md)




### createService

    mixed Reactor\ServiceContainer\ServiceContainer::createService($name, $value, $arguments)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ServiceContainer](Reactor-ServiceContainer-ServiceContainer.md)


#### Arguments
* $name **mixed**
* $value **mixed**
* $arguments **mixed**



### getByPath

    mixed Reactor\ServiceContainer\ServiceContainer::getByPath($path)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ServiceContainer](Reactor-ServiceContainer-ServiceContainer.md)


#### Arguments
* $path **mixed**



### getDirect

    mixed Reactor\ServiceContainer\ValueContainer::getDirect($name)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**



### reset

    mixed Reactor\ServiceContainer\ServiceProviderInterface::reset()





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ServiceProviderInterface](Reactor-ServiceContainer-ServiceProviderInterface.md)




### _reset

    mixed Reactor\ServiceContainer\ServiceContainer::_reset($data)





* Visibility: **protected**
* This method is defined by [Reactor\ServiceContainer\ServiceContainer](Reactor-ServiceContainer-ServiceContainer.md)


#### Arguments
* $data **mixed**



### getService

    mixed Reactor\ServiceContainer\ServiceProviderInterface::getService($container)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ServiceProviderInterface](Reactor-ServiceContainer-ServiceProviderInterface.md)


#### Arguments
* $container **mixed**



### setAll

    mixed Reactor\ServiceContainer\ValueContainer::setAll($data)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $data **mixed**



### setParent

    mixed Reactor\ServiceContainer\ValueContainer::setParent($parent)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $parent **mixed**



### getParent

    mixed Reactor\ServiceContainer\ValueContainer::getParent()





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)




### getKeysDirect

    mixed Reactor\ServiceContainer\ValueContainer::getKeysDirect()





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)




### getRoot

    mixed Reactor\ServiceContainer\ValueContainer::getRoot()





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)




### has

    mixed Reactor\ServiceContainer\ValueContainer::has($name)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**



### set

    mixed Reactor\ServiceContainer\ValueContainer::set($name, $value)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**
* $value **mixed**



### get

    mixed Reactor\ServiceContainer\ValueContainer::get($name)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**



### hasDirect

    mixed Reactor\ServiceContainer\ValueContainer::hasDirect($name)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**



### remove

    mixed Reactor\ServiceContainer\ValueContainer::remove($name)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**



### __get

    mixed Reactor\ServiceContainer\ValueContainer::__get($name)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**



### __set

    mixed Reactor\ServiceContainer\ValueContainer::__set($name, $value)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**
* $value **mixed**



### __isset

    mixed Reactor\ServiceContainer\ValueContainer::__isset($name)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**



### __unset

    mixed Reactor\ServiceContainer\ValueContainer::__unset($name)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**



### offsetExists

    mixed Reactor\ServiceContainer\ValueContainer::offsetExists($name)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**



### offsetGet

    mixed Reactor\ServiceContainer\ValueContainer::offsetGet($name)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**



### offsetSet

    mixed Reactor\ServiceContainer\ValueContainer::offsetSet($name, $value)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**
* $value **mixed**



### offsetUnset

    mixed Reactor\ServiceContainer\ValueContainer::offsetUnset($name)





* Visibility: **public**
* This method is defined by [Reactor\ServiceContainer\ValueContainer](Reactor-ServiceContainer-ValueContainer.md)


#### Arguments
* $name **mixed**


