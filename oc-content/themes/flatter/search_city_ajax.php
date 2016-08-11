<?php

require '../../../oc-load.php';
require 'functions.php';

$city_name = $_REQUEST['city_name'];
$region_name = $_REQUEST['region_name'];
$country_name = $_REQUEST['country_name'];
$db_prefix = DB_TABLE_PREFIX;
$city_data = new DAO();
$city_data->dao->select("city.pk_i_id as city_id, city.s_name as city_name, country.s_name as country_name, country.pk_c_code as country_code, region.s_name as region_name, region.pk_i_id as r_id");
$city_data->dao->from("{$db_prefix}t_city as city");
$city_data->dao->join("{$db_prefix}t_country as country", 'country.pk_c_code = city.fk_c_country_code', 'INNER');
$city_data->dao->join("{$db_prefix}t_region as region", 'region.pk_i_id = city.fk_i_region_id', 'INNER');
$city_data->dao->where("city.s_name LIKE '{$city_name}%' || region.s_name LIKE '{$region_name}%' || country.s_name LIKE '{$country_name}%' ");
$city_data->dao->orderBy("city.s_name || region.s_name || country.s_name ASC");
$city_array = $city_data->dao->get();
$city_result = $city_array->result();
echo json_encode($city_result);
?>