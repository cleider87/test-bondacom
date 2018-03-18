<?php

namespace RESTful\Services;

use RESTful\Helpers\GenericPDO;
use Silex\Application;

class RegionService {

    protected $fieldId = 'id';
    protected $instance = 'master';
    protected $table = 'regions';

    /**
     * Conexión Activa
     * @var GenericPDO $conexion
     */
    public $conexion = null;

    function __construct(Application $app) {
        $this->conexion = new GenericPDO($app, $this->instance, $this->table, $this->fieldId);
    }

}
