<?php

namespace Reactor\WebService;

// implements HTTPRouterInterface
class Router {

    public function __construct($application, $config) {
        $this->application = $application;
        $this->config = $config;
    }

    public function handleRequest($request_responce) {
        $rez = $this->parseUrl($request_responce->request->uri());
        print_r($rez);
    }

    public function parseUrl($url) {
        print_r($this->config);
    }

    function parseUrLegacy($str)
    {
        $_languages = array();
        $_reactor = array();
        $_site_tree = $this->config;

        $r = array();
        $tree_i = &$_site_tree['index'];
        $_reactor['path'] = array();
        $_reactor['path'][] = $_site_tree['nodes'][$tree_i['#key']];
        $_reactor['path_url'] = '';

        if($str=='' || $str=='index')
        {
            $_reactor['show'] = $_site_tree['nodes'][$tree_i['#key']];
            return $r;
        }


        $i = 0;
        $str = explode('/',$str);

        if(isset($_languages[$str[0]]))
        {
            $r['lng'] = $str[0];
            $i = 1;
        }

        $j = 0;
        $c = count($str);
        for(;$i<$c;$i++)
        {
            if(isset($tree_i[$str[$i]]))
            {
                $j = 0;

                $tree_i = &$tree_i[$str[$i]];
                $_reactor['path_url'] .= $str[$i].'/';
                $_reactor['path'][] = $_site_tree['nodes'][$tree_i['#key']]; //did #key points on node with minimal parameters set or what?
            }
            else
            {
                $param_pool = &$_site_tree['param']['/'.$_reactor['path_url']];

                $param = $param_pool[$param_pool['max']];
                $cnt = $param_pool['max'];

                if($j >= $cnt)
                {
                    $_reactor['show'] = $_site_tree['nodes'][$_site_tree['index']['404']['#key']];
                    stop('404');
                }

                $r[$param[$j]] = $str[$i];
                if($param[$j][0]=='_')
                {
                    $r[$param[$j]] = array();
                    for(;$i<$c;$i++)
                    {
                        // since array url part ending cant be marked just in url
                        // here parser will greedly take whole url ending as array
                        // we need find a way to parce arrays proper without any marks in url
                        if($str[$i][0]!='_')
                            $r[$param[$j]][]=$str[$i];
                        else
                        {
                            //$str[$i] = substr($str[$i],1);
                            //$i--;
                            break;
                        }
                    }
                }
                $j++;
            }
        }


        $r['show'] = $_reactor['path_url'];

        $param_pool = &$_site_tree['param']['/'.$_reactor['path_url']];

        while(!isset($param_pool[$j]) && $j<$param_pool['max']) $j++;
        if(!isset($param_pool[$j])) $j = $param_pool['min'];

        $_reactor['show'] = $_site_tree['nodes'][$param_pool[$j]['key']];
        $_reactor['path'][] = $_reactor['show'];

        return $r;
    }


}
