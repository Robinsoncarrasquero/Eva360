<?php
namespace app\CustomClass;

use App\Configuracion;
use App\Paypal;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class Transacciones
{

    private $precio;

    function __construct() {

        $this->precio = env('PAYPAL_TOTAL');

    }

    /**Saldo de la cuenta */
    public function getSaldo()
    {
        $saldo = Paypal::sum('total');
        return $saldo;
    }

    /**Unidades disponibles de la cuenta */
    public function getTotalUnidades()
    {
        $saldo = Paypal::sum('unidades');
        return $saldo;
    }

    /**Registra la transaccion de evaluacion */
    public function addTransaccion($lote)
    {
        try {
            $record = new  Paypal();
            $record->payid="ASSESSMENT_OF_".$lote;
            $record->intent='DB';
            $record->state='Process';
            $record->name="Systems";
            $record->total= - $this->precio;
            $record->currency="USD";
            $record->unidades=-1;
            $record->save();
        } catch (QueryException $e) {
            return false;
        }
        return true;
    }

}
