<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

//Routing
$app->get('/', function() use($app) {
    $response = $app['twig']->render('templates/index.html.twig');
    return new Response($response, 200, array('Cache-Control' => 's-maxage=3600, public'));
})->bind('index');

// GET  /{resource}/    List
$app->get('/api/{resource}/', function ($resource) use ($app) {
    $res = array();
    $q = mysql_query("SELECT * FROM $resource");
    while ($c = mysql_fetch_assoc($q)) { $res[] = $c; }
    return new Response(json_encode($res), 200, array('Content-Type' => 'application/json'));
});

// GET  /{resource}/{id}    Show
$app->get('/api/{resource}/{id}/', function ($resource, $id) use ($app) {
    $res = array();
    $q = mysql_query("SELECT * FROM $resource WHERE id = '$id'");
    while ($c = mysql_fetch_assoc($q)) { $res[] = $c; }
    return new Response(json_encode($res), 200, array('Content-Type' => 'application/json'));
});

// POST     /{resource}     Create
$app->post('/api/{resource}/', function ($resource, Request $request) use ($app) {
    parse_str($request->getContent(), $data);
    $query = "INSERT INTO $resource (" . implode(', ', array_keys($data)) . ") VALUES ('" . implode("', '", $data) . "')";
    mysql_query($query);
    return new Response(mysql_affected_rows(), 200);
});

// PUT  /{resource}/{id}    Update
$app->put('/api/{resource}/{id}/', function ($resource, $id, Request $request) use ($app) {
    parse_str($request->getContent(), $data);
    $data_mod = array();
    foreach ($data as $key => $value) { $data_mod[] = "$key = '$value'"; }
    $query = "UPDATE $resource SET " . implode(', ', $data_mod) . " WHERE id = $id";
    mysql_query($query);
    return new Response(mysql_affected_rows(), 200);
});

// DELETE   /{resource}/{id}    Destroy
$app->delete('/api/{resource}/{id}/', function ($resource, $id) use ($app) {
    $q = mysql_query("DELETE FROM $resource WHERE id = '$id'");
    return new Response(mysql_affected_rows(), 200);
});
//end Routing

if (!$app['debug']) {
    $app->error(function (\Exception $e, $code) use ($app) {
        if ($code == 404) {
            $response = $app['twig']->render('templates/404.html.twig');
            return new Response($response, 404);
        } else {
            $response = $app['twig']->render('templates/error.html.twig', array('code' => $code));
            return new Response($response, $code);
        }
    });
}