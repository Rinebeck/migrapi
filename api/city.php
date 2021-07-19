<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('config.php');

$search = $_GET['search'];

/*COSTO DE VIDA*/
$queryCost = $conexion->query("select  category, item_name, price, city_name
											from ((cost_city inner join items on cost_city.items_id = items.id) 
														  	  inner join city  on cost_city.city_id  = city.id) 
														  	  where city.city_name like '%$search%' order by category");
$items = $queryCost->fetch_all();
$_items = [];

foreach ($items as $i => $item) {
	$_items[utf8_encode($item[0])][] = ['name'  => utf8_encode($item[1]),
		'price' => utf8_encode($item[2]),
		'city'  => utf8_encode($item[3])];
}
unset($items);
mysqli_free_result($queryCost);
$_cost = [];
$l = 0;

foreach ($_items as $category => $items) {
	$_cost[$l] = ['category' => $category];
	$_cost[$l]['city'] = utf8_encode($items[0]['city']);

	foreach ($_items[$category] as $i => $item) {
		$_cost[$l]['items'][] = $item;
	}
	$l++;
}

/*CRIMINALIDAD*/
$queryCrime = $conexion->query("select *
 										   from crime_city 
										   inner join city on crime_city.city_id = city.id
										   where city.city_name like '%$search%'");
$crimes = $queryCrime->fetch_all();
//$_crime = [][];

foreach ($crimes as $i => $crime) {
	//['items'][] = $item;
	$_crime[] = ['id' => utf8_encode($crime[0]),
		'crime_increasing' => utf8_encode($crime[1]),
		'car_stolen' => utf8_encode($crime[2]),
		'things_car' => utf8_encode($crime[3]),
		'safe_night' => utf8_encode($crime[4]),
		'safe_daylight' => utf8_encode($crime[5]),
		'mugged' => utf8_encode($crime[6]),
		'insulted' => utf8_encode($crime[7]),
		'violent_crimes' => utf8_encode($crime[8]),
		'level_crime' => utf8_encode($crime[9]),
		'drugs' => utf8_encode($crime[10]),
		'racism' => utf8_encode($crime[11]),
		'corruption' => utf8_encode($crime[12]),
		'property_crimes' => utf8_encode($crime[13]),
		'home_broken' => utf8_encode($crime[14]),
		'attacked' => utf8_encode($crime[15]),
		'city_id' => utf8_encode($crime[16]),
		'city_name' => utf8_encode($crime[18])];
}


/*SANIDAD*/
$queryHealth = $conexion->query("select * from healthcare_city 
													 inner join city on healthcare_city.city_id = city.id
													 where city.city_name like '%$search%'");
$healthcare = $queryHealth->fetch_all();
$_health = [];

foreach ($healthcare as $i => $health) {
	$_health[] = ['id' => utf8_encode($health[0]),
		'location' => utf8_encode($health[1]),
		'speed' => utf8_encode($health[2]),
		'equipment' => utf8_encode($health[3]),
		'accuracy' => utf8_encode($health[4]),
		'cost' => utf8_encode($health[5]),
		'friendliness' => utf8_encode($health[6]),
		'waitings' => utf8_encode($health[7]),
		'skill' => utf8_encode($health[8]),
		'city_id' => utf8_encode($health[9]),
		'city_name' => utf8_encode($health[11])];
}
/*POLLUTION*/
$queryPollution = $conexion->query("select * from pollution_city 
														inner join city on pollution_city.city_id = city.id
														where city.city_name like '%$search%'");
$pollution = $queryPollution->fetch_all();
$_pollution = [];

foreach ($pollution as $i => $polli) {
	$_pollution[] = ['air_quality' => utf8_encode($polli[1]),
		'water_drinking' => utf8_encode($polli[2]),
		'water_pollution' => utf8_encode($polli[3]),
		'garbage' => utf8_encode($polli[4]),
		'noise_light' => utf8_encode($polli[5]),
		'clean' => utf8_encode($polli[6]),
		'comfortable' => utf8_encode($polli[7]),
		'parks' => utf8_encode($polli[8]),
		'city_name' => utf8_encode($polli[11]),];
}
/*TRAFICO*/
$queryTraffic = $conexion->query("select traffic_name, distance, walk, trayecto, waiting, other, city_name 
													from traffic_data 	inner join city 		 on traffic_data.city_id = city.id
													  	   				inner join traffic_items on traffic_data.traffic_items_id = traffic_items.id   	
																		where city.city_name like '%$search%'");

$traffic = $queryTraffic->fetch_all();
$_traffic = [];
foreach ($traffic as $i => $traff) {

	$time = ($traff[2] + $traff[3] + $traff[4] + $traff[5]);

	$_traffic[] = ['traffic_name' => utf8_encode($traff[0]),
		'distance'     => utf8_encode($traff[1]),
		'walk'         => utf8_encode($traff[2]),
		'trayecto'     => utf8_encode($traff[3]),
		'waiting'      => utf8_encode($traff[4]),
		'other'        => utf8_encode($traff[5]),
		'city_name'    => utf8_encode($traff[6]),
		'time_total'   => $time];
}

$result['cost']      = $_cost;
$result['crime']     = $_crime;
$result['health']    = $_health;
$result['pollution'] = $_pollution;
$result['traffic']   = $_traffic;

$cityData[0] = $result;

//echo json_encode($_cost);
//	//echo json_encode($_crime);
//	//echo json_encode($_health);
//	//echo json_encode($_pollution);
//	//echo json_encode($_traffic);
echo json_encode($cityData);

exit();
?>

