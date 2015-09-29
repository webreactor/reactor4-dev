<?php

namespace Reactor\HTTP;
use Reactor\Common\ValueScope\ValueScopeArray;

class RequestParameters  extends ValueScopeArray {

    // expects request related keys from $_SERVER
    protected $headers;

    public function headers() {
        if ($this->headers === null) {
            $this->headers = $this->parseHeaders($this->data);
        }
        return $this->headers;
    }

    public function parseHeaders($data) {
        $headers = array();
        $custom_headers = array(
            'CONTENT_LENGTH' => true,
            'CONTENT_TYPE' => true
        );
        foreach ($data as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers[substr($key, 5)] = $value;
            } elseif (isset($custom_headers[$key])) {
                $headers[$key] = $value;
            }
        }
        return $headers;
    }

}
