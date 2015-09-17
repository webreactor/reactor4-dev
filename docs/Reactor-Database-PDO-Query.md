Reactor\Database\PDO\Query
===============






* Class name: Query
* Namespace: Reactor\Database\PDO
* This class implements: [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)




Properties
----------


### $stats

    protected mixed $stats = array()





* Visibility: **protected**


### $statement

    protected mixed $statement





* Visibility: **protected**


### $line

    protected mixed $line = null





* Visibility: **protected**


### $iterator_key

    protected mixed $iterator_key





* Visibility: **protected**


Methods
-------


### __construct

    mixed Reactor\Database\PDO\Query::__construct($statement)





* Visibility: **public**


#### Arguments
* $statement **mixed**



### exec

    mixed Reactor\Database\Interfaces\QueryInterface::exec($parameters)





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)


#### Arguments
* $parameters **mixed**



### __destruct

    mixed Reactor\Database\PDO\Query::__destruct()





* Visibility: **public**




### line

    mixed Reactor\Database\Interfaces\QueryInterface::line($row)





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)


#### Arguments
* $row **mixed**



### free

    mixed Reactor\Database\Interfaces\QueryInterface::free()





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)




### matr

    mixed Reactor\Database\Interfaces\QueryInterface::matr($key, $row)





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)


#### Arguments
* $key **mixed**
* $row **mixed**



### count

    mixed Reactor\Database\Interfaces\QueryInterface::count()





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)




### getStats

    mixed Reactor\Database\Interfaces\QueryInterface::getStats()





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)




### getStatement

    mixed Reactor\Database\PDO\Query::getStatement()





* Visibility: **public**




### current

    mixed Reactor\Database\Interfaces\QueryInterface::current()





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)




### key

    mixed Reactor\Database\Interfaces\QueryInterface::key()





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)




### next

    mixed Reactor\Database\Interfaces\QueryInterface::next()





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)




### rewind

    mixed Reactor\Database\Interfaces\QueryInterface::rewind()





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)




### valid

    mixed Reactor\Database\Interfaces\QueryInterface::valid()





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\QueryInterface](Reactor-Database-Interfaces-QueryInterface.md)



