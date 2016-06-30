<?php

class Madhouse_Avatar_Controllers_Admin extends AdminSecBaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Load the settings view.
     */
    private function doSettings()
    {
    }

    /**
     * Upload the no profile picture
     * @return void
     */
    private function noProfileImage() {
        // upload image & move to path
        $status = "";
        $flash_error = "";
        $files = Params::getFiles("no_profile_image");

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
                        $tmpName = $files['tmp_name'][$key];
                        Madhouse_Avatar_Actions::process($tmpName);
                    } else {
                        $status = 'error';
                        $flash_error .= _m('There was a problem uploading the no profile image')."<br />";
                    }
                }
            }
        }


        if( $flash_error != '' ) {
            switch($status) {
                case('error'):
                    osc_add_flash_error_message($flash_error, 'admin');
                break;
                case('warning'):
                    osc_add_flash_warning_message($flash_error, 'admin');
                break;
                default:
                    osc_add_flash_ok_message($flash_error, 'admin');
                break;
            }
        }
    }

    /**
     * Save the settings and redirect to settings view.
     */
    private function doSettingsPost()
    {
        // Set no profile picture
        $this->noProfileImage();

        // Saves the settings
        Madhouse_Utils_Controllers::doSettingsPost(
            array(
                "urDimNav",
                "urDimThumbnail",
                "urDimPreview",
                "urDimNormal",
                "form_post_position",
                "form_edit_position"
            ),
            Params::getParamsAsArray("post"),
            mdh_avatar_settings_url()
        );
    }

    /**
     * Delete all resources from a user
     * @return void
     */
    private function doDelete() {
        $userId = Params::getParam("id");
        if ($userId != "") {
            $aResources = Madhouse_Avatar_Model::newInstance()->getAllResourcesFromUser($userId);
            if (count($aResources) > 0) {
                Madhouse_Avatar_Actions::deleteAllResourcesFromUser($userId, false);
                osc_add_flash_ok_message(__("Profile picture remove", mdh_current_plugin_name()), 'admin');
                $this->redirectTo(osc_admin_base_url(true) . '?page=users&action=edit&id='.$userId);
            } else {
                osc_add_flash_error_message(__("No profifle picture to remove", mdh_current_plugin_name()), 'admin');
                $this->redirectTo(osc_admin_base_url(true) . '?page=users&action=edit&id='.$userId);
            }

        }
    }


    /**
     * Do model, catch all cases of madhouse user resoures for admin
     */
    public function doModel()
    {
        parent::doModel();

        switch (Params::getParam("route")) {
            case mdh_current_plugin_name() . "_do":
                $this->doSettingsPost();
            break;
            case mdh_current_plugin_name() . "_regenerate":
            break;
            case mdh_current_plugin_name() . "_move":
            break;
            case mdh_current_plugin_name() . "_delete":
                $this->doDelete();
            break;
            case mdh_current_plugin_name() . "_settings":
            default:
                $this->doSettings();
            break;
        }
    }
}
?>