<?php

namespace App\Helpers;

class Helper
{

    /**
     * Indica el estatus de la evaluaciones desde inicio a fin
     * Tiene 3 estados.0 Inico, 1 Lanzada, 2 Finalizada
     */
    public static function estatus($estatus)

    {

         switch ($estatus) {
            case '0':
                return 'Inicio';
                break;
            case '1':
                return 'Lanzada';
                break;
            case '2':
                return 'Finalizada';
                break;
            case 'Inicio':
                return 0;
                break;
            case 'Lanzada':
                return 1;
                break;
            case 'Finalizada':
                return 2;
                break;
             default:
                return 'Indefinida';
                break;
            }

    }
    /**
     *Define los tipos de competencias estrictos
     */
    public static function tipoCompetencia($keytipo){

        $tipo=['G'=>'General','T'=>'Tecnica','S'=>'Supervisor','E'=>'Especifico'];

        return $tipo[$keytipo];

    }

}

