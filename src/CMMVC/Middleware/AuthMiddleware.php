<?php

namespace CMMVC\Middleware;
class AuthMiddleware
{
    protected $app;

    public function __construct(\CMMVC\Application $app)
    {
        $this->app = $app;
    }

    public function handle($route)
    {
        $canRoute = true;

        if (! $this->app->getSessionValue('loggedin', null)) {
            $this->redirect($route);
            $canRoute = false;
        }

        return $canRoute;
    }

    protected function redirect($route)
    {
        $this->app->redirect('');
    }
}
