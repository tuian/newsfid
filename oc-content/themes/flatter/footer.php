  
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
                            <?php _e('Powered by', ' '); ?> <a title="Osclass" target="_blank" rel="nofollow" href="http://osclass.org/"><?php _e("Eustache & Madisse SAS", 'flatter'); ?>  </a> 
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
    <div class="tchat_profile col-md-6 padding-0"></div>
    <div class="t-chat t_chat_menu" id="t_chat_menu">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="chat-notification">
            <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0 pointer text-center">
                <a href="<?php echo osc_base_url() ?>">
                    <img src="<?php echo osc_current_web_theme_url() . '/images/blacklogo.png' ?>" width="20px" height="20px" style="cursor: pointer;">
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
            <div class="col-md-2 col-sm-2 col-xs-2 padding-left-0 pointer soundpass">
                <a class="font-color-white"><i class="fa fa-headphones" aria-hidden="true"></i></a>
            </div>    
        </div>

        <div class="notification-area"></div>
        <div class="chat-menu">
            <?php _e('Discuss with your circle', 'flatter'); ?> <span class="dropdown pull-right pointer"><i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-hidden="true"></i></i>
                <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                    <li><a class="chat-filter" data-value="all"><?php _e('See all chats', 'flatter'); ?></a></li>
                    <li class="circle_chat"><a class="chat-filter" data-value="circle"> <?php _e('See only my circle chat', 'flatter'); ?></a></li>
                    <li class="pointer chat-filter chat_option">                               
                        <?php
                        $a = get_user_online_status(osc_logged_user_id());
                        if (!empty($a)):
                            if ($a['status'] == 0):
                                ?>
                                <a class="chat_off"><?php _e("Turn chat off", 'flatter'); ?></a>
                            <?php else: ?>
                                <a class="chat_on"><?php _e("Turn chat on", 'flatter'); ?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                </ul>
            </span>
        </div>
        <div class="soundpass-show" style="display: none">
            <img src="<?php echo osc_current_web_theme_url() ?>images/2.jpg" style="filter: blur(4px);">
            <img src="<?php echo osc_current_web_theme_url() ?>images/1.jpg" class="img-circle circle_sound">
            <a  href="javascript: openwindow()"><i class="fa fa-2x fa-play play_btn" aria-hidden="true"></i></a>
            <span class="sound_pass">SoundPass</span>
        </div>
        <div class="soundpass-text padding-7per text-center" style="display: none"><?php _e('Promote your brand or company at anytime', 'flatter');?></div>
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
                                $a = get_user_online_status($u['user_id']);
                                if (!empty($a)):
                                    if ($a['status'] == 0):
                                        ?>
                                        <div class="green-dot"></div>
                                        <?php
                                    endif;
                                endif;
                                ?>
                            </div>
                        </div>
                        <div class = "col-md-9 col-sm-9 col-xs-9 padding-left-0 user_chat_name">
                            <span class = "bold chat-user" to-user-id = "<?php echo $u['user_id']; ?>"><a href = "javascript:void(0)"><?php echo $u['user_name'];
                                ?></a></span>
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
                        <div class="col-md-2 padding-0 orange padding-right-10"><?php  _e("With", 'flatter'); ?></div>
                        <div class="col-md-10 dropdown"> 
                            <i class="fa fa-ellipsis-v dropdown-toggle pull-right pointer font-22px" aria-hidden="true" id="dropdownMenu2" data-toggle="dropdown"></i>
                            <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu2">
                                <li class="pointer block_user"><a><?php _e("Block this user", 'flatter'); ?></a></li>
                                <li class="close_chat pointer"><a><?php _e("Close this chat", 'flatter'); ?> </a></li>
                                <li class="pointer"><a><?php _e("Turn chat off", 'flatter'); ?></a></li>
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
                        <?php _e('no ongoing conversation history', 'flatter'); ?>
                    </div>
                </div>
                <!--                <div class="typing col-md-12 background-white"> Dhaval is typing.....</div>-->

                <div class="textarea">
                    <textarea class="msg_textarea" placeholder="<?php _e('Press enter to reply', 'flatter'); ?>"></textarea>
                    <img src="<?php echo $img_path; ?>" class="img-circle user_chat_photo" width="40px">
                </div>
            </div>
        </div>
        <div id="chat-box-footer"></div>

    </div>	



<?php endif; ?>
<script src="<?php echo osc_current_web_theme_url('js/jquery/jquery-1.11.2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('plugins/select2/select2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap-typeahead.min.js'); ?>"></script>
<script src="<?php echo osc_current_web_theme_url('js/jPushMenu.js'); ?>"></script>
<?php
$user_id = osc_logged_user_id();
$user = get_user_data($user_id);
if (!empty($user['s_path'])):

endif;
?>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/owl.carousel.min.js'); ?>"></script>
<script src="<?php echo osc_current_web_theme_url('js/main.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap.min.js'); ?>?ver=3.3.5"></script>  
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/placeholders.min.js'); ?>"></script>

<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap-switch.min.js'); ?>"></script>

<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/jquery-dropdate.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/date.format.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/jquery.Jcrop.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/script.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_base_url() . 'oc-content/plugins/slider/responsiveslides.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.geocomplete.js') ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/masonry.pkgd.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/imagesloaded.pkgd.min.js'); ?>"></script>        

<script type="text/javascript" src="<?php echo osc_current_web_theme_url('dist/js/app.min.js'); ?>"></script>
<?php if (osc_get_preference('g_analytics', 'flatter_theme') != null) { ?>
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
                        $('.chat_off').text('<?php _e("Turn chat off", 'flatter') ?>');
                        location.reload();
                    }
                })
            });
            $(function () {
                $('.soundpass').click(function () {
                    $('.chat-menu').hide();
                    $('.chat-user-overflow').hide();
                    $('.notification_dropdown').hide();
                    $('.notification_list').hide();
                    $('.soundpass-text').show();
                    $('.soundpass-show').show();
                });
            });

    </script>


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
            $('.msg_him').css('display', 'none');
            $('.msg_me').css('display', 'none');
            $('.user_name_chat').css('display', 'none');
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'chat-converstion.php' ?>",
                type: 'post',
                data: {
                    action: 'close-chat-converstion',
                },
                success: function (data) {
                }
            });
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
                    $('.soundpass-show').hide();
                    $('.soundpass-text').hide();
                }

            });
        });
        $(document).on('click', '.chat-window-button', function () {
            $('.notification1').addClass('notification').removeClass('orange').removeClass('notification1');
            $('.notification-area').hide();
            $('.soundpass-show').hide();
            $('.soundpass-text').hide();
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
            $('.soundpass-show').hide();
            $('.soundpass-text').hide();
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
                    $(".tchat_profile").show('slow').html(data);
                }
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