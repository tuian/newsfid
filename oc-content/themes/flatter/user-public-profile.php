<?php
// meta tag robots
osc_add_hook('header', 'flatter_follow_construct');

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

<DIV id="cover" classe="cover" style=" 
     margin:0;
     padding:0; no-repeat center fixed; 
     -webkit-background-size: cover; /* pour anciens Chrome et Safari */
     background-size: cover; /* version standardisée */
     background-color: black;
     max-height: 580px;
     overflow: hidden; 
     ">

    <?php if (function_exists("profile_picture_show")) { ?>
        <?php profile_picture_show(); ?>

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
                    <div class="box box-widget widget-user">
                        <div class="widget-user-header bg-black" style="background: url('<?php echo osc_current_web_theme_url() . "/images/cover_image.jpg" ?>') center center;">
                            <h3 class="widget-user-username">
                                <?php echo $user[0]['user_name'] ?>
                            </h3>
                            <h5 class="widget-user-desc">
                                Web Designer
                            </h5>
                        </div>
                        <div class="widget-user-image">
                            <?php
                            if (!empty($user[0]['s_path'])):
                                $img_path = osc_base_url() . '/' . $user[0]['s_path'] . $user[0]['pk_i_id'] . '.' . $user[0]['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>

                            <img class="img-circle" src="<?php echo $img_path ?>" alt=" <?php echo $user[0]['user_name'] ?>">
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            <?php
                                            $user_following = get_user_following_data($user[0]['user_id']);
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
                                            $user_followers = get_user_follower_data($user[0]['user_id']);
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
                                            $user_likes = get_user_item_likes($user[0]['user_id']);
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
                            <input type='text' placeholder="What are you looking for?">

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" style="display: block;">                             
                            <select class="form-control select2" style="width: 100%;" tabindex="-1" title="Podcast" aria-hidden="true">
                                <option>Podcast</option>                                
                                <option>Podcast1</option>                                
                                <option>Podcast2</option>                                
                                <option>Podcast3</option>                                
                                <option>Podcast4</option>                                
                                <option>Podcast5</option>                                
                            </select>
                        </div>                       
                        <div class="box-body" style="display: block;">
                            <?php osc_goto_first_category(); ?>
                            <?php if (osc_count_categories()) { ?>
                                <select id="sCategory" class="form-control" name="sCategory">
                                    <option value=""><?php _e('Select a category', 'flatter'); ?></option>
                                    <?php while (osc_has_categories()) { ?>
                                        <option class="maincat" value="<?php echo osc_category_id(); ?>"><?php echo osc_category_name(); ?></option>
                                        <?php if (osc_count_subcategories()) { ?>
                                            <?php while (osc_has_subcategories()) { ?>
                                                <option class="subcat" value="<?php echo osc_category_id(); ?>"><?php echo osc_category_name(); ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            <?php } ?>

                        </div>

                        <div class="box-body" style="display: block;">
                            <?php if (osc_get_preference('location_input', 'flatter_theme') == '1') { ?> 
                                <?php $aRegions = Region::newInstance()->listAll(); ?>
                                <?php if (count($aRegions) > 0) { ?>
                                    <select name="sRegion"  class="form-control" id="sRegion">
                                        <option value=""><?php _e('Select a region', 'flatter'); ?></option>
                                        <?php foreach ($aRegions as $region) { ?>
                                            <option value="<?php echo $region['s_name']; ?>"><?php echo $region['s_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                            <?php } else { ?>
                                <input name="sCity" id="sCity" class="form-control" placeholder="<?php _e('Type a city', 'flatter'); ?>" type="text" />
                                <input name="sRegion" id="sRegion" type="hidden" />
                                <script type="text/javascript">
                                    $(function () {
                                        function log(message) {
                                            $("<div/>").text(message).prependTo("#log");
                                            $("#log").attr("scrollTop", 0);
                                        }

                                        $("#sCity").autocomplete({
                                            source: "<?php echo osc_base_url(true); ?>?page=ajax&action=location",
                                            minLength: 2,
                                            select: function (event, ui) {
                                                $("#sRegion").attr("value", ui.item.region);
                                                log(ui.item ?
                                                        "<?php _e('Selected', 'flatter'); ?>: " + ui.item.value + " aka " + ui.item.id :
                                                        "<?php _e('Nothing selected, input was', 'flatter'); ?> " + this.value);
                                            }
                                        });
                                    });
                                </script>
                            <?php } ?>
                        </div>
                        <div class="box-body" style="display: block;">                            
                            <button type="submit" class="btn btn-box-tool filter-button" data-toggle="tooltip" title="Apply">Apply</button>
                        </div>
                    </div>
                    <!-- /.box -->                   
                </div>
            </div>

            <div class="col-md-8 padding-left-0">
                <ul class="nav navbar-nav user_profile_navigation bg-white">
                    <li class="active user_posts"><a href="javascript:void(0)">Post</a></li>
                    <li class=""><a data-toggle="tab" data-target="#user_posts" href="javascript:void(0)">Infos</a></li>
                    <li class=""><a href="javascript:void(0)">Watchlist</a></li>
                    <li class=""><a href="javascript:void(0)">Followers</a></li>
                    <li class=""><a href="javascript:void(0)">Circle</a></li>
                </ul>  

                <div class="user_content col-md-12 padding-0">
                    <div class="user_posts_area">
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
                </div>

            </div>
        </div>
    </div>
</div>

<?php
osc_add_hook('footer', 'custom_script');

function custom_script() {
    ?>
    <script>
        var is_enable_ajax = true;
        var loading = false;
        jQuery(document).ready(function ($) {
            $(document).on('click', '.user_profile_navigation a', function () {
                $('.user_profile_navigation li').removeClass('active');
                $(this).parent().addClass('active');
            });

            $(document).on('click', '.user_posts', function () {
                var user_id = '<?php echo osc_user_id() ?>';
    //                $.ajax({
    //                    url: "<?php echo osc_current_web_theme_url() . 'item_after_login_ajax.php' ?>",
    //                    data: {
    //                        user_id: user_id,
    //                    },
    //                    success: function (data) {
    //                        $('.user_posts_container').empty().append(data);
    //                    }
    //                });
            });

            $(window).bind('scroll', function () {
                if (is_enable_ajax && !loading && $(window).scrollTop() >= ($('.user_posts_container').offset().top + $('.user_posts_container').outerHeight() - window.innerHeight)) {
                    loading = true;
                    $('.user_posts_area .loading').fadeIn(500);
                    $('.user_posts_container').css({'opacity': '0.2'});
                    setTimeout(make_after_login_item_ajax_call, 1000);
                }
            });

            $(document).on('click', '.load_more_comment', function () {
                var count = $(this).siblings('.comment_count').text();
                $(this).parent().parent().children('.load_more').toggle(500);
                if ($(this).hasClass('load_comment_text')) {
                    $(this).html('<i class="fa fa-plus-square-o"></i> Display ' + count + ' comments more ');
                    $(this).removeClass('load_comment_text');
                } else {
                    $(this).html('<i class="fa fa-minus-square-o"></i> Hide comments');
                    $(this).addClass('load_comment_text');
                }
            });

            $(document).on('submit', 'form.comment_form', function (event) {
                var comment_form = $(this);
                var item_id = comment_form.attr('data_item_id');
                var user_id = comment_form.attr('data_user_id');
                var comment_text = comment_form.find('.comment_text').val();
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url('item_comment_ajax.php') ?>",
                    type: 'POST',
                    data: {user_id: user_id, item_id: item_id, comment_text: comment_text},
                    success: function (data, textStatus, jqXHR) {
                        comment_form.find('.comment_text').val('');
                        $('.comments_container_' + item_id).replaceWith(data);
                        var current_comment_number = $('.comment_count_' + item_id).first().html();
                        $('.comment_count_' + item_id).html(parseInt(current_comment_number) + 1);
                    }
                });
                return false;
            });

            $(document).on('click', '.like_box', function () {
                var item_id = $(this).attr('data_item_id');
                var user_id = $(this).attr('data_user_id');
                var action = $(this).attr('data_action');
                $.ajax({
                    url: '<?php echo osc_current_web_theme_url() . 'item_like_ajax.php' ?>',
                    data: {
                        item_id: item_id,
                        user_id: user_id,
                        action: action
                    },
                    success: function (data, textStatus, jqXHR) {
                        $('.item_like_box' + item_id).replaceWith(data);
                    }
                });
            });

            $(document).on('click', '.follow-user', function () {
                var user_id = $(this).attr('data_current_user_id');
                var follow_user_id = $(this).attr('data_follow_user_id');
                var action = $(this).attr('data_action');
                $.ajax({
                    url: '<?php echo osc_current_web_theme_url() . 'user_follow_ajax.php' ?>',
                    data: {
                        user_id: user_id,
                        follow_user_id: follow_user_id,
                        action: action
                    },
                    success: function (data, textStatus, jqXHR) {
                        $('.follow_box_' + user_id + follow_user_id).replaceWith(data);
                    }
                });
            });

            $(document).on('click', '.share_box', function () {
                var item_id = $(this).attr('data_item_id');
                var user_id = $(this).attr('data_user_id');
                var action = $(this).attr('data_action');
                $.ajax({
                    url: '<?php echo osc_current_web_theme_url() . 'item_share_ajax.php' ?>',
                    data: {
                        item_id: item_id,
                        user_id: user_id,
                        action: action
                    },
                    success: function (data, textStatus, jqXHR) {
                        $('.item_share_box' + user_id + item_id).replaceWith(data);
                    }
                });
            });

            $(document).on('click', '.item_title_head', function () {
                var item_id = $(this).attr('data_item_id');
                $.ajax({
                    url: '<?php echo osc_current_web_theme_url() . 'popup_ajax.php' ?>',
                    data: {
                        item_id: item_id,
                    },
                    success: function (data, textStatus, jqXHR) {
                        $('.popup').empty().append(data);
                        $('#item_popup_modal').modal('show');
                    }
                });
            });
        });
        function make_after_login_item_ajax_call() {
            var page_number = $('.user_posts_area .user_post_page_number').val();
            var user_id = '<?php echo osc_user_id() ?>';
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'user_posts.php' ?>",
                data: {
                    user_id: user_id,
                    page_number: page_number,
                },
                success: function (data) {
                    if (data !== '0') {
                        $('.user_posts_area .loading').fadeOut(1000);
                        $('.user_posts_container').css({'opacity': '1'});
                        loading = false;
                        $(".user_posts_container").append(data);
                        var next_page = parseInt($('.user_posts_area .user_post_page_number').val()) + 1;
                        $('.user_posts_area .user_post_page_number').val(next_page);
                    } else {
                        $(".user_posts_area .result_text").text('No More Data Found').show();
                        $('.user_posts_area .loading').fadeOut(1000);
                        $('.user_posts_container').css({'opacity': '1'});
                        is_enable_ajax = false;
                    }
                }
            });
        }
    </script>
    <?php
}
?>

<?php osc_current_web_theme_path('footer.php'); ?>