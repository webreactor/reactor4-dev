Reactor\Events\Dispatcher
===============






* Class name: Dispatcher
* Namespace: Reactor\Events





Properties
----------


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


### setTokens

    mixed Reactor\Events\Dispatcher::setTokens($wildcard, $wordcard, $divider)





* Visibility: **public**


#### Arguments
* $wildcard **mixed**
* $wordcard **mixed**
* $divider **mixed**



### addListener

    mixed Reactor\Events\Dispatcher::addListener($event_name, $callable)





* Visibility: **public**


#### Arguments
* $event_name **mixed**
* $callable **mixed**



### resetCache

    mixed Reactor\Events\Dispatcher::resetCache()





* Visibility: **public**




### addSubscriber

    mixed Reactor\Events\Dispatcher::addSubscriber(\Reactor\Events\SubscriberInterface $subscriber)





* Visibility: **public**


#### Arguments
* $subscriber **[Reactor\Events\SubscriberInterface](Reactor-Events-SubscriberInterface.md)**



### raise

    mixed Reactor\Events\Dispatcher::raise($name, $data)





* Visibility: **public**


#### Arguments
* $name **mixed**
* $data **mixed**



### dispatch

    mixed Reactor\Events\Dispatcher::dispatch(\Reactor\Events\Event $event)





* Visibility: **public**


#### Arguments
* $event **[Reactor\Events\Event](Reactor-Events-Event.md)**



### runCallback

    mixed Reactor\Events\Dispatcher::runCallback($callable, \Reactor\Events\Event $event)





* Visibility: **protected**


#### Arguments
* $callable **mixed**
* $event **[Reactor\Events\Event](Reactor-Events-Event.md)**



### getListeners

    mixed Reactor\Events\Dispatcher::getListeners($event_name)





* Visibility: **public**


#### Arguments
* $event_name **mixed**



### getPregMask

    mixed Reactor\Events\Dispatcher::getPregMask($event_mask)





* Visibility: **protected**


#### Arguments
* $event_mask **mixed**



### getSuperEventNames

    mixed Reactor\Events\Dispatcher::getSuperEventNames($event_name)





* Visibility: **protected**


#### Arguments
* $event_name **mixed**


