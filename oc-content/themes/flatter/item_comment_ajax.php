<?php
require '../../../oc-load.php';
require 'functions.php';

$comment_user_id = $_REQUEST['user_id'];
$comment_item_id = $_REQUEST['item_id'];
$comment_text = $_REQUEST['comment_text'];
$new_comment = new DAO();

$user = get_user_data($comment_user_id);

$comment_array = array();
$comment_array['fk_i_item_id'] = $comment_item_id;
$comment_array['s_body'] = $comment_text;
$comment_array['fk_i_user_id'] = $user['user_id'];
$comment_array['s_author_name'] = $user['user_name'];
$comment_array['s_author_email'] = $user['s_email'];
$comment_array['b_enabled'] = 1;
$comment_array['b_active'] = 1;
$comment_array['dt_pub_date'] = date("Y-m-d H:i:s");

$comment_data = $new_comment->dao->insert(DB_TABLE_PREFIX . 't_item_comment', $comment_array);

$c_data;
$comments_data = new DAO();
$comments_data->dao->select(sprintf('%st_item_comment.*', DB_TABLE_PREFIX));
$comments_data->dao->from(sprintf('%st_item_comment', DB_TABLE_PREFIX));
$conditions = array('fk_i_item_id' => $comment_item_id,
    'b_active' => 1,
    'b_enabled' => 1);
//$comments_data->dao->limit(3);
$comments_data->dao->where($conditions);
$comments_data->dao->orderBy('dt_pub_date', 'DESC');
$comments_result = $comments_data->dao->get();
$c_data = $comments_result->result();
?>
<div class="comments_container_<?php echo $comment_item_id; ?>"> 
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
        foreach ($c_data as $k => $comment_data):
            ?>
            <?php
            $comment_user = get_user_data($comment_data['fk_i_user_id']);
            if ($comment_user['s_path']):
                $user_image_url = osc_base_url() . $comment_user['s_path'] . $comment_user['pk_i_id'] . "_nav." . $comment_user['s_extension'];
            else:
                $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
            endif;
            if ($k > 2 && !$load_more && count($c_data) > 3):
                $load_more = 'load more';
                ?>                
                <div class="load_more">
                    <?php
                endif;
                ?>
                <div class="box-footer box-comments">
                    <div class="box-comment">
                        <!-- User image -->

                        <img class="img-circle" src="<?php echo $user_image_url ?>" alt="<?php echo $comment_user['user_name'] ?>">

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