<?php
require_once 'connect.db';
$link_identifier = mysql_connect($dbserver, $dbusername, $dbpassword);
if (!$link_identifier) exit('No se puede conectar a la base de datos.');
$selection = mysql_selectdb($database_name, $link_identifier);
if (!$selection) exit('No se puede seleccionar la base de datos.');