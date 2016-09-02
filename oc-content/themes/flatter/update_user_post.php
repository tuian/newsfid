<?php
require_once '../../../oc-load.php';
require_once 'functions.php';
$item_id = $_REQUEST['item_id'];
if ($_REQUEST['action'] == 'update_post'):
    $db_prefix = DB_TABLE_PREFIX;
    $post_data = new DAO();
    $post_data->dao->select("item.*");
    $post_data->dao->from("{$db_prefix}t_item_description AS item");
    $post_data->dao->where("item.fk_i_item_id", $item_id);
    $post_data_result = $post_data->dao->get();
    $post_desc = $post_data_result->row();

    $post_location = new DAO();
    $post_location->dao->select("item.*");
    $post_location->dao->from("{$db_prefix}t_item_location AS item");
    $post_location->dao->where("item.fk_i_item_id", $item_id);
    $post_location_result = $post_location->dao->get();
    $item_location = $post_location_result->row();

    $post_item_data = new DAO();
    $post_item_data->dao->select("item.*");
    $post_item_data->dao->from("{$db_prefix}t_item AS item");
    $post_item_data->dao->where("item.pk_i_id", $item_id);
    $post_item_result = $post_item_data->dao->get();
    $item = $post_item_result->row();
    ?>
    <div id="popup-free-user-post" class="modal modal-transparent fade" role="dialog">        
        <div class="col-md-offset-1 col-md-10 post">
            <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
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
                                </div>
                                <div class="col-md-12 bg-white">                                    
                                    <div class="col-md-offset-1">
                                        <div class="col-md-2 user-photo">
                                            <?php
                                            $current_user = get_user_data(osc_logged_user_id());

                                            if (!empty($current_user['s_path'])):
                                                $img_path = osc_base_url() . $current_user['s_path'] . $current_user['pk_i_id'] . '.' . $current_user['s_extension'];
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
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                <div class="col-md-4 padding-0">
                                                    <h4 class="bold"><?php echo $current_user['user_name'] ?>                                              
                                                        <?php if ($current_user['user_type'] != 0): ?>
                                                            <img class="vertical-top col-md-1 star img img-responsive" src="<?php echo $user_type_image_path ?>">
                                                        <?php endif ?>
                                                    </h4>
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

                                    <div class="col-md-12 vertical-row">
                                        <div class="col-md-offset-1 col-md-11 padding-top-3per">
                                            <!--                                        <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>
                                                                                    <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>-->
                                        </div>
                                    </div>
                                </div>

                                <!-------------------------User Information End---------------------------->
                                <div class="breack-line"> &nbsp; </div>
                                <!-------------------------General Information Start---------------------------->
                                <div class="bg-white">                            
                                    <div class="center-contant  padding-top-10">
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
                                            <input type="text" placeholder="Title" class="p_title" name="p_title" value="<?php echo $post_desc['s_title'] ?>"> <span class="error-title red">Post Title Required</span>
                                        </div>                              
                                    </div>                        
                                </div>

                                <!-------------------------General Information end---------------------------->
                                <div class="breack-line"></div>
                                <!-------------------------Add Media Start---------------------------->
                                <div class="col-md-12 padding-top-4per bg-white">         
                                    <div class="center-contant">                                        
                                        <div class="col-md-1 padding-0">
                                            <img src="<?php echo $img_path; ?>" alt="user" width='40px' >
                                        </div>

                                        <div class="box-shadow-none width-90 description-box col-md-8 padding-0">
                                            <textarea placeholder="What's on your mind?" name="p_disc" class="p_disc" name="p_disc"><?php echo $post_desc['s_description'] ?></textarea><span class="error-desc red">Post Description Required</span>
                                        </div>
                                    </div>
                                    <div class="border-bottom col-md-12">                 
                                    </div>

                                    <div class="center-contant">
                                        <div class="col-md-12 padding-10 vertical-row">
                                            <i class="fa fa-picture-o col-md-1" aria-hidden="true" ></i> 
                                            <span class="padding-left-10 col-md-10"> Update media(Image/GIF/Video) </span>
                                            <span class="col-md-1 pointer padding-0" data-toggle="collapse" data-target="#media"><i class="fa fa-angle-down pull-right " aria-hidden="true"></i></span>
                                        </div>
                                        <div id="media" class="collapse">                                            
                                            <div class=" col-md-12 border-bottom"></div>
                                            <div class="padding-top-3per col-md-12">
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
                                        </div>
                                    </div>
                                    <div class="border-bottom col-md-12">                 
                                    </div>
                                    <div class="center-contant padding-bottom-20">    
                                        <div class="col-md-12 padding-10 vertical-row">
                                            <i class="fa fa-map-marker col-md-1" aria-hidden="true"></i>                        
                                            <span class="padding-left-10 col-md-10"> Update location(Country/state/region/City/place) </span>
                                            <span class="col-md-1 pointer padding-0" data-toggle="collapse" data-target="#location"><i class="fa fa-angle-down pull-right " aria-hidden="true"></i></span>
                                        </div>
                                        <div id="location" class="collapse padding-bottom-20">                                              
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
                                    </div>
                                </div>
                            </div>
                            <!-------------------------Location end------------------------------>
                            <div class="breack-line"></div></div>
                        <!-------------------------Reminder start------------------------------>

                        <!-------------------------Finalisation Start------------------------------>
                        <div class="finalisation-info bg-white padding-3per col-md-12">
                            <div class="vertical-row col-md-offset-1">
                                <div class="en-savoir-plus1 publier1 col-md-3">
                                    <button type="submit" class="en-savoir-plus-button publier-btn pull-left">
                                        <span class="bold">Publier</span></button>
                                </div>
                                <div class="onoffswitch col-md-3">
                                    <input type="checkbox" name="publier" class="onoffswitch-checkbox" id="publier">
                                    <label class="onoffswitch-label" for="publier"></label>
                                </div>   <span class="">I accept addition requirement</span>                 
                                <div class="col-md-2">
                                    <span class="error-term red">Please Accept Term & Condition</span>
                                </div>
                                <div class="col-md-3">
                                    <span class="error-btn red">Please Fill All Required Field</span>
                                </div>
                            </div>
                        </div>
                        <!-------------------------Finalisation End------------------------------>

                    </form>
                </div>
            </div>

        </div>
    </div>
<?php endif; ?>
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
</script>
