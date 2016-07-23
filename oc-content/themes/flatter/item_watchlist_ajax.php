<?php

require '../../../oc-load.php';
require 'functions.php';

$user_id = $_REQUEST['user_id'];
$item_id = $_REQUEST['item_id'];
$action = $_REQUEST['action'];
$watchlist_value = 0;
if ($action == 'add_watchlist'):
    $watchlist_value = 1;
endif;
if ($user_id != 0):
    update_user_watchlist_item($user_id, $item_id, $watchlist_value);
endif;
user_watchlist_box($user_id, $item_id);
?>