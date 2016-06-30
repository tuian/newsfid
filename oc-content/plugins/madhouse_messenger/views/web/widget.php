<script type="text/javascript">
    $(document).ready(function () {
    	$.ajax({
    		type: "GET",
    		url: "<?php echo mdh_messenger_ajax_url(); ?>",
    		data: {
    			"do": "widget"
    		},
    		dataType: "json",
    		success: function(response, text, jqXHR) {
    		    console.log(response);
    			var $this = $(".messenger.widget");
    			
    			// Inserts a small stamp to notify new messages.
    			$this.html($this.html() + "&nbsp;(" + response.nbUnread + ")");
    		}
    	});
    });
</script>
<a href="<?php echo mdh_messenger_inbox_url(); ?>" class="messenger widget">
    <?php _e("Messages", mdh_current_plugin_name()); ?>
</a>