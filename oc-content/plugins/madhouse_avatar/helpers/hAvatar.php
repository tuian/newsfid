<?php


/**
 * HELPERS
 */


/*
 * ==========================================================================
 *  URL
 * ==========================================================================
 */

/**
 * Get route admin url
 * @return string $url
 */
function mdh_avatar_settings_url() {
	return osc_route_admin_url(mdh_current_plugin_name());
}

/**
 * Get route do admin url
 * @return string $url
 */
function mdh_avatar_do_url() {
	return osc_route_admin_url(mdh_current_plugin_name() . "_do");
}

/**
 * Get route move admin url
 * @return string $url
 */
function mdh_avatar_move_url() {
	return osc_route_admin_url(mdh_current_plugin_name() . "_move");
}

/**
 * Get route move admin url
 * @return string $url
 */
function mdh_avatar_ajax_url() {
	return osc_route_ajax_url(mdh_current_plugin_name() . "_ajax");
}

/**
 * Get route regenerate admin url
 * @return string $url
 */
function mdh_avatar_regenerate_url() {
	return osc_route_admin_url(mdh_current_plugin_name() . "_regenerate");
}

/**
 * Get route delete admin url
 * @return string $url
 */
function mdh_avatar_delete_resource_url($id) {
	return osc_route_admin_url(mdh_current_plugin_name() . "_delete", array('id' => $id));
}

/*
 * ==========================================================================
 *  USER RESOURCES FOLDER
 * ==========================================================================
 */

/**
 * Return folder name of user resources
 * @return string folder name
 */
function mdh_avatar_content_folder() {
	return "user_resources";
}

/**
 * Return base path of the folder containing all resources
 * @param  string $file specific file name
 * @return string       Full path
 */
function mdh_avatar_path_content($file="") {
	return osc_uploads_path() . mdh_avatar_content_folder() . "/". $file;
}

/**
 * Return base url of the folder containing all resources
 * @param  string $file specific file name
 * @return string       Full url
 */
function mdh_avatar_url_content($file="") {
	return osc_base_url() . 'oc-content/uploads/' . mdh_avatar_content_folder(). '/' . $file;
}

/*
 * ==========================================================================
 *  PARAMETERS
 * ==========================================================================
 */

// Return normal dimensions
function mdh_avatar_normal_dimensions() {
	return(osc_get_preference('urDimNormal', mdh_current_preferences_section()));
}

// Return preview dimensions
function mdh_avatar_preview_dimensions() {
	return(osc_get_preference('urDimPreview', mdh_current_preferences_section()));
}

// Return thumbnail dimensions
function mdh_avatar_thumbnail_dimensions() {
	return(osc_get_preference('urDimThumbnail', mdh_current_preferences_section()));
}

// Return nav dimensions
function mdh_avatar_nav_dimensions() {
	return(osc_get_preference('urDimNav', mdh_current_preferences_section()));
}

/*
 * ==========================================================================
 *  USER RESOURCES HELPERS
 * ==========================================================================
 */

/**
 * Gets a specific field from current user
 *
 * @param string $field
 * @param string $locale
 * @return mixed
 */
function mdh_avatar_field($userId, $field, $locale = "") {
	if (View::newInstance()->_exists('user_resource') ) {
		$data = View::newInstance()->_get('user_resource');
		if (array_key_exists($userId, $data)) {
			return osc_field($data[$userId], $field, $locale);
		} else {
			return null;
		}
	}
}

/**
 * Export data from user resource for on user (avoid export if a specific user resource is already exported)
 * @param  integer $userId user id
 * @return mixed
 */
function md_ur_export_data($userId) {
	$data = array();
	$result = array();
	if ( !View::newInstance()->_exists('user_resource') ) {
		$result = Madhouse_Avatar_Model::newInstance()->getResource($userId);

    } else {
    	$data = View::newInstance()->_get('user_resource');
    	if (	!array_key_exists($userId, $data)) {
    		$result = Madhouse_Avatar_Model::newInstance()->getResource($userId);
    	}
    }

    if(count($result) > 0 ) {
		$data[$userId] = $result;
		View::newInstance()->_exportVariableToView('user_resource',  $data);
	}
}

