<?php
/*
Plugin Name: Madhouse Avatar
Plugin URI: https://wearemadhouse.wordpress.com/portfolio/madhouse-avatar/
Description: Allows users to have a profile pricture, designed by madhouse.
Version: 1.40
Author: Madhouse
Author URI: http://wearemadhouse.wordpress.com
Short Name: madhouse_avatar
Plugin update URI: madhouse-avatar
*/


/*
 * ==========================================================================
 *  LOADING
 * ==========================================================================
 */

require_once __DIR__ . "/vendor/composer_components/madhouse/autoloader/autoload.php";

/**
 * Makes this plugin the first to be loaded.
 * - Bumps this plugin at the top of the active_plugins stack.
 */
function mdh_avatar_bump_me()
{
    if(OC_ADMIN) {
        // @legacy : ALWAYS remove this if active.
        if(osc_plugin_is_enabled("madhouse_utils/index.php")) {
            Plugins::deactivate("madhouse_utils/index.php");
        }

        // Sanitize & get the {PLUGIN_NAME}/index.php.
        $path = str_replace(osc_plugins_path(), '', osc_plugin_path(__FILE__));

        if(osc_plugin_is_installed($path)) {
            // Get the active plugins.
            $plugins_list = unserialize(osc_active_plugins());
            if(!is_array($plugins_list)) {
                return false;
            }

            // Remove $path from the active plugins list
            foreach($plugins_list as $k => $v) {
                if($v == $path) {
                    unset($plugins_list[$k]);
                }
            }

            // Re-add the $path at the beginning of the active plugins.
            array_unshift($plugins_list, $path);

            // Serialize the new active_plugins list.
            osc_set_preference('active_plugins', serialize($plugins_list));

            if(Params::getParam("page") === "plugins" && Params::getParam("action") === "enable" && Params::getParam("plugin") === $path) {
                //osc_redirect_to(osc_admin_base_url(true) . "?page=plugins");
            } else {
                osc_redirect_to(osc_admin_base_url(true) . "?" . http_build_query(Params::getParamsAsArray("get")));
            }
        }
    }
}

