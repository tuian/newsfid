<?php
require '../../../oc-load.php';
require 'functions.php';

if ($_REQUEST['notification'] == 'notification'):
    $notifications = get_user_notification();
    ?>
    <div class="notification_dropdown border-bottom-gray">
        <span class="bold font-color-black">  Marquer to comme lu</span> <span class="dropdown pull-right pointer padding-left-10"><i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-hidden="true"></i>
            <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                <li><a class="mark_all"> Mark all as read</a></li>
                <!--                <li class="circle_chat"><a class="chat-filter" data-value="circle"> See only my circle chat</a></li>
                                <li><a class="chat-filter" data-value="off">Turn chat off</a></li>-->
            </ul>
        </span>
    </div>
    <div class="background-white notification_list border-bottom-gray">

        <?php foreach ($notifications as $n): ?>
            <div class="col-md-12 padding-top-10 border-bottom-gray padding-bottom-10 <?php if($n['read_status']== '0'): echo 'unread-notification'; endif; ?>">
                <div class="col-md-3 padding-0">
                    <!--<img src="<?php echo $n['user_image'] ?>" class="img-circle user-icon" alt="User Image">-->
                    <img src="<?php echo $n['user_image'] ?>" data_user_id="<?php echo $n['from_user_id']; ?>" class="img-circle user-icon user_tchat" alt="User Image">                                
                </div>
                <div class="col-md-9 padding-0 bold dropdown"> <i class="fa fa-angle-down pull-right dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-hidden="true"></i>
                    <a href="<?php echo osc_user_public_profile_url($n['from_user_id']) ?>" ><?php echo $n['user_name'] ?></a>
                    <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu3">
                        <li><a class="pointer mark_read" mark_time="<?php echo $n['id']; ?>" to_user_id="<?php echo $n['to_user_id']; ?>"> Mark read</a></li>
                        <li><a class="pointer unmark_read" mark_time="<?php echo $n['id']; ?>" to_user_id="<?php echo $n['to_user_id']; ?>"> Unmark as not read</a></li>                       
                    </ul>
                </div>
                <div class="col-md-9 padding-0 <?php if($n['read_status']== '0'): echo 'font-color-black'; else: echo "light-gray"; endif; ?> ">
                    <?php echo $n['message']; ?>  <span class="pull-right"><?php echo time_elapsed_string(strtotime($n['created'])); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php
endif;
?>

<script>
    $(document).on('click', '.mark_all', function () {
        $.ajax({
            url: "<?php echo osc_current_web_theme_url() . 'tchat_user_data.php'; ?>",
            type: 'post',
            data: {
                mark_all: 'mark_all'
            }
        });
    });
    $(document).on('click', '.mark_read', function () {
        var mark_time = $(this).attr('mark_time');
        var to_id = $(this).attr('to_user_id');

        $.ajax({
            url: "<?php echo osc_current_web_theme_url() . 'tchat_user_data.php'; ?>",
            type: 'post',
            data: {
                mark_read: 'mark_read',
                mark_time: mark_time,
                user_id: to_id
            },
            success: function (data) {
               var exist_cnt = parseInt($('.user_notification').attr('data-pending-message'));
               var no = exist_cnt - 1;
               console.log(no);
                $('.user_notification').attr('data-pending-message', no);
                $('.user_notification').html(no);
            }
        });
    });
    $(document).on('click', '.unmark_read', function () {
        var mark_time = $(this).attr('mark_time');
        var to_id = $(this).attr('to_user_id');
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
            }

        });
    });
</script>