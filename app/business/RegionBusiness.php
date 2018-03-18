<?php

namespace RESTful\Business;

use Silex\Application;
use RESTful\Services\RegionService;

class RegionBusiness {

    private $app = null;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    public function create(int $structure_id,int $parent,string $region_name) {
        $insert_body = [
            'structure_id' => $structure_id,
            'parent' => $parent,
            'region_name' => $region_name
        ];
        $service = new RegionService($this->app);
        return $service->conexion->insertOne($insert_body);
    }

    public function updateRegion(int $id, string $description, int $status) {
        $update = "description='" . $description . "',status=" . $status;
        $service = new RegionService($this->app);
        $update_resp = $service->conexion->update($update, ' id=' . $id);
        if ($update_resp) {
            return $service->conexion->find("SELECT * FROM activity WHERE id=" . $id);
        }
        return $update_resp;
    }

    public function getAll($status = null) {
        $service = new RegionService($this->app);
        if (empty($status)) {
            $status = 1;
        }
        return $service->conexion->getAll("SELECT * FROM " . $service->conexion->getTableName() . " WHERE status=" . $status);
    }

    public function getChildren($iso, $id) {
        $service = new RegionService($this->app);
        $children = $service->conexion->getAll("
                                            SELECT 
                                                r.id,
                                                parent,
                                                region_name,
                                                final
                                            FROM
                                                regions r,
                                                structures s,
                                                countries c
                                            WHERE
                                                c.id = country_id
                                                AND r.status = 1 
                                                AND structure_id = s.id
                                                AND iso_name='" . $iso . "'
                                                AND parent =" . $id
        );
        return $children;
    }

}
