<?php

namespace RESTful\Plugins {
    use Silex\Application;
    use RESTful\Resources\APIResource;
    use RESTful\Resources\RootResource;
    
    /**
     * Puntos de montaje para endpoints
     */
    class Resources {
        public static function plug(Application $app) {
            $app->mount('/', new RootResource());
            $app->mount('/api', new APIResource());
        }
    }
}
