<!DOCTYPE html>
<html dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <meta charset="utf-8">
        <title><?php echo meta_title(); ?></title>
        <?php if (meta_description() != '') { ?>
            <meta name="description" content="<?php echo osc_esc_html(meta_description()); ?>" />
        <?php } ?>
        <?php if (meta_keywords() != '') { ?>
            <meta name="keywords" content="<?php echo osc_esc_html(meta_keywords()); ?>" />
        <?php } ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if (osc_is_ad_page()) { ?>
            <!-- Open Graph Tags -->
            <meta property="og:title" content="<?php echo osc_item_title(); ?>" />
            <meta property="og:image" content="<?php if (osc_count_item_resources()) { ?><?php echo osc_resource_url(); ?><?php } ?>" />
            <meta property="og:description" content="<?php echo osc_highlight(strip_tags(osc_item_description()), 120); ?>" />
            <!-- /Open Graph Tags -->
        <?php } ?>
        <?php if (osc_get_preference('g_webmaster', 'flatter_theme') != null) { ?>
            <meta name="google-site-verification" content="<?php echo osc_get_preference("g_webmaster", "flatter_theme"); ?>" />
        <?php } ?>
        <?php if (osc_get_canonical() != '') { ?><link rel="canonical" href="<?php echo osc_get_canonical(); ?>"/><?php } ?>
        <link rel="icon" href="favicon.ico" />
        <link href="<?php echo osc_current_web_theme_url('css/bootstrap.min.css'); ?>?ver=3.3.5" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('css/style.css'); ?>?ver=<?php echo $info['version']; ?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo osc_current_web_theme_url('css/mobilenav.css'); ?>" />
        <?php $getColorScheme = flatter_def_color(); ?>
        <?php osc_enqueue_style('' . $getColorScheme . 'green', osc_current_web_theme_url('css/' . $getColorScheme . '.css')); ?>
        <?php if (osc_get_preference('anim', 'flatter_theme') != '0') { ?>
            <link href="<?php echo osc_current_web_theme_url('css/animate.min.css'); ?>" rel="stylesheet" type="text/css" />
        <?php } ?>
        <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/owl.carousel.css'); ?>" type="text/css" media="screen" />
        <link href="<?php echo osc_current_web_theme_url('css/responsivefix.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('dist/css/skins/_all-skins.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('plugins/iCheck/flat/blue.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('css/bootstrap-switch.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('plugins/select2/select2.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('css/style2.css'); ?>" rel="stylesheet" type="text/css" />


        <!-- Header Hook -->
        <?php osc_run_hook('header'); ?>
        <!-- /Header Hook -->

        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/jquery.ias.min.js'); ?>"></script>

        <?php if (osc_get_preference('custom_css', 'flatter_theme', "UTF-8") != '') { ?>
            <style type="text/css">
    <?php echo osc_get_preference('custom_css', 'flatter_theme', "UTF-8"); ?>
            </style>
        <?php } ?>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="<?php flatter_body_class(); ?> skin-blue sidebar-mini" >
        <div class="wrapper row main_wrapper">
            <div class="col-md-2 col-sm-2 padding-0">
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <?php if (osc_is_web_user_logged_in()) : osc_user(); ?>
                            <?php
                            $user_id = osc_logged_user_id();
                            $user = get_user_data($user_id);
                            if (!empty($user[0]['s_path'])):
                                $img_path = osc_base_url() . '/' . $user[0]['s_path'] . $user[0]['pk_i_id'] . '.' . $user[0]['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>
                            <!-- Sidebar user panel -->

                            <div class="user-panel">
                                <div class="pull-left image">
                                    <!--<a href="<?php echo osc_user_profile_url() ?>">-->
                                    <a href="javascript:void(0)">
                                        <img src="<?php echo $img_path ?>" class="img-circle user-icon" alt="User Image">
                                    </a>
                                </div>
                                <div class="pull-left info">
                                    <!--<a href="<?php echo osc_user_profile_url() ?>">-->
                                    <a href="javascript:void(0)">
                                        <p>
                                            <!--<i class="fa fa-circle text-success"></i> -->
                                            <?php is_user_online(osc_logged_user_id()); ?> 
                                        </p>
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                                <div style="height: 10px;"></div>
                                <div class="pull-left">
                                    <!--<a href="<?php echo osc_user_profile_url() ?>">-->
                                    <a href="javascript:void(0)">
                                        <p><?php echo osc_logged_user_name() ?></p>
                                    </a>                                
                                </div>
                            </div>

                        <?php endif; ?>

                        <!-- search form -->
                        <div class="input-group sidebar-form search-newsfid" >
                            <input type="text"  name="q" class="form-control search-newsfid-text" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" id="search-btn" class="btn btn-flat search-newsfid-btn"><i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                        <!-- /.search form -->
                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu">
                            <!--<li class="header">MAIN NAVIGATION</li>-->
                            <?php
                            $url = $_SERVER['QUERY_STRING']; //you will get last part of url from there
                            $parts = explode('/', $url, 4);
                            ?>
                            <?php //if(strpos('page=home', $parts)$parts) ?>
                            <?php
                            $active = '';
                            if (empty($parts[0])):
                                $active = 'active';
                            else:
                                $active = '';
                            endif;
                            ?>
                            <li class="treeview <?php echo $active ?>">
                                <a href="<?php echo osc_base_url() ?>">
                                    <i class="fa fa-dashboard"></i>
                                    Fil d'actualité
                                </a>
                            </li>

                            <?php if (osc_is_web_user_logged_in()): ?>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-copy"></i>
                                        Ma chaîne
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (osc_is_web_user_logged_in()): ?>
                                <li class="treeview">

                                    <a href="<?php echo osc_base_url() . 'index.php?page=page&id=32' ?>">
                                        <i class="fa fa-th"></i>
                                        People
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (osc_is_web_user_logged_in()): ?>
                                <li class="add-item treeview" >
                                    <!--<a href="<?php echo osc_base_url() . 'index.php?page=item&action=item_add' ?>">-->
                                    <a href="javascript:void(0)" class="free_account" >
                                        <i class="fa fa-list-ul"></i>
                                        Publier
                                    </a>

                                </li>
                            <?php endif; ?>

                            <?php if (osc_is_web_user_logged_in()): ?>
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-th"></i>Compte
                                    </a>
                                </li>   
                                <?php
                                $active = '';
                                if (!empty($parts[0])):
                                    if (strpos($parts[0], 'page=user') !== false && strpos($parts[0], 'action=profile') !== false):
                                        $active = 'active';
                                    else:
                                        $active = '';
                                    endif;
                                endif;
                                ?>
                                <li class="user_settings treeview <?php echo $active ?>" data-toggle="modal" data-target="#user_confirm_password">
                                    <!--<a href="<?php echo osc_user_dashboard_url() ?>">-->
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-pie-chart"></i>Réglage
                                    </a>
                                </li>
                                <li class="treeview">
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-laptop"></i>m'abonner
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (osc_is_web_user_logged_in()): ?>

                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-book"></i>Terms
                                    </a>
                                </li>

                                <?php
                                $active = '';
                                if (!empty($parts[0])):
                                    if (strpos($parts[0], 'page=contact') !== false):
                                        $active = 'active';
                                    else:
                                        $active = '';
                                    endif;
                                endif;
                                ?>
                                <li class="treeview <?php echo $active ?>">                          
                                    <a href="<?php echo osc_contact_url(); ?>">
                                        <i class="fa fa-table"></i>Contact
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (!osc_is_web_user_logged_in()): ?>

                                <li class="treeview <?php echo $active ?>">
                                    <?php
                                    $active = '';
                                    if (!empty($parts[0])):
                                        if (strpos($parts[0], 'page=login') !== false):
                                            $active = 'active';
                                        else:
                                            $active = '';
                                        endif;
                                    endif;
                                    ?>
                                    <a href="<?php echo osc_user_login_url() ?>">
                                        <i class="fa fa-th"></i>Login
                                    </a>
                                </li>

                                <?php
                                $active = '';
                                if (!empty($parts[0])):
                                    if (strpos($parts[0], 'page=register') !== false):
                                        $active = 'active';
                                    else:
                                        $active = '';
                                    endif;
                                endif;
                                ?>

                                <li class="treeview <?php echo $active ?>">
                                    <a href="<?php echo osc_register_account_url() ?>">
                                        <i class="fa fa-pie-chart"></i>Register
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (osc_is_web_user_logged_in()) : osc_user(); ?>                                           

                                <li class="treeview">
                                    <a href="<?php echo osc_user_logout_url() ?>">
                                        <i class="fa fa-pie-chart"></i>Logout
                                    </a>
                                </li>

                            <?php endif; ?>

                        </ul>
                    </section>
                    <!-- /.sidebar -->
                </aside>
            </div>
            <div class="free-user-post"></div>
            <div class="search-newsfid-popup">                
                <div id="newsfid-search" class="modal fade" role="dialog">
                    <div class="modal-dialog search-popup">
                        <div class="modal-content">

                        </div>
                    </div>
                </div>                
            </div>
            <div class="user_passwor_popup_container">
                <div id="user_confirm_password" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="blue_text modal-title bold">
                                    Identification
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="">
                                    Cette page contient des informations personelles,<br/>
                                    <span class="bold">confirmer votre mot de passe pour y accéder.</span>
                                </div>
                                <div class="input-text-area margin-top-20 left-border box-shadow-none width-60">
                                    <input class="border-bottom-0 user_password_field" type="password" placeholder="Mot de passe">
                                </div>
                                <div class="red_text alert_text"></div>
                            </div>
                            <div class="modal-footer text-left">
                                <button type="button" class="btn btn-blue border-radius-0 user_password_check_btn">Confirmer</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php (osc_is_web_user_logged_in()) ? $class = "col-md-8 col-sm-8" : $class = "col-md-10 col-sm-10" ?>
            <div class="<?php echo $class ?> padding-0">
                <div class="content-wrapper">
                    <div class="content">
                        <a href="#" class="scrollToTop"><span class="fa fa-chevron-up fa-2x"></span></a>
                        <?php if (osc_show_flash_message()) { ?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 notification">
                                        <?php osc_show_flash_message(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


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
                            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

                            ga('create', 'UA-76423510-1', 'auto');
                            ga('send', 'pageview');

                        </script>

                        <script>
                            $(document).ready(function () {
                                $(document).on('click', '.free_account', function () {
                                    $.ajax({
                                        url: '<?php echo osc_current_web_theme_url() . 'popup_free_account_post.php' ?>',
                                        success: function (data) {
                                            $('.free-user-post').html(data);
//                                            $('#popup-free-user-post').appendTo("body");
                                            $('#popup-free-user-post').modal('show');
                                        }
                                    });
                                });
//                                $(document).on('click', '.user_settings', function () {
//                                    $.ajax({
//                                        url: '<?php echo osc_current_web_theme_url() . 'user_confirm_password_popup.php' ?>',
//                                        success: function (data) {
//                                            $('.user_passwor_popup_container').html(data);
//                                            $('#user_confirm_password').modal('show');
//                                        }
//                                    });
//                                });
                                $(document).on('click', '.user_password_check_btn', function () {
                                    var password = $('.user_password_field').val();
                                    $.ajax({
                                        url: '<?php echo osc_current_web_theme_url() . 'password_check_ajax.php' ?>',
                                        data: {
                                            password: password
                                        },
                                        success: function (data) {
                                            if (data == 1) {
                                                window.location.href = '<?php echo osc_user_profile_url() ?>'
                                            } else {
                                                $('.alert_text').html('password is not correct');
                                            }
                                        }
                                    });
                                });
                            });</script>
                        <script>
                            $(document).ready(function () {
                                $(document).on('click', '.search-newsfid-btn', function () {
                                    var search_newsfid_text = $('.search-newsfid-text').val();
                                    if (search_newsfid_text != '') {
                                        $.ajax({
                                            url: '<?php echo osc_current_web_theme_url() . 'search-newsfid.php' ?>',
                                            data: {
                                                search_newsfid_text: search_newsfid_text
                                            },
                                            success: function (data, textStatus, jqXHR) {
                                                $('.search-newsfid-popup .modal-content').empty().append(data);
                                                $('#newsfid-search').modal('show');
                                            }
                                        })
                                    }
                                });

                                $(document).on('keyup', '.search_newsfid_text', function () {
                                    var search_newsfid_text = $('.search_newsfid_text').val();
                                    if (search_newsfid_text != '') {
                                        $.ajax({
                                            url: '<?php echo osc_current_web_theme_url() . 'search-newsfid.php' ?>',
                                            data: {
                                                search_newsfid_text: search_newsfid_text
                                            },
                                            success: function (data) {
                                                $('.search-newsfid-popup .modal-content').empty().append(data);
                                            }
                                        })
                                    }
                                });
                            });
                        </script>
