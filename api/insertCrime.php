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
        $request->city;
        $request->datas;

        /*Valores de los radio buttons,
        1 => Muy seguro
        2 => Moderadamente seguro
        3 => Neutral
        4 => Poco Seguro
        5 => Muy inseguro*/

        if(isset($request->city) && isset($request->datas) ){
            foreach ($request->datas as $radio) {
                if(!$radio) {
                    echo json_encode([ false, '', '¡ERROR! Faltan datos, intente de nuevo.']);
                    exit();
                }
            };
            $cityId = $conexion->query("select city.id city_id from city  where city_name = '{$request->city}'")->fetch_row();
            $values = [ 1 => 100, 2 => 80, 3 => 50, 4 => 40, 5 => 20];

            $insert = "INSERT INTO `crime_city` (`level_crime`, `crime_increasing`, `mugged`, `home_broken`,
                               `car_stolen`, `things_car`, `attacked`, `insulted`, `racism`, `drugs`,
                               `property_crimes`,`violent_crimes`, `corruption`, `safe_daylight`, `safe_night`, 
                               `city_id`) VALUES (";

            $total = count($request->datas);
            foreach ($request->datas as $idx => $radio){
                $insert .= $values[$radio->value];
                if($idx+1 < $total){
                    $insert .= ", ";
                }
            }
            $insert.=", ".$cityId[0].")";
            $crime = $conexion->query($insert);

            if($crime){
                echo json_encode([ $crime, 'Datos ingresados exitosamente', '']);
            }else{
                echo json_encode([ $crime, '',  '¡ERROR! Faltan datos, intente de nuevo.']);
            }
        }

        }else{
            echo json_encode([ false, '',  '¡ERROR! Faltan datos, intente de nuevo.']);
            exit();
        }
    } catch(Exception $e){
        $crime = [0 => $result, 1 => $e->getMessage()];
        echo json_encode([ false, '', '¡ERROR! Faltan datos, intente de nuevo.']);
    };
exit();
?>