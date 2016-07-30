<?php
// meta tag robots
osc_add_hook('header', 'flatter_follow_construct');
if (!osc_logged_user_id()):
    osc_add_flash_error_message('You need to login to watch profile');
    osc_redirect_to(osc_base_url());
endif;
$address = '';
if (osc_user_address() != '') {
    if (osc_user_city_area() != '') {
        $address = osc_user_address() . ", " . osc_user_city_area();
    } else {
        $address = osc_user_address();
    }
} else {
    $address = osc_user_city_area();
}
$location_array = array();
if (trim(osc_user_city() . " " . osc_user_zip()) != '') {
    $location_array[] = trim(osc_user_city() . " " . osc_user_zip());
}
if (osc_user_region() != '') {
    $location_array[] = osc_user_region();
}
if (osc_user_country() != '') {
    $location_array[] = osc_user_country();
}
$location = implode(", ", $location_array);
unset($location_array);

osc_enqueue_script('jquery-validate');

flatter_add_body_class('user-public-profile');
osc_add_hook('before-main', 'sidebar');

function sidebar() {
    osc_current_web_theme_path('user-public-sidebar.php');
}
?>
<?php osc_current_web_theme_path('header.php'); ?>


<!-- profil cover -->

<div id="cover" class="cover">
    <?php
    if (get_user_last_post_resource(osc_user_id()) !== FALSE):
    //get_user_last_post_resource(osc_user_id());
    else:
        ?>
        <img src="<?php echo osc_current_web_theme_url() . "/images/cover_home_image.jpg" ?>" />
    <?php
    endif;
    ?>
    <?php if (function_exists("profile_picture_show")) { ?>
        <?php //profile_picture_show(); ?>

    <?php } else { ?>
        <img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim(osc_user_email()))); ?>?s=150&d=<?php echo osc_current_web_theme_url('images/user-default.jpg'); ?>" class="img-responsive" />
    <?php } ?>
