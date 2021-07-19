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
            $request = $request[0];

            if(isset($request->city) && isset($request->type) && isset($request->values) ){

                $cityId = $conexion->query("select id from city  where city_name = '{$request->city}'")->fetch_row();
                $trafficId = $conexion->query("select id  from traffic_items  where traffic_name = '{$request->type}'")->fetch_row();
            }else{
                echo json_encode([ false, '', '¡ERROR! Faltan datos, intente de nuevo.']);
                exit();
            }
            $insert = "INSERT INTO `traffic_data` VALUES (NULL, ";
            $total_values = count((array)$request->values);

            foreach ($request->values as $item_id => $value) {
                $value = !$value ? "NULL" : $value;
                $insert .= "$value , " ;
            }
            $insert .= $trafficId[0].", " .$cityId[0].")";
            $result = $conexion->query($insert);
            echo json_encode([ true, 'Datos ingresados exitosamente', '']);
        }

    } catch(Exception $e){
            $response = [0 => $result, 1 => $e->getMessage()];
            echo json_encode([ false, '', '¡ERROR! Faltan datos, intente de nuevo.']);
    };

exit();
?>