<?php

namespace Reactor\Generic\Model;

class CollectionModel {

    protected $connection;

    public function __construct($connection, $table, $key, $fkeys = array()) {
        $this->connection = $connection;
        $this->table = $table;
        $this->key = $key;
        $this->fkeys = $fkeys;
    }

    public function add($data) {
        return $this->connection->insert(
            $this->table,
            array_merge($this->fkeys, $data)
        );
    }

    public function delete($key) {
        return $this->connection->delete(
            $this->table,
            array_merge($this->fkeys, array($this->key => $key))
        );
    }

    public function replace($key, $data) {
        return $this->connection->replace(
            $this->table,
            array_merge($this->fkeys, array($this->key => $key), $data)
        );
    }

    public function update($key, $data) {
        return $this->connection->update(
            $this->table,
            $data,
            array_merge($this->fkeys, array($this->key => $key))
        );
    }

    public function get($key) {
        return $this->connection->select(
            $this->table,
            array_merge($this->fkeys, array($this->key => $key))
        )->line();
    }

    public function getPage($page, $per_page, $filter = array()) {
        $filter = array_merge($this->fkeys, $filter);
        $where = $this->connection->buildPairs(array_keys($filter), 'and');
        return $this->connection->pages(
            'select * from `' . $this->table . '`' .
            $this->connection->wrapWhere($where),
            $filter,
            $page,
            $per_page
        );
    }

}
