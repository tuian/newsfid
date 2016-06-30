<?php

if (!defined('OC_ADMIN'))
    exit('Direct access is not allowed.');
/*
  Plugin Name: Theme Plugin
  Plugin URI:
  Description: This plugin add themes to site.
  Version: 1.0.0
  Author:
  Author URI:
  Plugin update URI:
 */
require_once 'DAOTheme.php';

/**
 *
 */
define("THEME_UPLOAD_DIR", osc_base_path() . 'oc-content/uploads/themes_icon/');
define("THEME_UPLOAD_DIR_PATH", osc_base_url() . 'oc-content/uploads/themes_icon/');
define("THEME_PLUGIN_DIR_NAME", basename(__DIR__));
/**
 *
 */
$uploadImageName = null;

/**
 *
 */
function theme_after_install() {
    $path = osc_plugin_resource(THEME_PLUGIN_DIR_NAME . '/struct.sql');
    $sql = file_get_contents($path);
    DAOTheme::newInstance()->importSql($sql);
}

/**
 *
 */
function theme_after_uninstall() {
    $path = osc_plugin_resource(THEME_PLUGIN_DIR_NAME . '/drop.sql');
    $sql = file_get_contents($path);
    DAOTheme::newInstance()->importSql($sql);
    rmdir_theme_recursive(THEME_UPLOAD_DIR);
}

function rmdir_theme_recursive($dir) {
    foreach(scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$dir/$file")) rmdir_theme_recursive("$dir/$file");
        else unlink("$dir/$file");
    }
    rmdir($dir);
}

/**
 * @return int
 */
function theme_actions() {
    global $uploadImageName;

    //$dao_preference = new Preference();
    $addnew = Params::getParam('newadd');
    $edit = Params::getParam('edit');
    $bs_key_id = Params::getParam('delete');

    if (Params::getParam('file') != THEME_PLUGIN_DIR_NAME . '/admin.php') {
        return 0;
    }

    if ($addnew == 'true' && upload_theme_icon()) {
        $img = $uploadImageName;
        $name = Params::getParam('theme_name');

        $addIcon = DAOTheme::newInstance()->add_theme(array(
            'name' => $name,
            'image' => $img
        ));

        if ($addIcon) {
            osc_add_flash_ok_message(__('The icon has been added', 'rubric_icon'), 'admin');
        } else {
            osc_add_flash_error_message(_e('An error occurred delete the icon', 'rubric_icon'), 'admin');
        }
        osc_redirect_to(osc_admin_render_plugin_url(THEME_PLUGIN_DIR_NAME . '/admin.php'));
    } else if ($edit == 'true') {
        $img = $uploadImageName;
        $name = Params::getParam('theme_name');
        $id = Params::getParam('theme_id');
        $update_array = array('name' => $name);
        $new_image = update_theme_icon();
        if ($new_image):
            $update_array = array('name' => $name, 'image' => $new_image);
            @unlink(THEME_UPLOAD_DIR . Params::getParam('exist_image'));
        else:
            $update_array = array('name' => $name);
        endif;
        $addIcon = DAOTheme::newInstance()->update_theme($update_array, array('id' => $id));

        if ($addIcon) {
            osc_add_flash_ok_message(__('The icon has been added', 'rubric_icon'), 'admin');
        } else {
            osc_add_flash_error_message(_e('An error occurred delete the icon', 'rubric_icon'), 'admin');
        }
        osc_redirect_to(osc_admin_render_plugin_url(THEME_PLUGIN_DIR_NAME . '/admin.php'));
    } elseif ($bs_key_id != '') {
        $theme_array = DAOTheme::newInstance()->find_theme_by_id($bs_key_id);
        $deleteIcon = DAOTheme::newInstance()->delete_theme_by_id($bs_key_id);
        if ($deleteIcon) {
            @unlink(THEME_UPLOAD_DIR . $theme_array[0]['image']);
            osc_add_flash_ok_message(__('The icon has been deleted', 'rubric_icon'), 'admin');
        } else {
            osc_add_flash_error_message(__('An error occurred delete the icon', 'rubric_icon'), 'admin');
        }
        osc_redirect_to(osc_admin_render_plugin_url(THEME_PLUGIN_DIR_NAME . '/admin.php'));
    }
}

/**
 * @return int
 */
