<?php

namespace Reactor\Database\Interfaces;

/**
 * Interface QueryInterface
 *
 * @package Reactor\Database\Interfaces
 */
interface QueryInterface extends \Iterator
{
    /**
     * @param array $parameters
     *
     * @return $this
     */
    public function exec($parameters = array());
    
    /**
     * @param string $row
     *
     * @return mixed|null
     */
    public function line($row = '*');
    
    /**
     * @return bool
     */
    public function free();
    
    /**
     * @param null   $key
     * @param string $row
     *
     * @return array
     */
    public function matr($key = null, $row = '*');
    
    /**
     * @return int
     */
    public function count();
    
    /**
     * @return array
     */
    public function getStats();
    
    /**
     * @inheritdoc
     */
    public function current();
    
    /**
     * @inheritdoc
     */
    public function key();
    
    /**
     * @inheritdoc
     */
    public function next();
    
    /**
     * @inheritdoc
     */
    public function rewind();
    
    /**
     * @inheritdoc
     */
    public function valid();
}
