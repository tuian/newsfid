<?php
require '../../../oc-load.php';
require 'functions.php';

$comment_user_id = osc_logged_user_id();
$comment_item_id = $_REQUEST['item_id'];
$comment_text = $_REQUEST['comment_text'];
$new_comment = new DAO();
$user = get_user_data($comment_user_id);

//item detail
$data = new DAO();
$data->dao->select('item.*');
$data->dao->from(sprintf('%st_item AS item', DB_TABLE_PREFIX));
$data->dao->where('item.pk_i_id', $comment_item_id);
$result = $data->dao->get();
$item = $result->row();

if (isset($_REQUEST['comment_id']) && !empty($_REQUEST['comment_id'])):
    $comment_comment_id = $_REQUEST['comment_id'];
    $comments_data = new DAO();
    if (isset($_REQUEST['delete']) && $_REQUEST['delete'] == '1'):
        $comments_result = $comments_data->dao->delete("oc_t_item_comment", array('pk_i_id' => $comment_comment_id));
    else:
        $text = $_REQUEST['comment_text'];
        $comments_result = $comments_data->dao->update("oc_t_item_comment", array('s_body' => $text), array('pk_i_id' => $comment_comment_id));
        if ($comments_result):
            echo 1;
        else:
            echo 0;
        endif;
    endif;
else :
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

    //insert notification for author
    $message = 'commented your post';
    if ($comment_user_id != $item['fk_i_user_id']):
        set_user_notification($comment_user_id, $item['fk_i_user_id'], $message, $comment_item_id);
    endif;
    
    //commented your shared post
//    $message1 = 'commented your shared post';
//    if ($comment_user_id != $item['fk_i_user_id']):
//        set_user_notification($comment_user_id, $item['fk_i_user_id'], $message, $comment_item_id);
//    endif;
//    //insert notification for author
//    $message2 = 'joined your discussion';
//    if ($comment_user_id != $item['fk_i_user_id']):
//        set_user_notification($comment_user_id, $item['fk_i_user_id'], $message, $comment_item_id);
//    endif;

endif;
$c_data;
$comments_data = new DAO();
$comments_data->dao->select(sprintf('%st_item_comment.*', DB_TABLE_PREFIX));
$comments_data->dao->from(sprintf('%st_item_comment', DB_TABLE_PREFIX));
$conditions = array('fk_i_item_id' => $comment_item_id,
    'b_active' => 1,
    'b_enabled' => 1);
//$comments_data->dao->limit(3);
$comments_data->dao->where($conditions);
$comments_data->dao->orderBy('dt_pub_date', 'ASC');
$comments_result = $comments_data->dao->get();
$c_data = $comments_result->result();
?>
<div class="cmnt comments_container_<?php echo $comment_item_id; ?>"> 
<?php
if ($c_data):
    ?>
        <?php if (count($c_data) > 3): ?>
            <div class="box-body">
                <span class="load_more_comment"> <i class="fa fa-plus-square-o"></i> <?php _e("Display", 'flatter'); ?> <?php echo count($c_data) - 3 ?>  <?php _e(" comments more", 'flatter'); ?> </span>
                <span class="comment_count"><?php echo count($c_data) - 3 ?></span>
            </div>
    <?php endif; ?>
        <?php
        $total_comment = count($c_data);
        foreach ($c_data as $k => $comment_data):
            $comment_user = get_user_data($comment_data['fk_i_user_id']);
            if ($k < $total_comment - 3 && !$load_more):
                $load_more = __("load more", 'flatter');
                echo '<div class="load_more">';
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
                            <a href="<?php echo osc_user_public_profile_url($comment_user['user_id']) ?>">  <?php echo $comment_user['user_name']; ?></a>
                            <?php if ($comment_data['fk_i_user_id'] == osc_logged_user_id()):
                                ?>
                                <div class="dropdown  pull-right">
                                    <i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-hidden="true"></i>
                                    <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                                        <li class="edit_cmnt comment_text_<?php echo $comment_data['pk_i_id']; ?>" data-item-id='<?php echo $comment_item_id; ?>' data_text="<?php echo $comment_data['s_body']; ?>" data_id="<?php echo $comment_data['pk_i_id']; ?>" onclick="editComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $comment_item_id; ?>)" ><a><?php echo __('Edit'); ?></a></li>                                    
                                        <li class="delete_cmnt" onclick="deleteComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $comment_item_id; ?>)"><a><?php echo __('Delete') ?></a></li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <span class="text-muted margin-left-5"><?php echo time_elapsed_string(strtotime($comment_data['dt_pub_date'])) ?></span>
                        </span>
                        <span class="comment_text comment_edt_<?php echo $comment_data['pk_i_id']; ?>" data-text="<?php echo $comment_data['s_body']; ?>">
                            <?php echo $comment_data['s_body']; ?>
                        </span>                            
                    </div>                        
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
