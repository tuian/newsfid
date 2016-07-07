<?php if ($item_video_files != null && is_array($item_video_files) && count($item_video_files) > 0) : ?>
    <div class="item_video_container">
        <h3 style="margin-left: 40px;margin-top: 20px;"><?php _e('Item Video', 'item_video'); ?></h3>
        <div class="">
            <div class="dg_files">
                <?php foreach ($item_video_files as $_r) : ?>
                    <div class="item_video_single_row">
                        <div id="<?php echo $_r['pk_i_id']; ?>" fkid="<?php echo $_r['fk_i_item_id']; ?>" name="<?php echo $_r['s_name']; ?>">
                            <video controls>
                                <source src="<?php echo ITEM_VIDEO_FILE_URL . $_r['s_code'] . "_" . $_r['fk_i_item_id'] . "_" . $_r['s_name']; ?>" />
                            </video>
                        </div>
                        <div class="item_video_name">
                            <label><?php echo $_r['s_actual_name']; ?></label><a href="<?php echo osc_base_url() . "oc-content/plugins/" . osc_plugin_folder(__FILE__) . "download.php?file=" . $_r['s_code'] . "_" . $_r['fk_i_item_id'] . "_" . $_r['s_name']; ?>" ><?php _e('Download', 'item_video'); ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>