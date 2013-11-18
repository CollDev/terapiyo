<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

//Routing
// GET / Home
$app->get('/', function() use($app) {
    $response = $app['twig']->render('templates/index.html.twig');
    return new Response($response, 200, array('Cache-Control' => 's-maxage=3600, public'));
})->bind('index');

// GET /api List
$app->get('/api/', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `estado` = '1' AND `inicio` < NOW() AND NOW() < `fin`;";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    return new Response(json_encode($noticias), 200, array('Content-Type' => 'application/json'));
})->bind('list');

// GET /api/{id} Show
$app->get('/api/{id}/', function($id) use ($app) {
    $sql = "SELECT * FROM `noticia` WHERE `id` = ?;";
    $noticia = $app['db']->fetchAssoc($sql, array((int) $id));
    return new Response(json_encode($noticia), 200, array('Content-Type' => 'application/json'));
})->bind('show');

// POST /api Create
$app->post('/api/', function(Request $request) use ($app) {
    parse_str($request->getContent(), $data);
    $sql = "INSERT INTO `noticia` (`creado`, " . implode(', ', array_keys($data)) . ") VALUES (NOW(), '" . implode("', '", $data) . "');";
    $affected_rows = $app['db']->executeUpdate($sql);
    return new Response(json_encode($affected_rows), 200, array('Content-Type' => 'application/json'));
})->bind('create');

// PUT /api/{id} Update
$app->put('/api/{id}/', function($id, Request $request) use ($app) {
    parse_str($request->getContent(), $data);
    $data_mod = array();
    foreach ($data as $key => $value) {
        $data_mod[] = "`$key` = '$value'";
    }
    $sql = "UPDATE `noticia` SET " . implode(', ', $data_mod) . " WHERE `id` = ?;";
    $affected_rows = $app['db']->executeUpdate($sql, array((int) $id));
    return new Response(json_encode($affected_rows), 200, array('Content-Type' => 'application/json'));
})->bind('update');

// DELETE /api/{id} Delete
$app->delete('/api/{id}/', function($id) use ($app) {
    $sql = "DELETE FROM `noticia` WHERE `id` = ?;";
    $affected_rows = $app['db']->executeUpdate($sql, array((int) $id));
    return new Response(json_encode($affected_rows), 200, array('Content-Type' => 'application/json'));
})->bind('delete');

// GET /api/borrador List
$app->get('/api/borrador', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `estado` = '0';";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    return new Response(json_encode($noticias), 200, array('Content-Type' => 'application/json'));
})->bind('borrador');

// GET /api/historial List
$app->get('/api/historial', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `fin` < NOW();";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    return new Response(json_encode($noticias), 200, array('Content-Type' => 'application/json'));
})->bind('historial');
// GET /api/papelera List
$app->get('/api/papelera', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `estado` = '2';";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    return new Response(json_encode($noticias), 200, array('Content-Type' => 'application/json'));
})->bind('papelera');

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