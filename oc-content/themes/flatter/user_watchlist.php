<?php
if ($_REQUEST['user_id']):
    $user_id = $_REQUEST['user_id'];
else:
    $user_id = osc_user_id();
endif;

$users_watchlist = get_user_watchlist_item($user_id);
if (!$users_watchlist):
    ?>
    <div class="result_text col-md-12 padding-top-8per padding-left-7per vertical-row padding-bottom-13per background-white">
        <div class="col-md-4 padding-0">
            <img src="<?php echo osc_current_web_theme_url() . "images/documentation.png" ?>" class="post_icon">
        </div>
        <div class="col-md-7 padding-0">
            <div class="col-md-12 light_gray bold padding-bottom-10"> <?php _e("No watchlist posts found", 'flatter') ?></div>
            <div class="col-md-12 font-color-black padding-bottom-13per"><?php _e("Add to watchlist any posts you wish to read later. That is a good way to keep things if you need to hurry up because of something else to do in ruch                             ", 'flatter') ?></div>
        </div>   
    </div> 
    <?php
    return;
endif;

$data = new DAO();
$users_watchlist_item = implode(',', $users_watchlist);
$data->dao->select('item.*, item_location.*');
$data->dao->join(sprintf('%st_item_location AS item_location', DB_TABLE_PREFIX), 'item_location.fk_i_item_id = item.pk_i_id', 'INNER');
$data->dao->from(sprintf('%st_item AS item', DB_TABLE_PREFIX));
$data->dao->where("item.pk_i_id IN ({$users_watchlist_item})");
$data->dao->orderBy('item.dt_pub_date', 'DESC');

//$page_number = isset($_REQUEST['page_number']) ? $_REQUEST['page_number'] : 0;
//$offset = 10;
//$start_from = $page_number * $offset;
//$data->dao->limit($start_from, $offset);
$result = $data->dao->get();
$items = $result->result();
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
            $date_in_french = strftime("%d %B %Y ", strtotime($date));
            $item_id = osc_item_id();
            $user = get_user_data(osc_item_user_id());
            ?>
            <div class="box box-widget">
                <div class="box-header with-border">
                    <div class="user-block">
                        <div class="user_image">
                            <?php get_user_profile_picture($user['user_id']); ?>
                        </div>  
                        <span class="username"><a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>"><?php echo $user['user_name'] ?></a></span>
                        <span class="description"><?php echo $date_in_french ?></span>
                    </div>
                    <!-- /.user-block -->
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="<?php _e("Mark as read", 'flatter') ?>">
                            <i class="fa fa-circle-o"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p class="item_title_head" data_item_id="<?php echo osc_item_id(); ?>"><?php echo osc_item_title(); ?></p>

                    <?php
                    item_resources(osc_item_id());
                    ?>

                    <p><?php //echo osc_highlight(osc_item_description(), 200);                   ?></p>

                    <?php echo item_like_box(osc_logged_user_id(), osc_item_id()) ?>

                    &nbsp;&nbsp;

                    <?php echo user_share_box(osc_logged_user_id(), osc_item_id()) ?>

                    &nbsp;&nbsp;&nbsp;
                    <span class="comment_text"><i class="fa fa-comments"></i>&nbsp;<span class="comment_count_<?php echo osc_item_id(); ?>"><?php echo get_comment_count(osc_item_id()) ?></span>&nbsp;
                        <?php echo _e("Comments", 'flatter') ?>
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
                    $comments_data->dao->orderBy('dt_pub_date', 'DESC');
                    $comments_result = $comments_data->dao->get();
                    $c_data = $comments_result->result();
                    ?>
                    <?php
                    if ($c_data):
                        ?>
                        <?php if (count($c_data) > 3): ?>
                            <div class="box-body">
                                <span class="load_more_comment"> <i class="fa fa-plus-square-o"></i> <?php _e("Display", 'flatter') ?> <?php echo count($c_data) - 3 ?> <?php _e("comments more", 'flatter') ?> </span>
                                <span class="comment_count"><?php echo count($c_data) - 3 ?></span>
                            </div>
                        <?php endif; ?>
                        <?php
                        foreach ($c_data as $k => $comment_data):
                            ?>
                            <?php
                            $comment_user = get_user_data($comment_data['fk_i_user_id']);
                            ?>
                            <?php
                            if ($k > 2 && !$load_more && count($c_data) > 3):
                                $load_more = _e("load more", 'flatter');
                                ?>                                
                                <div class="load_more">
                                    <?php
                                endif;
                                ?>
                                <div class="box-footer box-comments">
                                    <div class="box-comment">
                                        <!-- User image -->
                                        <div class="comment_user_image">
                                            <?php get_user_profile_picture($comment_user['user_id']) ?>
                                        </div>
                                        <div class="comment-text">
                                            <span class="username">
                                                <?php echo $comment_user['user_name'] ?>
                                                <span class="text-muted pull-right"><?php echo time_elapsed_string(strtotime($comment_data['dt_pub_date'])) ?></span>
                                            </span><!-- /.username -->
                                            <?php echo $comment_data['s_body']; ?>
                                        </div>
                                        <!-- /.comment-text -->
                                    </div>                       
                                </div>  
                                <?php
                                if ($k > 2 && $k == (count($c_data) - 1)):
                                    unset($load_more);
                                    ?>
                                </div>                                
                                <?php
                            endif;
                            ?>                            
                            <?php
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
            <?php
        endwhile;
    endforeach;
    ?>
    <?php
else:
    echo _e("No watchlist item found", 'flatter');
endif;