<?php

namespace Reactor\Gekkon\Compiler;

use Reactor\Gekkon\Tags\Common\Tag_static;

//version 2.1
class Compiler {
    function __construct($gekkon) {
        $this->errors = array();
        $this->gekkon = $gekkon;
        $this->uid = 0;
        $this->binTplCode = false;
        $this->exp_compiler = new ExpCompiler($this);
        $this->open_tokens = null;
        $this->init();
    }

    function exp_compiler() {
        return $this->exp_compiler;
    }

    function init() {
        $this->tag_systems = array();
        $tokens = array();
        $tag_system_map = array();
        if (empty($this->gekkon->settings['tag_systems'])) {
            $this->error('No tag systems installed');
            return;
        }
        foreach ($this->gekkon->settings['tag_systems'] as $class_name => $data) {
            $this->tag_systems[$class_name] = new $class_name($this, $data);
            $tokens[$data['open']][$data['close']] = preg_quote($data['close'], '/');
            $tag_system_map[$data['open']][$data['close']][] = $class_name;
        }
        $open_tokens = array();
        $close_tokens = array();
        foreach ($tokens as $open => $close) {
            $open_tokens[$open] = preg_quote($open, '/');
            rsort($close); // Longer token goes first
            $close_tokens[$open] = implode('|', $close);
        }
        rsort($open_tokens);
        $this->open_tokens = implode('|', $open_tokens);
        $this->tag_system_map = $tag_system_map;
        $this->close_tokens = $close_tokens;
    }

    function compile($template) {
        $this->binTplCode = new BinTemplateCode($this, $template);
        $source = $this->compile_str($template->source());
        if (!Compiler::check_syntax($source)) {
            return false;
        }
        $this->binTplCode->blocks['__main'] = $source;
        return $this->binTplCode;
    }

    function compile_str($_str, $parent = false) {
        if ($parent === false) {
            $parent = new BaseTag($this);
            $parent->line = 1;
            $parent->system = 'root';
            $parent->parent = false;
        }
        $data = $this->parse_str($_str, $parent);
        $this->flush_errors();
        if ($data === false) {
            return false;
        }
        return $this->compile_parsed_str($data);
    }

    function compile_parsed_str($data) {
        $rez = '';
        foreach ($data as $tag) {
            if (($t = $tag->compile($this)) !== false) {
                $rez .= $t;
            } else {
                $this->flush_errors();
            }
        }
        return $rez;
    }

    function parse_str($_str, $_parent) {
        $rez = array();
        $_line = $_parent->line + $_parent->open_lines();
        while ($_str != '') {
            $_tag = $this->find_tag($_str);
            if ($_tag === false) {
                $rez[] = new Tag_static($_str);
                break;
            }
            $_tag->parent = &$_parent;
            if ($_tag->open_start > 0) {
                $before = new Tag_static(mb_substr($_str, 0, $_tag->open_start));
                $rez[] = $before;
                //echo $_line, '>', trim($before->content_raw), "\n";
                $_line += $before->total_lines();
                $_str = mb_substr($_str, $before->total_length());
                $_tag->open_start = 0;
            }
            //echo $_line, '>', trim($_tag->open_raw), "\n";
            $_tag->line = $_line;
            $_tag = $this->parse_tag($_tag, $_str);
            $_line += $_tag->total_lines();
            $_str = mb_substr($_str, $_tag->total_length());
            $rez[] = $_tag;
        }
        return $rez;
    }

    function find_tag(&$_str) {
        $open_raw = false;
        if (empty($this->open_tokens)) {
            return false;
        }
        if (preg_match('/' . $this->open_tokens . '/u', $_str, $preg_data, PREG_OFFSET_CAPTURE)) {
            $open_start_token = $preg_data[0][0];
            $open_start = $preg_data[0][1];
            $open_inner_start = $open_start + mb_strlen($open_start_token);
            if (preg_match('/' . $this->close_tokens[$open_start_token] . '/u', $_str, $preg_data, PREG_OFFSET_CAPTURE, $open_start)) {
                $open_end_token = $preg_data[0][0];
                $open_end = $preg_data[0][1];
                $open_inner_length = $open_end - $open_inner_start;
                $open_length = $open_end - $open_start + mb_strlen($open_end_token);
                $open_raw = substr($_str, $open_inner_start, $open_inner_length);
            }
        }
        if ($open_raw === false) {
            return false;
        }
        $_tag = new BaseTag($this);
        $_tag->open_raw = $open_raw;
        $_tag->start_token = $open_start_token;
        $_tag->end_token = $open_end_token;
        $_tag->open_start = $open_start;
        $_tag->open_length = $open_length;
        return $_tag;
    }

    function parse_tag($_tag, &$_str) {
        $possible_systems = $this->tag_system_map[$_tag->start_token][$_tag->end_token];
        foreach ($possible_systems as $tag_system) {
            $_tag = $this->tag_systems[$tag_system]->try_parse($_tag, $_str);
            if ($_tag->system !== '') {
                return $_tag;
            }
        }
        return new Tag_static($_tag->start_token . $_tag->open_raw . $_tag->end_token);
    }

    function error_in_tag($msg, $_tag) {
        return $this->error($msg, 'Tag: ' . $_tag->system . ':' . $_tag->name, $_tag->line);
    }

    function error($msg, $object = false, $line = false) {
        $message = '';
        if ($object !== false) {
            $message .= '[<b>' . $object . '</b>] ';
        }
        $message .= $msg . ' ';
        if ($line !== false) {
            if ($this->binTplCode !== false) {
                $message .= 'in <b>"' . $this->binTplCode->template->get_id() . '"</b> ';
            }
            $message .= 'on line ' . $line . ' ';
        }
        $this->errors[] = $message;
        return false;
    }

    function errors() {
        $this->errors = array_reverse($this->errors);
        $message = implode("\n", $this->errors);
        $this->errors = array();
        return strip_tags($message);
    }

    function flush_errors() {
        if (count($this->errors) > 0) {
            $this->errors = array_reverse($this->errors);
            $message = implode("\n", $this->errors);
            $this->gekkon->error($message, 'Compiler');
            $this->errors = array();
        }
        return false;
    }

    function getUID()//it is a relatively unique id, for uid inside of one template
    {
        return $this->uid++;
    }

    function check_syntax($code) {
        $tmp_file = $this->gekkon->bin_path.'check_syntax.tmp.php';
        file_put_contents($tmp_file, '<?php '.$code);
        exec('php -l '.$tmp_file, $details, $return_var);
        if ($return_var !== 0) {
            $this->errors[] = 'syntax error';
            return false;
        }
        return true;
    }

    function split_parsed_str($data, $tag_name, $keep_spliter = false) {
        $rez = array();
        $key = 0;
        $rez[$key] = array();
        foreach ($data as $tag) {
            if ($tag->name == $tag_name) {
                $key++;
                $rez[$key] = array();
                if ($keep_spliter) {
                    $rez[$key][] = $tag;
                }
            } else {
                $rez[$key][] = $tag;
            }
        }
        return $rez;
    }

    function compileOutput($data, $just_code = false) {
        if ($just_code) {
            $rez = '';
        } else {
            $rez = 'echo ';
        }
        if ($this->gekkon->settings['auto_escape']) {
            $rez .= "htmlspecialchars($data, ENT_QUOTES, 'UTF-8');\n";
        } else {
            $rez .= $data . ";\n";
        }
        return $rez;
    }
}
