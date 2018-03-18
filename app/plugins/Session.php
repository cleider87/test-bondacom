<?php

namespace RESTful\Plugins {

    use Silex\Application;
    use Silex\Provider\SessionServiceProvider;
    use RESTful\Helpers\SessionHelper;
    use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

    class Session {

        public static function plug(Application $app) {
            $app->register(new SessionServiceProvider());
            $app['session.capcha.storage'] = function ($app) {
                return new NativeSessionStorage();
            };
            $app['capcha.session'] = function () use($app) {
                return new SessionHelper($app['session.capcha.storage']);
            };
        }

    }

}