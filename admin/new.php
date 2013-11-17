<?php
require_once '../includes/db.php';
if (isset($_POST['submitted'])) {
    foreach($_POST AS $key => $value) {
        $_POST[$key] = mysql_real_escape_string($value);
    }
    $sql = "INSERT INTO `noticia` ( `titulo` ,  `contenido` ,  `creado` ,  `actualizado` ,  `estado`  ) VALUES(  '{$_POST['titulo']}' ,  '{$_POST['contenido']}' ,  '{$_POST['creado']}' ,  '{$_POST['actualizado']}' ,  '{$_POST['estado']}'  ) ";
    mysql_query($sql) or die(mysql_error());
    echo 'Noticia agregada.<br />';
    echo '<a href="index.php">Regresar al listado</a>';
}
?>
<form action="" method="POST">
    <p><b>Titulo:</b><br /><input type="text" name="titulo">
    <p><b>Contenido:</b><br /><textarea name="contenido"></textarea>
    <p><b>Creado:</b><br /><input type="text" name="creado">
    <p><b>Actualizado:</b><br /><input type="text" name="actualizado">
    <p><b>Estado:</b><br /><input type="text" name="estado"/>
    <p><input type="submit" value="Add Row" /><input type="hidden" value="1" name="submitted">
</form>
