<?php

namespace CMMVC\Sessions\Handlers;

use CMMVC\Sessions\SessionHandler;

class StandardSessionHandler extends SessionHandler
{
    public function startSession()
    {
        if ($this->sessionID == '') {
            session_start();

            $this->sessionID = session_id();
        }
    }

    public function restartSession()
    {
        $this->endSession();
        
        $this->startSession();
    }

    public function getSessionValue($key, $default=null)
    {
        if (!empty($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return $default;
        }
    }

    public function setSessionValue($key, $value)
    {
        $this->startSession();

        $_SESSION[$key] = $value;
    }

    public function endSession()
    {
        $this->sessionID = '';

        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();
    }
}
