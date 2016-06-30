
<?php mdh_current_plugin_path("views/admin/navigation.php"); ?>

<div class="space-in-md bg-light dk b-b">
    <div id="js-text-description">
        <p><?php printf(__("Use this tool to regenerate thumbnails for all profile pictures that users have uploaded to your website. This is useful if you've changed any of the thumbnail, preview or normal dimensions on %sthe avatar settings page%s.", mdh_current_plugin_name()), '<a href="' . mdh_avatar_settings_url() . '">','</a>'); ?></p>
        <p>
        <?php _e("Thumbnail regeneration is not reversible, but you can just change your thumbnail dimensions back to the old values and click the button again if you don't like the results.", mdh_current_plugin_name()) ?>
        </p>
        <p>
            <?php _e("To begin, just press the button below.", mdh_current_plugin_name()) ?>
        </p>
    </div>
</div>
<div class="space-in-md" id="js-text-action">
    <button type="submit" id="js-run-move" class="btn btn-primary"><?php _e("Regenerate all profile pictures", mdh_current_plugin_name()); ?></button>
</div>
<div class="space-in-md">
    <div class="progress">
      <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
        <span class="sr-only js-eta" id="js-eta">0%</span>
      </div>
    </div>

    <span class="text-lg font-bold"><?php _e("Progress", mdh_current_plugin_name()); ?> : </span><span class="js-eta text-lg font-bold">0%</span>
    <ul id="js-processed" class="list-unstyled"></ul>

</div>
<script type="text/javascript">

    $(document).ready(function(){
        $("#js-run-move").click(function(e){

            e.preventDefault();

            if(running) {
                running = false;
                $(this).attr('disabled', true);
            } else {
                running = true;
                ajaxCall(0, 0);
                $("#js-text-description").html(runningTxt);
                $(this).html("Abort resizing images");
            }
        });

        // keep track of how many requests failed
        var $progressBar       = $(".progress-bar"),
            $jsEta             = $(".js-eta"),
            countResources     = <?php echo Madhouse_Avatar_Model::newInstance()->countResources()?>,
            processedResrouces = 0,
            failed             = 0,
            interval           = 200,
            eta                = 0,
            doLength           = <?php echo (Params::getParam("route")==mdh_current_plugin_name()."_move")?"5":"1"; ?>,
            runningTxt         = '<?php _e("Please be patient while the thumbnails are regenerated. This can take a while if your server is slow (inexpensive hosting) or if you have many images. <strong>Do not navigate away from this page until this script is done or the thumbnails will not be resized</strong>. You will be notified via this page when the regenerating is completed.") ?>',
            running            = false,
            totalAjaxTime      = new Date().getTime();
        if (countResources == 0) {
            $("#js-run-move").prop("disabled", true);
            $("#js-run-move").html("No resources found");
        };

        function ajaxCall(next, processed){
            setTimeout(function(){
                var ajaxTime       = new Date().getTime();
                $.ajax({
                    url: "<?php echo mdh_avatar_ajax_url() ?>",
                    data: {
                        do: "<?php echo (Params::getParam("route")==mdh_current_plugin_name()."_move")?"move":"regenerate"; ?>",
                        start: next,
                        length: doLength,
                        processed: processed
                    },
                    dataType: 'json',
                    success: function(data) {
                        eta = data.processed / countResources *100;

                        $progressBar.css({"width":eta +"%"});
                        $jsEta.each(function (i, e) {
                            $(e).html(eta.toFixed(2) + "%");
                        });
                        var time = (new Date().getTime()-ajaxTime)/ 1000;
                        $("#js-processed").prepend('<li><span class="font-bold space-out-r"></span>' + data.resourcesProcessed.join(" | ") + " was successfully resized in " + time + " seconds</span></li>");

                        processedResrouces +=1;

                        if (!running || processedResrouces == countResources) {
                            var time = (new Date().getTime()- totalAjaxTime)/ 1000;
                            $("#js-text-action"). html('<div class="alert alert-success">All done! ' + processedResrouces + ' image(s) were successfully resized in ' + time + ' seconds and there were ' + failed + ' failures.</div>')
                        } else {
                            if(data.next < countResources) {
                                ajaxCall(data.next, data.processed);
                            }
                        }

                    },
                    error: function (request, status, error) {
                        ++failed;
                        processedResrouces +=1;
                        $("#js-processed").prepend('<li><span class="font-bold space-out-r text-danger">Processed id failed</span>' + next + ' and the next ' + doLength-1 + '<br/>error messege : ' + request.responseText + " " + error + "</span></li>");
                        // give the server some breathing room by
                        // increasing the interval
                        interval = interval + 100;
                        if (!running || processedResrouces == countResources) {
                            var time = (new Date().getTime()- totalAjaxTime)/ 1000;
                            $("#js-text-action"). html('<div class="alert alert-success">All done! ' + processedResrouces + ' image(s) were successfully resized in ' + time + ' seconds and there were ' + failed + ' failures.</div>')
                        } else {
                            ajaxCall(next+doLength, processed);
                        }
                    },
                    complete: function(jqXHR, text) {
                    }
               });
            }, interval);
        }
    });
</script>
