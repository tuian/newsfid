<?php
require '../../../oc-load.php';
require 'functions.php';
$user_id = osc_logged_user_id();
$data = new DAO();
$data->dao->select('item.*, item_location.*, item_user.pk_i_id as item_user_id, item_user.has_private_post as item_user_has_private_post');
$data->dao->join(sprintf('%st_item_location AS item_location', DB_TABLE_PREFIX), 'item_location.fk_i_item_id = item.pk_i_id', 'INNER');
$data->dao->join(sprintf('%st_user AS item_user', DB_TABLE_PREFIX), 'item_user.pk_i_id = item.fk_i_user_id', 'INNER');
//$data->dao->join(sprintf('%st_user_share_item AS item_share', DB_TABLE_PREFIX), 'item_share.user_id = item.fk_i_user_id', 'INNER');
$data->dao->from(sprintf('%st_item AS item', DB_TABLE_PREFIX));

$item = get_item_inprogress($user_id);
$i = array_unique($item);
$pre = implode(',', $i);

$data->dao->where(sprintf("item.pk_i_id IN(%s)", $pre));
$data->dao->orderBy('item.dt_pub_date', 'DESC');

$page_number = isset($_REQUEST['page_number']) ? $_REQUEST['page_number'] : 0;
$offset = 10;
$start_from = $page_number * $offset;
$data->dao->limit($start_from, $offset);
$result = $data->dao->get();
if ($result) {
    $items = $result->result();
} else {
    $items = array();
}

