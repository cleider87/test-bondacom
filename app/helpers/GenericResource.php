<?php

namespace RESTful\Helpers;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class GenericResource implements ControllerProviderInterface {

    /**
     * Método factory para conectar controllers básicos en la app
     * 
     * @param Application $app
     * @return string
     */
    public function connect(Application $app) {
        $me = get_class($this);
        $generic = '/';
        $particular = '/{id}';

        $controllers = $app['controllers_factory'];
        $controllers->get($generic, $me . '::listAll');
        $controllers->post($generic, $me . '::post');

        $controllers->get($particular, $me . '::get');
        $controllers->put($particular, $me . '::put');
        $controllers->delete($particular, $me . '::delete');
        
        return $this->connected($app, $controllers);
    }

    public abstract function listAll(Application $app): JsonResponse;

    public abstract function post(Application $app): JsonResponse;

    public abstract function get(Application $app,string $id): JsonResponse;

    public abstract function put(Application $app): JsonResponse;

    public abstract function delete(Application $app,string $id): JsonResponse;

    public function connected(Application $app, ControllerCollection $controllerCollection) {
        return $controllerCollection;
    }

}
