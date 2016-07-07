<h2><?php _e("Item Video", 'item_video'); ?></h2>
<div class="box">
    <div class="box dg_files">
        <div class="row">
            <p><?php printf(__('Allowed extensions are %s. Any other file will not be uploaded', 'item_video'), osc_get_preference('item_video_allowed_ext', 'item_video') ); ?></p>
        </div>
        <?php
        if ($item_video_files != null && is_array($item_video_files) && count($item_video_files) > 0) :
            foreach ($item_video_files as $_r) :
                ?>
                <div id="<?php echo $_r['pk_i_id']; ?>" fkid="<?php echo $_r['fk_i_item_id']; ?>" name="<?php echo $_r['s_name']; ?>">
                    <p><?php echo $_r['s_actual_name']; ?> <a href="javascript:delete_item_video_file(<?php echo $_r['pk_i_id'] . ", " . $_r['fk_i_item_id'] . ", '" .  $_r['s_name'] . "', '" . $secret . "'"; ?>);"  class="delete"><?php _e('Delete', 'item_video'); ?></a></p>
                </div>
                <?php
            endforeach;
        endif;
        ?>
        <div id="item_video_files1">
            <?php if (osc_get_preference('item_video_max_file_number') == 0 || (osc_get_preference('item_video_max_file_number') != 0 && count($item_video_files) < osc_get_preference('item_video_max_file_number'))) { ?>
                <div class="row">
                    <input type="file" name="item_video_files[]" />
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <a href="#" onclick="add_new_mp3();
                    return false;"><?php _e('Add new video file', 'item_video'); ?></a>
        </div>
    </div>
</div>
<script type="text/javascript">
    var dgIndex = 0;
    function gebi(id) {
        return document.getElementById(id);
    }
    function ce(name) {
        return document.createElement(name);
    }
    function re(id) {
        var e = gebi(id);
        e.parentNode.removeChild(e);
    }
    function add_new_mp3() {
        var max = <?php echo osc_get_preference('item_video_max_file_number'); ?>;
        var num_img = $('input[name="item_video_files[]"]').size() + $("a.delete").size();
        if ((max != 0 && num_img < max) || max == 0) {
            var id = 'p-' + dgIndex++;
            var i = ce('input');
            i.setAttribute('type', 'file');
            i.setAttribute('name', 'item_video_files[]');
            var a = ce('a');
            a.style.fontSize = 'x-small';
            a.style.paddingLeft = '10px';
            a.setAttribute('href', '#');
            a.setAttribute('divid', id);
            a.onclick = function () {
                re(this.getAttribute('divid'));
                return false;
            }
            a.appendChild(document.createTextNode('<?php _e('Remove'); ?>'));
            var d = ce('div');
            d.setAttribute('id', id);
            d.setAttribute('style', 'padding: 4px 0;')

            d.appendChild(i);
            d.appendChild(a);
            gebi('dg_files').appendChild(d);
            $("#" + id + " input:file").uniform();
        } else {
            alert('<?php _e('Sorry, you have reached the maximum number of mp3 files per ad'); ?>');
        }
    }

    setInterval("add_file_field()", 250);
    function add_file_field() {
        var count = 0;
        $('input[name="item_video_files[]"]').each(function (index) {
            if ($(this).val() == '') {
                count++;
            }
        });
        var max = <?php echo osc_get_preference('item_video_max_file_number'); ?>;
        var num_img = $('input[name="item_video_files[]"]').size() + $("a.delete").size();
        if (count == 0 && (max == 0 || (max != 0 && num_img < max))) {
            add_new_mp3();
        }
    }

    function delete_item_video_file(id, item_id, name, secret) {
        var result = confirm('<?php echo __('This action can\\\'t be undone. Are you sure you want to continue?', 'item_video'); ?>');
        if (result) {           
            $.ajax({
                type: "POST",
                url: '<?php echo osc_route_ajax_url('item-video-ajax'); ?>&id=' + id + '&item=' + item_id + '&code=' + name + '&secret=' + secret,
                dataType: 'json',
                success: function (data) {
                    var class_type = "error";
                    if (data.success) {
                        var div_name = 'div[name="' + name + '"]';
                        $(div_name).remove();
                        class_type = "ok";
                    }
                    var flash = $("#flash_js");
                    var message = $('<div>').addClass('pubMessages').addClass(class_type).attr('id', 'FlashMessage').html(data.msg);
                    flash.html(message);
                    $("#FlashMessage").slideDown('slow').delay(3000).slideUp('slow');
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
    }
</script>