</div>
<!-- end profil cover -->
<?php
$user = get_user_data(osc_user_id());
?>
<div id="sections">
    <div class="user_area">
        <div class="row">
            <div class="col-md-4">
                <div class=" bg-white col-md-12 padding-0">
                    <?php
                    if ($user['cover_picture_user_id']):
                        $cover_image_path = osc_base_url() . 'oc-content/plugins/profile_picture/images/profile' . $user['cover_picture_user_id'] . '.' . $user['pic_ext'];
                    else:
                        $cover_image_path = osc_current_web_theme_url() . "/images/cover_image.jpg";
                    endif;
                    ?>
                    <div class="box box-widget widget-user">
                        <div class="widget-user-header bg-black" style="background: url('<?php echo $cover_image_path ?>') center center;">
                            <h3 class="widget-user-username">
                                <?php echo $user['user_name'] ?>
                            </h3>
                            <h5 class="widget-user-desc">
                                <?php echo $user['role_name'] ?>
                            </h5>      
                            <?php if (osc_user_id() == osc_logged_user_id()): ?>
                                <span class="profile_img_overlay">
                                    <form class="cover_image_upload" method="post" enctype="multipart/form-data">
                                        <span class="icon">
                                            <i class="fa fa-camera"></i>
                                        </span>
                                        <input type="file" name="file" class="file user_cover_img">
                                    </form>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="widget-user-image">
                            <?php
                            if (!empty($user['s_path'])):
                                $img_path = osc_base_url() . '/' . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>

                            <?php get_user_profile_picture($user['user_id']) ?>

                            <?php if (osc_user_id() == osc_logged_user_id()): ?>
                                <span class="profile_img_overlay">
                                    <form class="file_upload" method="post" enctype="multipart/form-data">
                                        <span class="icon">
                                            <i class="fa fa-camera"></i>
                                        </span>
                                        <input type="file" name="file" class="file user_profile_img">
                                    </form>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            <?php
                                            $user_following = get_user_following_data($user['user_id']);
                                            if ($user_following):
                                                echo count($user_following);
                                            else:
                                                echo 0;
                                            endif;
                                            ?>
                                        </h5>
                                        <span class="description-text">
                                            ABONNEMENTS
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            <?php
                                            $user_followers = get_user_follower_data($user['user_id']);
                                            if ($user_followers):
                                                echo count($user_followers);
                                            else:
                                                echo 0;
                                            endif;
                                            ?>
                                        </h5>
                                        <span class="description-text">
                                            FOLLOWERS
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            <?php
                                            $user_likes = get_user_item_likes($user['user_id']);
                                            if ($user_likes):
                                                echo count($user_likes);
                                            else:
                                                echo 0;
                                            endif;
                                            ?>
                                        </h5>
                                        <span class="description-text">LIKES</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="box box-default">
                        <div class="box-header with-border">

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <span> What are you looking for?</span>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body" style="display: block;">                             
                            <select class="form-control select2 post_type_filter" style="width: 100%;" tabindex="-1" title="Podcast" aria-hidden="true">
                                <option value="image">Image</option>                                
                                <option value="video">Video</option>                                
                                <option value="gif">Gif</option>                                
                                <option value="music">Music</option>                                
                                <option value="podcast">Podcast</option>                                
                            </select>
                        </div> 

                        <div class="box-body" style="display: block;">
                            <div class="category-dropdown left-border margin-top-20" style="display: block;">
                                <?php osc_goto_first_category(); ?>
                                <?php if (osc_count_categories()) { ?>
                                    <select id="sCategory" class="form-control input-box" name="sCategory">
                                        <option value=""><?php _e('&nbsp; Category', 'flatter'); ?></option>
                                        <?php while (osc_has_categories()) { ?>
                                            <option class="maincat bold" value="<?php echo osc_category_id(); ?>"><?php echo osc_category_name(); ?></option>
                                            <?php if (osc_count_subcategories()) { ?>
                                                <?php while (osc_has_subcategories()) { ?>
                                                    <option class="subcat margin-left-30" value="<?php echo osc_category_id(); ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo osc_category_name(); ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>

                                    </select>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="box-body" style="display: block;">
                            <input type="text" class="filter_city" data_location_id="" data_location_type="city">
                        </div>
                        <div class="box-body" style="display: block;">                            
                            <button type="submit" class="btn btn-box-tool filter-button" data-toggle="tooltip" title="Apply">Apply</button>
                        </div>
                    </div>
                    <!-- /.box -->                 
                </div>
            </div>

            <div class="col-md-8 padding-left-0">
                <ul class="nav nav-tabs user_profile_navigation bg-white">
                    <li class="active user_posts"><a data-toggle="tab" data-target="#user_posts" href="javascript:void(0)">Post</a></li>
                    <li class="user_info"><a data-toggle="tab" data-target="#user_info" href="javascript:void(0)">Infos</a></li>
                    <li class="user_watchlist"><a data-toggle="tab" data-target="#user_watchlist" href="javascript:void(0)">Watchlist</a></li>
                    <?php if (osc_user_id() == osc_logged_user_id()): ?>
                        <li class="user_follower"><a data-toggle="tab" data-target="#user_follower" href="javascript:void(0)">Followers</a></li>
                        <li class="user_circle"><a data-toggle="tab" data-target="#user_circle" href="javascript:void(0)">Circle</a></li>
                    <?php endif; ?>
                </ul>  

                <div class="user_content col-md-12 padding-0 tab-content">
                    <div class="user_posts_area user_details tab-pane fade in active" id="user_posts">
                        <input type="hidden" value="0" class="user_post_page_number">
                        <div class="user_posts_container"></div>
                        <h2 class="result_text"></h2>                
                        <div class="loading text-center">
                            <div class="cs-loader">
                                <div class="cs-loader-inner">
                                    <label>	●</label>
                                    <label>	●</label>
                                    <label>	●</label>
                                    <label>	●</label>
                                    <label>	●</label>
                                    <label>	●</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="user_info_container user_details tab-pane fade bg-white" id="user_info">

                        <div>	<?php osc_current_web_theme_path('user_info.php') ?> </div>
                    </div>
                    <div class="user_watchlist_container user_details tab-pane fade bg-white" id="user_watchlist">
                        <?php osc_current_web_theme_path('user_watchlist.php') ?> 
                    </div>
                    <?php if (osc_user_id() == osc_logged_user_id()): ?>

                        <div class="user_follower_container user_details tab-pane fade" id="user_follower">

                            <div class="row margin-0">
                                <!--                            <div class="alert alert-warning alert-dismissible fade in alert-custom" role="alert">
                                                                <div class="col-md-12">
                                
                                                                    <div class="col-md-1 padding-0">
                                                                        <i class="fa fa-users fa-2x" aria-hidden="true" style="padding-top: 15px"></i>
                                                                    </div>  
                                                                    <div class="col-md-10">
                                                                        <strong>Holy guacamole!</strong> You should check in on some of those fields below.You should check in on some of those fields below. You should check in on<span class="bold" style="color:#000;"> some of those fields below.</span>
                                                                    </div>
                                                                    <div class="col-md-1 padding-0">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                
                                                                </div>
                                                                <div class="clear"></div>
                                
                                                            </div>-->
                                <div class="col-md-12 padding-0 search-box success-border">
                                    <div class="col-md-offset-1 col-md-10">
                                        <div class="input-text-area margin-top-20 left-border-30 box-shadow-none">
                                            <div class="col-md-10  margin-bottom-20">
                                                <input type="text" class="bold follower_search_text search_text" placeholder="Qui recherchez vous dans le cercle?">
                                            </div>
                                            <div class="follower-search-button search-button col-md-1">
                                                <button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="user_follower_box"></div>

                            </div>

                        </div>
                        <div class="user_circle_container user_details tab-pane fade" id="user_circle">
                            <div class="row margin-0">
                                <!--                            <div class="alert alert-warning alert-dismissible fade in alert-custom" role="alert">
                                                                <div class="col-md-12">
                                
                                                                    <div class="col-md-1 padding-0">
                                                                        <i class="fa fa-users fa-2x" aria-hidden="true" style="padding-top: 15px"></i>
                                                                    </div>  
                                                                    <div class="col-md-10">
                                                                        <strong>Holy guacamole!</strong> You should check in on some of those fields below.You should check in on some of those fields below. You should check in on<span class="bold" style="color:#000;"> some of those fields below.</span>
                                                                    </div>
                                                                    <div class="col-md-1 padding-0">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                
                                                                </div>
                                                                <div class="clear"></div>
                                
                                                            </div>-->
                                <div class="col-md-12 padding-0 search-box success-border">
                                    <div class="col-md-offset-1 col-md-10">
                                        <div class="input-text-area margin-top-20 left-border-30 box-shadow-none">
                                            <div class="col-md-10  margin-bottom-20">
                                                <input type="text" class="bold circle_search_text search_text" placeholder="Qui recherchez vous dans le cercle?">
                                            </div>
                                            <div class="circle-search-button search-button col-md-1">
                                                <button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="user_circle_box"></div>

                            </div>
                        </div>

                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="popup"></div>
<?php
osc_add_hook('footer', 'custom_script');

function custom_script() {
    ?>
    <script src="<?php echo osc_current_web_theme_js_url('jquery.form.js') ?>"></script>
    <script>
        var user_id = '<?php echo osc_user_id() ?>'
        var is_enable_ajax = true;
        var loading = false;
        var location_type = $('.filter_city').attr('data_location_type');
        var location_id = $('.filter_city').attr('data_location_id');
        var category_id = $('#sCategory').val();
        var post_type = $('.post_type_filter').val();
        jQuery(document).ready(function ($) {
            fetch_user_posts();

            $(document).on('click', '.user_profile_navigation .user_follower', function () {
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url() . 'user_follower.php' ?>",
                    data: {
                        user_id: user_id,
                    },
                    success: function (data) {
                        $('.user_follower_container .user_follower_box').html(data);
                    }
                });
            });

            $(document).on('click', '.user_follower_container .follower-search-button', function () {
                var search_name = $('.follower_search_text').val();
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url() . 'user_follower.php' ?>",
                    data: {
                        user_id: user_id,
                        search_name: search_name
                    },
                    success: function (data) {
                        $('.user_follower_container .user_follower_box').html(data);
                    }
                });
            });

            $(document).on('click', '.user_profile_navigation .user_circle', function () {
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url() . 'user_circle.php' ?>",
                    data: {
                        user_id: user_id,
                    },
                    success: function (data) {
                        $('.user_circle_container .user_circle_box').html(data);
                    }
                });

            });

            $(document).on('change', '.user_profile_img', function (event) {
                var options = {
                    url: '<?php echo osc_current_web_theme_url('user_image_change.php'); ?>',
                    type: 'post',
                    data: {
                        type: 'profile_image',
                    },
                    success: function (html, statusText, xhr, $form) {
                        $('.widget-user-image .img-circle').attr('src', html);
                    },
                };
                $('.file_upload').ajaxForm(options).submit();
            });

            $(document).on('change', '.user_cover_img', function (event) {
                var options = {
                    url: '<?php echo osc_current_web_theme_url('user_image_change.php'); ?>',
                    type: 'post',
                    data: {
                        type: 'cover_image',
                    },
                    success: function (html, statusText, xhr, $form) {
                        $('.widget-user-header').css({'background-image': ''});
                        $('.widget-user-header').css({'background-image': 'url(' + html + ')'});
                    },
                };
                $('.cover_image_upload').ajaxForm(options).submit();
            });

            $(document).on('click', '.user_circle_container .circle-search-button', function () {
                var search_name = $('.circle_search_text').val();
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url() . 'user_circle.php' ?>",
                    data: {
                        user_id: user_id,
                        search_name: search_name
                    },
                    success: function (data) {
                        $('.user_circle_container .user_circle_box').html(data);
                    }
                });
            });


            $(window).bind('scroll', function () {
                if (is_enable_ajax && !loading && $(window).scrollTop() >= ($('.user_posts_container').offset().top + $('.user_posts_container').outerHeight() - window.innerHeight)) {
                    loading = true;
                    $('.user_posts_area .loading').fadeIn(500);
                    $('.user_posts_container').css({'opacity': '0.2'});
                    setTimeout(fetch_user_posts, 1000);
                }
            });
            $('.filter-button').click(function () {
                $('.user_posts_area .loading').fadeIn(500);
                $('.user_posts_container').css({'opacity': '0.2'});
                reset_variables();
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url() . '/item_after_login_ajax.php' ?>",
                    data: {
                        user_id: user_id,
                        location_type: location_type,
                        location_id: location_id,
                        category_id: category_id,
                        post_type: post_type,
                    },
                    success: function (data) {
                        $('.user_posts_container').empty().append(data);
                        $('.user_posts_area .loading').fadeOut(1000);
                        $('.user_posts_container').css({'opacity': '1'});
                    }
                });
            });
        });
        function fetch_user_posts() {
            var page_number = $('.user_posts_area .user_post_page_number').val();
            var user_id = '<?php echo osc_user_id() ?>';
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'user_posts.php' ?>",
                data: {
                    user_id: user_id,
                    page_number: page_number,
                    location_type: location_type,
                    location_id: location_id,
                    category_id: category_id,
                    post_type: post_type,
                },
                success: function (data) {
                    $('.user_posts_area .loading').fadeOut(1000);
                    $('.user_posts_container').css({'opacity': '1'});
                    if (data !== '0') {
                        loading = false;
                        $(".user_posts_container").append(data);
                        var next_page = parseInt($('.user_posts_area .user_post_page_number').val()) + 1;
                        $('.user_posts_area .user_post_page_number').val(next_page);
                    } else {
                        $(".user_posts_area .result_text").text('No More Data Found').show();
                        is_enable_ajax = false;
                    }
                }
            });
        }
        function reset_variables() {
            is_enable_ajax = true;
            loading = false;
            if (!$('.filter_city').val()) {
                $('.filter_city').attr('data_location_id', '');
            }
            location_type = $('.filter_city').attr('data_location_type');
            location_id = $('.filter_city').attr('data_location_id');
            category_id = $('#sCategory').val();
            post_type = $('.post_type_filter').val();
            $('.user_posts_area .user_post_page_number').val(0);
        }
    </script>
    <?php
}
?>

<?php osc_current_web_theme_path('footer.php'); ?>