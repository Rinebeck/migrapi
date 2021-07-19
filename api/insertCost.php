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

        if (isset($request)) {

            $cityId = $conexion->query("select id from city where city_name = '{$request->city}'")->fetch_row();
            $currencyId = $conexion->query("select id from currency  where code     = '{$request->currency}'")->fetch_row();
            $change = $conexion->query("select eur_change from currency  where code  = '{$request->currency}'")->fetch_row();
            //INSERT INTO `cost_city` (`id`, `city_id`, `price`, `currency_id`, `items_id`) VALUES (NULL, '22', '619.02', '26', '1');
            $insert = "INSERT INTO `cost_city` VALUES";
            $total_values = count((array)$request->values);
            foreach ($request->values as $item_id => $value) {

                $value = !$value ? "NULL" : floatval($value) / $change[0];

                $insert .= "(NULL, " . $cityId[0] . ", " . $value . ", " . 35 . ", " . $item_id . ")";
                if (intval($item_id) != $total_values) {
                    $insert .= ", ";
                }
            }
            $result = $conexion->query($insert);

            if ($result) {
                echo json_encode([true, "Insertado exitosamente", '']);
            } else {
                echo json_encode([false, '', '¡ERROR! No se inserto, intente de nuevo']);
            }
        }
    }else {
        echo json_encode([ false, '', '¡ERROR! Faltan datos, intente de nuevo.']);
        exit();
    }
}catch(Exception $e){
    echo json_encode([ false, '',  '¡ERROR! Faltan datos, intente de nuevo.']);
    exit();
};
exit();
?>