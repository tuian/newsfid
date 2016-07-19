<?php osc_current_web_theme_path('header.php'); ?>

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
        <?php osc_slider(); ?>  
    <?php } ?>
    <div class="bigsearch transbg">
        <div class="row">
            <!-- search form --> 
        </div>

    </div>
    <!-- Big Search --> 

<?php else : ?>
    <div class="section" >
        <span class="home-slider-text"> Newsfid </span>
        <div id="cover" classe="cover home-slider-img">
            <img src="images/top.main.jpg" class="img-responsive" />
        </div>
    </div>

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
                <div class="col-md-4">
                    <div class=" bg-white col-md-12 padding-0">
                        <!--                    <div class="box box-widget widget-user">
                        
                                                <div class="widget-user-header bg-black" style="background: url('<?php echo osc_current_web_theme_url() . "/images/cover_image.jpg" ?>') center center;">
                                                    <h3 class="widget-user-username">
                        <?php echo $logged_user[0]['user_name'] ?>
                                                    </h3>
                                                    <h5 class="widget-user-desc">
                                                        Web Designer
                                                    </h5>
                                                </div>
                                                <div class="widget-user-image">
                        <?php
                        if (!empty($logged_user[0]['s_path'])):
                            $img_path = osc_base_url() . '/' . $logged_user[0]['s_path'] . $logged_user[0]['pk_i_id'] . '.' . $logged_user[0]['s_extension'];
                        else:
                            $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                        endif;
                        ?>
                        
                                                    <img class="img-circle" src="<?php echo $img_path ?>" alt=" <?php echo $logged_user[0]['user_name'] ?>">
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
                        <div class="col-md-12 margin-bottom-30">
                            <div class="col-md-3 padding-right-0">
                                <!-- /.direct-chat-info -->
                                <img class="direct-chat-img" src="<?php echo $img_path ?>" alt=" <?php echo $logged_user[0]['user_name'] ?>">
                                <img class="vertical-top" src="<?php echo osc_current_web_theme_url() . '/images/right.png' ?>" alt=" <?php echo $logged_user[0]['user_name'] ?>" width="16px" height="16px">
                            </div>
                            <div class="col-md-9 padding-right-0">
                                <h4 class="direct-chat-name  margin-0">Gemma Morris</h4>                                
                                <span class=""><i class="fa fa-users"></i> 25,2k</span>                                                            

                                <button type="submit" class="btn btn-box-tool frnd-sug-button pull-right" data-toggle="tooltip" title="Subscribe">M'abonner</button>                                                           
                            </div>
                        </div>
                        <div class="col-md-12 margin-bottom-30">
                            <div class="col-md-3 padding-right-0">
                                <!-- /.direct-chat-info -->
                                <img class="direct-chat-img" src="<?php echo $img_path ?>" alt=" <?php echo $logged_user[0]['user_name'] ?>">
                                <img class="vertical-top" src="<?php echo osc_current_web_theme_url() . '/images/star.png' ?>" alt=" <?php echo $logged_user[0]['user_name'] ?>" width="16px" height="16px">
                            </div>
                            <div class="col-md-9 padding-right-0">
                                <h4 class="direct-chat-name  margin-0">Gemma Morris</h4>                                
                                <span class=""><i class="fa fa-users"></i> 25,2k</span>                                                            

                                <button type="submit" class="btn btn-box-tool frnd-sug-button pull-right" data-toggle="tooltip" title="Subscribe">M'abonner</button>                                                           
                            </div>
                        </div>

                        <div class="col-md-12 margin-bottom-30">
                            <div class="col-md-3">                            
                                <img class="direct-chat-img" src="<?php echo $img_path ?>" alt=" <?php echo $logged_user[0]['s_username'] ?>">                            
                            </div>
                            <div class="col-md-9 padding-right-0">
                                <h4 class="direct-chat-name margin-0">Gemma Morris</h4>                                
                                <span class=""><i class="fa fa-users"></i> 25,2k</span>   
                                <button type="submit" class="btn btn-box-tool frnd-sug-button pull-right" data-toggle="tooltip" title="Subscribe">M'abonner</button>                                                           
                            </div>
                        </div>


                    </div>
                </div>

                <div class="col-md-8 padding-left-0">

                    <!--                    <div class="col-md-4 pull-right">
                                            <div class="country_flag_box vertical_center pull-right">
                                                <li>
                    <?php echo 'Flux' ?>
                                                </li>
                                                <li>
                                                    <img src=<?php echo osc_current_web_theme_url() . "images/flags/us.png" ?> width="50px" height="20px">
                                                </li>
                                                <li>
                    <?php $counrty_array = get_country_array(); ?>
                                                    <select id="country-list">
                    <?php
                    foreach ($counrty_array as $countryList):
                        ?>
                                                                                <option  value="<?php echo $countryList['s_name']; ?>">  <?php echo $countryList['s_name']; ?> </option>
                        <?php
                    endforeach;
                    ?>
                                                    </select>
                                                </li>
                                                <li>                                
                                                    <img class="dot_image" src="<?php echo osc_current_web_theme_url() . 'images/dots.png' ?>">
                                                    <i class="fa fa-ellipsis-v fa-2x"></i>
                                                </li>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                    
                                        <div class="col-md-8 pull-right">
                                            <div class="location_filter_container pull-right">
                                                <ul class="nav">
                                                    <li class="location_filter_tab"><a href="#tab_1">WORLD</a></li>
                                                    <li class="location_filter_tab" data_location_type="country" data_location_id="<?php echo $logged_user[0]['fk_c_country_code'] ?>"><a href="#tab_2">NATIONAL</a></li>
                                                    <li class="active location_filter_tab" data_location_type="city" data_location_id="<?php echo $logged_user[0]['fk_i_city_id'] ?>"><a href="#tab_3">LOCAL</a></li>
                                                </ul>                            
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>-->
                    <div class="posts_container">
                        <input type="hidden" name="item_page_number" id="item_page_number" value="1">
                        <div class="user_related_posts">

                        </div>
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
                        <ul class="nav navbar-nav">
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
                                        <li class="<?php echo osc_category_slug(); ?>" value="<?php echo osc_category_name() ?>">
                                            <a class="category" data-val="<?php echo osc_category_id() ?>" href="<?php echo osc_search_category_url(); ?>">
                                                <?php echo osc_category_name(); ?>
                                                <span>(<?php echo osc_category_total_items(); ?>)</span>
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
                            <li class="show-more-li"><a href="#"><?php echo __('Show more') . "&nbsp;&nbsp;&nbsp;"; ?><i class="fa fa-angle-down vertical-bottom"></i></a>
                                <ul class="">
                                    <?php foreach ($other_cat as $$k => $n): ?>
                                        <li class="<?php echo $n['slug']; ?>" value="<?php echo $n['name']; ?>">
                                            <a class="category" data-val="<?php echo $n['id']; ?>" href="<?php echo $n['href']; ?>">
                                                <?php echo $n['name']; ?><span>(<?php echo $n['count']; ?>)</span>
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
    <div id="cover" classe="cover" style=" 
         margin:0;
         padding:0; no-repeat center fixed; 
         -webkit-background-size: cover; /* pour anciens Chrome et Safari */
         background-size: cover; /* version standardisée */
         background-color: black;
         max-height: 400px;
         overflow: hidden; 
         ">


        <img src="images/bottom.main.jpg" class="img-responsive" />


    <?php endif; ?>
    <!-- bottom background -->

    <?php if (osc_get_preference('position2_enable', 'flatter_theme') != '0') { ?>
        <div id="position_widget" class="greybg<?php
        if (osc_get_preference('position1_hide', 'flatter_theme') != '0') {
            echo" hidden-xs";
        }
        ?>">
            <div class="container">
                <div class="dd-widget position_2">
                    <?php echo osc_get_preference('position2_content', 'flatter_theme'); ?>
                </div>
            </div>
        </div>
        <!-- Homepage widget 2 -->
    <?php } ?>
