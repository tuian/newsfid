<?php
require_once '../../../oc-load.php';
require_once 'functions.php';
?>
<!---- modal popup for free user post start------>

<!-- Modal -->
<div id="popup-free-user-post" class="modal modal-transparent fade" role="dialog">
    <div class="col-md-offset-1 col-md-10">
        <div class="large-modal">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="<?php echo osc_current_web_theme_url('post_add.php'); ?>" enctype="multipart/form-data">
                    <!--<input type="hidden" name="save" value="true">-->
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
                                <div class="input-text-area margin-top-20 left-border box-shadow-none width-60">
                                    <input type="text" placeholder="Title" name="p_title">
                                </div>
                                <div class="box-shadow-none width-90 description-box">
                                    <textarea placeholder="Redigez la description ici..." name="p_disc"></textarea>
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
                                        <div class="col-md-12">
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
                                    <!--                                <?php $counrty_array = get_country_array(); ?>
                                                                    <select id="country-list" style="box-shadow: none;">
                                                                        <option value="Country">&nbsp;Country</option>
                                    <?php
                                    foreach ($counrty_array as $countryList):
                                        ?>
                                                                                                                                                                                                                                                                        <option  value="<?php echo $countryList['s_name']; ?>">  <?php echo $countryList['s_name']; ?> </option>
                                        <?php
                                    endforeach;
                                    ?>
                                                                    </select><i class="icon-chevron-down"></i>-->
                                    <?php UserForm::country_select(osc_get_countries()); ?>
                                </div>

                                <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30">
                                    <input type="text" id="s_region_name" name="s_region_name" placeholder="Region">
                                    <input type="hidden" id="s_region_id" name="s_region_id">
                                </div>
                                <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30">
                                    <input type="text" name="s_city_name" class="form-control" id="s_city_name" placeholder="City">
                                    <input type="hidden" name="s_city_id" class="form-control" id="s_city_id">
                                </div>
                                <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30">
                                    <input type="text" placeholder="City Area" id="s_city_area_name" name="s_city_area_name">
                                </div>
                                <div class="input-text-area left-border margin-top-20 box-shadow-none width-60 margin-left-30">
                                    <input type="text" name="s_address" id="s_address" placeholder="Address">
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
                                <input type="checkbox" name="publier" class="onoffswitch-checkbox" id="publier">
                                <label class="onoffswitch-label" for="publier"></label>
                            </div>
                            <div class=" col-md-6">
                                <p>
                                    I accept the terms of use and additional requirements related to the use of newsfid service. One case of conflict with my content I agree to be solely responsible for and agree that newsfid and its partners are not responsible at all.
                                </p>
                            </div>




                        </div>
                        <div class="modal-footer ">
                            <div class="en-savoir-plus publier col-md-offset-1 col-md-3">
                                <button type="submit" class="en-savoir-plus-button publier-btn"><span class="bold">Publier<span></button>
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
                                            </div>
                                            <!----free user post end------->
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