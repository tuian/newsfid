<?php

require '../../../oc-load.php';
require 'functions.php';
?>
<?php

$logged_in_user_id = $_REQUEST['logged_in_user_id'];
$follow_user_id = $_REQUEST['follow_user_id'];
if ($_REQUEST['action'] == 'unfollow'):
    $follow_update = update_user_following($logged_in_user_id, $follow_user_id, $follow_value);
endif;
if ($_REQUEST['action'] == 'add_circle'):
    $add_circle = add_user_circle($logged_in_user_id, $follow_user_id);
    osc_add_flash_ok_message('This User Succsessfully Added To Your Circle');
endif;

if ($_REQUEST['remove_circle'] == 'remove_circle'):
    $db_prefix = DB_TABLE_PREFIX;
    $remove_user_data = new DAO();
    $remove_user_data->dao->delete("`{$db_prefix}t_user_circle`", "user_id = $logged_in_user_id AND circle_user_id = $follow_user_id");
    osc_add_flash_ok_message('This User Succsessfully Removed To Your Circle');
endif;

//osc_redirect_to(osc_base_url());
?>