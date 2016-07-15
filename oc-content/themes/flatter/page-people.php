<?php
// meta tag robots
osc_add_hook('header', 'flatter_nofollow_construct');

flatter_add_body_class('page');
osc_current_web_theme_path('header.php');
?>
<div id="columns">
    <div class="user-search">
        <form>
            <ul>
                <li class="people-search col-md-11">
                    <input class="" type="text" placeholder="Search for someone or a band">
                </li>
                <li class="search-button">
                    <button><i class="fa fa-search" aria-hidden="true"></i></button>
                </li>

            </ul>
        </form>
    </div>
    <div class="location_filter_container pull-right">
        <ul class="nav">
            <li class="location_filter_tab"><a href="#tab_1">WORLD</a></li>
            <li class="location_filter_tab" data_location_type="country" data_location_id="<?php echo $logged_user[0]['fk_c_country_code'] ?>"><a href="#tab_2">NATIONAL</a></li>
            <li class="active location_filter_tab" data_location_type="city" data_location_id="<?php echo $logged_user[0]['fk_i_city_id'] ?>"><a href="#tab_3">LOCAL</a></li>
        </ul>
        <div class="tab-content">

        </div>
        <!-- /.tab-content -->
    </div>

</div>
<?php osc_current_web_theme_path('footer.php'); ?>