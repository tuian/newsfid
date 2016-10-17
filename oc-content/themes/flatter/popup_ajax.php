<style>
    .skin-blue ::-webkit-scrollbar {
        width: 10px; 
    }
    ::-webkit-scrollbar-button {
        background-color: transparent; 
        height: 1px; 
    }
    ::-webkit-scrollbar-corner {
        background-color: #D3D3D3; 
    }
    ::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.3);
        width: 7px;
        border-radius: 30px;
    }
    ::-webkit-scrollbar-track {
        background-color: #fff;
    }
</style>
<?php
require_once '../../../oc-load.php';
require_once 'functions.php';

$item_id = $_REQUEST['item_id'];
if ($item_id):

    function get_item_location($item_id) {
        $item_data = new DAO();
        $db_prefix = DB_TABLE_PREFIX;
        $item_data->dao->select("item.*");
        $item_data->dao->from("{$db_prefix}t_item_location AS item");
        $item_data->dao->where("item.fk_i_item_id= {$item_id}");
        $result = $item_data->dao->get();
        $item = $result->row();
        return $item;
    }

    $item_location = get_item_location($item_id);

    function get_item($item_id) {
        $item = new DAO();
        $db_prefix = DB_TABLE_PREFIX;
        $item->dao->select("cat.*");
        $item->dao->from("{$db_prefix}t_item AS cat");
        $item->dao->where("cat.pk_i_id= {$item_id}");
        $result = $item->dao->get();
        $item_data = $result->row();
        return $item_data;
    }
    ?>

    <!-- Modal -->
    <div id="item_popup_modal" class="modal fade item_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" id="popup_news_close">&times;</button>
                <?php
                $items_pre = get_item_premium();
                if (!empty($items_pre)):
                    $item_rand = array_rand($items_pre);
                    $item_id_pre = $items_pre[$item_rand];
                    $user_pre = get_item($item_id_pre);
                    $user_pre_id = $user_pre['fk_i_user_id'];
                    $item_pre_details = get_item_details($item_id_pre);
                    ?>
                    <div class="col-md-12 padding-0">
                        <div class="col-md-12 background-white">
                            <div class="col-md-12 padding-top-4per">
                                <div class="popup">
                                    <?php
                                    if (osc_logged_user_id() != $user_pre_id):
                                        user_follow_box(osc_logged_user_id(), $user_pre_id);
                                    endif;
                                    ?>
                                    <div class="user-block">
                                        <?php
                                        $user_pr = get_user_data($user_pre_id);
                                        if (!empty($user_pr['s_path'])):
                                            $user_image_url = osc_base_url() . $user_pr['s_path'] . $user_pr['pk_i_id'] . "_nav." . $user_pr['s_extension'];
                                        else:
                                            $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                        endif;
                                        ?>
                                        <img class="img-circle" src="<?php echo $user_image_url ?>" alt="<?php echo $user_pr['user_name'] ?>">
                                        <span class="username">
                                            <a href="<?php echo osc_user_public_profile_url($user_pre_id) ?>"><?php echo $user_pr['user_name'] ?></a>
                                            <div class="">
                                                <i class="fa fa-users" aria-hidden="true"></i>
                                                <span class="padding-left-10"> 
                                                    <?php
                                                    $user_followers = get_user_follower_data($user_pre_id);
                                                    if ($user_followers):
                                                        echo count($user_followers);
                                                    else:
                                                        echo 0;
                                                    endif;
                                                    ?>
                                                </span>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12 post_resource" style="display: none">
                                    <h2> <?php echo $item_pre_details[0]['s_title']; ?> </h2>                    
                                </div>
                                <div class="col-md-5 post_resource_hide padding-0 padding-top-10 padding-bottom-10">
                                    <?php item_resources($item_id_pre); ?>
                                </div>
                                <div class="col-md-12 post_resource padding-0 padding-top-10 padding-bottom-10" style="display: none">
                                    <?php item_resources($item_id_pre); ?>                                    
                                </div>
                                <div class="col-md-7 post_resource_hide">
                                    <div class="bold"> <?php echo $item_pre_details[0]['s_title']; ?> </div>                                   
                                    <?php $desc = $item_pre_details[0]['s_description']; ?>   
                                    <?php custom_echo($desc, 100); ?> <br/>
                                    <button class="get_more"><?php _e("Read More", 'flatter') ?></button>
                                </div>
                                <div class="col-md-12 padding-0 padding-bottom-10"><?php _e("Spotlight", 'flatter') ?>  </div>
                                <div class="col-md-12 post_resource" style="display: none">                                                                   
                                    <?php echo nl2br($item_pre_details[0]['s_description']); ?> 
                                </div>
                            </div>
                            <div class='col-md-12 border-bottom-gray post_resource_hide'></div>
                        </div>
                    </div>
                    <div class="row post_resource" style="display: none;">
                        <div class="col-md-12">
                            <ul class="social-share padding-bottom-20 padding-left-7per">
                                <li>
                                    <?php echo item_like_box(osc_logged_user_id(), $item_id_pre) ?></li>

                                &nbsp;&nbsp;
                                <li>
                                    <?php echo user_share_box(osc_logged_user_id(), $item_id_pre) ?></li>
                                <li>
                                    &nbsp;&nbsp;&nbsp;
                                    <span class="comment_text"><i class="fa fa-comments"></i>&nbsp;<span class="comment_count_<?php echo $item_id_pre; ?>"><?php echo get_comment_count($item_id_pre) ?></span>&nbsp;
                                        <?php echo _e("Comments", 'flatter') ?>
                                    </span></li>
                                &nbsp;&nbsp;
                                <?php if (osc_is_web_user_logged_in()): ?>
                                    <li> <span><?php echo _e("Tchat", 'flatter') ?></span>&nbsp;</li>
                                <?php endif; ?>

                                <li class="facebook margin-left-15">
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
                                <li> 
                                    <?php if (osc_is_web_user_logged_in() && osc_logged_user_id() == $user_pre_id) { ?>
                    <!--                                        <div class="edit edit_post" item_id="<?php echo $item_id_pre; ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </div>-->
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row post_resource" style="display: none">
                        <div class="col-md-12">
                            <div class="cmnt comments_container_<?php echo $item_id_pre; ?>">
                                <?php
                                $c_data = get_item_comments($item_id_pre);
                                if (!empty($c_data)):
                                    if (count($c_data) > 3):
                                        ?>
                                        <div class="box-body">
                                            <span class="load_more_comment"> <i class="fa fa-plus-square-o"></i> <?php _e("Display", 'flatter') ?>  <?php echo count($c_data) - 3 ?>  <?php _e(" comments more", 'flatter') ?> </span>
                                            <span class="comment_count"><?php echo count($c_data) - 3 ?></span>
                                        </div>
                                        <?php
                                    endif;
                                    $total_comment = count($c_data);
                                    foreach ($c_data as $k => $comment_data):
                                        $comment_user = get_user_data($comment_data['fk_i_user_id']);
                                        if ($k < $total_comment - 3 && !$load_more):
                                            $load_more = __("load more", 'flatter');
                                            echo '<div class="load_more">';
                                        endif;
                                        ?>
                                        <?php
                                        if ($comment_user['s_path']):
                                            $user_image_url = osc_base_url() . $comment_user['s_path'] . $comment_user['pk_i_id'] . "_nav." . $comment_user['s_extension'];
                                        else:
                                            $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                        endif;
                                        ?>
                                        <div class="box-footer box-comments <?php echo $comment_data['fk_i_user_id'] == $item['fk_i_user_id'] ? 'border-blue-left' : '' ?>">
                                            <div class="box-comment">
                                                <!-- User image -->
                                                <div class="comment_user_image col-md-1 col-sm-1 padding-0">
                                                    <?php get_user_profile_picture($comment_user['user_id']) ?>
                                                </div>

                                                <div class="comment-area">
                                                    <span class="username">
                                                        <a href="<?php echo osc_user_public_profile_url($comment_user['user_id']); ?>"><?php echo $comment_user['user_name']; ?></a>
                                                        <span class="text-muted padding-left-10"><?php echo time_elapsed_string(strtotime($comment_data['dt_pub_date'])) ?></span>                                                                    
                                                        <?php if ($comment_data['fk_i_user_id'] == osc_logged_user_id()): ?>
                                                            <div class="dropdown  pull-right">
                                                                <i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-hidden="true"></i>
                                                                <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                                                                    <li class="edit_cmnt comment_text_<?php echo $comment_data['pk_i_id']; ?>" data-item-id='<?php echo $item['pk_i_id']; ?>' data_text="<?php echo $comment_data['s_body']; ?>" data_id="<?php echo $comment_data['pk_i_id']; ?>" onclick="editComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item_id; ?>)"><a><?php echo __('Edit'); ?></a></li>
                                                                    <li class="delete_cmnt" onclick="deleteComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item_id; ?>)"><a><?php echo __('Delete') ?></a></li>
                                                                </ul>
                                                            </div>
                                                        <?php endif; ?>
                                                    </span><!-- /.username -->
                                                    <span class="comment_text comment_edt_<?php echo $comment_data['pk_i_id']; ?>" data-text="<?php echo $comment_data['s_body']; ?>">
                                                        <?php echo $comment_data['s_body']; ?>
                                                    </span>
                                                </div>
                                                <!-- /.comment-text -->
                                            </div>                       
                                        </div>                  
                                        <?php
                                        if ($k == (count($c_data) - 4)):
                                            unset($load_more);
                                            echo "</div>";
                                        endif;
                                    endforeach;
                                endif;
                                ?>
                            </div>

                            <!-- /.box-footer -->
                            <?php if (osc_is_web_user_logged_in()): ?>
                                <div class="box-footer">
                                    <form class="comment_form" data_item_id="<?php echo $item_id_pre ?>" data_user_id ="<?php echo osc_logged_user_id() ?>" method="post">
                                        <div class="comment_user_image col-md-1 col-sm-1 padding-0">
                                            <?php get_user_profile_picture(osc_logged_user_id()) ?>
                                        </div>
                                        <!-- .img-push is used to add margin to elements next to floating images -->
                                        <div class="img-push">
                                            <textarea class="form-control input-sm comment_text" placeholder="<?php _e("Press enter to post comment", 'flatter') ?>"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                $item = get_item($item_id);
                osc_query_item(array('id' => $item_id, 'results_per_page' => 1));
                while (osc_has_custom_items()):
                    ?>
                    <div class="post_body">
                        <div class="box-body">
                            <?php //osc_item($item_id);     ?>
                            <div id="columns">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 padding-top-10">
                                            <div class="popup">
                                                <?php
                                                if (osc_logged_user_id() != osc_item_user_id()):
                                                    user_follow_box(osc_logged_user_id(), osc_item_user_id());
                                                endif;
                                                ?>
                                                <div class="user-block">
                                                    <?php
                                                    $user = get_user_data(osc_item_user_id());
                                                    if (!empty($user['s_path'])):
                                                        $user_image_url = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . "_nav." . $user['s_extension'];
                                                    else:
                                                        $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                                    endif;
                                                    ?>
                                                    <img class="img-circle" src="<?php echo $user_image_url ?>" alt="<?php echo $user['user_name'] ?>">
                                                    <span class="username">
                                                        <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>"><?php echo $user['user_name'] ?></a>
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
                                                    <div class="description comment more">
                                                        <?php echo nl2br(osc_item_description()); ?>                                              
                                                    </div>                                            

                                                    <div id="extra-fields">
                                                        <?php //osc_run_hook('item_detail', osc_item());      ?>
                                                    </div>

                                                </div> <!-- Description End -->

                                            </div><!-- Item Content End -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul class="social-share padding-bottom-20">
                                                        <li>
                                                            <?php echo item_like_box(osc_logged_user_id(), osc_item_id()) ?></li>

                                                        &nbsp;&nbsp;
                                                        <li>
                                                            <?php echo user_share_box(osc_logged_user_id(), osc_item_id()) ?></li>
                                                        <li>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <span class="comment_text"><i class="fa fa-comments"></i>&nbsp;<span class="comment_count_<?php echo osc_item_id(); ?>"><?php echo get_comment_count(osc_item_id()) ?></span>&nbsp;
                                                                <?php echo _e("Comments", 'flatter') ?>
                                                            </span></li>
                                                        &nbsp;&nbsp;
                                                        <?php if (osc_is_web_user_logged_in()): ?>
                                                            <li> <span><?php _e("Tchat", 'flatter') ?></span>&nbsp;</li>
                                                        <?php endif; ?>

                                                        <li class="facebook margin-left-15">
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
                                                        <li> 
                                                            <?php if (osc_is_web_user_logged_in() && osc_logged_user_id() == osc_item_user_id()) { ?>
                    <!--                                                                <div class="edit edit_post" item_id="<?php echo osc_item_id(); ?>">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </div>-->
                                                            <?php } ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="cmnt comments_container_<?php echo osc_item_id(); ?>">
                                                        <?php
                                                        $c_data = get_item_comments(osc_item_id());

                                                        if (!empty($c_data)):
                                                            if (count($c_data) > 3):
                                                                ?>
                                                                <div class="box-body">
                                                                    <span class="load_more_comment"> <i class="fa fa-plus-square-o"></i><?php _e("Display", 'flatter') ?>  <?php echo count($c_data) - 3 ?> <?php _e(" comments more", 'flatter') ?>  </span>
                                                                    <span class="comment_count"><?php echo count($c_data) - 3 ?></span>
                                                                </div>
                                                                <?php
                                                            endif;
                                                            $total_comment = count($c_data);
                                                            foreach ($c_data as $k => $comment_data):
                                                                $comment_user = get_user_data($comment_data['fk_i_user_id']);
                                                                if ($k < $total_comment - 3 && !$load_more):
                                                                    $load_more = __("load more", 'flatter');
                                                                    echo '<div class="load_more">';
                                                                endif;
                                                                ?>
                                                                <?php
                                                                if ($comment_user['s_path']):
                                                                    $user_image_url = osc_base_url() . $comment_user['s_path'] . $comment_user['pk_i_id'] . "_nav." . $comment_user['s_extension'];
                                                                else:
                                                                    $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                                                endif;
                                                                ?>
                                                                <div class="box-footer box-comments <?php echo $comment_data['fk_i_user_id'] == $item['fk_i_user_id'] ? 'border-blue-left' : '' ?>">
                                                                    <div class="box-comment">
                                                                        <!-- User image -->
                                                                        <div class="comment_user_image col-md-1 col-sm-1 padding-0">
                                                                            <?php get_user_profile_picture($comment_user['user_id']) ?>
                                                                        </div>

                                                                        <div class="comment-area">
                                                                            <span class="username">
                                                                                <a href="<?php echo osc_user_public_profile_url($comment_user['user_id']); ?>"> <?php echo $comment_user['user_name'] ?></a>
                                                                                <span class="text-muted padding-left-10"><?php echo time_elapsed_string(strtotime($comment_data['dt_pub_date'])) ?></span>                                                                    
                                                                                <?php if ($comment_data['fk_i_user_id'] == osc_logged_user_id()): ?>
                                                                                    <div class="dropdown  pull-right">
                                                                                        <i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-hidden="true"></i>
                                                                                        <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                                                                                            <li class="edit_cmnt comment_text_<?php echo $comment_data['pk_i_id']; ?>" data-item-id='<?php echo $item['pk_i_id']; ?>' data_text="<?php echo $comment_data['s_body']; ?>" data_id="<?php echo $comment_data['pk_i_id']; ?>" onclick="editComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item_id; ?>)"><a><?php echo __('Edit'); ?></a></li>                                                                                       
                                                                                            <li class="delete_cmnt" onclick="deleteComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item_id; ?>)"><a><?php echo __('Delete'); ?></a></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                            </span><!-- /.username -->
                                                                            <span class="comment_text comment_edt_<?php echo $comment_data['pk_i_id']; ?>" data-text="<?php echo $comment_data['s_body']; ?>">
                                                                                <?php echo $comment_data['s_body']; ?>
                                                                            </span>
                                                                        </div>
                                                                        <!-- /.comment-text -->
                                                                    </div>                       
                                                                </div>                  
                                                                <?php
                                                                if ($k == (count($c_data) - 4)):
                                                                    unset($load_more);
                                                                    echo "</div>";
                                                                endif;
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </div>

                                                    <!-- /.box-footer -->
                                                    <?php if (osc_is_web_user_logged_in()): ?>
                                                        <div class="box-footer">
                                                            <form class="comment_form" data_item_id="<?php echo osc_item_id() ?>" data_user_id ="<?php echo osc_logged_user_id() ?>" method="post">
                                                                <div class="comment_user_image col-sm-1 col-md-1 padding-0">
                                                                    <?php get_user_profile_picture(osc_logged_user_id()) ?>
                                                                </div>
                                                                <!-- .img-push is used to add margin to elements next to floating images -->
                                                                <div class="img-push">
                                                                    <textarea class="form-control input-sm comment_text" placeholder=" <?php _e("Press enter to post comment", 'flatter') ?>"></textarea>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <?php
                                                    endif;
                                                    ?>
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
        </div>
    <?php endwhile; ?>
    <script>

        $(document).ready(function () {
            var showChar = 200;
            var ellipsestext = "";
            var moretext = "<?php _e("Read More", 'flatter') ?>";
            var lesstext = "<?php _e("Read Less", 'flatter') ?>";
            $('.more').each(function () {
                var content = $(this).html();
                if (content.length > showChar) {

                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar - 0, content.length - showChar);
                    var html = c + '<span class="moreellipses">' + ellipsestext + '</span><span class="morecontent"><span>' + h + '</span><div><button class="morelink btn margin-top-20 btn-secondary">' + moretext + '</button></div></span>';
                    $(this).html(html);
                }

            });
            $(".morelink").click(function () {
                //$('.moreellipses').hide();
                if ($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });
        });
        $(document).ready(function () {
            $('.error-desc').hide();
            $('.error-title').hide();
            $('.error-term').hide();
            $('.error-btn').hide();
            $('#post_update').submit(function () {
                var title = $('.p_title').val();
                var discription = $('.p_disc').val();
                if (title != '') {
                    $('.error-title').hide();
                } else {
                    $('.error-title').show();
                    $('.error-btn').show();
                    return false;
                }
                if (discription != '')
                {
                    $('.error-desc').hide();
                }
                else {
                    $('.error-desc').show();
                    $('.error-btn').show();
                    return false;
                }

                if (!$("#publier").is(":checked")) {
                    $('.error-term').show();
                    return false;
                }
                return true;
            });
        });
        $(document).on('click', '.edit_post', function () {
            var item_id = $(this).attr('item_id');
            $('#popup_news_close').click();
            $.ajax({
                url: '<?php echo osc_current_web_theme_url() . 'update_user_post.php'; ?>',
                type: 'post',
                data: {
                    action: 'update_post',
                    item_id: item_id
                },
                success: function (data) {
                    $('.free-user-post').html(data);
                    //                                            $('#popup-free-user-post').appendTo("body");
                    $('#popup-free-user-post').modal('show');
                    $('#popup-free-user-post').replaceWith('#item_popup_modal');
                    // $('#popup-free-user-post').appendTo('body');
                }
            });
        });</script>
    <script>
        $(document).ready(function () {
            $('#s_region_name').typeahead({
                source: function (query, process) {
                    var $items = new Array;
                    var c_id = $('#countryId').val();
                    console.log(c_id);
                    if (c_id) {
                        $items = [""];
                        $.ajax({
                            url: "<?php echo osc_current_web_theme_url('region_ajax.php') ?>",
                            dataType: "json",
                            type: "POST",
                            data: {region_name: query, country_id: c_id},
                            success: function (data) {
                                $.map(data, function (data) {
                                    var group;
                                    group = {
                                        id: data.pk_i_id,
                                        name: data.s_name,
                                    };
                                    $items.push(group);
                                });
                                process($items);
                            }
                        });
                    } else {
                        alert('<?php _e("Please select country first", 'flatter') ?>');
                    }
                },
                afterSelect: function (obj) {
                    $('#s_region_id').val(obj.id);
                },
            });
        });</script>
    <script>
        $(document).ready(function () {
            $('#s_city_name').typeahead({
                source: function (query, process) {
                    var $items = new Array;
                    var region_id = $('#s_region_id').val();
                    if (region_id) {
                        $items = [""];
                        $.ajax({
                            url: "<?php echo osc_current_web_theme_url('search_city_by_region.php') ?>",
                            dataType: "json",
                            type: "POST",
                            data: {city_name: query, region_id: region_id},
                            success: function (data) {
                                $.map(data, function (data) {
                                    var group;
                                    group = {
                                        id: data.pk_i_id,
                                        name: data.city_name,
                                    };
                                    $items.push(group);
                                });
                                process($items);
                            }
                        });
                    } else {
                        alert('<?php _e("Please select region first", "flatter") ?>');
                    }
                },
                afterSelect: function (obj) {
                    //$('#sRegion').val(obj.id);
                },
            });
        });</script>
    <script>
        $(".post_type_switch").on('click', function () {
            var $box = $(this);
            if ($box.is(":checked")) {
                var group = ".post_type_switch";
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
            var selected_post_type = $('.post_type_switch').filter(':checked');
            if (selected_post_type.attr('data_post_type') == 'music' || selected_post_type.attr('data_post_type') == 'podcast') {
                var duplicate_post_media = $('#post_media').clone();
                $('#post_media').remove();
                $(selected_post_type).parent().after(duplicate_post_media);
            }
            if (selected_post_type.attr('data_post_type') == 'gif') {
                var duplicate_post_media2 = $('#post_media').clone();
                $('#post_media').remove();
                $(selected_post_type).parent().after(duplicate_post_media2);
            }
            if (selected_post_type.attr('data_post_type') == 'image' || selected_post_type.attr('data_post_type') == 'video') {
                var duplicate_post_media = $('#post_media').clone();
                $('#post_media').remove();
                $('.post_file_upload_container').append(duplicate_post_media);
            }

            if (selected_post_type.attr('data_post_type') == 'podcast' || selected_post_type.attr('data_post_type') == 'video') {
                $('#post_media').attr('type', 'text');
            } else {
                $('#post_media').attr('type', 'file');
            }
        });</script>
    <script>
        $(document).on('change', '.user_role_selector', function () {
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
                data: {
                    action: 'user_role',
                    user_role_id: role_id,
                },
                success: function (data, textStatus, jqXHR) {
                    if (data != 0) {
                        $('.user_role_name').text(data);
                    }
                    $('.user_role_selector').hide();
                    $('.user_role_name').show();
                }
            });
        });

        $(document).on('click', '.get_more', function () {
            $('.post_body').hide('slow');
            $('.get_more').hide('slow');
            $('.post_resource_hide').hide('slow');
            $('.post_resource').show('slow');
        });
    </script>
    <?php
endif;

if ($_REQUEST['maincategory'] == 'maincategory'):
    $Id = $_REQUEST['cat_id'];
    $aSubCategories = Category::newInstance()->findSubcategories($Id);

    foreach ($aSubCategories as $cat):
        ?>
        <option class="subcat margin-left-30" value="<?php echo $cat['fk_i_category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cat['s_name']; ?></option>
        <?php
    endforeach;
endif;
?>