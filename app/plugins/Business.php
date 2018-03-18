<?php

namespace RESTful\Plugins {

    use Silex\Application;
    use RESTful\Business\CountryBusiness;
    use RESTful\Business\RegionBusiness;
    use RESTful\Business\StructureBusiness;

    
    class Business {
        public static function plug(Application $app) {
            // Estado General
            $app['business.active'] = 'Activo';
            $app['business.inactive'] = 'Inactivo';
           
            $app['CountryBusiness'] = $app->factory(function ($c) {
                return new CountryBusiness($c);
            });
           
            $app['RegionBusiness'] = $app->factory(function ($c) {
                return new RegionBusiness($c);
            });
            
            $app['StructureBusiness'] = $app->factory(function ($c) {
                return new StructureBusiness($c);
            });
            
        }
    }

}
?>