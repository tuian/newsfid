<?php

require '../../../oc-load.php';

//$conn = DBConnectionClass::newInstance();
//$data = $conn->getOsclassDb();
//$comm = new DBCommandClass($data);
//$db_prefix = DB_TABLE_PREFIX;

$ajax_function = $_REQUEST['function'];
switch ($ajax_function):
    case 'get_city' :
        $country_id = $_REQUEST['country_id'];
        get_city($country_id);
        break;
endswitch;

function get_city($country_id) {
    $conn = getConnection();
    $db_prefix = DB_TABLE_PREFIX;
    $city = $conn->osc_dbFetchResults("SELECT pk_i_id, s_name FROM {$db_prefix}t_city WHERE fk_c_country_code='{$country_id}' ORDER BY s_name ASC");
    echo json_encode($city);
}

?>