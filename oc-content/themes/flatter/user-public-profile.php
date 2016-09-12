<?php
// meta tag robots
osc_add_hook('header', 'flatter_follow_construct');
if (!osc_logged_user_id()):
    osc_add_flash_error_message('Please login to continue.');
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

<?php
$user = get_user_data(osc_user_id());
?>
<!-- profil cover -->
<?php
if ($user['cover_picture_user_id']):
    $cover_image_path = osc_base_url() . 'oc-content/plugins/profile_picture/images/profile' . $user['cover_picture_user_id'] . '.' . $user['cover_pic_ext'];
else:
    $cover_image_path = osc_current_web_theme_url() . "/images/cover-image.png";
endif;
?>

<div id="cover" class="cover">
    <div class="file_upload_cover" data-toggle="modal" data-target="#crop-cover-img">
        <span class ="icon">
            <i class="fa fa-camera"></i>
        </span>
    </div>
    <img src="<?php echo $cover_image_path; ?>" class="img img-responsive">
</div>

<!-- end profil cover -->

<div id="sections">
    <div class="user_area">

        <div class="row wrap">
            <div class="">
                <div class="col-md-4"  id="wrap">
                    <div class=" bg-white col-md-12 padding-0">
                        <?php
                        if ($user['cover_picture_user_id']):
                            $cover_image_path = osc_base_url() . 'oc-content/plugins/profile_picture/images/profile' . $user['cover_picture_user_id'] . '.' . $user['cover_pic_ext'];
                        else:
                            $cover_image_path = osc_current_web_theme_url() . "/images/cover-image.png";
                        endif;
                        ?>
                        <div class="box box-widget widget-user">
                            <div class="widget-user-header bg-black" style="background: url('<?php echo $cover_image_path ?>') center center; max-height: 500px;">
                                <h3 class="widget-user-username">
                                    <?php echo $user['user_name'] ?>
                                </h3>
                                <h5 class="widget-user-desc">
                                    <?php echo $user['role_name'] ?>
                                </h5>      
                                <?php if (osc_user_id() == osc_logged_user_id()): ?>


                                    <div id="crop-cover-img" class="modal  fade" role="dialog">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h3 class="modal-title">Upload Image</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="bbody">

                                                        <!-- upload form -->
                                                        <form id="upload_form" enctype="multipart/form-data" method="post" action="<?php echo osc_current_web_theme_url() . 'upload.php' ?>" onsubmit="return checkFormCover()">
                                                            <!-- hidden crop params -->
                                                            <input type="hidden" id="x1_cover" name="x1_cover" />
                                                            <input type="hidden" id="y1_cover" name="y1_cover" />
                                                            <input type="hidden" id="x2_cover" name="x2_cover" />
                                                            <input type="hidden" id="y2_cover" name="y2_cover" />

                                                            <h4>Step1: Please select image file</h4>
                                                            <div class="choose-file"><input type="file" name="file_cover_img" id="image_file_cover" onchange="fileSelectHandlerCover()" /></div>

                                                            <div class="error"></div>
                                                            <div id="loader-icon_cover" style="display:none;"><img src="<?php echo osc_current_web_theme_url() . '/images/loader.gif' ?>" /></div>
                                                            <div class="step2">
                                                                <h4>Step2: Please select a crop region</h4>
                                                                <img id="preview_cover" />

                                                                <div class="info">
                                                                    <input type="hidden" id="filesize_cover" name="filesize" />
                                                                    <input type="hidden" id="filetype_cover" name="filetype" />
                                                                    <input type="hidden" id="filedim_cover" name="filedim" />
                                                                    <input type="hidden" id="w_cover" name="w" />
                                                                    <input type="hidden" id="h_cover" name="h" />

                                                                </div>
                                                                <div class="col-md-offset-4 col-md-4 padding-bottom-10 padding-top-10"><input type="submit" class="btn btn-info upload_profile_img" value="Upload" /></div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    <form class="cover_image_upload" method="post" enctype="multipart/form-data">
                                                                            <span class="icon">
                                                                                <i class="fa fa-camera"></i>
                                                                            </span>
                                                                            <input type="file" name="file" class="file user_cover_img">
                                                                        </form>-->

                                <?php endif; ?>
                            </div>
                            <div class="widget-user-image">
                                <?php
                                if (!empty($user['s_path'])):
                                    $img_path = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
                                else:
                                    $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                                endif;
                                ?>
                                <?php get_user_profile_picture($user['user_id']) ?>
                                <?php if (osc_user_id() == osc_logged_user_id()): ?>
                                    <span class="profile_img_overlay">
                                        <div class="file_upload" data-toggle="modal" data-target="#crop-img">
                                            <span class ="icon">
                                                <i class="fa fa-camera"></i>
                                            </span>
                                        </div>
                                        <!-- Modal -->
                                        <div id="crop-img" class="modal fade" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h3 class="modal-title">Upload Image</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="bbody">

                                                            <!-- upload form -->
                                                            <form id="upload_form" enctype="multipart/form-data" method="post" action="<?php echo osc_current_web_theme_url() . 'upload.php' ?>" onsubmit="return checkForm()">
                                                                <!-- hidden crop params -->
                                                                <input type="hidden" id="x1" name="x" />
                                                                <input type="hidden" id="y1" name="y" />
                                                                <input type="hidden" id="x2" name="x2" />
                                                                <input type="hidden" id="y2" name="y2" />

                                                                <h4>Step1: Please select image file</h4>
                                                                <div><input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" /></div>

                                                                <div class="error"></div>
                                                                <div id="loader-icon" style="display:none;"><img src="<?php echo osc_current_web_theme_url() . '/images/loader.gif' ?>" /></div>
                                                                <div class="step2">
                                                                    <h4>Step2: Please select a crop region</h4>
                                                                    <img id="preview" />

                                                                    <div class="info">
                                                                        <input type="hidden" id="filesize" name="filesize" />
                                                                        <input type="hidden" id="filetype" name="filetype" />
                                                                        <input type="hidden" id="filedim" name="filedim" />
                                                                        <input type="hidden" id="w" name="w" />
                                                                        <input type="hidden" id="h" name="h" />
                                                                    </div>
                                                                    <div class="col-md-offset-4 col-md-4 padding-bottom-10 padding-top-10"><input type="submit" class="btn btn-info upload_profile_img" value="Upload" /></div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <div class="clear"></div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="box-footer">
                                <div class="col-md-12 padding-0 user_info_area font-12">
                                    <div class="col-sm-4 border-right padding-left-0">
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
                                                Follow
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-5 border-right">
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
                                                Followers
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
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
                                            <span class="description-text">Likes</span>
                                        </div>
                                    </div>
                                </div>
                                <?php if (osc_logged_user_id() != $user['user_id']): ?>
                                    <div class="col-md-12 padding-0 communication-tab vertical-row">
                                        <?php
                                        $user_id = osc_logged_user_id();
                                        $follow_user_id = $user['user_id'];
                                        ?>
                                        <?php user_follow_btn_box($user_id, $follow_user_id) ?>
                                        <button class="btn btn-default bold font-12 col-md-4 padding-0" onClick="FreiChat.create_chat_window(<?php echo "'" . $user['user_name'] . "'"; ?>, <?php echo $user['user_id']; ?>)"><?php echo $u['user_name']; ?>Tchat</button>
                                        <?php
                                        $circle_data = get_user_circle_data($user_id);
                                        if (!empty($circle_data) && in_array($follow_user_id, $circle_data)):
                                            ?>
                                            <button class="btn btn-default bold col-md-4 padding-0 last_btn remove_circle" user-id="<?php echo osc_logged_user_id(); ?>" follow-user-id="<?php echo $user['user_id']; ?>">Remove to circle</button>
                                            <?php
                                        else:
                                            ?>
                                            <button class="btn btn-default bold col-md-4 padding-0 last_btn add_circle" user-id="<?php echo osc_logged_user_id(); ?>" follow-user-id="<?php echo $user['user_id']; ?>">Add to circle</button>
                                        <?php
                                        endif;
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>


                        <div class="box box-default">
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
                                <button type="reset" class="btn btn-box-tool reset-button" data-toggle="tooltip" title="Reset">Reset</button>
                            </div>
                        </div>
                        <!-- /.box -->                 
                    </div>
                </div>
            </div>
            <div class="box_post2" id="box_post2">
                <div class="col-md-8 padding-left-0">
                    <ul class="nav nav-tabs user_profile_navigation bg-white">
                        <li class="active user_posts"><a data-toggle="tab" data-target="#user_posts" href="javascript:void(0)">Post</a></li>
                        <li class="user_info"><a data-toggle="tab" data-target="#user_info" href="javascript:void(0)">Infos</a></li>
                        <?php if (osc_user_id() == osc_logged_user_id()): ?>
                            <li class="user_watchlist"><a data-toggle="tab" data-target="#user_watchlist" href="javascript:void(0)">Watchlist</a></li>
                        <?php endif; ?>
                        <li class="user_follower"><a data-toggle="tab" data-target="#user_follower" href="javascript:void(0)">Follows</a></li>
                        <?php if (osc_user_id() == osc_logged_user_id()): ?>
                            <li class="user_circle"><a data-toggle="tab" data-target="#user_circle" href="javascript:void(0)">Circle</a></li>
                        <?php endif; ?>
                    </ul>  

                    <?php
                    $user_id = osc_logged_user_id();
                    $post = get_user_posts_count($user_id);
