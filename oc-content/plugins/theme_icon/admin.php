<h2 class="render-title"><?php _e('Theme', 'category_icon'); ?></h2>
<div class="category_icon_add_box">
    <div class="left">
        <form action="<?php echo osc_admin_render_plugin_url(THEME_PLUGIN_DIR_NAME . '/admin.php'); ?>" method="post"
              enctype="multipart/form-data">
            <input type="hidden" name="newadd" value="true"/>
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label"><?php _e('Theme', 'category_icon') ?></div>
                        <div class="form-controls">
                            <div class="photo_container">
                                <input type="text" name="theme_name" id="theme_name" class="form-controls" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Image', 'category_icon') ?></div>
                        <div class="form-controls">
                            <div class="photo_container">
                                <input type="file" name="imageName"/>
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

<div class="theme_container">
    <?php
    $themes = get_all_themes_icon();

    if (!empty($themes)):
        ?>
        <table class="table table-responsive table-striped">
            <thead>
            <th><?php _e('Id', 'category_icon') ?></th>
            <th><?php _e('Image', 'category_icon') ?></th>
            <th><?php _e('Name', 'category_icon') ?></th>              
            <th><?php _e('Actions', 'category_icon') ?></th>              
            </thead>
            <tbody>
                <?php foreach ($themes as $k => $r): ?>
                <tr>
                    <td>
                        <?php echo  $k + 1 ?>
                    </td>
                    <td>
                        <img class="theme_admin_icon" src="<?php echo THEME_UPLOAD_DIR_PATH .  $r['image'] ?>" />
                    </td>
                    <td>
                        <?php echo  $r['name'] ?>
                    </td>
                    <td>
                        <a class="delete"
                           onclick="javascript:return confirm('<?php _e('This action can not be undone. Are you sure you want to continue?', 'watchlist'); ?>')"
                           href="<?php echo osc_admin_render_plugin_url(THEME_PLUGIN_DIR_NAME . '/admin.php') . '&delete=' . $r['id']; ?>">
                               <?php _e('Delete', 'home_gallery'); ?>
                        </a>
                        
                        &nbsp;&nbsp;
                        
                        <a class="delete" href="<?php echo osc_admin_render_plugin_url(THEME_PLUGIN_DIR_NAME . '/admin_edit.php') . '&theme_id=' . $r['id']; ?>">
                               <?php _e('Edit', 'home_gallery'); ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    else:

    endif;
    ?>
</div>