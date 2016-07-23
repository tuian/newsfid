<?php

require '../../../oc-load.php';
require 'functions.php';

$country_id = $_REQUEST['country_id'];
$city_name = $_REQUEST['city_name'];
$db_prefix = DB_TABLE_PREFIX;
$city_data = new DAO();
$city_data->dao->select("city.pk_i_id, city.s_name");
$city_data->dao->from("{$db_prefix}t_city as city");
$city_data->dao->where("city.s_name LIKE '{$city_name}%' ");
$city_data->dao->where("city.fk_c_country_code", $country_id);
$city_data->dao->orderBy("city.s_name ASC");
$city_array = $city_data->dao->get();
$city_result = $city_array->result();
echo json_encode($city_result);
?>