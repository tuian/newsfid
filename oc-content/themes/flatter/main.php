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
            <form action="<?php echo osc_base_url(true); ?>" method="get" class="search nocsrf">
                <input type="hidden" name="page" value="search"/>
                <div class="col-md-5 col-xs-12">
                    <input type="text" name="sPattern" id="query" value="" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'flatter_theme'), 'flatter')); ?>" />
                </div>
                <!-- Keyword -->
                <div class="col-md-3 col-xs-12">
                    <?php osc_goto_first_category(); ?>
                    <?php if (osc_count_categories()) { ?>
                        <select id="sCategory" name="sCategory">
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
                <!-- Categories -->
                <div class="col-md-3 col-xs-12">
                    <?php if (osc_get_preference('location_input', 'flatter_theme') == '1') { ?> 
                        <?php $aRegions = Region::newInstance()->listAll(); ?>
                        <?php if (count($aRegions) > 0) { ?>
                            <select name="sRegion" id="sRegion">
                                <option value=""><?php _e('Select a region', 'flatter'); ?></option>
                                <?php foreach ($aRegions as $region) { ?>
                                    <option value="<?php echo $region['s_name']; ?>"><?php echo $region['s_name']; ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                    <?php } else { ?>
                        <input name="sCity" id="sCity" placeholder="<?php _e('Type a city', 'flatter'); ?>" type="text" />
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
                <!-- Locations -->
                <div class="col-md-1 pull-right col-xs-12">
                    <button class="btn btn-sclr"><?php _e("GO", 'flatter'); ?></button>
                </div>
            </form>    
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
    $conn = DBConnectionClass::newInstance();
    $data = $conn->getOsclassDb();
    $comm = new DBCommandClass($data);
    $db_prefix = DB_TABLE_PREFIX;
    $logged_in_user_id = osc_logged_user_id();
    $query = "SELECT * FROM `{$db_prefix}t_user` user LEFT JOIN `{$db_prefix}t_user_resource` user2 ON user2.fk_i_user_id = user.pk_i_id WHERE user.pk_i_id={$logged_in_user_id}";
    $user_result = $comm->query($query);
    $logged_user = $user_result->result();
    ?>
    <div id="sections">
        <div class="user_area">
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->

                        <div class="widget-user-header bg-black" style="background: url('<?php echo osc_current_web_theme_url() . "/images/user-default.jpg" ?>') center center;">
                            <h3 class="widget-user-username">
                                <?php echo $logged_user[0]['s_username'] ?>
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

                            <img class="img-circle" src="<?php echo $img_path ?>" alt=" <?php echo $logged_user[0]['s_username'] ?>">
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            3,200
                                        </h5>
                                        <span class="description-text">
                                            SALES
                                        </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            13,000
                                        </h5>
                                        <span class="description-text">
                                            FOLLOWERS
                                        </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">35</h5>
                                        <span class="description-text">PRODUCTS</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
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
                                <option selected="selected">Alabama</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>

                <div class="col-md-8">

                    <div class="col-md-4 pull-right">
                        <div class="country_flag_box pull-right">
                            <li>
                                <?php echo 'Flux' ?>
                            </li>
                            <li>
                                <?php echo 'India' ?>
                            </li>
                            <li>                                
                                <img class="dot_image" src="<?php echo osc_current_web_theme_url() . 'images/dots.png' ?>">
                            </li>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-8 pull-right">
                        <div class="nav-tabs-theme pull-right">
                            <ul class="nav nav-tabs">
                                <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="false">WORLD</a></li>
                                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">NATIONAL</a></li>
                                <li class="active"><a href="#tab_3" data-toggle="tab" aria-expanded="true">LOCAL</a></li>
                            </ul>
                            <div class="tab-content">

                            </div>
                            <!-- /.tab-content -->
                        </div>
                    </div>



                    <div class="clearfix"></div>
                    <div class="box box-widget">
                        <div class="box-header with-border">
                            <div class="user-block">
                                <img class="img-circle" src="<?php echo osc_current_web_theme_url() . '/images/user1-128x128.jpg' ?>" alt="User Image">
                                <span class="username"><a href="<?php echo osc_user_public_profile_url('55') ?>">Jonathan Burke Jr.</a></span>
                                <span class="description">Shared publicly - 7:30 PM Today</span>
                            </div>
                            <!-- /.user-block -->
                            <div class="box-tools">
                                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                                    <i class="fa fa-circle-o"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <img class="img-responsive pad" src="<?php echo osc_current_web_theme_url() . '/images/photo2.png' ?>" alt="Photo">

                            <p>I took this photo this morning. What do you guys think?</p>
                            <?php echo '127' ?> &nbsp;
                            <a href="#"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;
                            <?php echo 'Like' ?>
                            &nbsp;&nbsp;
                            <?php echo '' ?> &nbsp;
                            <a href="#"><i class="fa fa-retweet"></i></a>&nbsp;
                            <?php echo 'Share' ?>

                            &nbsp;&nbsp;
                            <?php echo '' ?> &nbsp;
                            <a href="#"><i class="fa fa-comments"></i></a>&nbsp;
                            <?php echo 'Comment' ?>

                            &nbsp;&nbsp;
                            <a href="#"><?php echo 'Tchat' ?></a>&nbsp;
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer box-comments">
                            <div class="box-comment">
                                <!-- User image -->
                                <img class="img-circle img-sm" src="<?php echo osc_current_web_theme_url() . '/images/user3-128x128.jpg' ?>" alt="User Image">

                                <div class="comment-text">
                                    <span class="username">
                                        Maria Gonzales
                                        <span class="text-muted pull-right">8:03 PM Today</span>
                                    </span><!-- /.username -->
                                    It is a long established fact that a reader will be distracted
                                    by the readable content of a page when looking at its layout.
                                </div>
                                <!-- /.comment-text -->
                            </div>
                            <!-- /.box-comment -->
                            <div class="box-comment">
                                <!-- User image -->
                                <img class="img-circle img-sm" src="<?php echo osc_current_web_theme_url() . '/images/user4-128x128.jpg' ?>" alt="User Image">

                                <div class="comment-text">
                                    <span class="username">
                                        Luna Stark
                                        <span class="text-muted pull-right">8:03 PM Today</span>
                                    </span><!-- /.username -->
                                    It is a long established fact that a reader will be distracted
                                    by the readable content of a page when looking at its layout.
                                </div>
                                <!-- /.comment-text -->
                            </div>
                            <!-- /.box-comment -->
                        </div>
                        <!-- /.box-footer -->
                        <div class="box-footer">
                            <form action="#" method="post">
                                <img class="img-responsive img-circle img-sm" src="<?php echo osc_current_web_theme_url() . '/images/user4-128x128.jpg' ?>" alt="Alt Text">
                                <!-- .img-push is used to add margin to elements next to floating images -->
                                <div class="img-push">
                                    <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                                </div>
                            </form>
                        </div>
                        <!-- /.box-footer -->
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
                            if (osc_count_categories()) { ?>
                                <?php 
                                $i = 1; $j=0;
                                while (osc_has_categories()) { 
                                    if($i <6):
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
                                } ?> 
                            <?php }?>
                            <li class="show-more-li"><a href="#"><?php echo __('Show more')."&nbsp;&nbsp;&nbsp;";?><i class="fa fa-angle-down vertical-bottom"></i></a>
                                <ul class="">
                                   <?php  foreach ($other_cat as $$k => $n):?>
                                        <li class="<?php echo $n['slug'];?>" value="<?php echo $n['name'];?>">
                                            <a class="category" data-val="<?php echo $n['id'];?>" href="<?php echo $n['href'];?>">
                                                <?php echo $n['name'];?><span>(<?php echo $n['count'];?>)</span>
                                            </a>
                                        </li>
                                   <?php endforeach;?>                            
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
                    <i class="fa fa-spin fa-refresh fa-3x"></i>
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

<?php
osc_add_hook('footer', 'footer_script');

function footer_script() {
    ?>
    <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/masonry.pkgd.min.js'); ?>"></script>
    <script>
                        var pageNumber = $('#page_number').val();
                        var is_enable_ajax = true;
                        var loading = false;

                        $(document).ready(function () {

                            $('.select2').each(function () {
                                var placeholder = $(this).attr('title');
                                $(this).select2({
                                    placeholder: 'placeholder'
                                });
                            });

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
                        });
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
    </script>
    <?php
}
?>

<?php osc_current_web_theme_path('locationfind.php'); ?>
<?php osc_current_web_theme_path('footer.php'); ?>