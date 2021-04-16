<?php

namespace CMMVC\HTTP;

use CMMVC\Utils\UtilsArray;

class HTTPReader
{
    private $vars = array('post'=>array(), 'get'=>array(), 'cookie'=>array());

    public function __construct($post, $get, $cookie)
    {
        $this->vars['post'] = $post;
        $this->vars['get'] = $get;
        $this->vars['cookie'] = $cookie;
    }

    public function getPosts()
    {
        return UtilsArray::readArrayParam($this->vars, "post");
    }

    public function getGets()
    {
        return UtilsArray::readArrayParam($this->vars, "get");
    }

    public function getCookies()
    {
        return UtilsArray::readArrayParam($this->vars, "cookie");
    }

    private function getVarItem($type, $key)
    {
        return UtilsArray::readArrayParam($this->vars[strtolower($type)], $key, null);
    }

    public function getPostVar($key)
    {
        return $this->getVarItem("post", $key);
    }

    public function getGetVar($key)
    {
        return $this->getVarItem("get", $key);
    }

    public function getCookieVar($key)
    {
        return $this->getVarItem("cookie", $key);
    }

    public function readValue($key, $type = '')
    {
        if ($type != '') {
            return $this->getVarItem($type, $key);
        } else {
            $item = $this->getVarItem("post", $key);

            if ($item != null) {
                return $item;
            }

            $item = $this->getVarItem("get", $key);

            if ($item != null) {
                return $item;
            }

            $item = $this->getVarItem("cookie", $key);

            if ($item != null) {
                return $item;
            }
        }
    }
}
