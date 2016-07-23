<?php

require '../../../oc-load.php';
require 'functions.php';

$user_id = $_REQUEST['user_id'];
$follow_user_id = $_REQUEST['follow_user_id'];
$action = $_REQUEST['action'];
$follow_value = 0;
if ($action == 'follow'):
    $follow_value = 1;
endif;
if ($user_id != 0):
    update_user_following($user_id, $follow_user_id, $follow_value);
endif;
user_follow_box($user_id, $follow_user_id);
?>