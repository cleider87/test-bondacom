<?php

namespace RESTful\Resources {

    use Exception;
    use Silex\Application;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Silex\ControllerCollection;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Silex\Api\ControllerProviderInterface;

    class RootResource implements ControllerProviderInterface {

        public function connected(Application $app, ControllerCollection $controllerCollection) {
            $me = get_class($this);
            $controllerCollection->get('/', function () use ($app) {
                return $app->redirect("/api/");
            });

            return $controllerCollection;
        }

        public function connect(Application $app): ControllerCollection {
            $controllers = $app['controllers_factory'];
            return $this->connected($app, $controllers);
        }

    }

}
