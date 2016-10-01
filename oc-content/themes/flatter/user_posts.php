<?php
require '../../../oc-load.php';
require 'functions.php';
$search_name = $_REQUEST['search_name'];
if ($_REQUEST['user_id']):
    $user_id = $_REQUEST['user_id'];
else:
    $user_id = osc_logged_user_id();
endif;
$data = new DAO();
//get_share_post
$share_array = get_user_shared_item($user_id);
if (!empty($share_array)):
    $share_pk_id = implode(',', $share_array);
    $data->dao->select('item.*, CASE WHEN item_share.created IS NOT NULL THEN item_share.created ELSE item.dt_pub_date END as f_date, item_location.*, item_share.*, item_user.pk_i_id as item_user_id, item_user.has_private_post as item_user_has_private_post');
    $data->dao->join(sprintf('%st_user_share_item AS item_share', DB_TABLE_PREFIX), 'item_share.item_id = item.pk_i_id', 'LEFT');
    $data->dao->where(sprintf('(item.pk_i_id IN (%s) OR item.fk_i_user_id =%s) AND item.b_enabled = %s AND item.b_active = %s AND item.b_spam = %s', $share_pk_id, $user_id, 1, 1, 0));
    $data->dao->orderBy('f_date', 'DESC');
else:
    $data->dao->select('item.*, item_location.*, item_user.pk_i_id as item_user_id, item_user.has_private_post as item_user_has_private_post');
    $data->dao->where(sprintf('item.fk_i_user_id =%s AND item.b_enabled = %s AND item.b_active = %s AND item.b_spam = %s', $user_id, 1, 1, 0));
    $data->dao->orderBy('item.dt_pub_date', 'DESC');
endif;

$data->dao->join(sprintf('%st_item_location AS item_location', DB_TABLE_PREFIX), 'item_location.fk_i_item_id = item.pk_i_id', 'INNER');
$data->dao->join(sprintf('%st_user AS item_user', DB_TABLE_PREFIX), 'item_user.pk_i_id = item.fk_i_user_id', 'INNER');
//$data->dao->join(sprintf('%st_user_share_item AS item_share', DB_TABLE_PREFIX), 'item_share.user_id = item.fk_i_user_id', 'LEFT');
$data->dao->from(sprintf('%st_item AS item', DB_TABLE_PREFIX));
//$data->dao->where(sprintf("item_user.s_name LIKE '%s'", '%' . $search_name . '%'));


if (isset($_REQUEST['location_type'])):
    $location_type = $_REQUEST['location_type'];
    $location_id = isset($_REQUEST['location_id']) ? $_REQUEST['location_id'] : '';
    if ($_REQUEST['location_type'] == 'world'):
    elseif ($_REQUEST['location_type'] == 'country'):
        $data->dao->where('item_location.fk_c_country_code', $location_id);
    elseif ($_REQUEST['location_type'] == 'city'):
        if (!empty($location_id)):
            $data->dao->where('item_location.fk_i_city_id', $location_id);
        endif;
    endif;
endif;
if (!empty($_REQUEST['category_id'])):
    $categories = $_REQUEST['category_id'];
    if (Category::newInstance()->isRoot($_REQUEST['category_id'])):
        $categories = array_column(Category::newInstance()->findSubcategories($_REQUEST['category_id']), 'pk_i_id');
        $categories = implode(',', $categories);
    endif;
    $data->dao->where(sprintf('item.fk_i_category_id IN (%s)', $categories));
//else:
    $data->dao->whereIn('item.fk_i_category_id', get_user_categories(osc_logged_user_id()));
endif;

if ($_REQUEST['post_type'] != 'all' && !empty($_REQUEST['post_type'])):
    $data->dao->where('item.item_type', $_REQUEST['post_type']);
endif;



