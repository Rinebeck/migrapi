<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('config.php');

// <!-- //$query = $conexion->query("select city_name from city");-->
$query = $conexion->query("select id, code, currency, eur_change  from currency order by currency asc");

$items = $query->fetch_all();
$_items = [];
$_currencies = [];
$l = 0;

foreach ($items as $i => $item) {

    $_items[utf8_encode($item[0])][] =
        ['id'       => utf8_encode($item[0]),
         'code'     => utf8_encode($item[1]),
         'currency' => utf8_encode($item[2]),
         'change'   => utf8_encode($item[3])];
}

unset($items);

foreach ($_items as $data => $items) {
    $items = $items[0];
    $_currencies[$l] = ['id' => $items['id'], 'code' => $items['code'], 'currency' => $items['currency'], 'change' => $items['change']];
    $l++;
}

echo json_encode($_currencies);

exit();
?>

