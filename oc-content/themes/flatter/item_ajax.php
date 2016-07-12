<?php
require '../../../oc-load.php';

$data = new DAO();
$data->dao->select(sprintf('%st_item.*', DB_TABLE_PREFIX));
$data->dao->from(sprintf('%st_item', DB_TABLE_PREFIX));
$data->dao->orderBy('dt_pub_date', 'DESC');

if ($_REQUEST['filter_value'] && !empty($_REQUEST['filter_value'])):
    $categories = get_category_array($_REQUEST['filter_value']);
    $data->dao->whereIn('fk_i_category_id', $categories);
endif;

$page_number = isset($_REQUEST['page_number']) ? $_REQUEST['page_number'] : 0;
$offset = 9;
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
    foreach ($cat_data as $k => $cat):
        $category_array[] = $cat['pk_i_id'];
    endforeach;
    return $category_array;
}

function time_elapsed_string($ptime) {
    $etime = time() - $ptime;
    if ($etime < 1) {
        return '0 seconds';
    }
    $d = $etime / 3600;
    if ($d > 0 && $d <= 24) {
        $r = round($d);
        return $r . ' h';
    } else {
        return strftime("%d %b", $ptime);
    }
}

if ($items):
    $item_result = Item::newInstance()->extendData($items);
    $conn = DBConnectionClass::newInstance();
    $data = $conn->getOsclassDb();
    $comm = new DBCommandClass($data);
    $db_prefix = DB_TABLE_PREFIX;
    foreach ($item_result as $k => $item):
        osc_query_item(array('id' => $item['pk_i_id'], 'results_per_page' => 1000));
        while (osc_has_custom_items()):
            $date = osc_item_field("dt_pub_date");
            setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
            $date_in_french = time_elapsed_string(strtotime($date));

            $user_id = osc_item_user_id();
            $item_id = osc_item_id();
            $query = "SELECT user.*, user.s_name as name, user2.* FROM `{$db_prefix}t_user` user LEFT JOIN `{$db_prefix}t_user_resource` user2 ON user2.fk_i_user_id = user.pk_i_id WHERE user.pk_i_id={$user_id} LIMIT 1";
            $result = $comm->query($query);
            $user = $result->result();
            if (!empty($user)):
                $user_image_url = osc_base_url() . $user[0]['s_path'] . $user[0]['pk_i_id'] . "_nav." . $user[0]['s_extension'];
            else:
                $user_image_url = osc_current_web_theme_url('images/user_icon.jpg');
            endif;
//            echo "<pre>";
//            print_r($user);
            ?>
            <div class="item wow animated col-md-4 col-sm-4 col-lg-4">
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
                        <div class="col-md-9 padding-top-10">
                            <img src="<?php echo $user_image_url; ?>" alt="<?php echo isset($user[0]['name']) ? $user[0]['name'] : 'user icon'; ?>" class="img-responsive item_image user_thumbnail">
                            <h3 class="item_title">
                                <a style="item_link" href="<?php echo osc_item_url(); ?>">
                                    <?php echo isset($user[0]['name']) ? $user[0]['name'] : osc_item_title(); ?>
                                    <?php //echo osc_item_title();  ?>
                                </a>
                            </h3>
                        </div>
                        <div class="col-md-3 text-right padding-top-10">
                            <span class="item_time"><?php echo $date_in_french; ?></span>                            
                        </div>
                        <div class="col-md-12">
                            <p class="item_description">
                                <?php echo osc_highlight(strip_tags(osc_item_description()), 120); ?>
                            </p>                            
                        </div>
                        <div class="col-md-12">
                            <div class="item_counts">
                                <div class="col-md-2 padding-0">
                                    <span class="item_view_count">
                                        <i class="fa fa-retweet"></i> <?php echo osc_item_views(); ?>
                                    </span>
                                    <?php if (!empty($count_result)): ?>
                                        <span class="item_favourite_count">
                                            <i class="fa fa-heart"></i> <?php echo $count_result[0]['total'] ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3 padding-0">                                                                           
                                    <span class="item_view_count">
                                        <i class="fa fa-heart fa-lg"></i> <?php echo '24'; ?>
                                    </span>
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
            </div>
            <?php
        endwhile;
    endforeach;
    ?>
    <?php
else:
    echo '0';
endif;
?>