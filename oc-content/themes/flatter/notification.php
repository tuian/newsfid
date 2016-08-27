<?php
require '../../../oc-load.php';
require 'functions.php';

if ($_REQUEST['notification'] == 'notification'):
    $users = get_chat_users();
    if (!empty($users['s_path'])):
        $img_path = osc_base_url() . $users['s_path'] . $users['pk_i_id'] . '.' . $users['s_extension'];
    else:
        $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
    endif;
    ?>
    <div class="notification_dropdown border-bottom-gray">
        <span class="bold font-color-black">  Marquer to comme lu</span> <span class="dropdown pull-right pointer padding-left-10"><i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-hidden="true"></i></i>
            <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                <li><a class="chat-filter" data-value="all"> See all chats</a></li>
                <li class="circle_chat"><a class="chat-filter" data-value="circle"> See only my circle chat</a></li>
                <li><a class="chat-filter" data-value="off">Turn chat off</a></li>
            </ul>
        </span>
    </div>
    <div class="background-white notification_list border-bottom-gray">
        <div class="col-md-12 margin-top-20">
            <div class="col-md-3 padding-left-0">
                <img src="<?php echo $img_path ?>" data_user_id="<?php echo $users['user_id'] ?>" class="img-circle user-icon user_tchat" alt="User Image">                                
            </div>
            <div class="col-md-9 padding-left-0">
                user notification
            </div>
        </div>
    </div>
    
    <?php
endif;
?>