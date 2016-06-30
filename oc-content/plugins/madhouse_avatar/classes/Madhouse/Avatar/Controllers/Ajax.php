<?php

class Madhouse_Avatar_Controllers_Ajax extends AdminSecBaseModel
{
    function __construct()
    {
        parent::__construct();
        $this->ajax = true;
    }

    function doModel()
    {
        parent::doModel();
        switch (Params::getParam("do")) {
            /**
             * do=move
             */
            case "regenerate":
                // Ugly but require for some big images
                ini_set('memory_limit', '248M');
                $avatarManager = Madhouse_Avatar_Model::newInstance();
                $start  = Params::getParam("start");
                $length = Params::getParam("length");
                $processed = Params::getParam("processed");
                $aUserResources = $avatarManager->getResources(null, $start, $length);
                $aIds = array();
                foreach ($aUserResources as $key => $value) {

                    $resourceId = $value["pk_i_id"];
                    $extension = $value["s_extension"];

                    $base_path = osc_base_path(). $value["s_path"] . $resourceId;
                    $normal_path = $path = $base_path  .'_original';
                    // Create normal size
                    $size = explode('x', mdh_avatar_normal_dimensions());

                    if(strpos($value['s_content_type'], 'image')!==false) {
                        if(file_exists($base_path."_original.".$extension)) {
                            array_push($aIds, $value["pk_i_id"] . " (file use : original)");
                            $base_path_source_image = $base_path."_original.".$extension;
                            $use_original = true;
                        } else if(file_exists($base_path.".".$extension)) {
                            array_push($aIds, $value["pk_i_id"] . " (file use : normal)");
                            $base_path_source_image = $base_path.".".$extension;
                            $use_original = false;
                        } else if(file_exists($base_path."_preview.".$extension)) {
                            array_push($aIds, $value["pk_i_id"] . " (file use : preview)");
                            $base_path_source_image = $base_path."_preview.".$extension;
                            $use_original = false;
                        } else {
                            array_push($aIds, $value["pk_i_id"] . " (file not found)");
                            $use_original = false;
                            continue;
                        };

                        $normal_path = $path = osc_base_path().$value['s_path'].$resourceId.'.'.$extension;

                        $img = ImageResizer::fromFile($base_path_source_image)->autoRotate()->resizeTo($size[0], $size[1]);

                        // if($use_original) {
                        //     if( osc_is_watermark_text() ) {
                        //         $img->doWatermarkText(osc_watermark_text(), osc_watermark_text_color());
                        //     } elseif ( osc_is_watermark_image() ){
                        //         $img->doWatermarkImage();
                        //     }
                        // }

                        $img->saveToFile($base_path.".".$extension, $extension);

                        // Create preview
                        $path = $base_path."_preview".".".$extension;
                        $size = explode('x', mdh_avatar_preview_dimensions());
                        ImageResizer::fromFile($base_path_source_image)->resizeTo($size[0], $size[1])->saveToFile($path, $extension);

                        // Create thumbnail
                        $path = $base_path."_thumbnail".".".$extension;
                        $size = explode('x', mdh_avatar_thumbnail_dimensions());
                        ImageResizer::fromFile($base_path_source_image)->resizeTo($size[0], $size[1])->saveToFile($path, $extension);

                        // Create nav
                        $path = $base_path."_nav".".".$extension;
                        $size = explode('x', mdh_avatar_nav_dimensions());
                        ImageResizer::fromFile($base_path_source_image)->resizeTo($size[0], $size[1])->saveToFile($path, $extension);
                    } else {
                        array_push($aIds, $value["pk_i_id"] . ", File isn't an image");
                    }
                }
                echo json_encode(array(
                    "next" => $start+$length,
                    "processed" => $processed + count($aUserResources),
                    "resourcesProcessed" => $aIds
                    )
                );
            break;
            /**
             * do=move
             */
            case "move":
                $avatarManager = Madhouse_Avatar_Model::newInstance();
                $start  = Params::getParam("start");
                $length = Params::getParam("length");
                $processed = Params::getParam("processed");
                $aUserResources = $avatarManager->getResources(null, $start, $length);
                $aIds = array();
                foreach ($aUserResources as $key => $value) {
                    $resourceId = $value["pk_i_id"];

                    $userId = $value["fk_i_user_id"];
                    $extension = $value["s_extension"];

                    $folder = mdh_avatar_path_content().(floor($userId/100))."/";

                    if(!is_dir($folder)) {
                        if (!@mkdir($folder, 0755, true)) {
                            return 3; // PATH CAN NOT BE CREATED
                        }
                    }

                    $base_path = mdh_avatar_path_content() . "profile". $value["fk_i_user_id"];
                    // Create tmp files
                    osc_copy($base_path. "." . $extension, $folder.$resourceId.'.'.$extension);
                    osc_copy($base_path.'_preview.'. $extension, $folder.$resourceId.'_preview.'.$extension);
                    osc_copy($base_path.'_thumbnail.'. $extension, $folder.$resourceId.'_thumbnail.'.$extension);
                    osc_copy($base_path.'_original.'. $extension, $folder.$resourceId.'_original.'.$extension);
                    osc_copy($base_path.'_nav.'. $extension, $folder.$resourceId.'_nav.'.$extension);

                    // Remove tmp files
                    //@unlink($base_path."_normal");
                    //@unlink($base_path."_preview");
                    //@unlink($base_path."_thumbnail");
                    //@unlink($base_path."_nav");
                    //@unlink($base_path);

                    if($userId != 0) {
                        $s_path = str_replace(osc_base_path(), '', $folder);
                        $avatarManager->updateByPrimaryKey(
                            array(
                                's_path'          => $s_path
                                ,'s_content_type' => "image/jpeg"
                            )
                            ,$resourceId
                        );
                    }

                    array_push($aIds, $value["pk_i_id"]);
                }
                echo json_encode(array(
                    "next" => $start+$length,
                    "processed" => $processed + count($aUserResources),
                    "resourcesProcessed" => $aIds
                    )
                );
            break;
            default:
                echo json_encode(array('error' => __('No action defined', mdh_current_plugin_name())));
            break;
        }
    }

}

?>