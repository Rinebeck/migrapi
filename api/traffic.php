<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('config.php');

    $search1 = $_GET['c1'];
    $search2 = $_GET['c2'];

    $queryTraffic = $conexion->query("select traffic_name, distance, walk, trayecto, waiting, other, city_name 
                                                        from traffic_data 	inner join city 		 on traffic_data.city_id = city.id
                                                                            inner join traffic_items on traffic_data.traffic_items_id = traffic_items.id   	
                                                                            where city.city_name like '%$search1%'");

    $queryTraffic2 = $conexion->query("select traffic_name, distance, walk, trayecto, waiting, other, city_name 
                                                        from traffic_data 	inner join city 		 on traffic_data.city_id = city.id
                                                                            inner join traffic_items on traffic_data.traffic_items_id = traffic_items.id   	
                                                                            where city.city_name like '%$search2%'");

   // $qtn = $conexion->query("SELECT DISTINCT(traffic_name) FROM traffic_items");
    //$_traffic_names = $qtn->fetch_all();

    $traffic_names = [];



    //foreach ($_traffic_names as $traffic_name){
      //  $traffic_names[] = utf8_encode($traffic_name[0]);
    //}

    $traffic = $queryTraffic->fetch_all();
    $_traffic = [];

    foreach ($traffic as $i => $traff) {

        $time = ($traff[2] + $traff[3] + $traff[4] + $traff[5]);

        $_traffic['city1'][utf8_encode($traff[0])] = [
            'city_name'    => utf8_encode($traff[6]),
            'traffic_name' => utf8_encode($traff[0]),
            'distance'     => utf8_encode($traff[1]),
            'walk'         => utf8_encode($traff[2]),
            'trayecto'     => utf8_encode($traff[3]),
            'waiting'      => utf8_encode($traff[4]),
            'other'        => utf8_encode($traff[5]),
            'time_total'   => $time,

            $traffic_names[] = utf8_encode($traff[0])
        ];
    }

    $traffic2 = $queryTraffic2->fetch_all();

    foreach ($traffic2 as $i => $traff) {

        $time = ($traff[2] + $traff[3] + $traff[4] + $traff[5]);

           $_traffic['city2'][utf8_encode($traff[0])] = [
            'city_name'    => utf8_encode($traff[6]),
            'traffic_name' => utf8_encode($traff[0]),
            'distance'     => utf8_encode($traff[1]),
            'walk'         => utf8_encode($traff[2]),
            'trayecto'     => utf8_encode($traff[3]),
            'waiting'      => utf8_encode($traff[4]),
            'other'        => utf8_encode($traff[5]),
            'time_total'   => $time,

            $traffic_names[] = utf8_encode($traff[0])
        ];
    }
    $data = [];
    $pos = 0;
    $traffic_names = array_unique($traffic_names);
    foreach ($traffic_names as $traffic_name) {

        $data[$pos]['traffic_name'] = $traffic_name;

        foreach ($_traffic as $city_key => $city) {

            if(array_key_exists($traffic_name, $city)){

                foreach ($city as $traffic){
                    if($traffic['traffic_name'] == $traffic_name){
                        $data[$pos]['items'][] = $traffic;
                    }
                }
            }/*else {
                $data[$pos]['items'][] = [
                    'city_name'    => $traffic['city_name'],
                    'traffic_name' => $traffic_name,
                    'distance'     => "",
                    'walk'         => "",
                    'trayecto'     => "",
                    'waiting'      => "",
                    'other'        => "",
                    'time_total'   => ""
                ];
            }*/
        }
        $pos++;
    }
    echo json_encode($data);
    exit();
?>

