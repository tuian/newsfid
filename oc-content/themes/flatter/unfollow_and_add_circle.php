<?php
require '../../../oc-load.php';
require 'functions.php';
?>
<?php
$user_id = osc_logged_user_id();
$logged_in_user_id = $_REQUEST['logged_in_user_id'];
$follow_user_id = $_REQUEST['follow_user_id'];

if ($_REQUEST['action'] == 'unfollow'):
    $follow_value = 0;
    $follow_update = update_user_following($logged_in_user_id, $follow_user_id, $follow_value);
elseif ($_REQUEST['action'] == 'follow' || $_REQUEST['follow'] == 'follow-user'):
    $follow_value = 1;
    $follow_update = follow_user($user_id, $follow_user_id, $follow_value);
elseif ($_REQUEST['follow_remove'] == 'follow-remove'):
    $follow_value = 2;
    $follow_update = update_user_following($user_id, $follow_user_id, $follow_value);
endif;

if ($_REQUEST['action'] == 'add_circle'):
    $circle_value = 1;
    $add_circle = update_user_circle($logged_in_user_id, $follow_user_id, $circle_value);

elseif ($_REQUEST['action'] == 'remove_circle'):
    $circle_value = 0;
    $add_circle = update_user_circle($logged_in_user_id, $follow_user_id, $circle_value);
endif;

if ($_REQUEST['follow'] == 'follow-user' || $_REQUEST['follow_remove'] == 'follow-remove'):
    ?>
    <div class="suggested_user_div">
        <?php
        $logged_in_user_id = osc_logged_user_id();
        $logged_user = get_user_data($logged_in_user_id);
        $suggested_users = get_suggested_users($logged_user['user_id'], 1000);
        $follow_user = (array) get_user_following_data($logged_user['user_id']);
        $suggested_follow_users = array_diff($suggested_users, $follow_user);
        $follow_remove = (array) get_user_following_remove_data($logged_user['user_id']);
        $suggested_users_result = array_diff($suggested_follow_users, $follow_remove);
        $suggested_users_result = get_users_data($suggested_users_result);
        if (!empty($suggested_users_result)):
            ?>
            <div class = "box-header with-border">
                <span class = "bold"> <?php _e("Suggestions", "flatter")
            ?></span>
                <!-- /.box-tools -->
            </div>
            <?php
        endif;
        if ($follow_user != $suggested_users_result):
            if (!empty($suggested_users_result)):
                $i = 0;
                foreach ($suggested_users_result as $suggested_user_array):
                    if (+$i > 3)
                        break;

//                    if (!empty($suggested_user_array)):
//                        if ((get_user_follower_data($suggested_user_array['user_id']))):
                    if (count(get_user_follower_data($suggested_user_array['user_id'])) > '0'):
                        ?>
                        <div class="sugg_box col-md-12 col-xs-12 user margin-bottom-10 user-<?php echo $suggested_user_array['user_id'] ?>">
                            <div class="col-md-3 col-xs-2 padding-0">
                                <?php get_user_profile_picture($suggested_user_array['user_id']) ?>
                            </div>
                            <div class="col-md-9 col-xs-10 padding-right-0">
                                <h5 class="direct-chat-name margin-0"><a href="<?php echo osc_user_public_profile_url($suggested_user_array['user_id']) ?>"><?php echo $suggested_user_array['user_name'] ?></a></h5>  

                                <span class=""><i class="fa fa-users"></i> <?php echo count(get_user_follower_data($suggested_user_array['user_id'])) ?></span>                                                            
                                <div class="col-md-12 padding-0">                                                           
                                    <div class="col-md-offset-2 col-md-4 padding-0 sug_button">                                                           
                                        <button class="follow_users" user-id="<?php echo $suggested_user_array['user_id']; ?>" <?php if (osc_current_user_locale() == 'en_US'): ?> style="padding: 6% 16% !important;" <?php endif; ?>><?php _e('Follow', 'flatter'); ?></button>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 padding-left-10 <?php if (osc_current_user_locale() == 'fr_FR'): ?> margin-left-15 <?php endif; ?>">             
                                        <button class="button-gray-box follow_remove" user-id="<?php echo $suggested_user_array['user_id']; ?>"> <?php _e('Remove', 'flatter'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <?php
                    endif;
//                        endif;
//                    endif;
                    $i++;
                endforeach;
            endif;
            ?>
        </div>
        <?php
    endif;
endif;
//osc_redirect_to(osc_base_url());
?>
<script>


</script>