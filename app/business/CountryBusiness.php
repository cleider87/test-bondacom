<?php

namespace RESTful\Business;

use Silex\Application;
use RESTful\Services\CountryService;

class CountryBusiness {

    private $app = null;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    public function create(string $country_name, string $iso_name) {
        $insert_body = [
            'country_name' => $country_name,
            'iso_name' => $iso_name
        ];
        $service = new CountryService($this->app);
        return $service->conexion->insertOne($insert_body);
    }

    public function updateCountry(int $id, string $description, int $status) {
        $update = "description='" . $description . "',status=" . $status;
        $service = new CountryService($this->app);
        $update_resp = $service->conexion->update($update, ' id=' . $id);
        if ($update_resp) {
            return $service->conexion->find("SELECT * FROM countries WHERE id=" . $id);
        }
        return $update_resp;
    }

    public function getAll($status = null) {
        $service = new CountryService($this->app);
        if (empty($status)) {
            $status=1;
        }
        return $service->conexion->getAll("SELECT id as value,country_name as name FROM " . $service->conexion->getTableName() . " WHERE status=" . $status);
    }

}
