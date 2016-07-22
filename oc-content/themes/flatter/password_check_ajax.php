<?php
require '../../../oc-load.php';
require 'functions.php';

$user_id = osc_logged_user_id();
$user = User::newInstance()->findByPrimaryKey($user_id);

$password = $_REQUEST['password'];
if (osc_verify_password($password,$user['s_password'])) :
    echo 1;    
else:
    echo 0;
endif;
?>