<?php
require '../../../oc-load.php';
require 'functions.php';
$user_id = osc_logged_user_id();
$user = get_user_data($user_id);
if ($_REQUEST['action'] == "chat-converstion"):
    $to_user_id = $_REQUEST['user_id'];
    osc_set_preference('chat_user_id', $to_user_id);   
    $user_to = get_user_data($to_user_id);
    $msg = get_chat_message_data($user_id);
    if (isset($to_user_id)):
        $conv = get_chat_conversion($user_id, $to_user_id);
        ?>
        <input type="hidden" id="hidden-data" from-id="<?php echo $user_id ?>" from-name="<?php echo $user['user_name'] ?>" to-id="<?php echo $to_user_id ?>" to-name="<?php echo $user_to['user_name'] ?>" old_msg_cnt="<?php echo count(get_chat_conversion($user_id, $to_user_id)); ?>"/>
        <div class="chat_box">

            <div class="background-white padding-10">
                <div class="bold">
                    <span class="orange padding-right-10"><?php _e("With", 'flatter'); ?> </span> <a href="<?php echo osc_user_public_profile_url($to_user_id) ?>"> <?php echo $user_to['user_name']; ?></a>
                </div>            
            </div>
            <div  class="col-md-12 border-bottom-gray"></div>
            <div class="col-md-12 background-white">
                <span class="dropdown vertical-row pull-right">
                    <i class="fa fa-plus pull-right font-12 padding-5" aria-hidden="true"></i><i class="fa fa-ellipsis-v dropdown-toggle pull-right pointer font-22px" aria-hidden="true" id="dropdownMenu2" data-toggle="dropdown"></i>
                    <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu2">
                        <li class="pointer"><a><?php _e("Block this user", 'flatter'); ?></a></li>
                        <li class="close_chat pointer"><a><?php _e("Close this chat", 'flatter'); ?> </a></li>
                        <li class="pointer"><a><?php _e("Turn chat off", 'flatter'); ?></a></li>
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
                            <div class="pull-left"> <img src="<?php echo $img_path_to; ?>" class="img-circle" width="30px"></div> <span class="col-md-10 padding-left-10"><?php echo $msg['message']; ?></span>
                        </div>
                    <?php else : ?>
                        <div class="col-md-12 padding-0 padding-5 msg_me font-color-black">
                            <div class="pull-left"> <img src="<?php echo $img_path; ?>" class="img-circle" width="20px"></div><span class="col-md-10 padding-left-10"> <?php echo $msg['message']; ?> </span>
                        </div>  
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <!--                <div class="typing col-md-12 background-white"> Dhaval is typing.....</div>-->

            <div class="textarea">
                <textarea class="msg_textarea" placeholder="Press enter to reply" id="messageBox"></textarea>
                <img src="<?php echo $img_path; ?>" class="img-circle user_chat_photo" width="40px">
            </div>
        </div>
        <?php
    endif;
endif;
?>
<script>
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
                    $('#online-chat').html(data);
                    $('.msg').animate({scrollTop: $('.msg').prop("scrollHeight")}, 10);
                    $('textarea.msg_textarea').val('');
                    $('textarea.msg_textarea').focus();
                }
            });
        }
    };

</script>