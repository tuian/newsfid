<?php

require '../../../oc-load.php';
require 'functions.php';


$db_prefix = DB_TABLE_PREFIX;
$item_id = $_REQUEST[item_id];
$item_data = new DAO();
$item_type = $_REQUEST['post_type'];

if ($item_id) :

    if ($item_type == 'image'):
        $file_name = $_FILES['post_media']['name'];
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
//        $image_extensions = array('png', 'jpg', 'jpeg', 'bmp', 'tiff', 'svg', 'gif', 'jfif', 'PNG', 'JPG', 'JPEG', 'BMP', 'TIFF', 'SVG', 'JFIF', 'GIF');
//        if (!in_array($extension, $image_extensions)):
//            osc_add_flash_error_message(__("Please choose valid format image", 'flatter'));
//            osc_redirect_to(osc_base_url());
//            die;
//        endif;

    endif;

    if ($item_type == 'gif'):
        $file_name = $_FILES['post_media']['name'];
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $image_extensions = array('gif');
        if (!in_array($extension, $image_extensions)):
            osc_add_flash_error_message(__("Please choose gif format image", 'flatter'));
            osc_redirect_to(osc_base_url());
            die;
        endif;
    endif;

    if ($item_type == 'music'):
        $file_name = $_FILES['post_media']['name'];
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $image_extensions = array('mp3', 'mp4');

        if (!in_array($extension, $image_extensions)):
            osc_add_flash_error_message(__("Please choose mp3 or mp4 format file", 'flatter'));
            osc_redirect_to(osc_base_url());
            die;
        endif;
        if ($_FILES['post_media']['size'] > 10000000):
            osc_add_flash_error_message(__("Please choose file less than or equal to 10 mb", 'flatter'));
            osc_redirect_to(osc_base_url());
            die;
        endif;
    endif;
endif;
if ($item_id) :
    $item_resorce = get_user_post_resource($item_id);
    $item['pk_i_id'] = $item_id;
    $item['fk_i_category_id'] = $_REQUEST['sCategory'];
    $item_data->dao->update("{$db_prefix}t_item", $item, array('pk_i_id' => $item_id));

    $item_desc['s_title'] = $_REQUEST['p_title'];
    $item_desc['s_description'] = $_REQUEST['p_disc'];


    $item_data->dao->update("{$db_prefix}t_item_description", $item_desc, array('fk_i_item_id' => $item_id));

    $country = Country::newInstance()->findByCode($_REQUEST['countryId']);
    $region = Region::newInstance()->findByName($_REQUEST['s_region_name']);
    $city = City::newInstance()->findByName($_REQUEST['s_city_name'], $region['pk_i_id']);

    $item_location['fk_i_item_id'] = $item_id;
    $item_location['fk_c_country_code'] = $country['pk_c_code'];
    $item_location['s_country'] = $country['s_name'];
    $item_location['s_address'] = $_REQUEST['s_address'];
    $item_location['fk_i_region_id'] = $region['pk_i_id'];
    $item_location['s_region'] = $region['s_name'];
    $item_location['fk_i_city_id'] = $city['pk_i_id'];
    $item_location['s_city'] = $city['s_name'];
    $item_location['s_city_area'] = $_REQUEST['s_city_area_name'];

    $item_data->dao->update("{$db_prefix}t_item_location", $item_location, array('fk_i_item_id' => $item_id));

    $item_action = new ItemActions();
    $item_pk_id = $item_resorce['pk_i_id'];
    if ($item_type == 'image' || $item_type == 'gif' || $item_type == 'music'):
        item_files_upload($_FILES['post_media'], $item_id, $item_type, $item_pk_id);
    else:
        item_embedcode_upload($_REQUEST['post_media'], $item_id, $item_type, $item_pk_id);
    endif;

    osc_redirect_to(osc_base_url());
    die;

    if ($_REQUEST['redirect'] == 'homepage'):
        osc_redirect_to(osc_base_url());
        die;
    else :
        osc_redirect_to(osc_user_public_profile_url(osc_logged_user_id()));
        die;
    endif;
endif;

function item_files_upload($aResources, $itemId, $item_type, $item_pk_id) {

    $db_prefix = DB_TABLE_PREFIX;
    $item_resource_data = new DAO();
    $folder = osc_uploads_path() . (floor($itemId / 100)) . "/";

    //foreach ($aResources as $key => $error) {
    $tmpName = $aResources['tmp_name'];
    $file_name = $aResources['name'];

    $extension = pathinfo($file_name, PATHINFO_EXTENSION);

//    $item_resource_data->dao->insert("{$db_prefix}t_item_resource", array('fk_i_item_id' => $itemId));

    $item_resource_data->dao->update("{$db_prefix}t_item_resource", array('fk_i_item_id' => $itemId), array('pk_i_id' => $item_pk_id));
    $resourceId = $item_pk_id;

    if (!is_dir($folder)) {
        if (!@mkdir($folder, 0755, true)) {
            return 3; // PATH CAN NOT BE CREATED
        }
    }
    move_uploaded_file($tmpName, $folder . $resourceId . '.' . $extension);
    //osc_copy($tmpName, $folder . $resourceId . '.' . $extension);
    $s_path = str_replace(osc_base_path(), '', $folder);
    $userid = osc_logged_user_id();
    $item_resource_data->dao->update("{$db_prefix}t_item_resource", array(
        's_path' => $s_path
        , 's_name' => osc_genRandomPassword()
        , 's_extension' => $extension,
        's_content_type' => $item_type,
            //, 's_content_type' => $mime
            )
            , array(
        'pk_i_id' => $resourceId
        , 'fk_i_item_id' => $itemId
            )
    );
    $item_resource_data->dao->update("{$db_prefix}t_item", array('item_type' => $item_type, 'dt_mod_date' => date('Y-m-d H:i:s')), array('pk_i_id =' => $itemId, 'fk_i_user_id =' => $userid));
}

function item_embedcode_upload($aResources, $itemId, $item_type, $item_pk_id) {
    $db_prefix = DB_TABLE_PREFIX;
    $item_resource_data = new DAO();
    $s_path = $aResources;
    $userid = osc_logged_user_id();
    $item_resource_data->dao->update("{$db_prefix}t_item_resource", array(
        's_path' => $s_path
        , 's_name' => osc_genRandomPassword(),
//        's_content_type' => $item_type,
            //, 's_extension' => $extension
            //, 's_content_type' => $mime
            )
            , array(
        'pk_i_id' => $item_pk_id
        , 'fk_i_item_id' => $itemId
            )
    );
    $item_resource_data->dao->update("{$db_prefix}t_item", array('item_type' => $item_type, 'dt_mod_date' => date('Y-m-d H:i:s')), array('pk_i_id =' => $itemId, 'fk_i_user_id =' => $userid));
}

?>