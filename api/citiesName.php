    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include('config.php');

      // <!-- //$query = $conexion->query("select city_name from city");-->
    $query = $conexion->query("select city_name from city order by city_name asc");

    $items = $query->fetch_all();
    $_items = [];
    $_cities = [];
    $l = 0;

    foreach ($items as $i => $item) {
        $_items[utf8_encode($item[0])][] = [];
    }

    unset($items);

    foreach ($_items as $city => $items) {
        $_cities[$l] = ['cityname' => $city];
        $l++;
    }

    //$result['names'] = $_cities;
    //$cityData[0] = $_cities;

    echo json_encode($_cities);

    exit();
    ?>

