<?php
require_once '../../../oc-load.php';
require_once 'functions.php';
?>
<!---- modal popup for free user post start------>

<!-- Modal -->
<div id="popup-free-user-post" class="modal modal-transparent fade" role="dialog">
    <div class="col-md-offset-1 col-sm-offset-1 col-sm-10 col-md-10 post">
        <button type="button" class="close" data-dismiss="modal">&times;</button>-->
        <div class="large-modal">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" id="post_add" action="<?php echo osc_current_web_theme_url('post_add.php'); ?>" enctype="multipart/form-data">
                    <!--<input type="hidden" name="save" value="true">-->
                    <!-------------------------User Information Start---------------------------->

                    <div class="modal-body padding-0">
                        <div class="col-md-12 col-sm-12 padding-0">
                            <div class="greybg padding-top-3per">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 bg-white">                       
                        <div class="col-md-offset-1 col-sm-offset-1">
                            <div class="col-md-2 col-sm-2 user-photo">
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
                            <div class="col-md-6 col-sm-6">
                                <div class="col-md-12 col-sm-12">
                                    <div class="col-md-4 col-sm-4 padding-0">
                                        <h4 class="bold vertical-row"><?php echo $current_user['user_name']; ?>                                     
                                            <?php if ($current_user['user_type'] != 0): ?>
                                                <img class="star img img-responsive" src="<?php echo $user_type_image_path ?>">
                                            <?php endif ?>
                                        </h4> 
                                    </div>                                      

                                </div>
                                <div class="col-md-12 col-sm-12 vertical-row">
                                    <h5 class=" margin-0"><?php _e("You have already", 'flatter') ?>   <span style="color:orangered"><?php echo get_user_posts_count($current_user['user_id']) ?></span>  <?php _e(" publication", 'flatter') ?>  </h5>
                                </div>


                            </div>
                            <div class="col-md-4 col-sm-4 padding-top-4per">
                                <div class="col-md-offset-4">
                                    <a href="<?php echo osc_current_web_theme_url('subscribe.php'); ?>" class="en-savoir-plus-button-orng"> <?php _e("Get more details", 'flatter') ?> </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12  vertical-row">
                            <div class="col-md-offset-1 col-sm-offset-1 col-md-11 col-sm-11 padding-top-3per">
                                <!--                                        <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>
                                                                        <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>-->
                            </div>
                        </div>
                    </div>

                    <!-------------------------User Information End---------------------------->
                    <div class="breack-line"> &nbsp; </div>
                    <!-------------------------General Information Start---------------------------->
                    <div class="bg-white">
                        <div class="center-contant padding-top-10">
                            <div class="category-dropdown left-border width-50" style="display: block;">
                                <?php osc_goto_first_category(); ?>
                                <?php if (osc_count_categories()) { ?>
                                    <select id="mCategory" class="form-control input-box" name="sCategory">
                                        <option value=""><?php _e('Category *', 'flatter'); ?></option>
                                        <?php while (osc_has_categories()) { ?>
                                            <option class="maincat" value="<?php echo osc_category_id(); ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo osc_category_name(); ?></option>                                    
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                            </div><span class="error-mcat red"><?php _e("Please select category", 'flatter') ?></span>
                            <div class="category-dropdown left-border width-50 margin-top-10" style="display: block;">
                                <?php osc_goto_first_category(); ?>
                                <?php if (osc_count_categories()) { ?>
                                    <select id="sCategory" class="form-control input-box" name="sCategory">
                                        <option value=""><?php _e('&nbsp; Rubrics *', 'flatter'); ?></option> 
                                        <?php while (osc_has_categories()) { ?>
                                            <?php while (osc_has_subcategories()) { ?>
                                                <option class="subcat margin-left-30" value="<?php echo osc_category_id(); ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo osc_category_name(); ?></option>
                                            <?php } ?>                                           
                                        <?php } ?>                                      
                                    </select>
                                <?php } ?>

                            </div><span class="error-scat red"><?php _e("Please select rubrics", 'flatter') ?></span>
                            <div class="input-text-area margin-top-10 padding-bottom-20 left-border box-shadow-none width-50">
                                <input type="text" placeholder="Title" name="p_title" class="p_title"><span class="error-title red"><?php _e("Post Title Required", 'flatter') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="breack-line"></div>

                    <!-------------------------General Information end---------------------------->

                    <!-------------------------Add Media Start---------------------------->
                    <div class="col-md-12 col-sm-12 padding-top-4per bg-white">            
                        <div class="center-contant">
                            <div class="col-md-1 col-sm-1 padding-0">
                                <img src="<?php echo $img_path; ?>" alt="user" width='40px' >
                            </div>
                            <div class="box-shadow-none width-90 description-box col-md-8 col-sm-8 padding-0">
                                <textarea placeholder="<?php _e("What's on your mind?", 'flatter') ?>" name="p_disc" class="p_disc"></textarea><span class="error-desc red"><?php _e("Post Description Required", 'flatter') ?></span>
                            </div>
                        </div>
                        <div class="border-bottom col-md-12 col-sm-12">                 
                        </div>  
                        <div class="center-contant">
                            <div class="col-md-12 col-sm-12 padding-10 vertical-row pointer" data-toggle="collapse" data-target="#media">
                                <i class="fa fa-picture-o col-md-1 col-sm-1" aria-hidden="true" ></i> 
                                <span class="padding-left-10 col-md-10 col-sm-10"><?php _e("Add media(Image/GIF/Video) ", 'flatter') ?> </span>
                                <span class="col-md-1 col-sm-1 pointer padding-0"><i class="fa fa-angle-down pull-right " aria-hidden="true"></i></span>
                            </div>
                            <div id="media" class="collapse">
                                <div class="col-md-12 col-sm-12 border-bottom"></div>
                                <div class="padding-top-3per col-sm-12 col-md-12">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="col-md-12 col-sm-12 vertical-row center-contant">
                                            <div class="col-md-2 col-sm-2"> <span class="bold"><?php _e("Image", 'flatter') ?></span>
                                                <div class="onoffswitch">
                                                    <input type="checkbox" name="post_type" class="onoffswitch-checkbox post_type_switch" data_post_type="image" id="image" value="image">
                                                    <label class="onoffswitch-label" for="image"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-1 ou"><?php _e("or", 'flatter') ?></div>
                                            <div class="col-md-2"><span class="bold"><?php _e("Video", 'flatter') ?></span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php _e("Liens", 'flatter') ?>)</span>
                                                <div class="onoffswitch">
                                                    <input type="checkbox" name="post_type" class="onoffswitch-checkbox post_type_switch" data_post_type="video" id="video" value="video">
                                                    <label class="onoffswitch-label" for="video"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 padding-top-8per">
                                            <div class="col-md-offset-1 col-sm-offset-1 col-sm-10 col-md-4">
                                                <!--<img class="vertical-top camera-icon img img-responsive" src="<?php echo osc_current_web_theme_url() . '/images/camera.png' ?>">-->
                                                <div class="post_file_upload_container" style="background-image: url('<?php echo osc_current_web_theme_url() . '/images/camera.png' ?>')">
                                                    <input type="file" name="post_media" accept="image/*"  onchange="showimage(this)" id="post_media" class="post_media" placeholder="<?php _e("Add your embedding code here", 'flatter') ?>">
                                                    <img id="thumbnil" src="" alt="image"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 text-bg-color">
                                        <div class="bold padding-10">
                                            <?php _e("You can not choose both at the same time
                                            you can publish  image or a video link.", 'flatter') ?>

                                        </div>
                                    </div>
                                </div> 
                                <div class=" col-md-12 col-sm-12 border-bottom">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="bold"><?php _e("GIF", 'flatter') ?></span>
                                        <div class="onoffswitch margin-top-20">
                                            <input type="checkbox" name="post_type" class="onoffswitch-checkbox post_type_switch" data_post_type="gif" id="gif" value="gif">
                                            <label class="onoffswitch-label" for="gif"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 text-bg-color">
                                        <div class="bold padding-10">
                                            <?php _e("The image begins to automatically animate when the user will scroll.", 'flatter') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-12 col-sm-12 border-bottom">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="bold"><?php _e("Music", 'flatter') ?></span>
                                        <div class="onoffswitch margin-top-20">
                                            <input type="checkbox" name="post_type" class="onoffswitch-checkbox post_type_switch" data_post_type="music" id="music" value="music">
                                            <label class="onoffswitch-label" for="music"></label>
                                        </div>
                                        <div class="mp3-max">
                                            <span class=""><?php _e("(MP3 10.MO maximum)", 'flatter') ?> </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 text-bg-color">
                                        <div class="bold padding-10">
                                            <?php _e("You can download only mp3 files. If you wish to publish mp3  bigger than 10mo thank you to subscribe.", 'flatter') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-12 col-sm-12">
                                    <div class="col-md-6 col-sm-6">
                                        <span class="bold"><?php _e("Podcast", 'flatter') ?></span>
                                        <div class="onoffswitch margin-top-20">
                                            <input type="checkbox" name="post_type" class="onoffswitch-checkbox post_type_switch" data_post_type="podcast" id="podcast" value="podcast">
                                            <label class="onoffswitch-label" for="podcast"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 text-bg-color">
                                        <div class="bold padding-10">
                                            <?php _e(" Your podcast must be a mp3 file. I you wish to publish a file bigger than 100mo thank you to subscribe.", 'flatter') ?>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="border-bottom col-md-12 col-sm-12">                 
                        </div>
                        <div class="center-contant padding-bottom-20">    
                            <div class="col-md-12 col-sm-12 padding-10 vertical-row pointer" data-toggle="collapse" data-target="#location">
                                <i class="fa fa-map-marker col-md-1 col-sm-1" aria-hidden="true"></i>                        
                                <span class="padding-left-10 col-md-10 col-sm-10"> <?php _e("Add location(Country/state/region/City/place)", 'flatter') ?>  </span>
                                <span class="col-md-1 col-sm-1 pointer padding-0"><i class="fa fa-angle-down pull-right " aria-hidden="true"></i></span>
                            </div>
                            <div id="location" class="collapse padding-bottom-20">  
                                <div class="border-bottom col-md-12">                 
                                </div>

                                <div class="col-md-offset-1 col-sm-offset-1 col-md-10 col-sm-10">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="col-md-1 col-sm-1">
                                            <img class="vertical-top  img img-responsive" src="<?php echo osc_current_web_theme_url() . '/images/info.png' ?>" width="50px" height="45px" style="margin-left: 10px; margin-top:10px;">
                                        </div>
                                        <div class="col-md-10 col-sm-10 padding-10">
                                            <?php _e("This step is not mandatory but nevertheless important to improve your publication in our search engine.", 'flatter') ?>
                                        </div>
                                    </div>
                                    <div class="border-bottom col-md-12 col-sm-12">                 
                                    </div>
                                </div><div class="clear"></div>

                                <div class="col-md-offset-2 col-sm-offset-2 col-md-10 col-sm-10 padding-bottom-20">
                                    <div class="input-text-area left-border margin-top-20 box-shadow-none country-select width-60 margin-left-30">                                  
                                        <?php UserForm::country_select(array_slice(osc_get_countries(), 1, -1)); ?>
                                    </div>
                                    <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30">
                                        <input type="text" id="s_region_name" name="s_region_name" placeholder="<?php _e("Region", 'flatter') ?>">
                                        <input type="hidden" id="s_region_id" name="s_region_id">
                                    </div>
                                    <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30">
                                        <input type="text" name="s_city_name" class="form-control" id="s_city_name" placeholder="<?php _e("City", 'flatter') ?>">
                                        <input type="hidden" name="s_city_id" class="form-control" id="s_city_id">
                                    </div>
                                    <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30">
                                        <input type="text" placeholder="<?php _e("City Area", 'flatter') ?>" id="s_city_area_name" name="s_city_area_name">
                                    </div>
                                    <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30">
                                        <input type="text" name="s_address" id="s_address" placeholder="<?php _e("Address", 'flatter') ?>">
                                    </div>
                                </div>                        
                            </div>
                        </div>
                        <!-- <div class="col-md-5">
                             
                         </div>-->


                    </div>
                    <!-------------------------Add Media end------------------------------>
                    <div class="breack-line"></div>


                    <!-------------------------Finalisation Start------------------------------>
                    <div class="finalisation-info bg-white padding-3per col-md-12 col-sm-12">
                        <div class="vertical-row col-md-offset-1 col-sm-offset-1">
                            <div class="en-savoir-plus1 publier1 col-md-3">
                                <button type="submit" class="en-savoir-plus-button publier-btn pull-left">
                                    <span class="bold"><?php _e("Publier", 'flatter') ?></span></button>
                            </div>
                            <div class="onoffswitch col-md-3 col-sm-3">
                                <input type="checkbox" name="publier" class="onoffswitch-checkbox" id="publier">
                                <label class="onoffswitch-label" for="publier"></label>
                            </div>   <span class=""><?php _e("I accept addition requirement", 'flatter') ?></span>                 
                            <div class="col-md-2 col-sm-2">
                                <span class="error-term red"><?php _e("Please Accept Term & Condition", 'flatter') ?></span>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <span class="error-btn red"><?php _e("Please Fill All Required Field", 'flatter') ?></span>
                            </div>
                        </div>
                    </div>
                    <!-------------------------Finalisation End------------------------------>

                </form>
            </div>
        </div>
    </div>
</div>

<!----free user post end------->
<script>
    $(document).on('click', '.post_file_upload_container', function () {
        $('.post_file_upload_container').css('background', 'none');
    });
    $('#thumbnil').hide();
    function showimage(fileInput) {
        var files = fileInput.files;
        $('#thumbnil').show();
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var img = document.getElementById("thumbnil");
            img.file = file;
            var reader = new FileReader();
            reader.onload = (function (aImg) {
                return function (e) {
                    aImg.src = e.target.result;
                };
            })(img);
            reader.readAsDataURL(file);
        }
    }
    $(document).ready(function () {
        $(document).on('change', '#mCategory', function () {
            var cat = $(this).val();
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('popup_ajax.php') ?>",
                type: 'post',
                data: {
                    maincategory: 'maincategory',
                    cat_id: cat
                },
                success: function (data) {
                    $('#sCategory').html(data);
                }
            });
        });
        $('.error-desc').hide();
        $('.error-title').hide();
        $('.error-term').hide();
        $('.error-btn').hide();
        $('.error-scat').hide();
        $('.error-mcat').hide();
        $('#post_add').submit(function () {
            var title = $('.p_title').val();
            var discription = $('.p_disc').val();
            var mcat = $('#mCategory option:selected').val();
            var scat = $('#sCategory option:selected').val();
            if (mcat !== '') {
                $('.error-mcat').hide();
            } else {
                $('.error-mcat').show();
                $('.error-btn').show();
                return false;
            }
            if (scat !== '') {
                $('.error-scat').hide();
            } else {
                $('.error-scat').show();
                $('.error-btn').show();
                return false;
            }
            if (title !== '') {
                $('.error-title').hide();
            } else {
                $('.error-title').show();
                $('.error-btn').show();
                return false;
            }
            if (discription !== '')
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
<script>
    $(document).ready(function () {
        $('#s_region_name').typeahead({
            source: function (query, process) {
                var $items = new Array;
                var c_id = $('#countryId').val();
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
                }
                //                                                            else {
                //                                                                alert('Please select country first');
                //                                                            }
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
                }
                //                                                            else {
                //                                                                alert('Please select region first');
                //                                                            }
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

        if (selected_post_type.attr('data_post_type') == 'image') {
            $('#post_media').attr('accept', 'image/*');
            $('#post_media').removeClass('media_video');
        } else if (selected_post_type.attr('data_post_type') == 'gif') {
            $('#post_media').attr('accept', 'image/gif');
            $('#post_media').removeClass('media_video');
        } else if (selected_post_type.attr('data_post_type') == 'music') {
            $('#post_media').attr('accept', 'audio/*');
            $('#post_media').removeClass('media_video');
        } else if (selected_post_type.attr('data_post_type') == 'video') {
            $('#post_media').attr('accept', 'video/*');
            $('#post_media').addClass('media_video');
        } else if (selected_post_type.attr('data_post_type') == 'podcast') {
            $('#post_media').attr('accept', 'podcast');
            $('#post_media').removeClass('media_video');
        }
    });
</script>