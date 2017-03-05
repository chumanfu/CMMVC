<?php

namespace CMMVC\Sessions;

abstract class SessionHandler
{
	protected $sessionID = '';

	abstract protected function startSession();
	abstract protected function restartSession();
	abstract protected function getSessionValue($key, $default=null);
	abstract protected function setSessionValue($key, $value);
	abstract protected function endSession();

}

?>