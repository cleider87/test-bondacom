<?php

namespace RESTful\Plugins {
    
    use Silex\Application;
    use Silex\Provider\DoctrineServiceProvider;

    class Database {
        public static function plug(Application $app) {
            $app->register(new DoctrineServiceProvider(),$app['config.dbs']);
        }

    }

}
