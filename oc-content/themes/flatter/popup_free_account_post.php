<?php
require_once '../../../oc-load.php';
require_once 'functions.php';
?>
<!---- modal popup for free user post start------>

<!-- Modal -->
<div id="popup-free-user-post" class="modal fade" role="dialog">
    <div class="col-md-offset-1 col-md-10">
        <div class="large-modal">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="<?php echo osc_current_web_theme_url('post_add.php'); ?>" enctype="multipart/form-data">
                    <!--<input type="hidden" name="save" value="true">-->
                    <!-------------------------User Information Start---------------------------->
                    <div class="modal-body greybg">
                        <div class="sub">
                            <div class="col-md-12">
                                <h1 class="bold big-font col-md-12">Publier librement sur Newsfid</h1>
                                <p class="col-md-7" style="margin-left: -10px;">
                                    A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera la difference avec les autres utilisateurs.
                                </p>
                            </div>
                        </div><div class="clear"></div>
                        <div class="col-md-2 ">
                            <?php
                            $current_user = get_user_data(osc_logged_user_id());

                            if (!empty($current_user[0]['s_path'])):
                                $img_path = osc_base_url() . '/' . $current_user[0]['s_path'] . $current_user[0]['pk_i_id'] . '.' . $current_user[0]['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>

                            <img src="<?php echo $img_path; ?>" alt="user" class="img img-responsive">
                        </div> 
                        <div class="user-info col-md-6">
                            <h5><?php echo $current_user[0]['user_name'] ?><img class="vertical-top" src="<?php echo osc_current_web_theme_url() . '/images/start-box.png' ?>" width="16px" height="16px" style="margin-left: 10px"></h5>
                            <h5>Vous avez deja <span style="color:orangered"><?php echo get_user_posts_count($current_user[0]['user_id']) ?></span> publication</h5>
                        </div>
                        <div class="en-savoir-plus col-md-3">
                            <button class="en-savoir-plus-button">En savoir plus</button>
                        </div>


                    </div>
                    <div class="clear"></div>
                    <div class="col-md-offset-1 user-data">
                        <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>
                        <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>
                    </div>
                    <!-------------------------User Information End---------------------------->
                    <div class="breack-line"></div>
                    <!-------------------------General Information Start---------------------------->
                    <div class="genral-info round-border-top">
                        <div class="modal-header">
                            <h3 class="modal-title bold orange">General Information </h3>
                        </div>
                        <div class="col-md-offset-1">
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
                        <div class="modal-footer">
                        </div>


                    </div>
                    <!-------------------------General Information end---------------------------->
                    <div class="breack-line"><div class=" round-border-bottom"></div></div>
                    <!-------------------------Add Media Start---------------------------->
                    <div class="media-info round-border-top">
                        <div class="modal-header">
                            <h3 class="modal-title bold orange">Add a Media </h3>
                        </div>
                        <div class="col-md-offset-1 col-md-10 margin-top-20">
                            <div class="border-bottom col-md-12 vertical-row">
                                <div class="col-md-1">
                                    <img class="vertical-top img img-responsive" src="<?php echo osc_current_web_theme_url() . '/images/info.png' ?>" width="50px" height="45px" style="margin-left: 10px; margin-top:10px;">
                                </div>
                                <div class="col-md-11">
                                    A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera la difference avec les autres utilisateurs.
                                </div>
                            </div>
                            <div class="border-bottom col-md-12 vertical-row">
                                <div class="col-md-1">
                                    <img class="vertical-top img img-responsive" src="<?php echo osc_current_web_theme_url() . '/images/filters.png' ?>" width="50px" height="45px" style="margin-left: 10px; margin-top:10px;">
                                </div>
                                <span class="orange col-md-1"><h3 class="bold">Filters</h3></span>
                            </div>
                            <div class=" col-md-12 border-bottom vertical-row">
                                <div class="col-md-6">
                                    <div class="col-md-12 padding-10 vertical-row">
                                        <div class="col-md-3"> <span class="bold">Image</span>
                                            <div class="onoffswitch margin-top-20">
                                                <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" checked>
                                                <label class="onoffswitch-label" for="image"></label>
                                            </div>
                                        </div><div class="col-md-1">ou</div>
                                        <div class="col-md-3"><span class="bold">Video</span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Liens)</span>
                                            <div class="onoffswitch margin-top-20">
                                                <input type="checkbox" name="video" class="onoffswitch-checkbox" id="video">
                                                <label class="onoffswitch-label" for="video"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 vertical-row">
                                        <div class="col-md-offset-1 col-md-4">
                                            <!--<img class="vertical-top camera-icon img img-responsive" src="<?php echo osc_current_web_theme_url() . '/images/camera.png' ?>">-->
                                            <div class="post_file_upload_container" style="background-image: url('<?php echo osc_current_web_theme_url() . '/images/camera.png' ?>')">
                                                <input type="file" name="photos[]" id="photos" placeholder="Address">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6  text-bg-color">
                                    <div class="bold padding-10">
                                        Vous ne pouvez pas choisir lee deux en meme
                                        temps. Vous pubiiez soit une Image .JPG I PNG I
                                        colt un liens video (Youtubel Daylinotion I Vimio)
                                    </div>
                                </div>



                                <!--                                
                                                                <div class="col-md-4 media-video-image">
                                                                    
                                
                                
                                                                    <div class="col-md-3 ou" style="text-align: center">ou</div>
                                
                                                                   
                                                                </div>   -->

                                <!--                                <div class="col-md-12 vertical-row">
                                                                    <div class=" col-md-offset-1 margin-bottom-20">
                                
                                                                        
                                                                    </div>
                                                                </div>-->
                            </div> 
                            <div class=" col-md-12 border-bottom vertical-row">
                                <div class="col-md-6">
                                    <span class="bold">GIF</span>
                                    <div class="onoffswitch margin-top-20">
                                        <input type="checkbox" name="gif" class="onoffswitch-checkbox" id="gif">
                                        <label class="onoffswitch-label" for="gif"></label>
                                    </div>
                                </div>
                                <div class="col-md-6  text-bg-color">
                                    <div class="bold padding-10">
                                        L’image commencera I s’animer de manière automatique au survol de votre publication.
                                    </div>
                                </div>
                            </div>
                            <div class=" col-md-12 border-bottom vertical-row">
                                <div class="col-md-6">
                                    <span class="bold">Music</span>
                                    <div class="onoffswitch margin-top-20">
                                        <input type="checkbox" name="music" class="onoffswitch-checkbox" id="music">
                                        <label class="onoffswitch-label" for="music"></label>
                                    </div>
                                    <div class="mp3-max">
                                        <span class="">(MP3 10.MO maximum) </span>
                                    </div>
                                </div>
                                <div class="col-md-6 text-bg-color">
                                    <div class="bold padding-10">
                                        Vous ne pouvez télecharger qu’un fichier MP3. Si vos désirez publier un fichier supeneur I 1OMO merci e vous abonner I Newefid
                                    </div>
                                </div>
                            </div>
                            <div class=" col-md-12 border-bottom vertical-row">
                                <div class="col-md-6">
                                    <span class="bold">Podcast</span>
                                    <div class="onoffswitch margin-top-20">
                                        <input type="checkbox" name="podcast" class="onoffswitch-checkbox" id="podcast">
                                        <label class="onoffswitch-label" for="podcast"></label>
                                    </div>
                                </div>
                                <div class="col-md-6 text-bg-color">
                                    <div class="bold padding-10">
                                        A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera la difference avec les autres utilisateurs.

                                    </div>
                                </div>


                            </div>
                            <!-- <div class="col-md-5">
                                 
                             </div>-->

                        </div>
                    </div>
                    <!-------------------------Add Media end------------------------------>
                    <div class="breack-line"><div class="round-border-bottom"></div></div>

                    <!-------------------------Location Start------------------------------>
                    <div class="location-info round-border-top">
                        <div class="modal-header">
                            <h3 class="modal-title bold orange">Location </h3>
                        </div>
                        <div class="modal-header">
                            <div class="col-md-offset-1 col-md-10 margin-top-20">
                                <div class="col-md-12 margin-top-20 padding-bottom-20">
                                    <div class="col-md-1">
                                        <img class="vertical-top  img img-responsive" src="<?php echo osc_current_web_theme_url() . '/images/info.png' ?>" width="50px" height="45px" style="margin-left: 10px; margin-top:10px;">
                                    </div>
                                    <div class="col-md-10 padding-10">
                                        A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera la difference avec les autres utilisateurs.
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
                    <div class="breack-line"><div class="round-border-bottom"></div></div>
                    <!-------------------------Reminder start------------------------------>
                    <div class="modal-body greybg round-border-top">
                        <div class="sub">
                            <div class="col-md-12">
                                <h1 class="bold big-font col-md-12">Bon a Savior</h1>
                                <p class="col-md-7" style="margin-left: -10px;">
                                    A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera la difference avec les autres utilisateurs.
                                </p>
                            </div>
                        </div><div class="clear"></div>
                        <div class="user-photo col-md-2">
                            <?php
                            $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            ?>
                            <img src="<?php echo $img_path; ?>" alt="user"" width="100px" height="100px">
                        </div> 
                        <div class="user-info col-md-6">
                            <h5>Gwinel Madlisse<img class="vertical-top" src="<?php echo osc_current_web_theme_url() . '/images/start-box.png' ?>" width="16px" height="16px" style="margin-left: 10px"></h5>
                            <h5>Vous avez deja <span style="color:orangered">365</span> publication</h5>
                        </div>
                        <div class="en-savoir-plus-gry col-md-3">
                            <button class="en-savoir-plus-button-gry">En savoir plus</button>
                        </div>


                    </div>
                    <div class="clear"></div>
                    <div class="col-md-offset-1 user-data">
                        <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>
                        <h5>A tout moment vous pouvez faire un portate de compte pour passer</h5>
                    </div>
                    <!-------------------------Reminder end------------------------------>
                    <div class="breack-line"><div class="round-border-bottom"></div></div>
                    <!-------------------------Finalisation Start------------------------------>
                    <div class="finalisation-info round-border-top">
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
                                    A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera.
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
                                                            var c_id = $('#countryId').val();
                                                            if (c_id) {
                                                                $items = [""];
                                                                $.ajax({
                                                                    url: "<?php echo osc_current_web_theme_url('city_ajax.php') ?>",
                                                                    dataType: "json",
                                                                    type: "POST",
                                                                    data: {city_name: query, country_id: c_id},
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
                                                            $('#sRegion').val(obj.id);
                                                        },
                                                    });
                                                });
                                            </script>


