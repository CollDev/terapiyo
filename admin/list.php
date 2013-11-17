<?php
require_once '../includes/db.php';
echo '<table class="table">'; 
echo '<tr>'; 
echo '<td><b>Id</b></td>'; 
echo '<td><b>Titulo</b></td>'; 
echo '<td><b>Contenido</b></td>'; 
echo '<td><b>Creado</b></td>'; 
echo '<td><b>Actualizado</b></td>'; 
echo '<td><b>Estado</b></td>'; 
echo '</tr>';
$result = mysql_query("SELECT * FROM `noticia`") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)) { 
    foreach($row AS $key => $value) {
        $row[$key] = stripslashes($value);
    } 
echo '<tr>';  
echo '<td valign="top">' . nl2br( $row['id']) . '</td>';  
echo '<td valign="top">' . nl2br( $row['titulo']) . '</td>';  
echo '<td valign="top">' . nl2br( $row['contenido']) . '</td>';  
echo '<td valign="top">' . nl2br( $row['creado']) . '</td>';  
echo '<td valign="top">' . nl2br( $row['actualizado']) . '</td>';  
echo '<td valign="top">' . nl2br( $row['estado']) . '</td>';  
echo '<td valign="top"><a href="edit.php?id=' . $row['id'] . '">Editar</a></td><td><a href="delete.php?id=' . $row['id'] . '">Eliminar</a></td>'; 
echo '</tr>';
} 
echo '</table>';
echo '<a href="new.php">Nueva noticia</a>';