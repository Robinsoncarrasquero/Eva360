<?php
namespace app\CustomClass;

use App\Configuracion;

class ConfigSingleton
{

    private static $instance = Null;
    private $configuracion = null;
    protected $contador =0;
    public function __construct()
    {
        $this->configuracion =  Configuracion::first();

    }

    // private function __clone()
    // {
    //     # code...
    // }

    // public function getInstance()
    // {
    //     if (is_null(self::$instance)) {

    //         self::$instance = new ConfigSingleton();
    //     }

    //     return self::$instance;
    // }

    public function data(){
        return $this->configuracion;
    }

    public function suma(){
        return $this->contador++;;
    }

}
