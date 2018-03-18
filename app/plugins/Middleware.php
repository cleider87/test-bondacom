<?php

namespace RESTful\Plugins {

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    class Middleware {

        public static function plug(Application $app) {
            $app->after(function (Request $request, Response $response) use($app) {
                $response->headers->set('Access-Control-Allow-Origin', $app['asset.cors']['cors.allowOrigin']);
            });
            
            $app->before(function (Request $request, Application $app)  {
                if (strpos($request->headers->get('Content-Type'), 'application/json') === 0) {
                    $data = json_decode($request->getContent(), true);
                    $request->request->replace(is_array($data) ? $data : array());
                }
            });
        }

    }

}