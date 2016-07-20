<?php

namespace Reactor\Database\PDO;

use Reactor\Database\Exceptions as Exceptions;
use Reactor\Database\Interfaces\QueryInterface;

/**
 * Class Query
 *
 * @package Reactor\Database\PDO
 */
class Query implements QueryInterface
{
    protected $stats = array();
    protected $statement;
    protected $line = null;
    protected $iterator_key = 0;
    
    /**
     * Query constructor.
     *
     * @param $statement \PDOStatement
     */
    public function __construct($statement)
    {
        $this->statement = $statement;
    }
    
    /**
     * @inheritdoc
     *
     * @throws \Reactor\Database\Exceptions\DatabaseException
     */
    public function exec($parameters = array())
    {
        $this->statement->closeCursor();
        
        $parameters = (array) $parameters;
        
        $this->stats['parameters'] = $parameters;
        
        $execution_time = microtime(true);
        
        try {
            $this->statement->execute($parameters);
        } catch (\PDOException $exception) {
            throw new Exceptions\DatabaseException($exception->getMessage(), $this);
        }
        
        $this->stats['execution_time'] = microtime(true) - $execution_time;
        
        return $this;
    }
    
    /**
     * @return void
     */
    public function __destruct()
    {
        $this->statement->closeCursor();
    }
    
    /**
     * @inheritdoc
     */
    public function line($row = '*')
    {
        $line = $this->statement->fetch(\PDO::FETCH_ASSOC);
        
        if ($line) {
            if ($row == '*') {
                return $line;
            }
            
            return $line[$row];
        }
        
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function free()
    {
        $this->statement->closeCursor();
    }
    
    /**
     * @inheritdoc
     */
    public function matr($key = null, $row = '*')
    {
        $data = array();
        
        if ($key === null) {
            if ($row == '*') {
                $data = $this->statement->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                while ($line = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
                    $data[] = $line[$row];
                }
            }
        } else {
            if ($row == '*') {
                while ($line = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
                    $data[$line[$key]] = $line;
                }
            } else {
                while ($line = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
                    $data[$line[$key]] = $line[$row];
                }
            }
        }
        
        return $data;
    }
    
    /**
     * @inheritdoc
     */
    public function count()
    {
        return $this->statement->rowCount();
    }
    
    /**
     * @inheritdoc
     */
    public function getStats()
    {
        $this->stats['query'] = $this->statement->queryString;
        
        return $this->stats;
    }
    
    /**
     * Hackish method if advanced PDO features are requred
     *
     * @return \PDOStatement
     */
    public function getStatement()
    {
        return $this->statement;
    }
    
    /**
     * @inheritdoc
     */
    public function current()
    {
        if (!$this->line) {
            $this->next();
        }
        
        return $this->line;
    }
    
    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->iterator_key;
    }
    
    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->line = $this->line();
        $this->iterator_key++;
        if (!$this->line) {
            $this->iterator_key = false;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function rewind()
    {
        return $this->iterator_key = 0;
    }
    
    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->iterator_key !== false;
    }
}
