<?php

/*
  Plugin Name: User Online
  Plugin URI: http://plugins-zone.com/free-plugins-for-osclass/user-online.html
  Description: This plugin enables you to show in item page if the user is online and logged in.
  Version: 1.0.2
  Author: cartagena68
  Author URI: http://plugins-zone.com
  Short Name: useronline
  Plugin update URI: http://plugins-zone.com/free-plugins-for-osclass/user-online.html
 */

// Install Plugin
function useronline_install() {

    $conn = getConnection();
    $conn->autocommit(false);
    try {
        $path = osc_plugin_resource('useronline/struct.sql');
        $sql = file_get_contents($path);
        $conn->osc_dbImportSQL($sql);
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
    $conn->autocommit(true);
    osc_set_preference('useronline_text', 'User Online', 'useronline', 'STRING');
    osc_set_preference('useroffline_text', 'User Offline', 'useronline', 'STRING');
    osc_set_preference('useronline_set_text_image', 'image', 'useronline', 'STRING');
}

// Uninstall Plugin
function useronline_uninstall() {
    $conn = getConnection();
    $conn->autocommit(false);
    try {
        $conn->osc_dbExec('DROP TABLE %st_useronline', DB_TABLE_PREFIX);
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
    $conn->autocommit(true);
    osc_delete_preference('useronline_text', 'useronline');
    osc_delete_preference('useroffline_text', 'useronline');
    osc_delete_preference('useronline_set_text_image', 'useronline');
}

function useronline_user_online() {

    if (osc_is_web_user_logged_in()) {
        $conn = getConnection();
        $id = osc_logged_user_id();
        $userOnline = $conn->osc_dbFetchResult("SELECT `userid` FROM %st_useronline", DB_TABLE_PREFIX);
//        if (!in_array($id, $userOnline)):
            $conn->osc_dbExec("INSERT INTO %st_useronline (`userid`, `timestamp`, `status`) VALUES ('$id', CURRENT_TIMESTAMP, '0') ON DUPLICATE KEY UPDATE timestamp=CURRENT_TIMESTAMP", DB_TABLE_PREFIX);
//        endif;
    }
    // delete the USER ID that are no longer online (no update for longer than 5 minutes)
    $conn = getConnection();
    $conn->osc_dbExec("DELETE FROM %st_useronline WHERE timestamp < NOW() - INTERVAL 5 MINUTE", DB_TABLE_PREFIX);
}

// Show if user is online
//function useronline_show_user_status($itemUserId = null) {
//    if (!$itemUserId):
//        $itemUserId = osc_item_user_id();
//    endif;
//    $conn = getConnection();
//    $userOnline = $conn->osc_dbFetchResult("SELECT * FROM %st_useronline WHERE userid = '%s'", DB_TABLE_PREFIX, $itemUserId);
//    if ($userOnline != '') {
//        if (osc_get_preference('useronline_set_text_image', 'useronline') == 'image') {
//            echo '<img src="' . osc_base_url() . 'oc-content/plugins/useronline/images/online.png" />';
//        } else {
//            echo '<span style="color:#00CC00 !important; font-weight:bold">' . osc_get_preference('useronline_text', 'useronline') . '&nbsp;</span>';
//        }
//    } else {
//        if (osc_get_preference('useronline_set_text_image', 'useronline') == 'image') {
//            echo '<img src="' . osc_base_url() . 'oc-content/plugins/useronline/images/offline.png" />';
//        } else {
//            echo '<span style="color:#F00 !important; font-weight:bold">' . osc_get_preference('useroffline_text', 'useronline') . '&nbsp;</span>';
//        }
//    }
//}

function useronline_show_user_status($itemUserId = null) {
    if (!$itemUserId):
        $itemUserId = osc_item_user_id();
    endif;
    $conn = getConnection();
    $userOnline = $conn->osc_dbFetchResult("SELECT * FROM %st_useronline WHERE userid = '%s' AND status = '%s'", DB_TABLE_PREFIX, $itemUserId, '1');
    if ($userOnline != '') {
        return 1;
    } else {
        return 0;
    }
}

function useronline_help() {
    osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/admin.php');
}

// Delete USER ID when user logout
function useronline_user_logout() {
    if (osc_is_web_user_logged_in()) {
        $conn = getConnection();
        $id = osc_logged_user_id();
        $conn->osc_dbExec("UPDATE %st_useronline SET status = '1' WHERE userid = '%s'", DB_TABLE_PREFIX, $id);
    }
}

function useronline_user_chat_on() {
    if (osc_is_web_user_logged_in()) {
        $conn = getConnection();
        $id = osc_logged_user_id();
        $conn->osc_dbExec("UPDATE %st_useronline SET status = '0' WHERE userid = '%s'", DB_TABLE_PREFIX, $id);
    }
}

// user online for admin panel
function total_user_online() {

    function getFormattedResult() {
        $conn = getConnection();
        $results = $conn->osc_dbFetchResults("SELECT * FROM %st_useronline", DB_TABLE_PREFIX);
        $row = count($results);
        return number_format($row, 0, '', '.');
    }

    // fetch the data
    $online = getFormattedResult();

    echo '
  <style type="text/css">
    .counterstyle { border: solid #ccc 1px; -moz-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px; -webkit-box-shadow: 0 1px 1px #ccc; -moz-box-shadow: 0 1px 1px #ccc; box-shadow: 0 1px 1px #ccc; font-family: "trebuchet MS", "Lucida sans", Arial; font-size: 13px; color: #444; *border-collapse: collapse; /* IE7 and lower */ border-spacing: 0; width: 350px;}
    .counterstyle tr:hover { background: #fbf8e9;}
    .counterstyle td{ border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 3px; text-align: left;}
    .counterstyle td.flag img{width: 30px; height: 20px;}
  </style>
  <table class="counterstyle"><tbody>
    <tr><td>Total Users Online </td><td>' . $online . '</td></tr>
	
</tbody></table>';
}

function useronline_admin_menu() {
    echo '<h3><a href="#">User Online</a></h3>
    <ul>
        <li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin.php') . '">&raquo; ' . __('Admin', 'plugincache') . '</a></li>
			<li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'help.php') . '">&raquo; ' . __('Help', 'plugincache') . '</a></li>
    </ul>';
}

function list_user_online() {
    $conn = getConnection();
    $results = $conn->osc_dbFetchResults("SELECT * FROM %st_useronline", DB_TABLE_PREFIX);
    foreach ($results as $result) {
        $userId = $result['userid'];
        $user = $conn->osc_dbFetchResult("SELECT * FROM %st_user WHERE pk_i_id = '%s'", DB_TABLE_PREFIX, $userId);
        echo '
			<tr>
	<td>' . $user['s_name'] . '</td>
	<td>' . $user['pk_i_id'] . '</td>
	<td>' . $user['dt_reg_date'] . '</td>
	<td>' . $user['s_email'] . '</td>
	<td>' . $user['i_items'] . '</td>
	<td>' . $user['s_access_ip'] . '</td>
	<td>' . $user['dt_access_date'] . '</td>
	</tr>
		';
    }
}

// This is needed in order to be able to activate the plugin
osc_register_plugin(osc_plugin_path(__FILE__), 'useronline_install');

// This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", 'useronline_uninstall');

osc_add_hook(osc_plugin_path(__FILE__) . '_configure', 'useronline_help');

osc_add_hook('before_html', 'useronline_user_online');
osc_add_hook('logout', 'useronline_user_logout');
osc_add_hook('admin_menu', 'useronline_admin_menu');
?>
