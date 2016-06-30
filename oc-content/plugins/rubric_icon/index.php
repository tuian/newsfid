<?php

if (!defined('OC_ADMIN'))
    exit('Direct access is not allowed.');
/*
  Plugin Name: Rubric Plugin
  Plugin URI:
  Description: This plugin add rubrics to site.
  Version: 1.0.0
  Author:
  Author URI:
  Plugin update URI:
 */
require_once 'DAORubric.php';

/**
 *
 */
define("RUBRIC_UPLOAD_DIR", osc_base_path() . 'oc-content/uploads/rubrics_icon/');
define("RUBRIC_UPLOAD_DIR_PATH", osc_base_url() . 'oc-content/uploads/rubrics_icon/');
define("RUBRIC_PLUGIN_DIR_NAME", basename(__DIR__));
/**
 *
 */
$uploadImageName = null;

/**
 *
 */
function rubric_after_install() {
    $path = osc_plugin_resource(RUBRIC_PLUGIN_DIR_NAME . '/struct.sql');
    $sql = file_get_contents($path);
    DAORubric::newInstance()->importSql($sql);
}

/**
 *
 */
function rubric_after_uninstall() {
    $path = osc_plugin_resource(RUBRIC_PLUGIN_DIR_NAME . '/drop.sql');
    $sql = file_get_contents($path);
    DAORubric::newInstance()->importSql($sql);
    rmdir_recursive(RUBRIC_UPLOAD_DIR);
}

function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
        else unlink("$dir/$file");
    }
    rmdir($dir);
}

/**
 * @return int
 */
function rubric_actions() {
    global $uploadImageName;

    //$dao_preference = new Preference();
    $addnew = Params::getParam('newadd');
    $edit = Params::getParam('edit');
    $bs_key_id = Params::getParam('delete');

    if (Params::getParam('file') != RUBRIC_PLUGIN_DIR_NAME . '/admin.php') {
        return 0;
    }

    if ($addnew == 'true' && upload_rubric_icon()) {
        $img = $uploadImageName;
        $name = Params::getParam('rubric_name');

        $addIcon = DAORubric::newInstance()->add_rubric(array(
            'name' => $name,
            'image' => $img
        ));

        if ($addIcon) {
            osc_add_flash_ok_message(__('The icon has been added', 'rubric_icon'), 'admin');
        } else {
            osc_add_flash_error_message(_e('An error occurred delete the icon', 'rubric_icon'), 'admin');
        }
        osc_redirect_to(osc_admin_render_plugin_url(RUBRIC_PLUGIN_DIR_NAME . '/admin.php'));
    } else if ($edit == 'true') {
        $img = $uploadImageName;
        $name = Params::getParam('rubric_name');
        $id = Params::getParam('rubric_id');
        $update_array = array('name' => $name);
        $new_image = update_rubric_icon();
        if ($new_image):
            $update_array = array('name' => $name, 'image' => $new_image);
            @unlink(RUBRIC_UPLOAD_DIR . Params::getParam('exist_image'));
        else:
            $update_array = array('name' => $name);
        endif;
        $addIcon = DAORubric::newInstance()->update_rubric($update_array, array('id' => $id));

        if ($addIcon) {
            osc_add_flash_ok_message(__('The icon has been added', 'rubric_icon'), 'admin');
        } else {
            osc_add_flash_error_message(_e('An error occurred delete the icon', 'rubric_icon'), 'admin');
        }
        osc_redirect_to(osc_admin_render_plugin_url(RUBRIC_PLUGIN_DIR_NAME . '/admin.php'));
    } elseif ($bs_key_id != '') {
        $rubric_array = DAORubric::newInstance()->find_rubric_by_id($bs_key_id);
        $deleteIcon = DAORubric::newInstance()->delete_rubric_by_id($bs_key_id);
        if ($deleteIcon) {
            @unlink(RUBRIC_UPLOAD_DIR . $rubric_array[0]['image']);
            osc_add_flash_ok_message(__('The icon has been deleted', 'rubric_icon'), 'admin');
        } else {
            osc_add_flash_error_message(__('An error occurred delete the icon', 'rubric_icon'), 'admin');
        }
        osc_redirect_to(osc_admin_render_plugin_url(RUBRIC_PLUGIN_DIR_NAME . '/admin.php'));
    }
}

/**
 * @return int
 */
