<?php

/*
  Plugin Name: Item Mp3
  Plugin URI:
  Description: This plugin allows your users to attach a mp3 file to their items
  Version: 1.0
  Author: Custom
  Author URI:
  Short Name: item_mp3
  Plugin update URI:
 */

require_once 'ItemMp3Model.php';


define('ITEM_MP3_FILE_PATH', osc_base_path() . 'oc-content/uploads/item_mp3/');
define('ITEM_MP3_FILE_URL', osc_base_url() . 'oc-content/uploads/item_mp3/');
define('ITEM_MP3_PLUGIN_DIR_NAME', basename(__DIR__));

function item_mp3_install() {
    ItemMp3Model::newInstance()->import(ITEM_MP3_PLUGIN_DIR_NAME . '/struct.sql');
    @mkdir(ITEM_MP3_FILE_PATH);
    osc_set_preference('item_mp3_max_file_number', '1', 'item_mp3', 'INTEGER');
    osc_set_preference('item_mp3_allowed_ext', 'mp3', 'item_mp3', 'STRING');
    osc_set_preference('item_mp3_max_file_size', '10', 'item_mp3', 'INTEGER');
}

function item_mp3_uninstall() {
    ItemMp3Model::newInstance()->uninstall();
    osc_delete_preference('item_mp3_max_file_number', 'item_mp3');
    osc_delete_preference('item_mp3_allowed_ext', 'item_mp3');
    osc_delete_preference('item_mp3_max_file_size', 'item_mp3');
}

function item_mp3_configure() {
    osc_plugin_configure_view(osc_plugin_path(__FILE__));
}

function item_mp3_admin_menu() {
    osc_add_admin_submenu_divider('plugins', 'Item Mp3', 'item_mp3_divider', 'administrator');
    osc_add_admin_submenu_page('plugins', __('Settings', 'item_mp3'), osc_route_admin_url('item-mp3-admin-conf'), 'item_mp3_settings', 'administrator');
    //osc_add_admin_submenu_page('plugins', __('Configure categories', 'item_mp3'), osc_admin_configure_plugin_url(ITEM_MP3_PLUGIN_DIR_NAME . "/index.php"), 'item_mp3_categories', 'administrator');
    osc_add_admin_submenu_page('plugins', __('File stats', 'item_mp3'), osc_route_admin_url('item-mp3-admin-stats'), 'item_mp3_stats', 'administrator');
}

function item_mp3_form($catId = null) {
    if ($catId != "") {
        //if (osc_is_this_category('item_mp3', $catId)) {
        $item_mp3_files = null;
        require_once 'item_edit.php';
        //}
    }
}

function item_mp3_item_detail() {
    //if (osc_is_this_category('item_mp3', osc_item_category_id())) {
    $item_mp3_files = ItemMp3Model::newInstance()->getFilesFromItem(osc_item_id());
    require_once 'item_detail.php';
    //}
}

function item_mp3_item_edit($catId = null, $item_id = null) {
    //if (osc_is_this_category('item_mp3', $catId)) {
    $item_mp3_files = ItemMp3Model::newInstance()->getFilesFromItem($item_id);
    $dg_item = Item::newInstance()->findByPrimaryKey($item_id);
    $secret = $dg_item['s_secret'];
    unset($dg_item);
    require_once 'item_edit.php';
    //}
}

function item_mp3_upload_files($item) {
    if ($item['fk_i_category_id'] != null) {
        //if (osc_is_this_category('item_mp3', $item['fk_i_category_id'])) {
        $files = Params::getFiles('item_mp3_files');
        if (is_array($files) && count($files) > 0) {
            require LIB_PATH . 'osclass/mimes.php';
            $allowed_types = array_map('trim', explode(',', osc_get_preference('item_mp3_allowed_ext', 'item_mp3')));
            $failed = false;
            $errorMsg = '';
            $maxSize = 1048576 * osc_get_preference('item_mp3_max_file_size', 'item_mp3');
            foreach ($files['name'] as $key => $error) :
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
                            $path = ITEM_MP3_FILE_PATH . $file_name;
                            if (move_uploaded_file($files['tmp_name'][$key], $path)) :
                                ItemMp3Model::newInstance()->insertFile($item['pk_i_id'], $new_file_name, $files['name'][$key], $date);
                                $failed = FALSE;
                            else :
                                $failed = true;
                                $errorMsg = __('File is not uploaded', 'item_mp3');
                            endif;
                        else :
                            $failed = true;
                            $errorMsg = __('Please choose file with allowed extension type', 'item_mp3');
                        endif;
                    else :
                        $failed = true;
                        $errorMsg = __('Please add file which has size less then or equals to allowes file size', 'item_mp3');
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

function item_mp3_delete_item($item) {
    ItemMp3Model::newInstance()->removeItem($item);
}

osc_register_plugin(osc_plugin_path(__FILE__), 'item_mp3_install');
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", 'item_mp3_uninstall');
osc_add_hook(osc_plugin_path(__FILE__) . "_configure", 'item_mp3_configure');

osc_add_hook('admin_menu_init', 'item_mp3_admin_menu');

osc_add_hook('item_form', 'item_mp3_form');

osc_add_hook('item_detail', 'item_mp3_item_detail');

osc_add_hook('item_edit', 'item_mp3_item_edit');

osc_add_hook('edited_item', 'item_mp3_upload_files');
osc_add_hook('posted_item', 'item_mp3_upload_files');

osc_add_hook('delete_item', 'item_mp3_delete_item');

osc_add_route('item-mp3-admin-conf', ITEM_MP3_PLUGIN_DIR_NAME . '/admin/conf', ITEM_MP3_PLUGIN_DIR_NAME . '/admin/conf', osc_plugin_folder(__FILE__) . 'admin/conf.php');
osc_add_route('item-mp3-admin-stats', ITEM_MP3_PLUGIN_DIR_NAME . '/admin/stats', ITEM_MP3_PLUGIN_DIR_NAME . '/admin/stats', osc_plugin_folder(__FILE__) . 'admin/stats.php');
osc_add_route('item-mp3-ajax', ITEM_MP3_PLUGIN_DIR_NAME . '/ajax', ITEM_MP3_PLUGIN_DIR_NAME . '/ajax', osc_plugin_folder(__FILE__) . 'ajax.php');
osc_add_route('item-mp3-download', ITEM_MP3_PLUGIN_DIR_NAME . '/download/(.+)', ITEM_MP3_PLUGIN_DIR_NAME . '/download/{file}', osc_plugin_folder(__FILE__) . 'download.php');

function item_mp3_load_admin_styles() {
    osc_enqueue_style('item-mp3-admin-style', osc_base_url() . 'oc-content/plugins/item_mp3/assets/css/admin_style.css');
    //osc_enqueue_style('bootstrap-style', osc_base_url() . 'oc-content/plugins/item_mp3/assets/css/bootstrap.min.css' );
}

osc_add_hook('init_admin', 'item_mp3_load_admin_styles');

function item_mp3_load_styles() {
    osc_enqueue_style('item-mp3-style', osc_base_url() . 'oc-content/plugins/item_mp3/assets/css/style.css');
}

osc_add_hook('init', 'item_mp3_load_styles');
