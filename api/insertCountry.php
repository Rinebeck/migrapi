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
            /* Validar que no existe en la base de datos*/
            //SELECT * FROM `country` WHERE country_name = 'Mexico'
            $country = $conexion->query("select * from country where country_name = '{$request}' ")->fetch_row();
            if(empty($country)){
                $insert = "INSERT INTO `country` (`country_name`) VALUES  ('{$request}')";
                $result = $conexion->query($insert);
                echo json_encode([ true, "{$request} insertado exitosamente", '']);
                exit();
            }else {
                //Si existe ya no lo agrega
                echo json_encode([ false, "{$request} ya existe."]);
                exit();
            }
        }else {
            echo json_encode([ false,'', '¡ERROR! Faltan datos, intente de nuevo.']);
            exit();
        }
    }

}catch(Exception $e){
    $result = [0 => $result, 1 => $e->getMessage()];
    echo json_encode([ false,'', '¡ERROR! Faltan datos, intente de nuevo.']);
    };
exit();
?>