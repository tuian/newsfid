<?php
error_reporting(0);
require '../../../oc-load.php';
require 'functions.php';
$language = isset($_SESSION['userLocale']) ? $_SESSION['userLocale'] : osc_locale_code();
$db_prefix = DB_TABLE_PREFIX;
$data = new DAO();
$data->dao->select('item.*,  item_description.*, item_user.pk_i_id as item_user_id, item_user.has_private_post as item_user_has_private_post');
$data->dao->from("{$db_prefix}t_item as item");
$data->dao->join(sprintf('%st_user AS item_user', DB_TABLE_PREFIX), 'item_user.pk_i_id = item.fk_i_user_id', 'INNER');
$data->dao->join(sprintf('%st_item_description AS item_description', DB_TABLE_PREFIX), 'item.pk_i_id = item_description.fk_i_item_id', 'INNER');
$data->dao->where('item.b_enabled = 1 AND item.b_active = 1 AND item.b_spam = 0 AND item_description.fk_c_locale_code="' . $language . '"');
$data->dao->orderBy('dt_pub_date', 'DESC');
if ($_REQUEST['filter_value'] && !empty($_REQUEST['filter_value'])):
    $categories = get_category_array($_REQUEST['filter_value']);
    $data->dao->whereIn('fk_i_category_id', $categories);
endif;
$data->dao->where("item_user.has_private_post = 0 AND item_user.user_type != 0");

$page_number = isset($_REQUEST['page_number']) ? $_REQUEST['page_number'] : 0;
$offset = 75;
$start_from = $page_number * $offset;
$data->dao->limit($start_from, $offset);
//$data->dao->offset(10);
$result = $data->dao->get();
if ($result) {
    $items = $result->result();
} else {
    $items = array();
}

if ($items):
    $item_result = Item::newInstance()->extendData($items);
    $db_prefix = DB_TABLE_PREFIX;
    ?>
    <!--<div class="col-md-12">-->
    <?php
    $i = 1;
    foreach ($item_result as $k => $item):
        osc_query_item(array('id' => $item['pk_i_id'], 'results_per_page' => 1000));
        while (osc_has_custom_items()):
            $date = osc_item_field("dt_pub_date");
            setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
            $date_in_french = time_elapsed_string(strtotime($date));
            $user_id = osc_item_user_id();
            $item_id = osc_item_id();
            $user = get_user_data($user_id);
            if (!empty($user['s_path'])):
                $user_image_url = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . "_nav." . $user['s_extension'];
            else:
                $user_image_url = osc_current_web_theme_url('images/user_icon.jpg');
            endif;
            if (osc_count_item_resources()) { //item without media should not allow
                ?>
                <!--<div class="item1 wow animated col-md-4 col-sm-4 col-lg-4">-->
                <div class="item animated col-md-4 col-sm-4 col-lg-4 padding-lr-5">
                    <div class="list">
                        <?php if (osc_images_enabled_at_items()) { ?>
                            <div class="image">
                                <div>
                                    <?php if (osc_count_item_resources()) { ?>
                                        <a href="javascript:void(0)" class="item_title_head" data_item_id="<?php echo osc_item_id(); ?>">
                                            <?php item_resources(osc_item_id()) ?>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo osc_item_url(); ?>">
                                            <img src="<?php echo osc_current_web_theme_url('images/no-image.jpg'); ?>" alt="<?php echo osc_item_title(); ?>" class="img-responsive item_image">
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="description" >
                            <div class="col-md-9 padding-top-10">
                                <img src="<?php echo $user_image_url; ?>" alt="<?php echo isset($user['user_name']) ? $user['user_name'] : 'user icon'; ?>" class="col-md-3 padding-0 img-responsive item_image user_thumbnail">
                                <h3 class="item_title col-md-9">
                                    <a class="item_title_head" data_item_id="<?php echo osc_item_id(); ?>" href="javascript:void(0)">
                                        <?php echo isset($user['user_name']) ? $user['user_name'] : osc_item_title(); ?>
                                        <?php //echo osc_item_title();   ?>
                                    </a>
                                </h3>
                                <span class="item_time col-md-9 padding-left-10"><?php echo $date_in_french; ?></span>                            
                            </div>

                             <div class="col-md-12">                                                        
                                <a class="bold text-black" href="<?php echo osc_item_url(); ?>">
                                    <?php echo osc_highlight(strip_tags(osc_item_title()), 80); ?>
                                </a>                                                        
                            </div>
                            <div class="col-md-12">
                                <p class="item_description">
                                    <?php echo osc_highlight(strip_tags(osc_item_description()), 120); ?>
                                </p>                            
                            </div>
                            <div class="col-md-12">
                                <div class="item_counts">
                                    <div class="col-md-6 padding-0">

                                        <?php
                                        $like_count = get_item_likes_count(osc_item_id());
                                        if ($like_count > 0):
                                            ?>
                                            <span class="item_view_count padding-right-10">
                                                <?php echo $like_count; ?>
                                                <i class="fa fa-thumbs-o-up"></i> 
                                            </span>
                                            <?php
                                        endif;
                                        $share_count = get_item_shares_count(osc_item_id());
                                        if ($share_count > 0):
                                            ?>
                                            <span class="item_view_count padding-right-10">
                                                <?php echo $share_count; ?>
                                                <i class="fa fa-retweet"></i> 
                                            </span>
                                            <?php
                                        endif;
                                        $comment_count = get_comment_count(osc_item_id());
                                        if ($comment_count > 0):
                                            ?>                                                                                                                           
                                            <span class="comment_text padding-right-10">
                                                <i class="fa fa-comments"></i>
                                                <?php echo $comment_count; ?>
                                            </span>
                                            <?php
                                        endif;
                                        $watchlist_count = get_item_watchlist_count(osc_item_id());
                                        if ($watchlist_count > 0):
                                            ?>
                                            <span class="item_favourite_count">
                                                <i class="fa fa-heart"></i> <?php echo $watchlist_count ?>
                                            </span>
                                            <?php
                                        endif;
                                        ?>
                                    </div>  
                                    <div class="col-md-6 blue_text text-right pull-right pointer item_cat" cat-id="<?php echo osc_item_category_id(); ?>">

                                        <?php echo osc_item_category(); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 col-sm-9 col-xs-9">
                                    <?php if (osc_price_enabled_at_items()) { ?>
                                        <span class="price sclr">
                                            <?php echo osc_format_price(osc_item_price()); ?>
                                        </span>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        endwhile;
//        if($i%3 == 0):
//            echo "</div><div class='col-md-12'>";
//        endif;
//        if($i%75 == 0):
//            echo "</div><div class='load-more-content'></div><div class='col-md-12'>";
//        endif;
        $i++;
    endforeach;
//    echo "</div>"; 
    ?>
    <?php
//elseif($page_number > 0):
//    echo '<h2 class="result_text">No More Data Found</h2> ';
else:
    echo '<div class="usepost_no_record"><h2 class="result_text">' . __('Nothing to show off for now.', 'flatter') . '</h2>' . __("Thanks to try later", 'flatter').'</div> ';
endif;
?>
<script>
    $(document).on('click', '.item_cat', function () {
        var cat_id = $(this).attr('cat-id');
        $.ajax({
            url: "<?php echo osc_current_web_theme_url('item_filter.php') ?>",
            type: "POST",
            data: {
                cat_id: cat_id
            },
            success: function (data) {
                $('.masonry_row').html(data);
                $('html,body').animate({
                    scrollTop: 600
                }, 1000);
            }
        });
    });
</script>