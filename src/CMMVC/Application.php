<?php

namespace CMMVC;

use CMMVC\ApplicationInterface;
use CMMVC\Exceptions\AppException;
use CMMVC\Sessions\SessionFactory;
use CMMVC\Database\DatabaseFactory;
use CMMVC\Middleware\MiddlewareFactory;
use CMMVC\Config\ConfigReaderFactory;
use CMMVC\HTTP\HTTPReader;

class Application implements ApplicationInterface
{
	private $configReader;
	private $sessionHandler;
	private $databaseConnection;
	private $objectArray = array();
	private $httpReader;
	private $uriReader;

	private static $instance;


	function __construct()
	{

	}

	public static function getInstance()
	{
		if (null === static::$instance) 
		{
			static::$instance = new static();
		}

		return static::$instance;
	}

	public function initialise($configFile)
	{
		if (!file_exists($configFile))
		{
			throw new AppException("Config file missing: " . $configFile);
		}

		$this->httpReader = new HTTPReader($_POST, $_GET, $_COOKIE);

		$this->uriReader = new URIReader($_SERVER['REQUEST_URI']);

		$pathParts = pathinfo($configFile);

		$this->configReader = ConfigReaderFactory::createConfigReader($pathParts['extension']);

		$this->configReader->readConfig($configFile);

		$this->sessionHandler = SessionFactory::createSessionHandler($this->getConfigSetting('session', 'sessiontype', ''));

		$this->sessionHandler->startSession();

		if ($this->sessionHandler->getSessionValue('csrf', '') == '')
		{
			$this->sessionHandler->setSessionValue('csrf', base64_encode(openssl_random_pseudo_bytes(32)));
		}

		$this->databaseConnection = DatabaseFactory::getDatabase("file",
																	$this->configReader->getConfigSetting('database','dbhost'),
																	$this->configReader->getConfigSetting('database','dbname'),
																	$this->configReader->getConfigSetting('database','dbuser'),
																	$this->configReader->getConfigSetting('database','dbpassword'));

		if ($handle = opendir('../app/Models'))
		{
			while (false !== ($modelClass = readdir($handle)))
			{
				if (($modelClass != '.') && ($modelClass != '..'))
				{
					$basename = basename($modelClass);

					$basename = strtolower(str_replace('.php', '', $basename));

					$className = 'App\\Models\\' . $basename;

	        		$this->objectArray['models'][$basename] = new $className();
	        	}
    		}
		}
	}

	public function canRoute($route)
	{
		return $this->routing->canRoute($this->sessionHandler, $this->configReader, $route);
	}

	public function redirect($page)
	{
		header('Location: ' . $this->getConfigSetting('', 'baseurl', '') . "/" . $page, true, 302);
	}

	public function view($page, $pageData = array())
	{
		$pageData['csrf'] = $this->sessionHandler->getSessionValue('csrf', '');

		require("../app/Views/" . $page . ".php");
	}

	public function __get($name)
	{
		if (!empty($this->objectArray['models'][$name]))
		{
			return $this->objectArray['models'][$name];
		}
		else if (!empty($this->objectArray['middleware'][$name]))
		{
			return $this->objectArray['middleware'][$name];
		}
		else if ($name == 'databaseconnection')
		{
			return $this->databaseConnection;
		}
		else if ($name == 'session')
		{
			return $this->sessionHandler;
		}
		else
		{
			throw new AppException("Object missing: " . $name . "\n" . var_export(debug_backtrace(), true));
		}
	}

	public function setSessionValue($key, $value)
	{
		return $this->sessionHandler->setSessionValue($key, $value);
	}

	public function getSessionValue($key)
	{
		return $this->sessionHandler->getSessionValue($key, null);
	}

	public function killSession()
	{
		$this->sessionHandler->endSession();
	}

	public function implementRouting()
	{
		$controller = null;
		$class = '';
		$route = $this->uriReader->getRoute();

		if (($class = $this->getConfigSetting('routes', $route, '')) != '')
		{
			$className = "App\\Controllers\\" . $class;
			
		}
		else
		{
			if ($route == '')
			{
				$className = "App\\Controllers\\" . $this->getConfigSetting('routes', 'defaultroute', '');
			}
		}

		if ($className != '')
		{
			$controller = new $className($this);
		}

		if ($controller)
		{
			$var = null;
			$method = null;

			if ((count($urlParts) > 2) && (($method = $urlParts[2]) != ''))
			{
				if (count($urlParts) == 4)
				{
					$var = $urlParts[3];
				}
			}

			$routingMiddleware = $this->getConfigSetting('routes', $route . "-middleware", '');

			$continue = true;

			if ($routingMiddleware != '')
			{
				$middlewareArray = explode(":", $routingMiddleware);

				$middlewareObject = null;

				foreach ($middlewareArray as $middleware)
				{
					$middlewareSettings = explode(";", $routingMiddleware);

					if (count($middlewareSettings) == 2)
					{
						$middlewareRoutes = explode(',', $middlewareSettings[1]);

						for ($i = 0; $i < count($middlewareRoutes); $i++)
						{
							if (($method == $middlewareRoutes[$i]) || ($route == $middlewareRoutes[$i]))
							{
								$middlewareObject = $this->getMiddleware($middlewareSettings[0]);

								$continue = $middlewareObject->handle($route);
								
								break;
							}
						}
					}
				}

			}

			if ($continue)
			{
				$controller->_index($this->uriReader);
			}
		}
		else
		{
			throw new AppException("Controller not found: " . $class);
		}
	}

	protected function getMiddleware($middlewareType)
	{
		if (empty($this->objectArray['middleware'][$middlewareType]))
		{
			$this->objectArray['middleware'][$middlewareType] = MiddlewareFactory::createMiddleware($this, $middlewareType);
		}

		return $this->objectArray['middleware'][$middlewareType];
	}

	public function getConfigSetting($section, $key, $default)
	{
		return $this->configReader->getConfigSetting($section, $key, $default);
	}

	public function getCSRF()
	{
		return $this->httpReader->getPostVar('csrf');
	}

	public function getSessionCSRF()
	{
		return $this->app->getSessionValue('csrf');
	}

}

?>