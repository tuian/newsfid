<?php
require '../../../oc-load.php';
require 'functions.php';
$user_id = osc_logged_user_id();

$comment_comment_id = $_REQUEST['comment_id'];
$update_message = new DAO();
$res = $update_message->dao->update("frei_chat", array('read_status' => 1), array('`to`' => $user_id));
?>
<?php osc_current_web_theme_path('header.php'); ?>
<style>
    .content-wrapper{
        background-color: #fff !important;
    }</style>
<div class="col-md-12 bg-tchat">
    <div class="border-box ">
        <div class="row margin-0 padding-top-3per ">
            <div class="col-md-4 padding-0">
                <div class="col-md-12 border-top-gray background-white border-box-right border-bottom-gray tchat_tab">
                    <ul class="nav margin-top-20 nav-font">
                        <li id="message" class="col-md-7 pointer active_tab">
                            <div class="msg msg_tab">New messages</div>
                        </li>
                        <li id="archive" class="col-md-5 pointer">
                            <div class="msg msg_tab  text-center">Archives</div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-12 background-white border-box-right padding-top-4per padding-bottom-13per vertical-row search-box_tchat">
                    <input type="text" name="search_name" class="form-control search-tchat-text search_name" placeholder="Search...">
                    <i class="fa fa-search search_icon pointer padding-10"></i>                 
                </div>
                <?php
                $msg = get_chat_message_data($user_id);
                ?>
                <div class="col-md-12 background-white border-box-right t_chat_overflow">
                    <ul class="padding-0" id="user_list">
                        <?php
                        $user = $msg['from'];
                        
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
                                <div class="col-md-7">
                                    <label class="margin-0 bold font-color-black"><?php echo $data['to_name']; ?></label>
                                    <div class="icon-size"><i class="fa fa-reply" aria-hidden="true"></i> <?php echo $data['message']; ?></div>
                                </div>
                                <div class="col-md-5 dropdown"> 
                                    <i class="fa fa-ellipsis-v dropdown-toggle pull-right pointer font-22px" aria-hidden="true" id="dropdownMenu2" data-toggle="dropdown"></i>
                                    <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu2">
                                        <li class="archive_chat pointer" data-id="<?php echo $data['to']; ?>"><a>Archive</a></li>
                                        <li class="delete_chat pointer" data-id="<?php echo $data['to']; ?>"><a>Delete</a></li>                                        
                                    </ul>
                                </div>
                            </li>
                            <?php
                        endforeach;
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 border-top-gray border-bottom-gray background-white">
                <div class="col-md-12 padding-top-3per">
                    <!--                    <div class="vertical-row">
                                            <span class="border-bottom-gray padding-top-4per separator1"></span>
                                            <span class="padding-top-4per vertical-row separator2"><span>August</span><span>&nbsp;17</span></span>
                                            <span class="border-bottom-gray padding-top-4per separator3"></span>
                                        </div>-->
                    <div class="border-bottom-gray padding-0 col-md-12" id='chat-box'>
                        <?php
                        if (isset($msg[0]['to'])):
                            $conv = get_chat_conversion($user_id, $msg[0]['to']);
                            ?>

                            <input type="hidden" id="hidden-user-data" from-user-id="<?php echo $msg[0]['from'] ?>" from-user-name="<?php echo $msg[0]['from_name'] ?>" to-user-id="<?php echo $msg[0]['to'] ?>" to-user-name="<?php echo $msg[0]['to_name'] ?>" old_msg_cnt="<?php echo count(get_chat_conversion($user_id, $msg[0]['to'])); ?>"/>
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
                                                    <i class="fa fa-check" aria-hidden="true"></i> <?php echo $msg['message'] ?>
                                                <?php else:
                                                    ?>
                                                    <i class="fa fa-reply" aria-hidden="true"></i> <?php echo $msg['message'] ?>
                                                <?php endif; ?>                                                 
                                            </div>
                                        </div>
                                    </div>                                   
                                </div>
                                <?php
                            endforeach;
                        endif;
                        ?>                       
                    </div>

                    <div class="col-md-12 padding-0 padding-top-13per">
                        <textarea class="t_chat_textarea" placeholder="Write a reply...."></textarea>
                    </div>
                    <div class="col-md-12 padding-0 padding-bottom-13per padding-top-4per">
                        <button class="btn btn-default send_msg">Send</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#chat-box').animate({scrollTop: $('#chat-box').prop("scrollHeight")}, 500);
       //300000 MS == 5 minutes
       
       //archives chat
       $('.archive_chat').click(function(){
           var to_id = $(this).attr('data-id');
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'tchat-converstion.php' ?>",
                type: 'post',
                data: {                
                    action:'archive_chat',
                    to_id: to_id,                
                },
                success: function (data) {
                     location.reload();             
                }
            });
       });
       
       //delete chat
       $('.delete_chat').click(function(){
           var to_id = $(this).attr('data-id');
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'tchat-converstion.php' ?>",
                type: 'post',
                data: {                
                    action:'delete_chat',
                    to_id: to_id,                
                },
                success: function (data) {
                     location.reload();               
                }
            });
       });
       
    function ajaxCall() {
            var to_id = $('#hidden-user-data').attr('to-user-id');
            var old_msg_cnt = $('#hidden-user-data').attr('old_msg_cnt');
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'tchat-converstion.php' ?>",
                type: 'post',
                data: {
                    action: 'chat-converstion',
                    flag: 'recrsive',
                    old_msg_cnt: old_msg_cnt,
                    user_id: to_id
                },
                success: function (data) {
                    if (data != 'same as old') {
                        $('#chat-box').html(data);
                        $('#chat-box').animate({scrollTop: $('#chat-box').prop("scrollHeight")}, 500);
                    }
                }
            });
        }

    });
    $('.nav').on('click', 'li', function () {
        $('.nav li.active_tab').removeClass('active_tab');
        $(this).addClass('active_tab');
    });
    
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
                $('.t_chat_textarea').closest('div').html('<textarea class="t_chat_textarea" placeholder="Write a reply...."></textarea>');
            }
        });
    });
    $('.t_chat_textarea').bind('keypress', function (e) {
        if (e.which === 13) {
            $('.send_msg').click();
        }
    });
    $(document).on('click', '.user_list', function () {
        var id = $(this).attr('data-id');
        $.ajax({
            url: "<?php echo osc_current_web_theme_url() . 'tchat-converstion.php' ?>",
            type: 'post',
            data: {
                action: 'chat-converstion',
                user_id: id
            },
            success: function (data) {
                $('#chat-box').html(data);
                $('#chat-box').animate({scrollTop: $('#chat-box').prop("scrollHeight")}, 500);
            }
        });
    });

    $(document).on('keyup', '.search_name', function () {
        var search = $(this).val();
        $.ajax({
            type: 'post',
            url: "<?php echo osc_current_web_theme_url() . 'tchat-converstion.php' ?>",
            data: {
                search_action: 'search-action',
                search_text: search
            },
            success: function (data) {
                $('.t_chat_overflow').html(data);
                // $('#chat-box').animate({scrollTop: $('#chat-box').prop("scrollHeight")}, 500);
            }
        });
    });
</script>
<?php osc_current_web_theme_path('footer.php'); ?>