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
//    pr($msg_array);
    $msg_data = new DAO();
    if ($_REQUEST['action'] == 'archives-converstion'):
        $msg_data->dao->insert("`frei_chat_archives`", $msg_array);
    else:
//    elseif ($_REQUEST['action'] == 'chat-converstion'):
        $msg_data->dao->insert("`frei_chat`", $msg_array);
    endif;
endif;
if ($_REQUEST['action'] == 'chat-converstion'):
    $partner_id = $_REQUEST['user_id'];
    $old_msg_cnt = $_REQUEST['old_msg_cnt'];
    $user = get_user_data($user_id);
    $partner = get_user_data($partner_id);
    $conv = get_chat_conversion($user_id, $partner_id);
    $new_msg_cnt = count(get_chat_conversion($user_id, $partner_id));
    if ($_REQUEST['read_status'] == '0'):
        $msg_data = new DAO();        
        $msg_data->dao->update("`frei_chat`", array('read_status' => 1), array('`to`' => $partner_id));
    endif;
    if ($old_msg_cnt == $new_msg_cnt):
        die('same as old');
    endif;
    ?>
    <input type="hidden" id="hidden-user-data" msg_type="chat-converstion" from-user-id="<?php echo $user_id ?>" from-user-name="<?php echo $user['user_name'] ?>" to-user-id="<?php echo $partner_id ?>" to-user-name="<?php echo $partner['user_name'] ?>" old_msg_cnt="<?php echo $new_msg_cnt; ?>"/>    
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
if ($_REQUEST['action'] == 'archives-converstion'):
    $partner_id = $_REQUEST['user_id'];
    $old_msg_cnt = $_REQUEST['old_msg_cnt'];
    $user = get_user_data($user_id);
    $partner = get_user_data($partner_id);
    $conv = get_archive_conversion($user_id, $partner_id);
    ?>
    <input type="hidden" id="hidden-user-data" msg_type="archives-converstion" from-user-id="<?php echo $user_id; ?>" from-user-name="<?php echo $user['user_name'] ?>" to-user-id="<?php echo $partner_id; ?>" to-user-name="<?php echo $partner['user_name'] ?>" old_msg_cnt="<?php echo count(get_chat_conversion($user_id, $partner_id)); ?>"/>
    <?php foreach ($conv as $k => $msg):
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
if ($_REQUEST['action'] == "online-chat-converstion"):
    $user = get_user_data($user_id);
    $to_user_id = $_REQUEST['user_id'];
    $user_to = get_user_data($to_user_id);
    $msg = get_chat_message_data($user_id);
    if (isset($to_user_id)):
        $conv = get_chat_conversion($user_id, $to_user_id);
        ?>
        <input type="hidden" id="hidden-data" from-id="<?php echo $user_id ?>" from-name="<?php echo $user['user_name'] ?>" to-id="<?php echo $to_user_id ?>" to-name="<?php echo $user_to['user_name'] ?>" old_msg_cnt="<?php echo count(get_chat_conversion($user_id, $to_user_id)); ?>"/>
        <div class="chat_box">
            <div class="background-white padding-10">
                <div class="bold">
                    <span class="orange padding-right-10"> With</span> <a><?php echo $user_to['user_name']; ?> </a>
                </div>            
            </div>
            <div  class="col-md-12 border-bottom-gray"></div>
            <div class="col-md-12 background-white">
                <span class="dropdown vertical-row pull-right">
                    <i class="fa fa-ellipsis-v dropdown-toggle pull-right pointer font-22px" aria-hidden="true" id="dropdownMenu2" data-toggle="dropdown"></i>
                    <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu2">
                        <li class="pointer"><a><?php _e("Block this user", 'flatter') ?></a></li>
                        <li class="close_chat pointer"><a><?php _e(" Close this chat", 'flatter') ?></a></li>
                        <li class="pointer"><a><?php _e("Turn chat off", 'flatter') ?></a></li>
                    </ul>
                </span>
            </div>

            <?php
            if (!empty($user['s_path'])):
                $img_path = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
            else:
                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
            endif;


            if (!empty($user_to['s_path'])):
                $img_path_to = osc_base_url() . $user_to['s_path'] . $user_to['pk_i_id'] . '.' . $user_to['s_extension'];
            else:
                $img_path_to = osc_current_web_theme_url() . '/images/user-default.jpg';
            endif;
            ?>
            <div class="msg col-md-12 background-white overflow-chat"> 
                <?php foreach ($conv as $k => $msg):
                    ?>
                    <?php if ($msg['from'] != $user_id): ?>        
                        <div class="col-md-12 padding-0 msg_him">
                            <div class="pull-left"><img src="<?php echo $img_path_to; ?>" class="img-circle" width="30px"></div> <span class="col-md-10 padding-left-10"><?php echo $msg['message']; ?></span>
                        </div>
                    <?php else : ?>
                        <div class="col-md-12 padding-0 padding-5 msg_me font-color-black">
                            <div class="pull-left"><img src="<?php echo $img_path; ?>" class="img-circle" width="20px"></div><span class="col-md-10 padding-left-10 dont-break-out"> <?php echo $msg['message']; ?> </span>
                        </div>  
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <!--<div class="typing col-md-12 background-white"> Dhaval is typing.....</div>-->

            <div class="textarea">
                <textarea class="msg_textarea" placeholder="<?php _e("Press enter to reply", 'flatter') ?>" id="messageBox1"></textarea>
                <img src="<?php echo $img_path; ?>" class="img-circle user_chat_photo" width="40px">
            </div>
        </div>
        <?php
    endif;
