<?php
	// meta tag robots
    osc_add_hook('header','flatter_follow_construct');

    $address = '';
    if(osc_user_address()!='') {
        if(osc_user_city_area()!='') {
            $address = osc_user_address().", ".osc_user_city_area();
        } else {
            $address = osc_user_address();
        }
    } else {
        $address = osc_user_city_area();
    }
    $location_array = array();
    if(trim(osc_user_city()." ".osc_user_zip())!='') {
        $location_array[] = trim(osc_user_city()." ".osc_user_zip());
    }
    if(osc_user_region()!='') {
        $location_array[] = osc_user_region();
    }
    if(osc_user_country()!='') {
        $location_array[] = osc_user_country();
    }
    $location = implode(", ", $location_array);
    unset($location_array);

    osc_enqueue_script('jquery-validate');

    flatter_add_body_class('user-public-profile');
    osc_add_hook('before-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('user-public-sidebar.php');
    }
?>
<?php osc_current_web_theme_path('header.php') ; ?>


  <!-- profil cover -->

  <DIV id="cover" classe="cover" style=" 
  margin:0;
  padding:0; no-repeat center fixed; 
  -webkit-background-size: cover; /* pour anciens Chrome et Safari */
  background-size: cover; /* version standardisée */
  background-color: black;
  max-height: 580px;
  overflow: hidden; 
  ">

    <?php if (function_exists("profile_picture_show")) { ?>
                <?php profile_picture_show(); ?>


            <?php } else { ?>
                <img src="http://www.gravatar.com/avatar/<?php echo md5( strtolower( trim( osc_user_email() ) ) ); ?>?s=150&d=<?php echo osc_current_web_theme_url('images/user-default.jpg') ; ?>" class="img-responsive" />
            <?php } ?>





 


        </div>



            

  <!-- end profil cover -->





<div id="columns">
	<div class="container">
    	<div class="row profile-header clearfix">
        	<div class="col-sm-4 hidden-xs">
                <?php osc_run_hook('before-main'); ?>
            </div>
            <div class="col-sm-8">
            	<div class="profile-detail">
            	<h3 style="  color: black; "><?php echo osc_user_name(); ?></h3>
                <?php
                    $logged_in_user_id = osc_logged_user_id();
                    $follow_user_id = osc_user_id();                    
                ?>
                <?php if($logged_in_user_id != $follow_user_id): ?>
                    <div class="follow" data-current-user-id="<?php echo $logged_in_user_id ?>" data-follow-user-id="<?php echo $follow_user_id ?>"><i class="fa fa-users"></i> Follow</div>
                <?php endif; ?>
                    
                <?php if( $address !== '' || $location !== '' ) { ?><span><i class="glyphicon glyphicon-map-marker clr"></i> <?php printf(__('%1$s'), $location); ?></span><br class="visible-xs" /><?php } ?><?php if( osc_user_website() !== '' ) { ?><span><i class="fa fa-external-link clr"></i> <a href="<?php echo osc_user_website(); ?>" target="_blank" rel="nofollow"><?php echo osc_user_website(); ?></a></span><?php } ?>
                

                <small> <span >  <?php if(function_exists('useronline_show_user_status')) {useronline_show_user_status();} ?>       </span></small> 

                
                <?php if( osc_user_info() !== '' ) { ?>
                <div class="user-description">
                    <h5><?php _e('Description', 'flatter'); ?></h5>
                    <p><?php echo nl2br(osc_user_info()); ?></p>
                </div>
                <?php } ?>
                </div>
                
                <?php if( osc_count_items() > 0 ) { ?>
                <h3><?php echo osc_user_name(); ?>'s <?php _e('Listings', 'flatter'); ?></h3>
                <div class="searchpage">
                    <div id="content">
                    <?php osc_current_web_theme_path('loop.php'); ?>
                    </div>
                    <div class="pagination"><?php echo osc_pagination_items(); ?></div>
                </div>
                <?php } ?>
            </div>
            <!-- Only for Mobile View -->
            <div class="col-sm-4 visible-xs">
                <?php osc_run_hook('before-main'); ?>
            </div>
            
        </div>
    </div>
</div>

<?php osc_current_web_theme_path('footer.php') ; ?>