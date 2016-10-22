<?php

require '../../../oc-load.php';
require 'functions.php';

$user_data = new DAO();
$db_prefix = DB_TABLE_PREFIX;
$user_id = osc_logged_user_id();

if ($_REQUEST['action'] == 'user_info'):
    $text = $_REQUEST['user_info_text'];
    $user_data->dao->select("user_info.*");
    $user_data->dao->from("{$db_prefix}t_user_description as user_info");
    $user_data->dao->where("user_info.fk_i_user_id", $user_id);
    $user_data->dao->limit(1);
    $user_result = $user_data->dao->get();
    $user_result_array = $user_result->row();
    if ($user_result_array):
        $result = $user_data->dao->update("{$db_prefix}t_user_description", array('s_info' => $text), array('fk_i_user_id' => $user_id));
    else:
        $reult = $user_data->dao->insert("{$db_prefix}t_user_description", array('fk_i_user_id' => $user_id, 'fk_c_locale_code' => 'en_US', 's_info' => $text));
    endif;
    if ($result):
        echo 1;
    else:
        echo 0;
    endif;
endif;


if ($_REQUEST['action'] == 'user_localisation'):    
    
    $city = $_REQUEST['city'];
    $city_id = $_REQUEST['city_id'];
    $region_code = $_REQUEST['region_code'];
    $region_name = $_REQUEST['region_name'];
    $country = $_REQUEST['country'];
    $country_code = $_REQUEST['scountry'];
 
    /*add city and country if not exist and also insert country id and city id*/
//    $user_data->dao->select("country.*");
//    $user_data->dao->from("{$db_prefix}t_country as country");
//    $user_data->dao->where('country.s_name', $country);
//    $country_result = $user_data->dao->get();
//    $country_arr = $country_result->row();
//    if(!empty($country_arr)):
//        $country_code = $country_arr['pk_c_code'];  
//    else:
//        $c_array['pk_c_code'] = $country_code;
//        $c_array['s_name'] = $country;
//        $c_array['s_slug'] = str_replace(" ", "-", strtolower($country));
//        $user_data->dao->insert("{$db_prefix}t_country", $c_array);
//    endif;
    
    
//    $result = $user_data->dao->update("{$db_prefix}t_user", array('d_coord_lat' => $lat, 'd_coord_long' => $lng, 's_city' => $city, 'fk_c_country_code' => $country_code, 's_country' => $country), array('pk_i_id' => $user_id));
    $result = $user_data->dao->update("{$db_prefix}t_user", array('s_region' => $region_name, 'fk_i_region_id' => $region_code, 's_city' => $city, 'fk_i_city_id' => $city_id, 'fk_c_country_code' => $country_code, 's_country' => $country), array('pk_i_id' => $user_id));
    if ($result):
//        $data['lat'] = $lat;
//        $data['lng'] = $lng;
//        echo json_encode($data);
        echo 1;
    else:
        echo 0;
    endif;
    
endif;

if ($_REQUEST['action'] == 'user_website'):
    $text = $_REQUEST['user_website_text'];
    $result = $user_data->dao->update("{$db_prefix}t_user", array('s_website' => $text), array('pk_i_id' => $user_id));
    if ($result):
        echo 1;
    else:
        echo 0;
    endif;
endif;

if ($_REQUEST['action'] == 'user_role'):
    $text = $_REQUEST['user_role_id'];
    $result = $user_data->dao->update("{$db_prefix}t_user", array('user_role' => $text), array('pk_i_id' => $user_id));
    if ($result):
        $user_data = get_user_data($user_id);
        echo $user_data['role_name_eng'];
    else:
        echo 0;
    endif;
endif;

if ($_REQUEST['action'] == 'user_type_change'):
    $user_id = $_REQUEST['user_id'];
    $new_user_type_value = $_REQUEST['user_type_value'];

//    $db_prefix = DB_TABLE_PREFIX;
//    $user_data = new DAO();
//    $user_data->dao->select("user.*");
//    $user_data->dao->from("{$db_prefix}t_user as user");
//    $user_data->dao->where('user.pk_i_id', $user_id);
//    $user_result = $user_data->dao->get();
//    $user_array = $user_result->row();
//
//    $new_user_type_value = 2;
//
//    if ($user_type_value == '1'):
//        if ($user_array['user_type'] == '0'):
//            $new_user_type_value = 2;
//        endif;
//        if ($user_array['user_type'] == '1'):
//            $new_user_type_value = 3;
//        endif;
//        
//    elseif ($user_type_value == '0'):
//        if ($user_array['user_type'] == '2'):
//            $new_user_type_value = 0;
//        endif;
//        if ($user_array['user_type'] == '3'):
//            $new_user_type_value = 1;
//        endif;        
//    endif;

    $result = $user_data->dao->update("{$db_prefix}t_user", array('user_type' => $new_user_type_value), array('pk_i_id' => $user_id));

    if ($result):
        echo 1;
    else:
        echo 0;
    endif;

endif;
?>