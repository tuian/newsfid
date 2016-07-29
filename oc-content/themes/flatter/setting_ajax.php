<?php

require '../../../oc-load.php';
require 'functions.php';

$user_data = new DAO();
$db_prefix = DB_TABLE_PREFIX;
$user_id = osc_logged_user_id();

if ($_REQUEST['action'] == 'user_name'):
    $text = $_REQUEST['up_name'];
    $result = $user_data->dao->update("{$db_prefix}t_user", array('s_name' => $text), array('pk_i_id' => $user_id));
    if ($result):
        echo 1;
    else:
        echo 0;
    endif;
endif;

if ($_REQUEST['action'] == 's_email'):
    $text = $_REQUEST['up_email'];
    $result = $user_data->dao->update("{$db_prefix}t_user", array('s_email' => $text), array('pk_i_id' => $user_id));
    if ($result):
        echo 1;
    else:
        echo 0;
    endif;
endif;

if ($_REQUEST['action'] == 's_phone_mobile'):
    $text = $_REQUEST['up_mobile'];
    $result = $user_data->dao->update("{$db_prefix}t_user", array('s_phone_mobile' => $text), array('pk_i_id' => $user_id));
    if ($result):
        echo 1;
    else:
        echo 0;
    endif;
endif;

if ($_REQUEST['action'] == 'fk_c_country_code'):
    $country_code = $_REQUEST['up_country'];
    $country_name = $_REQUEST['up_country_name'];
    $result = $user_data->dao->update("{$db_prefix}t_user", array('fk_c_country_code' => $country_code, 's_country' => $country_name), array('pk_i_id' => $user_id));
    if ($result):
        echo 1;
    else:
        echo 0;
    endif;
endif;

//if ($_REQUEST['action'] == 'fk_i_city_id'):
//    $city_code = $_REQUEST['up_city_name'];
//    $city_name = $_REQUEST['up_city_code'];
//    $result = $user_data->dao->update("{$db_prefix}t_user", array('fk_i_city_id' => $city_code, 's_city' => $city_name ), array('pk_i_id' => $user_id));
//    if ($result):
//         echo 1;
//    else:
//        echo 0;
//    endif;
//endif;

if ($_REQUEST['action'] == 'user_role'):
    $user_type_id = $_REQUEST['user_role_id'];
    $result = $user_data->dao->update("{$db_prefix}t_user", array('user_role' => $user_type_id), array('pk_i_id' => $user_id));
    if ($result):
        echo 1;
    else:
        echo 0;
    endif;
endif;
?>