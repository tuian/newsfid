<?php
if (!defined('OC_ADMIN') || OC_ADMIN !== true)
    exit('Access is not allowed.');
$conn = getConnection();
$stats = $conn->osc_dbFetchResults("SELECT * FROM %st_item_video_files f, %st_item_video_files_downloads d WHERE d.fk_i_file_id = f.pk_i_id ORDER BY f.fk_i_item_id ASC, f.pk_i_id ASC", DB_TABLE_PREFIX, DB_TABLE_PREFIX);
?>
<div style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 20px;">
        <div style="float: left; width: 100%;">
            <table style="width:600px;">
                <thead>
                    <tr>
                        <th style="width:40px;"><?php _e('Ad', 'item_video'); ?></th>
                        <th><?php _e('File', 'item_video'); ?></th>
                        <th style="width:100px;"><?php _e('Total downloads', 'item_video'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats as $stat) : ?>
                        <tr>
                            <td><?php echo $stat['fk_i_item_id']; ?></td>
                            <td><?php echo $stat['s_code'] . "_" . $stat['fk_i_item_id'] . "_" . $stat['s_name']; ?></td>
                            <td style="text-align: center;"><?php echo $stat['i_downloads']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div style="clear: both;"></div>										
    </div>
</div>
