<?php
class Madhouse_Avatar_Actions {

    /**
     * Process when a profile picture is uploaded
     * @param  string  $tmpName name of the temporary file
     * @param  integer $userId  Self explenation
     * @return void
     */
    public static function process($tmpName, $userId = 0, $install = false) {

        $AvatarManager = Madhouse_Avatar_Model::newInstance();

        if($userId != 0) {
            $folder = mdh_avatar_path_content().(floor($userId/100))."/";
        } else {
            $folder =  mdh_avatar_path_content();
        }

        $imgres = ImageResizer::fromFile($tmpName);
        $extension = osc_apply_filter('upload_image_extension', $imgres->getExt());
        $mime = osc_apply_filter('upload_image_mime', $imgres->getMime());
        // Create normal size
        $normal_path = $path = $tmpName."_normal";
        $size = explode('x', mdh_avatar_normal_dimensions());
        $img = ImageResizer::fromFile($tmpName)->autoRotate()->resizeTo($size[0], $size[1]);

        // if( osc_is_watermark_text() ) {
        // $img->doWatermarkText(osc_watermark_text(), osc_watermark_text_color());
        // } else if ( osc_is_watermark_image() ){
        // $img->doWatermarkImage();
        // }

        $img->saveToFile($path, $extension);

        // Create preview
        $path = $tmpName."_preview";
        $size = explode('x', mdh_avatar_preview_dimensions());
        ImageResizer::fromFile($tmpName)->resizeTo($size[0], $size[1])->saveToFile($path, $extension);

        // Create thumbnail
        $path = $tmpName."_thumbnail";
        $size = explode('x', mdh_avatar_thumbnail_dimensions());
        ImageResizer::fromFile($tmpName)->resizeTo($size[0], $size[1])->saveToFile($path, $extension);

        // Create nav
        $path = $tmpName."_nav";
        $size = explode('x', mdh_avatar_nav_dimensions());
        ImageResizer::fromFile($tmpName)->resizeTo($size[0], $size[1])->saveToFile($path, $extension);

        if($userId != 0) {
            $AvatarManager->insert(array(
                'fk_i_user_id' => $userId
            ));
            $resourceId = $AvatarManager->dao->insertedId();
        } else {
            $resourceId = 0;
        }

        if(!is_dir($folder)) {
            if (!@mkdir($folder, 0755, true)) {
                return 3; // PATH CAN NOT BE CREATED
            }
        }

        // Create tmp files
        osc_copy($tmpName.'_normal', $folder.$resourceId.'.'.$extension);
        osc_copy($tmpName.'_preview', $folder.$resourceId.'_preview.'.$extension);
        osc_copy($tmpName.'_thumbnail', $folder.$resourceId.'_thumbnail.'.$extension);
        osc_copy($tmpName.'_nav', $folder.$resourceId.'_nav.'.$extension);
        if( osc_keep_original_image() ) {
            $path = $folder.$resourceId.'_original.'.$extension;
            osc_copy($tmpName, $path);
        }

        // Remove tmp files
        @unlink($tmpName."_normal");
        @unlink($tmpName."_preview");
        @unlink($tmpName."_thumbnail");
        @unlink($tmpName."_nav");
        if (!$install) {
            @unlink($tmpName);
        }

        if($userId != 0) {
            $s_path = str_replace(osc_base_path(), '', $folder);
            $AvatarManager->update(
                array(
                    's_path'          => $s_path
                    ,'s_name'         => osc_genRandomPassword()
                    ,'s_extension'    => $extension
                    ,'s_content_type' => $mime
                )
                ,array(
                    'pk_i_id'       => $resourceId
                    ,'fk_i_user_id' => $userId
                )
            );
        }

        unset($AvatarManager);
    }

    /**
     * Check size of an array of resources
     * @param  array $aResources array of resources
     * @return boolean           result of check sizes
     */
    public static function checkSize($aResources)
    {
        $success = true;

        if($aResources != '') {
            // get allowedExt
            $maxSize = osc_max_size_kb() * 1024;
            foreach ($aResources['error'] as $key => $error) {
                $bool_img = false;
                if ($error == UPLOAD_ERR_OK) {
                    $size = $aResources['size'][$key];
                    if($size >= $maxSize){
                        $success = false;
                    }
                }
            }
            if(!$success){
                osc_add_flash_error_message( _m("One of the files you tried to upload exceeds the maximum size"));
            }
        }
        return $success;
    }

