<?php

use App\Configuracion;

class ConfigSingleton
{

    private static $instance = Null;
    private $configuracion = null;

    private function __construct()
    {
        $this->configuracion =  Configuracion::first();

    }

    private function __clone()
    {
        # code...
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {

            self::$instance = new ConfigSingleton();
        }

        return self::$instance;
    }

    public function data(){
        return $this->configuracion;
    }

}
