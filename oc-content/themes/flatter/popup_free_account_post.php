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
                                    <option value=""><?php _e('Category', 'flatter'); ?></option>
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
                        <div class="input-text-area margin-top-20 box-shadow-none width-60">
                            <input type="text" placeholder="Title">
                        </div>
                        <div class="box-shadow-none width-90 description-box">
                            <textarea placeholder="Redigez la description ici..."></textarea>
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
                        <div class="border-bottom col-md-12">
                            <img class="vertical-top col-md-1" src="<?php echo osc_current_web_theme_url() . '/images/info.png' ?>" width="50px" height="45px" style="margin-left: 10px; margin-top:10px;">
                            <p class="col-md-10">
                                A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera la difference avec les autres utilisateurs.
                            </p>
                        </div>
                        <div class="border-bottom col-md-12">
                            <img class="vertical-top col-md-1" src="<?php echo osc_current_web_theme_url() . '/images/filters.png' ?>" width="50px" height="45px" style="margin-left: 10px; margin-top:10px;">
                            <span class="orange col-md-1"><h3 class="bold">Filters</h3></span>
                        </div>
                        <div class=" col-md-12 border-bottom">
                            <div class="col-md-2 margin-top-20">
                                <span class="bold">Image</span>
                             </div>
                             
                             <div class="col-md-2 margin-top-20">
                                 <span class="bold">Video</span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Liens)</span>
                             </div>
                            <div class="col-md-8">
                                 <p>
                                     A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera la difference avec les autres utilisateurs.
                                 </p>
                            </div>
                            <div class="col-md-4 media-video-image">
                                <div class="onoffswitch margin-top-20 col-md-5">
                                    <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" checked>
                                    <label class="onoffswitch-label" for="image"></label>
                                </div>
                                 
                           
                                <div class="col-md-3 ou" style="text-align: center">ou</div>
                             
                                 <div class="onoffswitch margin-top-20 col-md-3">
                                    <input type="checkbox" name="video" class="onoffswitch-checkbox" id="video">
                                    <label class="onoffswitch-label" for="video"></label>
                                </div>
                        </div>   
                      
                        <div class="col-md-12">
                            <div class=" col-md-offset-1 margin-bottom-20">
                            <img class="vertical-top" src="<?php echo osc_current_web_theme_url() . '/images/camera.png' ?>" width="80px" height="80px" style="margin-left: -3px; margin-top:30px;">
                            </div>
                        </div>
                          </div> 
                        <div class=" col-md-12 border-bottom">
                            <div class="col-md-2 margin-top-20">
                                <span class="bold">GIF</span>
                            </div>
                            <div class="col-md-offset-2 col-md-8">
                                 <p>
                                     A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera la difference avec les autres utilisateurs.
                                 </p>
                            </div>
                            <div class="col-md-4 media-video-image">
                                <div class="onoffswitch margin-top-20 col-md-5">
                                    <input type="checkbox" name="gif" class="onoffswitch-checkbox" id="gif">
                                    <label class="onoffswitch-label" for="gif"></label>
                                </div>
                        </div>   
                     </div>
                         <div class=" col-md-12 border-bottom">
                            <div class="col-md-2 margin-top-20">
                                <span class="bold">Music</span>
                            </div>
                            <div class="col-md-offset-2 col-md-8">
                                 <p>
                                     A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera la difference avec les autres utilisateurs.
                                 </p>
                            </div>
                            <div class="col-md-4 media-video-image">
                                <div class="onoffswitch margin-top-20 col-md-2">
                                    <input type="checkbox" name="music" class="onoffswitch-checkbox" id="music">
                                    <label class="onoffswitch-label" for="music"></label>
                                </div>
                                <div class="col-md-10 mp3-max">
                                    <span class="">(MP3 10.MO maximum) </span>
                                </div>
                        </div>   
                     </div>
                         <div class=" col-md-12 border-bottom">
                            <div class="col-md-2 margin-top-20">
                                <span class="bold">Podcast</span>
                            </div>
                            <div class="col-md-offset-2 col-md-8">
                                 <p>
                                     A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera la difference avec les autres utilisateurs.
                                 </p>
                            </div>
                            <div class="col-md-4 media-video-image">
                                <div class="onoffswitch margin-top-20 col-md-5">
                                    <input type="checkbox" name="podcast" class="onoffswitch-checkbox" id="podcast">
                                    <label class="onoffswitch-label" for="podcast"></label>
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
                    <div class="col-md-offset-1 col-md-10 margin-top-20">
                        <div class="border-bottom col-md-12 margin-top-20 padding-bottom-20">
                            <img class="vertical-top col-md-1" src="<?php echo osc_current_web_theme_url() . '/images/info.png' ?>" width="50px" height="45px" style="margin-left: 10px; margin-top:10px;">
                            <p class="col-md-10">
                                A tout moment vous pouvez faire un portate de compte pour passer de l'offre gratuite a l'offre avec abonnement. Cela vous permettra de publier de sans plus aucune limitation de contenu et d'optenir un marquage visuel qui fera la difference avec les autres utilisateurs.
                            </p>
                        </div>
                    </div>
                </div>
                <!-------------------------Location end------------------------------>
            </div>

        </div>
    </div>
</div>
<!----free user post end------->
