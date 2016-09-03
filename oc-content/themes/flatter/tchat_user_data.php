<?php
require '../../../oc-load.php';
require 'functions.php';
?>

<?php
if ($_REQUEST['mark_all'] == 'mark_all'):
    $db_prefix = DB_TABLE_PREFIX;
    $read_status['read_status'] = '1';
    $user['from_user_id']= 104;
    $user_id = osc_logged_user_id();
    $mark_all = new DAO();
    $mark_all->dao->update("{$db_prefix}t_user_notifications", $read_status, $user);    
endif;
if ($_REQUEST['mark_read'] == 'mark_read'):
    $db_prefix = DB_TABLE_PREFIX;
    $read_status['read_status'] = '1';
    $user['created'] = $_REQUEST['mark_time'];    
    $mark_all = new DAO();
    $mark_all->dao->update("{$db_prefix}t_user_notifications", $read_status, $user);    
endif;

if ($_REQUEST['mark_unread'] == 'mark_unread'):
    $db_prefix = DB_TABLE_PREFIX;
    $read_status['read_status'] = '0';
    $user['created'] = $_REQUEST['mark_time'];    
    $mark_all = new DAO();    
    $mark_all->dao->update("{$db_prefix}t_user_notifications", $read_status, $user);    
    echo "add";
    die;
endif;

$user_id = $_REQUEST['user_id'];
$user = get_user_data($user_id);
$follow_user_id = $user['user_id'];
$logged_in_user_id = osc_logged_user_id();
?>
<div class="background-white col-md-12 padding-bottom-14per padding-0 box-shadow-black" id="tchat_data">
    <?php
    if ($user['cover_picture_user_id']):
        $cover_image_path = osc_base_url() . 'oc-content/plugins/profile_picture/images/profile' . $user['cover_picture_user_id'] . '.' . $user['pic_ext'];
    else:
        $cover_image_path = osc_current_web_theme_url() . "/images/cover-image.png";
    endif;
    ?>
    <img src="<?php echo $cover_image_path ?>" class="img img-responsive">
    <div class="tchat_profile_pic vertical-row">
        <?php
        if (!empty($user['s_path'])):
            $img_path = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
        else:
            $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
        endif;
        ?>
        <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>"><img src="<?php echo $img_path ?>" height="130px" width="130px" class="background-white padding-10"></a>
        <div class="">
            <i class="fa fa-users" aria-hidden="true"></i> Abonnés 
            <span class="bold padding-left-10"> 
                <?php
                $user_followers = get_user_follower_data($user['user_id']);
                if ($user_followers):
                    echo count($user_followers);
                else:
                    echo 0;
                endif;
                ?>
            </span><br>
            <i class="fa fa-play" aria-hidden="true"></i> Lectures <span class="bold padding-left-10"> 45</span>
        </div>
    </div>
    <div class="col-md-12 tchat-user-name">
        <span class="user_name bold blue_text"><a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>" class="blue_text"><?php echo $user['user_name']; ?></a></span>
    </div>
    <div class="center-contant">
        <?php echo $user['s_city'] ?>-<?php echo $user['s_country'] ?>
        <div class="col-md-12 border-bottom-gray-2px"></div>
    </div>
    <div class="user_desc center-contant">
        <div class="border-bottom-gray padding-top-13per padding-bottom-10">

        </div>
        <div class="border-bottom-gray padding-top-10 padding-bottom-10 light_gray">
            <span class="pointer unfollow_user">  Me désabonner </span>
        </div>
        <div class="border-bottom-gray padding-top-10 padding-bottom-10 light_gray">
            <span class="pointer add_circle"> Ajouter au cercal </span>
        </div>
        <div class="border-bottom-gray padding-top-10 padding-bottom-10 light_gray">
            <span class="pointer"> Bloquer utilisateur </span>
        </div>
        <div class="border-bottom-gray padding-top-10 padding-bottom-10 light_gray">
            <span class="pointer"> Envoyer un fichier </span>
        </div>

    </div>

</div>
<script>
    $(document).on('click', '.unfollow_user', function () {
        var follow_user_id = <?php echo $follow_user_id ?>;
        var logged_in_user_id = <?php echo $logged_in_user_id ?>;
        $.ajax({
            url: '<?php echo osc_current_web_theme_url() . 'unfollow_and_add_circle.php' ?>',
            type: 'post',
            data: {
                action: 'unfollow',
                follow_user_id: follow_user_id,
                logged_in_user_id: logged_in_user_id
            },
            success: function () {

            }
        })
    });

    $(document).on('click', '.add_circle', function () {
        var follow_user_id = <?php echo $follow_user_id ?>;
        var logged_in_user_id = <?php echo $logged_in_user_id ?>;
        $.ajax({
            url: '<?php echo osc_current_web_theme_url() . 'unfollow_and_add_circle.php' ?>',
            type: 'post',
            data: {
                action: 'add_circle',
                follow_user_id: follow_user_id,
                logged_in_user_id: logged_in_user_id
            },
            success: function () {

            }
        })
    });
</script>