//pr($post);
//if($post == 1):
                    ?>

                    <?php // endif;  ?>
                    <div class="col-md-12 padding-0 search-box success-border">
                    </div>
                    <div class="border-bottom-gray col-md-12"></div>
                    <div class="user_content col-md-12 padding-0 tab-content scroll-content background-white">
                        <div class="user_posts_area user_details tab-pane fade in active" id="user_posts">
                            <input type="hidden" value="0" name="abc" class="user_post_page_number">  
                            <div class="no-user-post">
                                <div class="col-md-12 padding-top-8per background-white padding-left-7per vertical-row padding-bottom-13per blank_user_post">
                                    <div class="col-md-4 padding-0">
                                        <img src="<?php echo osc_current_web_theme_url() . "images/earth-globe (1).png" ?>" class="post_icon">
                                    </div>
                                    <div class="col-md-7 padding-0">
                                        <div class="col-md-12 light_gray bold padding-bottom-10"> Nothing to show for now </div>
                                        <div class="col-md-12 font-color-black padding-bottom-13per">Nothing has been post yet on that profile page</div>
                                        <div class="col-md-12">
                                            <a href="javascript:void(0)" class="free_account" >
                                                <button class="btn btn-info border-radius-0">Publish Something</button>
                                            </a>
                                        </div>
                                    </div>                                
                                </div>
                                <div class="border-bottom-gray col-md-12"></div>
                            </div>
                            <div class="user_posts_container"></div>
                            <div class="result_text_message"></div> 
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
                        <?php if (osc_user_id() == osc_logged_user_id()): ?>
                            <div class="user_watchlist_container user_details tab-pane fade bg-white" id="user_watchlist">
                                <?php osc_current_web_theme_path('user_watchlist.php') ?> 
                            </div>
                        <?php endif; ?>
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
                                                <input type="text" class="bold follower_search_text search_text" placeholder=" who are you looking for among your followers?">
                                            </div>
                                            <div class="follower-search-button search-button col-md-1">
                                                <button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 border-bottom-gray"></div>

                                <div class="user_follower_box"></div>
                                <?php
                                $user_id = osc_logged_user_id();
                                $follower_users = get_user_follower_data($user_id);
                                if (!$follower_users):
                                    ?>
                                    <div class="col-md-12 padding-top-8per padding-left-7per vertical-row padding-bottom-13per">
                                        <div class="col-md-4 padding-0">
                                            <img src="<?php echo osc_current_web_theme_url() . "images/follow_user.png" ?>" class="post_icon">
                                        </div>
                                        <div class="col-md-7 padding-0">
                                            <div class="col-md-12 light_gray bold padding-bottom-10"> No user found</div>
                                            <div class="col-md-12 font-color-black padding-bottom-13per">When people are following you ther are display just right here then you can better manage them and see who likes you.  </div>
                                        </div>                                
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                        <?php if (osc_user_id() == osc_logged_user_id()): ?>
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
                                                    <input type="text" class="bold circle_search search_text" placeholder="Who are you looking for among your circle?">
                                                </div>
                                                <div class="circle-search-button search-button col-md-1">
                                                    <button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 border-bottom-gray"></div>

                                    <div class="user_follower_box"></div>
                                    <?php
                                    $user_id = osc_logged_user_id();
                                    $circle_users = get_user_circle_data($user_id);
                                    if (!$circle_users):
                                        ?>
                                        <div class="col-md-12 padding-top-8per padding-left-7per vertical-row padding-bottom-13per">
                                            <div class="col-md-4 padding-0">
                                                <img src="<?php echo osc_current_web_theme_url() . "images/user.png" ?>" class="post_icon">
                                            </div>
                                            <div class="col-md-7 padding-0">
                                                <div class="col-md-12 light_gray bold padding-bottom-10"> No user found</div>
                                                <div class="col-md-12 font-color-black padding-bottom-13per">You can add people to your circle at anytime. That's the quicker and easier way to find back people you like to discuss with.</div>
                                            </div>                                
                                        </div>
                                    <?php endif; ?>
                                    <div class="user_circle_box"></div>

                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

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
    <script src="<?php echo osc_current_web_theme_js_url('jquery.Jcrop.js') ?>"></script>
    <script>

                                            $(window).scroll(function (event) {
                                                var screen = $(window).height();
                                                var scroll = $(window).scrollTop();
                                                if (screen > 900) {
                                                    var fix = 610;
                                                }
                                                else if (screen > 800) {
                                                    var fix = 600;
                                                }
                                                else if (screen > 700) {
                                                    var fix = 570;
                                                }
                                                else if (screen > 600) {
                                                    var fix = 500;
                                                }
                                                else if (screen > 480) {
                                                    var fix = 450;
                                                }
                                                else if (screen > 400) {
                                                    var fix = 380;
                                                }
                                                if (scroll > fix) {
                                                    $('#wrap').addClass("box_fix2");
                                                    $('#box_post2').addClass("box_post3");
                                                    $('.user_profile_navigation').addClass("fix_nav");

                                                } else {
                                                    $('#wrap').removeClass("box_fix2");
                                                    $('#box_post2').removeClass("box_post3");
                                                    $('.user_profile_navigation').removeClass("fix_nav");

                                                }

                                            });
                                            $(document).on('click', '.add_circle', function () {
                                                var follow_user_id = $(this).attr('follow-user-id');
                                                var logged_in_user_id = $(this).attr('user-id');
                                                $.ajax({
                                                    url: '<?php echo osc_current_web_theme_url() . 'unfollow_and_add_circle.php' ?>',
                                                    type: 'post',
                                                    data: {
                                                        action: 'add_circle',
                                                        follow_user_id: follow_user_id,
                                                        logged_in_user_id: logged_in_user_id
                                                    },
                                                    success: function () {
                                                        $(location).attr('href', '<?php echo osc_user_public_profile_url(osc_logged_user_id()); ?>');
                                                    }
                                                })
                                            });
                                            $(document).on('click', '.remove_circle', function () {
                                                var follow_user_id = $(this).attr('follow-user-id');
                                                var logged_in_user_id = $(this).attr('user-id');
                                                $.ajax({
                                                    url: '<?php echo osc_current_web_theme_url() . 'unfollow_and_add_circle.php' ?>',
                                                    type: 'post',
                                                    data: {
                                                        remove_circle: 'remove_circle',
                                                        follow_user_id: follow_user_id,
                                                        logged_in_user_id: logged_in_user_id
                                                    },
                                                    success: function () {
                                                        $(location).attr('href', '<?php echo osc_user_public_profile_url(osc_logged_user_id()); ?>');
                                                    }
                                                })
                                            });
    </script>
    <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/masonry.pkgd.min.js'); ?>"></script>
    <script>
                                            var user_id = '<?php echo osc_user_id() ?>'
                                            var is_enable_ajax = true;
                                            var loading = false;
                                            var location_type = $('.filter_city').attr('data_location_type');
                                            var location_id = $('.filter_city').attr('data_location_id');
                                            var category_id = $('#sCategory').val();
                                            var post_type = $('.post_type_filter').val();
                                            $(document).on('click', '.file_upload', function () {

                                                //$('#crop-img').modal('show');
                                                $('#crop-img').appendTo('body');
                                            });
                                            $(document).on('click', '.file_upload_cover', function () {

                                                //$('#crop-img').modal('show');
                                                $('#crop-cover-img').appendTo('body');
                                            });
                                            $(document).ready(function () {
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
                                                                        region_id: data.region_id,
                                                                        country_id: data.country_id,
                                                                        name: data.city_name + '-' + data.region_name + '-' + data.country_name,
                                                                    };
                                                                    $items.push(group);
                                                                });

                                                                process($items);
                                                            }
                                                        });
                                                    },
                                                    afterSelect: function (obj) {
                                                        $('.filter_city').attr('data_location_id', obj.id);
                                                    },
                                                    //                updater:function (item) {
                                                    //                    console.log(item);
                                                    //                },
                                                });
                                            });
                                            $(document).ready(function ($) {
                                                fetch_user_posts();


                                                $('#cover .img').hover(function () {
                                                        $('.file_upload_cover .icon').show();
                                                    },
                                                    function () {
                                                        $('.file_upload_cover .icon').hide();
                                                });
                                                
                                                $('.file_upload_cover .icon').hover(function () {
                                                        $('.file_upload_cover .icon').show();
                                                    },
                                                    function () {
                                                        $('.file_upload_cover .icon').hide();
                                                });
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

                                                $(document).on('keyup', '.follower_search_text', function () {
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
                                                $(document).on('keyup', '.post_search', function () {
                                                    var search_name = $('.post_search').val();
                                                    $.ajax({
                                                        url: "<?php echo osc_current_web_theme_url() . 'user_posts.php' ?>",
                                                        data: {
                                                            user_id: user_id,
                                                            search_name: search_name
                                                        },
                                                        success: function (data) {
                                                            $('.user_posts_container').html(data);
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
                                                $(document).on('keyup', '.circle_search', function () {
                                                    var search_name = $('.circle_search').val();

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
                                                        // $('.user_posts_container').css({'opacity': '0.2'});
                                                        setTimeout(fetch_user_posts, 1000);
                                                    }
                                                });
                                                $('#sCategory').change(function () {
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
                                                $('.country-dropdown #countryId').change(function () {
                                                    $('.posts_container .loading').fadeIn(500);
                                                    $('.user_related_posts').css({'opacity': '0.2'});
                                                    var country_id = $('#countryId').val();
                                                    reset_variables();
                                                    //make_after_login_item_ajax_call();
                                                    $.ajax({
                                                        url: "<?php echo osc_current_web_theme_url() . '/item_after_login_ajax.php' ?>",
                                                        data: {
                                                            country_id: country_id,
                                                        },
                                                        success: function (data) {
                                                            $('.user_posts_container').empty().append(data);
                                                            $('.user_posts_area .loading').fadeOut(1000);
                                                            $('.user_posts_container').css({'opacity': '1'});
                                                        }
                                                    });
                                                });
                                                $('.filter_city').change(function () {
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
                                                $('.reset-button').click(function () {
                                                    window.location.reload();

                                                });
                                            });
                                            function fetch_user_posts() {
                                                var post = $('.user_post_page_number').val();

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
                                                        if (data.indexOf("Nothing to show") >= 0) {
                                                            if (page_number === 1) {
                                                                $('.result_text_message').html('<h2 class="result_text">Ends of results</h2>');
                                                            } else if ($('.usepost_no_record').size() < 1) {
                                                                $('.result_text_message').html(data);
                                                            }
                                                            is_enable_ajax = false;
                                                        }
                                                        else {
                                                            loading = false;
                                                            $(".no-user-post").hide();
                                                            $(".user_posts_container").append(data);
                                                            var next_page = parseInt($('.user_posts_area .user_post_page_number').val()) + 1;
                                                            $('.user_posts_area .user_post_page_number').val(next_page);

                                                        }
                                                        //                                                        else {
                                                        //                                                            if (data.indexOf("Nothing to show") >= 0) {
                                                        //                                                                if (page_number === 1) {
                                                        //                                                                    $('.user_posts_area .result_text').html('<h2 class="result_text">Ends of results</h2>');
                                                        //                                                                } else if ($('.result_text').size() < 1) {
                                                        //                                                                    $('.user_posts_area .result_text').html(data);
                                                        //                                                                }
                                                        //                                                            }
                                                        ////                                                            $(".user_posts_area .result_text").text('Ends of results').show();
                                                        //                                                            is_enable_ajax = false;
                                                        //                                                        }
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
<?php //osc_current_web_theme_path('locationfind.php'); ?>
<?php osc_current_web_theme_path('footer.php'); ?>