<?php
if (!empty($_GET)) {
    if (isset($_GET['course'])) {
        header("Content-Type: application/json; charset=utf-8");
        echo (require_once $_GET['course'] . '.json');
    }
} elseif (!empty($_POST)) {
    if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['comentario'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $comentario = $_POST['comentario'];

        if ($nombre != '' && $email != '' && $comentario != '') {
            $nameRegex    = '/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/';
            $phoneRegex   = '/[0-9-()+]{3,20}/';
            $emailRegex   = '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/';
            if (preg_match($nameRegex, $nombre) == 0)
                $return = array('responseCode' => 400, 'response' => 'Ha ingresado un nombre no válido.');
            elseif (preg_match($emailRegex, $email) == 0)
                $return = array('responseCode' => 400, 'response' => 'Ha ingresado un email no válido.');
            elseif (isset($_POST['telefono']) && $_POST['telefono'] != '' && preg_match($phoneRegex, $_POST['telefono']) == 0)
                $return = array('responseCode' => 400, 'response' => 'Ha ingresado un teléfono no válido.');
            else {
                $apellidos = isset($_POST['apellidos']) ? "'" . $_POST['apellidos'] . "'" : NULL;
                $telefono  = isset($_POST['telefono']) ? "'" . $_POST['telefono'] . "'" : NULL;
                $direccion = isset($_POST['direccion']) ? "'" . $_POST['direccion'] . "'" : NULL;
                //enviar el correo
                require_once 'eml.php';
                $message = Swift_Message::newInstance()
                    ->setSubject('Mensaje desde la página web')
                    ->setFrom($email)
                    ->setTo($email)
                    //->setBcc($emlusername)
                    ->setBody('Hola:' . '
' . '
Nombre: ' . $nombre . '
Apellidos: ' . $apellidos . '
Telefono: ' . $telefono . '
Dirección: ' . $direccion . '
Email: ' . $email . '
Escribió el siguiente comentario:' . '
' . $comentario . '
' . '
Que tenga un buen dia.')
                    ;
                $sent = $mailer->send($message);
                //guardar en la base de datos
                require_once 'db.php';
                $query = "INSERT INTO `correos` (
                            `id`,
                            `nombre`,
                            `apellidos`,
                            `telefono`,
                            `direccion`,
                            `email`,
                            `comentario`,
                            `creado`,
                            `estado`
                          ) VALUES (
                            NULL,
                            '". $nombre . "',
                            " . $apellidos . ",
                            " . $telefono . ",
                            " . $direccion . ",
                            '". $email . "',
                            '". $comentario . "',
                            NOW(),
                            '". $sent . "'
                          );";
                $inserted = mysql_query($query);
                if ($sent && $inserted)
                    $return = array('responseCode' => 200, 'response' => 'Comentario enviado y almacenado.');
                else if ($sent)
                    $return = array('responseCode' => 200, 'response' => 'Comentario enviado.');
                else if ($inserted)
                    $return = array('responseCode' => 200, 'response' => 'Comentario almacenado.');
                else
                    $return = array('responseCode' => 400, 'response' => 'No se pudo enviar, intente más tarde.');
            }
        } else {
            if ($nombre == '')
                $return = array('responseCode' => 400, 'response' => 'Debe ingresar su nombre.');
            elseif ($email == '')
                $return = array('responseCode' => 400, 'response' => 'Debe ingresar su correo electrónico.');
            elseif ($comentario == '')
                $return = array('responseCode' => 400, 'response' => 'Debe ingresar un comentario.');
        }
    } else {
        $return = array('responseCode' => 400, 'response' => 'Debe usar el formulario de contácto de la página web.');
    }
    echo json_encode($return);
} else {
    echo 'No esta permitido a esta sección.';
}