<?php

namespace CMMVC;

use CMMVC\HTTP\URIReader;

trait ControllerTrait
{
    protected $app = null;

    public function _index(URIReader $uriReader)
    {
        $methodCalled = false;

        $method = $uriReader->getMethod();
        $var = $uriReader->getVar();

        if ($method) {
            if (method_exists($this, $method)) {
                $this->$method($var);
                $methodCalled = true;
            }
        }

        if (!$methodCalled) {
            $this->index($method);
        }
    }

    public function checkCSRF()
    {
        $return = true;
        $csrf = $this->app->getCSRF();

        if ($csrf == null) {
            $return = false;
        } else {
            if ($csrf != $this->app->getSessionCSRF()) {
                $return = false;
            }
        }

        return $return;
    }
}
