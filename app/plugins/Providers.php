<?php

namespace RESTful\Plugins {

    use Silex\Application;
    use Silex\Provider\MonologServiceProvider;
    use Silex\Provider\TwigServiceProvider;

    class Providers {

        public static function plug(Application $app) {
            
            $app->register(new MonologServiceProvider(), array(
                'monolog.logfile' => __DIR__ .'/../../'.$app['config.log'],
                'monolog.permission' => 0644,
            ));
            
        }
        
    }

}