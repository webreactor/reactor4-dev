<?php

namespace Reactor\Generic\Model;

use Reactor\Database\Interfaces\ConnectionInterface;
use Reactor\Database\Interfaces\QueryInterface;

class CollectionModel {

    protected $dao;

    public function setDAO($dao) {
        $this->dao = $dao;
    }

    public function add($data) {
        return $this->dao->add($data);
    }

    public function delete($key) {
        return $this->dao->delete($key);
    }

    public function update($key, $data) {
        return $this->dao->update($key, $data);
    }

    public function replace($key, $data) {
        return $this->dao->replace($key, $data);
    }

    public function get($key) {
        return $this->dao->get($key);
    }

    public function getAll($keys = array()) {
        return $this->dao->getAll($keys);
    }

    public function getPage($page, $per_page, $keys = array()) {
        //$cond = array_merge($this->fkeys, $keys)
        //return $this->connection->sql('select from `'.$this->table.'` where '., $cond)->line();
    }

}
