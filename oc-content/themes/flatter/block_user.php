<?php

require '../../../oc-load.php';
require 'functions.php';

$db_prefix = DB_TABLE_PREFIX;
$block_user['user_id'] = osc_logged_user_id();
$block_user['block_user_id'] = $_REQUEST['user_id'];
$block_data = new DAO();
if ($_REQUEST['user_id']):
    $block_data->dao->insert("{$db_prefix}t_user_access", $block_user);
endif;
?>