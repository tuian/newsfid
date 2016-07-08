<?php if ($item_podcast_files != null && is_array($item_podcast_files) && count($item_podcast_files) > 0) : ?>
    <div class="item_podcast_container">
        <h3 style="margin-left: 40px;margin-top: 20px;"> <?php _e('Item Podcast', 'item_podcast'); ?></h3>
        <div class="">
            <div class="dg_files">
                <?php foreach ($item_podcast_files as $_r) : ?>
                    <div class="item_podcast_single_row">
                        <div id="<?php echo $_r['pk_i_id']; ?>" fkid="<?php echo $_r['fk_i_item_id']; ?>">
                            <?php echo $_r['s_embed_code']; ?>
                        </div>
                    <!--<div class="item_podcast_name">
                            <textarea><?php echo $_r['s_embed_code']; ?></textarea>
                        </div>-->
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>