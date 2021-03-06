<?php

require '../../../oc-load.php';
require 'functions.php';

if ($_REQUEST['action'] == 'user_block'):
    $db_prefix = DB_TABLE_PREFIX;
    $block_user['user_id'] = osc_logged_user_id();
    $block_user['block_user_id'] = $_REQUEST['block_user_id'];
    $block_user['block_value'] = 1;
    $block_data = new DAO();
    $block_data->dao->insert("{$db_prefix}t_user_block", $block_user);
endif;
if ($_REQUEST['action'] == 'unblock' && $_REQUEST['block_user_id']):
    $db_prefix = DB_TABLE_PREFIX;
    $user_id = osc_logged_user_id();
    $block_user_id = $_REQUEST['block_user_id'];
    $block_data = new DAO();
    $block_data->dao->delete("{$db_prefix}t_user_block", "user_id = $user_id AND block_user_id = $block_user_id");
endif;
?>