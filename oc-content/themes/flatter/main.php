<?php
osc_current_web_theme_path('header.php');

$user_id = osc_logged_user_id();
if (isset($user_id)) {
    $user_categories = get_user_categories($user_id);
    $db_prefix = DB_TABLE_PREFIX;
    $user_last_post_data = new DAO();
    $user_last_post_data->dao->select("item.*");
    $user_last_post_data->dao->from(DB_TABLE_PREFIX . "t_item AS item");
    if (!empty($user_categories)):
        $user_last_post_data->dao->where('item.fk_i_category_id  IN (' . implode(",", $user_categories) . ")");
    endif;

    $user_last_post_data->dao->orderBy('dt_pub_date', 'DESC');
    $user_last_post_array = $user_last_post_data->dao->get();
    $post = $user_last_post_array->row();
    $post_details = array();
    if (!empty($post)) {
        $id_post = $post['pk_i_id'];
        $item_description = new DAO();
        $item_description->dao->select("item_desc.*");
        $item_description->dao->from(DB_TABLE_PREFIX . "t_item_description AS item_desc");
        $item_description->dao->where('fk_i_item_id', $id_post);
        $item_desc = $item_description->dao->get();
        $post_details = $item_desc->row(); // currently we have hide this, we will replace this with slider

        $db_prefix = DB_TABLE_PREFIX;
        $post_resource_data = new DAO();
        $post_resource_data->dao->select("item_resource.*");
        $post_resource_data->dao->from("{$db_prefix}t_item_resource AS item_resource");
        $post_resource_data->dao->where("item_resource.fk_i_item_id", $id_post);
        $post_resource_data->dao->limit(1);
        $post_resource_data_result = $post_resource_data->dao->get();
        $post_resource_array = $post_resource_data_result->row();
    }
}
?>
<?php if (osc_get_preference('pop_enable', 'flatter_theme') != '0') { ?>
    <!-- Modal -->
    <div class="modal fade" id="promo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close', 'flatter'); ?></span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo osc_get_preference('pop_heading', 'flatter_theme', "UTF-8"); ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo osc_get_preference('landing_pop', 'flatter_theme', "UTF-8"); ?>
                </div>

            </div>
        </div>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.min.js"></script>
    <script type="text/javascript">
        $(window).load(function () {
            if ($.cookie('pop') == null) {
                $('#promo').modal('show');
                $.cookie('pop', '1');
            }
        });
    </script>
    <!-- Popup -->

<?php } ?>

<!-- Big Search -->

<!-- Homepage widget 1 -->

<!-- bottom background -->

<?php if (osc_is_web_user_logged_in()) : ?>
    <?php if (function_exists("osc_slider")) { ?>
        <?php //osc_slider();  ?>  
    <?php } ?>

                                <!--    <div id="cover" class="cover" style="background-image: url(<?php echo osc_base_url() . $post_resource_array['s_path'] . $post_resource_array['pk_i_id'] . '.' . $post_resource_array['s_extension']; ?>);background-size: cover;">
                                        <div class="last-post col-md-12">
                                            <div class="col-md-8">
                                                HEADLINES
                                            </div>
                                            <div class="col-md-8">
                                                <h3 class="bold"><?php echo isset($post_details['s_title']) ? $post_details['s_title'] : ''; ?></h3>
                                            </div>
                                            <div class="col-md-8 padding-bottom-10"><i>
    <?php
    $string = strip_tags(isset($post_details['s_description']) ? $post_details['s_description'] : '');

    if (strlen($string) > 100) {

// truncate string
        $stringCut = substr($string, 0, 100);

// make sure it ends in a word so assassinate doesn't become ass...
        $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '</i> <div class="col-md-12 green padding-0 item_title_head read_more" data_item_id="' . $post_details['fk_i_item_id'] . '"> Read More </div>';
    }
    ?>  <?php echo $string;
    ?>
                                            </div>
                                        </div>      
                                    </div>-->

