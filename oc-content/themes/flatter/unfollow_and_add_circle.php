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
endif;
//osc_redirect_to(osc_base_url());
?>