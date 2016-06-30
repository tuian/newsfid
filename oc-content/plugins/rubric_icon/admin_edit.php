<?php
    $rubric = get_rubric_icon(Params::getParam('rubric_id'));
?>
<h2 class="render-title"><?php _e('Rubric', 'category_icon'); ?></h2>
<div class="category_icon_add_box">
    <div class="left">
        <form action="<?php echo osc_admin_render_plugin_url(RUBRIC_PLUGIN_DIR_NAME . '/admin.php'); ?>" method="post"
              enctype="multipart/form-data">
            <input type="hidden" name="edit" value="true"/>
            <input type="hidden" name="rubric_id" value="<?php echo $rubric[0]['id']; ?>"/>
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label"><?php _e('Rubric', 'category_icon') ?></div>
                        <div class="form-controls">
                            <div class="photo_container">
                                <input type="text" name="rubric_name" id="rubric_name" class="form-controls" value="<?php echo $rubric[0]['name']; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Image', 'category_icon') ?></div>
                        <div class="form-controls">
                            <div class="photo_container">
                                <input type="file" name="imageName" />
                                <input type="hidden" name="exist_image" value="<?php echo $rubric[0]['image'] ?>" />
                                <img class="rubric_admin_icon" src="<?php echo RUBRIC_UPLOAD_DIR_PATH . '/' . $rubric[0]['image'] ?>" />
                            </div> 
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"></div>
                        <div class="form-controls">
                            <input type="submit" value="Save changes" class="btn btn-submit">
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="right">

    </div>
</div>