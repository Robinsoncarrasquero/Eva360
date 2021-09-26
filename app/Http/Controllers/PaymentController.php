<?php

namespace App\Http\Controllers;

use App\Paypal;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use app\CustomClass\Transacciones;

class PaymentController extends Controller
{
    private $apiContext;
    private $precio;
    private $transacciones;
    private $unidades;
    public function __construct()
    {
        $payPalConfig = Config::get('paypal');
        $this->precio = env('PAYPAL_TOTAL');

        // After Step 1
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $payPalConfig['client_id'],     // ClientID
                $payPalConfig['secret'],      // ClientSecret
            )
        );


        $this->apiContext->setConfig($payPalConfig['setting']);

    }

    // ...

    public function payWithPayPal(Request $request)
    {
        $validate = $request->validate(
            [
                'monto'=>'required|numeric',
            ],
            [
                'monto.required'=>'Monto requerido, por favor ingrese un monto mayor a cero',
                'monto.numeric'=>'Debe ser un valor numerico'
        ]);

        //Unidades compradas en variable global porque sale del sitio
        $this->unidades =$request->unidades;

        $total = $request->monto;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($total);
        $amount->setCurrency('USD');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('Credit for you assessments');

        $callbackUrl=route('paypal.status');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callbackUrl)
            ->setCancelUrl($callbackUrl);

        $payment = new Payment() ;
        $payment->setIntent('Order')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (PayPalConnectionException $ex) {
            echo $ex->getData();
        }
    }

    public function payPalStatus(Request $request)
    {

        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');

        if (!$paymentId || !$payerId || !$token) {
            $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar.';
            //return redirect('/paypal/failed')->with(compact('status'));
            return redirect()->route('paypal.transactions')->withErrors($status);
        }

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        /** Execute the payment **/
        $result = $payment->execute($execution, $this->apiContext);

        $shipping_address = [
        //'number_of_books' => $payment->transactions[0]->item_list->items[0]->name,
                'name' => $payment->payer->payer_info->shipping_address->recipient_name,
                'street' => $payment->payer->payer_info->shipping_address->line1,
                'city' => $payment->payer->payer_info->shipping_address->city,
                'state' => $payment->payer->payer_info->shipping_address->state,
                'country' => $payment->payer->payer_info->shipping_address->country_code,
        ];

        $order = [
            'payid' => $payment->id,
            'intent' => $payment->intent,
            'name' => $payment->payer->payer_info->shipping_address->recipient_name,
            'state' => $payment->state,
            'total' => $payment->transactions[0]->amount->total,
            'currency' => $payment->transactions[0]->amount->currency,
        ];

        if ($result->getState() === 'approved') {
            try {
                $record = new  Paypal();
                $record->payid=$order['payid'];
                $record->intent=$order['intent'];
                $record->state=$order['state'];
                $record->name=$order['name'];
                $record->total=$order['total'];
                $record->currency=$order['currency'];
                $record->unidades= $order['total'] / $this->precio;
                $record->save();
            } catch (QueryException $e) {
                return redirect()->back()
                ->withErrors('Error no fue posible guardar esta transaccion. reporte el problema order: '.$order['payid']);
            }

            $status = 'Pago exitoso! El pago a través de PayPal se ha ralizado correctamente.';
            //return redirect('/results')->with(compact('status'));
            return redirect()->route('paypal.transactions')->withSuccess($status);
        }

        $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar.';
        //return redirect('/results')->with(compact('status'));
        return redirect()->route('paypal.transactions')->withErrors($status);
    }

    /**Formularios para mostras las transacciones  */
    public function transactions(Request $request){
        //$records = Paypal::all()->simplePaginate(25);
        $records = Paypal::orderBy('created_at','DESC')->simplePaginate(25);
        $saldo=$records->sum('total');
        $transacciones = new Transacciones();
        $unidades = $transacciones->getTotalUnidades();
        return view('paypal.transactions',compact('records','saldo','unidades'));
    }

    /**Formulario para cargar los pagos de paypal */
    public function editPayPayPal(){
        $precio= $this->precio ;
        return view('paypal.editpaypaypal',compact('precio'));
    }
}
