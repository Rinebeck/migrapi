<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('config.php');

$query = $conexion->query("select category, id, item_name, code from items");

$items = $query->fetch_all();
$_items = [];

foreach ($items as $i => $item) {
    $_items[utf8_encode($item[0])][] =
        ['item_name'      => utf8_encode($item[2]),
            'code'           => utf8_decode($item[3]),
            'id'             => utf8_encode($item[1]),
            'category'       => utf8_encode($item[0])];

}
unset($items);
mysqli_free_result($query);
$_costName = [];
$l = 0;

foreach ($_items as $category => $items) {
    $_costName[$l] = ['category' => $category];
    //$_costName[$l]['categories_id'] = utf8_encode($items[0]['categories_id']);

    foreach ($_items[$category] as $i => $item) {
        $_costName[$l]['items'][] = $item;
    }
    $l++;
}


$result['items']  = $_costName;

$cityData[0] = $result;

echo json_encode($_costName);
exit();
?>
