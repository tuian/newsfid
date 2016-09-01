<?php
require '../../../oc-load.php';
require 'functions.php';

if ($_REQUEST['notification'] == 'notification'):
    $notifications = get_user_notification();
    ?>
    <div class="notification_dropdown border-bottom-gray">
        <span class="bold font-color-black">  Marquer to comme lu</span> <span class="dropdown pull-right pointer padding-left-10"><i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-hidden="true"></i>
            <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                <li><a class="chat-filter" data-value="all"> See all chats</a></li>
                <li class="circle_chat"><a class="chat-filter" data-value="circle"> See only my circle chat</a></li>
                <li><a class="chat-filter" data-value="off">Turn chat off</a></li>
            </ul>
        </span>
    </div>
    <div class="background-white notification_list border-bottom-gray">
        <?php foreach ($notifications as $n): ?>
            <div class="col-md-12 padding-top-10 border-bottom-gray padding-bottom-10">
                <div class="col-md-3 padding-0">
                    <img src="<?php echo $n['user_image'] ?>" class="img-circle user-icon" alt="User Image">                                
                </div>
                <div class="col-md-9 padding-0 bold dropdown"> <i class="fa fa-angle-down pull-right dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-hidden="true"></i>
                    <?php echo $n['user_name'] ?>
                    <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu3">
                        <li><a class="pointer"> Mark as read</a></li>
                        <li><a class="pointer"> Unmark as not read</a></li>                       
                    </ul>
                </div>
                <div class="col-md-9 padding-0 light_gray">
                    <?php echo $n['message']; ?>  <span class="pull-right"><?php echo time_elapsed_string(strtotime($n['created'])); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php
endif;
?>