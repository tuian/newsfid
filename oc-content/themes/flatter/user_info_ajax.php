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
    print_r($text);
    print_r($result);
    if ($result):
        $user_data = get_user_data($user_id);
        echo $user_data['role_name'];
    else:
        echo 0;
    endif;
endif;
?>