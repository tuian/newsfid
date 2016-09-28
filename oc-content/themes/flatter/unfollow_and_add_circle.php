<?php
require '../../../oc-load.php';
require 'functions.php';
?>
<?php
$logged_in_user_id = $_REQUEST['logged_in_user_id'];
$follow_user_id = $_REQUEST['follow_user_id'];
if ($_REQUEST['action'] == 'unfollow'):
    $follow_value = 0;
    $follow_update = update_user_following($logged_in_user_id, $follow_user_id, $follow_value);
elseif ($_REQUEST['action'] == 'follow'):
    $follow_value = 1;
    $follow_update = update_user_following($logged_in_user_id, $follow_user_id, $follow_value);
endif;


if ($_REQUEST['action'] == 'add_circle'):
    $circle_value = 1;
    $add_circle = update_user_circle($logged_in_user_id, $follow_user_id, $circle_value);
elseif ($_REQUEST['action'] == 'remove_circle'):
    $circle_value = 0;
    $add_circle = update_user_circle($logged_in_user_id, $follow_user_id, $circle_value);
endif;

if ($_REQUEST['follow'] == 'follow-user'):
    ?>
    <div class="suggested_user_div">
        <?php
        $logged_in_user_id = osc_logged_user_id();
        $logged_user = get_user_data($logged_in_user_id);
        $suggested_users = get_suggested_users($logged_user['user_id'], 1000);
        $follow_user = (array) get_user_following_data($logged_user['user_id']);
        $suggested_users_result = array_diff($suggested_users, $follow_user);
        if ($follow_user != $suggested_users_result):
            if ($suggested_users_result):
                $i = 0;
                foreach ($suggested_users_result as $s_user):
                    if (+$i > 4)
                        break;
                    $suggested_user_array = get_user_data($s_user);
                    if (!empty($suggested_user_array)):
                        if ((get_user_follower_data($suggested_user_array['user_id']))):
                            ?>
                            <div class="col-md-12 col-xs-12 user margin-bottom-10 user-<?php echo $suggested_user_array['user_id'] ?>">
                                <div class="col-md-3 col-xs-2 padding-0">
                                    <?php get_user_profile_picture($suggested_user_array['user_id']) ?>
                                </div>
                                <div class="col-md-9 col-xs-10 padding-right-0">
                                    <h5 class="direct-chat-name margin-0"><a href="<?php echo osc_user_public_profile_url($suggested_user_array['user_id']) ?>"><?php echo $suggested_user_array['user_name'] ?></a></h5>  

                                    <span class=""><i class="fa fa-users"></i> <?php echo count(get_user_follower_data($suggested_user_array['user_id'])) ?></span>                                                            
                                    <div class="col-md-12 padding-0">                                                           
                                        <div class="col-md-offset-2 col-md-4 padding-0 sug_button">                                                           
                                            <?php
                                            user_follow_btn_box($logged_user['user_id'], $suggested_user_array['user_id']);
                                            ?>
                                        </div>
                                        <div class="col-md-4">         
                                            <button class="button-gray-box">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <?php
                        endif;
                    endif;
                    $i++;
                endforeach;
            else:
                ?>
                <div class="col-md-12 col-xs-12 margin-bottom-10">                                
                    no
                </div> 
            <?php
            endif;
            ?>
        </div>
        <?php
    endif;
endif;
//osc_redirect_to(osc_base_url());
?>
<script>
    $(document).on('click', '.frnd-sug-button', function () {
        var user = $(this).attr('user-data');
        $(user).hide();
        $.ajax({
            url: "<?php echo osc_current_web_theme_url('unfollow_and_add_circle.php') ?>",
            type: "POST",
            data: {
                follow: 'follow-user'
            },
            success: function (data) {
                $('#suggested_user_div').html(data);
            }
        });
    });
</script>