    /**
     * Check extension of an array of resources
     * @param  array   $aResources array of resources
     * @return boolean             result of check extension
     */
    public static function checkAllowedExt($aResources)
    {
        $success = true;
        require LIB_PATH . 'osclass/mimes.php';
        if($aResources != '') {
            // get allowedExt
            $aMimesAllowed = array();
            $aExt = explode(',', osc_allowed_extension() );
            foreach($aExt as $ext){
                if(isset($mimes[$ext])) {
                    $mime = $mimes[$ext];
                    if( is_array($mime) ){
                        foreach($mime as $aux){
                            if( !in_array($aux, $aMimesAllowed) ) {
                                array_push($aMimesAllowed, $aux );
                            }
                        }
                    } else {
                        if( !in_array($mime, $aMimesAllowed) ) {
                            array_push($aMimesAllowed, $mime );
                        }
                    }
                }
            }
            foreach ($aResources['error'] as $key => $error) {
                $bool_img = false;
                if ($error == UPLOAD_ERR_OK) {
                    // check mime file
                    $fileMime = $aResources['type'][$key];
                    if(stripos($fileMime, "image/")!==FALSE) {
                        if(function_exists("getimagesize")) {
                            $info = getimagesize($aResources['tmp_name'][$key]);
                            if(isset($info['mime'])) {
                                $fileMime = $info['mime'];
                            } else {
                                $fileMime = '';
                            }
                        };
                    };


                    if(in_array($fileMime,$aMimesAllowed)) {
                        $bool_img = true;
                    }
                    if(!$bool_img && $success) {$success = false;}
                }
            }

            if(!$success){
                osc_add_flash_error_message( _m("The file you tried to upload does not have a valid extension"));
            }
        }
        return $success;
    }

    /**
     * Remove a specific resource from disk
     * @param integer $id
     * @param boolean $admin
     * @return void
     */
    public static function deleteResource($id , $admin) {

        $resource = Madhouse_Avatar_Model::newInstance()->findByPrimaryKey($id);
        if( !is_null($resource) ){
            Log::newInstance()->insertLog('user', 'delete user resource', $resource['pk_i_id'], $id,  $admin?'admin':'user', $admin ? osc_logged_admin_id() : osc_logged_user_id());

            // $backtracel = '';
            // foreach(debug_backtrace() as $k=>$v){
            //     if($v['function'] == "include" || $v['function'] == "include_once" || $v['function'] == "require_once" || $v['function'] == "require"){
            //         $backtracel .= "#".$k." ".$v['function']."(".$v['args'][0].") called@ [".$v['file'].":".$v['line']."] / ";
            //     }else{
            //         $backtracel .= "#".$k." ".$v['function']." called@ [".$v['file'].":".$v['line']."] / ";
            //     }
            // }

            // Log::newInstance()->insertLog('user resource', 'delete user resource backtrace', $resource['pk_i_id'], $backtracel,  $admin?'admin':'user', $admin ? osc_logged_admin_id() : osc_logged_user_id());

            // to change if id resource is pk_i_id

            @unlink(osc_base_path() . $resource['s_path'] . $resource['pk_i_id'] . "." .  $resource['s_extension']);

            @unlink(osc_base_path() . $resource['s_path'] . $resource['pk_i_id'] . "_original." .$resource['s_extension']);
            @unlink(osc_base_path() . $resource['s_path'] . $resource['pk_i_id'] ."_thumbnail." .$resource['s_extension']);
            @unlink(osc_base_path() . $resource['s_path'] . $resource['pk_i_id'] . "_preview."  .$resource['s_extension']);
            @unlink(osc_base_path() . $resource['s_path'] . $resource['pk_i_id'] . "_nav."      .$resource['s_extension']);
        }
    }

    /**
     * Remove resources from disk
     * @param integer $id
     * @param boolean $admin
     * @return void
     */
    public static function deleteAllResourcesFromUser($userId , $admin) {

        $aResources = Madhouse_Avatar_Model::newInstance()->getResources($userId);

        if (count($aResources) > 0) {
            foreach ($aResources as $key => $resource) {
                if($resource['fk_i_user_id']==$userId) {
                    self::deleteResource($resource["pk_i_id"], $admin);
                    Log::newInstance()->insertLog('user resource hook', 'delete resource', $resource['pk_i_id'], $resource['fk_i_user_id'], 'user', $userId);
                    Madhouse_Avatar_Model::newInstance()->delete(array('pk_i_id' => $resource['pk_i_id'], 'fk_i_user_id' => $userId) );
                }
            }
        }
    }


}

?>