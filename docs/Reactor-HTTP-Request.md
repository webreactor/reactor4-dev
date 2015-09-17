Reactor\HTTP\Request
===============






* Class name: Request
* Namespace: Reactor\HTTP





Properties
----------


### $uri

    protected mixed $uri





* Visibility: **protected**


### $method

    protected mixed $method





* Visibility: **protected**


### $host

    protected mixed $host





* Visibility: **protected**


### $post

    protected mixed $post





* Visibility: **protected**


### $get

    protected mixed $get





* Visibility: **protected**


### $body

    protected mixed $body





* Visibility: **protected**


### $headers

    protected mixed $headers





* Visibility: **protected**


### $files

    protected mixed $files





* Visibility: **protected**


### $cookies

    protected mixed $cookies





* Visibility: **protected**


Methods
-------


### __construct

    mixed Reactor\HTTP\Request::__construct($get, $post, $cookies, $files, $server, $content)





* Visibility: **public**


#### Arguments
* $get **mixed**
* $post **mixed**
* $cookies **mixed**
* $files **mixed**
* $server **mixed**
* $content **mixed**



### set

    mixed Reactor\HTTP\Request::set($name, $value)





* Visibility: **public**


#### Arguments
* $name **mixed**
* $value **mixed**



### get

    mixed Reactor\HTTP\Request::get($name, $default)





* Visibility: **public**


#### Arguments
* $name **mixed**
* $default **mixed**



### getInteger

    mixed Reactor\HTTP\Request::getInteger($name, $default)





* Visibility: **public**


#### Arguments
* $name **mixed**
* $default **mixed**



### getNumber

    mixed Reactor\HTTP\Request::getNumber($name, $default)





* Visibility: **public**


#### Arguments
* $name **mixed**
* $default **mixed**



### getAll

    mixed Reactor\HTTP\Request::getAll()





* Visibility: **public**



