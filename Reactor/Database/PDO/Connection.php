<?php

namespace Reactor\Database\PDO;

use Reactor\Database\Exceptions as Exceptions;
use Reactor\Database\Interfaces\ConnectionInterface;

/**
 * Class Connection
 *
 * @package Reactor\Database\PDO
 */
class Connection implements ConnectionInterface
{
    protected $connection = null;
    protected $connection_string;
    protected $user;
    protected $pass;
    
    /**
     * Connection constructor.
     *
     * @param string $connection_string
     * @param string $user
     * @param string $pass
     */
    public function __construct($connection_string, $user = null, $pass = null)
    {
        $this->connection_string = $connection_string;
        $this->user              = $user;
        $this->pass              = $pass;
    }
    
    /**
     * @return null|\PDO
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    protected function getConnection()
    {
        if ($this->connection === null) {
            try {
                $this->connection = new \PDO($this->connection_string, $this->user, $this->pass);
                $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $exception) {
                throw new Exceptions\DatabaseException($exception->getMessage(), $this);
            }
        }
        
        return $this->connection;
    }
    
    /**
     * @param       $func
     * @param array $param
     *
     * @return bool
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function transaction($func, $param = array())
    {
        if (!is_callable($func) || !is_array($param)) {
            return false;
        }
        
        try {
            $this->beginTransaction();
            
            call_user_func_array($func, $param);
            
            return $this->commit();
        } catch (\Exception $exception) {
            $this->rollBack();
            
            throw new Exceptions\DatabaseException('Transaction failed - ' . $exception->getMessage(), $this);
        }
    }
    
    /**
     * @return bool
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function beginTransaction()
    {
        try {
            return $this->getConnection()->beginTransaction();
        } catch (\Exception $exception) {
            throw new Exceptions\DatabaseException($exception->getMessage(), $this);
        }
    }
    
    /**
     * @return bool
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function commit()
    {
        try {
            return $this->getConnection()->commit();
        } catch (\Exception $exception) {
            throw new Exceptions\DatabaseException($exception->getMessage(), $this);
        }
    }
    
    /**
     * @return bool
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function rollBack()
    {
        try {
            return $this->getConnection()->rollBack();
        } catch (\Exception $exception) {
            throw new Exceptions\DatabaseException($exception->getMessage(), $this);
        }
    }
    
    /**
     * @inheritdoc
     *
     * @param array $arguments
     *
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function sql($query, $arguments = array())
    {
        if (!empty($GLOBALS['debug'])) {
            echo "\n$query " . json_encode($arguments) . "<br>";
        }
        $statement = $this->getConnection()->prepare($query);
        if (!$statement) {
            throw new Exceptions\DatabaseException($this->getConnection()->errorInfo()[2], $this);
        }
        $query = new Query($statement);
        if ($arguments === null) {
            return $query;
        }
        
        return $query->exec($arguments);
    }
    
    /**
     * @inheritdoc
     *
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function lastId($name = null)
    {
        return $this->getConnection()->lastInsertId($name);
    }
    
    /**
     * @param $where
     *
     * @return string
     */
    public function wrapWhere($where)
    {
        if (trim($where) == '') {
            return ' ';
        }
        
        return ' where ' . $where;
    }
    
    /**
     * @param        $table
     * @param array  $where_data
     * @param string $where
     *
     * @return \Reactor\Database\PDO\Connection|\Reactor\Database\PDO\Query
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function select($table, $where_data = array(), $where = '')
    {
        if ($where === '') {
            $where = $this->buildPairs(array_keys($where_data), 'and');
        }
        
        return $this->sql(
            'select * from `' . $table . '`'
            . $this->wrapWhere($where),
            $where_data
        );
    }
    
    /**
     * @inheritdoc
     *
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function insert($table, array $data)
    {
        $keys = array_keys($data);
        $this->sql(
            'insert into `' . $table . '`
            (`' . implode('`, `', $keys) . '`)
            values (:' . implode(', :', $keys) . ')',
            $data
        );
        
        return $this->lastId();
    }
    
    /**
     * @inheritdoc
     *
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function replace($table, array $data)
    {
        $keys = array_keys($data);
        $this->sql(
            'replace into `' . $table . '`
            (`' . implode('`, `', $keys) . '`)
            values (:' . implode(', :', $keys) . ')',
            $data
        );
        
        return $this->lastId();
    }
    
    public function prefixArrayKeys($data, $prefix) {
        $rez = array();
        foreach ($data as $key => $value) {
            $rez[$prefix.$key] = $value;
        }
        return $rez;
    }

    /**
     * @param        $keys
     * @param string $delimeter
     *
     * @return string
     */
    public function buildPairs($keys, $delimeter = ',')
    {
        $pairs = array();
        foreach ($keys as $k) {
            $pairs[] = '`' . $k . '`= :' . $k;
        }
        
        return implode(' ' . $delimeter . ' ', $pairs);
    }
    
    /**
     * @inheritdoc
     *
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function update($table, array $data, array $where_data = array(), $where = '')
    {
        $where_data = $this->prefixArrayKeys($where_data, 'where_');
        $data = $this->prefixArrayKeys($data, 'data_');
        if ($where === '') {
            $where = $this->buildPairs(array_keys($where_data), 'and');
        }
        $query = $this->sql(
            'update `' . $table . '` set '
            . $this->buildPairs(array_keys($data))
            . $this->wrapWhere($where),
            array_merge($data, $where_data)
        );
        
        return $query->count();
    }
    
    /**
     * @param        $table
     * @param array  $where_data
     * @param string $where
     *
     * @return int
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function delete($table, $where_data = array(), $where = '')
    {
        if ($where === '') {
            $where = $this->buildPairs(array_keys($where_data), 'and');
        }
        $query = $this->sql(
            'delete from `' . $table . '` '
            . $this->wrapWhere($where),
            $where_data
        );
        
        return $query->count();
    }
    
    /**
     * @inheritdoc
     *
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function pages($query, array $parameters, $page, $per_page, $total_rows = null)
    {
        $per_page = (int) $per_page;
        $page     = (int) $page;
        
        if ($page == 0) {
            $data = $this->sql($query, $parameters)->matr();
        } else {
            
            $from = ($page - 1) * $per_page;
            $data = $this->sql($query . ' limit ' . $from . ', ' . $per_page, $parameters)->matr();
        }

        if ($total_rows === null) {
            $cnt_query = stristr($query, 'from');
            
            $t = strripos($cnt_query, 'order by');
            if ($t !== false) {
                $cnt_query = substr($cnt_query, 0, $t);
            }
            
            $total_rows = $this->sql('SELECT count(*) as `count` ' . $cnt_query, $parameters)->line('count');
        }
        
        $total_pages = ceil($total_rows / $per_page);
        
        return array(
            'data'        => $data,
            'total_rows'  => $total_rows,
            'total_pages' => $total_pages,
            'page'        => $page,
            'per_page'    => $per_page,
        );
    }
}
