<?php

namespace Reactor\Database\Interfaces;

/**
 * Interface ConnectionInterface
 *
 * @package Reactor\Database\Interfaces
 */
interface ConnectionInterface
{
    /**
     * @param       $query
     *
     * @return $this|\Reactor\Database\PDO\Query
     */
    public function sql($query);
    
    /**
     * @param null $name
     *
     * @return string
     */
    public function lastId($name = null);
    
    /**
     * @param       $table
     * @param array $data
     *
     * @return string
     */
    public function insert($table, array $data);
    
    /**
     * @param       $table
     * @param array $data
     *
     * @return string
     */
    public function replace($table, array $data);
    
    /**
     * @param        $table
     * @param array  $data
     * @param array  $where_data
     * @param string $where
     *
     * @return int
     */
    public function update($table, array $data, array $where_data = array(), $where = '');
    
    /**
     * @param       $query
     * @param array $parameters
     * @param       $page
     * @param       $per_page
     * @param null  $total_rows
     *
     * @return array
     */
    public function pages($query, array $parameters, $page, $per_page, $total_rows = null);
}
