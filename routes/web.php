<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get('/location', function () use ($app) {
    $results = app('db')->select("SELECT * FROM location");
    return response()->json(($results));
});
    
$app->get('/location/{id}', function ($id) use ($app) {
    $results = app('db')->select('SELECT * FROM location WHERE id = :id', ['id' => $id]);
    if (!$results) {
        return '{"errors":[{"msg":"No results"}]}';
    }
    return response()->json(json_decode('{"data":'.json_encode($results[0]).'}'));
});
    
$app->get('/location/{id_location}/product', function ($id_location) use ($app) {
    $results = app('db')->select('SELECT * FROM product WHERE id_location = :id_location', ['id_location' => $id_location]);
    if (!$results) {
        return response()->json(json_decode('{"errors":[{"msg":"No results"}]}'));
    }
    return response()->json(json_decode('{"data":'.json_encode($results).'}'));
});

$app->get('/location/{id_location}/product', function ($id_location) use ($app) {
    $results = app('db')->select('SELECT * FROM product WHERE id_location = :id_location', ['id_location' => $id_location]);
    if (!$results) {
        return response()->json(json_decode('{"errors":[{"msg":"No results"}]}'));
    }
    return response()->json(json_decode('{"data":'.json_encode($results).'}'));
});

$app->get('/location/{id_location}/product/{id}', function ($id_location, $id) use ($app) {
    $results = app('db')->select('SELECT * FROM product WHERE id_location = :id_location AND id = :id', ['id_location' => $id_location, 'id' => $id]);
    if (!$results) {
        return response()->json(json_decode('{"errors":[{"msg":"No results"}]}'));
    }
    return response()->json(json_decode('{"data":'.json_encode($results).'}'));
});

$app->post('/charge', function(\Illuminate\Http\Request $request) {
    $request->get('');
    $res = json_decode($request->getContent());
    $date = explode('/', $res->exp_date);
    
    $opts = array(
        'http'=>array(
            'method'=>'POST',
            'header' => 'Authorization: Basic '.base64_encode('sk_kjhkjhkjhkjhk:')."\r\n".
                        "Content-Type: application/json\r\n",
            'content' => '{
                            "number": "'.$res->number.'",
                            "holder_name": "'.$res->holder_name.'",
                            "exp_month": '.(int)$date[0].',
                            "exp_year": '.(int)$date[1].',
                            "cvv": "'.$res->cvv.'",
                            "billing_address": {
                                "street": "Malibu Point",
                                "number": "10880",
                                "zip_code": "90265",
                                "neighborhood": "Central Malibu",
                                "city": "Malibu",
                                "state": "CA",
                                "country": "US"
                            },
                            "options": {
                              "verify_card": true
                            }
                        }'
        )
    );
    $context = stream_context_create($opts);
    $result = file_get_contents('https://api.mundipagg.com/core/v1/customers/cus_dfgdgdfgdfg/cards', false, $context, -1, 40000);
    return '';
});

$app->get('/customer/{id}/cards', function() {
    return response()->json(json_decode('{
    "data": [
        {
            "id": "card_hgjhsgfjsdfkjsdfsd",
            "first_six_digits": "542501",
            "last_four_digits": "7793",
            "brand": "Mastercard",
            "holder_name": "Tony Stark",
            "exp_month": 1,
            "exp_year": 2018,
            "status": "active",
            "created_at": "2017-08-19T19:10:57Z",
            "updated_at": "2017-08-19T19:10:57Z",
            "billing_address": {
                "street": "Malibu Point",
                "number": "10880",
                "zip_code": "90265",
                "neighborhood": "Central Malibu",
                "city": "Malibu",
                "state": "CA",
                "country": "US"
            },
            "type": "credit"
        }
    ],
    "paging": {
        "total": 1
    }
}'));
});