$pack = get_user_pack_details(osc_logged_user_id());
if ($items):
    $item_result = Item::newInstance()->extendData($items);
    $conn = DBConnectionClass::newInstance();
    $data = $conn->getOsclassDb();
    $comm = new DBCommandClass($data);
    $db_prefix = DB_TABLE_PREFIX;

    foreach ($item_result as $k => $item):
        osc_query_item(array('id' => $item['pk_i_id'], 'results_per_page' => 1000));
        while (osc_has_custom_items()):
            $item_id = osc_item_id();
            $user = get_user_data(osc_item_user_id());
            ?>
            <div id="box" class="box_<?php echo $item['pk_i_id'] ?>">
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <div class="user-block">
                            <div class="user_image">
                                <?php get_user_profile_picture($user['user_id']); ?>
                            </div>                        <span class="username"><a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>"><?php echo $user['user_name'] ?></a></span>
                            <span class="description"><?php echo time_elapsed_string(strtotime($item['dt_pub_date'])); ?>
                                <?php if (osc_logged_user_id() == $user['user_id']): ?>
                                    <button type="button" class="btn btn-box-tool pull-right dropdown"><i class="fa fa-chevron-down" data-toggle="dropdown"></i>
                                        <ul class="dropdown-menu padding-10" role="menu" aria-labelledby="menu1">
                                            <li class="delete_post" data-user-id="<?php echo $user['user_id'] ?>" data-post-id="<?php echo $item_id; ?>"><a><!--Supprimer la publication--><?php _e("Delete", 'flatter') ?></a></li>
                                            <li class="edit_user_post" item_id="<?php echo $item_id; ?>"><a><!--Modifier--> <?php _e("Edit", 'flatter') ?></a></li>
                                            <?php
                                            $items = get_item_premium();
                                            if (!in_array($item_id, $items)):
                                                $pack = get_user_pack_details(osc_logged_user_id());
                                                if ($pack['remaining_post'] == 0):
                                                    ?>
                                                    <li class="premium" data-toggle="modal" data-target="#marketing" item_id="<?php echo $item_id; ?>"><a> <?php _e("Premium", 'flatter') ?></a></li>

                                                <?php else: ?>
                                                    <li class="premium add_premium_post"><a href="javascript:void(0)"><?php _e("Premium", 'flatter') ?> </a></li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <!--                      <li class="disabled light_gray padding-left-10per">Sponsoriser</li>
                                                                  <li class="disabled light_gray padding-left-10per">Remonter en tête de liste</li>
                                                                  <li><a></a></li>
                                                                  <li><a>Signaler la publication</a></li>-->
                                        </ul>
                                    </button>
                                <?php endif; ?>
                            </span>
                            <div id="premium-popup"></div>
                            <div id="marketing" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">                                            
                                            <div class="bold blue_text center-contant"><?php _e("Newsfid Marketing", 'flatter') ?></div>
                                        </div>
                                        <div class="modal-body padding-bottom-10">
                                            <div class="center-contant">
                                                <?php
                                                $pack = get_user_pack_details(osc_logged_user_id());
                                                if (!$pack['remaining_post'] == 0):
                                                    ?>
                                                    <div class="premium-success">
                                                        <h4><span  class="bold"> <?php _e("You've done it great", 'flatter') ?></span></h4>
                                                        <div class="col-md-10 padding-0 padding-bottom-6per">
                                                            <?php _e("We are delighted to let you know that you started an adverting campaing on Newsfid. Your promoted post is now online during next 48 hours" , 'flatter') ?>
                                                            
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="premium-fail">
                                                        <div class="col-md-10 padding-0 padding-bottom-10">
                                                            <?php _e("We are very sorry for the inconvenience but your balance is two low for now .Thank you to top up in order to promote that post.", 'flatter') ?>
                                                            
                                                        </div>
                                                        <div class="col-md-10 padding-0 padding-bottom-10">
                                                            <?php _e("if you are a partner organization just contact us at services@newsfid.com and we'll do it for you.", 'flatter') ?>
                                                            
                                                        </div>
                                                        <div class="col-md-10 padding-0 padding-bottom-13per text-gray">
                                                            <?php _e("You can get up to $2000 balance credit. To give you an idea it means that you can promote 2k posts without spending your money at all.", 'flatter') ?>
                                                            
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div><div class="clearfix"></div>
                                        <div class="modal-footer padding-bottom-20">
                                            <div class="center-contant">
                                                <?php
                                                $pack = get_user_pack_details(osc_logged_user_id());
                                                if (!$pack['remaining_post'] == 0):
                                                    ?>
                                                    <button class="btn  btn-info pull-left button-box bold"><a href="<?php echo osc_user_public_profile_url(osc_logged_user_id()); ?>"><?php _e("Thanks", 'flatter') ?></a></button>
                                                <?php else : ?>
                                                    <button class="btn  btn-info pull-left button-box bold" data-dismiss="modal"><?php _e("Thanks", 'flatter') ?></button>
                                                <?php endif; ?>
                                                <button class="btn pull-left button-box btn-default adverting-btn bold"><a href="<?php echo osc_current_web_theme_url() . 'promoted_post_pack.php' ?>"><?php _e("Go to adverting account", 'flatter') ?></a></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.user-block -->
                        <!--                    <div class="box-tools">
                                                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                                                    <i class="fa fa-circle-o"></i></button>
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                            </div>-->
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p class="item_title_head" data_item_id="<?php echo osc_item_id(); ?>"><?php echo osc_item_title(); ?></p>

                        <?php
                        if ($item['item_type']):
                            item_resources(osc_item_id());
                        endif;
                        ?>

                        <p><?php //echo osc_highlight(osc_item_description(), 200);                                                                                  ?></p>

                        <?php echo item_like_box(osc_logged_user_id(), osc_item_id()) ?>

                        &nbsp;&nbsp;

                        <?php echo user_share_box(osc_logged_user_id(), osc_item_id()) ?>

                        &nbsp;&nbsp;&nbsp;
                        <span class="comment_text"><i class="fa fa-comments"></i>&nbsp;<span class="comment_count_<?php echo osc_item_id(); ?>"><?php echo get_comment_count(osc_item_id()) ?></span>&nbsp;
                            <?php echo 'Comments' ?>
                        </span>
                        &nbsp;&nbsp;
                        <?php echo user_watchlist_box(osc_logged_user_id(), osc_item_id()) ?>
                    </div>
                    <!-- /.box-body -->

                    <div class="cmnt comments_container_<?php echo osc_item_id(); ?>">                    
                        <?php
                        $c_data;
                        $comments_data = new DAO();
                        $comments_data->dao->select(sprintf('%st_item_comment.*', DB_TABLE_PREFIX));
                        $comments_data->dao->from(sprintf('%st_item_comment', DB_TABLE_PREFIX));
                        $conditions = array('fk_i_item_id' => osc_item_id(),
                            'b_active' => 1,
                            'b_enabled' => 1);
                        //$comments_data->dao->limit(3);
                        $comments_data->dao->where($conditions);
                        $comments_data->dao->orderBy('dt_pub_date', 'ASC');
                        $comments_result = $comments_data->dao->get();
                        $c_data = $comments_result->result();
                        ?>
                        <?php
                        if ($c_data):
                            ?>
                            <?php if (count($c_data) > 3): ?>
                                <div class="box-body">
                                    <span class="load_more_comment"> <i class="fa fa-plus-square-o"></i> <?php _e("Display", 'flatter') ?> <?php echo count($c_data) - 3 ?>  <?php _e(" comments more ", 'flatter') ?></span>
                                    <span class="comment_count"><?php echo count($c_data) - 3 ?></span>
                                </div>
                            <?php endif; ?>
                            <?php
                            $total_comment = count($c_data);
                            foreach ($c_data as $k => $comment_data):
                                $comment_user = get_user_data($comment_data['fk_i_user_id']);
                                if ($k < $total_comment - 3 && !$load_more):
                                    $load_more = 'load more';
                                    echo '<div class="load_more">';
                                endif;
                                ?>
                                <div class="box-footer box-comments <?php echo $comment_data['fk_i_user_id'] == $item['fk_i_user_id'] ? 'border-blue-left' : '' ?>">
                                    <div class="box-comment">
                                        <!-- User image -->
                                        <div class="comment_user_image">
                                            <?php get_user_profile_picture($comment_user['user_id']) ?>
                                        </div>
                                        <div class="comment-text">
                                            <span class="username">
                                                <a href="<?php echo osc_user_public_profile_url($comment_user['user_id']) ?>"> <?php echo $comment_user['user_name'] ?> </a>
                                                <span class="text-muted margin-left-5"><?php echo time_elapsed_string(strtotime($comment_data['dt_pub_date'])) ?></span>
                                            </span><!-- /.username -->
                                            <?php echo $comment_data['s_body']; ?>
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
                                <?php
                                $current_user = get_user_data(osc_logged_user_id());
                                ?>
                                <div class="comment_user_image">
                                    <?php get_user_profile_picture($current_user['user_id']) ?>
                                </div>                            <!-- .img-push is used to add margin to elements next to floating images -->
                                <div class="img-push">
                                    <textarea class="form-control input-sm comment_text" placeholder="<?php _e("Press enter to post comment", 'flatter') ?>"></textarea>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                    <!-- /.box-footer -->
                </div>
            </div>
            <?php
        endwhile;
    endforeach;
    ?>
    <?php
