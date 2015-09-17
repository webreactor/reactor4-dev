Reactor\Gekkon\Compiler\LLParser\LLParser
===============






* Class name: LLParser
* Namespace: Reactor\Gekkon\Compiler\LLParser







Methods
-------


### __construct

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::__construct($_raw_grammar)





* Visibility: **public**


#### Arguments
* $_raw_grammar **mixed**



### fsm_init

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::fsm_init()





* Visibility: **public**




### ff_sets_init

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::ff_sets_init()





* Visibility: **public**




### fsm_fill

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::fsm_fill()





* Visibility: **public**




### grammar_init

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::grammar_init($_raw_grammar)





* Visibility: **public**


#### Arguments
* $_raw_grammar **mixed**



### parse_rule

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::parse_rule($str)





* Visibility: **public**


#### Arguments
* $str **mixed**



### find_close

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::find_close($str, $start, $closer)





* Visibility: **public**


#### Arguments
* $str **mixed**
* $start **mixed**
* $closer **mixed**



### find_first_term

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::find_first_term($left)





* Visibility: **public**


#### Arguments
* $left **mixed**



### find_follow_term

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::find_follow_term($left)





* Visibility: **public**


#### Arguments
* $left **mixed**



### add_left_follows

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::add_left_follows($from, $to)





* Visibility: **public**


#### Arguments
* $from **mixed**
* $to **mixed**



### isTerminal

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::isTerminal($char)





* Visibility: **public**


#### Arguments
* $char **mixed**



### parse

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::parse($_str)





* Visibility: **public**


#### Arguments
* $_str **mixed**



### print_stack

    mixed Reactor\Gekkon\Compiler\LLParser\LLParser::print_stack($stack)





* Visibility: **public**


#### Arguments
* $stack **mixed**


