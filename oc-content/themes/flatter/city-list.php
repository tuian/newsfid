<?php

require '../../../oc-load.php';

//$conn = DBConnectionClass::newInstance();
//$data = $conn->getOsclassDb();
//$comm = new DBCommandClass($data);
//$db_prefix = DB_TABLE_PREFIX;


$region_id = $_REQUEST['region_id'];
$city_name = $_REQUEST['city_name'];
$conn = getConnection();
$db_prefix = DB_TABLE_PREFIX;
$city = $conn->osc_dbFetchResults("SELECT pk_i_id, s_name FROM {$db_prefix}t_city WHERE fk_i_region_id='{$region_id}' ORDER BY s_name ASC");
echo json_encode($city);
//echo json_encode($_REQUEST);
?>