endif;
if ($_REQUEST['action'] == "archive_chat"):
    $to_user_id = $_REQUEST['to_id'];
    if (isset($to_user_id)):
        $conversion = get_chat_conversion($user_id, $to_user_id);
        if (!empty($conversion)):
            $msg_data = new DAO();
            foreach ($conversion as $c):
                $msg_array = $c;
                $msg_array['`from`'] = $c['from'];
                $msg_array['`to`'] = $c['to'];
                unset($msg_array['from']);
                unset($msg_array['to']);
                $msg_data->dao->insert("`frei_chat_archives`", $msg_array);
            endforeach;
            $conversion = delete_chat_conversion($user_id, $to_user_id);
            return $conversion;
        endif;
    endif;
endif;
if ($_REQUEST['action'] == "delete_chat"):
    $to_user_id = $_REQUEST['to_id'];
    if (isset($to_user_id)):
        $conversion = delete_chat_conversion($user_id, $to_user_id);
        return $conversion;
    endif;
endif;
?>
<?php
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
if ($_REQUEST['search_archive'] == 'search-archive'):
    $search = $_REQUEST['search_text'];
    $user_conversion_data = new DAO();
    $user_conversion_data->dao->select('frei_chat_archives.*');
    $user_conversion_data->dao->from('frei_chat_archives');
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


if ($_REQUEST['action'] == "online-chat-converstion"):
    ?>
    <script>
        document.getElementById("messageBox1").onkeypress = function enterKey(e)
        {
            var key = e.which || e.keyCode;
            if (key == 13)
            {
                var msg = $('.msg_textarea').val();
                var from_id = $('#hidden-data').attr('from-id');
                var from_name = $('#hidden-data').attr('from-name');
                var to_id = $('#hidden-data').attr('to-id');
                var to_name = $('#hidden-data').attr('to-name');
                if (!msg) {
                    return false;
                }
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url() . 'tchat-converstion.php' ?>",
                    type: 'post',
                    data: {
                        submit: 'send-msg',
                        action: 'online-chat-converstion',
                        from_id: from_id,
                        from_name: from_name,
                        user_id: to_id,
                        to_name: to_name,
                        msg: msg
                    },
                    success: function (data) {
                        $('#online-chat').html(data);
                        $('.msg').animate({scrollTop: $('.msg').prop("scrollHeight")}, 10);
                        $('textarea.msg_textarea').val('');
                        $('textarea.msg_textarea').focus();
                    }
                });
            }
        };
        $(document).on('click', '.send_msg', function () {
            var msg = $('.t_chat_textarea').val();
            var from_id = $('#hidden-user-data').attr('from-user-id');
            var from_name = $('#hidden-user-data').attr('from-user-name');
            var to_id = $('#hidden-user-data').attr('to-user-id');
            var to_name = $('#hidden-user-data').attr('to-user-name');
            if (!msg) {
                return false;
            }
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'tchat-converstion.php' ?>",
                type: 'post',
                data: {
                    submit: 'send-msg',
                    action: 'chat-converstion',
                    from_id: from_id,
                    from_name: from_name,
                    user_id: to_id,
                    to_name: to_name,
                    msg: msg
                },
                success: function (data) {
                    $('#chat-box').html(data);
                    $('#chat-box').animate({scrollTop: $('#chat-box').prop("scrollHeight")}, 500);
                    $('.t_chat_textarea').closest('div').html('<textarea class="t_chat_textarea" placeholder="<?php _e("Write a reply....", 'flatter') ?>"></textarea>');
                }
            });
        });
        $('.t_chat_textarea').bind('keypress', function (e) {
            if (e.which === 13) {
                $('.send_msg').click();
            }
        });

    </script>
<?php endif; ?>