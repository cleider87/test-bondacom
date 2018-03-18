<?php

namespace RESTful {
    // Autoload de clases internas
    $loader = require __DIR__ . '/../app/vendor/autoload.php';

    use RESTful\App;
    use RESTful\Plugins\Config;

    $app = new App();
    Config::plug($app);
    
    if($app['debug']){
        // Modo sin seguridad
        $app->debug();
    }else{
        $app->production();
    }

    $app->run();
}