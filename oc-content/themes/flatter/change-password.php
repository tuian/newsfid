<?php

require '../../../oc-load.php';
require 'functions.php';

$user_id = osc_logged_user_id();
$user = User::newInstance()->findByPrimaryKey($user_id);
$user_data = new DAO();
$db_prefix = DB_TABLE_PREFIX;


$password = $_REQUEST['password'];
if (osc_verify_password($password, $user['s_password'])) :
    if ($_REQUEST['action'] == 'password-change'):
        $text = sha1($_REQUEST['new_passowrd']);
        $result = $user_data->dao->update("{$db_prefix}t_user", array('s_password' => $text), array('pk_i_id' => $user_id));
        if ($result):
            echo 1;
        else:
            echo 0;
        endif;
    endif;
else:
    echo 0;
endif;
?>