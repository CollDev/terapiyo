<?php
require_once '../includes/db.php';
if (isset($_GET['id']) ) { 
$id = (int) $_GET['id']; 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "UPDATE `noticia` SET  `titulo` =  '{$_POST['titulo']}' ,  `contenido` =  '{$_POST['contenido']}' ,  `creado` =  '{$_POST['creado']}' ,  `actualizado` =  '{$_POST['actualizado']}' ,  `estado` =  '{$_POST['estado']}'   WHERE `id` = '$id' "; 
mysql_query($sql) or die(mysql_error()); 
echo (mysql_affected_rows()) ? "Edited row.<br />" : "Nothing changed. <br />"; 
echo "<a href='index.php'>Back To Listing</a>"; 
} 
$row = mysql_fetch_array ( mysql_query("SELECT * FROM `noticia` WHERE `id` = '$id' ")); 
?>

<form action='' method='POST'> 
<p><b>Titulo:</b><br /><input type='text' name='titulo' value='<?= stripslashes($row['titulo']) ?>' /> 
<p><b>Contenido:</b><br /><textarea name='contenido'><?= stripslashes($row['contenido']) ?></textarea> 
<p><b>Creado:</b><br /><input type='text' name='creado' value='<?= stripslashes($row['creado']) ?>' /> 
<p><b>Actualizado:</b><br /><input type='text' name='actualizado' value='<?= stripslashes($row['actualizado']) ?>' /> 
<p><b>Estado:</b><br /><input type='text' name='estado' value='<?= stripslashes($row['estado']) ?>' /> 
<p><input type='submit' value='Edit Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 
<?php }