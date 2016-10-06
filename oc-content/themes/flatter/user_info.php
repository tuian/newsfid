<?php
$address = '';
if (osc_user_address() != '') {
    if (osc_user_city_area() != '') {
        $address = osc_user_address() . ", " . osc_user_city_area();
    } else {
        $address = osc_user_address();
    }
} else {
    $address = osc_user_city_area();
}
$user_data = get_user_data(osc_user_id());
$roles = get_user_roles_array();
?>

<div class="row user_info_row success-border margin-0">
    <div class="col-md-4 col-sm-4">
        <i class="fa fa-user" aria-hidden="true"></i>
        <span class="user_info_header padding-left-10"><?php _e("About me", 'flatter') ?></span>
    </div>
    <div class="col-md-8 col-sm-8 user_info">
        <span class="user_info_text info_text" data_text="<?php echo osc_user_info(); ?>">
            <?php echo osc_user_info(); ?>
        </span>
        <?php if (osc_user_id() == osc_logged_user_id()): ?>
            <span class="edit_user_detail edit-color-blue pointer user_info_edit">
                <i class="fa fa-pencil-square-o"></i> <?php _e("Edit", 'flatter') ?>
            </span>
        <?php endif; ?>
    </div>
</div>

<div class="row user_info_row  margin-0">
    <div class="col-md-4 col-sm-4">
        <i class="col-md-2 col-sm-2 padding-0 fa fa-list" aria-hidden="true"></i>
        <span class="col-md-9 col-sm-9 user_info_header  padding-left-10"><?php _e("Type of account", 'flatter') ?></span>
    </div>
    <div class="col-md-8 col-sm-8">
        <span class="user_type_text info_text" data_role_id="<?php echo $user_data['role_id'] ?>">
            <span class="user_role_selector_container">
                <span class="user_role_name">
                    <?php echo $user_data['role_name_eng']; ?>
                </span>
                <select name="user_role_selector" id="user_role_selector" class="user_role_selector">
                    <?php foreach ($roles as $k => $role): ?>
                        <option <?php if ($role['id'] == $user_data['role_id']) echo 'selected'; ?> value="<?php echo $role['id'] ?>"><?php echo $role['role_name_eng']; ?></option>
                    <?php endforeach; ?>
                </select>
            </span>
        </span>
        <?php if (osc_user_id() == osc_logged_user_id()): ?>
            <span class="edit_user_detail edit-color-blue pointer user_type_edit">
                <i class="fa fa-pencil-square-o"></i> <?php _e("Edit", 'flatter') ?>
            </span>
        <?php endif; ?>
    </div>
</div>

<div class="row user_info_row  margin-0">
    <div class="col-md-4 col-sm-4">
        <i class="col-md-2 col-sm-2 padding-0 fa fa-globe" aria-hidden="true"></i>
        <span class="col-md-9 col-sm-9 user_info_header padding-left-10"><?php _e("Website", 'flatter') ?></span>
    </div>
    <div class="col-md-8 col-sm-8 user_website">
        <span class="user_website_text info_text" data_text="<?php echo osc_user_website(); ?>">
            <?php echo osc_user_website(); ?>
        </span>        
        <?php if (osc_user_id() == osc_logged_user_id()): ?>
            <span class="edit_user_detail edit-color-blue pointer user_website_edit">
                <i class="fa fa-pencil-square-o"></i><?php _e("Edit", 'flatter') ?> 
            </span>
        <?php endif; ?>
    </div>
</div>

<div class="row user_info_row  margin-0">
    <div class="col-md-4 col-sm-4">
        <i class="col-md-2 col-sm-2 padding-0 fa fa-map-marker" aria-hidden="true"></i>
        <span class="col-md-9 col-sm-9 user_info_header padding-left-10"><?php _e("Localisation", 'flatter') ?></span>
    </div>
    <div class="col-md-8 col-sm-8">
        <input type="hidden" class="city_id">
        <input type="hidden" class="region_id">
        <input type="hidden" name="country_id" class="country_id">
        <span class="user_localisation_text info_text" data_text="<?php echo osc_user_field('s_city') . " - " . osc_user_field('s_country'); ?>">
            <span class="location-box"><?php echo osc_user_field('s_city') . " - " . osc_user_field('s_country'); ?></span>
            <?php if (osc_user_id() == osc_logged_user_id()): ?>
                <input type="text" class="user_localisation_textbox filter_city hide" city="<?php echo osc_user_field('s_city') ?>" region="<?php echo osc_user_field('s_region') ?>" country="<?php echo osc_user_field('s_country') ?>"value="<?php echo osc_user_field('s_city') . " - " . osc_user_field('s_country'); ?>">
            <?php endif; ?>
        </span>  
        <?php if (osc_user_id() == osc_logged_user_id()): ?>
            <span class="edit_user_detail edit-color-blue pointer user_localisation_edit">
                <i class="fa fa-pencil-square-o"></i> <?php _e("Edit", 'flatter') ?>
            </span>
        <?php endif; ?>
    </div>
</div>


<div class="row user_info_row margin-0 user_map_box">
    <div class="user_map" id="user_map"></div>
</div>

<?php
osc_add_hook('footer', 'custom_map_script');

