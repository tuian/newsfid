<?php
require '../../../oc-load.php';

$data = new DAO();
$data->dao->select(sprintf('%st_item.*', DB_TABLE_PREFIX));
$data->dao->from(sprintf('%st_item', DB_TABLE_PREFIX));
$data->dao->orderBy('dt_pub_date', 'DESC');

if ($_REQUEST['filter_value']):
    $categories = get_category_array($_REQUEST['filter_value']);
    $data->dao->whereIn('fk_i_category_id', $categories);
endif;

$page_number = isset($_REQUEST['page_number']) ? $_REQUEST['page_number'] : 0;
$offset = 1000;
$start_from = $page_number * $offset;
$data->dao->limit($start_from, $offset);
//$data->dao->offset(10);
$result = $data->dao->get();
if ($result) {
    $items = $result->result();
} else {
    $items = array();
}

function get_category_array($parent_category_id) {
    $category_array = array($parent_category_id);
    $category_data = new DAO();
    $category_data->dao->select(sprintf('%st_category.*', DB_TABLE_PREFIX));
    $category_data->dao->from(sprintf('%st_category', DB_TABLE_PREFIX));
    $category_data->dao->where('fk_i_parent_id', $parent_category_id);
    $result1 = $category_data->dao->get();
    $cat_data = $result1->result();
    foreach($cat_data as $k => $cat):
        $category_array[] = $cat['pk_i_id'];
    endforeach;
    return $category_array;
}

$item_result = Item::newInstance()->extendData($items);
?>
<?php foreach ($item_result as $k => $item): ?>
    <?php
    osc_query_item(array('id' => $item['pk_i_id'], 'results_per_page' => 1000));
    while (osc_has_custom_items()):
        ?>
        <div class="item wow animated col-md-4 col-sm-4">
            <div class="list">
                <?php if (osc_images_enabled_at_items()) { ?>
                    <div class="image">
                        <div>
                            <?php if (osc_count_item_resources()) { ?>
                                <a href="<?php echo osc_item_url(); ?>">
                                    <img src="<?php echo osc_resource_preview_url(); ?>" alt="<?php echo osc_item_title(); ?>" class="img-responsive item_image" />
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
                    <h3 class="item_title">
                        <a style="item_link" href="<?php echo osc_item_url(); ?>">
                            <?php echo osc_item_title(); ?>
                        </a>
                    </h3>

                    <span class="item_time"><?php echo $date_in_french; ?></span>

                    <span class="item_meta">
                        <?php echo osc_item_category(); ?>
                        <?php //echo osc_item_();    ?>
                    </span>
                    <p class="item_description">
                        <?php echo osc_highlight(strip_tags(osc_item_description()), 0); ?>
                    </p>
                    <div class="item_counts">
                        <span class="item_view_count">
                            <i class="fa fa-retweet"></i> <?php echo osc_item_views(); ?>
                        </span>
                        <?php if (!empty($count_result)): ?>
                            <span class="item_favourite_count">
                                <i class="fa fa-heart"></i> <?php echo $count_result[0]['total'] ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <?php if (osc_price_enabled_at_items()) { ?>
                                <span class="price sclr">
                                    <?php echo osc_format_price(osc_item_price()); ?>
                                </span>
                            <?php } ?>
                        </div>
                        <?php if (function_exists("watchlist")) { ?>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <div class="wishlist pull-right">
                                    <?php if (osc_is_web_user_logged_in()) { ?>
                                        <?php watchlist2(); ?>
                                    <?php } else { ?>
                                        <a title="<?php _e("Add to watchlist", 'watchlist'); ?>" rel="nofollow" href="<?php echo osc_user_login_url(); ?>"><i class="fa fa-heart-o fa-lg"></i></a>
                                        <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endwhile;
endforeach;
?>