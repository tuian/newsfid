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
    
    $msg_array['time'] =  time() . str_replace(" ", "", microtime());
    $msg_array['GMT_time'] = time();   
    $msg_array['message_type'] = 0;
    $msg_array['room_id'] = -1;
//    pr($_REQUEST);
    $msg_data = new DAO();
    $msg_data->dao->insert("`frei_chat`", $msg_array);
endif;
if ($_REQUEST['action'] == 'chat-converstion'):
    $partner_id = $_REQUEST['user_id'];
    $user = get_user_data($user_id);
    $partner = get_user_data($partner_id);    
    $conv = get_chat_conversion($user_id, $partner_id);?>
    <input type="hidden" id="hidden-user-data" from-user-id="<?php echo $user['user_id'] ?>" from-user-name="<?php echo $user['user_name'] ?>" to-user-id="<?php echo $partner['user_id'] ?>" to-user-name="<?php echo $partner['user_name'] ?>"/>
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
                            <i class="fa fa-check" aria-hidden="true"></i>
                        <?php else:
                            ?>
                            <i class="fa fa-reply" aria-hidden="true"></i>
                        <?php endif; ?>                                                 
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-2 padding-0">
                <?php echo $msg['message'] ?>
            </div>
        </div>
        <?php
    endforeach;
endif;
?>

