<?php
require '../../../oc-load.php';
require 'functions.php';
$user_id = osc_logged_user_id();
if ($_REQUEST['submit'] == 'send-msg'):
    $msg_array['`from`'] = $_REQUEST['from_id'];
    $msg_array['from_name'] = $_REQUEST['from_name'];
    $msg_array['`to`'] = $_REQUEST['user_id'];
    $msg_array['to_name'] = $_REQUEST['to_name'];
    $msg_array['message'] = $_REQUEST['msg'];
    $msg_array['sent'] = date('Y-m-d H:i:s');


//    $user = User::newInstance()->findByPrimaryKey($u['user_id']);     // change it                        
//    if (useronline_show_user_status($_REQUEST['user_id']) == 1) {        
//        $msg_array['recd'] = 1;
//    }
//    else{            
//        $msg_array['recd'] = 0;
//    }
    $msg_array['recd'] = 0;
    $msg_array['read_status'] = 0;

    $msg_array['time'] = time() . str_replace(" ", "", microtime());
    $msg_array['GMT_time'] = time();
    $msg_array['message_type'] = 0;
    $msg_array['room_id'] = -1;
//    pr($_REQUEST);
    $msg_data = new DAO();
    $msg_data->dao->insert("`frei_chat`", $msg_array);
endif;
if ($_REQUEST['action'] == 'chat-converstion'):
    $partner_id = $_REQUEST['user_id'];
    $old_msg_cnt = $_REQUEST['old_msg_cnt'];
    $user = get_user_data($user_id);
    $partner = get_user_data($partner_id);
    $conv = get_chat_conversion($user_id, $partner_id);
    $new_msg_cnt = count(get_chat_conversion($user_id, $partner_id));
    if($old_msg_cnt == $new_msg_cnt):
        die('same as old');
    endif;
    ?>
    <input type="hidden" id="hidden-user-data" from-user-id="<?php echo $user_id ?>" from-user-name="<?php echo $user['user_name'] ?>" to-user-id="<?php echo $partner_id ?>" to-user-name="<?php echo $partner['user_name']?>" old_msg_cnt="<?php echo $new_msg_cnt; ?>"/>    
    <?php
    foreach ($conv as $k => $msg):
        ?>
        <div class="conversion">
            <div class="col-md-12 padding-0 vertical-row">
                <div class="col-md-1 padding-0 padding-top-4per">
                    <?php
                    $id = osc_logged_user_id();
                    if ($msg['from'] != $id):
                        $id = $msg['from'];
                    endif;
                    $user = get_user_data($id);
                    ?>
                    <?php
                    if (!empty($user['s_path'])):
                        $img_path = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
                    else:
                        $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                    endif;
                    ?>
                    <img src="<?php echo $img_path ?>" class="img img-responsive" style="">
                </div>
                <div class="col-md-11 padding-top-4per" id="conv">
                    <label class="bold font-color-black margin-0"><?php echo $msg['from_name']; ?></label>
                    <span class="text-muted margin-left-5"><?php echo time_elapsed_string(strtotime($msg['sent'])) ?></span>
                    <div class="icon-size">
                        <?php
                        $id = osc_logged_user_id();
                        if ($msg['from'] != $id):
                            ?>
                            <i class="fa fa-check" aria-hidden="true"></i>  <?php echo $msg['message'] ?>
                        <?php else:
                            ?>
                            <i class="fa fa-reply" aria-hidden="true"></i>  <?php echo $msg['message'] ?>
                        <?php endif; ?>                                                 
                    </div>
                </div>
            </div>            
        </div>
        <?php
    endforeach;
endif;
if ($_REQUEST['search_action'] == 'search-action'):
    $search = $_REQUEST['search_text'];
    $user_conversion_data = new DAO();
    $user_conversion_data->dao->select('frei_chat.*');
    $user_conversion_data->dao->from('frei_chat');
    $user_conversion_data->dao->where("`from` = " . $user_id . " AND `to_name` LIKE '%" . $search . "%'");
    $user_conversion_data->dao->groupBy('`to`');
    $user_result = $user_conversion_data->dao->get();
    $result = $user_result->result();
    $msg = $result;
    ?>
    <ul class="padding-0" id="user_list">
        <?php
        $result = $msg['from'];
        foreach ($msg as $k => $data):

            $id = $data['to'];
            $user = get_user_data($id);
            if (!empty($user['s_path'])):
                $img_path = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
            else:
                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
            endif;
            ?>
            <li class="col-md-12 vertical-row padding-0 border-bottom-gray user_list pointer" data-id='<?php echo $data['to']; ?>'>
                <img src="<?php echo $img_path; ?>" class="img img-responsive" style="width:25%; padding: 5px">
                <div>
                    <label class="margin-0 bold font-color-black"><?php echo $data['to_name']; ?></label>
                    <div class="icon-size"><i class="fa fa-reply" aria-hidden="true"></i> <?php echo $data['message']; ?></div>
                </div>
            </li>
            <?php
        endforeach;
        ?>
    </ul>
    <?php
endif;
?>

