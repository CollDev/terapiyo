<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

//Routing
// GET / Home
$app->get('/', function() use($app) {
    $response = $app['twig']->render('templates/index.html.twig');
    return new Response($response, 200, array('Cache-Control' => 's-maxage=3600, public'));
})->bind('index');

// GET /admin Admin
$app->get('/admin', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `estado` = '1' AND `inicio` < NOW() AND NOW() < `fin` ORDER BY `id` DESC;";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    $response = $app['twig']->render('templates/admin.html.twig', array('noticias' => $noticias));
    return new Response($response, 200, array('Cache-Control' => 's-maxage=3600, public'));
})->bind('admin');

// GET /admin Admin
$app->get('/admin/borrador', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `estado` = '0';";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    $response = $app['twig']->render('templates/borrador.html.twig', array('noticias' => $noticias));
    
    return new Response($response, 200, array('Cache-Control' => 's-maxage=3600, public'));
})->bind('borrador');

// GET /programadas Programadas
$app->get('/admin/programadas', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `inicio` > NOW() ORDER BY `id` DESC;";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    $response = $app['twig']->render('templates/programadas.html.twig', array('noticias' => $noticias));
    
    return new Response($response, 200, array('Cache-Control' => 's-maxage=3600, public'));
})->bind('programadas');

// GET /admin Admin
$app->get('/admin/papelera', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `estado` = '2';";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    $response = $app['twig']->render('templates/papelera.html.twig', array('noticias' => $noticias));
    
    return new Response($response, 200, array('Cache-Control' => 's-maxage=3600, public'));
})->bind('papelera');

// GET /admin Admin
$app->get('/admin/historial', function() use($app) {
    $sql = "SELECT * FROM `noticia` WHERE `fin` < NOW();";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $noticias = $statement->fetchAll();
    $response = $app['twig']->render('templates/historial.html.twig', array('noticias' => $noticias));
    
    return new Response($response, 200, array('Cache-Control' => 's-maxage=3600, public'));
})->bind('historial');

// GET /consultas Consultas
$app->get('/admin/consultas', function() use($app) {
    $sql = "SELECT * FROM `correo` WHERE `estado` = '0' OR `estado` = '1' ORDER BY `id` DESC;";
    $statement = $app['db']->prepare($sql);
    $statement->execute();
    $consultas = $statement->fetchAll();
    $response = $app['twig']->render('templates/consultas.html.twig', array('consultas' => $consultas));
    
    return new Response($response, 200, array('Cache-Control' => 's-maxage=3600, public'));
})->bind('consultas');

// POST /feedback
$app->post('/feedback', function(Request $request) use($app) {
    parse_str($request->getContent(), $data);
    if ($data['nombre'] != '' && $data['email'] != '' && $data['consulta'] != '') {
        $nombre = $data['nombre'];
        $email = $data['email'];
        $consulta = $data['consulta'];
        $telefono  = $data['telefono'] != '' ? $data['telefono'] : NULL;

        if ($nombre != '' && $email != '' && $consulta != '') {
            $nameRegex    = '/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/';
            $phoneRegex   = '/[0-9-()+]{3,20}/';
            $emailRegex   = '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/';
            if (preg_match($nameRegex, $nombre) == 0) {
                $return = array('responseCode' => 400, 'response' => 'Ha ingresado un nombre no válido.');
            } elseif (preg_match($emailRegex, $email) == 0) {
                $return = array('responseCode' => 400, 'response' => 'Ha ingresado un email no válido.');
            } elseif ($telefono != null && preg_match($phoneRegex, $telefono) == 0) {
                $return = array('responseCode' => 400, 'response' => 'Ha ingresado un teléfono no válido.');
            } else {
                $message = \Swift_Message::newInstance()
                    ->setSubject($app['settings']['mailer']['subject'])
                    ->setFrom($email)
                    ->setTo($app['swiftmailer.options']['username'])
                    ->setBcc($email)
                    ->setBody(sprintf($app['settings']['mailer']['body'], $nombre, $email, $telefono, $consulta), 'text/html');

                $sent = $app['mailer']->send($message);
                
                //guardar en la base de datos
                $sql = "INSERT INTO `correo` (`creado`, `estado`, " . implode(', ', array_keys($data)) . ") VALUES (NOW(), '0', '" . implode("', '", $data) . "');";
                $inserted = $app['db']->executeUpdate($sql);
                
                if ($sent && $inserted) {
                    $return = array('responseCode' => 200, 'response' => 'Consulta enviada y almacenada.');
                } else if ($sent) {
                    $return = array('responseCode' => 200, 'response' => 'Consulta enviada.');
                } else if ($inserted) {
                    $return = array('responseCode' => 200, 'response' => 'Consulta almacenada.');
                } else {
                    $return = array('responseCode' => 400, 'response' => 'No se pudo enviar, intente más tarde.');
                }
            }
        } else {
            if ($nombre == '') {
                $return = array('responseCode' => 400, 'response' => 'Debe ingresar su nombre.');
            } elseif ($email == '') {
                $return = array('responseCode' => 400, 'response' => 'Debe ingresar su correo electrónico.');
            } elseif ($consulta == '') {
                $return = array('responseCode' => 400, 'response' => 'Debe ingresar una consulta.');
            }
        }
    } else {
        $return = array('responseCode' => 400, 'response' => 'Debe usar el formulario de contácto de la página web.');
    }
    return new Response(json_encode($return), 200, array('Content-Type' => 'application/json'));
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

// PATCH /api/recuperar/{id} Delete
$app->post('/api/recuperar/{id}/', function($id) use ($app) {
    $sql = "UPDATE `noticia` SET `estado` = '0' WHERE `id` = ?;";
    $affected_rows = $app['db']->executeUpdate($sql, array((int) $id));
    return new Response(json_encode($affected_rows), 200, array('Content-Type' => 'application/json'));
});

// GET /api/consulta/{id} Show
$app->get('/api/consulta/{id}/', function($id) use ($app) {
    $update = "UPDATE `correo` SET `estado` = '1' WHERE `id` = ?;";
    $app['db']->executeUpdate($update, array((int) $id));
    
    $sql = "SELECT * FROM `correo` WHERE `id` = ?;";
    $noticia = $app['db']->fetchAssoc($sql, array((int) $id));

    return new Response(json_encode($noticia), 200, array('Content-Type' => 'application/json'));
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