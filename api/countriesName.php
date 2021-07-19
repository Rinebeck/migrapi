<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('config.php');

    $query = $conexion->query("select country_name, country.id, city_name, city.id
                                      from   country 
                                      left join city on country.id = city.country_id ORDER BY country_name ASC");

    //$qtn = $conexion->query("SELECT DISTINCT country_name FROM country");
    //$_countries = $qtn->fetch_all();

    $items = $query->fetch_all();
    $_items = [];

    foreach ($items as $i => $item) {
        $_items[utf8_encode($item[0])][] =
            ['city_name'  => utf8_encode($item[2]),
             'city_id'    => utf8_encode($item[3]),
             'country_id' => utf8_encode($item[1])];
    }
    unset($items);
    mysqli_free_result($query);
    $_countries = [];
    $l = 0;

    foreach ($_items as $country_name => $items) {
        $_countries[$l] = ['country_name' => $country_name];
        $_countries[$l]['country_id'] = $items[0]['country_id'];

        foreach ($_items[$country_name] as $i => $item) {
            $_countries[$l]['cities'][] = $item;
        }
        $l++;
    }

echo json_encode($_countries);
exit();
?>