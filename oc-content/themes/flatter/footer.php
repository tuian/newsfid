  
<span style="padding-bottom: 10px;"></span>


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

<?php if (osc_is_web_user_logged_in()): ?>
    <?php $users = get_chat_users(); ?>
    <div class="tchat_profile col-md-5 padding-0 hide">

    </div>
    <div class="col-md-2 col-sm-2 padding-left-0">
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
                    </a>
                </div>
                <div class="col-md-2 padding-left-0 pointer">
                    <i class="fa fa-bell" aria-hidden="true"></i>
                </div>    
            </div>
            <div class="chat-menu">
                Conversations du cercle <span class="dropdown pull-right pointer"><i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-hidden="true"></i></i>
                    <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                        <li><a> See all chats</a></li>
                        <li><a> See only my circle chat</a></li>
                        <li><a>Turn chat off</a></li>
                    </ul>
                </span>
            </div>
            <div class="chat-user-overflow">                
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
                            <div class="col-md-4 padding-left-0">
                                <img src="<?php echo $img_path ?>" data_user_id="<?php echo $u['user_id'] ?>" class="img-circle user-icon user_tchat" alt="User Image">                                
                                <div class="onlineuser">
                                    <?php
                                    $user = User::newInstance()->findByPrimaryKey($u['user_id']);     // change it                        
                                    if (useronline_show_user_status($user['user_id']) == 1) {
                                        ?>
                                        <a class="chat_online_inline green-dot" id="onlineuser" href="javascript:void(0)" onClick="FreiChat.create_chat_window(<?php echo "'" . $user['user_name'] . "'"; ?>, <?php echo osc_item_user_id(); ?>)"></a>
                                    <?php } else { ?>
                                        <a class="chat_offline_inline" href="javascript:void(0)"></a>
                                    <?php } ?>
                                </div> 
                            </div>
                            <div class="col-md-8 padding-left-0">
                                <span class="bold chat-user"><?php echo $u['user_name']; ?></span>
                            </div>
                        </div>                        
                        <?php
                    endforeach;
                endif;
                ?>   
            </div>
            <div class="col-md-12 padding-0 background-white">
                <div class="chat-overflow">
                    <div class="col-md-12 margin-top-10">
                        <div class="col-md-12 padding-0 dropdown">
                            <span class="bold chat-user on_chat_user">Maccini News</span> 
                            <i class="fa fa-ellipsis-v pull-right dropdown-toggle" id="user_chat" data-toggle="dropdown" aria-hidden="true"></i></i>
                            <ul class="dropdown-menu edit-arrow" aria-labelledby="user_chat">
                                <li class="pointer"><a>Block this user</a></li>
                                <li class="pointer"><a>Close this chat</a></li>
                                <li class="pointer"><a>Turn chat off</a></li>
                            </ul>

                        </div>
                        <div class="col-md-4 padding-left-0">
                            <img class="img-circle" src="<?php echo osc_current_web_theme_url() . '/images/user3-128x128.jpg' ?>" width="50px">

                        </div>
                        <div class="col-md-8 padding-left-0"> 
                            <p class="chat-text"> oung Muslim....</p>
                        </div>
                    </div>
                    <div class="col-md-12 margin-top-10 padding-right-0">
                        <div class="col-md-12 padding-0"><span class="bold chat-user on_chat_user">Maccini News</span></div>
                        <div class="col-md-4 padding-left-0">

                            <img class="img-circle" src="<?php echo osc_current_web_theme_url() . '/images/user3-128x128.jpg' ?>" width="50px">

                        </div>
                        <div class="col-md-8 padding-0">

                            <p class="chat-text">  oung Muslimvvvoung Muslim oung Muslim oung Muslim oung Muslim </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-3 col-md-8 font-12 light_gray">user is typing....</div>
                <div class="col-md-12 margin-top-10 replay_area">
                    <textarea class="replay_area border-none outline-none color-white" placeholder="Write a replay..."></textarea>
                </div>
            </div>            
        </div>	

    </div>	

<?php endif; ?>
<!-- / wrapper -->
<?php if (osc_get_preference('g_analytics', 'flatter_theme') != null) { ?>
    <script>
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
<script src="<?php echo osc_current_web_theme_url('js/jPushMenu.js'); ?>"></script>
<script src="<?php echo osc_current_web_theme_url('js/main.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/owl.carousel.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap.min.js'); ?>?ver=3.3.5"></script>  
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/placeholders.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('dist/js/app.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap-switch.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('plugins/select2/select2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap-typeahead.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/jquery-dropdate.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/date.format.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/jquery.Jcrop.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/script.js'); ?>"></script>
</body>
</html>