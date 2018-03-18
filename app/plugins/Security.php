<?php

namespace RESTful\Plugins {

    use Silex\Application;
    use Silex\Provider\SecurityServiceProvider;

    class Security {

        public static function plug(Application $app) {
            $app['security.firewalls'] = array(
                'api' => array(
                    'pattern' => '^/api',
                    'http' => true,
                    'methods' => 'POST',
                    'users' => array(
                        // raw password is foo
                        'admin' => array('ROLE_ADMIN', 
                            '$2y$10$3i9/lVd8UOFIJ6PAMFt8gu3/r5g0qeCJvoSlLCsvMTythye19F77a'),
                    ),
                ),
            );

            
            $app['config.firewall.access'] = array(
                array('^/api', 'ROLE_ADMIN'),
                array('^/.+$', 'IS_AUTHENTICATED_ANONYMOUSLY')
            );

            $app->register(new SecurityServiceProvider());
        }

    }

}