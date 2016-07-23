<?php

require '../../../oc-load.php';
require 'functions.php';
//$item_action = new ItemActions();
//$item_action->uploadItemResources($_FILES['photos'], 800);
//die;
$user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());

$item_array['fk_i_user_id'] = $user['pk_i_id'];
$item_array['fk_i_category_id'] = $_REQUEST['sCategory'];
$item_array['dt_pub_date'] = date("Y-m-d H:i:s");
$item_array['dt_mod_date'] = date("Y-m-d H:i:s");
$item_array['s_contact_name'] = $user['s_name'];
$item_array['s_contact_email'] = $user['s_email'];
$item_array['s_ip'] = get_ip();
$item_array['b_premium'] = 0;
$item_array['b_enabled'] = 1;
$item_array['b_active'] = 1;
$item_array['b_spam'] = 0;
$item_array['s_secret'] = osc_genRandomPassword();
$item_array['b_show_email'] = 0;
//$item_array['dt_expiration'] = '';

$item_data = new DAO();
$item_data->dao->insert(sprintf('%st_item', DB_TABLE_PREFIX), $item_array);
$item_id = $item_data->dao->insertedId();

if ($item_id) {
    $item_desc['fk_i_item_id'] = $item_id;
    $item_desc['fk_c_locale_code'] = 'en_US';
    $item_desc['s_title'] = $_REQUEST['p_title'];
    $item_desc['s_description'] = $_REQUEST['p_disc'];
    $item_data->dao->insert(sprintf('%st_item_description', DB_TABLE_PREFIX), $item_desc);

    $country = Country::newInstance()->findByCode($_REQUEST['countryId']);
    $region = Region::newInstance()->findByName($_REQUEST['s_region_name']);
    $city = City::newInstance()->findByName($_REQUEST['s_city_name'], $region['pk_i_id']);

    $item_location['fk_i_item_id'] = $item_id;
    $item_location['fk_c_country_code'] = $country['pk_c_code'];
    $item_location['s_country'] = $country['s_name'];
    $item_location['s_address'] = $_REQUEST['s_address'];
//$item_location['s_zip'] = '';
    $item_location['fk_i_region_id'] = $region['pk_i_id'];
    $item_location['s_region'] = $region['s_name'];
    $item_location['fk_i_city_id'] = $city['pk_i_id'];
    $item_location['s_city'] = $city['s_name'];
//$item_location['fk_i_city_area_id'] = '';
    $item_location['s_city_area'] = $_REQUEST['s_city_area_name'];
//$item_location['d_coord_lat'] = '';
//$item_location['d_coord_long'] = '';

    $item_data->dao->insert(sprintf('%st_item_location', DB_TABLE_PREFIX), $item_location);
    $item = Item::newInstance()->findByPrimaryKey($item_id);
    insert_geo_location($item);

    $item_action = new ItemActions();
    $item_action->uploadItemResources($_FILES['photos'], $item_id);

    osc_redirect_to(osc_base_url());
    die;
}
?>