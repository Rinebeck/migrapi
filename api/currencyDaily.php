<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('config.php');

$XML=simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");

foreach($XML->Cube->Cube->Cube as $rate){

    //echo '1 euro='.$rate["rate"]. $rate["currency"];
    $query = $conexion->query("update currency set eur_change = {$rate["rate"]} where code = '{$rate["currency"]}'");

    if(!$query){
        $log = $conexion->error;
        file_put_contents('./logs/log_'.date("j.n.Y").'.log', $log."\n", FILE_APPEND);
    }
}

exit();
?>