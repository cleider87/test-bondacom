<?php

namespace RESTful;

use Silex\Application;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

use RESTful\Plugins\Database;
use RESTful\Plugins\Business;
use RESTful\Plugins\Resources;
use RESTful\Plugins\Providers;
use RESTful\Plugins\Middleware;
use RESTful\Plugins\Session;
use RESTful\Plugins\Security;

class App extends Application {

    use Application\SecurityTrait;
    use Application\MonologTrait;

    public function __construct(array $values = array()) {
        parent::__construct($values);
    }

    public function production() {
        $app = $this;
        date_default_timezone_set($app['config.timezone']);
        ExceptionHandler::register($app['debug']);
        ErrorHandler::register();
        Providers::plug($app);

        $app->log("Modo Producción");

        Database::plug($app);
        Business::plug($app);
        Middleware::plug($app);
        Resources::plug($app);
        Session::plug($app);
        Security::plug($app);
        $app->boot();
    }

    public function debug() {
        $app = $this;
        date_default_timezone_set($app['config.timezone']);
        ExceptionHandler::register($app['debug']);
        ErrorHandler::register();
        Providers::plug($app);
        $app->log("Modo Desarrollo");

        Database::plug($app);
        Business::plug($app);
        Middleware::plug($app);
        Resources::plug($app);
        Session::plug($app);
    }

}