</div>
<?php if (!osc_is_web_user_logged_in()) : ?>
    <div class="section">
        <div class="postadspace">
            <div class="container">
                <?php if (osc_users_enabled() || (!osc_users_enabled() && !osc_reg_user_post() )) : ?>
                    <center> <h50 style=" margin:0 0 10px 0; font-weight:600; font-size: 32px; color: black;">  Join us for free now  </h50></center> <br>
                    <a class="btn btn-sclr btn-lg" href=" <?php echo osc_register_account_url(); ?>"><?php _e(" Sign up for free ", 'flatter'); ?></a>                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

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
                                    var location_type = $('.nav-tabs-theme li.active').attr('data_location_type');
                                    var location_id = $('.nav-tabs-theme li.active').attr('data_location_id');
                                    $(document).ready(function () {

                                        $('.select2').each(function () {
                                            var placeholder = $(this).attr('title');
                                            $(this).select2({
                                                placeholder: 'placeholder'
                                            });
                                        });
    <?php if (!osc_is_web_user_logged_in()): ?>
                                            $('.masonry_row').masonry({
                                                columnWidth: '.item',
                                                itemSelector: '.item',
                                            });
                                            var targetOffset = $(".loading").offset().top + $('.masonry_row').outerHeight();
                                            $.ajax({
                                                url: "<?php echo osc_current_web_theme_url() . '/item_ajax.php' ?>",
                                                //data: {page_number: pageNumber, },
                                                success: function (data, textStatus, jqXHR) {
                                                    $('.masonry_row').html(data);
                                                }
                                            });
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
                                                        $(".result_text").hide();
                                                        $('.masonry_row').masonry('reloadItems');
                                                        $('.masonry_row').masonry('layout');
                                                        $('#page_number').val(1);
                                                    }

                                                });
                                            });

                                            $(window).bind('scroll', function () {
                                                if (is_enable_ajax && !loading && $(window).scrollTop() >= ($('.masonry_row').offset().top + $('.masonry_row').outerHeight() - window.innerHeight)) {
                                                    loading = true;
                                                    $('.loading').fadeIn(500);
                                                    $('.masonry_row').css({'opacity': '0.2'});
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

                                            $(window).bind('scroll', function () {
                                                if (is_enable_ajax && !loading && $(window).scrollTop() >= ($('.user_related_posts').offset().top + $('.user_related_posts').outerHeight() - window.innerHeight)) {
                                                    loading = true;
                                                    $('.posts_container .loading').fadeIn(500);
                                                    $('.user_related_posts').css({'opacity': '0.2'});
                                                    setTimeout(make_after_login_item_ajax_call, 1000);
                                                }
                                            });

    <?php endif; ?>

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

                                    });

                                    function make_after_login_item_ajax_call() {
                                        var page_number = $('#item_page_number').val();
                                        $.ajax({
                                            url: "<?php echo osc_current_web_theme_url() . 'item_after_login_ajax.php' ?>",
                                            data: {
                                                page_number: page_number,
                                                location_type: location_type,
                                                location_id: location_id,
                                            },
                                            success: function (data) {
                                                if (data !== '0') {
                                                    $('.posts_container .loading').fadeOut(1000);
                                                    $('.user_related_posts').css({'opacity': '1'});
                                                    loading = false;
                                                    $(".user_related_posts").append(data);
                                                    var next_page = parseInt($('#item_page_number').val()) + 1;
                                                    $('#item_page_number').val(next_page);
                                                } else {
                                                    $(".result_text").text('No More Data Found').show();
                                                    $('.posts_container .loading').fadeOut(1000);
                                                    $('.user_related_posts').css({'opacity': '1'});
                                                    is_enable_ajax = false;
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
                                                if (data !== '0') {
                                                    $(".masonry_row").append(data);
                                                    $('.loading').fadeOut(1000);
                                                    $('.masonry_row').css({'opacity': '1'});
                                                    var next_page = parseInt($('#page_number').val()) + 1;
                                                    $('#page_number').val(next_page);
                                                    loading = false;
                                                } else {
                                                    $(".result_text").text('No More Data Found').show();
                                                    $('.loading').fadeOut(1000);
                                                    $('.masonry_row').css({'opacity': '1'});
                                                    is_enable_ajax = false;
                                                    loading = false;
                                                }
                                                $('.masonry_row').masonry('reloadItems');
                                                $('.masonry_row').masonry('layout');
                                            }
                                        });
                                    }

                                    function reset_variable_after_login() {
                                        is_enable_ajax = true;
                                        loading = false;
                                        location_type = $('.nav-tabs-theme li.active').attr('data_location_type');
                                        location_id = $('.nav-tabs-theme li.active').attr('data_location_id');
                                        $('#item_page_number').val(1);
                                    }
    </script>
    <?php
}
?>

<?php osc_current_web_theme_path('locationfind.php'); ?>
<?php osc_current_web_theme_path('footer.php'); ?>