function upload_theme_icon() {
    global $uploadImageName;

    if (!empty($_FILES['imageName'])) {
        $myFile = $_FILES['imageName'];

        // if directory exist
        if (!is_dir(THEME_UPLOAD_DIR)) {
            mkdir(THEME_UPLOAD_DIR);
            // set proper permissions on the new dir
            chmod(THEME_UPLOAD_DIR, 0777);
        }

        if ($myFile["error"] !== UPLOAD_ERR_OK) {
            osc_add_flash_error_message(__('An error occurred saving the icon', 'rubric_icon'), 'admin');
            osc_redirect_to(osc_admin_render_plugin_url(THEME_PLUGIN_DIR_NAME . '/admin.php'));
        }

        // ensure a safe filename
        $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

        $parts = pathinfo($name);

        $name = md5($parts["filename"]) . '.' . $parts["extension"];
        // don't overwrite an existing file
        $i = 0;
        $parts = pathinfo($name);
        while (file_exists(THEME_UPLOAD_DIR . $name)) {
            $i++;
            $name = md5($parts["filename"]) . "-" . $i . "." . $parts["extension"];
        }

        // preserve file from temporary directory
        $success = move_uploaded_file($myFile["tmp_name"], THEME_UPLOAD_DIR . $name);
        if (!$success) {
            osc_add_flash_error_message(__('An error occurred saving the icon', 'rubric_icon'), 'admin');
            osc_redirect_to(osc_admin_render_plugin_url(THEME_PLUGIN_DIR_NAME . '/admin.php'));
        }
        // set proper permissions on the new file
        chmod(THEME_UPLOAD_DIR . $name, 0755);

        $uploadImageName = $name;

        return 1;
    }
}

function update_theme_icon() {
    global $uploadImageName;

    if (!empty($_FILES['imageName']['name'])) {
        $myFile = $_FILES['imageName'];

        // if directory exist
        if (!is_dir(THEME_UPLOAD_DIR)) {
            mkdir(THEME_UPLOAD_DIR);
            // set proper permissions on the new dir
            chmod(THEME_UPLOAD_DIR, 0777);
        }

        if ($myFile["error"] !== UPLOAD_ERR_OK) {
            osc_add_flash_error_message(__('An error occurred saving the icon', 'rubric_icon'), 'admin');
            //osc_redirect_to(osc_admin_render_plugin_url(THEME_PLUGIN_DIR_NAME . '/admin.php'));
        }

        // ensure a safe filename
        $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

        $parts = pathinfo($name);

        $name = md5($parts["filename"]) . '.' . $parts["extension"];
        // don't overwrite an existing file
        $i = 0;
        $parts = pathinfo($name);
        while (file_exists(THEME_UPLOAD_DIR . $name)) {
            $i++;
            $name = md5($parts["filename"]) . "-" . $i . "." . $parts["extension"];
        }

        // preserve file from temporary directory
        $success = move_uploaded_file($myFile["tmp_name"], THEME_UPLOAD_DIR . $name);

        if (!$success) {
            osc_add_flash_error_message(__('An error occurred saving the icon', 'rubric_icon'), 'admin');
            osc_redirect_to(osc_admin_render_plugin_url(THEME_PLUGIN_DIR_NAME . '/admin.php'));
        }
        // set proper permissions on the new file
        chmod(THEME_UPLOAD_DIR . $name, 0755);

        $uploadImageName = $name;

        return $name;
    }
}

// get category icon by category primary key
/**
 * @param $rubric_id
 * @return int
 */
function get_theme_icon($theme_id) {
    $icon = DAOTheme::newInstance()->find_theme_by_id($theme_id);

    if (count($icon) > 0) {
        return $icon;
    }
    return array();
}

/**
 * @return array
 */
function get_all_themes_icon() {
    $icons = DAOTheme::newInstance()->get_all_theme();
    if (count($icons) > 0) {
        return $icons;
    }
    return array();
}

/**
 *
 */
function theme_admin() {
    osc_admin_render_plugin(THEME_PLUGIN_DIR_NAME . '/admin.php');
}

/**
 *
 */
function theme_admin_menu() {
    osc_admin_menu_plugins('Theme icon', osc_admin_render_plugin_url(THEME_PLUGIN_DIR_NAME . '/admin.php'), 'theme_icon_submenu');
}

/**
 *
 */
function theme_load_styles() {
    osc_enqueue_style('theme_icon', osc_base_url() . 'oc-content/plugins/' . THEME_PLUGIN_DIR_NAME . '/assets/css/custom_theme_icon.css');
}

// This is needed in order to be able to activate the plugin
osc_register_plugin(osc_plugin_path(__FILE__), 'theme_after_install');
// This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", 'theme_after_uninstall');
osc_add_hook(osc_plugin_path(__FILE__) . "_configure", 'theme_admin');
osc_add_hook('admin_menu_init', 'theme_admin_menu');
// register css
osc_add_hook('init_admin', 'theme_load_styles');
osc_add_hook('init_admin', 'theme_actions');
?>