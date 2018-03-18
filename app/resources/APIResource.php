<?php

namespace RESTful\Resources {

    use Exception;
    use Silex\Application;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Silex\ControllerCollection;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Silex\Api\ControllerProviderInterface;

    class APIResource implements ControllerProviderInterface {

        public function connected(Application $app, ControllerCollection $controllerCollection) {
            $me = get_class($this);
            $controllerCollection->get('/', function () use ($app) {
                return $app->json(
                                [
                                    'API' => $app['asset.app_name'],
                                    'DEBUG' => $app['debug'],
                                    'VERSION' => $app['asset.version']
                                ]
                );
            });
            $controllerCollection->post("/country/", $me . '::create_country');
            $controllerCollection->post("/region/", $me . '::create_region');
            $controllerCollection->post("/structure/", $me . '::create_structure');
            
            $controllerCollection->get("/structure/{name}", $me . '::getStructureByCountryName');
            $controllerCollection->get("/{iso}/structure/", $me . '::getStructureByCountryISO');
            
            $controllerCollection->get("/structure/", $me . '::getStructures');
            
            $controllerCollection->get("/country/", $me . '::getCountries');
            $controllerCollection->get("/country/{iso}/region/children", $me . '::getChildren');
            $controllerCollection->get("/country/{iso}/region/{id}/children", $me . '::getChildren');
            

            return $controllerCollection;
        }
        
        public function create_country(Application $app) {
            $request = Request::createFromGlobals();
            $requestContent = $request->getContent();
            if (!is_array($requestContent)) {
                $array = json_decode($requestContent, true);
                if (is_array($array)) {
                    $request->request->replace($array);
                }
            }
            // Campos Ofuscados

            $country_name = 'country_name';
            $iso_name = 'iso_name';

            // Bloque de Validaciones
            if (empty($request->request->get($country_name)) ||
                    empty($request->request->get($iso_name)) 
            ) {
                $error = array('message' => "Incomplete Request ");
                return $app->json($error, 400);
            }

            $_country_name = $request->request->get($country_name);
            $_iso_name = $request->request->get($iso_name);

            $resp = $app['CountryBusiness']->create($_country_name, $_iso_name);
            return $app->json($resp, 200);
        }
        
        public function create_region(Application $app) {
            $request = Request::createFromGlobals();
            $requestContent = $request->getContent();
            if (!is_array($requestContent)) {
                $array = json_decode($requestContent, true);
                if (is_array($array)) {
                    $request->request->replace($array);
                }
            }
            // Campos Ofuscados

            $region_name = 'region_name';
            $structure_id = 'structure_id';
            $parent = 'parent';

            // Bloque de Validaciones
            if (
                    empty($request->request->get($region_name)) ||
                    empty($request->request->get($structure_id)) 
            ) {
                $error = array('message' => "Incomplete Request ");
                return $app->json($error, 400);
            }

            $_region_name = $request->request->get($region_name);
            $_structure_id = $request->request->getInt($structure_id);
            $_parent = $request->request->getInt($parent);

            $resp = $app['RegionBusiness']->create($_structure_id, $_parent,$_region_name);
            return $app->json($resp, 200);
        }
          
        public function create_structure(Application $app) {
            $request = Request::createFromGlobals();
            $requestContent = $request->getContent();
            if (!is_array($requestContent)) {
                $array = json_decode($requestContent, true);
                if (is_array($array)) {
                    $request->request->replace($array);
                }
            }
            // Campos Ofuscados
           
            $country_id = 'country_id';
            $level_name = 'level_name';
            $level = 'level';
            $final = 'final';


            // Bloque de Validaciones
            if (
                    empty($request->request->get($level_name)) ||
                    empty($request->request->getInt($country_id))
            ) {
                $error = array('message' => "Incomplete Request ");
                return $app->json($error, 400);
            }

            $_country_id = $request->request->get($country_id);
            $_level_name = $request->request->get($level_name);
            $_level = $request->request->getInt($level);
            $_final = $request->request->getInt($final);

            $resp = $app['StructureBusiness']->create($_country_id,$_level_name,$_level,$_final);
            return $app->json($resp, 200);
        }
        
        public function getCountries(Application $app) {
            $resp = $app['CountryBusiness']->getAll();
            return $app->json($resp, 200);
        }

        public function getStructures(Application $app) {
            $resp = $app['StructureBusiness']->getAll();
            return $app->json($resp, 200);
        }

        public function getRegions(Application $app) {
            $resp = $app['RegionBusiness']->getAll();
            return $app->json($resp, 200);
        }

        public function getChildren(Application $app, $iso, $id = 0) {
            $nodes = $app['RegionBusiness']->getChildren($iso, $id);
            $resp = $this->getNode($app,$app['RegionBusiness']->getChildren($iso, $id), $iso);
            return $app->json(["node"=>$resp], 200);
        }

        private function getNode($app,$nodes,$iso) {
            $resp=[];
            foreach ($nodes as $node){
                if ($node['final'] == 0) {
                    $resp[] = [
                        "node" => $node,
                        "data" => $this->getNode($app,$app['RegionBusiness']->getChildren($iso, $node['id']) , $iso )
                    ];
                } else {
                    $resp[] = ["node" => $node];
                }
            }
            
            return $resp;
        }

        public function getStructureByCountryName(Application $app, $name) {
            $resp = $app['StructureBusiness']->getStructureByCountryName($name);
            return $app->json(
                            ["name" => $name, "structure" => $resp]
                            , 200);
        }

        public function getStructureByCountryISO(Application $app, $iso) {
            $resp = $app['StructureBusiness']->getStructureByCountryISO($iso);
            return $app->json($resp, 200);
        }

        public function connect(Application $app): ControllerCollection {
            $controllers = $app['controllers_factory'];
            return $this->connected($app, $controllers);
        }

    }

}
