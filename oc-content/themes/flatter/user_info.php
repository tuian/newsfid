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

<div class="row user_info_row">
    <div class="user_map" id="user_map"></div>
</div>