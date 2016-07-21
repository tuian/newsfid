<?php
require '../../../oc-load.php';
require 'functions.php';

//$search_name = $_REQUEST['search_name'];
//$location_type = $_REQUEST['location_type'];
//$location_id = $_REQUEST['location_id'];
$user_id = $_REQUEST['user_id'];
$follower_users = get_user_following_data($user_id);
//print_r($user_id);
//print_r($follower_users);
//die;
if ($follower_users):
//print_r($follower_users);
    $user_search_data = new DAO();
    $user_search_data->dao->select('user.pk_i_id as user_id, user.s_name as user_name, user.s_email, user.fk_i_city_id, user.fk_c_country_code');
    $user_search_data->dao->select('user_resource.pk_i_id, user_resource.fk_i_user_id, user_resource.s_extension, user_resource.s_path');
    $user_search_data->dao->join(sprintf('%st_user_resource AS user_resource', DB_TABLE_PREFIX), 'user.pk_i_id = user_resource.fk_i_user_id', 'LEFT');
    $user_search_data->dao->from(sprintf('%st_user AS user', DB_TABLE_PREFIX));
    $user_search_data->dao->where(sprintf("user.s_name LIKE '%s'", '%' . $search_name . '%'));
//$user_search_data->dao->where(sprintf("user.pk_i_id IN (%s)", osc_logged_user_id()));
    $user_search_data->dao->whereIn("user.pk_i_id", $follower_users);

//if ($location_type !== 'world'):
//    if ($location_type == 'national'):
//        $user_search_data->dao->where("user.fk_c_country_code", $location_id);
//    else:
//        $user_search_data->dao->where("user.fk_i_city_id", $location_id);
//    endif;
//endif;

    $user_search_data->dao->orderBy('user.s_name', 'ASC');
    $user_search_result = $user_search_data->dao->get();
    $user_search_array = $user_search_result->result();

//if ($user_search_array):
    ?>
    <div class="col-md-12">
        <p class="people-result-text"><?php echo '(' . count($user_search_array) . ')' ?> results found </p>
    </div>
    <div class="col-md-12 padding-0 user_serach_box">
        <?php foreach ($user_search_array as $user): ?>
            <div class="col-md-6">
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->

                    <div class="widget-user-header bg-black" style="background: url('<?php echo osc_current_web_theme_url() . "/images/cover_image.jpg" ?>') center center;">
                        <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>" >
                            <h3 class="widget-user-username">
                                <?php echo $user['user_name'] ?>
                            </h3>
                        </a>
                        <h5 class="widget-user-desc">
                            Web Designer
                        </h5>
                    </div>
                    <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>">
                        <div class="widget-user-image">
                            <?php
                            if (!empty($user['s_path'])):
                                $img_path = osc_base_url() . '/' . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>

                            <img class="img-circle" src="<?php echo $img_path ?>" alt=" <?php echo $user['user_name'] ?>">
                        </div>
                    </a>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        <?php
                                        $user_following = get_user_following_data($user['user_id']);
                                        if ($user_following):
                                            echo count($user_following);
                                        else:
                                            echo 0;
                                        endif;
                                        ?>
                                    </h5>
                                    <span class="description-text">
                                        ABONNEMENTS
                                    </span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        <?php
                                        $user_followers = get_user_follower_data($user['user_id']);
                                        if ($user_followers):
                                            echo count($user_followers);
                                        else:
                                            echo 0;
                                        endif;
                                        ?>
                                    </h5>
                                    <span class="description-text">
                                        FOLLOWERS
                                    </span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        <?php
                                        $user_likes = get_user_item_likes($user['user_id']);
                                        if ($user_likes):
                                            echo count($user_likes);
                                        else:
                                            echo 0;
                                        endif;
                                        ?>
                                    </h5>
                                    <span class="description-text">LIKES</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>


            </div>                
        <?php endforeach; ?>
    </div>  

<?php else: ?>
    <div class = "col-md-12 no-of-result">
        <p class = "people-result-text">No people found</p>
    </div>
<?php endif; ?>