else:
    echo '<div class="usepost_no_record"><h2 class="result_text">'. _e("Nothing to show off for now.", 'flatter') .'</h2>Thanks to try later</div> ';
endif;
?>

<script>
    $(document).on('click', '.add_premium_post', function () {
        var item_id = $(this).attr('item_id');
        var user_id = <?php echo osc_logged_user_id() ?>;
        $.ajax({
            url: "<?php echo osc_current_web_theme_url('promoted_post_ajax.php') ?>",
            type: 'post',
            data: {
                add_premium: 'add_premium',
                item_id: item_id,
                user_id: user_id
            },
            success: function () {
                $('#marketing').modal('show');
            }
        });
    });
    $(document).on('click', '.delete_post', function () {
        var user_id = $(this).attr('data-user-id');
        var post_id = $(this).attr('data-post-id');
        if (confirm('Are Sure Want To Delete This Post')) {
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'delete_post_ajax.php'; ?>",
                type: 'post',
                data: {
                    action: 'delete_post',
                    user_id: user_id,
                    post_id: post_id
                },
                success: function () {
                    $(location).attr('href', '<?php echo osc_user_public_profile_url(osc_logged_user_id()); ?>');
                }
            });
        }
    });
    $(document).on('click', '.edit_user_post', function () {
        var item_id = $(this).attr('item_id');
        $.ajax({
            url: '<?php echo osc_current_web_theme_url() . 'update_user_post.php'; ?>',
            type: 'post',
            data: {
                action: 'update_post',
                item_id: item_id
            },
            success: function (data) {
                $('.free-user-post').html(data);
                $('#popup-free-user-post').modal('show');
            }
        });
    });
</script>