Reactor\Database\Interfaces\ConnectionInterface
===============






* Interface name: ConnectionInterface
* Namespace: Reactor\Database\Interfaces
* This is an **interface**






Methods
-------


### sql

    mixed Reactor\Database\Interfaces\ConnectionInterface::sql($query)





* Visibility: **public**


#### Arguments
* $query **mixed**



### lastId

    mixed Reactor\Database\Interfaces\ConnectionInterface::lastId($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### insert

    mixed Reactor\Database\Interfaces\ConnectionInterface::insert($table, $data)





* Visibility: **public**


#### Arguments
* $table **mixed**
* $data **mixed**



### replace

    mixed Reactor\Database\Interfaces\ConnectionInterface::replace($table, $data)





* Visibility: **public**


#### Arguments
* $table **mixed**
* $data **mixed**



### update

    mixed Reactor\Database\Interfaces\ConnectionInterface::update($table, $data, $where_data, $where)





* Visibility: **public**


#### Arguments
* $table **mixed**
* $data **mixed**
* $where_data **mixed**
* $where **mixed**



### pages

    mixed Reactor\Database\Interfaces\ConnectionInterface::pages($query, $parameters, $page, $per_page, $total_rows)





* Visibility: **public**


#### Arguments
* $query **mixed**
* $parameters **mixed**
* $page **mixed**
* $per_page **mixed**
* $total_rows **mixed**


