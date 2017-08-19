<?php

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