<?php
require '../../../oc-load.php';
require 'functions.php';
$user_id = osc_logged_user_id();
$user = get_user_data($user_id);
if ($_REQUEST['action'] == "close-chat-converstion"):
    $db_prefix = DB_TABLE_PREFIX;
    $delete_item_comment = new DAO();
    $delete_item_comment->dao->delete("{$db_prefix}t_active_chat", "user_id= $user_id");
    osc_set_preference('chat_user_id', '');
endif;
if ($_REQUEST['action'] == "user_typing"):
    $db_prefix = DB_TABLE_PREFIX;
    $user_data = new DAO();
    $result = $user_data->dao->update("{$db_prefix}t_active_chat", array('user_type' => 1), array('user_id' => $user_id));
    osc_set_preference('chat_user_id', '');
elseif ($_REQUEST['action'] == "no_user_typing"):
    $db_prefix = DB_TABLE_PREFIX;
    $user_data = new DAO();
    $result = $user_data->dao->update("{$db_prefix}t_active_chat", array('user_type' => 0), array('user_id' => $user_id));
    osc_set_preference('chat_user_id', '');
endif;
if ($_REQUEST['action'] == "chat-converstion"):
    if ($_REQUEST['user_status'] == "user_status"):
        $to_user_id = $_REQUEST['user_id'];
        $chat_array['user_id'] = $user_id;
        $chat_array['to_user_id'] = $to_user_id;
        $chat_data = new DAO();
        $chat_data->dao->select(sprintf('%st_active_chat.*', DB_TABLE_PREFIX));
        $chat_data->dao->from(sprintf('%st_active_chat', DB_TABLE_PREFIX));
        $chat_data->dao->where('user_id', $user_id);
        $chat_data->dao->limit(1);
        $chat_data_result = $chat_data->dao->get();
        $chat_data_array = $chat_data_result->result();
        if ($chat_data_array):
            $chat_reult = $chat_data->dao->update(sprintf('%st_active_chat', DB_TABLE_PREFIX), $chat_array, array('id' => $chat_data_array[0]['id']));
        else:
            $chat_reult = $chat_data->dao->insert(sprintf('%st_active_chat', DB_TABLE_PREFIX), $chat_array);
        endif;
    endif;
    $to_user_id = $_REQUEST['user_id'];
    osc_set_preference('chat_user_id', $to_user_id);
    $user_to = get_user_data($to_user_id);
    $msg = get_chat_message_data($user_id);
    $block_user = get_blocked_user_id($user_id);