if(!function_exists("mdh_utils") || (function_exists("mdh_utils") && (mdh_utils() === true || strnatcmp(mdh_utils(), "1.20") === -1))) {
    mdh_avatar_bump_me();
} else {
	/*
	 * ==========================================================================
	 *  INSTALL
	 * ==========================================================================
	 */

	function mdh_avatar_install() {
		osc_set_preference('urDimNav',           '50x50',   mdh_current_preferences_section(), 'STRING');
		osc_set_preference('urDimThumbnail',     '70x70',   mdh_current_preferences_section(), 'STRING');
		osc_set_preference('urDimPreview',       '100x100', mdh_current_preferences_section(), 'STRING');
		osc_set_preference('urDimNormal',        '300x300', mdh_current_preferences_section(), 'STRING');
	    osc_set_preference('form_post_position', '5',       mdh_current_preferences_section(), 'INTEGER');
	    osc_set_preference('form_edit_position', '5',       mdh_current_preferences_section(), 'INTEGER');

		osc_set_preference('watermark', "0", mdh_current_preferences_section(), 'BOOLEAN');

		osc_reset_preferences();

		mdh_import_sql(mdh_current_plugin_path('assets/model/install.sql', false));

		if (!file_exists(mdh_avatar_path_content())) {
			mkdir(mdh_avatar_path_content(), 0777, true);
		}

		// Create default image profile
		$tmpName = mdh_current_plugin_path("assets/img/no_picture.jpg", false);
	    Madhouse_Avatar_Actions::process($tmpName, 0, true);

	    // Set the version to the current installed one.
	    osc_set_preference('version', '1.40', mdh_current_preferences_section(), 'INTEGER');
	}
	osc_register_plugin(osc_plugin_path(__FILE__), "mdh_avatar_install");

	if(osc_plugin_is_installed(mdh_current_plugin_name(true)) && osc_get_preference("version", mdh_current_preferences_section()) === "") {
        mdh_avatar_install();
    }

	/*
	 * ==========================================================================
	 *  UNINSTALL
	 * ==========================================================================
	 */

	osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', function () {
		mdh_delete_preferences(mdh_current_preferences_section());
		mdh_import_sql(mdh_current_plugin_path('assets/model/uninstall.sql', false));
	});

    /*
     * ==========================================================================
     * FORM
     * ==========================================================================
     */

    function mdh_avatar_form($user = null) {
        if (OC_ADMIN) {
            mdh_current_plugin_path('views/admin/edit.php');
        } else {
            Madhouse_Utils_Controllers::doViewPart('edit.php');
        }
    }

    osc_add_hook('user_register_form', 'mdh_avatar_form', (OC_ADMIN)? 5 : osc_get_preference('form_edit_position', mdh_current_preferences_section()));

    osc_add_hook('user_profile_form', 'mdh_avatar_form', (OC_ADMIN)? 5 : osc_get_preference('form_edit_position', mdh_current_preferences_section()));

	/*
	 * ==========================================================================
	 * UPLOAD PROFILE PICTURE
	 * ==========================================================================
	 */

	function submitUpload($userId) {

		$aResources = Params::getFiles('user_photo');
		$ajax_photos = Params::getParam('ajax_user_photos');

		// $ajax_photos is an array of filenames of the photos uploaded by ajax to a temporary folder
	    // fake insert them into the array of the form-uploaded photos
	    if(is_array($ajax_photos)) {
	        foreach($ajax_photos as $photo) {
	            if(file_exists(osc_content_path().'uploads/temp/'.$photo)) {
	                $aResources['name'][]      = $photo;
	                $aResources['type'][]      = 'image/*';
	                $aResources['tmp_name'][]  = osc_content_path().'uploads/temp/'.$photo;
	                $aResources['error'][]     = UPLOAD_ERR_OK;
	                $aResources['size'][]      = 0;
	            }
	        }
	    }

		if(is_array($aResources) && $aResources != '') {
			// upload image & move to path
	        $status = "";
	        $flash_error = "";
	        $files = $aResources;

	        // Validate
	        if ( !Madhouse_Avatar_Actions::checkAllowedExt($files) ) {
	            $status = 'error';
	        }
	        if ( !Madhouse_Avatar_Actions::checkSize($files) ) {
	            $status = 'error';
	        }

	        if ($status != 'error') {
	            foreach ($files['error'] as $key => $error) {
	                $tmpName = $files['tmp_name'][$key];
	                if ($tmpName != "") {
		                if( $error == UPLOAD_ERR_OK) {
		                    Madhouse_Avatar_Actions::deleteAllResourcesFromUser($userId, false);
		                    Madhouse_Avatar_Actions::process($tmpName, $userId);
		                } else {
		                    $status = 'error';
		                    $flash_error .= _m('There was a problem uploading your image profile')."<br />";
		                }
	            	}
	            }
	        }


	        if( $flash_error != '' ) {
	            switch($status) {
	                case('error'):
	                    osc_add_flash_error_message($flash_error);
	                break;
	                case('warning'):
	                    osc_add_flash_warning_message($flash_error);
	                break;
	                default:
	                break;
	            }
	        }
		}
		return 0; // NO PROBLEMS
	}

	//Run controller when users delete an item
	osc_add_hook('user_register_completed', 'submitUpload') ;

	//Run controller when users  edit an item
	osc_add_hook('user_edit_completed', 'submitUpload') ;

	/*
	 * ==========================================================================
	 *  DELETE RESOURCE
	 * ==========================================================================
	 */

	osc_add_hook('delete_user', function ($userId) {
		Madhouse_Avatar_Actions::deleteAllResourcesFromUser($userId, false);
	});

	/*
	 * ==========================================================================
	 *  ADMIN MENU
	 * ==========================================================================
	 */

	osc_add_hook('admin_menu_init', function () {
	    osc_add_admin_submenu_divider('madhouse', __('Avatar', mdh_current_plugin_name()), mdh_current_plugin_name(), 'administrator');
	    osc_add_admin_submenu_page('madhouse', __('Settings', mdh_current_plugin_name()), mdh_avatar_settings_url(), mdh_current_plugin_name() . '_settings', 'administrator');
	    osc_add_admin_submenu_page('madhouse', __('Regenerate', mdh_current_plugin_name()), mdh_avatar_regenerate_url(), mdh_current_plugin_name() . '_regenerate', 'administrator');
	});

	/*
	 * ==========================================================================
	 *  CONTROLLER
	 * ==========================================================================
	 */

	osc_add_hook("renderplugin_controller", function()
	{
		if(preg_match('/^' . mdh_current_plugin_name() . '.*$/', Params::getParam("route"))) {

			// Enqueue style for admin only.
	        osc_add_hook("admin_header", function() {
	            osc_enqueue_style(mdh_current_plugin_name() . "_admin", mdh_current_plugin_url("assets/css/admin.css"));
	        });

			$filter =  function($string) {
				return __("Madhouse Avatar", mdh_current_plugin_name());
			};

			// Page title (in <head />)
			osc_add_filter("admin_title", $filter);

			// Page title (in <h1 />)
			osc_add_filter("custom_plugin_title", $filter);

			osc_add_filter("admin_body_class", function($classes) {
				array_push($classes, "madhouse");
				return $classes;
			});

			// Add a .row-offset to wrapping <div /> element.
			osc_add_filter("render-wrapper", function($string) {
				return "row-offset";
			});

			mdh_current_plugin_path("classes/Madhouse/Avatar/Controllers/Admin.php");
			$do = new Madhouse_Avatar_Controllers_Admin();
			$do->doModel();
		}
	});

	/*
	 * ==========================================================================
	 *  ROUTE
	 * ==========================================================================
	 */

	osc_add_route(
		mdh_current_plugin_name(),
		'avatar/?',
		'avatar/',
		mdh_current_plugin_name() . '/views/admin/settings.php'
	);

	osc_add_route(
		mdh_current_plugin_name() . "_do",
		'avatar/do/?',
		'avatar/do/',
		mdh_current_plugin_name() . '/views/admin/settings.php'
	);

	osc_add_route(
		mdh_current_plugin_name()."_move",
		'avatar/move?',
		'avatar/move',
		mdh_current_plugin_name() . '/views/admin/regenerate.php'
	);

	osc_add_route(
		mdh_current_plugin_name()."_regenerate",
		'avatar/move?',
		'avatar/move',
		mdh_current_plugin_name() . '/views/admin/regenerate.php'
	);

	osc_add_route(
	    mdh_current_plugin_name()."_delete",
	    'avatar/delete/(\d+)/?',
	    'avatar/move/{id}',
	    mdh_current_plugin_name() . '/views/admin/index.php'
	);

	osc_add_route(
	    mdh_current_plugin_name() . "_ajax",
	    'avatar/ajax/?',
	    'avatar/ajax/',
	    mdh_current_plugin_name() . '/ajax.php',
	    true
	);
}

?>