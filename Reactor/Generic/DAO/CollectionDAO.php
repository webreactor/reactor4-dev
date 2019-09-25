<?php

namespace Reactor\Generic\DAO;

use Reactor\Database\Interfaces\ConnectionInterface;
use Reactor\Database\Interfaces\QueryInterface;

class CollectionDAO {

    protected $connection;

    public function __construct($connection, $table, $key, $fkeys = array()) {
        $this->connection = $connection;
        $this->table = $table;
        $this->key = $key;
        $this->fkeys = $fkeys;
    }

    public function add($data) {
        return $this->connection->insert($this->table, array_merge($this->fkeys, $data));
    }

    public function delete($key) {
        return $this->connection->delete($this->table, array_merge($this->fkeys, array($this->key => $key)));
    }

    public function replace($key, $data) {
        return $this->connection->replace($this->table, array_merge($this->fkeys, array($this->key => $key), $data));
    }

    public function update($key, $data) {
        return $this->connection->update($this->table, $data, array_merge($this->fkeys, array($this->key => $key)));
    }

    public function get($key) {
        return $this->connection->select($this->table, array_merge($this->fkeys, array($this->key => $key)))->line();
    }

    public function getAll($keys = array()) {
        $cond = array_merge($this->fkeys, $keys);
        return $this->connection->select($this->table, $cond)->matr($this->key);
    }

    public function getPage($page, $per_page, $keys = array()) {
        //$cond = array_merge($this->fkeys, $keys)
        //return $this->connection->sql('select from `'.$this->table.'` where '., $cond)->line();
    }

}
