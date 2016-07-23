<?php

require '../../../oc-load.php';
require 'functions.php';

$user_id = $_REQUEST['user_id'];
$item_id = $_REQUEST['item_id'];
$action = $_REQUEST['action'];
$share_value = 0;
if($action == 'share'):
    $share_value = 1;
endif;
if($user_id != 0):
    update_user_share_item($user_id, $item_id, $share_value);
endif;
user_share_box($user_id, $item_id);
?>