<?php if ( ! defined('OC_ADMIN')) exit('Direct access is not allowed.');

?>
<?php mdh_current_plugin_path("views/admin/navigation.php"); ?>
<div class="space-in-lg bg-light dk clearfix b-b">
    <h2 class="h2 row-space-2"><?php _e("Read me", mdh_current_plugin_name()); ?></h2>
    <h3 class="h3 row-space-2"><?php _e("Files restrictions", mdh_current_plugin_name()); ?></h3>
    <div>
    	<p>
    		 <?php _e('Max size of profile picture : ', mdh_current_plugin_name()); ?><strong> <?php echo osc_max_size_kb() . " kb";?></strong> <a href="<?php echo osc_admin_base_url(). "?page=settings&action=media" ?>"><?php _e("edit", mdh_current_plugin_name()); ?></a>
    	</p>
    	<p>
    		 <?php _e('Extensions authorised : ', mdh_current_plugin_name()); ?><strong> <?php echo  osc_allowed_extension(); ?></strong>
    	</p>
    </div>
    <h3 class="h3 row-space-2"><?php _e("Helpers", mdh_current_plugin_name()); ?></h3>
    <ul>
        <li><code>echo mdh_avatar_nav_url({USER_ID})</code></li>
        <li><code>echo mdh_avatar_thumbnail_url({USER_ID})</code></li>
        <li><code>echo mdh_avatar_preview_url({USER_ID})</code></li>
        <li><code>echo mdh_avatar_normal_url({USER_ID})</code></li>
    </ul>
    <p><code>{USER_ID}</code> <?php _e("can be replaced by", mdh_current_plugin_name()); ?> : <code>osc_logged_user_id()</code>, <code>osc_user_id()</code> or <code>osc_item_user_id()</code></p>
    <h3 class="h3 row-space-2"><?php _e("Customisation", mdh_current_plugin_name()); ?></h3>
    <p class="row-space-3"><?php _e("To customize the form, create a folder inside your theme (oc-content/YOUR_THEME<strong>/plugins/madhouse_avatar/</strong>). Then, just copy the default view named edit.php (oc-content/plugins<strong>/madhouse_avatar/views/web/edit.php</strong>) to your theme  (oc-content/YOUR_THEME<strong>/plugins/madhouse_avatar/edit.php</strong>)", mdh_current_plugin_name()); ?></p>
</div>
<form class="settings_form form-horizontal" action="<?php echo mdh_avatar_do_url(); ?>" method="post" enctype="multipart/form-data">
        <div class="space-in-lg bg-light b-b clearfix">
            <h2 class="h2 row-space-2"><?php _e("Settings", mdh_current_plugin_name()); ?></h2>
			<h3 class="h3 row-space-2"><?php _e("Image sizes", mdh_current_plugin_name()); ?></h3>
    		<p class="text-muted row-space-3"><?php _e("The sizes listed below determine the maximum dimensions in pixels to use when uploading a image. Format: <b>Width</b> x <b>Height</b>.", mdh_current_plugin_name()); ?></p>

            <div class="form-group">
                <label class="control-label col-sm-2">Nav size</label>
                <div class="col-sm-2"><input type="text" class="form-control" name="urDimNav" value="<?php echo mdh_avatar_nav_dimensions(); ?>"></div>
            </div>
        	<div class="form-group">
                <label class="control-label col-sm-2">Thumbnail size</label>
                <div class="col-sm-2"><input type="text" class="form-control" name="urDimThumbnail" value="<?php echo mdh_avatar_thumbnail_dimensions(); ?>"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Preview size</label>
                <div class="col-sm-2"><input type="text" class="form-control" name="urDimPreview" value="<?php echo mdh_avatar_preview_dimensions(); ?>"></div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Normal size</label>
                <div class="col-sm-2"><input type="text" class="form-control" name="urDimNormal" value="<?php echo mdh_avatar_normal_dimensions(); ?>"></div>
            </div>
            <h3 class="h3 row-space-2"><?php _e("Form position",mdh_current_plugin_name()) ?></h3>

            <div class="form-group">
                <label class="col-sm-2 control-label"><?php _e("Register", mdh_current_plugin_name()); ?></label>
                <div class="col-sm-3">
                    <!-- default_status -->
                    <select name="form_post_position" class="">
                        <option value="-1"><?php _e("Don't display", mdh_current_plugin_name()); ?></option>
                        <?php for($i = 1 ; $i <=10 ; $i++): ?>
                            <option <?php echo (osc_get_preference('form_post_position', mdh_current_preferences_section()) == $i) ? 'selected="selected"': ""; ?> value="<?php echo $i; ?>"><?php echo $i ?> </option>
                        <?php endfor; ?>
                    </select>
                    <p class="help-block"><?php _e("Need 'user_form' hook", mdh_current_plugin_name()); ?></p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"><?php _e("Edit", mdh_current_plugin_name()); ?></label>
                <div class="col-sm-3">
                    <!-- default_status -->
                    <select name="form_edit_position">
                        <option value="-1"><?php _e("Don't display", mdh_current_plugin_name()); ?></option>
                        <?php for($i = 1 ; $i <=10 ; $i++): ?>
                            <option <?php echo (osc_get_preference('form_edit_position', mdh_current_preferences_section()) == $i) ? 'selected="selected"': ""; ?> value="<?php echo $i; ?>"><?php echo $i ?> </option>
                        <?php endfor; ?>
                    </select>
                    <p class="help-block"><?php _e("Need 'user_profile_form' hook", mdh_current_plugin_name()); ?></p>
                </div>
            </div>
			<h3 class="h3 row-space-2"><?php _e("No profile picture image", mdh_current_plugin_name()); ?></h3>
			<div class="form-group">
				<label class="control-label col-sm-2"><?php _e('Image'); ?></label>
				<div class="col-sm-4 space-in-t-sm">
                    <input type="file" name="no_profile_image[]" id="no_profile_image_file"/>
                    <p class="help-block"><?php _e("It has to be a ", mdh_current_plugin_name()); echo osc_allowed_extension(); ?> </p>
				</div>
			</div>
            <div class="form-group">
                <label class="control-label col-sm-2"><?php _e('Current'); ?></label>
                <div class="col-sm-2">
                    <div class="width-xl thumbnail"><img width="400px" src="<?php echo mdh_avatar_no_user_resource_url(); ?>" /></div>
                </div>
            </div>
        </div>
        <div class="space-in-md bg-light dker b-b">
            <input type="submit" id="save_changes" value="<?php _e('Save changes', mdh_current_plugin_name()); ?>" class="btn btn-primary btn-block"/>
        </div>
</form>



