<?php

require '../../../oc-load.php';
require 'functions.php';

$db_prefix = DB_TABLE_PREFIX;

$user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());

$item_type = $_REQUEST['post_type'];
if ($item_type):
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

$item_array['fk_i_user_id'] = $user['pk_i_id'];
$item_array['fk_i_category_id'] = $_REQUEST['sCategory'];
if ($item_type):
    $item_array['item_type'] = $item_type;
endif;
$item_array['dt_pub_date'] = date("Y-m-d H:i:s");
$item_array['dt_mod_date'] = date("Y-m-d H:i:s");
$item_array['s_contact_name'] = $user['s_name'];
$item_array['s_contact_email'] = $user['s_email'];
$item_array['s_ip'] = get_ip();
$item_array['b_premium'] = 0;
$item_array['b_enabled'] = 1;
$item_array['b_active'] = 1;
$item_array['b_spam'] = 0;
$item_array['s_secret'] = osc_genRandomPassword();
$item_array['b_show_email'] = 0;
//$item_array['dt_expiration'] = '';

$item_data = new DAO();
$item_data->dao->insert("{$db_prefix}t_item", $item_array);
$item_id = $item_data->dao->insertedId();

if ($item_id) {
    $item_desc['fk_i_item_id'] = $item_id;
    $item_desc['fk_c_locale_code'] = !empty($user['mother_tongue'])?$user['mother_tongue']:'en_US';
    $item_desc['s_title'] = $_REQUEST['p_title'];
    $item_desc['s_description'] = $_REQUEST['p_disc'];
    $item_data->dao->insert("{$db_prefix}t_item_description", $item_desc);

    $country = Country::newInstance()->findByCode($_REQUEST['countryId']);
    $region = Region::newInstance()->findByName($_REQUEST['s_region_name']);
    $city = City::newInstance()->findByName($_REQUEST['s_city_name'], $region['pk_i_id']);

    $item_location['fk_i_item_id'] = $item_id;
    $item_location['fk_c_country_code'] = $country['pk_c_code'];
    $item_location['s_country'] = $country['s_name'];
    $item_location['s_address'] = $_REQUEST['s_address'];
//$item_location['s_zip'] = '';
    $item_location['fk_i_region_id'] = $region['pk_i_id'];
    $item_location['s_region'] = $region['s_name'];
    $item_location['fk_i_city_id'] = $city['pk_i_id'];
    $item_location['s_city'] = $city['s_name'];
//$item_location['fk_i_city_area_id'] = '';
    $item_location['s_city_area'] = $_REQUEST['s_city_area_name'];
//$item_location['d_coord_lat'] = '';
//$item_location['d_coord_long'] = '';

    $item_data->dao->insert("{$db_prefix}t_item_location", $item_location);
    $item = Item::newInstance()->findByPrimaryKey($item_id);
    insert_geo_location($item);

    $item_action = new ItemActions();

    if ($item_type == 'image' || $item_type == 'gif' || $item_type == 'music'):
        item_files_upload($_FILES['post_media'], $item_id, $item_type);
    else:
        item_embedcode_upload($_REQUEST['post_media'], $item_id, $item_type);
    endif;

    osc_redirect_to(osc_base_url());
    die;
}

function item_files_upload($aResources, $itemId, $item_type) {
    $db_prefix = DB_TABLE_PREFIX;
    $item_resource_data = new DAO();
    $folder = osc_uploads_path() . (floor($itemId / 100)) . "/";

    //foreach ($aResources as $key => $error) {
    $tmpName = $aResources['tmp_name'];
    $file_name = $aResources['name'];
    
    $extension = pathinfo($file_name, PATHINFO_EXTENSION);

    $item_resource_data->dao->insert("{$db_prefix}t_item_resource", array('fk_i_item_id' => $itemId));

    $resourceId = $item_resource_data->dao->insertedId();

    if (!is_dir($folder)) {
        if (!@mkdir($folder, 0755, true)) {
            return 3; // PATH CAN NOT BE CREATED
        }
    }
    move_uploaded_file($tmpName, $folder . $resourceId . '.' . $extension);
    //osc_copy($tmpName, $folder . $resourceId . '.' . $extension);
    $s_path = str_replace(osc_base_path(), '', $folder);
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
}

function item_embedcode_upload($aResources, $itemId, $item_type) {
    $db_prefix = DB_TABLE_PREFIX;
    $item_resource_data = new DAO();
    $item_resource_data->dao->insert("{$db_prefix}t_item_resource", array('fk_i_item_id' => $itemId));
    $resourceId = $item_resource_data->dao->insertedId();
    $s_path = $aResources;
    $item_resource_data->dao->update("{$db_prefix}t_item_resource", array(
        's_path' => $s_path
        , 's_name' => osc_genRandomPassword(),
        's_content_type' => $item_type,
            //, 's_extension' => $extension
            //, 's_content_type' => $mime
            )
            , array(
        'pk_i_id' => $resourceId
        , 'fk_i_item_id' => $itemId
            )
    );
}

?>