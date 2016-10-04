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
<?php if (osc_is_web_user_logged_in()) : ?>
    <!--     bottom background 
        <div id="cover" class="cover">

    <?php // if (function_exists("osc_slider")) { ?>
    <?php // osc_slider(); ?>  
    <?php // } ?>
        </div>-->
    <?php
else: {
        
    }
    ?>
        <!--    <div id="cover" class="cover" style="background-image: url(<?php echo osc_base_url() . $post_resource_array['s_path'] . $post_resource_array['pk_i_id'] . '.' . $post_resource_array['s_extension']; ?>);background-size: cover;max-height: 500px;">
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
        $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . ' <div class="col-md-12 green padding-0 item_title_head read_more" data_item_id="' . $post_details['fk_i_item_id'] . '"> Read More </div>';
    }
    ?>  <?php echo $string;
    ?></i>
                    </div>
                </div>      
            </div>-->


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

                <span style=" ">  <?php echo __('Publish and share stories with the world', 'flatter'); ?> </span> 

                <?php if (osc_is_web_user_logged_in()) { ?>
                    <a href="https://newsfid.com/index.php?page=item&action=item_add"> <?php echo __('Share a story with us now.', 'flatter'); ?></a>  <br><br>
                <?php } else { ?>
                    <a href="<?php echo osc_register_account_url(); ?>"> <?php echo __('Or get an account for free now.', 'flatter'); ?></a>  <br><br>
                <?php } ?>                
            </div>
        </div>

    </div><!-- Section 5 -->
<?php endif; ?>
<?php if (osc_is_web_user_logged_in()): ?>
    <?php
    $logged_in_user_id = osc_logged_user_id();
    $logged_user = get_user_data($logged_in_user_id);
    ?>
    <div id="sections">
        <div class="user_area">
            <div class="row wrap">
                <div class="">
                    <div class="col-md-4 col-sm-4" id="wrap">
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
                                    <span class="bold"> Filters </span>
                                    <!-- /.box-tools -->
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body" style="display: block;">                             
                                    <select class="form-control select2 post_type_filter" style="width: 100%;" tabindex="-1" title="Podcast" aria-hidden="true">
                                        <option value="all">All</option> 
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
                                        <img src="<?php echo osc_current_web_theme_url() . "images/research-icon.png" ?>" width="20px">  Search</button> or 
                                    <button type="reset" class="btn btn-box-tool reset-button bold" data-toggle="tooltip" title="Reset">Reset</button>
                                </div>
                            </div>
                            <!-- /.box -->
                            <div id="suggested_user_div">
                                <div class="suggested_user_div">
                                    <?php
                                    $suggested_users = get_suggested_users($logged_user['user_id'], 1000);
                                    $follow_user = (array) get_user_following_data($logged_user['user_id']);
                                    $suggested_follow_users = array_diff($suggested_users, $follow_user);
                                    $follow_remove = (array) get_user_following_remove_data($logged_user['user_id']);
                                    $suggested_users_result = array_diff($suggested_follow_users, $follow_remove);
                                    $suggested_users_result = get_users_data($suggested_users_result);  
                                    if ($suggested_users_result):
                                        $i = 0;
                                        foreach ($suggested_users_result as $suggested_user_array):
                                            if (+$i > 3)
                                                break;
                                           
//                                                if ((get_user_follower_data($suggested_user_array['user_id']))): 
                                                ?>
                                                <div class="sugg_box col-md-12 col-xs-12 margin-bottom-10">
                                                    <div class="col-md-3 col-xs-2 padding-0">
                                                        <?php get_user_profile_picture($suggested_user_array['user_id']) ?>
                                                    </div>
                                                    <div class="col-md-9 col-xs-10 padding-right-0">
                                                        <h5 class="direct-chat-name  margin-0" user-data=".user-<?php echo $suggested_user_array['user_id']; ?>"><a href="<?php echo osc_user_public_profile_url($suggested_user_array['user_id']) ?>"><?php echo $suggested_user_array['user_name'] ?></a></h5>  

                                                        <span class=""><i class="fa fa-users"></i> <?php echo count(get_user_follower_data($suggested_user_array['user_id'])) ?></span>                                                            
                                                        <div class="col-md-12 padding-0">                                                           
                                                            <div class="col-md-offset-2 col-md-4 padding-0 sug_button">
                                                                <button class="follow_users" user-id="<?php echo $suggested_user_array['user_id']; ?>">Follow</button>
                                                            </div>
                                                            <div class="col-md-4 padding-left-10">         
                                                                <button class="button-gray-box follow_remove" user-id="<?php echo $suggested_user_array['user_id']; ?>">Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
                                                <?php
