<?php

require '../../../oc-load.php';
require 'functions.php';

$user_id = $_REQUEST['user_id'];
$item_id = $_REQUEST['item_id'];
$action = $_REQUEST['action'];
$like_value = 0;
if($action == 'like'):
    $like_value = 1;
endif;
update_item_like($user_id, $item_id, $like_value);
item_like_box($user_id, $item_id);
?>