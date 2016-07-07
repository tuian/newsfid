<?php

/*
  Plugin Name: Item Video
  Plugin URI:
  Description: This plugin allows your users to attach a video file to their items
  Version: 1.0
  Author: Custom
  Author URI:
  Short Name: item_video
  Plugin update URI:
 */

require_once 'ItemVideoModel.php';


define('ITEM_VIDEO_FILE_PATH', osc_base_path() . 'oc-content/uploads/item_video/');
define('ITEM_VIDEO_FILE_URL', osc_base_url() . 'oc-content/uploads/item_video/');
define('ITEM_VIDEO_PLUGIN_DIR_NAME', basename(__DIR__));

function item_video_install() {
    ItemVideoModel::newInstance()->import(ITEM_VIDEO_PLUGIN_DIR_NAME . '/struct.sql');
    @mkdir(ITEM_VIDEO_FILE_PATH);
    osc_set_preference('item_video_max_file_number', '1', 'item_video', 'INTEGER');
    osc_set_preference('item_video_allowed_ext', 'mp4', 'item_video', 'STRING');
    osc_set_preference('item_video_max_file_size', '100', 'item_video', 'INTEGER');
}

function item_video_uninstall() {
    ItemVideoModel::newInstance()->uninstall();
    osc_delete_preference('item_video_max_file_number', 'item_video');
    osc_delete_preference('item_video_allowed_ext', 'item_video');
    osc_delete_preference('item_video_max_file_size', 'item_video');
}

function item_video_configure() {
    osc_plugin_configure_view(osc_plugin_path(__FILE__));
}

function item_video_admin_menu() {
    osc_add_admin_submenu_divider('plugins', 'Item Video', 'item_video_divider', 'administrator');
    osc_add_admin_submenu_page('plugins', __('Settings', 'item_video'), osc_route_admin_url('item-video-admin-conf'), 'item_video_settings', 'administrator');
    //osc_add_admin_submenu_page('plugins', __('Configure categories', 'item_video'), osc_admin_configure_plugin_url(ITEM_VIDEO_PLUGIN_DIR_NAME . "/index.php"), 'item_video_categories', 'administrator');
    osc_add_admin_submenu_page('plugins', __('File stats', 'item_video'), osc_route_admin_url('item-video-admin-stats'), 'item_video_stats', 'administrator');
}

function item_video_form($catId = null) {
    if ($catId != "") {
        //if (osc_is_this_category('item_video', $catId)) {
        $item_video_files = null;
        require_once 'item_edit.php';
        //}
    }
}

function item_video_item_detail() {
    //if (osc_is_this_category('item_video', osc_item_category_id())) {
    $item_video_files = ItemVideoModel::newInstance()->getFilesFromItem(osc_item_id());
    require_once 'item_detail.php';
    //}
}

function item_video_item_edit($catId = null, $item_id = null) {
    //if (osc_is_this_category('item_video', $catId)) {
    $item_video_files = ItemVideoModel::newInstance()->getFilesFromItem($item_id);
    $dg_item = Item::newInstance()->findByPrimaryKey($item_id);
    $secret = $dg_item['s_secret'];
    unset($dg_item);
    require_once 'item_edit.php';
    //}
}

function item_video_upload_files($item) {
    if ($item['fk_i_category_id'] != null) {
        //if (osc_is_this_category('item_video', $item['fk_i_category_id'])) {
        $files = Params::getFiles('item_video_files');
        if (is_array($files) && count($files) > 0) {
            require LIB_PATH . 'osclass/mimes.php';
            $allowed_types = array_map('trim', explode(',', osc_get_preference('item_video_allowed_ext', 'item_video')));
            $failed = false;
            $errorMsg = '';
            $maxSize = 1048576 * osc_get_preference('item_video_max_file_size', 'item_video');
            foreach ($files['error'] as $key => $error) :
                if ($error !== 4):
                    $bool_img = false;
                    $size = $files['size'][$key];
                    if ($size <= $maxSize) :
                        $fileMime = $files['type'][$key];
                        $path = $files['name'][$key];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        if (in_array($ext, $allowed_types)) :
                            $date = date('YmdHis');
                            $new_file_name = uniqid() . '.' . $ext;
                            $file_name = $date . '_' . $item['pk_i_id'] . '_' . $new_file_name;
                            $path = ITEM_VIDEO_FILE_PATH . $file_name;
                            if (move_uploaded_file($files['tmp_name'][$key], $path)) :
                                ItemVideoModel::newInstance()->insertFile($item['pk_i_id'], $new_file_name, $files['name'][$key], $date);
                                $failed = FALSE;
                            else :
                                $failed = true;
                                $errorMsg = __('File is not uploaded', 'item_video');
                            endif;
                        else :
                            $failed = true;
                            $errorMsg = __('Please choose file with allowed extension type', 'item_video');
                        endif;
                    else :
                        $failed = true;
                        $errorMsg = __('Please add file which has size less then or equals to allowes file size', 'item_video');
                    endif;
                endif;
            endforeach;
            if ($failed) :
                osc_add_flash_error_message($errorMsg, 'admin');
            endif;
            //}
        }
    }
}

function item_video_delete_item($item) {
    ItemVideoModel::newInstance()->removeItem($item);
}

osc_register_plugin(osc_plugin_path(__FILE__), 'item_video_install');
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", 'item_video_uninstall');
osc_add_hook(osc_plugin_path(__FILE__) . "_configure", 'item_video_configure');

osc_add_hook('admin_menu_init', 'item_video_admin_menu');

osc_add_hook('item_form', 'item_video_form');

osc_add_hook('item_detail', 'item_video_item_detail');

osc_add_hook('item_edit', 'item_video_item_edit');

osc_add_hook('edited_item', 'item_video_upload_files');
osc_add_hook('posted_item', 'item_video_upload_files');

osc_add_hook('delete_item', 'item_video_delete_item');

osc_add_route('item-video-admin-conf', ITEM_VIDEO_PLUGIN_DIR_NAME . '/admin/conf', ITEM_VIDEO_PLUGIN_DIR_NAME . '/admin/conf', osc_plugin_folder(__FILE__) . 'admin/conf.php');
osc_add_route('item-video-admin-stats', ITEM_VIDEO_PLUGIN_DIR_NAME . '/admin/stats', ITEM_VIDEO_PLUGIN_DIR_NAME . '/admin/stats', osc_plugin_folder(__FILE__) . 'admin/stats.php');
osc_add_route('item-video-ajax', ITEM_VIDEO_PLUGIN_DIR_NAME . '/ajax', ITEM_VIDEO_PLUGIN_DIR_NAME . '/ajax', osc_plugin_folder(__FILE__) . 'ajax.php');
osc_add_route('item-video-download', ITEM_VIDEO_PLUGIN_DIR_NAME . '/download/(.+)', ITEM_VIDEO_PLUGIN_DIR_NAME . '/download/{file}', osc_plugin_folder(__FILE__) . 'download.php');

function item_video_load_admin_styles() {
    osc_enqueue_style('item-video-admin-style', osc_base_url() . 'oc-content/plugins/item_video/assets/css/admin_style.css');
    //osc_enqueue_style('bootstrap-style', osc_base_url() . 'oc-content/plugins/item_video/assets/css/bootstrap.min.css' );
}

osc_add_hook('init_admin', 'item_video_load_admin_styles');

function item_video_load_styles() {
    osc_enqueue_style('item-video-style', osc_base_url() . 'oc-content/plugins/item_video/assets/css/style.css');
}

osc_add_hook('init', 'item_video_load_styles');
