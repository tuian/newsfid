<?php
// meta tag robots
osc_add_hook('header', 'flatter_nofollow_construct');

flatter_add_body_class('login');
osc_enqueue_script('jquery-validate');
osc_current_web_theme_path('header.php');
?>
<div class="loginbox">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="login-register">

                    <br><br>
                    <div class="row">
                        <ul id="error_list"></ul>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-2">
                            <span class="login-text">
                                <span class="bold">Login</span> 
                            </span>
                            <span class="login-text">
                                <a href="<?php echo osc_register_account_url() ?>"> Register </a>
                            </span>
                        </div>
                    </div>

                    <form action="<?php echo osc_base_url(true); ?>" name="login" id="login" method="post" >
                        <input type="hidden" name="page" value="login" />
                        <input type="hidden" name="action" value="login_post" />
                        <div class="row vertical-row user_login_row">
                            <div class="col-md-2 padding-right-0 z-index-1">
                                <img class="user-img img-responsive img-circle" src="<?php echo osc_current_web_theme_url() . 'images/user-default.jpg'; ?>" alt="User profile picture">
                            </div>
                            <div class="col-md-5 padding-0 login_user_name">
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" id="email" placeholder="<?php _e('E-mail', 'flatter'); ?>">
                                </div>
                            </div>
                            <div class="col-md-5 padding-right-0">
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="<?php _e('Password', 'flatter'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5 col-md-offset-2">
                                <a class="reset_password color-white" href="<?php echo osc_recover_user_password_url() ?>" >
                                    <?php _e('Reset Password', 'flatter'); ?>
                                </a>
                            </div>
                            <div class="col-md-5 pull-right text-right">
                                <button type="submit" class="btn btn-custom"><?php _e("Connexion", 'flatter'); ?></button>
                            </div>
                        </div>
                        <div class="separate-30"></div>
                        <div class="row">
                            <div class="col-md-5 col-md-offset-7 pull-right text-right">
                                <a class="sign_in_another color-blue big-text" href="#" >
                                    <?php _e('Or sign in as a different user', 'flatter'); ?>
                                </a>
                            </div>

                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php LoginValidation(); ?>
<?php osc_current_web_theme_path('footer.php'); ?>