<?php

namespace Reactor\WebService;

class WebLink {
    
    public $scheme;
    public $user;
    public $password;
    public $host;
    public $port;
    public $path;
    public $query;
    public $fragment;

    public function __construct($link = null) {
        if ($link !== null) {
            $parts = parse_url($link);
            foreach ($parts as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function uri($parts = array()) {
        $rez = '';
        $parts = array_merge(get_object_vars($this), $parts);

        if (isset($parts['path'])) {
            $rez .= $parts['path'];
        }

        if (isset($parts['query'])) {
            $rez .= '?'.$parts['query'];
        }

        return $rez;
    }

    public function url($parts = array()) {
        $rez = '';
        $parts = array_merge(get_object_vars($this), $parts);
        if (isset($parts['scheme'])) {
            $rez .= $parts['scheme'].'://';
        }

        if (isset($parts['user'])) {
            $rez .= $parts['user'];
            if (isset($parts['password'])) {
                $rez .= ':'.$parts['password'];
            }
            $rez .= '@';
        }

        if (isset($parts['host'])) {
            $rez .= $parts['host'];
        }

        if (isset($parts['port']) && $parts['port'] != 80) {
            $rez .= ':'.$parts['port'];
        }

        if (isset($parts['path'])) {
            $rez .= $parts['path'];
        }

        if (isset($parts['query'])) {
            $rez .= '?'.$parts['query'];  
        }

        return $rez;
    }

}
