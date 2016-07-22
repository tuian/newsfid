   
<span style="padding-bottom: 10px;"></span>


<div id="footer" >
    <div class="footer-top bg">
        <div class="container">
            <div class="row">

                <div class="col-md-3 col-sm-4 col-xs-6 morelinks">
                    <h4><?php _e('Information', 'flatter'); ?></h4>
                    <div class="fb-content links">
                        <ul>
                            <?php
                            osc_reset_static_pages();
                            while (osc_has_static_pages()) {
                                ?>
                <!--                            <li><a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a></li>-->
                            <?php } ?>
                            <li><a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact us', 'flatter'); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-5 col-xs-6">
                    <?php if (osc_get_preference('facebook_likebox', 'flatter_theme') !== '0') { ?>
                        <?php if (function_exists("fb_page_plugin")) { ?>
                            <div class="hidden-xs">
                                <?php fb_page_plugin(); ?>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if (osc_get_preference('fcwidget_content', 'flatter_theme') != null) { ?>

                            <h4><?php echo osc_get_preference('fcwidget_title', 'flatter_theme'); ?></h4>
                            <div class="fb-content">
                                <?php echo osc_get_preference('fcwidget_content', 'flatter_theme'); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-12 followus col-md-offset-1">
                    <h4><?php _e('Follow us', 'flatter'); ?></h4>
                    <div class="fb-content social">
                        <?php if (osc_get_preference('facebook_page', 'flatter_theme') != null) { ?>
                            <a href="https://www.facebook.com/<?php echo osc_get_preference("facebook_page", "flatter_theme"); ?>" title="<?php _e('Follow on Facebook', 'flatter'); ?>" target="_blank" class="fb"><i class="fa fa-facebook fa-lg"></i></a>
                        <?php } ?>
                        <?php if (osc_get_preference('twitter_page', 'flatter_theme') != null) { ?>
                            <a href="https://twitter.com/<?php echo osc_get_preference("twitter_page", "flatter_theme"); ?>" title="<?php _e('Follow on Twitter', 'flatter'); ?>" target="_blank" class="tw"><i class="fa fa-twitter fa-lg"></i></a>
                        <?php } ?>
                        <?php if (osc_get_preference('gplus_page', 'flatter_theme') != null) { ?>
                            <a href="https://plus.google.com/<?php echo osc_get_preference("gplus_page", "flatter_theme"); ?>" title="<?php _e('Follow on Google+', 'flatter'); ?>" target="_blank" class="gp"><i class="fa fa-google-plus fa-lg"></i></a>
                        <?php } ?>
                        <?php if (osc_get_preference('pinterest_page', 'flatter_theme') != null) { ?>
                            <a href="http://www.pinterest.com/<?php echo osc_get_preference("pinterest_page", "flatter_theme"); ?>" title="<?php _e('Follow on Pinterest', 'flatter'); ?>" target="_blank" class="pi"><i class="fa fa-pinterest fa-lg"></i></a>
                        <?php } ?>
                        <a href="<?php echo osc_base_url(); ?>feed" title="<?php _e('RSS feed', 'flatter'); ?>" target="_blank" class="rf"><i class="fa fa-rss fa-lg"></i></a>
                    </div>
                    <div class="foot-language">
                        <?php if (osc_count_web_enabled_locales() > 1) { ?>
                            <?php osc_goto_first_locale(); ?>
                            <select class="form-control" id="langselection">
                                <option value="<?php echo osc_change_language_url(osc_current_user_locale()); ?>"><?php
                                    $lcode = osc_get_current_user_locale();
                                    echo $lcode['s_short_name'];
                                    ?></option>
                                <?php $i = 0; ?>
                                <?php
                                while (osc_has_web_enabled_locales()) {
                                    if (osc_locale_code() != osc_current_user_locale()) {
                                        ?>
                                        <option value="<?php echo osc_change_language_url(osc_locale_code()); ?>"><?php echo osc_locale_name(); ?></option>
                                        <?php
                                        if ($i == 0) {
                                            echo "";
                                        }
                                        ?>
                                        <?php $i++; ?>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $("#langselection").change(function () {
                                        location = $("#langselection option:selected").val();
                                    });
                                });
                            </script>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Footer Top -->
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
    <div class="col-md-2 col-sm-2 padding-left-0">
        <div class="t-chat">
            <div class="chat-notification">
                <div class="col-md-2 padding-left-0">
                    <img src="<?php echo osc_current_web_theme_url() . '/images/newsfidlogo-white.png' ?>" width="20px" height="20px" style="cursor: pointer;">
                </div>
                <div class="col-md-2 padding-left-0">
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                <div class="col-md-2 padding-left-0">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </div>
                <div class="col-md-2 padding-left-0">
                    <i class="fa fa-bell" aria-hidden="true"></i>
                </div>    
            </div>
            <div class="chat-dropdown">
                <select class="orange">
                    <option>Conversations du cercle</option>
                </select>
            </div>
            <div class="col-md-12 margin-top-20">
                <div class="col-md-5 padding-left-0">
                    <img class="img-circle" src="<?php echo osc_current_web_theme_url() . '/images/user3-128x128.jpg' ?>" width="50px">
                    <div class="green-dot"></div>            </div>
                <div class="col-md-7 padding-left-0">
                    <span class="bold chat-user">Maccini News</span>
                </div>
            </div>
            <div class="col-md-12 margin-top-20">
                <div class="col-md-5 padding-left-0">
                    <img class="img-circle" src="<?php echo osc_current_web_theme_url() . '/images/user1-128x128.jpg' ?>" width="50px">

                </div>
                <div class="col-md-7 padding-left-0">
                    <span class="bold chat-user">Maccini News</span>
                    <p class="chat-text"> oung Muslim....</p>
                </div>
            </div>
            <div class="col-md-12 margin-top-20">
                <div class="col-md-5 padding-left-0">
                    <img class="img-circle" src="<?php echo osc_current_web_theme_url() . '/images/user4-128x128.jpg' ?>" width="50px">

                </div>
                <div class="col-md-7 padding-left-0">
                    <span class="bold chat-user">Maccini News</span>
                    <p class="chat-text"> oung Muslim....</p>
                </div>
            </div>
            <div class="col-md-12 margin-top-20">
                <div class="col-md-5 padding-left-0">
                    <img class="img-circle" src="<?php echo osc_current_web_theme_url() . '/images/user3-128x128.jpg' ?>" width="50px">

                </div>
                <div class="col-md-7 padding-left-0">
                    <span class="bold chat-user">Maccini News</span>
                    <p class="chat-text"> oung Muslim....</p>
                </div>
            </div>
            <div class="right-sidebar">

            <?php
            osc_run_hook('mdh_messenger_widget');
            mdh_messenger_widget();
            ?>
        </div>
        </div>	
        
    </div>	

<?php endif; ?>
</div> <!-- / wrapper -->
<?php if (osc_get_preference('g_analytics', 'flatter_theme') != null) { ?>
    <script>
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
        ga('send', 'pageview');
    </script>
<?php } ?>
<?php if (osc_get_preference('anim', 'flatter_theme') != '0') { ?>
    <script src="<?php echo osc_current_web_theme_url('js/wow.min.js'); ?>"></script>
    <script type="text/javascript">
        new WOW().init();
    </script>
<?php } ?>
<?php osc_run_hook('footer'); ?>
<?php if (osc_is_home_page() && !osc_is_web_user_logged_in()): ?>
    <style type="text/css">
        #footer {
            display: block;
        }
    </style>
<?php endif; ?>
<script src="<?php echo osc_current_web_theme_url('js/jPushMenu.js'); ?>"></script>
<script src="<?php echo osc_current_web_theme_url('js/main.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/owl.carousel.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap.min.js'); ?>?ver=3.3.5"></script>  
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/placeholders.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('dist/js/app.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap-switch.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('plugins/select2/select2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap-typeahead.min.js'); ?>"></script>

</body>
</html>