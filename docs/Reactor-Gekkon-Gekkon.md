Reactor\Gekkon\Gekkon
===============






* Class name: Gekkon
* Namespace: Reactor\Gekkon





Properties
----------


### $version

    public mixed $version = '4.3'





* Visibility: **public**


### $gekkon_path

    public mixed $gekkon_path





* Visibility: **public**


### $compiler

    public mixed $compiler





* Visibility: **public**


### $settings

    public mixed $settings





* Visibility: **public**


### $data

    public mixed $data





* Visibility: **public**


### $tplProvider

    public mixed $tplProvider





* Visibility: **public**


### $binTplProvider

    public mixed $binTplProvider





* Visibility: **public**


### $cacheProvider

    public mixed $cacheProvider





* Visibility: **public**


Methods
-------


### __construct

    mixed Reactor\Gekkon\Gekkon::__construct($tpl_path, $bin_path)





* Visibility: **public**


#### Arguments
* $tpl_path **mixed**
* $bin_path **mixed**



### assign

    mixed Reactor\Gekkon\Gekkon::assign($name, $data)





* Visibility: **public**


#### Arguments
* $name **mixed**
* $data **mixed**



### register

    mixed Reactor\Gekkon\Gekkon::register($name, $data)





* Visibility: **public**


#### Arguments
* $name **mixed**
* $data **mixed**



### push_module

    mixed Reactor\Gekkon\Gekkon::push_module($module)





* Visibility: **public**


#### Arguments
* $module **mixed**



### pop_module

    mixed Reactor\Gekkon\Gekkon::pop_module()





* Visibility: **public**




### display

    mixed Reactor\Gekkon\Gekkon::display($tpl_name, $scope_data, $module)





* Visibility: **public**


#### Arguments
* $tpl_name **mixed**
* $scope_data **mixed**
* $module **mixed**



### get_display

    mixed Reactor\Gekkon\Gekkon::get_display($tpl_name, $scope_data)





* Visibility: **public**


#### Arguments
* $tpl_name **mixed**
* $scope_data **mixed**



### template

    mixed Reactor\Gekkon\Gekkon::template($tpl_name)





* Visibility: **public**


#### Arguments
* $tpl_name **mixed**



### clear_cache

    mixed Reactor\Gekkon\Gekkon::clear_cache($tpl_name, $id)





* Visibility: **public**


#### Arguments
* $tpl_name **mixed**
* $id **mixed**



### get_scope

    mixed Reactor\Gekkon\Gekkon::get_scope($data)





* Visibility: **public**


#### Arguments
* $data **mixed**



### compile

    mixed Reactor\Gekkon\Gekkon::compile($template)





* Visibility: **public**


#### Arguments
* $template **mixed**



### error

    mixed Reactor\Gekkon\Gekkon::error($msg, $object)





* Visibility: **public**


#### Arguments
* $msg **mixed**
* $object **mixed**



### settings_set_all

    mixed Reactor\Gekkon\Gekkon::settings_set_all($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### settings_set

    mixed Reactor\Gekkon\Gekkon::settings_set($name, $value)





* Visibility: **public**


#### Arguments
* $name **mixed**
* $value **mixed**



### set_property

    mixed Reactor\Gekkon\Gekkon::set_property($name, $value)





* Visibility: **public**


#### Arguments
* $name **mixed**
* $value **mixed**



### get_property

    mixed Reactor\Gekkon\Gekkon::get_property($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### add_tag_system

    mixed Reactor\Gekkon\Gekkon::add_tag_system($name, $open, $close)





* Visibility: **public**


#### Arguments
* $name **mixed**
* $open **mixed**
* $close **mixed**



### remove_tag_system

    mixed Reactor\Gekkon\Gekkon::remove_tag_system($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### clear_dir

    mixed Reactor\Gekkon\Gekkon::clear_dir($path)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $path **mixed**



### create_dir

    mixed Reactor\Gekkon\Gekkon::create_dir($path)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $path **mixed**


