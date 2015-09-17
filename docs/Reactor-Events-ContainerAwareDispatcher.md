Reactor\Events\ContainerAwareDispatcher
===============






* Class name: ContainerAwareDispatcher
* Namespace: Reactor\Events
* Parent class: [Reactor\Events\Dispatcher](Reactor-Events-Dispatcher.md)





Properties
----------


### $container

    protected mixed $container





* Visibility: **protected**


### $resolver

    protected mixed $resolver





* Visibility: **protected**


### $wildcard

    protected mixed $wildcard = '#'





* Visibility: **protected**


### $wordcard

    protected mixed $wordcard = '\*'





* Visibility: **protected**


### $divider

    protected mixed $divider = '\.'





* Visibility: **protected**


### $listeners

    protected mixed $listeners = array()





* Visibility: **protected**


### $cache

    protected mixed $cache = array()





* Visibility: **protected**


Methods
-------


### setContainer

    mixed Reactor\Events\ContainerAwareDispatcher::setContainer($container)





* Visibility: **public**


#### Arguments
* $container **mixed**



### runCallback

    mixed Reactor\Events\Dispatcher::runCallback($callable, \Reactor\Events\Event $event)





* Visibility: **protected**
* This method is defined by [Reactor\Events\Dispatcher](Reactor-Events-Dispatcher.md)


#### Arguments
* $callable **mixed**
* $event **[Reactor\Events\Event](Reactor-Events-Event.md)**



### addSubscriberService

    mixed Reactor\Events\ContainerAwareDispatcher::addSubscriberService($reference)





* Visibility: **public**


#### Arguments
* $reference **mixed**



### setTokens

    mixed Reactor\Events\Dispatcher::setTokens($wildcard, $wordcard, $divider)





* Visibility: **public**
* This method is defined by [Reactor\Events\Dispatcher](Reactor-Events-Dispatcher.md)


#### Arguments
* $wildcard **mixed**
* $wordcard **mixed**
* $divider **mixed**



### addListener

    mixed Reactor\Events\Dispatcher::addListener($event_name, $callable)





* Visibility: **public**
* This method is defined by [Reactor\Events\Dispatcher](Reactor-Events-Dispatcher.md)


#### Arguments
* $event_name **mixed**
* $callable **mixed**



### resetCache

    mixed Reactor\Events\Dispatcher::resetCache()





* Visibility: **public**
* This method is defined by [Reactor\Events\Dispatcher](Reactor-Events-Dispatcher.md)




### addSubscriber

    mixed Reactor\Events\Dispatcher::addSubscriber(\Reactor\Events\SubscriberInterface $subscriber)





* Visibility: **public**
* This method is defined by [Reactor\Events\Dispatcher](Reactor-Events-Dispatcher.md)


#### Arguments
* $subscriber **[Reactor\Events\SubscriberInterface](Reactor-Events-SubscriberInterface.md)**



### raise

    mixed Reactor\Events\Dispatcher::raise($name, $data)





* Visibility: **public**
* This method is defined by [Reactor\Events\Dispatcher](Reactor-Events-Dispatcher.md)


#### Arguments
* $name **mixed**
* $data **mixed**



### dispatch

    mixed Reactor\Events\Dispatcher::dispatch(\Reactor\Events\Event $event)





* Visibility: **public**
* This method is defined by [Reactor\Events\Dispatcher](Reactor-Events-Dispatcher.md)


#### Arguments
* $event **[Reactor\Events\Event](Reactor-Events-Event.md)**



### getListeners

    mixed Reactor\Events\Dispatcher::getListeners($event_name)





* Visibility: **public**
* This method is defined by [Reactor\Events\Dispatcher](Reactor-Events-Dispatcher.md)


#### Arguments
* $event_name **mixed**



### getPregMask

    mixed Reactor\Events\Dispatcher::getPregMask($event_mask)





* Visibility: **protected**
* This method is defined by [Reactor\Events\Dispatcher](Reactor-Events-Dispatcher.md)


#### Arguments
* $event_mask **mixed**



### getSuperEventNames

    mixed Reactor\Events\Dispatcher::getSuperEventNames($event_name)





* Visibility: **protected**
* This method is defined by [Reactor\Events\Dispatcher](Reactor-Events-Dispatcher.md)


#### Arguments
* $event_name **mixed**


