<?php if ($item_podcast_files != null && is_array($item_podcast_files) && count($item_podcast_files) > 0) : ?>
    <div class="item_podcast_container">
        <h3 style="margin-left: 40px;margin-top: 20px;"><?php _e('Item Audio', 'item_podcast'); ?></h3>
        <div class="">
            <div class="dg_files">
                <?php foreach ($item_podcast_files as $_r) : ?>
                    <div class="item_podcast_single_row">
                        <div id="<?php echo $_r['pk_i_id']; ?>" fkid="<?php echo $_r['fk_i_item_id']; ?>" name="<?php echo $_r['s_embed_code']; ?>">
                            <?php echo ITEM_PODCAST_FILE_URL . $_r['s_code'] . "_" . $_r['fk_i_item_id'] . "_" . $_r['s_embed_code']; ?>
                        </div>
                        <div class="item_podcast_name">
                            <label><?php echo $_r['s_actual_name']; ?></label><a href="<?php echo osc_base_url() . "oc-content/plugins/" . osc_plugin_folder(__FILE__) . "download.php?file=" . $_r['s_code'] . "_" . $_r['fk_i_item_id'] . "_" . $_r['s_embed_code']; ?>" ><?php _e('Download', 'item_podcast'); ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>