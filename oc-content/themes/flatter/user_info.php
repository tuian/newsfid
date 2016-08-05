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
        <span class="user_info_header padding-left-10">A propos de moi</span>
    </div>
    <div class="col-md-8 col-sm-8 user_info">
        <span class="user_info_text info_text" data_text="<?php echo osc_user_info(); ?>">
            <?php echo osc_user_info(); ?>
        </span>
        <?php if (osc_user_id() == osc_logged_user_id()): ?>
            <span class="edit_user_detail edit-color-blue pointer user_info_edit">
                <i class="fa fa-pencil-square-o"></i> Edit
            </span>
        <?php endif; ?>
    </div>
</div>

<div class="row user_info_row  margin-0">
    <div class="col-md-4 col-sm-4">
        <i class="fa fa-list" aria-hidden="true"></i>
        <span class="user_info_header  padding-left-10">Type de compte</span>
    </div>
    <div class="col-md-8 col-sm-8">
        <span class="user_type_text info_text" data_role_id="<?php echo $user_data['role_id'] ?>">
            <span class="user_role_selector_container">
                <span class="user_role_name">
                    <?php echo $user_data['role_name']; ?>
                </span>
                <select name="user_role_selector" id="user_role_selector" class="user_role_selector">
                    <?php foreach ($roles as $k => $role): ?>
                        <option <?php if ($role['id'] == $user_data['role_id']) echo 'selected'; ?> value="<?php echo $role['id'] ?>"><?php echo $role['role_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </span>
        </span>
        <?php if (osc_user_id() == osc_logged_user_id()): ?>
            <span class="edit_user_detail edit-color-blue pointer user_type_edit">
                <i class="fa fa-pencil-square-o"></i> Edit
            </span>
        <?php endif; ?>
    </div>
</div>

<div class="row user_info_row  margin-0">
    <div class="col-md-4 col-sm-4">
        <i class="fa fa-globe" aria-hidden="true"></i>
        <span class="user_info_header padding-left-10">Website</span>
    </div>
    <div class="col-md-8 col-sm-8 user_website">
        <span class="user_website_text info_text" data_text="<?php echo osc_user_website(); ?>">
            <?php echo osc_user_website(); ?>
        </span>        
        <?php if (osc_user_id() == osc_logged_user_id()): ?>
            <span class="edit_user_detail edit-color-blue pointer user_website_edit">
                <i class="fa fa-pencil-square-o"></i> Edit
            </span>
        <?php endif; ?>
    </div>
</div>

<div class="row user_info_row  margin-0">
    <div class="col-md-4 col-sm-4">
        <i class="fa fa-map-marker" aria-hidden="true"></i>
        <span class="user_info_header padding-left-10">Localisation</span>
    </div>
    <div class="col-md-8 col-sm-8 user_website">
        <span class="user_localisation_text info_text" data_text="<?php echo osc_user_field('s_city')." - ".osc_user_field('s_country'); ?>">
            <?php echo osc_user_field('s_city')." - ".osc_user_field('s_country'); ?>
        </span>   
        <input type="text" class="hide" id="autocomplete">       
        <?php if (osc_user_id() == osc_logged_user_id()): ?>
            <span class="edit_user_detail edit-color-blue pointer user_localisation_edit">
                <i class="fa fa-pencil-square-o"></i> Edit
            </span>
        <?php endif; ?>
    </div>
</div>

<?php $user_lat = (osc_user_field('d_coord_lat')) ? osc_user_field('d_coord_lat') : '45.7640' ?>
<?php $user_lng = (osc_user_field('d_coord_lng')) ? osc_user_field('d_coord_lng') : '4.8357' ?>

<div class="row user_info_row margin-0 user_map_box">
    <div class="user_map" id="user_map"></div>
</div>

<?php
osc_add_hook('footer', 'custom_map_script');

function custom_map_script() {
    ?>
<script src="//maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places"></script>
<script src="<?php echo osc_current_web_theme_js_url('jquery.geocomplete.js') ?>"></script>
    <script>
        function initMap() {
//            var latitude = <?php echo floatval($user_lat); ?>;
//            var longitude = <?php echo floatval($user_lng); ?>;           
//
//            var myLatLng = {lat: latitude, lng: longitude};
//            var map = new google.maps.Map(document.getElementById('user_map'), {
//                zoom: 20,
//                center: myLatLng
//            });
//            var marker = new google.maps.Marker({
//                position: myLatLng,
//                map: map,
//                title: ''
//            });
        var map;     
        map = new google.maps.Map(document.getElementById('user_map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });     
        }
       google.maps.event.addDomListener(window, 'load', initMap)
       var goptions = {
            map: '#user_map',
            details: ".details",            
            types: ['(cities)'],
            basemap: 'gray',
            mapOptions: {
                    zoom: 10
            },
            marketOptions: {
                    draggable: true
            }
        }
     $('#autocomplete').geocomplete(goptions).bind("geocode:result", function(event, result){                        
        $.ajax({
            url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
            type: 'POST',
            data: {
                action: 'user_localisation',
                lat: result.geometry.location.lat,
                lng: result.geometry.location.lng,
                city: result.address_components['0'].long_name,
                country: result.address_components['3'].long_name,
            },
            success: function (data, textStatus, jqXHR) {                
                $('#autocomplete').addClass('hide');
                $('.user_localisation_text').show();
                $('.user_localisation_text').html(result.address_components['0'].long_name+" - "+result.address_components['3'].long_name);
            }
        });
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
            
             $(document).on('click', '.user_localisation_edit', function () {
                var text = $('.user_localisation_text').attr('data_text');
                $('#autocomplete').val(text);
                $('.user_localisation_text').hide();
                $('#autocomplete').removeClass('hide');
            }); 
        });
    </script>
    <?php
}
?>