//                                              
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
                            </div>
                            <div class="box box-default copyright_box">
                                Copyright Newsfid - <span class="bold"> Gaël Eustache & Gwinel Madisse </span> (E&M) &copy; <?php echo date('Y') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_post">
                    <div class="col-md-8 col-sm-8 padding-left-0">
                        <div class="col-md-12 padding-0">                        
                            <ul class="nav user_profile_navigation bg-white">
                                <li class="active location_filter_tab"><a href="#tab_1"><?php _e("WORLD", 'flatter'); ?></a></li>
                                <?php if (!empty($logged_user['fk_c_country_code'])): ?>
                                    <li class="location_filter_tab" data_location_type="country" data_location_id="<?php echo $logged_user['fk_c_country_code'] ?>"><a href="#tab_2"><?php _e("NATIONAL", 'flatter'); ?></a></li>
                                <?php else: ?>
                                    <li><a data-toggle="modal" data-target="#myModal"><?php _e("NATIONAL", 'flatter'); ?></a></li>                                     
                                <?php endif; ?>
                                <?php if (!empty($logged_user['fk_i_city_id'])): ?>
                                    <li class="location_filter_tab" data_location_type="city" data_location_id="<?php echo $logged_user['fk_i_city_id'] ?>"><a href="#tab_3"><?php _e("LOCAL", 'flatter'); ?></a></li> 
                                <?php else: ?>
                                    <li><a data-toggle="modal" data-target="#myModal"><?php _e("LOCAL", 'flatter'); ?></a></li>                                
                                    <div id="myModal" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title"><?php _e("Please enter your City and Country name to use this tab", 'flatter'); ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-md-10 col-sm-10">                                                         
                                                        <input type="text" id="autocomplete_main" name="autocomplete_main" value="<?php echo osc_user_field('s_city') . " " . osc_user_field('s_country'); ?>">    
                                                    </div>
                                                    <span id="ajax_city_saved" class="hidden"><?php _e("Saved..", 'flatter'); ?></span>
                                                </div>
                                                <div class="modal-footer">                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </ul>                                                    
                        </div>                                                   
                        <div class="clearfix"></div>
                        <div class="posts_container">
                            <input type="hidden" name="item_page_number" id="item_page_number" value="1">
                            <input type="hidden" name="primium_item_id" id="primium_item_id">

                            <div class="user_related_posts"></div>
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
                                                <!--<span>(<?php //echo osc_category_total_items();                                                                       ?>)</span>-->
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
                                                <!--<span>(<?php //echo $n['count'];                                                                       ?>)</span>-->
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
                    <div class="masonry_row">
                    <?php                        
                        $language = isset($_SESSION['userLocale'])?$_SESSION['userLocale']:osc_locale_code();
                        $db_prefix = DB_TABLE_PREFIX;
                        $data = new DAO();
                        $data->dao->select('item.*, item_description.*, item_user.pk_i_id as item_user_id, item_user.has_private_post as item_user_has_private_post');
                        $data->dao->from("{$db_prefix}t_item as item");
                        $data->dao->join(sprintf('%st_user AS item_user', DB_TABLE_PREFIX), 'item_user.pk_i_id = item.fk_i_user_id', 'INNER');
                        $data->dao->join(sprintf('%st_item_description AS item_description', DB_TABLE_PREFIX), 'item.pk_i_id = item_description.fk_i_item_id', 'INNER');
                        $data->dao->orderBy('dt_pub_date', 'DESC');
                        $categories = get_category_array('1');
                        $data->dao->whereIn('fk_i_category_id', $categories);
                        $data->dao->where("item_user.has_private_post = 0 AND item_user.user_type != 0 AND item_description.fk_c_locale_code='".$language."'");

                        $page_number = isset($_REQUEST['page_number']) ? $_REQUEST['page_number'] : 0;
                        $offset = 20;
                        $start_from = $page_number * $offset;
                        $data->dao->limit($start_from, $offset);
                        //$data->dao->offset(10);
                        $result = $data->dao->get();
                        if ($result) {
                            $items = $result->result();
                        } else {
                            $items = array();
                        }                        
                        if ($items):
                            $item_result = Item::newInstance()->extendData($items);
                            $db_prefix = DB_TABLE_PREFIX;
                            ?>
                            <!--<div class="col-md-12">-->
                            <?php
                            $i = 1;
                            foreach ($item_result as $k => $item):
                                osc_query_item(array('id' => $item['pk_i_id'], 'results_per_page' => 1000));
                                while (osc_has_custom_items()):
                                    $date = osc_item_field("dt_pub_date");
                                    setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
                                    $date_in_french = time_elapsed_string(strtotime($date));
                                    $user_id = osc_item_user_id();
                                    $item_id = osc_item_id();
                                    $user = get_user_data($user_id);
                                    if (!empty($user['s_path'])):
                                        $user_image_url = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . "_nav." . $user['s_extension'];
                                    else:
                                        $user_image_url = osc_current_web_theme_url('images/user_icon.jpg');
                                    endif;
                                    if (osc_count_item_resources()) { //item without media should not allow
                                        ?>
                                        <!--<div class="item1 wow animated col-md-4 col-sm-4 col-lg-4">-->
                                        <div class="item animated col-md-4 col-sm-4 col-lg-4 padding-lr-5">
                                            <div class="list">
                                                <?php if (osc_images_enabled_at_items()) { ?>
                                                    <div class="image">
                                                        <div>
                                                            <?php if (osc_count_item_resources()) { ?>
                                                                <a href="javascript:void(0)" class="item_title_head" data_item_id="<?php echo osc_item_id(); ?>">
                                                                    <?php item_resources(osc_item_id()) ?>
                                                                </a>
                                                            <?php } else { ?>
                                                                <a href="<?php echo osc_item_url(); ?>">
                                                                    <img src="<?php echo osc_current_web_theme_url('images/no-image.jpg'); ?>" alt="<?php echo osc_item_title(); ?>" class="img-responsive item_image">
                                                                </a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="description" >
                                                    <div class="col-md-9 padding-top-10">
                                                        <img src="<?php echo $user_image_url; ?>" alt="<?php echo isset($user['user_name']) ? $user['user_name'] : 'user icon'; ?>" class="col-md-3 padding-0 img-responsive item_image user_thumbnail">
                                                        <h3 class="item_title col-md-9">
                                                            <a class="item_title_head" data_item_id="<?php echo osc_item_id(); ?>" href="javascript:void(0)">
                                                                <?php echo isset($user['user_name']) ? $user['user_name'] : osc_item_title(); ?>
                                                                <?php //echo osc_item_title();      ?>
                                                            </a>
                                                        </h3>
                                                        <span class="item_time col-md-9 padding-left-10"><?php echo $date_in_french; ?></span>                            
                                                    </div>

                                                    <div class="col-md-12">
                                                        <p class="item_description">
                                                            <?php echo osc_highlight(strip_tags($item['s_description']), 120); ?>
                                                        </p>                            
                                                    </div>
                                                    <div class="col-md-12 padding-bottom-10">
                                                        <div class="item_counts">
                                                            <div class="col-md-6 padding-0">

                                                                <?php
                                                                $like_count = get_item_likes_count(osc_item_id());
                                                                if ($like_count > 0):
                                                                    ?>
                                                                    <span class="item_view_count padding-right-10">
                                                                        <?php echo $like_count; ?>
                                                                        <i class="fa fa-thumbs-o-up"></i> 
                                                                    </span>
                                                                    <?php
                                                                endif;
                                                                $share_count = get_item_shares_count(osc_item_id());
                                                                if ($share_count > 0):
                                                                    ?>
                                                                    <span class="item_view_count padding-right-10">
                                                                        <?php echo $share_count; ?>
                                                                        <i class="fa fa-retweet"></i> 
                                                                    </span>
                                                                    <?php
                                                                endif;
                                                                $comment_count = get_comment_count(osc_item_id());
                                                                if ($comment_count > 0):
                                                                    ?>                                                                                                                           
                                                                    <span class="comment_text padding-right-10">
                                                                        <i class="fa fa-comments"></i>
                                                                        <?php echo $comment_count; ?>
                                                                    </span>
                                                                    <?php
                                                                endif;
                                                                $watchlist_count = get_item_watchlist_count(osc_item_id());
                                                                if ($watchlist_count > 0):
                                                                    ?>
                                                                    <span class="item_favourite_count">
                                                                        <i class="fa fa-heart"></i> <?php echo $watchlist_count ?>
                                                                    </span>
                                                                    <?php
                                                                endif;
                                                                ?>
                                                            </div>  
                                                            <div class="col-md-6 blue_text text-right pull-right pointer item_cat" cat-id="<?php echo osc_item_category_id(); ?>">
                                                                <?php echo osc_item_category(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-9 col-sm-9 col-xs-9">
                                                            <?php if (osc_price_enabled_at_items()) { ?>
                                                                <span class="price sclr">
                                                                    <?php echo osc_format_price(osc_item_price()); ?>
                                                                </span>
                                                            <?php } ?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                endwhile;
                                //        if($i%3 == 0):
                                //            echo "</div><div class='col-md-12'>";
                                //        endif;
                                //        if($i%75 == 0):
                                //            echo "</div><div class='load-more-content'></div><div class='col-md-12'>";
                                //        endif;
                                $i++;
                            endforeach;
                            //    echo "</div>"; 
                            ?>
                            <?php
                        //elseif($page_number > 0):
                        //    echo '<h2 class="result_text">No More Data Found</h2> ';
                        else:
                            echo '<div class="usepost_no_record"><h2 class="result_text">'.__("Nothing to show off for now.", 'flatter').'</h2>'.__('Thanks to try later').'</div>';                           
                        endif;
                        ?>
                    </div>
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
    <?php if (osc_is_web_user_logged_in()): ?>
        <script>
            $('#autocomplete_main').typeahead({
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
                                city_name:data.city_name,
                                region_id: data.r_id,
                                region_name:data.region_name,
                                country_code: data.country_code,
                                country_name:data.country_name,
                                name: data.city_name + '-' + data.region_name + '-' + data.country_name,
                            };
                            $items.push(group);
                        });                        
                        process($items);
                    }
                });
            },
            updater:function (data) {
                var new_text = data.name; 
                $('#ajax_city_saved').removeClass('hidden');
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
                    type: 'POST',
                    data: {
                        action: 'user_localisation',                     
                        city: data.city_name,
                        country: data.country_name,
                        scountry: data.country_code,
                        region_code: data.region_id,
                        region_name: data.region_name,
                    },
                    dataType: "json", 
                    success: function (data, textStatus, jqXHR) {
                        $('#autocomplete_main').val(new_text);
                        location.reload();                      
                    }
                });           
            }
        });
        </script>
    <?php endif; ?>
    <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/masonry.pkgd.min.js'); ?>"></script>
    <script>

        $(document).on('click', '.follow_remove', function () {
            var user_id = $(this).attr('user-id');
            $(this).closest('.sugg_box').hide('slow');
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('unfollow_and_add_circle.php') ?>",
                type: "POST",
                data: {
                    follow_remove: 'follow-remove',
                    follow_user_id: user_id,
                },
                success: function (data) {
                    $('#suggested_user_div').html(data);
                }
            });
        });
        $(document).on('click', '.follow_users', function () {
            var user_id = $(this).attr('user-id');
            $(this).closest('.sugg_box').hide('slow');
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('unfollow_and_add_circle.php') ?>",
                type: "POST",
                data: {
                    follow: 'follow-user',
                    follow_user_id: user_id,
                },
                success: function (data) {
                    $('#suggested_user_div').html(data);
                }
            });
        });
        var pageNumber = $('#page_number').val();
        var is_enable_ajax = true;
        var loading = false;
        var location_type = $('.filter_city').attr('data_location_type') || $('.filter_region').attr('data_location_type') || $('.filter_country').attr('data_location_type');
        var location_id = $('.filter_city').attr('data_location_id') || $('.filter_region').attr('data_location_id') || $('.filter_country').attr('data_location_id');
        var category_id = $('#sCategory').val();
        var post_type = $('.post_type_filter').val();
        $(document).ready(function () {
            $(window).scroll(function (event) {
                var scroll = $(window).scrollTop();
                if (scroll > 650) {
                    $('#home_primary_nav_wrap').addClass("all_news_nav_fix");
                } else {
                    $('#home_primary_nav_wrap').removeClass("all_news_nav_fix");
                }

            });

    <?php if (osc_is_web_user_logged_in()): ?>


                $(window).scroll(function (event) {
                    var screen = $(window).height();
                    var scroll = $(window).scrollTop();
                    if (screen > 1000) {
                        var fix = 1100;
                    }
                    else if (screen > 900) {
                        var fix = 870;
                    }
                    else if (screen > 800) {
                        var fix = 800;
                    }
                    else if (screen > 700) {
                        var fix = 700;
                    }
                    else if (screen > 600) {
                        var fix = 530;
                    }
                    else if (screen > 500) {
                        var fix = 450;
                    }
                    else if (screen > 400) {
                        var fix = 500;
                    }
                    else if (screen > 300) {
                        var fix = 450;
                    }
                    if (scroll > 0) {
                        $('#wrap').addClass("box_fix_main");
                        $('.box_post').addClass("box_post_main");
                        $('.user_profile_navigation').addClass("fix_nav");

                    } else {
                        $('#wrap').removeClass("box_fix_main");
                        $('.box_post').removeClass("box_post_main");
                        $('.user_profile_navigation').removeClass("fix_nav");
                    }

                });
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
                // init Masonry
                var $grid = $('.masonry_row').masonry({
                    columnWidth: '.item',
                    itemSelector: '.item',
                });
                // layout Masonry after each image loads
                $grid.imagesLoaded().progress(function () {
                    $grid.masonry('layout');
                });
                $('#filter_value').val('1');
                $('#search_form a').click(function (e) {
                    $('.result_message').html(''); // make blank previous error message
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
                            $grid.imagesLoaded().progress(function () {
                                $grid.masonry('layout');
                            });
                            $('#page_number').val(1);

                        }

                    });
                });
                $('#search_form li').click(function (e) {
                    $(this).addClass('active');
                });
                $(window).on("scroll", function () {
                    var scrollHeight = $(document).height();
                    var scrollPosition = $(window).height() + $(window).scrollTop();
                    if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
                        setTimeout(make_item_ajax_call, 1000);
                    }
                });

                $(document).on('click', '.item_cat', function () {
                    var cat_id = $(this).attr('cat-id');
                    $.ajax({
                        url: "<?php echo osc_current_web_theme_url('item_filter.php') ?>",
                        type: "POST",
                        data: {
                            cat_id: cat_id
                        },
                        success: function (data) {
                            $('.masonry_row').html(data);
                            $('html,body').animate({
                                scrollTop: 600
                            }, 1000);
                            $('.masonry_row').masonry('reloadItems');
                            $grid.imagesLoaded().progress(function () {
                                $grid.masonry('layout');
                            });
                        }
                    });
                });
    <?php else: ?>
                var item_page_number = $('#item_page_number').val();
                var location_type = $('.location_filter_tab.active').attr('data_location_type');
                var location_id = $('.location_filter_tab.active').attr('data_location_id');
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
                    var location_type = $('.location_filter_tab.active').attr('data_location_type');
                    var location_id = $('.location_filter_tab.active').attr('data_location_id');
                    var category_id = $('#sCategory').val();
                    var post_type = $('.post_type_filter').val();
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
                    var country_id = $('#countryId').val();
                    var location_type = $('.location_filter_tab.active').attr('data_location_type');
                    var location_id = $('.location_filter_tab.active').attr('data_location_id');
                    var category_id = $('#sCategory').val();
                    var post_type = $('.post_type_filter').val();
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
                            country_id: country_id,
                            post_type: post_type
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

        //            $(window).load(function () {            
        //                $.ajax({
        //                    url: "<?php echo osc_current_web_theme_url() . '/item_ajax.php?filter_value=1' ?>",                
        //                    success: function (data, textStatus, jqXHR) {
        //                        $('.masonry_row').append(data);
        //                        $('.masonry_row').masonry({
        //                            columnWidth: '.item',
        //                            itemSelector: '.item',
        //                        });
        //                        $('.masonry_row').masonry('layout');
        //                        $('.masonry_row').masonry('reloadItems');
        //                    }
        //                });
        //            });

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
            var $grid = $('.masonry_row').masonry({
                columnWidth: '.item',
                itemSelector: '.item',
            });
            $('.loading').fadeIn(500);
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'item_ajax.php' ?>",
                data: {
                    page_number: page_number,
                    filter_value: filter_value,
                },
                success: function (data) {
                    $('.loading').fadeOut(1000);
                    if (data.indexOf("Nothing to show") >= 0) {
                        if (page_number === 1) {
                            $('.result_message').html('<h2 class="result_text"><?php _e("Ends of results", 'flatter'); ?></h2>');
                        } else if ($('.result_text').size() < 1) {
                            $('.result_message').html(data);
                        }
                    }
                    else {
                        $(".masonry_row").append(data);
                        var next_page = parseInt($('#page_number').val()) + 1;
                        $('#page_number').val(next_page);
                        loading = false;
                        $grid.imagesLoaded().progress(function () {
                            $grid.masonry('layout');
                        });
                        $('.masonry_row').masonry('reloadItems');
                    }
                }
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

<?php //osc_current_web_theme_path('locationfind.php');  ?>
<?php osc_current_web_theme_path('footer.php'); ?>