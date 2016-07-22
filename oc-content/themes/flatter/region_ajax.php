<?php

require '../../../oc-load.php';

//$conn = DBConnectionClass::newInstance();
//$data = $conn->getOsclassDb();
//$comm = new DBCommandClass($data);
//$db_prefix = DB_TABLE_PREFIX;


$country_id = $_REQUEST['country_id'];
$region_name = $_REQUEST['region_name'];
$conn = getConnection();
$db_prefix = DB_TABLE_PREFIX;
$region = $conn->osc_dbFetchResults("SELECT pk_i_id, s_name FROM {$db_prefix}t_region WHERE fk_c_country_code='{$country_id}' ORDER BY s_name ASC");
echo json_encode($region);
//echo json_encode($_REQUEST);
?>