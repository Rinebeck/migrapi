    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include('config.php');

    $search = $_GET['search'];

    $query = $conexion->query("select city_name, city.id
                                      from country 
                                      left join city on country.id = city.country_id
                                      where country_name like '%$search%' ORDER BY city_name ASC");

    $items = $query->fetch_all();
    $_items = [];
    $_cities = [];
    $l = 0;

    foreach ($items as $i => $item) {
        $_items[utf8_encode($item[0])][] =
         ['city_id' => utf8_encode($item[1])];
    }

    unset($items);

    foreach ($_items as $city => $items) {
        $_cities[$l] = ['cityname' => $city];
        $_cities[$l]['city_id'] = $items[0]['city_id'];
        $l++;
    }

    //$result['names'] = $_cities;
    //$cityData[0] = $_cities;

    echo json_encode($_cities);

    exit();
    ?>