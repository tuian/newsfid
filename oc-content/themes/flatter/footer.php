   
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
            //osc_run_hook('mdh_messenger_widget');
            //mdh_messenger_widget();
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
</body>
</html>