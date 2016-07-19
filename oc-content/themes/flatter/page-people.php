<?php
// meta tag robots
osc_add_hook('header', 'flatter_nofollow_construct');

flatter_add_body_class('page');
osc_current_web_theme_path('header.php');
$logged_user = get_user_data(osc_logged_user_id());
?>
<div id="columns">
    <div class="user-search">

        <ul>
            <li class="people-search col-md-11">
                <input class="search_name" type="text" placeholder="Search for someone or a band">
            </li>
            <li class="search-button">
                <button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
            </li>

        </ul>

    </div>
    <div class="location_filter_container pull-right pull-right-search">
        <ul class="nav">
            <li class="location_filter_tab" data_location_type="world" data_location_id=''><a href="#">WORLD</a></li>
            <li class="location_filter_tab" data_location_type="country" data_location_id="<?php echo $logged_user[0]['fk_c_country_code'] ?>"><a href="#">NATIONAL</a></li>
            <li class="active location_filter_tab" data_location_type="city" data_location_id="<?php echo $logged_user[0]['fk_i_city_id'] ?>"><a href="#">LOCAL</a></li>
        </ul>
        <div class="tab-content">

        </div>
        <!-- /.tab-content -->
    </div>

    <div class="container">
        <div class="row user_serach_row">
        </div>    
    </div>
</div>

<?php
osc_add_hook('footer', 'custom_script');

function custom_script() {
    ?>
    <script>
        jQuery(document).ready(function ($) {
            filter_user_search_data();
            $(document).on('click', '.search-button', function () {
                filter_user_search_data();
            });

            $(document).on('click', '.location_filter_tab', function () {
                if (!$(this).hasClass('active')) {
                    $('.location_filter_tab').removeClass('active');
                    $(this).addClass('active');
                    filter_user_search_data();
                }
            });
        });

        function filter_user_search_data() {
            var search_name = $('.search_name').val();
            var location_type = $('.location_filter_tab.active').attr('data_location_type');
            var location_id = $('.location_filter_tab.active').attr('data_location_id');
            if (search_name != '') {
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url() ?>" + 'user_search_ajax.php',
                    data: {
                        search_name: search_name,
                        location_type: location_type,
                        location_id: location_id
                    },
                    success: function (data, textStatus, jqXHR) {
                        $('.user_serach_row').empty().append(data);
                    }

                });
            }
        }


    </script>
    <?php
}

osc_current_web_theme_path('footer.php');
?>