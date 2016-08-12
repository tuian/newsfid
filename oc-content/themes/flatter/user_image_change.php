<?php

require '../../../oc-load.php';
require 'functions.php';

$userId = osc_logged_user_id();

if ($_REQUEST['type'] == 'profile_image'):
    $files = $_FILES['file'];
    $tmpName = $files['tmp_name'];
    Madhouse_Avatar_Actions::deleteAllResourcesFromUser($userId, false);
    Madhouse_Avatar_Actions::process($tmpName, $userId);
    $user_image_path = Madhouse_Avatar_Model::newInstance()->getResource($userId);
    if (!empty($user_image_path['s_path'])):
        $img_path = osc_base_url() . $user_image_path['s_path'] . $user_image_path['pk_i_id'] . '.' . $user_image_path['s_extension'];
    else:
        $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
    endif;
    echo $img_path;
endif;


if ($_REQUEST['type'] == 'cover_image'):
    $files = $_FILES['file'];
    $tmpName = $files['tmp_name'];
    $filename = $files['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    move_uploaded_file($files['tmp_name'], osc_plugins_path() . 'profile_picture/images/' . 'profile' . $userId . '.' . $ext);
    $db_prefix = DB_TABLE_PREFIX;
    $user_data = new DAO();
    $user_data->dao->select("user_cover_image.*");
    $user_data->dao->from("{$db_prefix}t_profile_picture as user_cover_image");
    $user_data->dao->where("user_cover_image.user_id", $userId);
    $user_data->dao->limit(1);
    $user_result = $user_data->dao->get();
    $user_array = $user_result->row();

    if ($user_array):
        $user_data->dao->update("{$db_prefix}t_profile_picture", array('pic_ext' => $ext), array('user_id' => $userId));
    else:
        $user_data->dao->insert("{$db_prefix}t_profile_picture", array('user_id' => $userId, 'pic_ext' => $ext));
    endif;

    $user_data->dao->select("user_cover_image.*");
    $user_data->dao->from("{$db_prefix}t_profile_picture as user_cover_image");
    $user_data->dao->where("user_cover_image.user_id", $userId);
    $user_data->dao->limit(1);
    $user_result = $user_data->dao->get();
    $user_array = $user_result->row();

    if ($user_array):
        $cover_image_path = osc_base_url() . 'oc-content/plugins/profile_picture/images/profile' . $user_array['user_id'] . '.' . $user_array['pic_ext'];
    else:
        $cover_image_path = osc_current_web_theme_url() . "/images/cover_image.jpg";
    endif;
    echo $cover_image_path;
endif;
?>
