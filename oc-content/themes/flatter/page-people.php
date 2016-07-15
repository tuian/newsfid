<?php
// meta tag robots
osc_add_hook('header', 'flatter_nofollow_construct');

flatter_add_body_class('page');
osc_current_web_theme_path('header.php');
?>
<div id="columns">
    <div class="user-search">
       
            <ul>
                <li class="people-search col-md-11">
                    <input class="search-text" type="text" placeholder="Search for someone or a band">
                </li>
                <li class="search-button">
                    <button><i class="fa fa-search" aria-hidden="true"></i></button>
                </li>

            </ul>
        
    </div>
    <div class="location_filter_container pull-right pull-right-search">
        <ul class="nav">
            <li class="location_filter_tab"><a href="#tab_1">WORLD</a></li>
            <li class="location_filter_tab" data_location_type="country" data_location_id="<?php echo $logged_user[0]['fk_c_country_code'] ?>"><a href="#tab_2">NATIONAL</a></li>
            <li class="active location_filter_tab" data_location_type="city" data_location_id="<?php echo $logged_user[0]['fk_i_city_id'] ?>"><a href="#tab_3">LOCAL</a></li>
        </ul>
        <div class="tab-content">

        </div>
        <!-- /.tab-content -->
    </div>
    <div class="clear"></div>
    <div class="col-md-offset-2">
        <p class="people-result-text">(4) results found </p>
        <div class="col-md-5">
        <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->

                        <div class="widget-user-header bg-black" style="background: url('<?php echo osc_current_web_theme_url() . "/images/cover_image.jpg" ?>') center center;">
                            <h3 class="widget-user-username">
                                <?php echo $logged_user[0]['user_name'] ?>
                            </h3>
                            <h5 class="widget-user-desc">
                                Web Designer
                            </h5>
                        </div>
                        <div class="widget-user-image">
                            <?php
                            if (!empty($logged_user[0]['s_path'])):
                                $img_path = osc_base_url() . '/' . $logged_user[0]['s_path'] . $logged_user[0]['pk_i_id'] . '.' . $logged_user[0]['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>

                            <img class="img-circle" src="<?php echo $img_path ?>" alt=" <?php echo $logged_user[0]['user_name'] ?>">
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            3,200
                                        </h5>
                                        <span class="description-text">
                                            ABONNEMENTS
                                        </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            13,000
                                        </h5>
                                        <span class="description-text">
                                            FOLLOWERS
                                        </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">35</h5>
                                        <span class="description-text">LIKES</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
            
           
        </div>
        <div class="col-md-5">
        <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->

                        <div class="widget-user-header bg-black" style="background: url('<?php echo osc_current_web_theme_url() . "/images/cover_image.jpg" ?>') center center;">
                            <h3 class="widget-user-username">
                                <?php echo $logged_user[0]['user_name'] ?>
                            </h3>
                            <h5 class="widget-user-desc">
                                Web Designer
                            </h5>
                        </div>
                        <div class="widget-user-image">
                            <?php
                            if (!empty($logged_user[0]['s_path'])):
                                $img_path = osc_base_url() . '/' . $logged_user[0]['s_path'] . $logged_user[0]['pk_i_id'] . '.' . $logged_user[0]['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>

                            <img class="img-circle" src="<?php echo $img_path ?>" alt=" <?php echo $logged_user[0]['user_name'] ?>">
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            3,200
                                        </h5>
                                        <span class="description-text">
                                            ABONNEMENTS
                                        </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            13,000
                                        </h5>
                                        <span class="description-text">
                                            FOLLOWERS
                                        </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">35</h5>
                                        <span class="description-text">LIKES</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
            
           
        </div>
        <div class="col-md-5">
        <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->

                        <div class="widget-user-header bg-black" style="background: url('<?php echo osc_current_web_theme_url() . "/images/cover_image.jpg" ?>') center center;">
                            <h3 class="widget-user-username">
                                <?php echo $logged_user[0]['user_name'] ?>
                            </h3>
                            <h5 class="widget-user-desc">
                                Web Designer
                            </h5>
                        </div>
                        <div class="widget-user-image">
                            <?php
                            if (!empty($logged_user[0]['s_path'])):
                                $img_path = osc_base_url() . '/' . $logged_user[0]['s_path'] . $logged_user[0]['pk_i_id'] . '.' . $logged_user[0]['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>

                            <img class="img-circle" src="<?php echo $img_path ?>" alt=" <?php echo $logged_user[0]['user_name'] ?>">
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            3,200
                                        </h5>
                                        <span class="description-text">
                                            ABONNEMENTS
                                        </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            13,000
                                        </h5>
                                        <span class="description-text">
                                            FOLLOWERS
                                        </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">35</h5>
                                        <span class="description-text">LIKES</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
            
            
        </div>
        <div class="col-md-5">
        <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->

                        <div class="widget-user-header bg-black" style="background: url('<?php echo osc_current_web_theme_url() . "/images/cover_image.jpg" ?>') center center;">
                            <h3 class="widget-user-username">
                                <?php echo $logged_user[0]['user_name'] ?>
                            </h3>
                            <h5 class="widget-user-desc">
                                Web Designer
                            </h5>
                        </div>
                        <div class="widget-user-image">
                            <?php
                            if (!empty($logged_user[0]['s_path'])):
                                $img_path = osc_base_url() . '/' . $logged_user[0]['s_path'] . $logged_user[0]['pk_i_id'] . '.' . $logged_user[0]['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>

                            <img class="img-circle" src="<?php echo $img_path ?>" alt=" <?php echo $logged_user[0]['user_name'] ?>">
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            3,200
                                        </h5>
                                        <span class="description-text">
                                            ABONNEMENTS
                                        </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            13,000
                                        </h5>
                                        <span class="description-text">
                                            FOLLOWERS
                                        </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">35</h5>
                                        <span class="description-text">LIKES</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>