function upload_rubric_icon() {
    global $uploadImageName;

    if (!empty($_FILES['imageName'])) {
        $myFile = $_FILES['imageName'];

        // if directory exist
        if (!is_dir(RUBRIC_UPLOAD_DIR)) {
            mkdir(RUBRIC_UPLOAD_DIR);
            // set proper permissions on the new dir
            chmod(RUBRIC_UPLOAD_DIR, 0777);
        }

        if ($myFile["error"] !== UPLOAD_ERR_OK) {
            osc_add_flash_error_message(__('An error occurred saving the icon', 'rubric_icon'), 'admin');
            osc_redirect_to(osc_admin_render_plugin_url(RUBRIC_PLUGIN_DIR_NAME . '/admin.php'));
        }

        // ensure a safe filename
        $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

        $parts = pathinfo($name);

        $name = md5($parts["filename"]) . '.' . $parts["extension"];
        // don't overwrite an existing file
        $i = 0;
        $parts = pathinfo($name);
        while (file_exists(RUBRIC_UPLOAD_DIR . $name)) {
            $i++;
            $name = md5($parts["filename"]) . "-" . $i . "." . $parts["extension"];
        }

        // preserve file from temporary directory
        $success = move_uploaded_file($myFile["tmp_name"], RUBRIC_UPLOAD_DIR . $name);
        if (!$success) {
            osc_add_flash_error_message(__('An error occurred saving the icon', 'rubric_icon'), 'admin');
            osc_redirect_to(osc_admin_render_plugin_url(RUBRIC_PLUGIN_DIR_NAME . '/admin.php'));
        }
        // set proper permissions on the new file
        chmod(RUBRIC_UPLOAD_DIR . $name, 0755);

        $uploadImageName = $name;

        return 1;
    }
}

function update_rubric_icon() {
    global $uploadImageName;

    if (!empty($_FILES['imageName']['name'])) {
        $myFile = $_FILES['imageName'];

        // if directory exist
        if (!is_dir(RUBRIC_UPLOAD_DIR)) {
            mkdir(RUBRIC_UPLOAD_DIR);
            // set proper permissions on the new dir
            chmod(RUBRIC_UPLOAD_DIR, 0777);
        }

        if ($myFile["error"] !== UPLOAD_ERR_OK) {
            osc_add_flash_error_message(__('An error occurred saving the icon', 'rubric_icon'), 'admin');
            osc_redirect_to(osc_admin_render_plugin_url(RUBRIC_PLUGIN_DIR_NAME . '/admin.php'));
        }

        // ensure a safe filename
        $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

        $parts = pathinfo($name);

        $name = md5($parts["filename"]) . '.' . $parts["extension"];
        // don't overwrite an existing file
        $i = 0;
        $parts = pathinfo($name);
        while (file_exists(RUBRIC_UPLOAD_DIR . $name)) {
            $i++;
            $name = md5($parts["filename"]) . "-" . $i . "." . $parts["extension"];
        }

        // preserve file from temporary directory
        $success = move_uploaded_file($myFile["tmp_name"], RUBRIC_UPLOAD_DIR . $name);

        if (!$success) {
            osc_add_flash_error_message(__('An error occurred saving the icon', 'rubric_icon'), 'admin');
            //osc_redirect_to(osc_admin_render_plugin_url('rubric_icon/admin.php'));
        }
        // set proper permissions on the new file
        chmod(RUBRIC_UPLOAD_DIR . $name, 0755);

        $uploadImageName = $name;

        return $name;
    }
}

// get category icon by category primary key
/**
 * @param $rubric_id
 * @return int
 */
function get_rubric_icon($rubric_id) {
    $icon = DAORubric::newInstance()->find_rubric_by_id($rubric_id);

    if (count($icon) > 0) {
        return $icon;
    }
    return array();
}

/**
 * @return array
 */
function get_all_rubrics_icon() {
    $icons = DAORubric::newInstance()->get_all_rubric();
    if (count($icons) > 0) {
        return $icons;
    }
    return array();
}

/**
 *
 */
function rubric_admin() {
    osc_admin_render_plugin(RUBRIC_PLUGIN_DIR_NAME . '/admin.php');
}

/**
 *
 */
function rubric_admin_menu() {
    osc_admin_menu_plugins('Rubric icon', osc_admin_render_plugin_url(RUBRIC_PLUGIN_DIR_NAME . '/admin.php'), 'rubric_icon_submenu');
}

/**
 *
 */
function rubric_load_styles() {
    osc_enqueue_style('rubric_icon', osc_base_url() . 'oc-content/plugins/' . RUBRIC_PLUGIN_DIR_NAME . '/assets/css/custom_rubric_icon.css');
}

// This is needed in order to be able to activate the plugin
osc_register_plugin(osc_plugin_path(__FILE__), 'rubric_after_install');
// This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", 'rubric_after_uninstall');
osc_add_hook(osc_plugin_path(__FILE__) . "_configure", 'rubric_admin');
osc_add_hook('admin_menu_init', 'rubric_admin_menu');
// register css
osc_add_hook('init_admin', 'rubric_load_styles');
osc_add_hook('init_admin', 'rubric_actions');
?>