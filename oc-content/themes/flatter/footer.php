  
<span style="padding-bottom: 10px;"></span>

<?php
if (osc_is_web_user_logged_in()):
    $users = get_chat_users();
    ?>
    <div id="footer" >    
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6 copyright">
                        &copy; <?php echo date('Y'); ?> <a href="#"><?php echo osc_page_title(); ?></a>. <?php _e('All Rights Reserved', 'flatter'); ?>. 
                        <?php if (osc_get_preference('footer_link', 'flatter_theme') !== '0') { ?>
                            <?php _e('Powered by', ' '); ?> <a title="Osclass" target="_blank" rel="nofollow" href="http://osclass.org/"> Eustache & Madisse SAS </a> 
                        <?php } ?>
                    </div>
                    <?php if (osc_get_preference('footer_link', 'flatter_theme') !== '0') { ?>
                        <div class="col-md-6 col-sm-6 col-xs-6 powered">
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
    <!-- / Footer -->
    <!-- / content -->


    <span class="t_chat_open" onclick="openNav()">T-Chat</span>
    <div class="tchat_profile col-md-6 padding-0 hide">
    </div>
    <div class="t-chat t_chat_menu" id="t_chat_menu">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="chat-notification">
            <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0 pointer text-center">
                <a href="<?php echo osc_base_url() ?>">
                    <img src="<?php echo osc_current_web_theme_url() . '/images/newsfidlogo-white.png' ?>" width="20px" height="20px" style="cursor: pointer;">
                </a>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0 pointer text-center">
                <i class="fa fa-user chat-window-button" aria-hidden="true"></i>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0 pointer text-center">
                <a class="font-color-white" href="<?php echo osc_current_web_theme_url() . 't-chat.php' ?>">
                    <?php
                    $active = '';
                    if ((strpos($_SERVER['REQUEST_URI'], 't-chat') !== false)):
                        $active = 'orange';
                    else:
                        $active = '';
                    endif;
                    ?> 
                    <i class="fa fa-envelope <?php echo $active; ?>" aria-hidden="true"></i>
                    <?php if (get_pending_msg_cnt() > 0): ?>
                        <span class="label message-count"><?php echo get_pending_msg_cnt(); ?></span>
                    <?php endif; ?>
                </a>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0 pointer">
                <i class="fa fa-bell notification" aria-hidden="true"></i>
                <?php
                if (get_pending_notification_cnt() > 0):
                    $pending_msg_cnt = get_pending_notification_cnt();
                    ?>
                    <span class="label message-count user_notification" data-pending-message="<?php echo $pending_msg_cnt ?>"><?php echo $pending_msg_cnt ?></span>
                <?php endif; ?>
            </div>    
        </div>

        <div class="notification-area"></div>
        <div class="chat-menu">
            Discuss with your circle <span class="dropdown pull-right pointer"><i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-hidden="true"></i></i>
                <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                    <li><a class="chat-filter" data-value="all"> See all chats</a></li>
                    <li class="circle_chat"><a class="chat-filter" data-value="circle"> See only my circle chat</a></li>
                    <li><a class="chat-filter" data-value="off">Turn chat off</a></li>
                </ul>
            </span>
        </div>
        <div class="chat-user-overflow" id="chat-user-list">                
            <?php
            if (!empty($users)):
                foreach ($users as $u):

                    if (!empty($u['s_path'])):
                        $img_path = osc_base_url() . $u['s_path'] . $u['pk_i_id'] . '.' . $u['s_extension'];
                    else:
                        $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                    endif;
                    ?>
                    <div class="col-md-12 col-sm-12 col-xs-12 margin-top-20">
                        <div class="col-md-3 col-sm-3 col-xs-3 padding-left-0">
                            <img src="<?php echo $img_path ?>" data_user_id="<?php echo $u['user_id'] ?>" class="img-circle user-icon user_tchat" alt="User Image">                                
                            <div class="onlineuser">
                                <?php
                                if (useronline_show_user_status($u['user_id']) == 1) {
                                    ?>
                                    <div class="green-dot"></div>                                        
                                <?php } else { ?>
                                    <!--<a class="chat_offline_inline" href="javascript:void(0)"></a>-->
                                <?php } ?>
                            </div> 
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-9 padding-left-0">
                            <span class="bold chat-user" to-user-id="<?php echo $u['user_id']; ?>"><a href="javascript:void(0)"><?php echo $u['user_name']; ?></a></span>
                        </div>
                    </div>                        
                    <?php
                endforeach;
            endif;
            ?>   
        </div>
        <div id="online-chat">
            <div class="chat_box">

                <div class="background-white col-md-12 padding-10">
                    <div class="bold">
                        <div class="col-md-2 padding-0 orange padding-right-10"> With</div>
                        <div class="col-md-10 dropdown"> 
                            <i class="fa fa-ellipsis-v dropdown-toggle pull-right pointer font-22px" aria-hidden="true" id="dropdownMenu2" data-toggle="dropdown"></i>
                            <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu2">
                                <li class="pointer"><a>Block this user</a></li>
                                <li class="close_chat pointer"><a> Close this chat</a></li>
                                <li class="pointer"><a>Turn chat off</a></li>
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
                        no ongoing conversation history
                    </div>
                </div>
                <!--                <div class="typing col-md-12 background-white"> Dhaval is typing.....</div>-->

                <div class="textarea">
                    <textarea class="msg_textarea" placeholder="Press enter to reply"></textarea>
                    <img src="<?php echo $img_path; ?>" class="img-circle user_chat_photo" width="40px">
                </div>
            </div>
        </div>
        <div id="chat-box-footer"></div>

    </div>	



<?php endif; ?>
<!-- / wrapper -->
<?php if (osc_get_preference('g_analytics', 'flatter_theme') != null) { ?>
    <script>

        $(document).ready(function () {
            var chat_user_id = '<?php echo osc_get_preference('chat_user_id'); ?>';
            if (chat_user_id !== '') {
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url() . 'chat-converstion.php' ?>",
                    type: 'post',
                    data: {
                        action: 'chat-converstion',
                        user_id: chat_user_id
                    },
                    success: function (data) {
                        $('#online-chat').html(data);
                        $('#online-chat').css('display', 'block');
                        $('.msg').animate({scrollTop: $('.msg').prop("scrollHeight")}, 10);
                    }
                });
            }
        });
        $(document).on('click', '.chat-user', function () {
            var id = $(this).attr('to-user-id');
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'chat-converstion.php' ?>",
                type: 'post',
                data: {
                    action: 'chat-converstion',
                    user_id: id
                },
                success: function (data) {
                    $('#online-chat').html(data);
                    $('#online-chat').css('display', 'block');
                    $('.msg').animate({scrollTop: $('.msg').prop("scrollHeight")}, 10);
                }
            });
        });
        $(document).on('click', '.close_chat', function () {
            $('#online-chat').css('display', 'none');
        });

        $(document).on('click', '.closebtn', function () {
            $('#t_chat_menu').css("display", "none");
            $('.t_chat_menu').css("transition", "0.9s");
            $('.t_chat_open').show();
        });
        $(document).on('click', '.t_chat_open', function () {
            $('.t_chat_open').hide();
            $('#t_chat_menu').css("width", "250px");
            $('.t_chat_menu').css("transition", "0.9s");
            $('#t_chat_menu').css("display", "block");
        });
        $(document).on('click', '.notification', function () {
            $('.notification').addClass('notification1 orange').removeClass('notification');
            $('.notification-area').show();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'notification.php'; ?>",
                method: 'post',
                data: {
                    notification: 'notification'
                },
                success: function (data, textStatus, jqXHR) {
                    $('.notification-area').html(data);
                    $('.chat-menu').hide();
                    $('#chat-user-list').hide();
                    $('#online-chat').hide();

                }

            });
        });
        
        $(document).on('click', '.chat-window-button', function () {
            $('.notification1').addClass('notification').removeClass('orange').removeClass('notification1');
            $('.notification-area').hide();
            $('.chat-menu').show();
            $('#chat-user-list').show();
            $('#online-chat').show();
        });
        $(document).on('click', '.notification1', function () {
            $('.notification1').addClass('notification').removeClass('orange').removeClass('notification1');
            $('.notification-area').hide();
            $('.chat-menu').show();
            $('#chat-user-list').show();
            $('#online-chat').show();
        });

        $(document).on('click', '.user_tchat', function () {
            var user_id = $(this).attr('data_user_id');
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'tchat_user_data.php'; ?>",
                method: 'post',
                data: {
                    user_id: user_id
                },
                success: function (data, textStatus, jqXHR) {
                    $('.tchat_profile').html(data);
                    $('.tchat_profile').addClass('show');
                    $(".tchat_profile").animate({
                        width: '700px',
                    });
                    $('.tchat_profile').removeClass('hide');
                }

            });
            $(document).on('click', '.tchat_profile', function () {
                $('.tchat_profile').addClass('show');
                $('.tchat_profile').removeClass('hide');
            });
            $('body').click(function () {

                $(".tchat_profile").animate({
                    width: '0px',
                });
            });
        });
        $(document).on('click', '.chat-filter', function () {
            var filter = $(this).attr('data-value');
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'custom-function.php'; ?>",
                method: 'post',
                data: {
                    action: 'chat-filter',
                    filter: filter
                },
                success: function (data, textStatus, jqXHR) {
                    $('#chat-user-list').html(data);
                }
            });
        });
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', '<?php echo osc_get_preference("g_analytics", "flatter_theme"); ?>', 'auto');
        ga('send', 'pageview');</script>
<?php } ?>
<?php if (osc_get_preference('anim', 'flatter_theme') != '0') { ?>
    <script src="<?php echo osc_current_web_theme_url('js/wow.min.js'); ?>"></script>
    <script type="text/javascript">
            new WOW().init();</script>
<?php } ?>
<?php osc_run_hook('footer'); ?>
<?php if (osc_is_home_page() && !osc_is_web_user_logged_in()): ?>
    <style type="text/css">
        #footer {
            display: block;
        }
    </style>
<?php endif; ?>
<?php osc_current_web_theme_path('script_code.php') ?>    
</body>
</html>