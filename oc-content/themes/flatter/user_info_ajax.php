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
    $lat = $_REQUEST['lat'];
    $lng = $_REQUEST['lng'];
    $city = $_REQUEST['city'];
    $country = $_REQUEST['country'];
    
    /*add city and country if not exist and also insert country id and city id*/
    $result = $user_data->dao->update("{$db_prefix}t_user", array('d_coord_lat' => $lat, 'd_coord_long' => $lng, 's_city' => $city, 's_country' => $country), array('pk_i_id' => $user_id));
    if ($result):
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
        echo $user_data['role_name'];
    else:
        echo 0;
    endif;
endif;

if ($_REQUEST['action'] == 'user_type_change'):
    $user_id = $_REQUEST['user_id'];
    $user_type_value = $_REQUEST['user_type_value'];

    $db_prefix = DB_TABLE_PREFIX;
    $user_data = new DAO();
    $user_data->dao->select("user.*");
    $user_data->dao->from("{$db_prefix}t_user as user");
    $user_data->dao->where('user.pk_i_id', $user_id);
    $user_result = $user_data->dao->get();
    $user_array = $user_result->row();

    $new_user_type_value = 2;

    if ($user_type_value == '1'):
        if ($user_array['user_type'] == '0'):
            $new_user_type_value = 2;
        endif;
        if ($user_array['user_type'] == '1'):
            $new_user_type_value = 3;
        endif;
        
    elseif ($user_type_value == '0'):
        if ($user_array['user_type'] == '2'):
            $new_user_type_value = 0;
        endif;
        if ($user_array['user_type'] == '3'):
            $new_user_type_value = 1;
        endif;        
    endif;

    $result = $user_data->dao->update("{$db_prefix}t_user", array('user_type' => $new_user_type_value), array('pk_i_id' => $user_id));

    if ($result):
        echo 1;
    else:
        echo 0;
    endif;

endif;
?>