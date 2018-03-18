<?php

namespace RESTful\Business;

use Silex\Application;
use RESTful\Services\StructureService;

class StructureBusiness {

    private $app = null;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    public function create(int $country_id, string $level_name,int $level,int $final) {
        $insert_body = [
            'country_id' => $country_id,
            'level_name' => $level_name,
            'level' => $level,
            'final' => $final
        ];
        $service = new StructureService($this->app);
        return $service->conexion->insertOne($insert_body);
    }

    public function updateStructure(int $id, string $description, int $status) {
        $update = "description='" . $description . "',status=" . $status;
        $service = new StructureService($this->app);
        $update_resp = $service->conexion->update($update, ' id=' . $id);
        if ($update_resp) {
            return $service->conexion->find("SELECT * FROM structures WHERE id=" . $id);
        }
        return $update_resp;
    }

    public function getAll($status = null) {
        $service = new StructureService($this->app);
        if (empty($status)) {
            $status = 1;
        }
        return $service->conexion->getAll(
                        "SELECT
                            s.id,
                            country_name,
                            iso_name,
                            level_name,
                            final
                        FROM 
                            structures s, countries c 
                        WHERE 
                            c.id=country_id and c.status=1
                            "
        );
    }

    public function getStructureByCountryName(string $name) {
        $service = new StructureService($this->app);
        return $service->conexion->getAll(
                        "SELECT
                            s.id,
                            country_name,
                            iso_name,
                            level_name,
                            final
                        FROM 
                            structures s, countries c 
                        WHERE 
                            c.id=country_id and c.status=1
                            AND country_name='" . $name . "'"
        );
    }
    
    public function getStructureByCountryISO(string $iso) {
        $service = new StructureService($this->app);
        return $service->conexion->getAll(
                        "SELECT
                            s.id,
                            country_name,
                            iso_name,
                            level,
                            level_name,
                            final
                        FROM 
                            structures s, countries c 
                        WHERE 
                            c.id=country_id and status=1
                            AND iso_name='" . $iso . "'"
        );
    }

}
