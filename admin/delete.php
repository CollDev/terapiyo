<?php
require_once '../includes/db.php';
$id = (int) $_GET['id']; 
mysql_query("DELETE FROM `noticia` WHERE `id` = '$id' ") ; 
echo (mysql_affected_rows()) ? "Noticia eliminada.<br /> " : "Nada ha sido eliminado.<br /> "; 
?> 

<a href="index.php">Regresar al listado</a>