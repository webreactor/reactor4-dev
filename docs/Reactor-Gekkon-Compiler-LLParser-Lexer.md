Reactor\Gekkon\Compiler\LLParser\Lexer
===============






* Class name: Lexer
* Namespace: Reactor\Gekkon\Compiler\LLParser





Properties
----------


### $str

    public mixed $str





* Visibility: **public**


### $length

    public mixed $length





* Visibility: **public**


### $rez

    public mixed $rez





* Visibility: **public**


### $current

    public mixed $current





* Visibility: **public**


### $error

    public mixed $error





* Visibility: **public**


### $step

    public mixed $step





* Visibility: **public**


Methods
-------


### parse_expression

    mixed Reactor\Gekkon\Compiler\LLParser\Lexer::parse_expression($str)





* Visibility: **public**


#### Arguments
* $str **mixed**



### init

    mixed Reactor\Gekkon\Compiler\LLParser\Lexer::init($str)





* Visibility: **public**


#### Arguments
* $str **mixed**



### find_variable_end

    mixed Reactor\Gekkon\Compiler\LLParser\Lexer::find_variable_end($start)





* Visibility: **public**


#### Arguments
* $start **mixed**



### save

    mixed Reactor\Gekkon\Compiler\LLParser\Lexer::save($buffer, $type)





* Visibility: **public**


#### Arguments
* $buffer **mixed**
* $type **mixed**



### find_close

    mixed Reactor\Gekkon\Compiler\LLParser\Lexer::find_close($start, $opener, $closer, $alt)





* Visibility: **public**


#### Arguments
* $start **mixed**
* $opener **mixed**
* $closer **mixed**
* $alt **mixed**



### parse_variable

    mixed Reactor\Gekkon\Compiler\LLParser\Lexer::parse_variable($str)





* Visibility: **public**


#### Arguments
* $str **mixed**


