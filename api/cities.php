<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include('config.php');

    $search1 = $_GET['c1'];
	$search2 = $_GET['c2'];

	$query1 = $conexion->query("select  category, item_name, price, city_name
										from ((cost_city inner join items on city_items.items_id = items.id) 
														  inner join city  on city_items.city_id  = city.id) 
														  where city.city_name like '%$search1%' order by category");
	$items1 = $query1->fetch_all();

	$query2 = $conexion->query("select  category, item_name, price, city_name
										from ((cost_city inner join items on city_items.items_id = items.id) 
														  inner join city  on city_items.city_id  = city.id) 
														  where city.city_name like '%$search2%' order by category");
	$items2 = $query2->fetch_all();

	$_items = [];

	foreach ($items1 as $i => $item) {
		$_items[utf8_encode($item[0])][] = ['name' => utf8_encode($item[1]), 'price' => utf8_encode($item[2]), 'city' => utf8_encode($item[3])];
	}

    $result = [];

    $l = 0;

	foreach ($_items as $category => $items) {
		$result[$l] = ['category' => utf8_encode($category)];
		$result[$l]['city'] = utf8_encode($items[0]['city']);

		foreach ($_items[$category] as $i => $item) {
			$result[$l]['items'][] = ['name' => utf8_encode($item['name']), 'price' => utf8_encode($item['price']), 'city' => utf8_encode($item['city'])];
		}
		$l++;
	}
	$cities['c1'] = $result;
	$_items = [];

	foreach ($items2 as $i => $item) {
		$_items[utf8_encode($item[0])][] = ['name' => utf8_encode($item[1]), 'price' => utf8_encode($item[2]), 'city' => utf8_encode($item[3])];
	}
	
	$l = 0;

	foreach ($_items as $category => $items) {
		$result[$l] = ['category' => utf8_encode($category)];
		$result[$l]['city'] = utf8_encode($items[0]['city']);

		foreach ($_items[$category] as $i => $item) {
			$result[$l]['items'][] = ['name' => utf8_encode($item['name']), 'price' => utf8_encode($item['price']), 'city' => utf8_encode($item['city'])];
		}
		$l++;
	}
	$cities['c2'] = $result;
	$ciudades[0] = $cities;

	echo json_encode($ciudades);
	exit();
?>

