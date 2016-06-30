<?php osc_current_web_theme_path('header.php'); ?>
    
<?php if( osc_get_preference('pop_enable', 'flatter_theme') != '0') { ?>
<!-- Modal -->
<div class="modal fade" id="promo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close', 'flatter'); ?></span></button>
		<h4 class="modal-title" id="myModalLabel"><?php echo osc_get_preference('pop_heading', 'flatter_theme', "UTF-8"); ?></h4>
	  </div>
	  <div class="modal-body">
		<?php echo osc_get_preference('landing_pop', 'flatter_theme', "UTF-8"); ?>
	  </div>
	  
	</div>
  </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.min.js"></script>
<script type="text/javascript">
 $(window).load(function(){
	 if ($.cookie('pop') == null) {
		 $('#promo').modal('show');
		 $.cookie('pop', '1');
	 }
 });
</script>
<!-- Popup -->

 <!-- Slider -->  

<?php if( osc_is_web_user_logged_in() ) { ?>


 <?php if (function_exists("osc_slider")) { ?>
                  <?php osc_slider(); ?>
            <?php } ?>

   
  
              

            <?php } else { ?>


 <!-- slider -->
<div class="section" >

       <span style=   "position:absolute;
top:230px;
left:100px;
width:100px;
color: white;
font-weight: bold;
font-size: 5vw; 
text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.33);

background-color: none;
z-index:10;" > Newsfid </span>

       <span style=   "position:absolute;
top:315px;
left:100px;
width:1000px;
color: white;
font-size: 1vw; 
text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.33);

background-color: none;
z-index:10;" > News stories and even more </span>

  <DIV id="cover" classe="cover" style=" 
  margin:0;
  padding:0; no-repeat center fixed; 
  -webkit-background-size: cover; /* pour anciens Chrome et Safari */
  background-size: cover; /* version standardisée */
  background-color: black;
  max-height: 400px;
  overflow: hidden; 
  ">




                <img src="images/top.main.jpg" class="img-responsive" />
            <?php } ?>


</div>


 


        </div>


                    





<?php } ?>
    
    

<!-- Big Search -->
    

