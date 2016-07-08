<?php
if (!defined('OC_ADMIN') || OC_ADMIN !== true)
    exit('Access is not allowed.');

if (Params::getParam('plugin_action') == 'done') {
   
    osc_set_preference('item_podcast_max_file_number', Params::getParam('item_podcast_max_files'), 'item_podcast', 'INTEGER');
//    osc_set_preference('item_podcast_allowed_ext', Params::getParam('item_podcast_allowed_ext'), 'item_podcast', 'STRING');
//    osc_set_preference('item_podcast_max_file_size', Params::getParam('item_podcast_max_file_size'), 'item_podcast', 'INTEGER');

    ob_get_clean();
    osc_add_flash_ok_message(__('Plugin configuration changed successfully', 'item_podcast'), 'admin');
    osc_redirect_to(osc_route_admin_url('item-podcast-admin-conf'));
}
?>
<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 20px;">
        <div style="float: left; width: 100%;">
            <fieldset>
                <legend><?php _e('Item Podcast Settings', 'item_podcast'); ?></legend>
                <form name="item_podcast_form" id="item_podcast_form" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
                    <div style="float: left; width: 100%;">
                        <input type="hidden" name="page" value="plugins" />
                        <input type="hidden" name="action" value="renderplugin" />

                        <input type="hidden" name="route" value="item-podcast-admin-conf" />
                        <input type="hidden" name="plugin_action" value="done" />
                        
                        <label for="item_podcast_max_files"><?php _e('Number of max files per ad', 'item_podcast'); ?></label>
                        <br/>
                        <input type="text" name="item_podcast_max_files" id="item_podcast_max_files" value="<?php echo osc_get_preference('item_podcast_max_file_number', 'item_podcast') ?>"/>
                        <br/>
                        
<!--                        <label for="item_podcast_max_file_size"><?php _e('Max file size allowed (in MB)', 'item_podcast'); ?></label>
                        <br/>
                        <input type="text" name="item_podcast_max_file_size" id="item_podcast_max_file_size" value="<?php echo osc_get_preference('item_podcast_max_file_size', 'item_podcast') ?>"/>
                        <br/>
                        
                        
                        <label for="item_podcast_allowed_ext"><?php _e('Allowed filetypes (separated by comma)', 'item_podcast'); ?></label>
                        <br/>
                        <input type="text" name="item_podcast_allowed_ext" id="item_podcast_allowed_ext" value="<?php echo osc_get_preference('item_podcast_allowed_ext', 'item_podcast'); ?>"/>
                        <br/>-->
                        
                        
                        <span style="float:right;"><button type="submit" style="float: right;"><?php _e('Update', 'item_podcast'); ?></button></span>
                    </div>
                    <br/>
                    <div style="clear:both;"></div>
                </form>
            </fieldset>
        </div>
        <div style="clear: both;"></div>										
    </div>
</div>
