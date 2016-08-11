<?php
require_once '../../../oc-load.php';
require_once 'functions.php';

$item_id = $_REQUEST['item_id'];

function get_item_location($item_id) {
    $item_data = new DAO();
    $db_prefix = DB_TABLE_PREFIX;
    $item_data->dao->select("item.*");
    $item_data->dao->from("{$db_prefix}t_item_location AS item");
    $item_data->dao->where("item.fk_i_item_id= {$item_id}");
    $result = $item_data->dao->get();
    $item = $result->row();
    return $item;
}

$item_location = get_item_location($item_id);

function get_item($item_id) {
    $item = new DAO();
    $db_prefix = DB_TABLE_PREFIX;
    $item->dao->select("cat.*");
    $item->dao->from("{$db_prefix}t_item AS cat");
    $item->dao->where("cat.pk_i_id= {$item_id}");
    $result = $item->dao->get();
    $item_data = $result->row();
    return $item_data;
}

$item = get_item($item_id);
osc_query_item(array('id' => $item_id, 'results_per_page' => 1));
while (osc_has_custom_items()):
    ?>

    <!-- Modal -->
    <div id="item_popup_modal" class="modal fade item_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="box-body">
                    <?php //osc_item($item_id);   ?>
                    <div id="columns">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="popup">
                                        <?php user_follow_box(osc_logged_user_id(), osc_item_user_id()); ?>
                                        <div class="user-block">
                                            <?php
                                            $user = get_user_data(osc_item_user_id());
                                            if (!empty($user['s_path'])):
                                                $user_image_url = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . "_nav." . $user['s_extension'];
                                            else:
                                                $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                            endif;
                                            ?>
                                            <img class="img-circle" src="<?php echo $user_image_url ?>" alt="<?php echo $user['user_name'] ?>">
                                            <span class="username">
                                                <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>"><?php echo $user['user_name'] ?></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 item-title">
                                    <h2><?php echo osc_item_title(); ?></h2>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                    <?php if (osc_get_preference('position7_enable', 'flatter_theme') != '0') { ?>
                                        <div id="position_widget"<?php
                                        if (osc_get_preference('position7_hide', 'flatter_theme') != '0') {
                                            echo " class='hidden-xs'";
                                        }
                                        ?>>
                                            <div class="dd-widget position_7">
                                                <?php echo osc_get_preference('position7_content', 'flatter_theme'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div id="content">
                                        <?php item_resources(osc_item_id()) ?>

                                        <div id="itemdetails" class="clearfix">
                                            <div class="description">
                                                <?php echo osc_item_description(); ?>
                                            </div>                                            

                                            <div id="extra-fields">
                                                <?php //osc_run_hook('item_detail', osc_item());   ?>
                                            </div>

                                        </div> <!-- Description End -->

                                    </div><!-- Item Content End -->

                                    <div class="row item-bottom">
                                        <div class="col-md-6 col-md-offset-3"> 
                                            <ul class="social-share">
                                                <li class="facebook">
                                                    <a class="whover" title="" data-toggle="tooltip" href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent('<?php echo osc_item_url(); ?>'), 'facebook-share-dialog', 'height=279, width=575');
                                                                return false;" data-original-title="<?php _e("Share on Facebook", 'flatter'); ?>">
                                                        <i class="fa fa-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="twitter">
                                                    <a class="whover" title="" href="https://twitter.com/intent/tweet?text=<?php echo osc_item_title(); ?>&url=<?php echo osc_item_url(); ?>" data-toggle="tooltip" data-original-title="<?php _e("Share on Twitter", 'flatter'); ?>"><i class="fa fa-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="googleplus">
                                                    <a class="whover" title="" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,height=600,width=600');
                                                                return false;" href="https://plus.google.com/share?url=<?php echo osc_item_url(); ?>" data-toggle="tooltip" data-original-title="<?php _e("Share on Google+", 'flatter'); ?>">
                                                        <i class="fa fa-google-plus"></i>
                                                    </a>
                                                </li>                                               
                                            </ul><!-- Social Share End -->
                                        </div>
                                        <div class="col-md-6">
                                            <?php if (osc_is_web_user_logged_in() && osc_logged_user_id() == osc_item_user_id()) { ?>
                                                <div class="pull-right edit edit_post" >
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-9 col-md-offset-3">
                                            <?php echo item_like_box(osc_logged_user_id(), osc_item_id()) ?>

                                            &nbsp;&nbsp;

                                            <?php echo user_share_box(osc_logged_user_id(), osc_item_id()) ?>

                                            &nbsp;&nbsp;&nbsp;
                                            <span class="comment_text"><i class="fa fa-comments"></i>&nbsp;<span class="comment_count_<?php echo osc_item_id(); ?>"><?php echo get_comment_count(osc_item_id()) ?></span>&nbsp;
                                                <?php echo 'Comments' ?>

                                                &nbsp;&nbsp;
                                                <a href="#"><?php echo 'Tchat' ?></a>&nbsp;
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="comments_container_<?php echo osc_item_id(); ?>">
                                                <?php
                                                $c_data = get_item_comments(osc_item_id());
                                                if ($c_data):
                                                    foreach ($c_data as $k => $comment_data):
                                                        ?>
                                                        <?php
                                                        $comment_user = get_user_data($comment_data['fk_i_user_id']);
                                                        if ($comment_user['s_path']):
                                                            $user_image_url = osc_base_url() . $comment_user['s_path'] . $comment_user['pk_i_id'] . "_nav." . $comment_user['s_extension'];
                                                        else:
                                                            $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                                        endif;
                                                        ?>
                                                        <div class="box-footer box-comments">
                                                            <div class="box-comment">
                                                                <!-- User image -->
                                                                <img class="img-circle" src="<?php echo $user_image_url ?>" alt="<?php echo $comment_user['user_name'] ?>">

                                                                <div class="comment-area">
                                                                    <span class="username">
                                                                        <?php echo $comment_user['user_name'] ?>
<!--                                                                        <div class="dropdown  pull-right">
                                                                            <i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-hidden="true"></i>
                                                                            <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                                                                                <li class="delete_cmnt" onclick="deleteComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item_id; ?>)"><a>Supprimer la publication</a></li>
                                                                                <li class="edit_cmnt comment_text_<?php echo $comment_data['pk_i_id']; ?>" data-item-id='<?php echo $item['pk_i_id']; ?>' data_text="<?php echo $comment_data['s_body']; ?>" data_id="<?php echo $comment_data['pk_i_id']; ?>" onclick="editComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item_id; ?>)"><a>Modifier</a></li>
                                                                                <li><a></a></li>
                                                                                <li><a>Sponsoriser</a></li>
                                                                                <li><a>Remonter en tête de liste</a></li>
                                                                                <li><a></a></li>
                                                                                <li><a>Signaler la publication</a></li>

                                                                            </ul>
                                                                        </div>-->
                                                                    </span><!-- /.username -->
                                                                    <span class="comment_text comment_edt_<?php echo $comment_data['pk_i_id']; ?>" data-text="<?php echo $comment_data['s_body']; ?>">
                                                                        <?php echo $comment_data['s_body']; ?>
                                                                    </span>
                                                                    <span class="text-muted pull-right"><?php echo time_elapsed_string(strtotime($comment_data['dt_pub_date'])) ?></span>                                                                    
                                                                </div>
                                                                <!-- /.comment-text -->
                                                            </div>                       
                                                        </div>                  
                                                        <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </div>
                                            <!-- /.box-footer -->
                                            <?php if (osc_is_web_user_logged_in()): ?>
                                                <div class="box-footer">
                                                    <form class="comment_form" data_item_id="<?php echo osc_item_id() ?>" data_user_id ="<?php echo osc_logged_user_id() ?>" method="post">
                                                        <?php
                                                        $current_user = get_user_data(osc_logged_user_id());
                                                        $current_user_image_url = '';

                                                        if ($current_user['s_path']):
                                                            $current_user_image_url = osc_base_url() . $current_user['s_path'] . $current_user['pk_i_id'] . "_nav." . $current_user['s_extension'];
                                                        else:
                                                            $current_user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                                        endif;
                                                        ?>
                                                        <img class="img-responsive img-circle img-sm" src="<?php echo $current_user_image_url ?>" alt="<?php echo $current_user['user_name'] ?>">
                                                        <!-- .img-push is used to add margin to elements next to floating images -->
                                                        <div class="img-push">
                                                            <input type="text" class="form-control input-sm comment_text" placeholder="Press enter to post comment">
                                                        </div>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if (osc_get_preference('google_adsense', 'flatter_theme') !== '0' && osc_get_preference('adsense_listing', 'flatter_theme') != null) { ?>
                                        <div class="pagewidget">
                                            <div class="gadsense">
                                                <?php echo osc_get_preference('adsense_listing', 'flatter_theme'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!-- Comments Template -->

                                </div><!-- Item Content -->

                                <!-- Sidebar Template -->

                            </div>

                        </div>
                    </div>
                </div>              
            </div>

        </div>
    </div>

    <div id="popup-free-user-post" class="modal modal-transparent fade" role="dialog">
        <div class="col-md-offset-1 col-md-10">
            <div class="large-modal">
                <!-- Modal content-->
                <div class="modal-content">
                    <form method="post" id="post_update" action="<?php echo osc_current_web_theme_url('post_update.php'); ?>" enctype="multipart/form-data">
                        <!--<input type="hidden" name="save" value="true">-->
                        <input type="hidden" name="item_id" id="item_id" value="<?php echo $item_id; ?>">
                        <!-------------------------User Information Start---------------------------->

                        <div class="modal-body padding-0">
                            <div class="col-md-12 padding-0">
                                <div class="greybg padding-top-3per">
                                    <div class="col-md-12 vertical-row">
                                        <div class="sub col-md-offset-1">
                                            <h1 class="bold big-font col-md-12">Publish freely on Newsfid.</h1>
                                            <div class="col-md-7">
                                                At any time you can update your free account to get more publishing options. This will allow you as well to mark your profile with a professional logo to make the difference with other users.
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bg-white">
                                    <div class="col-md-12 vertical-row">
                                        <div class="col-md-offset-1">
                                            <div class="col-md-2 user-photo">
                                                <?php
                                                $current_user = get_user_data(osc_logged_user_id());

                                                if (!empty($current_user['s_path'])):
                                                    $img_path = osc_base_url() . '/' . $current_user['s_path'] . $current_user['pk_i_id'] . '.' . $current_user['s_extension'];
                                                else:
                                                    $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                                                endif;

                                                if ($current_user['user_type'] == 1):
                                                    $user_type_image_path = osc_current_web_theme_url() . 'images/Subscriber.png';
                                                endif;

                                                if ($current_user['user_type'] == 2):
                                                    $user_type_image_path = osc_current_web_theme_url() . 'images/Certified.png';
                                                endif;

                                                if ($current_user['user_type'] == 3):
                                                    $user_type_image_path = osc_current_web_theme_url() . 'images/Ciertified-subscriber.png';
                                                endif;
                                                ?>

                                                <img src="<?php echo $img_path; ?>" alt="user" class="img img-responsive">
                                            </div> 
                                            <div class="col-md-6 padding-top-3per">
                                                <div class="col-md-12 vertical-row">
                                                    <div class="col-md-4 padding-0">
                                                        <h4 class="bold"><?php echo $current_user['user_name'] ?></h4>                                                </div>
                                                    <div class="col-md-6 padding-0">
                                                        <?php if ($current_user['user_type'] != 0): ?>
                                                            <img class="vertical-top col-md-1 star img img-responsive" src="<?php echo $user_type_image_path ?>">
                                                        <?php endif ?>
                                                    </div>

                                                </div>
                                                <div class="col-md-12 vertical-row">
                                                    <h5 class=" margin-0">Vous avez déjà <span style="color:orangered"><?php echo get_user_posts_count($current_user['user_id']) ?></span> publication </h5>
                                                </div>


                                            </div>
                                            <div class="col-md-4 padding-top-4per">
                                                <div class="col-md-offset-4">
                                                    <a href="<?php echo osc_current_web_theme_url('subscribe.php'); ?>" class="en-savoir-plus-button-orng"> En savoir plus </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 vertical-row">
                                        <div class="col-md-offset-1 col-md-11 padding-top-3per">
                                            <!--                                        <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>
                                                                                    <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-------------------------User Information End---------------------------->
                            <div class="breack-line"> &nbsp; </div>
                            <!-------------------------General Information Start---------------------------->
                            <div class="genral-info bg-white border-radius-10">
                                <div class="theme-modal-header">
                                    <h3 class="modal-title bold orange">General Information </h3>
                                </div>
                                <div class="center-contant">
                                    <div class="category-dropdown left-border margin-top-20" style="display: block;">
                                        <?php osc_goto_first_category(); ?>
                                        <?php if (osc_count_categories()) { ?>
                                            <select id="sCategory" class="form-control input-box" name="sCategory">
                                                <option <?php ?> value=""><?php _e('&nbsp; Category', 'flatter'); ?></option>
                                                <?php while (osc_has_categories()) { ?>
                                                    <option  class="maincat bold" <?php if (osc_category_id() == $item['fk_i_category_id']) echo 'selected'; ?> value="<?php echo osc_category_id(); ?>"><?php echo osc_category_name(); ?></option>
                                                    <?php if (osc_count_subcategories()) { ?>
                                                        <?php while (osc_has_subcategories()) { ?>
                                                            <option class="subcat margin-left-30" <?php if (osc_category_id() == $item['fk_i_category_id']) echo 'selected'; ?> value="<?php echo osc_category_id(); ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo osc_category_name(); ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>

                                            </select>
                                        <?php } ?>

                                    </div>
                                    <div class="input-text-area margin-top-20 left-border box-shadow-none width-60">
                                        <input type="text" placeholder="Title" class="p_title" name="p_title" value="<?php echo osc_item_title(); ?>"> <span class="error-title red">Post Title Required</span>
                                    </div>
                                    <div class="box-shadow-none width-90 description-box">
                                        <textarea placeholder="Redigez la description ici..." class="p_disc" name="p_disc"><?php echo osc_item_description(); ?></textarea> <span class="error-desc red">Post Description Required</span>
                                    </div>

                                </div>
                                <div class="theme-modal-footer">
                                </div>


                            </div>
                            <!-------------------------General Information end---------------------------->
                            <div class="breack-line"></div>
                            <!-------------------------Add Media Start---------------------------->
                            <div class="media-info border-radius-10">
                                <div class="theme-modal-header">
                                    <h3 class="bold orange">Add a Media </h3>
                                </div>
                                <div class="center-contant">
                                    <div class="border-bottom col-md-12 vertical-row">
                                        <div class="col-md-1">
                                            <img class="vertical-top img img-responsive" src="<?php echo osc_current_web_theme_url() . '/images/info.png' ?>" >
                                        </div>
                                        <div class="col-md-11 padding-10">
                                            Depending on your needs choose the type of media you are interested in for your publication,
                                            some media uses require a subscription while others are free of use.
                                        </div>
                                    </div>
                                    <div class="border-bottom col-md-12 vertical-row  padding-10">
                                        <div class="col-md-1 margin-bottom-3per">
                                            <img class="vertical-top img img-responsive" src="<?php echo osc_current_web_theme_url() . '/images/filter.png' ?>" width="50px" height="45px" style="margin-left: 10px; margin-top:10px;">
                                        </div>
                                        <div class="orange col-md-1"><h3 class="bold">Filters</h3></div>
                                    </div>
                                    <div class=" col-md-12">
                                        <div class="col-md-6">
                                            <div class="col-md-12 vertical-row center-contant">
                                                <div class="col-md-2"> <span class="bold">Image</span>
                                                    <div class="onoffswitch">
                                                        <input type="checkbox" name="post_type" class="onoffswitch-checkbox post_type_switch" data_post_type="image" id="image" checked value="image">
                                                        <label class="onoffswitch-label" for="image"></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 ou">ou</div>
                                                <div class="col-md-2"><span class="bold">Video</span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Liens)</span>
                                                    <div class="onoffswitch">
                                                        <input type="checkbox" name="post_type" class="onoffswitch-checkbox post_type_switch" data_post_type="video" id="video" value="video">
                                                        <label class="onoffswitch-label" for="video"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 padding-top-8per">
                                                <div class="col-md-offset-1 col-md-4">
                                                    <!--<img class="vertical-top camera-icon img img-responsive" src="<?php echo osc_current_web_theme_url() . '/images/camera.png' ?>">-->
                                                    <div class="post_file_upload_container" style="background-image: url('<?php echo osc_current_web_theme_url() . '/images/camera.png' ?>')">
                                                        <input type="file" name="post_media" id="post_media" class="post_media" placeholder="add your embedding code here">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6  text-bg-color">
                                            <div class="bold padding-10">
                                                You can not choose both at the same time
                                                you can publish  image or a video link.
                                            </div>
                                        </div>
                                    </div> 
                                    <div class=" col-md-12 border-bottom">
                                        <div class="col-md-6">
                                            <span class="bold">GIF</span>
                                            <div class="onoffswitch margin-top-20">
                                                <input type="checkbox" name="post_type" class="onoffswitch-checkbox post_type_switch" data_post_type="gif" id="gif" value="gif">
                                                <label class="onoffswitch-label" for="gif"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6  text-bg-color">
                                            <div class="bold padding-10">
                                                The image begins to automatically animate when the user will scroll.
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-md-12 border-bottom">
                                        <div class="col-md-6">
                                            <span class="bold">Music</span>
                                            <div class="onoffswitch margin-top-20">
                                                <input type="checkbox" name="post_type" class="onoffswitch-checkbox post_type_switch" data_post_type="music" id="music" value="music">
                                                <label class="onoffswitch-label" for="music"></label>
                                            </div>
                                            <div class="mp3-max">
                                                <span class="">(MP3 10.MO maximum) </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-bg-color">
                                            <div class="bold padding-10">
                                                You can download only mp3 files. If you wish to publish mp3  bigger than 10mo thank you to subscribe.
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-md-12 border-bottom">
                                        <div class="col-md-6">
                                            <span class="bold">Podcast</span>
                                            <div class="onoffswitch margin-top-20">
                                                <input type="checkbox" name="post_type" class="onoffswitch-checkbox post_type_switch" data_post_type="podcast" id="podcast" value="podcast">
                                                <label class="onoffswitch-label" for="podcast"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-bg-color">
                                            <div class="bold padding-10">
                                                Your podcast must be a mp3 file. I you wish to publish a file bigger than 100mo thank you to subscribe.

                                            </div>
                                        </div>


                                    </div>
                                    <!-- <div class="col-md-5">
                                         
                                     </div>-->

                                </div>
                            </div>
                            <!-------------------------Add Media end------------------------------>
                            <div class="breack-line"></div>

                            <!-------------------------Location Start------------------------------>
                            <div class="location-info border-radius-10">
                                <div class="modal-header">
                                    <h3 class="modal-title bold orange">Localistion </h3>
                                </div>
                                <div class="modal-header">
                                    <div class="col-md-offset-1 col-md-10 margin-top-20">
                                        <div class="col-md-12 margin-top-20 padding-bottom-20">
                                            <div class="col-md-1">
                                                <img class="vertical-top  img img-responsive" src="<?php echo osc_current_web_theme_url() . '/images/info.png' ?>" width="50px" height="45px" style="margin-left: 10px; margin-top:10px;">
                                            </div>
                                            <div class="col-md-10 padding-10">
                                                This step is not mandatory but nevertheless important to improve your publication in our search engine.
                                            </div>
                                        </div>

                                    </div><div class="clear"></div>
                                </div>
                                <div class="col-md-offset-2 col-md-10 margin-top-20">
                                    <div class="input-text-area left-border margin-top-20 box-shadow-none country-select width-60 margin-left-30">                                  
                                        <select id="countryId" class="user_country_textbox" name="countryId">
                                            <?php
                                            $counrtry_db = osc_get_countries();
                                            foreach ($counrtry_db as $key => $country) :
                                                ?>
                                                <option <?php if ($country['pk_c_code'] == $item_location['fk_c_country_code']) echo 'selected'; ?> value="<?php echo $country['pk_c_code']; ?>"><?php echo $country['s_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>


                                    <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30">
                                        <input type="text" id="s_region_name" name="s_region_name" placeholder="Region" value="<?php echo $item_location['s_region']; ?>">
                                        <input type="hidden" id="s_region_id" name="s_region_id">
                                    </div>
                                    <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30">
                                        <input type="text" name="s_city_name" class="form-control" id="s_city_name" placeholder="City" value="<?php echo $item_location['s_city']; ?>">
                                        <input type="hidden" name="s_city_id" class="form-control" id="s_city_id">
                                    </div>
                                    <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30">
                                        <input type="text" placeholder="City Area" id="s_city_area_name" name="s_city_area_name" value="<?php echo $item_location['s_city_area']; ?>">
                                    </div>
                                    <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30" >
                                        <input type="text" name="s_address" id="s_address" placeholder="Address" value="<?php echo $item_location['s_address']; ?>">
                                    </div>
                                </div>
                            </div>
                            <!-------------------------Location end------------------------------>
                            <div class="breack-line"></div></div>
                        <!-------------------------Reminder start------------------------------>
                        <div class="col-md-12 padding-0 border-radius-10">
                            <div class="greybg padding-top-3per">
                                <div class="col-md-12 vertical-row">
                                    <div class="sub col-md-offset-1">
                                        <h1 class="bold big-font col-md-12">Bon à savoir</h1>
                                        <div class="col-md-7">
                                            Subscribers users can promote their publication at all times thanks to Promoted publications. Unsubscribed users can not enjoy it. 
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-offset-8">
                                        <button class="en-savoir-plus-button-gry">Ne plus afficher ce message</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 bg-white">
                                <div class="col-md-12 vertical-row">
                                    <div class="col-md-offset-1">
                                        <div class="col-md-2 margin-top-20">
                                            <?php
                                            $current_user = get_user_data(osc_logged_user_id());

                                            if (!empty($current_user['s_path'])):
                                                $img_path = osc_base_url() . '/' . $current_user['s_path'] . $current_user['pk_i_id'] . '.' . $current_user['s_extension'];
                                            else:
                                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                                            endif;
                                            ?>

                                            <img src="<?php echo $img_path; ?>" alt="user" class="img img-responsive">
                                        </div> 
                                        <div class="col-md-6 padding-top-3per">
                                            <div class="col-md-12 vertical-row">
                                                <div class="col-md-4 padding-0">
                                                    <h5 >Gwinel Madlisse</h5>
                                                </div>
                                                <div class="col-md-6 padding-0">
                                                    <img class="vertical-top col-md-1 star img img-responsive" src="<?php echo osc_current_web_theme_url() . '/images/start-box.png' ?>">
                                                </div>

                                            </div>
                                            <div class="col-md-12 vertical-row">
                                                <h5 class=" margin-0">Vous avez deja <span style="color:orangered">365</span> publication</h5>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12 vertical-row">
                                    <div class="col-md-offset-1 col-md-11 padding-top-3per">
                                        <!--                                    <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>
                                                                            <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-------------------------Reminder end------------------------------>
                        <div class="breack-line"></div>
                        <!-------------------------Finalisation Start------------------------------>
                        <div class="finalisation-info border-radius-10 bg-white">
                            <div class="modal-header col-md-offset-1 margin-top-20">
                                <h3 class="modal-title bold orange">Finalisation</h3>
                            </div>
                            <div class=" col-md-12 border-bottom margin-top-20 margin-bottom-20">
                                <div class="onoffswitch margin-top-20 col-md-offset-1 col-md-2">
                                    <input type="checkbox" name="publier" class="onoffswitch-checkbox publier" id="publier">
                                    <label class="onoffswitch-label" for="publier"></label>
                                </div>
                                <div class=" col-md-6">
                                    <p>
                                        I accept the terms of use and additional requirements related to the use of newsfid service. One case of conflict with my content I agree to be solely responsible for and agree that newsfid and its partners are not responsible at all.
                                    </p>
                                </div>
                                <div class="col-md-offset-1 col-md-11">
                                    <span class="error-term red">Please Accept Term & Condition</span>
                                </div>


                            </div>
                            <div class="modal-footer ">
                                <div class="en-savoir-plus publier col-md-offset-1 col-md-3">
                                    <button type="submit" class="en-savoir-plus-button publier-btn"><span class="bold">Publier<span></button> 
                                </div>
                                <div class="col-md-4">
                                    <span class="error-btn red">Please Fill All Required Field</span>
                                </div>
                                                </div>


                                                </div>
                                                <!-------------------------Finalisation End------------------------------>
                                                <div class="breack-line"><div class="round-border-bottom"></div></div>
                                                </div>
                                                </form>
                                                </div>

                                                </div>
                                                </div>
                                            <?php endwhile; ?>
                                            <script>
                                                $(document).ready(function () {
                                                    $('.error-desc').hide();
                                                    $('.error-title').hide();
                                                    $('.error-term').hide();
                                                    $('.error-btn').hide();
                                                    $('#post_update').submit(function () {
                                                        var title = $('.p_title').val();
                                                        var discription = $('.p_disc').val();
                                                        if (title != '') {
                                                            $('.error-title').hide();
                                                        } else {
                                                            $('.error-title').show();
                                                            $('.error-btn').show();
                                                            return false;
                                                        }
                                                        if (discription != '')
                                                        {
                                                            $('.error-desc').hide();
                                                        }
                                                        else {
                                                            $('.error-desc').show();
                                                            $('.error-btn').show();
                                                            return false;
                                                        }

                                                        if (!$("#publier").is(":checked")) {
                                                            $('.error-term').show();
                                                           
                                                            return false;
                                                        }
                                                        return true;

                                                    });
                                                });
                                                $(".edit_post").click(function () {
                                                    $('#popup-free-user-post').modal('show');
                                                });
                                            </script>
                                            <script>
                                                $(document).ready(function () {
                                                    $('#s_region_name').typeahead({
                                                        source: function (query, process) {
                                                            var $items = new Array;
                                                            var c_id = $('#countryId').val();
                                                            console.log(c_id);
                                                            if (c_id) {
                                                                $items = [""];
                                                                $.ajax({
                                                                    url: "<?php echo osc_current_web_theme_url('region_ajax.php') ?>",
                                                                    dataType: "json",
                                                                    type: "POST",
                                                                    data: {region_name: query, country_id: c_id},
                                                                    success: function (data) {
                                                                        $.map(data, function (data) {
                                                                            var group;
                                                                            group = {
                                                                                id: data.pk_i_id,
                                                                                name: data.s_name,
                                                                            };
                                                                            $items.push(group);
                                                                        });

                                                                        process($items);
                                                                    }
                                                                });
                                                            } else {
                                                                alert('Please select country first');
                                                            }
                                                        },
                                                        afterSelect: function (obj) {
                                                            $('#s_region_id').val(obj.id);
                                                        },
                                                    });
                                                });
                                            </script>
                                            <script>
                                                $(document).ready(function () {
                                                    $('#s_city_name').typeahead({
                                                        source: function (query, process) {
                                                            var $items = new Array;
                                                            var region_id = $('#s_region_id').val();
                                                            if (region_id) {
                                                                $items = [""];
                                                                $.ajax({
                                                                    url: "<?php echo osc_current_web_theme_url('search_city_by_region.php') ?>",
                                                                    dataType: "json",
                                                                    type: "POST",
                                                                    data: {city_name: query, region_id: region_id},
                                                                    success: function (data) {
                                                                        $.map(data, function (data) {
                                                                            var group;
                                                                            group = {
                                                                                id: data.pk_i_id,
                                                                                name: data.city_name,
                                                                            };
                                                                            $items.push(group);
                                                                        });

                                                                        process($items);
                                                                    }
                                                                });
                                                            } else {
                                                                alert('Please select region first');
                                                            }
                                                        },
                                                        afterSelect: function (obj) {
                                                            //$('#sRegion').val(obj.id);
                                                        },
                                                    });
                                                });
                                            </script>
                                            <script>
                                                $(".post_type_switch").on('click', function () {
                                                    var $box = $(this);
                                                    if ($box.is(":checked")) {
                                                        var group = ".post_type_switch";
                                                        $(group).prop("checked", false);
                                                        $box.prop("checked", true);
                                                    } else {
                                                        $box.prop("checked", false);
                                                    }
                                                    var selected_post_type = $('.post_type_switch').filter(':checked');

                                                    if (selected_post_type.attr('data_post_type') == 'music' || selected_post_type.attr('data_post_type') == 'podcast') {
                                                        var duplicate_post_media = $('#post_media').clone();
                                                        $('#post_media').remove();
                                                        $(selected_post_type).parent().after(duplicate_post_media);
                                                    }
                                                    if (selected_post_type.attr('data_post_type') == 'gif') {
                                                        var duplicate_post_media2 = $('#post_media').clone();
                                                        $('#post_media').remove();
                                                        $(selected_post_type).parent().after(duplicate_post_media2);
                                                    }
                                                    if (selected_post_type.attr('data_post_type') == 'image' || selected_post_type.attr('data_post_type') == 'video') {
                                                        var duplicate_post_media = $('#post_media').clone();
                                                        $('#post_media').remove();
                                                        $('.post_file_upload_container').append(duplicate_post_media);
                                                    }

                                                    if (selected_post_type.attr('data_post_type') == 'podcast' || selected_post_type.attr('data_post_type') == 'video') {
                                                        $('#post_media').attr('type', 'text');
                                                    } else {
                                                        $('#post_media').attr('type', 'file');
                                                    }
                                                });
                                            </script>
                                            <script>
                                                $(document).on('change', '.user_role_selector', function () {
                                                    $.ajax({
                                                        url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
                                                        data: {
                                                            action: 'user_role',
                                                            user_role_id: role_id,
                                                        },
                                                        success: function (data, textStatus, jqXHR) {
                                                            if (data != 0) {
                                                                $('.user_role_name').text(data);
                                                            }
                                                            $('.user_role_selector').hide();
                                                            $('.user_role_name').show();
                                                        }
                                                    });
                                                });
                                            </script>