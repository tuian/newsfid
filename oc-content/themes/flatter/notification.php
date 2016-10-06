<?php
require '../../../oc-load.php';
require 'functions.php';

if ($_REQUEST['notification'] == 'notification'):
    $notifications = get_user_notification();
    ?>
    <div class="notification_dropdown border-bottom-gray">
        <span class="bold font-color-black">  Mark all as read</span> <span class="dropdown pull-right pointer padding-left-10"><i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-hidden="true"></i>
            <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                <li><a class="mark_all" user-id="<?php echo osc_logged_user_id(); ?>"><?php _e("Mark all as read", 'flatter'); ?> </a></li>
                <!--                <li class="circle_chat"><a class="chat-filter" data-value="circle"> See only my circle chat</a></li>
                                <li><a class="chat-filter" data-value="off">Turn chat off</a></li>-->
            </ul>
        </span>
    </div>
    <div class="background-white notification_list border-bottom-gray">
<div class="popup"></div>
        <?php foreach ($notifications as $n): ?>
            <div class="col-md-12 padding-top-10 border-bottom-gray padding-bottom-10 unread <?php
            if ($n['read_status'] == '0'): echo 'unread-notification';
            endif;
            ?>">
                <div class="col-md-3 padding-0">
                    <!--<img src="<?php echo $n['user_image'] ?>" class="img-circle user-icon" alt="User Image">-->
                    <img src="<?php echo $n['user_image'] ?>" data_user_id="<?php echo $n['from_user_id']; ?>" class="img-circle user-icon user_tchat" alt="User Image">                                
                </div>
                <div class="col-md-9 padding-0 bold dropdown"> <i class="fa fa-angle-down pull-right dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-hidden="true"></i>
                    <div class="user_chat_name"><a href="<?php echo osc_user_public_profile_url($n['from_user_id']) ?>" ><?php echo $n['user_name'] ?></a></div>
                    <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu3">
                        <li><a class="pointer mark_read" mark_time="<?php echo $n['id']; ?>" to_user_id="<?php echo $n['to_user_id']; ?>"><?php _e("Mark read", 'flatter'); ?> </a></li>
                        <li><a class="pointer unmark_read" mark_time="<?php echo $n['id']; ?>" to_user_id="<?php echo $n['to_user_id']; ?>"><?php _e(" Unmark as not read", 'flatter'); ?></a></li>                       
                    </ul>
                </div>
                <div class="col-md-9 padding-0 <?php
                if ($n['read_status'] == '0'): echo 'font-color-black';
                else: echo "light-gray";
                endif;
                ?> ">
                   <span class="notification_post pointer" item-id="<?php echo $n['item_id']; ?>"> <?php echo $n['message']; ?></span>  <span class="pull-right"><?php echo time_elapsed_string(strtotime($n['created'])); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php
endif;
?>

<script>
$(document).on('click', '.notification_post', function () {
	var item_id = $(this).attr('item-id');
	$.ajax({
            url: "<?php echo osc_current_web_theme_url() . 'popup_ajax.php'; ?>",
            type: 'post',
            data: {
                item_id: item_id
            },
            success: function (data) {
                $('.popup').html(data);
				$('#item_popup_modal').modal('show');
            }
        });
});
    $(document).on('click', '.mark_all', function () {
        var user = $(this).attr('user-id');
        $.ajax({
            url: "<?php echo osc_current_web_theme_url() . 'tchat_user_data.php'; ?>",
            type: 'post',
            data: {
                mark_all: 'mark_all',
                user_id: user
            },
            success: function (data) {
                $('.unread-notification').css('background-color', '#fff');
                var exist_cnt = parseInt($('.user_notification').attr('data-pending-message'));
                var no = 0;
                console.log(no);
                if (no !== 0) {
                    $('.user_notification').attr('data-pending-message', no);
                    $('.user_notification').html(no);
                } else {
                    $('.user_notification').hide();
                }

            }
        });
    });
    $(document).on('click', '.mark_read', function () {
        var mark_time = $(this).attr('mark_time');
        var to_id = $(this).attr('to_user_id');      
        $(this).closest('.unread-notification').removeClass('unread-notification');                
        $.ajax({
            url: "<?php echo osc_current_web_theme_url() . 'tchat_user_data.php'; ?>",
            type: 'post',
            data: {
                mark_read: 'mark_read',
                mark_time: mark_time,
                user_id: to_id
            },
            success: function (data) {
                $('.user_notification').show();
                var exist_cnt = parseInt($('.user_notification').attr('data-pending-message'));
                var no = exist_cnt - 1;                                
                $('.user_notification').attr('data-pending-message', no);
                $('.user_notification').html(no);
            }
        });
    });
    $(document).on('click', '.unmark_read', function () {
        var mark_time = $(this).attr('mark_time');
        var to_id = $(this).attr('to_user_id');
        $(this).closest('.unread').addClass('unread-notification'); 
        $.ajax({
            url: "<?php echo osc_current_web_theme_url() . 'tchat_user_data.php'; ?>",
            type: 'post',
            data: {
                mark_unread: 'mark_unread',
                mark_time: mark_time,
                user_id: to_id
            },
            success: function (data) {
                var exist_cnt = parseInt($('.user_notification').attr('data-pending-message'));
                var no = exist_cnt + 1;
                console.log(no);
                $('.user_notification').attr('data-pending-message', no);
                $('.user_notification').html(no);
                $('.user_notification').show();
            }

        });
    });
</script>