<?php
define('DB_NAME', 'digit520_bd_migrapp'); // DATABASE digit520_bd_migrapp
define('DB_USER', 'digit520_user_migra'); // ROOT DEFAULT MYSQL  
define('DB_PASSWORD', 'encTKE7zM_6V');  // PASSOWORD
define('DB_HOST', 'localhost'); // LOCAL IF YOU USE LOCAL.
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>