<?php
require_once '../../../oc-load.php';
require_once 'functions.php';
?>

<?php
$item_id = $_REQUEST['item_id'];
osc_query_item(array('id' => $item_id, 'results_per_page' => 1));
while (osc_has_custom_items()):
    ?>

    <!-- Modal -->
    <div id="item_popup_modal" class="modal fade item_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="box-body">
                    <?php //osc_item($item_id); ?>
                    <div id="columns">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="popup">
                                        <?php user_follow_box(osc_logged_user_id(), osc_item_user_id()); ?>
                                        <div class="user-block">
                                            <?php
                                            $user = get_user_data(osc_item_user_id());
                                            if (!empty($user[0]['s_path'])):
                                                $user_image_url = osc_base_url() . $user[0]['s_path'] . $user[0]['pk_i_id'] . "_nav." . $user[0]['s_extension'];
                                            else:
                                                $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                            endif;
                                            ?>
                                            <img class="img-circle" src="<?php echo $user_image_url ?>" alt="<?php echo $user[0]['user_name'] ?>">
                                            <span class="username">
                                                <a href="<?php echo osc_user_public_profile_url($user[0]['user_id']) ?>"><?php echo $user[0]['user_name'] ?></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 item-title">
                                    <h2><?php echo osc_item_title(); ?></h2>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                    <?php if (osc_get_preference('position7_enable', 'flatter_theme') != '0') { ?>
                                        <div id="position_widget"<?php
                                        if (osc_get_preference('position7_hide', 'flatter_theme') != '0') {
                                            echo " class='hidden-xs'";
                                        }
                                        ?>>
                                            <div class="dd-widget position_7">
                                                <?php echo osc_get_preference('position7_content', 'flatter_theme'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div id="content">
                                        <?php item_resources(osc_item_id()) ?>

                                        <div id="itemdetails" class="clearfix">
                                            <div class="description">
                                                <?php echo osc_item_description(); ?>
                                            </div>                                            

                                            <div id="extra-fields">
                                                <?php //osc_run_hook('item_detail', osc_item()); ?>
                                            </div>

                                        </div> <!-- Description End -->

                                    </div><!-- Item Content End -->

                                    <div class="row item-bottom">
                                        <div class="col-md-6 col-md-offset-3"> 
                                            <ul class="social-share">
                                                <li class="facebook">
                                                    <a class="whover" title="" data-toggle="tooltip" href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent('<?php echo osc_item_url(); ?>'), 'facebook-share-dialog', 'height=279, width=575');
                                                            return false;" data-original-title="<?php _e("Share on Facebook", 'flatter'); ?>">
                                                        <i class="fa fa-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="twitter">
                                                    <a class="whover" title="" href="https://twitter.com/intent/tweet?text=<?php echo osc_item_title(); ?>&url=<?php echo osc_item_url(); ?>" data-toggle="tooltip" data-original-title="<?php _e("Share on Twitter", 'flatter'); ?>"><i class="fa fa-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="googleplus">
                                                    <a class="whover" title="" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,height=600,width=600');
                                                            return false;" href="https://plus.google.com/share?url=<?php echo osc_item_url(); ?>" data-toggle="tooltip" data-original-title="<?php _e("Share on Google+", 'flatter'); ?>">
                                                        <i class="fa fa-google-plus"></i>
                                                    </a>
                                                </li>                                               
                                            </ul><!-- Social Share End -->
                                        </div>
                                        <div class="col-md-6">
                                            <?php if (osc_is_web_user_logged_in() && osc_logged_user_id() == osc_item_user_id()) { ?>
                                                <div class="pull-right edit">
                                                    <a class="whover" href="<?php echo osc_item_edit_url(); ?>"  rel="nofollow"><i class="fa fa-pencil"></i></a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-9 col-md-offset-3">
                                            <?php echo item_like_box(osc_logged_user_id(), osc_item_id()) ?>

                                            &nbsp;&nbsp;

                                            <?php echo user_share_box(osc_logged_user_id(), osc_item_id()) ?>

                                            &nbsp;&nbsp;&nbsp;
                                            <span class="comment_text"><i class="fa fa-comments"></i>&nbsp;<span class="comment_count_<?php echo osc_item_id(); ?>"><?php echo get_comment_count(osc_item_id()) ?></span>&nbsp;
                                                <?php echo 'Comments' ?>

                                                &nbsp;&nbsp;
                                                <a href="#"><?php echo 'Tchat' ?></a>&nbsp;
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="comments_container_<?php echo osc_item_id(); ?>">
                                                <?php
                                                $c_data = get_item_comments(osc_item_id());
                                                if ($c_data):
                                                    foreach ($c_data as $k => $comment_data):
                                                        ?>
                                                        <?php
                                                        $comment_user = get_user_data($comment_data['fk_i_user_id']);
                                                        if ($comment_user[0]['s_path']):
                                                            $user_image_url = osc_base_url() . $comment_user[0]['s_path'] . $comment_user[0]['pk_i_id'] . "_nav." . $comment_user[0]['s_extension'];
                                                        else:
                                                            $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                                        endif;
                                                        ?>
                                                        <div class="box-footer box-comments">
                                                            <div class="box-comment">
                                                                <!-- User image -->
                                                                <img class="img-circle" src="<?php echo $user_image_url ?>" alt="<?php echo $comment_user[0]['user_name'] ?>">

                                                                <div class="comment-text">
                                                                    <span class="username">
                                                                        <?php echo $comment_user[0]['user_name'] ?>
                                                                        <span class="text-muted pull-right"><?php echo time_elapsed_string(strtotime($comment_data['dt_pub_date'])) ?></span>
                                                                    </span><!-- /.username -->
                                                                    <?php echo $comment_data['s_body']; ?>
                                                                </div>
                                                                <!-- /.comment-text -->
                                                            </div>                       
                                                        </div>                  
                                                        <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </div>
                                            <!-- /.box-footer -->
                                            <div class="box-footer">
                                                <form class="comment_form" data_item_id="<?php echo osc_item_id() ?>" data_user_id ="<?php echo osc_logged_user_id() ?>" method="post">
                                                    <?php
                                                    $current_user = get_user_data(osc_logged_user_id());
                                                    $current_user_image_url = '';

                                                    if ($current_user[0]['s_path']):
                                                        $current_user_image_url = osc_base_url() . $current_user[0]['s_path'] . $current_user[0]['pk_i_id'] . "_nav." . $current_user[0]['s_extension'];
                                                    else:
                                                        $current_user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                                    endif;
                                                    ?>
                                                    <img class="img-responsive img-circle img-sm" src="<?php echo $current_user_image_url ?>" alt="<?php echo $current_user[0]['user_name'] ?>">
                                                    <!-- .img-push is used to add margin to elements next to floating images -->
                                                    <div class="img-push">
                                                        <input type="text" class="form-control input-sm comment_text" placeholder="Press enter to post comment">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (osc_get_preference('google_adsense', 'flatter_theme') !== '0' && osc_get_preference('adsense_listing', 'flatter_theme') != null) { ?>
                                        <div class="pagewidget">
                                            <div class="gadsense">
                                                <?php echo osc_get_preference('adsense_listing', 'flatter_theme'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!-- Comments Template -->

                                </div><!-- Item Content -->

                                <!-- Sidebar Template -->

                            </div>

                        </div>
                    </div>
                </div>              
            </div>

        </div>
    </div>
<?php endwhile; ?>