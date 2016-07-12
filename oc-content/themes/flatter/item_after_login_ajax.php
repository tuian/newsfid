<?php
require '../../../oc-load.php';
require 'functions.php';

$data = new DAO();
$data->dao->select(sprintf('%st_item.*', DB_TABLE_PREFIX));
$data->dao->from(sprintf('%st_item', DB_TABLE_PREFIX));
$data->dao->orderBy('dt_pub_date', 'DESC');

$data->dao->whereIn('fk_i_category_id', get_user_categories());

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
            if ($user):
                $user_image_url = osc_base_url() . $user[0]['s_path'] . $user[0]['pk_i_id'] . "_nav." . $user[0]['s_extension'];
            else:
                $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
            endif;
//            if (!empty($user)):
//                $user_image_url = osc_base_url() . $user[0]['s_path'] . $user[0]['pk_i_id'] . "_nav." . $user[0]['s_extension'];
//            else:
//                $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
//            endif;
            ?>
            <div class="box box-widget">
                <div class="box-header with-border">
                    <div class="user-block">
                        <img class="img-circle" src="<?php echo $user_image_url ?>" alt="<?php echo $user[0]['s_name'] ?>">
                        <span class="username"><a href="<?php echo osc_user_public_profile_url($user[0]['pk_i_id']) ?>"><?php echo $user[0]['s_name'] ?></a></span>
                        <span class="description"><?php echo $date_in_french ?></span>
                    </div>
                    <!-- /.user-block -->
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                            <i class="fa fa-circle-o"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <?php
                    item_resources(osc_item_id());
                    ?>

                    <p><?php echo osc_item_description(); ?></p>
                    <?php echo '127' ?> &nbsp;
                    <a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;
                    <?php echo 'Like' ?>
                    &nbsp;&nbsp;
                    <?php echo '' ?> &nbsp;
                    <a href="#"><i class="fa fa-retweet"></i></a>&nbsp;
                    <?php echo 'Share' ?>

                    &nbsp;&nbsp;
                    <?php echo '' ?> &nbsp;
                    <a href="#"><i class="fa fa-comments"></i></a>&nbsp;
                    <?php echo 'Comment' ?>

                    &nbsp;&nbsp;
                    <a href="#"><?php echo 'Tchat' ?></a>&nbsp;
                </div>
                <!-- /.box-body -->
                <div class="comments_container_<?php echo osc_item_id(); ?>">
                    <?php
                    $c_data;
                    $comments_data = new DAO();
                    $comments_data->dao->select(sprintf('%st_item_comment.*', DB_TABLE_PREFIX));
                    $comments_data->dao->from(sprintf('%st_item_comment', DB_TABLE_PREFIX));
                    $conditions = array('fk_i_item_id' => osc_item_id(),
                        'b_active' => 1,
                        'b_enabled' => 1);
                    $comments_data->dao->limit(3);
                    $comments_data->dao->where($conditions);
                    $comments_data->dao->orderBy('dt_pub_date', 'DESC');
                    $comments_result = $comments_data->dao->get();
                    $c_data = $comments_result->result();
                    ?>
                    <?php
                    if ($c_data):
                        foreach ($c_data as $k => $comment_data):
                            ?>
                            <?php
                            $comment_user = get_user_data($comment_data['fk_i_user_id']);
                          
                            if ($comment_user):
                                $user_image_url = osc_base_url() . $comment_user[0]['s_path'] . $comment_user[0]['pk_i_id'] . "_nav." . $comment_user[0]['s_extension'];
                            else:
                                $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                            endif;
                            ?>
                            <div class="box-footer box-comments">
                                <div class="box-comment">
                                    <!-- User image -->
                                    <img class="img-circle" src="<?php echo $user_image_url ?>" alt="<?php echo $comment_user[0]['s_name'] ?>">

                                    <div class="comment-text">
                                        <span class="username">
                                            <?php echo $comment_user[0]['s_name'] ?>
                                            <span class="text-muted pull-right"><?php echo $comment_data['dt_pub_date'] ?></span>
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
                        
                        if ($current_user):
                            $current_user_image_url = osc_base_url() . $current_user[0]['s_path'] . $current_user[0]['pk_i_id'] . "_nav." . $current_user[0]['s_extension'];
                        else:
                            $current_user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                        endif;
                        
                        ?>
                        <img class="img-responsive img-circle img-sm" src="<?php echo $current_user_image_url ?>" alt="<?php echo $current_user[0]['s_name'] ?>">
                        <!-- .img-push is used to add margin to elements next to floating images -->
                        <div class="img-push">
                            <input type="text" class="form-control input-sm comment_text" placeholder="Press enter to post comment">
                        </div>
                    </form>
                </div>
                <!-- /.box-footer -->
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

