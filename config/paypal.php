<?php
return [
    'client_id'=>env('PAYPAL_CLIENT_ID'),
    'secret'=>env('PAYPAL_SECRET'),

    'setting'=>[
        'mode'=>env('PAYPAL_MODE','sandbox'),
        'http.Connection.TimeOut'=>30,
        'log.LogEnabled'=>true,
        'log.FileName'=>storage_path('/logs/paypal.log'),
        'log.LogLevel'=>'ERROR',
    ],

];

?>
