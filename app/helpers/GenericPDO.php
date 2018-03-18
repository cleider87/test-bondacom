<?php

namespace RESTful\Helpers {

    use Silex\Application;
    use Doctrine\DBAL\Schema\Table;
    use Doctrine\DBAL\Statement;

    class GenericPDO {

        /**
         *  Contenerdor Silex
         * @var Application $app 
         */
        private $app = '';

        /**
         *
         * Entidad 
         * 
         * @var string  $table_name
         * @var string  $fieldId
         * @var array  $structure
         * 
         */
        private $instance_name;
        private $table_name;
        private $fieldId;

        function __construct(Application $app, $instance, $table, $id = 'id') {
            $this->app = $app;

            $this->fieldId = $id;
            $this->table_name = $table;
            $this->instance_name = $instance;
            $app['dbs'][$instance]->getSchemaManager();
        }

        public function getOne($id) {
            /**
             * @var Statement $conexion 
             */
            $conexion = $this->getConexion();
            $sql = "SELECT * FROM " . $this->table_name . " WHERE id=?";
            return $conexion->fetchAssoc($sql, array((int) $id));
        }

        public function getAll($sql=null) {
            /**
             * @var Statement $conexion 
             */
            $conexion = $this->getConexion();
            if(!empty($sql)){
                return $conexion->fetchAll($sql);
            }
            return $conexion->fetchAll('SELECT * FROM ' . $this->table_name);
        }

        public function find($sql, $filters = []) {
            /**
             * @var Statement $conexion 
             */
            $conexion = $this->getConexion();
            return $conexion->fetchAssoc($sql, $filters);
        }

        public function insertOne($fiels = []) {
            /**
             * @var Statement $conexion 
             */
            $conexion = $this->getConexion();
            $conexion->insert($this->table_name, $fiels);
            $id = $conexion->lastInsertId();
            return $this->getOne($id);
        }

        public function update($fiels, $conditions ) {
            /**
             * @var Statement $conexion 
             */
            $conexion = $this->getConexion();
            $sql = "UPDATE " . $this->table_name . " SET ".$fiels." WHERE ".$conditions;
            if($conexion->executeQuery($sql)->queryString){
                return true;
            }else{
                return false;
            }
        }

        public function deleteOne($id) {
            /**
             * @var Statement $conexion 
             */
            $conexion = $this->getConexion();
            return $conexion->delete($this->table_name, array('id' => $id));
        }

        /**
         * Obtiene el manejador de query
         * @return Statement
         */
        private function getConexion() {
            return $this->app['dbs'][$this->instance_name];
        }

        public function getInform() {
            $error = $this->getConexion()->errorCode();
            $info = $this->getConexion()->errorInfo();
            $inform = array(
                'code' => $error,
                'info' => $info
            );
            return $inform;
        }

        public function rowCount() {
            return $this->getConexion()->rowCount();
        }

        public function getTableName() {
            return $this->table_name;
        }

        public function getFieldId() {
            return $this->fieldId;
        }

    }

}