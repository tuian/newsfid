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
                <div class="breack-line"></div>
                 <div class="genral-info round-border">
                     <div class="modal-header">
                        <h3 class="modal-title bold orange">General Information </h3>
                      </div>
                     <div class="col-md-offset-1">
                         <div class="category-dropdown" style="display: block;">
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
                     </div>
                </div>
            </div>
           
        </div>
    </div>
</div>
<!----free user post end------->