<!-- Homepage widget 1 -->








   <?php if( osc_is_web_user_logged_in() ) { ?>
                                                   
                


    <div class="bigsearch transbg">
        <div class="row">
            <form action="<?php echo osc_base_url(true); ?>" method="get" class="search nocsrf">
            <input type="hidden" name="page" value="search"/>
            <div class="col-md-5 col-xs-12">
                <input type="text" name="sPattern" id="query" value="" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'flatter_theme'), 'flatter')); ?>" />
            </div>
            <!-- Keyword -->
            <div class="col-md-3 col-xs-12">
                <?php osc_goto_first_category(); ?>
                <?php  if ( osc_count_categories() ) { ?>
                <select id="sCategory" name="sCategory">
                    <option value=""><?php _e('Select a category', 'flatter'); ?></option>
                    <?php while ( osc_has_categories() ) { ?>
                    <option class="maincat" value="<?php echo osc_category_id() ; ?>"><?php echo osc_category_name(); ?></option>
                        <?php if ( osc_count_subcategories() ) { ?>
                            <?php while ( osc_has_subcategories() ) { ?>
                            <option class="subcat" value="<?php echo osc_category_id() ; ?>"><?php echo osc_category_name(); ?></option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php  } ?>
            </div>
            <!-- Categories -->
            <div class="col-md-3 col-xs-12">
                <?php if( osc_get_preference('location_input', 'flatter_theme') == '1') { ?> 
                   <?php $aRegions = Region::newInstance()->listAll(); ?>
                    <?php if(count($aRegions) > 0 ) { ?>
                    <select name="sRegion" id="sRegion">
                        <option value=""><?php _e('Select a region', 'flatter'); ?></option>
                        <?php foreach($aRegions as $region) { ?>
                        <option value="<?php echo $region['s_name'] ; ?>"><?php echo $region['s_name'] ; ?></option>
                        <?php } ?>
                    </select>
                    <?php } ?>
                <?php } else { ?>
                    <input name="sCity" id="sCity" placeholder="<?php _e('Type a city', 'flatter'); ?>" type="text" />
                    <input name="sRegion" id="sRegion" type="hidden" />
                    <script type="text/javascript">
                        $(function() {
                            function log( message ) {
                                $( "<div/>" ).text( message ).prependTo( "#log" );
                                $( "#log" ).attr( "scrollTop", 0 );
                            }
                    
                            $( "#sCity" ).autocomplete({
                                source: "<?php echo osc_base_url(true); ?>?page=ajax&action=location",
                                minLength: 2,
                                select: function( event, ui ) {
                                    $("#sRegion").attr("value", ui.item.region);
                                    log( ui.item ?
                                        "<?php _e('Selected', 'flatter'); ?>: " + ui.item.value + " aka " + ui.item.id :
                                        "<?php _e('Nothing selected, input was', 'flatter'); ?> " + this.value );
                                }
                            });
                        });
                    </script>
                <?php } ?>
            </div>
            <!-- Locations -->
            <div class="col-md-1 pull-right col-xs-12">
                <button class="btn btn-sclr"><?php _e("GO", 'flatter');?></button>
            </div>
            </form>    
        </div>
        
    </div>
</div>
<!-- Big Search -->          
            </DIV>
        </div>





 <?php } else { ?>




 
 <div class="section" ;>

        <div class="postadspace"      style="


background-image:-moz-linear-gradient(30deg, #75D0FA, #61F4C3);
background-image:-webkit-linear-gradient(30deg, #75D0FA, #61F4C3);
background-image:-o-linear-gradient(30deg, #75D0FA, #F883FF);
background-image:linear-gradient(60deg, #75D0FA173, 0.95), #F883FF);
}
    "    >
            <div class="container">
                <br> 
                <h2 class="clr" style=" margin-top: 40px; text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.33); font-size: 18px; "><?php echo osc_get_preference("fpromo_text", "flatter_theme"); ?></h2>
                
                <span style=" text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.13)"   font-size: "10px";>  Publish and share stories with the world </span> 

                <?php if( osc_is_web_user_logged_in() ) { ?>
                                              <a href="https://newsfid.com/index.php?page=item&action=item_add" style=" color: black; font-weight: bold"; > Share a story with us now.</a>  <br><br>
                                            <?php } else { ?>
                                              <a href="<?php echo osc_register_account_url(); ?>" style=" color: black; "; > Or get an account for free now.</a>  <br><br>
                                              <?php } ?>

                  <br><br><br>
            </div>
        </div>



                                                   <?php } ?>

    </div><!-- Section 5 -->

    
<div id="sections">
    <div class="section">
        <?php
            require_once('geoplugin.class.php');
            $geoplugin = new geoPlugin();
            //$ip = $_SERVER['REMOTE_ADDR'];
            //$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
            //locate the IP
            $geoplugin->locate();
            
             
            $ct= $geoplugin->city;
            $rg= $geoplugin->region;
            $cy= $geoplugin->countryName; 
            //echo "$cy";
        ?> 














    <div class="section" style="background-color: black;">
        <?php $premiumcount = osc_get_preference('premium_count', 'flatter_theme'); ?>
        <?php osc_get_premiums($premiumcount); if( osc_count_premiums() >= 1) { ?>
        <div class="featuredlistings">
            <div class="clr-layer"></div>
            <div class="container">
                <h2 style=" text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.73); font-size: 18px; "><?php _e(' Sponsored Stories', 'flatter'); ?></h2> 
              
                
                <div id="fuListings" class="carousel slide bdr" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php while ( osc_has_premiums() ) { ?>
                        <div class="item clearfix">
                            <div class="col-md-5 col-sm-5 premium-image">
                                <?php if( osc_images_enabled_at_items() ) { ?>
                                    <div>
                                    <?php if(osc_count_premium_resources()) { ?>
                                    <a href="<?php echo osc_premium_url(); ?>"><img src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_premium_title(); ?>" class="img-responsive" /></a>
                                    <?php } else { ?>
                                    <a href="<?php echo osc_premium_url(); ?>"><img src="<?php echo osc_current_web_theme_url('images/no-photo.jpg'); ?>" alt="<?php echo osc_premium_title(); ?>" class="img-responsive"></a>
                                    <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-7 col-sm-7 premium-content">
                                <div>
                                    <h3 class="sclr"><a href="<?php echo osc_premium_url(); ?>"><?php echo osc_premium_title(); ?></a>
                                    <span class="meta"><?php echo osc_premium_category(); ?> (<?php echo osc_premium_region(); ?>, <?php echo osc_premium_country(); ?>)</span></h3>
                                    <p class="description"><?php echo osc_highlight( strip_tags( osc_premium_description() ), 320 ) ; ?></p>
                                    <?php if( osc_price_enabled_at_items() ) { ?><span class="premium-price clr"><?php echo osc_format_premium_price(); ?></span><?php } ?>
                                    <div class="image-thumbs">
                                    <?php osc_reset_resources(); ?>
                                        <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { if($i != 0) { // except 1st image ?>
                                        <a href="<?php echo osc_premium_url(); ?>"><img class="img-responsive" src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_premium_title(); ?>" /></a>
                                        <?php } ?>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Item -->
                        <?php } ?>
                    </div><!-- Carousel Inner END -->
                    <!-- Controls -->
                  <a class="left carousel-control hidden-xs" href="#fuListings" role="button" data-slide="prev">Prev</a>
                  <a class="right carousel-control hidden-xs" href="#fuListings" role="button" data-slide="next">Next</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div><!-- Section 2 -->













    <?php if( osc_is_web_user_logged_in() ) { ?>


        <div class="latestbylocation">
            <div class="container">
                <h2 class="clr">
                <?php 
                    if($ct==null) {
                    if ($rg==null){
                    if($cy==null){
                        echo "No listings";
                        } else { echo "<script language='JavaScript'>document.write(geoip_city());</script>"; }
                        }else { echo $rg; }
                        }else {echo  $ct; 
                    }
                ?>
                <small><a href="#location" data-toggle="modal" data-target="#locationSelect" class="sclr" style="font-size: 20px; font-weight: bold;"><?php _e('Browse by country', 'flatter'); ?></a></small>
                </h2>
                
                <div id="owl-bylocation" class="owl-carousel">
                    <?php
                        /*$ct= $details->city;
                        $rg= $details->region;
                        $cy= $details->country; */
                        $ct= $geoplugin->city;
                        $rg= $geoplugin->region;
                        $cy= $geoplugin->countryName; 
                        if($cy==null) {
                        if ($rg==null){
                        if($ct !=null){
                        osc_query_item('city_name='.$ct);
                        }
                        }else {  osc_query_item('region_name='.$rg); }
                        }else { osc_query_item('country_name='.$cy); }
                        if( osc_count_custom_items() == 0) { 
                    ?>

                    <?php } else { ?>
                    
                    <?php while ( osc_has_custom_items() ) { ?>
                    <div class="item wow fadeInUp animated">
                        <div class="list">
                            <?php if( osc_images_enabled_at_items() ) { ?>
                            <div class="image">
                                <div>
                                <?php if(osc_count_item_resources()) { ?>
                                <a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_resource_preview_url(); ?>" alt="<?php echo osc_item_title(); ?>" class="img-responsive" /></a>
                                <?php } else { ?>
                                <a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_current_web_theme_url('images/no-image.jpg'); ?>" alt="<?php echo osc_item_title(); ?>" class="img-responsive"></a>
                                <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="caption">
                                <h3 class="clr"><a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a></h3>
                                <span class="meta"><?php echo osc_item_category(); ?></span>
                                <p class="description"><?php echo osc_highlight( strip_tags( osc_item_description() ), 110 ) ; ?></p>
                                <div class="row">
                                    <div class="col-md-9 col-sm-9 col-xs-9">
                                        <?php if( osc_price_enabled_at_items() ) { ?><span class="price sclr"><?php echo osc_format_price(osc_item_price()); ?></span><?php } ?>
                                    </div>
                                    <?php if (function_exists("watchlist")) { ?>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <div class="wishlist pull-right">
                                            <?php if( osc_is_web_user_logged_in() ) { ?>
                                                <?php watchlist2(); ?>
                                            <?php } else { ?>
                                            <a title="<?php _e("Add to watchlist", 'watchlist'); ?>" rel="nofollow" href="<?php echo osc_user_login_url(); ?>"><i class="fa fa-heart-o fa-lg"></i></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                </div><!-- Carousel END -->
            </div>

               <?php } else { ?>
                                                   <?php } ?>

        </div><!-- Listing by Location END -->
    </div><!-- Section END -->
    














     
    
    </div><!-- Section 3 -->
    
    <div class="section">
        <div class="latestListing">
            <div class="container">
                <h2 class="clr"><?php _e('Latest Headlines ', 'flatter') ; ?></h2>
                <div id="owl-latest" class="owl-carousel">
                    <?php
                    if( osc_count_latest_items() == 0) { ?>
                        <?php _e('No listings', 'flatter'); ?>
                    <?php } else { ?>
                    <?php while ( osc_has_latest_items() ) { ?>
                    <div class="item wow fadeInUp animated">
                        <div class="list">
                            <?php if( osc_images_enabled_at_items() ) { ?>
                            <div class="image">
                                <div>
                                <?php if(osc_count_item_resources()) { ?>
                                <a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_resource_preview_url(); ?>" alt="<?php echo osc_item_title(); ?>" class="img-responsive" /></a>
                                <?php } else { ?>
                                <a href="<?php echo osc_item_url(); ?>"><img src="<?php echo osc_current_web_theme_url('images/no-image.jpg'); ?>" alt="<?php echo osc_item_title(); ?>" class="img-responsive"></a>
                                <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="caption" >
                                <h3 class="clr"><a style="margin-right: 15px; margin-left : 10px; " href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a></h3>
                                <span class="meta"><?php echo osc_item_category(); ?></span>
                                <p class="description"><?php echo osc_highlight( strip_tags( osc_item_description() ), 0 ) ; ?></p>
                                <div class="row">
                                    <div class="col-md-9 col-sm-9 col-xs-9">
                                        <?php if( osc_price_enabled_at_items() ) { ?><span class="price sclr"><?php echo osc_format_price(osc_item_price()); ?></span><?php } ?>
                                    </div>
                                    <?php if (function_exists("watchlist")) { ?>
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <div class="wishlist pull-right">
                                        	<?php if( osc_is_web_user_logged_in() ) { ?>
												<?php watchlist2(); ?>
                                            <?php } else { ?>
                                            <a title="<?php _e("Add to watchlist", 'watchlist'); ?>" rel="nofollow" href="<?php echo osc_user_login_url(); ?>"><i class="fa fa-heart-o fa-lg"></i></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                </div><!-- Carousel END -->
            </div>
        </div><!-- Latestlisting END -->
    </div><!-- Section 4 -->
    






<?php if( osc_is_web_user_logged_in() ) { ?>



   
  
              

            <?php } else { ?>


 <!-- bottom background -->

  <DIV id="cover" classe="cover" style=" 
  margin:0;
  padding:0; no-repeat center fixed; 
  -webkit-background-size: cover; /* pour anciens Chrome et Safari */
  background-size: cover; /* version standardisée */
  background-color: black;
  max-height: 400px;
  overflow: hidden; 
  ">


                <img src="images/bottom.main.jpg" class="img-responsive" />
            <?php } ?>







    

    
    <?php if( osc_get_preference('position2_enable', 'flatter_theme') != '0') { ?>
    <div id="position_widget" class="greybg<?php if( osc_get_preference('position1_hide', 'flatter_theme') != '0') {echo" hidden-xs";}?>">
        <div class="container">
            <div class="dd-widget position_2">
                <?php echo osc_get_preference('position2_content', 'flatter_theme'); ?>
            </div>
        </div>
    </div>
    <!-- Homepage widget 2 -->
    <?php } ?>
</div>




<?php if( osc_is_web_user_logged_in() ) { ?>


 <?php } else { ?>
         
      <div class="section">
        <div class="postadspace">
            <div class="container">
                
                   <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>


                  <center> <h50 style=" margin:0 0 10px 0; font-weight:600; font-size: 32px; color: black;">  Join us for free now  </h50></center> <br>

                    <a class="btn btn-sclr btn-lg" href=" <?php echo osc_register_account_url(); ?>"><?php _e(" Sign up for free ", 'flatter');?></a>
                <?php } ?>
            </div>
        </div>
    </div>


            <?php } ?>





<?php osc_current_web_theme_path('locationfind.php'); ?>
<?php osc_current_web_theme_path('footer.php') ; ?>