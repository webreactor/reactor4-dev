Reactor\Database\PDO\Connection
===============






* Class name: Connection
* Namespace: Reactor\Database\PDO
* This class implements: [Reactor\Database\Interfaces\ConnectionInterface](Reactor-Database-Interfaces-ConnectionInterface.md)




Properties
----------


### $connection

    protected mixed $connection = null





* Visibility: **protected**


### $connection_string

    protected mixed $connection_string





* Visibility: **protected**


### $user

    protected mixed $user





* Visibility: **protected**


### $pass

    protected mixed $pass





* Visibility: **protected**


Methods
-------


### __construct

    mixed Reactor\Database\PDO\Connection::__construct($connection_string, $user, $pass)





* Visibility: **public**


#### Arguments
* $connection_string **mixed**
* $user **mixed**
* $pass **mixed**



### getConnection

    mixed Reactor\Database\PDO\Connection::getConnection()





* Visibility: **protected**




### sql

    mixed Reactor\Database\Interfaces\ConnectionInterface::sql($query)





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\ConnectionInterface](Reactor-Database-Interfaces-ConnectionInterface.md)


#### Arguments
* $query **mixed**



### lastId

    mixed Reactor\Database\Interfaces\ConnectionInterface::lastId($name)





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\ConnectionInterface](Reactor-Database-Interfaces-ConnectionInterface.md)


#### Arguments
* $name **mixed**



### wrapWrere

    mixed Reactor\Database\PDO\Connection::wrapWrere($where)





* Visibility: **protected**


#### Arguments
* $where **mixed**



### select

    mixed Reactor\Database\PDO\Connection::select($table, $where_data, $where)





* Visibility: **public**


#### Arguments
* $table **mixed**
* $where_data **mixed**
* $where **mixed**



### insert

    mixed Reactor\Database\Interfaces\ConnectionInterface::insert($table, $data)





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\ConnectionInterface](Reactor-Database-Interfaces-ConnectionInterface.md)


#### Arguments
* $table **mixed**
* $data **mixed**



### replace

    mixed Reactor\Database\Interfaces\ConnectionInterface::replace($table, $data)





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\ConnectionInterface](Reactor-Database-Interfaces-ConnectionInterface.md)


#### Arguments
* $table **mixed**
* $data **mixed**



### buildPairs

    mixed Reactor\Database\PDO\Connection::buildPairs($keys, $delimeter)





* Visibility: **public**


#### Arguments
* $keys **mixed**
* $delimeter **mixed**



### update

    mixed Reactor\Database\Interfaces\ConnectionInterface::update($table, $data, $where_data, $where)





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\ConnectionInterface](Reactor-Database-Interfaces-ConnectionInterface.md)


#### Arguments
* $table **mixed**
* $data **mixed**
* $where_data **mixed**
* $where **mixed**



### delete

    mixed Reactor\Database\PDO\Connection::delete($table, $where_data, $where)





* Visibility: **public**


#### Arguments
* $table **mixed**
* $where_data **mixed**
* $where **mixed**



### pages

    mixed Reactor\Database\Interfaces\ConnectionInterface::pages($query, $parameters, $page, $per_page, $total_rows)





* Visibility: **public**
* This method is defined by [Reactor\Database\Interfaces\ConnectionInterface](Reactor-Database-Interfaces-ConnectionInterface.md)


#### Arguments
* $query **mixed**
* $parameters **mixed**
* $page **mixed**
* $per_page **mixed**
* $total_rows **mixed**


