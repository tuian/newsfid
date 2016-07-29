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
    $text = $_REQUEST['up_country'];
    $result = $user_data->dao->update("{$db_prefix}t_user", array('fk_c_country_code' => $text), array('pk_i_id' => $user_id));
    if ($result):
         echo 1;
    else:
        echo 0;
    endif;
endif;

?>