//$following_user = get_user_following_data($user_id);
//$following_user[] = $user_id;
//$current_user_following_users = get_user_following_data(osc_logged_user_id());
//if ($following_user):
//    $following_user[] = $user_id;
//    $data->dao->where(sprintf('item.fk_i_user_id IN (%s)', implode(',', $following_user)));
//else:
//    $data->dao->where(sprintf('item.fk_i_user_id =%s', $user_id));
//endif;
//if ($current_user_following_users):
//    $current_user_following_users = implode(',', $current_user_following_users);
//    $data->dao->where("item_user.has_private_post = 0 OR (item_user.has_private_post = 1 AND item.fk_i_user_id IN ($current_user_following_users))");
//else:
//    $data->dao->where("item_user.has_private_post = '0'");
//endif;
//$following_user = implode(',', $following_user);
//$data->dao->where("item_user.has_private_post = 0 OR (item_user.has_private_post = 1 AND item.fk_i_user_id IN ($following_user))");
//$data->dao->where(sprintf('item.fk_i_user_id =%s', $user_id));
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
            $post_user = get_user_data(osc_item_user_id());
            $user = get_user_data($user_id);
            ?>
            <div id="box" class="box_<?php echo $item['pk_i_id'] ?>">
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <div class="user-block">
                            <div class="user_image">
                                <?php get_user_profile_picture($user['user_id']); ?>
                            </div>  
                            <span class="username">
                                <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>">
                                    <?php echo $user['user_name'] ?>
                                </a> 
                                <?php if (!empty($share_array) && in_array($item['pk_i_id'], $share_array)): ?> 
                                    <sapn>shared <?php
                                        if ($post_user['user_id'] == $user['user_id']):
                                            if ($user['s_gender'] == 'male'):
                                                echo 'his';
                                            else:
                                                echo 'her';
                                            endif;
                                        else:
                                            ?>
                                            <a class="blue_text" href="<?php echo osc_user_public_profile_url($post_user['user_id']) ?>"><?php echo $post_user['user_name']; ?></a>
                                        <?php endif; ?> 
                                        post
                                    </sapn>
                                <?php endif; ?>
                            </span>
                            <span class="description"> <?php
                                if (!empty($share_array) && in_array($item['pk_i_id'], $share_array)):
                                    $i = get_user_shared_item_details($item['pk_i_id']);
                                    echo time_elapsed_string(strtotime($i['created']));
                                else:
                                    echo time_elapsed_string(strtotime($item['dt_pub_date']));
                                endif;
                                ?>
                                <?php if (osc_logged_user_id() == $user['user_id'] = osc_item_user_id()): ?>
                                    <button type="button" class="btn btn-box-tool pull-right dropdown"><i class="fa fa-chevron-down" data-toggle="dropdown"></i>
                                        <ul class="dropdown-menu padding-10" role="menu" aria-labelledby="menu1">
                                            <li class="delete_post" data-user-id="<?php echo $user['user_id'] ?>" data-post-id="<?php echo $item_id; ?>"><a><!--Supprimer la publication-->Delete</a></li>
                                            <li class="edit_user_post" item_id="<?php echo $item_id; ?>"><a><!--Modifier--> Edit</a></li>
                                            <?php
                                            $items = get_item_premium();
                                            if (!in_array($item_id, $items)):
                                                $pack = get_user_pack_details(osc_logged_user_id());
                                                if ($pack['remaining_post'] == 0):
                                                    ?>
                                                    <li class="premium" data-toggle="modal" data-target="#marketing"><a> Promote Now</a></li>

                                                <?php else: ?>
                                                    <li class="premium add_premium_post" item_id="<?php echo $item_id; ?>"><a href="javascript:void(0)"> Promote Now</a></li>
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
                                            <div class="bold blue_text center-contant">Newsfid Marketing</div>
                                        </div>
                                        <div class="modal-body padding-bottom-10">
                                            <div class="center-contant">
                                                <?php
                                                $pack = get_user_pack_details(osc_logged_user_id());
                                                if (!$pack['remaining_post'] == 0):
                                                    ?>
                                                    <div class="premium-success">
                                                        <h4><span  class="bold"> You've done it great</span></h4>
                                                        <div class="col-md-10 padding-0 padding-bottom-6per">
                                                            We are delighted to let you know that you started an adverting campaing on Newsfid. Your promoted post is now online during next 48 hours 
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="premium-fail">
                                                        <div class="col-md-10 padding-0 padding-bottom-10">
                                                            We are very sorry for the inconvenience but your balance is two low for now .Thank you to top up in order to promote that post.
                                                        </div>
                                                        <div class="col-md-10 padding-0 padding-bottom-10">
                                                            if you are a partner organization just contact us at services@newsfid.com and we'll do it for you.
                                                        </div>
                                                        <div class="col-md-10 padding-0 padding-bottom-13per text-gray">
                                                            You can get up to $2000 balance credit. To give you an idea it means that you can promote 2k posts without spending your money at all.
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
                                                    <button class="btn  btn-info pull-left button-box blue-box bold"><a class="font-color-white" href="<?php echo osc_user_public_profile_url(osc_logged_user_id()); ?>">Thanks</a></button>
                                                <?php else : ?>
                                                    <button class="btn  btn-info pull-left button-box bold" data-dismiss="modal">Thanks</button>
                                                <?php endif; ?>
                                                <button class="btn pull-left button-box btn-default adverting-btn bold"><a href="<?php echo osc_current_web_theme_url() . 'promoted_post_pack.php' ?>">Go to adverting account</a></button>
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

                        <p><?php //echo osc_highlight(osc_item_description(), 200);                                                                                          ?></p>

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
                                    <span class="load_more_comment"> <i class="fa fa-plus-square-o"></i> Display <?php echo count($c_data) - 3 ?> comments more </span>
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
                                                <?php echo $comment_user['user_name'];
                                                
                                                if($comment_data['fk_i_user_id'] == osc_logged_user_id()):        
                                                ?>
                                                <div class="dropdown  pull-right">
                                                    <i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-hidden="true"></i>
                                                    <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                                                        <li class="edit_cmnt comment_text_<?php echo $comment_data['pk_i_id']; ?>" data-item-id='<?php echo $item['pk_i_id']; ?>' data_text="<?php echo $comment_data['s_body']; ?>" data_id="<?php echo $comment_data['pk_i_id']; ?>" onclick="editComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item['pk_i_id']; ?>)"><a><?php echo __('Edit'); ?></a></li>
                                                        <li class="delete_cmnt" onclick="deleteComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item['pk_i_id']; ?>)"><a><?php echo __('Delete'); ?></a></li>
                                                    </ul>
                                                </div>
                                                <?php endif; ?>
                                                <span class="text-muted margin-left-5"><?php echo time_elapsed_string(strtotime($comment_data['dt_pub_date'])) ?></span>
                                            </span>
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
                                <?php
                                $current_user = get_user_data(osc_logged_user_id());
                                ?>
                                <div class="comment_user_image">
                                    <?php get_user_profile_picture($current_user['user_id']) ?>
                                </div>                            <!-- .img-push is used to add margin to elements next to floating images -->
                                <div class="img-push">
                                    <textarea class="form-control input-sm comment_text" placeholder="Press enter to post comment"></textarea>
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
    echo '<div class="usepost_no_record"><h2 class="result_text">Nothing to show off for now.</h2>Thanks to try later</div> ';
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
    
    $(document).on('blur', '.user_comment_textbox', function () {
            var new_text = $(this).val();
            var data_id = $(this).attr('data_id');
            var item_id = $(this).attr('data-item-id');
            if (!new_text) {
                return false;
            }
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'item_comment_ajax.php'; ?>",
                method: 'post',
                data: {
                    action: 'user_comment',
                    comment_text: new_text,
                    comment_id: data_id,
                    item_id: item_id
                },
                success: function (data, textStatus, jqXHR) {
                    $('.comment_edt_' + data_id).html(new_text);
                    $('.comment_edt_' + data_id).attr('data-text', new_text);
                }
            });
            //$('.user_website_text').html(new_text).attr('data_text', new_text);
        });
    function editComment(comment_id, data_item_id) {
        var text = $('.comment_edt_' + comment_id).attr('data-text');
        var input_box = '<input type="text" class="user_comment_textbox" data-item-id="' + data_item_id + '" data_id="' + comment_id + '" value="' + text + '">';
        $('.comment_edt_' + comment_id).html(input_box);
    }
    function deleteComment(comment_id, data_item_id) {
        $.ajax({
            url: "<?php echo osc_current_web_theme_url() . 'item_comment_ajax.php'; ?>",
            method: 'post',
            data: {
                action: 'user_comment',
                comment_id: comment_id,
                item_id: data_item_id,
                delete: '1'
            },
            success: function (data, textStatus, jqXHR) {
                $('.comments_container_' + data_item_id).replaceWith(data);
                var current_comment_number = $('.comment_count_' + data_item_id).first().html();
                $('.comment_count_' + data_item_id).html(parseInt(current_comment_number) - 1);
            }
        });
    }
</script>