<?php else : ?>
    <!--    <div class="section" >
            <span class="home-slider-text"> Newsfid </span>
            <div id="cover" classe="cover home-slider-img">
                <img src="images/top.main.jpg" class="img-responsive" />
            </div>
        </div>-->

    <div class="section">
        <div class="postadspace">
            <div class="container">
                <br> 
                <h2 class="clr"><?php echo osc_get_preference("fpromo_text", "flatter_theme"); ?></h2>

                <span style=" ">  Publish and share stories with the world </span> 

                <?php if (osc_is_web_user_logged_in()) { ?>
                    <a href="https://newsfid.com/index.php?page=item&action=item_add"> Share a story with us now.</a>  <br><br>
                <?php } else { ?>
                    <a href="<?php echo osc_register_account_url(); ?>"> Or get an account for free now.</a>  <br><br>
                <?php } ?>                
            </div>
        </div>
    <?php endif; ?>
</div><!-- Section 5 -->

<?php if (osc_is_web_user_logged_in()): ?>
    <?php
    $logged_in_user_id = osc_logged_user_id();
    $logged_user = get_user_data($logged_in_user_id);
    ?>
    <div id="sections">
        <div class="user_area">
            <div class="row">
                <div class="box_fix">
                    <div class="col-md-3 col-sm-3">
                        <div class=" bg-white col-md-12 padding-0">
                            <!--                    <div class="box box-widget widget-user">
                            
                                                    <div class="widget-user-header bg-black" style="background: url('<?php echo osc_current_web_theme_url() . "/images/cover-image.png" ?>') center center;">
                                                        <h3 class="widget-user-username">
                            <?php echo $logged_user['user_name'] ?>
                                                        </h3>
                                                        <h5 class="widget-user-desc">
                                                            Web Designer
                                                        </h5>
                                                    </div>
                                                    <div class="widget-user-image">
                            <?php
                            if (!empty($logged_user['s_path'])):
                                $img_path = osc_base_url() . $logged_user['s_path'] . $logged_user['pk_i_id'] . '.' . $logged_user['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>
                            
                                                        <img class="img-circle" src="<?php echo $img_path ?>" alt=" <?php echo $logged_user['user_name'] ?>">
                                                    </div>
                                                    <div class="box-footer">
                                                        <div class="row">
                                                            <div class="col-sm-4 border-right">
                                                                <div class="description-block">
                                                                    <h5 class="description-header">
                            <?php
                            $user_following = get_user_following_data(osc_logged_user_id());
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
                            $user_followers = get_user_follower_data(osc_logged_user_id());
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
                            $user_likes = get_user_item_likes(osc_logged_user_id());
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
                                                </div>-->


                            <div class="box box-default no-border">
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
                                    <div class="category-dropdown left-border" style="display: block;">
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
                                    <div class="country-dropdown left-border" style="display: block;">
                                        <?php UserForm::country_select(array_slice(osc_get_countries(), 1, -1)); ?>                                
                                    </div>
                                </div>

                                <div class="box-body" style="display: block;">
                                    <input type="text" class="filter_city" data_location_id="" data_location_type="city" placeholder="<?php echo 'Enter city, country, state or county' ?>">
                                </div>
                                <div class="box-body" style="display: block;">                            
                                    <button type="submit" class="btn btn-box-tool filter-button" data-toggle="tooltip" title="Search">
                                        <img src=<?php echo osc_current_web_theme_url() . "images/research-icon.png" ?>>  Search</button> or 
                                    <button type="reset" class="btn btn-box-tool reset-button" data-toggle="tooltip" title="Reset">Reset</button>
                                </div>
                            </div>
                            <!-- /.box -->
                            <div class="suggested_user_div">
                                <?php
                                $suggested_users = get_suggested_users($logged_user['user_id'], 1000);
                                $follow_user = get_user_following_data($logged_user['user_id']);
                                $suggested_users_result = array_diff($suggested_users, $follow_user);
                                if ($suggested_users_result):
                                    $i=0;
                                    foreach ($suggested_users_result as $s_user):
                                        if (+$i > 5)
                                            break;
                                        $suggested_user_array = get_user_data($s_user);
                                        if (!empty($suggested_user_array)):
                                            if ((get_user_follower_data($suggested_user_array['user_id']))):
                                                ?>
                                                <div class="col-md-12 col-xs-12 margin-bottom-10">
                                                    <div class="col-md-3 col-xs-2 padding-0">
                    <?php get_user_profile_picture($suggested_user_array['user_id']) ?>
                                                    </div>
                                                    <div class="col-md-9 col-xs-10 padding-right-0">
                                                        <h4 class="direct-chat-name  margin-0"><?php echo $suggested_user_array['user_name'] ?></h4>  

                                                        <span class=""><i class="fa fa-users"></i> <?php echo count(get_user_follower_data($suggested_user_array['user_id'])) ?></span>                                                            
                                                        <?php
                                                        user_follow_btn_box($logged_user['user_id'], $suggested_user_array['user_id']);
                                                        ?>
                                                    </div>
                                                </div>    
                                                <?php
                                            endif;
                                        endif;
                                        $i++;
                                    endforeach;
                                else:
                                    ?>
                                    <div class="col-md-12 col-xs-12 margin-bottom-10">                                
                                        no
                                    </div> 
                                <?php
                                endif;
                                ?>
                            </div>
                            <div class="box box-default copyright_box">
                                Copyright Newsfid - <span class="bold"> Gaël Eustache & Gwinel Madisse </span> (E&M) &copy; <?php echo date('Y') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_post">
                    <div class="col-md-9 col-sm-9 padding-left-0">
                        <div class="col-md-12 padding-0">                        
                            <ul class="nav user_profile_navigation bg-white">
                                <li class="location_filter_tab"><a href="#tab_1">WORLD</a></li>
                                <li class="location_filter_tab" data_location_type="country" data_location_id="<?php echo $logged_user['fk_c_country_code'] ?>"><a href="#tab_2">NATIONAL</a></li>
                                <li class="active location_filter_tab" data_location_type="city" data_location_id="<?php echo $logged_user['fk_i_city_id'] ?>"><a href="#tab_3">LOCAL</a></li>
                            </ul>                                                    
                        </div>
                        <div class="clearfix"></div>
                        <div class="posts_container">
                            <input type="hidden" name="item_page_number" id="item_page_number" value="1">
                            <div class="user_related_posts">

                            </div>

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
    </div>
<?php else: ?>
    <div class="section custom_filter_navigation">
        <div class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container"> 
                <form id="search_form" method="POST">
                    <input type="hidden" name="filter_value" id="filter_value">
                    <input type="hidden" name="page_number" id="page_number" value="1">
                    <input type="hidden"  size="5" type="text" id="item_id" name="id">              
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only"><?php _e("Toggle navigation", 'flatter'); ?></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand clr" href="<?php echo osc_base_url(); ?>"></a>
                    </div>
                    <div class="navbar-collapse collapse" id="home_primary_nav_wrap">
                        <ul class="nav navbar-nav show_more_li">
                            <?php /* $themes = get_all_themes_icon();
                              foreach ($themes as $k => $theme): ?>
                              <li>
                              <a class="category" data-val="<?php echo $theme['id'] ?>" href="#"><?php echo $theme['name'] ?></a>
                              </li>
                              <?php endforeach; */ ?>
                            <?php osc_goto_first_category(); ?>
                            <?php
                            $other_cat = array();
                            if (osc_count_categories()) {
                                ?>
                                <?php
                                $i = 1;
                                $j = 0;
                                while (osc_has_categories()) {
                                    if ($i < 6):
                                        ?>
                                        <li class="<?php echo osc_category_slug(); ?> <?php echo $i == '1' ? 'active' : ''; ?>" value="<?php echo osc_category_name() ?>">
                                            <a class="category" data-val="<?php echo osc_category_id() ?>" href="<?php echo osc_search_category_url(); ?>">
                <?php echo osc_category_name(); ?>
                                                <!--<span>(<?php //echo osc_category_total_items();                               ?>)</span>-->
                                            </a>
                                        </li>
                                        <?php
                                    else:
                                        $other_cat[$j]['slug'] = osc_category_slug();
                                        $other_cat[$j]['name'] = osc_category_name();
                                        $other_cat[$j]['id'] = osc_category_id();
                                        $other_cat[$j]['href'] = osc_search_category_url();
                                        $other_cat[$j]['count'] = osc_category_total_items();
                                        $j++;
                                    endif;
                                    $i++;
                                }
                                ?> 
    <?php } ?>
                            <li class="show-more-li show_more"><?php echo __('Show more') . "&nbsp;&nbsp;&nbsp;"; ?><i class="fa fa-angle-down vertical-bottom"></i>
                                <ul class="">
    <?php foreach ($other_cat as $$k => $n): ?>
                                        <li class="<?php echo $n['slug']; ?>" value="<?php echo $n['name']; ?>">
                                            <a class="category" data-val="<?php echo $n['id']; ?>" href="<?php echo $n['href']; ?>">
        <?php echo $n['name']; ?>
                                                <!--<span>(<?php //echo $n['count'];                               ?>)</span>-->
                                            </a>
                                        </li>
    <?php endforeach; ?>                            
                                </ul>  
                            </li>
                        </ul>                                    
                    </div>
                </form>
            </div>

            <!-- Categories -->                    
            <!-- Locations -->
        </div>
    </div>   
    <div class="section all_news">
        <div class="container-fluid">
            <div class="row  effect-3">
                <div class="col-md-12">
                    <div class="masonry_row"></div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">                
                <div class="result_message"></div>
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
<?php endif; ?>
<?php /* if (!osc_is_web_user_logged_in()) : ?>
  <div class="section">
  <div class="postadspace">
  <div class="container">
  <?php if (osc_users_enabled() || (!osc_users_enabled() && !osc_reg_user_post() )) : ?>
  <center> <h50 style=" margin:0 0 10px 0; font-weight:600; font-size: 32px; color: black;">  Join us for free now  </h50></center> <br>
  <a class="btn btn-sclr btn-lg" href=" <?php echo osc_register_account_url(); ?>"><?php _e(" Sign up for free ", 'flatter'); ?></a>                <?php endif; ?>
  </div>
  </div>
  </div>
  <?php endif; */ ?>

<div class="popup"></div>

<?php
osc_add_hook('footer', 'footer_script');

function footer_script() {
    ?>
    <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/masonry.pkgd.min.js'); ?>"></script>
    <script>
        var pageNumber = $('#page_number').val();
        var is_enable_ajax = true;
        var loading = false;
        var location_type = $('.filter_city').attr('data_location_type') || $('.filter_region').attr('data_location_type') || $('.filter_country').attr('data_location_type');
        var location_id = $('.filter_city').attr('data_location_id') || $('.filter_region').attr('data_location_id') || $('.filter_country').attr('data_location_id');
        var category_id = $('#sCategory').val();
        var post_type = $('.post_type_filter').val();
        $(document).ready(function () {
    <?php if (osc_is_web_user_logged_in()): ?>
                $('.select2').each(function () {
                    var placeholder = $(this).attr('title');
                    $(this).select2({
                        placeholder: 'placeholder'
                    });
                });
                $('.filter_city').typeahead({
                    source: function (query, process) {
                        var $items = new Array;
                        $items = [""];
                        $.ajax({
                            url: "<?php echo osc_current_web_theme_url('search_city_ajax.php') ?>",
                            dataType: "json",
                            type: "POST",
                            data: {city_name: query, region_name: query, country_name: query},
                            success: function (data) {
                                $.map(data, function (data) {
                                    var group;
                                    group = {
                                        city_id: data.city_id,
                                        region_id: data.r_id,
                                        country_code: data.country_code,
                                        name: data.city_name + '-' + data.region_name + '-' + data.country_name,
                                    };
                                    $items.push(group);
                                });

                                process($items);
                            }
                        });
                    },
                    afterSelect: function (obj) {
                        console.log(obj);
                        $('.posts_container .loading').fadeIn(500);
                        $('.user_related_posts').css({'opacity': '0.2'});

                        reset_variable_after_login();
                        //make_after_login_item_ajax_call();
                        var category_id = $('#sCategory').val();
                        var post_type = $('.post_type_filter').val();
                        $.ajax({
                            type: 'post',
                            url: "<?php echo osc_current_web_theme_url() . 'item_after_login_ajax.php' ?>",
                            data: {
                                search_by: 'city',
                                city_id: obj.city_id,
                                region_id: obj.region_id,
                                country_code: obj.country_code,
                                category_id: category_id,
                                post_type: post_type,
                            },
                            success: function (data) {
                                $('.user_related_posts').empty().append(data);
                                $('.posts_container .loading').fadeOut(1000);
                                $('.user_related_posts').css({'opacity': '1'});
                            }
                        });
                    },
                    //                updater:function (item) {
                    //                    console.log(item);
                    //                },
                });
    <?php endif; ?>
    <?php if (!osc_is_web_user_logged_in()): ?>
                //                $('.masonry_row').masonry({
                //                    columnWidth: '.item',
                //                    itemSelector: '.item',
                //                });
                //                var targetOffset = $(".loading").offset().top + $('.masonry_row').outerHeight();
                //                $.ajax({
                //                    url: "<?php echo osc_current_web_theme_url() . '/item_ajax.php' ?>",
                //                    //data: {page_number: pageNumber, },
                //                    success: function (data, textStatus, jqXHR) {
                //                        $('.masonry_row').append(data);
                //                        $('.masonry_row').masonry('layout');
                //                        $('.masonry_row').masonry('reloadItems');
                //                    }
                //                });
                $('#search_form a').click(function (e) {
                    $('#search_form li').removeClass('active');
                    $(this).parent().addClass('active');
                    e.preventDefault();

                    var filter_value = $(this).attr('data-val');
                    $('#filter_value').val(filter_value);
                    $.ajax({
                        url: "<?php echo osc_current_web_theme_url() . 'item_ajax.php' ?>",
                        data: {
                            filter_value: filter_value
                        },
                        success: function (data, textStatus, jqXHR) {
                            $('.masonry_row').html(data);
                            is_enable_ajax = true;
                            //                            $(".result_text").hide();
                            $('.masonry_row').masonry('reloadItems');
                            $('.masonry_row').masonry('layout');
                            $('#page_number').val(1);

                        }

                    });
                });
                $('#search_form li').click(function (e) {
                    $(this).addClass('active');
                });
                $(window).bind('scroll', function () {
                    if (is_enable_ajax && !loading && $(window).scrollTop() >= ($('.masonry_row').offset().top + $('.masonry_row').outerHeight() - window.innerHeight)) {
                        loading = true;
                        $('.loading').fadeIn(500);
                        //                        $('.masonry_row').css({'opacity': '0.2'});
                        setTimeout(make_item_ajax_call, 1000);
                    }
                });
    <?php else: ?>
                var item_page_number = $('#item_page_number').val();
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url() . '/item_after_login_ajax.php' ?>",
                    data: {
                        location_type: location_type,
                        location_id: location_id,
                    },
                    success: function (data, textStatus, jqXHR) {
                        $('.user_related_posts').append(data);
                    }
                });
                $('.location_filter_tab').click(function () {
                    if (!$(this).hasClass('active')) {
                        $('.location_filter_tab').removeClass('active');
                        $(this).addClass('active');
                        var location_type = $('.location_filter_tab.active').attr('data_location_type');
                        var location_id = $('.location_filter_tab.active').attr('data_location_id');
                        $('.posts_container .loading').fadeIn(500);
                        $('.user_related_posts').css({'opacity': '0.2'});
                        reset_variable_after_login();
                        // make_after_login_item_ajax_call();
                        $.ajax({
                            url: "<?php echo osc_current_web_theme_url() . '/item_after_login_ajax.php' ?>",
                            data: {
                                location_type: location_type,
                                location_id: location_id,
                            },
                            success: function (data, textStatus, jqXHR) {
                                $('.user_related_posts').empty().append(data);
                                $('.posts_container .loading').fadeOut(1000);
                                $('.user_related_posts').css({'opacity': '1'});
                            }
                        });
                    }
                });
                $('#sCategory').change(function () {
                    $('.posts_container .loading').fadeIn(500);
                    $('.user_related_posts').css({'opacity': '0.2'});
                    reset_variable_after_login();
                    //make_after_login_item_ajax_call();
                    $.ajax({
                        url: "<?php echo osc_current_web_theme_url() . '/item_after_login_ajax.php' ?>",
                        data: {
                            location_type: location_type,
                            location_id: location_id,
                            category_id: category_id,
                            post_type: post_type,
                        },
                        success: function (data) {
                            $('.user_related_posts').empty().append(data);
                            $('.posts_container .loading').fadeOut(1000);
                            $('.user_related_posts').css({'opacity': '1'});
                        }
                    });
                });
                $('#countryId').change(function () {
                    $('.posts_container .loading').fadeIn(500);
                    $('.user_related_posts').css({'opacity': '0.2'});
                    var country_id = $('#countryId').val();
                    reset_variable_after_login();
                    //make_after_login_item_ajax_call();
                    $.ajax({
                        url: "<?php echo osc_current_web_theme_url() . '/item_after_login_ajax.php' ?>",
                        data: {
                            country_id: country_id,
                        },
                        success: function (data) {
                            $('.user_related_posts').empty().append(data);
                            $('.posts_container .loading').fadeOut(1000);
                            $('.user_related_posts').css({'opacity': '1'});
                        }
                    });
                });
                $('.filter-button').click(function () {
                    $('.posts_container .loading').fadeIn(500);
                    $('.user_related_posts').css({'opacity': '0.2'});
                    reset_variable_after_login();
                    //make_after_login_item_ajax_call();
                    $.ajax({
                        url: "<?php echo osc_current_web_theme_url() . '/item_after_login_ajax.php' ?>",
                        data: {
                            location_type: location_type,
                            location_id: location_id,
                            category_id: category_id,
                            post_type: post_type,
                        },
                        success: function (data) {
                            $('.user_related_posts').empty().append(data);
                            $('.posts_container .loading').fadeOut(1000);
                            $('.user_related_posts').css({'opacity': '1'});
                        }
                    });
                });
                $('.reset-button').click(function () {
                    window.location.reload();

                });
                $(window).bind('scroll', function () {
                    if (is_enable_ajax && !loading && $(window).scrollTop() >= ($('.user_related_posts').offset().top + $('.user_related_posts').outerHeight() - window.innerHeight)) {
                        loading = true;
                        $('.posts_container .loading').fadeIn(500);
                        //                        $('.user_related_posts').css({'opacity': '0.2'});
                        setTimeout(make_after_login_item_ajax_call, 1000);
                    }
                });

    <?php endif; ?>
        });

        $(window).load(function () {

            //                var targetOffset = $(".loading").offset().top + $('.masonry_row').outerHeight();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . '/item_ajax.php?filter_value=1' ?>",
                //data: {page_number: pageNumber, },
                success: function (data, textStatus, jqXHR) {
                    $('.masonry_row').append(data);
                    $('.masonry_row').masonry({
                        columnWidth: '.item',
                        itemSelector: '.item',
                    });
                    $('.masonry_row').masonry('layout');
                    $('.masonry_row').masonry('reloadItems');
                }
            });
        });

        function make_after_login_item_ajax_call() {
            var page_number = $('#item_page_number').val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'item_after_login_ajax.php' ?>",
                data: {
                    page_number: page_number,
                    location_type: location_type,
                    location_id: location_id,
                    category_id: category_id,
                    post_type: post_type,
                },
                success: function (data) {
                    $('.posts_container .loading').fadeOut(1000);
                    if ($('.result_text').size() < 1) {
                        $(".user_related_posts").append(data);
                        var next_page = parseInt($('#item_page_number').val()) + 1;
                        $('#item_page_number').val(next_page);
                    }

                }
            });
        }

        function make_item_ajax_call() {
            var filter_value = $('#filter_value').val();
            var page_number = $('#page_number').val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'item_ajax.php' ?>",
                data: {
                    page_number: page_number,
                    filter_value: filter_value,
                },
                success: function (data) {
                    $('.loading').fadeOut(1000);
                    if (data.indexOf("Nothing to show") >= 0) {
                        if (page_number == 1) {
                            $('.result_message').html('<h2 class="result_text">Ends of results</h2>');
                        } else {
                            $('.result_message').html(data);
                        }
                    }
                    else {
                        $(".masonry_row").append(data);
                        var next_page = parseInt($('#page_number').val()) + 1;
                        $('#page_number').val(next_page);
                        loading = false;
                        $('.masonry_row').masonry('layout');
                        $('.masonry_row').masonry('reloadItems');
                    }
                }
                //                    var el = $(data);
                //jQuery(".masonry_row").append(el).masonry( 'appended', el, true );
                //                    $('.masonry_row').masonry('layout');
                //                    $('.masonry_row').masonry('reloadItems');

            });
        }

        function reset_variable_after_login() {
            is_enable_ajax = true;
            loading = false;
            if (!$('.filter_city').val()) {
                $('.filter_city').attr('data_location_id', '');
            }
            location_type = $('.filter_city').attr('data_location_type');
            location_id = $('.filter_city').attr('data_location_id');
            category_id = $('#sCategory').val();
            post_type = $('.post_type_filter').val();
            $('#item_page_number').val(1);
        }

    </script>
    <?php
}
?>

<?php //osc_current_web_theme_path('locationfind.php'); ?>
<?php osc_current_web_theme_path('footer.php'); ?>