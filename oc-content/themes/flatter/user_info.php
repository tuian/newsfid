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
?>

<div class="row user_info_row success-border margin-0">
    <div class="col-md-4 col-sm-4">
        <span class="user_info_header">A propos de moi</span>
    </div>
    <div class="col-md-8 col-sm-8">
        <span class="user_info_text"><?php echo osc_user_info(''); ?></span>
    </div>
</div>

<div class="row user_info_row  margin-0">
    <div class="col-md-4 col-sm-4">
        <span class="user_info_header">Type de compte</span>
    </div>
    <div class="col-md-8 col-sm-8">
        <span class="user_info_text"><?php echo osc_user_info(); ?></span>
    </div>
</div>

<div class="row user_info_row  margin-0">
    <div class="col-md-4 col-sm-4">
        <span class="user_info_header">Website</span>
    </div>
    <div class="col-md-8 col-sm-8">
        <span class="user_info_text"><?php echo osc_user_name(); ?></span>
    </div>
</div>

<div class="row user_info_row  margin-0">
    <div class="col-md-4 col-sm-4">
        <span class="user_info_header">Localisation</span>
    </div>
    <div class="col-md-8 col-sm-8">
        <span class="user_info_text"><?php echo $address; ?></span>
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
        //initMap();
        function initMap() {
            var latitude = <?php echo floatval( $user_lat ); ?>;
            var longitude = <?php echo floatval ( $user_lng ); ?>;
            latitude = 45.7640;
            longitude = 4.8357
            
            var myLatLng = {lat: latitude, lng: longitude};

            var map = new google.maps.Map(document.getElementById('user_map'), {
                zoom: 20,
                center: myLatLng
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: ''
            });
        }
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>
    <?php
}
?>