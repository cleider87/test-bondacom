<?php

namespace RESTful\Services;

use RESTful\Helpers\GenericPDO;
use Silex\Application;

class StructureService {

    protected $fieldId = 'id';
    protected $instance = 'master';
    protected $table = 'structures';

    /**
     * Conexión Activa
     * @var GenericPDO $conexion
     */
    public $conexion = null;

    function __construct(Application $app) {
        $this->conexion = new GenericPDO($app, $this->instance, $this->table, $this->fieldId);
    }

}
