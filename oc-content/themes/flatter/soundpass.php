
<?php
require '../../../oc-load.php';
require 'functions.php';
?>
<?php osc_current_web_theme_path('header.php'); ?>

<!-- profile cover -->

<div class="soundpass-page bg-white">
    <div class="cover-img">
        <div class="container">
            <div class="min-height-300"></div>                
            <div class="col-md-8">                
                <h1 class="font-color-white bold-600 font-65px"><?php _e("Sound Pass", 'flatter') ?></h1>                
                <h5 class="font-color-white"><?php _e("Lorem Ipsum is simply dummy text", 'flatter') ?></h5>                
            </div>
        </div>
    </div>
    <div class="row padding-0 col-md-offset-1">
        <div class="contant  col-md-12">
            <div class="col-md-6 text-left padding-top-4per text-gray-dark">
                <?php _e("Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy textLorem Ipsum is simply dummy textLorem Ipsum is simply dummy textLorem Ipsum is simply dummy text", 'flatter') ?>
                
            </div>            
            <div class="col-md-4 padding-top-4per text-center">
                <button type="submit" class="btn btn-lg button-orng-box" data-toggle="modal" data-target="#payment"><?php _e("Activer sound Pass", 'flatter') ?></button>
            </div>                

        </div>
        <div class="col-md-12 padding-top-4per">
            <div class="col-md-5 text-left text-gray-dark">
                <?php _e("Lorem Ipsum is simply dummy text Lorem Ipsum ", 'flatter') ?>
            </div>               

        </div>
        <div class="col-md-12 text-right padding-left-8per">
            <div class="col-md-1 col-sm-2 col-xs-2 text-gray-dark">
                <?php _e("Lorem", 'flatter') ?> 
            </div> 
            <div class="col-md-1 col-sm-2 col-xs-2 text-gray-dark">
               <?php _e("Lorem", 'flatter') ?>  
            </div> 
            <div class="col-md-1 col-sm-2 col-xs-2 text-gray-dark">
                <?php _e("Lorem", 'flatter') ?>
            </div> 

        </div>

    </div>
    <div class="border-bottom-gray col-md-12 padding-top-4per"></div>
    <div class="col-md-12 white-bg padding-bottom-6per">
        <div class="col-md-offset-2 col-md-8 padding-top-4per">
            <div class="col-md-3">
                <div class="col-md-9">
                    <div class="img-user">
                        <img src="images/user1-128x128.jpg" class="img img-responsive img-circle">
                        <div class="star-img">
                            <img src="images/star.png" class="img img-responsive img-circle">
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
                <div class='col-md-12'>
                    <?php _e("Lorem Ipsum", 'flatter') ?>
                </div>
                <div class="col-md-12">
                    <?php _e("Lorem Ipsum is simply dummy textLorem Ipsum is simply dummy textLorem Ipsum is simply dummy textLorem Ipsum is simply dummy textLorem Ipsum is simply dummy text", 'flatter') ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end profil cover -->
<?php osc_current_web_theme_path('footer.php'); ?>