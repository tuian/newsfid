<?php
if (!defined('OC_ADMIN') || OC_ADMIN !== true)
    exit('Access is not allowed.');

if (Params::getParam('plugin_action') == 'done') {
   
    osc_set_preference('item_video_max_file_number', Params::getParam('item_video_max_files'), 'item_video', 'INTEGER');
    osc_set_preference('item_video_allowed_ext', Params::getParam('item_video_allowed_ext'), 'item_video', 'STRING');
    osc_set_preference('item_video_max_file_size', Params::getParam('item_video_max_file_size'), 'item_video', 'INTEGER');

    ob_get_clean();
    osc_add_flash_ok_message(__('Plugin configuration changed successfully', 'item_video'), 'admin');
    osc_redirect_to(osc_route_admin_url('item-video-admin-conf'));
}
?>
<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 20px;">
        <div style="float: left; width: 100%;">
            <fieldset>
                <legend><?php _e('Item Video Settings', 'item_video'); ?></legend>
                <form name="item_video_form" id="item_video_form" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
                    <div style="float: left; width: 100%;">
                        <input type="hidden" name="page" value="plugins" />
                        <input type="hidden" name="action" value="renderplugin" />

                        <input type="hidden" name="route" value="item-video-admin-conf" />
                        <input type="hidden" name="plugin_action" value="done" />
                        
                        <label for="item_video_max_files"><?php _e('Number of max files per ad', 'item_video'); ?></label>
                        <br/>
                        <input type="text" name="item_video_max_files" id="item_video_max_files" value="<?php echo osc_get_preference('item_video_max_file_number', 'item_video') ?>"/>
                        <br/>
                        
                        <label for="item_video_max_file_size"><?php _e('Max file size allowed (in MB)', 'item_video'); ?></label>
                        <br/>
                        <input type="text" name="item_video_max_file_size" id="item_video_max_file_size" value="<?php echo osc_get_preference('item_video_max_file_size', 'item_video') ?>"/>
                        <br/>
                        
                        
                        <label for="item_video_allowed_ext"><?php _e('Allowed filetypes (separated by comma)', 'item_video'); ?></label>
                        <br/>
                        <input type="text" name="item_video_allowed_ext" id="item_video_allowed_ext" value="<?php echo osc_get_preference('item_video_allowed_ext', 'item_video'); ?>"/>
                        <br/>
                        
                        
                        <span style="float:right;"><button type="submit" style="float: right;"><?php _e('Update', 'item_video'); ?></button></span>
                    </div>
                    <br/>
                    <div style="clear:both;"></div>
                </form>
            </fieldset>
        </div>
        <div style="clear: both;"></div>										
    </div>
</div>
