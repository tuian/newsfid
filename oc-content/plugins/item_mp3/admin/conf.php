<?php
if (!defined('OC_ADMIN') || OC_ADMIN !== true)
    exit('Access is not allowed.');

if (Params::getParam('plugin_action') == 'done') {
   
    osc_set_preference('item_mp3_max_file_number', Params::getParam('item_mp3_max_files'), 'item_mp3', 'INTEGER');
    osc_set_preference('item_mp3_allowed_ext', Params::getParam('item_mp3_allowed_ext'), 'item_mp3', 'STRING');
    osc_set_preference('item_mp3_max_file_size', Params::getParam('item_mp3_max_file_size'), 'item_mp3', 'INTEGER');

    ob_get_clean();
    osc_add_flash_ok_message(__('Plugin configuration changed successfully', 'item_mp3'), 'admin');
    osc_redirect_to(osc_route_admin_url('item-mp3-admin-conf'));
}
?>
<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 20px;">
        <div style="float: left; width: 100%;">
            <fieldset>
                <legend><?php _e('Item Mp3 Settings', 'item_mp3'); ?></legend>
                <form name="item_mp3_form" id="item_mp3_form" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
                    <div style="float: left; width: 100%;">
                        <input type="hidden" name="page" value="plugins" />
                        <input type="hidden" name="action" value="renderplugin" />

                        <input type="hidden" name="route" value="item-mp3-admin-conf" />
                        <input type="hidden" name="plugin_action" value="done" />
                        
                        <label for="item_mp3_max_files"><?php _e('Number of max files per ad', 'item_mp3'); ?></label>
                        <br/>
                        <input type="text" name="item_mp3_max_files" id="item_mp3_max_files" value="<?php echo osc_get_preference('item_mp3_max_file_number', 'item_mp3') ?>"/>
                        <br/>
                        
                        <label for="item_mp3_max_file_size"><?php _e('Max file size allowed (in MB)', 'item_mp3'); ?></label>
                        <br/>
                        <input type="text" name="item_mp3_max_file_size" id="item_mp3_max_file_size" value="<?php echo osc_get_preference('item_mp3_max_file_size', 'item_mp3') ?>"/>
                        <br/>
                        
                        
                        <label for="item_mp3_allowed_ext"><?php _e('Allowed filetypes (separated by comma)', 'item_mp3'); ?></label>
                        <br/>
                        <input type="text" name="item_mp3_allowed_ext" id="item_mp3_allowed_ext" value="<?php echo osc_get_preference('item_mp3_allowed_ext', 'item_mp3'); ?>"/>
                        <br/>
                        
                        
                        <span style="float:right;"><button type="submit" style="float: right;"><?php _e('Update', 'item_mp3'); ?></button></span>
                    </div>
                    <br/>
                    <div style="clear:both;"></div>
                </form>
            </fieldset>
        </div>
        <div style="clear: both;"></div>										
    </div>
</div>