/**
 * Return the no photo url
 * @param  string $format format of the picture (nav, normal, preview, thumbnail)
 * @return stirng         no photo url
 */
function mdh_avatar_no_user_resource_url($format="") {
	$foramt = "_".$format;
    return (string) mdh_avatar_url_content()."0". $format.".jpg";
}

/**
 * Test if a user has a resource
 * @param  integer $userId user id
 * @return boolean         true if a user as aresource
 */
function mdh_avatar_has_user_resource($userId = null) {

	//export data form user resources table
	md_ur_export_data($userId);

	$data = array();
	if($userId == "") {
        $userId = osc_logged_user_id();
	}

	$data = View::newInstance()->_get('user_resource');

	if (!empty($data) && array_key_exists($userId, $data)) {
		return true;
	} else {
		return null;
	}
}

/**
 * Return avatar url
 * @param  integer $userId user id
 * @param  string $ext     picture extension
 * @return string          avatar url
 */
function mdh_avatar_url($userId = null, $ext="") {
	if(!isset($userId)) {
		$userId = osc_logged_user_id();
	}

	md_ur_export_data($userId);

	if (mdh_avatar_has_user_resource($userId)) {
		if(!file_exists(osc_base_path() . mdh_avatar_field($userId, "s_path") . mdh_avatar_field($userId, "pk_i_id") . $ext . "." . mdh_avatar_field($userId, "s_extension"))) {
			return mdh_avatar_no_user_resource_url($ext);
		}
		// Normal case.
		return osc_base_url() . mdh_avatar_field($userId, "s_path") . mdh_avatar_field($userId, "pk_i_id") . $ext . "." . mdh_avatar_field($userId, "s_extension");
	} else {
		return mdh_avatar_no_user_resource_url($ext);
	}
}

/**
 * Return avatar url
 * @deprecated deprecated since version 1.4 use instead mdh_avatar_url()
 * @param  integer $userId user id
 * @param  string $ext     picture extension
 * @return string          avatar url
 */
function madhouse_ur_avatar_url($userId = null, $ext="") {
	return mdh_avatar_url($userId, $ext);
}

/**
 * Get nav url of a user
 * @param  integer $userId user id
 * @return string          avatar url
 */
function mdh_avatar_nav_url($userId=null) {
	return mdh_avatar_url($userId, "_nav");
}

/**
 * Get thumbnail url of a user
 * @param  integer $userId user id
 * @return string          avatar url
 */
function mdh_avatar_thumbnail_url($userId=null) {
	return mdh_avatar_url($userId, "_thumbnail");
}

/**
 * Get preview url of a user
 * @param  integer $userId user id
 * @return string          avatar url
 */
function mdh_avatar_preview_url($userId=null) {
	return mdh_avatar_url($userId, "_preview");
}

/**
 * Get normal url of a user
 * @param  integer $userId user id
 * @return string          avatar url
 */
function mdh_avatar_normal_url($userId=null) {
	return mdh_avatar_url($userId);
}

/**
 * Get nav url of a user
 * @deprecated deprecated since version 1.4 use instead mdh_avatar_nav_url()
 * @param  integer $userId user id
 * @return string          avatar url
 */
function madhouse_ur_nav_url($userId=null) {
	return mdh_avatar_nav_url($userId);
}

/**
 * Get thumbnail url of a user
 * @deprecated deprecated since version 1.4 use instead mdh_avatar_thumbnail_url()
 * @param  integer $userId user id
 * @return string          avatar url
 */
function madhouse_ur_thumbnail_url($userId=null) {
	return mdh_avatar_thumbnail_url($userId);
}

/**
 * Get preview url of a user
 * @deprecated deprecated since version 1.4 use instead mdh_avatar_preview_url()
 * @param  integer $userId user id
 * @return string          avatar url
 */
function madhouse_ur_preview_url($userId=null) {
	return mdh_avatar_preview_url($userId);
}

/**
 * Get normal url of a user
 * @deprecated deprecated since version 1.4 use instead mdh_avatar_normal_url()
 * @param  integer $userId user id
 * @return string          avatar url
 */
function madhouse_ur_normal_url($userId=null) {
	return mdh_avatar_normal_url($userId);
}

?>