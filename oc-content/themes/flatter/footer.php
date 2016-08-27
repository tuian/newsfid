  
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



    <div class="tchat_profile col-md-5 padding-0 hide">
    </div>

    <div class="t-chat">
        <div class="chat-notification">
            <div class="col-md-2 padding-left-0 pointer">
                <a href="<?php echo osc_base_url() ?>">
                    <img src="<?php echo osc_current_web_theme_url() . '/images/newsfidlogo-white.png' ?>" width="20px" height="20px" style="cursor: pointer;">
                </a>
            </div>
            <div class="col-md-2 padding-left-0 pointer">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="col-md-2 padding-left-0 pointer">
                <a class="font-color-white" href="<?php echo osc_current_web_theme_url() . 't-chat.php' ?>">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    <?php if (get_pending_msg_cnt() > 0): ?>
                        <span class="label message-count"><?php echo get_pending_msg_cnt(); ?></span>
                    <?php endif; ?>
                </a>
            </div>
            <div class="col-md-2 padding-left-0 pointer">
                <i class="fa fa-bell notification" aria-hidden="true"></i>
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
                    <div class="col-md-12 margin-top-20">
                        <div class="col-md-3 padding-left-0">
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
                        <div class="col-md-9 padding-left-0">
                            <span class="bold chat-user"><a href="javascript:void(0)" onClick="FreiChat.create_chat_window(<?php echo "'" . $u['user_name'] . "'"; ?>, <?php echo $u['user_id']; ?>)"><?php echo $u['user_name']; ?></a></span>
                        </div>
                    </div>                        
                    <?php
                endforeach;
            endif;
            ?>   
        </div>
        <div id="chat-box-footer"></div>

    </div>	



<?php endif; ?>
<!-- / wrapper -->
<?php if (osc_get_preference('g_analytics', 'flatter_theme') != null) { ?>
    <script>
        $(document).on('click', '.notification', function () {

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
                }

            });
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
                    $('.tchat_profile').removeClass('hide');
                }

            });

            $(document).on('click', '.tchat_profile', function () {
                $('.tchat_profile').addClass('show');
                $('.tchat_profile').removeClass('hide');
            });
            $('body').click(function () {
                $('.tchat_profile').addClass('hide');
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