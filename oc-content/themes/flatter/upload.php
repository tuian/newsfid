<?php

$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
$max_file_size = 1000 * 10240; #200kb
$nw = $nh = 500; # image with # height
$cover_height = 500;
$cover_width = 1000;
require_once '../../../oc-load.php';
require_once 'functions.php';
$base_path = osc_themes_path();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image_file']['name'])) {

        if (!$_FILES['image_file']['error'] && $_FILES['image_file']['size'] < $max_file_size) {
            $ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $valid_exts)) {
//					$path = osc_current_web_theme_url() . 'images/15.' . $ext;

                $path = $base_path . 'flatter/images/' . uniqid() . '.' . $ext;
                $size = getimagesize($_FILES['image_file']['tmp_name']);

                $x = (int) $_POST['x'];
                $y = (int) $_POST['y'];
                $w = (int) $_POST['w'] ? $_POST['w'] : $size[0];
                $h = (int) $_POST['h'] ? $_POST['h'] : $size[1];

                $data = file_get_contents($_FILES['image_file']['tmp_name']);
                $vImg = imagecreatefromstring($data);
                $dstImg = imagecreatetruecolor($nw, $nh);
                imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h);
                if ($ext == 'png') {
                    imagepng($dstImg, $path);
                } elseif ($ext == 'jpg' || $ext == 'jpeg') {                    
                    imagejpeg($dstImg, $path);                    
                }
                imagedestroy($dstImg);

                $userId = osc_logged_user_id();
                $files = $_FILES['tmp_name'];
                $tmpName = $files['name'];

                Madhouse_Avatar_Actions::deleteAllResourcesFromUser($userId, false);
                Madhouse_Avatar_Actions::process($path, $userId);
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
                osc_redirect_to(osc_user_public_profile_url(osc_logged_user_id()));
            } else {
                osc_add_flash_error_message(_e("Unknown problem!", 'flatter'));
            }
        } else {
            osc_add_flash_error_message(_e("File is too small or large", 'flatter'));
        }
    } elseif (isset($_FILES['file_cover_img']['name'])) {
        if (!$_FILES['file_cover_img']['error'] && $_FILES['file_cover_img']['size'] < $max_file_size) {
            $ext = strtolower(pathinfo($_FILES['file_cover_img']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $valid_exts)) {
                $userId = osc_logged_user_id();
                $path = osc_plugins_path() . 'profile_picture/images/' . 'profile' . $userId . '.' . $ext;
                $size = getimagesize($_FILES['file_cover_img']['tmp_name']);
                $x = (int) $_POST['x1_cover'];
                $y = (int) $_POST['y1_cover'];
                $w = (int) $_POST['w'] ? $_POST['w'] : $size[0];
                $h = (int) $_POST['h'] ? $_POST['h'] : $size[1];

                $data = file_get_contents($_FILES['file_cover_img']['tmp_name']);
                $vImg = imagecreatefromstring($data);
                $dstImg = imagecreatetruecolor($cover_width, $cover_height);
                imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $cover_width, $cover_height, $w, $h);
                imagepng($dstImg, $path);
//                echo $path;
                imagedestroy($dstImg);
//                die('test');
                $db_prefix = DB_TABLE_PREFIX;
                $user_data = new DAO();
                $user_data->dao->select("user_cover_image.*");
                $user_data->dao->from("{$db_prefix}t_profile_picture as user_cover_image");
                $user_data->dao->where("user_cover_image.user_id", $userId);
                $user_data->dao->limit(1);
                $user_result = $user_data->dao->get();
                $user_array = $user_result->row();
                ;
                if ($user_array):
                    $user_data->dao->update("{$db_prefix}t_profile_picture", array('cover_pic_ext' => $ext), array('user_id' => $userId));
                else:
                    $user_data->dao->insert("{$db_prefix}t_profile_picture", array('user_id' => $userId, 'cover_pic_ext' => $ext));
                endif;
                osc_redirect_to(osc_user_public_profile_url(osc_logged_user_id()));
            } else {
                osc_add_flash_error_message(_e("Unknown problem!", 'flatter'));
            }
        } else {
            osc_add_flash_error_message(_e("File is too small or large", 'flatter'));
        }
    } else {
        osc_add_flash_error_message(_e("File not set!", 'flatter'));
    }
    die;
} else {
    osc_add_flash_error_message(_e("Bad request!", 'flatter'));
}
?>