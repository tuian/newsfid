<style type="text/css">
    .form-container .controls input[type="file"] {
        border-color: transparent;
        box-shadow: 0 0 0 0;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $(".form-container form").attr("enctype", "multipart/form-data");
    });
</script>
<?php if(osc_is_user_profile()): ?>
    <div class="control-group">
        <label class="control-label" for="password"><?php _e('Current avatar', 'madhouse_avatar'); ?></label>
        <div class="controls">
            <img src="<?php echo mdh_avatar_thumbnail_url() ?>">
        </div>
    </div>
<?php endif; ?>
<div class="control-group">
    <label class="control-label" for="password"><?php _e('Select avatar', 'madhouse_avatar'); ?></label>
    <div class="controls">
        <input type="file" name="user_photo[]">
    </div>
</div>