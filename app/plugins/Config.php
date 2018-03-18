<?php

namespace RESTful\Plugins {

    use Silex\Application;

    class Config {
        public static function plug(Application $app) {
            // App
            $app['asset.app_name'] = 'RESTful API Localidades';
            $app['asset.version']='v1.0.0';
            $app['asset.i18n'] = 'es';
            
            // Desarrollo
            $app['debug'] = false;
            $app['config.log'] =  'tmp/log__'. date('Ymd').'.log';
            $app['config.timezone']='America/Buenos_Aires';
            // CORS
            $app['asset.cors'] = array(
                "cors.allowOrigin" => "*",
                "cors.allowMethods" => 'POST, GET, OPTIONS, DELETE, PUT',
                "cors.maxAge" => 1000,
                "cors.allowHeaders" => 'x-requested-with, Content-Type, origin, authorization, accept, client-security-token'
            );
            
            // Servicios
            // Base de datos
            $app['config.dbs'] = array(
                'dbs.options' => array(
                    'master' => array(
                        'driver' => 'pdo_mysql',
                        'host' => 'localhost',
                        'dbname' => 'localidades',
                        'user' => 'root',
                        'password' => 'admin',
                        'charset' => 'utf8mb4',
                    ),
                    'slave' => array(
                        'driver' => 'pdo_sqlite',
                        'path' => __DIR__ . '/app.db',
                        'charset' => 'utf8mb4',
                    )
                )
            );
        }
    }

}
