<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    include('config.php');
try {
    $postdata = file_get_contents("php://input");

    if (isset($postdata)) {
        $request = json_decode($postdata);
        if(isset($request)){
            $countryId = $conexion->query("select id from country where country_name = '{$request[0]->country}' ")->fetch_row();
            $city = $conexion->query("select * from city where city_name = '{$request[0]->city}' ")->fetch_row();
            if(empty($city)){
                /* Validar que no existe en la base de datos*/
                //INSERT INTO `city` (`id`, `city_name`, `country_id`) VALUES (NULL, 'Puebla', '17');
                $insert = "INSERT INTO `city` (`id`, `city_name`, `country_id`) VALUES  (null, '{$request[0]->city}','$countryId[0]')";
                $result = $conexion->query($insert);
                echo json_encode([ true, "{$request[0]->city} insertado exitosamente", '']);
                exit();
            }else {
                //Si existe ya no lo agrega
                echo json_encode([ false, '', "{$request[0]->city} ya existe."]);
                exit();
            }
        }else {
            echo json_encode([ false, '', '¡ERROR! Faltan datos, intente de nuevo.']);
            exit();
        }
    }
}catch(Exception $e){
    echo json_encode([ false, '',  '¡ERROR! Faltan datos, intente de nuevo.']);
    exit();
};
exit();
?>