//    pr($block_user);
    if (!in_array($to_user_id, $block_user)):
        if (isset($to_user_id)):
            $conv = get_chat_conversion($user_id, $to_user_id);
            ?>
            <input type="hidden" id="hidden-data" from-id="<?php echo $user_id ?>" from-name="<?php echo $user['user_name'] ?>" to-id="<?php echo $to_user_id ?>" to-name="<?php echo $user_to['user_name'] ?>" old_msg_cnt="<?php echo count(get_chat_conversion($user_id, $to_user_id)); ?>"/>
            <div class="chat_box">
                <div class="background-white padding-10">
                    <!--                    <div class="bold">
                                            <span class="orange padding-right-10"><?php _e("With", 'flatter'); ?> </span> <a class="user_name_chat" href="<?php echo osc_user_public_profile_url($to_user_id) ?>"> <?php echo $user_to['user_name']; ?></a>
                                        </div>  -->
                    <!--                     <span class="dropdown vertical-row pull-right">
                                            <i class="fa fa-ellipsis-v dropdown-toggle pull-right pointer font-22px" aria-hidden="true" id="dropdownMenu2" data-toggle="dropdown"></i>
                                            <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu2">
                                                <li class="pointer" id="block_msg_user"><a><?php _e("Block this user", 'flatter'); ?></a></li>
                                                <li class="close_chat pointer"><a><?php _e("Close this chat", 'flatter'); ?> </a></li>
                                                <li class="pointer chat_option">
                    <?php
                    $a = get_user_online_status($user_id);
                    if (!empty($a)):
                        if ($a['status'] == 0):
                            ?>
                                                                                                    <a class="chat_off"><?php _e("Turn on Ghost mode", 'flatter'); ?></a>
                        <?php else: ?>
                                                                                                    <a class="chat_on"><?php _e("Turn chat on", 'flatter'); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                                                </li>
                                            </ul>
                                        </span>-->
                </div>

                <!--                <div class="col-md-12 background-white">
                                   
                                </div>-->
                <div  class="col-md-12 border-bottom-gray"></div>
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
                                <div class="pull-left"> <img src="<?php echo $img_path_to; ?>" class="img-circle" width="30px"></div> <span class="col-md-10 padding-left-10 dont-break-out"><?php echo $msg['message']; ?></span>
                            </div>
                        <?php else : ?>
                            <div class="col-md-12 padding-0 padding-5 msg_me font-color-black">
                                <div class="pull-left"> <img src="<?php echo $img_path; ?>" class="img-circle" width="20px"></div><span class="col-md-10 padding-left-10 dont-break-out"> <?php echo $msg['message']; ?> </span>
                            </div>  
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <!--                <div class="typing col-md-12 background-white"></div>
                
                                <div class="textarea">
                                    <textarea class="msg_textarea" placeholder="<?php _e('Press enter to reply', 'flatter'); ?>" id="messageBox"></textarea>
                                    <img src="<?php echo $img_path; ?>" class="img-circle user_chat_photo" width="40px">
                                </div>-->
            </div>
            <?php
        endif;
    else:
        ?>
        <div id = "online-chat">
            <div class = "chat_box">
                <div class = "background-white col-md-12 padding-10">
                    <div class = "bold">
                        <div class = "col-md-2 padding-0 orange padding-right-10"> With</div>
                        <div class = "col-md-10 dropdown">
                            <i class = "fa fa-ellipsis-v dropdown-toggle pull-right pointer font-22px" aria-hidden = "true" id = "dropdownMenu2" data-toggle = "dropdown"></i>
                            <ul class = "dropdown-menu edit-arrow" aria-labelledby = "dropdownMenu2">
                                <li class = "pointer block_user"><a><?php _e("Block this user", 'flatter'); ?></a></li>
                                <li class="close_chat pointer"><a><?php _e("Close this chat", 'flatter'); ?> </a></li>
                                <li class="pointer"><a><?php _e("Turn on Ghost mode", 'flatter'); ?></a></li>
                            </ul>
                        </div>
                    </div>            
                </div>
                <div  class="col-md-12 border-bottom-gray"></div>
                <?php
                $user_id = osc_logged_user_id();
                $user = get_user_data($user_id);
                if (!empty($user['s_path'])):
                    $img_path = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
                else:
                    $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                endif;
                ?>
                <div class="msg col-md-12 background-white overflow-chat vertical-row"> 
                    <div class="col-md-4 padding-0">
                        <img src="<?php echo osc_current_web_theme_url() . '/images/msg.png' ?>">
                    </div>
                    <div class="col-md-8">
                        <?php _e('No ongoing conversation history', 'flatter'); ?>
                    </div>
                </div>
                <div class="typing col-md-12 background-white"></div>

                <div class="textarea">
                    <textarea class="msg_textarea" placeholder="<?php _e('Press enter to reply', 'flatter'); ?>"></textarea>
                    <img src="<?php echo $img_path; ?>" class="img-circle user_chat_photo" width="40px">
                </div>
            </div>
        </div>
    <?php
    endif;
endif;
?>
<script>
    $(document).on('click', '.chat_off', function () {
        $.ajax({
            url: '<?php echo osc_current_web_theme_url() . 'chat-on-off.php' ?>',
            type: 'post',
            data: {
                action: 'chat_off'
            },
            success: function () {
                $('.chat_off').text('<?php _e("Turn chat on", 'flatter') ?>');
                location.reload();
            }
        })
    });
    $(document).on('click', '.chat_on', function () {
        $.ajax({
            url: '<?php echo osc_current_web_theme_url() . 'chat-on-off.php' ?>',
            type: 'post',
            data: {
                action: 'chat_on'
            },
            success: function () {
                $('.chat_off').text('<?php _e("Turn on Ghost mode", 'flatter') ?>');
                location.reload();
            }
        })
    });
    $(document).on('click', '#block_msg_user', function () {
        var follow_user_id = <?php echo $to_user_id ?>;
        $.ajax({
            url: '<?php echo osc_current_web_theme_url() . 'block_user.php' ?>',
            type: 'post',
            data: {
                action: 'user_block',
                block_user_id: follow_user_id
            },
            success: function () {
                $('#block_msg_user').text('<?php _e("Blocked", 'flatter') ?>');
                location.reload();
            }
        })
    });
    document.getElementById("messageBox").onkeypress = function enterKey(e)
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
                    $('.chat_box').html(data);
                    $('.msg').animate({scrollTop: $('.msg').prop("scrollHeight")}, 10);
                    $('textarea.msg_textarea').val('');
                    $('textarea.msg_textarea').focus();
                }
            });
        }
    };

</script>