function custom_map_script() {
    ?>
    <script src="//maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places"></script>

    <script>
        //        google.maps.event.addDomListener(window, 'load', initMap);
        //        function initMap() {
        //            var latitude = <?php echo osc_user_field('d_coord_lat') ? osc_user_field('d_coord_lat') : '45.7640' ?>;
        //            var longitude = <?php echo osc_user_field('d_coord_long') ? osc_user_field('d_coord_long') : '4.8357' ?>;
        //
        //            var myLatLng = {lat: latitude, lng: longitude};
        //            var map = new google.maps.Map(document.getElementById('user_map'), {
        //                zoom: 10,
        //                center: myLatLng
        //            });
        //            //add the code here, after the map variable has been instantiated
        //            var tab = jQuery('ul.user_profile_navigation li')[1]
        //            jQuery(tab).one('click', function () {
        //                setTimeout(function () {
        //                    google.maps.event.trigger(map, 'resize');
        //                    map.setCenter(myLatLng)
        //                    google.maps.Marker({
        //                        position: myLatLng,
        //                        map: map,
        //                        title: 'My City'
        //                    });
        //                }, 1000);
        //
        //            });
        //        }
        //        function updateMap(latitude, longitude) {
        //            var myLatLng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
        //            var map = new google.maps.Map(document.getElementById('user_map'), {
        //                zoom: 10,
        //                center: myLatLng
        //            });
        //            google.maps.event.trigger(map, 'resize');
        //            map.setCenter(myLatLng)
        //            google.maps.Marker({
        //                position: myLatLng,
        //                map: map,
        //                title: 'My City'
        //            });
        //        }
        //
        //        //       
        //        var goptions = {
        //            map: '#user_map',
        //            details: ".details",
        //            types: ['(cities)'],
        //            basemap: 'gray',
        //            mapOptions: {
        //                zoom: 10
        //            },
        //            marketOptions: {
        //                draggable: true
        //            }
        //        }

        
        $(document).on('click', '.user_localisation_edit', function () {
            $('.user_localisation_textbox').removeClass('hide');
            $('.location-box').addClass('hide');
        });
        $('.filter_city').typeahead({
            source: function (query, process) {
                var $items = new Array;
                $items = [""];
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url('search_city_ajax.php') ?>",
                    dataType: "json",
                    type: "POST",
                    data: {city_name: query, region_name: query, country_name: query},
                    success: function (data) {
                        $.map(data, function (data) {
                            var group;
                            group = {
                                city_id: data.city_id,
                                city_name: data.city_name,
                                region_id: data.r_id,
                                region_name: data.region_name,
                                country_code: data.country_code,
                                country_name: data.country_name,
                                name: data.city_name + '-' + data.region_name + '-' + data.country_name,
                            };
                            $items.push(group);
                        });
                        process($items);
                    }
                });
            },
            updater: function (data) {
                var new_text = data.name;
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
                    type: 'POST',
                    data: {
                        action: 'user_localisation',
                        city: data.city_name,
                        country: data.country_name,
                        scountry: data.country_code,
                        region_code: data.region_id,
                        region_name: data.region_name,
                    },
                    dataType: "json",
                    success: function (data, textStatus, jqXHR) {
                        $('.user_localisation_textbox').val(new_text);
                        $('.user_localisation_textbox').addClass('hide');
                        $('.location-box').html(new_text);
                        $('.location-box').removeClass('hide');
                    }
                });
            }
        });
    </script>           

    <script>
        jQuery(document).ready(function ($) {
            $(document).on('click', '.user_info_edit', function () {
                var text = $('.user_info .user_info_text').attr('data_text');
                var input_box = '<input type="text" class="user_info_textbox" value="' + text + '">';
                $('.user_info_text').html(input_box);
                $('.user_info_textbox').keypress(function (e) {
                    if (e.which == 13) {//Enter key pressed
                        $('.user_info_textbox').focusout();
                    }
                });
            });
            $(document).on('blur', '.user_info_textbox', function () {
                var new_text = $(this).val();
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
                    data: {
                        action: 'user_info',
                        user_info_text: new_text,
                    },
                    success: function (data, textStatus, jqXHR) {
                    }
                });
                $('.user_info_text').html(new_text).attr('data_text', new_text);
            });
            $(document).on('click', '.user_website_edit', function () {
                var text = $('.user_website .user_website_text').attr('data_text');
                var input_box = '<input type="text" class="user_website_textbox" value="' + text + '">';
                $('.user_website_text').html(input_box);
                $('.user_website_textbox').keypress(function (e) {
                    if (e.which == 13) {//Enter key pressed
                        $('.user_website_textbox').focusout();
                    }
                });
            });
            $(document).on('blur', '.user_website_textbox', function () {
                var new_text = $(this).val();
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
                    data: {
                        action: 'user_website',
                        user_website_text: new_text,
                    },
                    success: function (data, textStatus, jqXHR) {
                    }
                });
                $('.user_website_text').html(new_text).attr('data_text', new_text);
            });
            $(document).on('click', '.user_type_edit', function () {
                $('.user_role_selector').show();
                $('.user_role_name').hide();
                //                var text = $('.user_website .user_website_text').attr('data_text');
                //                var input_box = '<input type="text" class="user_website_textbox" value="' + text + '">';
                //                $('.user_website_text').html(input_box);
            });
            $(document).on('change', '.user_role_selector', function () {
                var role_id = $(this).val();
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
                    data: {
                        action: 'user_role',
                        user_role_id: role_id,
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (data != 0) {
                            $('.user_role_name').text(data);
                        }
                        $('.user_role_selector').hide();
                        $('.user_role_name').show();
                    }
                });
            });
        });

    </script>
    <?php
}
?>