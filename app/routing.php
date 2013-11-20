<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

//Routing
// GET / Home
$app->get('/', function() use($app) {
    $response = $app['twig']->render('templates/index.html.twig');
    return new Response($response, 200, array('Cache-Control' => 's-maxage=3600, public'));
})->bind('index');

// GET / Admin
$app->get('/admin', function() use($app) {
    $response = $app['twig']->render('templates/admin.html.twig');
    return new Response($response, 200, array('Cache-Control' => 's-maxage=3600, public'));
})->bind('admin');

// POST /feedback
$app->post('/feedback', function () use ($app) {
    $request = $app['request'];

    $message = \Swift_Message::newInstance()
        ->setSubject('Mensaje desde la página web')
        ->setFrom($request->get('email'))
        ->setTo($request->get('email'))
        ->setBcc($app['swiftmailer.options']['username'])
        ->setBody('Hola:' . '
' . '
Nombre: ' . $request->get('nombre') . '
Telefono: ' . $request->get('telefono') . '
Email: ' . $request->get('email') . '
Escribió la siguiente consulta:' . '
' . $request->get('message') . '
' . '
Que tenga un buen dia.');

    $app['mailer']->send($message);

    return new Response('Thank you for your feedback!', 201);
})->bind('feedback');

// GET /api List
$app->get('/api/', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `estado` = '1' AND `inicio` < NOW() AND NOW() < `fin` ORDER BY `id` DESC;";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    return new Response(json_encode($noticias), 200, array('Content-Type' => 'application/json'));
});

// GET /api/{id} Show
$app->get('/api/{id}/', function($id) use ($app) {
    $sql = "SELECT * FROM `noticia` WHERE `id` = ?;";
    $noticia = $app['db']->fetchAssoc($sql, array((int) $id));
    return new Response(json_encode($noticia), 200, array('Content-Type' => 'application/json'));
});

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
        if ($key != '_method') {
            $data_mod[] = "`$key` = '$value'";
        }
    }
    $sql = "UPDATE `noticia` SET " . implode(', ', $data_mod) . " WHERE `id` = ?;";
    $affected_rows = $app['db']->executeUpdate($sql, array((int) $id));
    return new Response(json_encode($affected_rows), 200, array('Content-Type' => 'application/json'));
});

// DELETE /api/{id} Delete
$app->delete('/api/{id}/', function($id) use ($app) {
    $sql = "DELETE FROM `noticia` WHERE `id` = ?;";
    $affected_rows = $app['db']->executeUpdate($sql, array((int) $id));
    return new Response(json_encode($affected_rows), 200, array('Content-Type' => 'application/json'));
});

// PATCH /api/{id} Delete
$app->post('/api/{id}/', function($id) use ($app) {
    $sql = "UPDATE `noticia` SET `estado` = '2' WHERE `id` = ?;";
    $affected_rows = $app['db']->executeUpdate($sql, array((int) $id));
    return new Response(json_encode($affected_rows), 200, array('Content-Type' => 'application/json'));
});

// GET /api/borrador List
$app->get('/api/borrador', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `estado` = '0';";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    return new Response(json_encode($noticias), 200, array('Content-Type' => 'application/json'));
});

// GET /api/historial List
$app->get('/api/historial', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `fin` < NOW();";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    return new Response(json_encode($noticias), 200, array('Content-Type' => 'application/json'));
});
// GET /api/papelera List
$app->get('/api/papelera', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `estado` = '2';";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    return new Response(json_encode($noticias), 200, array('Content-Type' => 'application/json'));
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