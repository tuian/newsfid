<?php
require '../../../oc-load.php';
require 'functions.php';

if ($_REQUEST['action'] == 'chat_off'):
    if (osc_is_web_user_logged_in()):
        $conn = getConnection();
        $id = osc_logged_user_id();
        $conn->osc_dbExec("UPDATE %st_useronline SET status = '1' WHERE userid = '%s'", DB_TABLE_PREFIX, $id);
    endif;
elseif ($_REQUEST['action'] == 'chat_on'):
    if (osc_is_web_user_logged_in()):
        $conn = getConnection();
        $id = osc_logged_user_id();
        $conn->osc_dbExec("UPDATE %st_useronline SET status = '0' WHERE userid = '%s'", DB_TABLE_PREFIX, $id);
    endif;
    endif;
