<?php

/*
  Plugin Name: Item Podcast
  Plugin URI:
  Description: This plugin allows your users to embed file to their items
  Version: 1.0
  Author: Custom
  Author URI:
  Short Name: item_podcast
  Plugin update URI:
 */

require_once 'ItemPodcastModel.php';


define('ITEM_PODCAST_FILE_PATH', osc_base_path() . 'oc-content/uploads/item_podcast/');
define('ITEM_PODCAST_FILE_URL', osc_base_url() . 'oc-content/uploads/item_podcast/');
define('ITEM_PODCAST_PLUGIN_DIR_NAME', basename(__DIR__));

function item_podcast_install() {
    ItemPodcastModel::newInstance()->import(ITEM_PODCAST_PLUGIN_DIR_NAME . '/struct.sql');
    @mkdir(ITEM_PODCAST_FILE_PATH);
    osc_set_preference('item_podcast_max_file_number', '1', 'item_podcast', 'INTEGER');
    osc_set_preference('item_podcast_allowed_ext', 'mp3', 'item_podcast', 'STRING');
    osc_set_preference('item_podcast_max_file_size', '10', 'item_podcast', 'INTEGER');
}

function item_podcast_uninstall() {
    ItemPodcastModel::newInstance()->uninstall();
    osc_delete_preference('item_podcast_max_file_number', 'item_podcast');
    osc_delete_preference('item_podcast_allowed_ext', 'item_podcast');
    osc_delete_preference('item_podcast_max_file_size', 'item_podcast');
}

function item_podcast_configure() {
    osc_plugin_configure_view(osc_plugin_path(__FILE__));
}

function item_podcast_admin_menu() {
    osc_add_admin_submenu_divider('plugins', 'Item Poscast', 'item_podcast_divider', 'administrator');
    osc_add_admin_submenu_page('plugins', __('Settings', 'item_podcast'), osc_route_admin_url('item-podcast-admin-conf'), 'item_podcast_settings', 'administrator');
    //osc_add_admin_submenu_page('plugins', __('Configure categories', 'item_podcast'), osc_admin_configure_plugin_url(ITEM_PODCAST_PLUGIN_DIR_NAME . "/index.php"), 'item_podcast_categories', 'administrator');
    osc_add_admin_submenu_page('plugins', __('File stats', 'item_podcast'), osc_route_admin_url('item-podcast-admin-stats'), 'item_podcast_stats', 'administrator');
}

function item_podcast_form($catId = null) {
    if ($catId != "") {
        //if (osc_is_this_category('item_podcast', $catId)) {
        $item_podcast_files = null;
        require_once 'item_edit.php';
        //}
    }
}

function item_podcast_item_detail() {
    //if (osc_is_this_category('item_podcast', osc_item_category_id())) {
    $item_podcast_files = ItemPodcastModel::newInstance()->getFilesFromItem(osc_item_id());
    require_once 'item_detail.php';
    //}
}

function item_podcast_item_edit($catId = null, $item_id = null) {
    //if (osc_is_this_category('item_podcast', $catId)) {
    $item_podcast_files = ItemPodcastModel::newInstance()->getFilesFromItem($item_id);
    $dg_item = Item::newInstance()->findByPrimaryKey($item_id);
    $secret = $dg_item['s_secret'];
    unset($dg_item);
    require_once 'item_edit.php';
    //}
}

function item_podcast_upload_files($item) {
    if ($item['fk_i_category_id'] != null) {
        //if (osc_is_this_category('item_podcast', $item['fk_i_category_id'])) {
        $files =Params::getParam('item_podcast_files', FALSE, FALSE, FALSE);
      
        if (count($files) > 0) {
            foreach ($files as $key => $content) :
                ItemPodcastModel::newInstance()->insertFile($item['pk_i_id'],$content, $date);
            endforeach;
            if ($failed) :
                osc_add_flash_error_message($errorMsg, 'admin');
            endif;
        }
    }
}

function item_podcast_delete_item($item) {
    ItemPodcastModel::newInstance()->removeItem($item);
}

osc_register_plugin(osc_plugin_path(__FILE__), 'item_podcast_install');
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", 'item_podcast_uninstall');
osc_add_hook(osc_plugin_path(__FILE__) . "_configure", 'item_podcast_configure');

osc_add_hook('admin_menu_init', 'item_podcast_admin_menu');

osc_add_hook('item_form', 'item_podcast_form');

osc_add_hook('item_detail', 'item_podcast_item_detail');

osc_add_hook('item_edit', 'item_podcast_item_edit');

osc_add_hook('edited_item', 'item_podcast_upload_files');
osc_add_hook('posted_item', 'item_podcast_upload_files');

osc_add_hook('delete_item', 'item_podcast_delete_item');

osc_add_route('item-podcast-admin-conf', ITEM_PODCAST_PLUGIN_DIR_NAME . '/admin/conf', ITEM_PODCAST_PLUGIN_DIR_NAME . '/admin/conf', osc_plugin_folder(__FILE__) . 'admin/conf.php');
osc_add_route('item-podcast-admin-stats', ITEM_PODCAST_PLUGIN_DIR_NAME . '/admin/stats', ITEM_PODCAST_PLUGIN_DIR_NAME . '/admin/stats', osc_plugin_folder(__FILE__) . 'admin/stats.php');
osc_add_route('item-podcast-ajax', ITEM_PODCAST_PLUGIN_DIR_NAME . '/ajax', ITEM_PODCAST_PLUGIN_DIR_NAME . '/ajax', osc_plugin_folder(__FILE__) . 'ajax.php');
osc_add_route('item-podcast-download', ITEM_PODCAST_PLUGIN_DIR_NAME . '/download/(.+)', ITEM_PODCAST_PLUGIN_DIR_NAME . '/download/{file}', osc_plugin_folder(__FILE__) . 'download.php');

function item_podcast_load_admin_styles() {
    osc_enqueue_style('item-podcast-admin-style', osc_base_url() . 'oc-content/plugins/item_podcast/assets/css/admin_style.css');
    //osc_enqueue_style('bootstrap-style', osc_base_url() . 'oc-content/plugins/item_podcast/assets/css/bootstrap.min.css' );
}

osc_add_hook('init_admin', 'item_podcast_load_admin_styles');

function item_podcast_load_styles() {
    osc_enqueue_style('item-podcast-style', osc_base_url() . 'oc-content/plugins/item_podcast/assets/css/style.css');
}

osc_add_hook('init', 'item_podcast_load_styles');
