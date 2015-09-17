Reactor\Gekkon\Compiler\Compiler
===============






* Class name: Compiler
* Namespace: Reactor\Gekkon\Compiler







Methods
-------


### __construct

    mixed Reactor\Gekkon\Compiler\Compiler::__construct($gekkon)





* Visibility: **public**


#### Arguments
* $gekkon **mixed**



### init

    mixed Reactor\Gekkon\Compiler\Compiler::init()





* Visibility: **public**




### compile

    mixed Reactor\Gekkon\Compiler\Compiler::compile($template)





* Visibility: **public**


#### Arguments
* $template **mixed**



### compile_one

    mixed Reactor\Gekkon\Compiler\Compiler::compile_one($template)





* Visibility: **public**


#### Arguments
* $template **mixed**



### compile_str

    mixed Reactor\Gekkon\Compiler\Compiler::compile_str($_str, $parent)





* Visibility: **public**


#### Arguments
* $_str **mixed**
* $parent **mixed**



### compile_parsed_str

    mixed Reactor\Gekkon\Compiler\Compiler::compile_parsed_str($data)





* Visibility: **public**


#### Arguments
* $data **mixed**



### parse_str

    mixed Reactor\Gekkon\Compiler\Compiler::parse_str($_str, $_parent)





* Visibility: **public**


#### Arguments
* $_str **mixed**
* $_parent **mixed**



### find_tag

    mixed Reactor\Gekkon\Compiler\Compiler::find_tag($_str)





* Visibility: **public**


#### Arguments
* $_str **mixed**



### parse_tag

    mixed Reactor\Gekkon\Compiler\Compiler::parse_tag($_tag, $_str)





* Visibility: **public**


#### Arguments
* $_tag **mixed**
* $_str **mixed**



### error_in_tag

    mixed Reactor\Gekkon\Compiler\Compiler::error_in_tag($msg, $_tag)





* Visibility: **public**


#### Arguments
* $msg **mixed**
* $_tag **mixed**



### error

    mixed Reactor\Gekkon\Compiler\Compiler::error($msg, $object, $line)





* Visibility: **public**


#### Arguments
* $msg **mixed**
* $object **mixed**
* $line **mixed**



### flush_errors

    mixed Reactor\Gekkon\Compiler\Compiler::flush_errors()





* Visibility: **public**




### getUID

    mixed Reactor\Gekkon\Compiler\Compiler::getUID()





* Visibility: **public**




### split_parsed_str

    mixed Reactor\Gekkon\Compiler\Compiler::split_parsed_str($data, $tag_name, $keep_spliter)





* Visibility: **public**


#### Arguments
* $data **mixed**
* $tag_name **mixed**
* $keep_spliter **mixed**



### compileOutput

    mixed Reactor\Gekkon\Compiler\Compiler::compileOutput($data, $just_code)





* Visibility: **public**


#### Arguments
* $data **mixed**
* $just_code **mixed**


