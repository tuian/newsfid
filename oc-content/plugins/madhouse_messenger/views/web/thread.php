<?php

/*
 * ========================================================================================
 *
 * TO CUSTOMIZE
 *
 * COPY THIS FILE TO YOUR THEME IN
 * oc-content/themes/{your_theme_name}/plugins/madhouse_messenger/thread.php
 *
 * FOR TRANSLATION, RENAME ALL "madhouse_messenger" in this file by "your_theme_name"
 * Then update your po and mo file of your theme
 *
 * ========================================================================================
 */

/*
 * ========================================================================================
 * /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
 * REMOVE THE LINE UNDER IF YOU COPY THIS VIEW ON YOUR THEME
 * /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
 * ========================================================================================
 */

Madhouse_Utils_Plugins::overrideView();

/**
 * ========================================================================================
 * /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
 * REMOVE THE LINE AVOVE IF YOU COPY THIS VIEW ON YOUR THEME
 * /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
 * ========================================================================================
 */

?>

<link rel="stylesheet" type="text/css" href="<?php echo mdh_current_plugin_url("assets/css/web.css"); ?>" />
<script type="text/javascript">
	$(document).ready(function() {
		// Ajax to load previous message.
		var mmessengerp = <?php echo Params::getParam("p") ?>;

        $(".js-messenger-form").on('submit', function(e) {
            console.log("coucou");
            $(this).find("input[type=submit]").prop('disabled', true);
        });

		$(".more > a").click(function(e) {
			e.preventDefault();

			var more = $(".more");

			$.ajax({
				type: "GET",
				url: "<?php echo mdh_messenger_ajax_url(); ?>",
				data: {
					"do": "more",
					"n": <?php echo Params::getParam("n") ?>,
					"p": mmessengerp + 1,
					"tid": <?php echo Params::getParam("id"); ?>
				},
				dataType: "json",
				success: function(response, text, jqXHR) {
                    $.each(response.data, function(i, e) {
                        if(! e.is_auto) {
                            $("ul.messages").append(
                                '<li class="message box">' +
                                    '<div class="message-delete pull-right">' +
                                        '<a href="' + e.urls.delete + '">' +
                                            '<?php _e("Delete", "madhouse_messenger"); ?>' +
                                        '</a>' +
                                    '</div>' +
                                    '<ul class="meta unstyled inline">' +
                                        '<li class="message-sender">' +
                                            '<a href="' + e.sender.url + '">' +
                                                e.sender.name +
                                            '</a>' +
                                        '</li>' +
                                        '<li class="message-sent-date">' +
                                            '<em>' + e.sent_date.fb_formatted + '</em>' +
                                        '</li>' +
                                    '</ul>' +
                                    '<div class="text">' +
                                        e.text +
                                    '</div>' +
                                '</li>'
                            );
                        } else {
                            $("ul.messages").append(
                                '<div class="message box transparent">' +
                                    '<em>' +
                                        e.text +
                                        '<small>' + e.sent_date.fb_formatted + '</small>' +
                                    '</em>' +
                                '</div>'
                            );
                        }
                    });

					// Is there more messages in this thread?
					if(response.hasMore == false) {
						// Remove the link that triggers this ajax call.
						more.remove();
					}
					++mmessengerp;
				}
			});
		});
	});
</script>
<div class="messenger">
    <div class="wrapper">
        <h2><?php echo mdh_thread_title_default() ?></h2>
        <div class="main">
            <div class="box content">
                <form class="form-vertical js-messenger-form" action="<?php echo mdh_messenger_send_url(); ?>" method="POST">
                	<input type="hidden" name="tid" value="<?php echo Params::getParam("id"); ?>" />
            		<div class="control-group">
            		    <div class="controls">
                    		<textarea class="" name="message" placeholder="<?php _e("Write something...", "madhouse_messenger"); ?>" rows="3"></textarea>
                		</div>
                	</div>
            		<div class="control-group">
                        <input class="js-submit-message btn btn-primary" type="submit" value="<?php _e("Send", "madhouse_messenger"); ?>" />
                    </div>
                </form>
            </div>
            <div class="">
                <?php if(mdh_messenger_status_enabled() && (! mdh_messenger_status_for_owner() || (mdh_messenger_status_for_owner() && mdh_is_thread_item_owner()))): ?>
                    <div class="status-wrapper content">
                        <h5>
                            <?php _e("Status of this thread:", "madhouse_messenger"); ?>
                            <?php if(mdh_thread_has_status()): ?>
                                <small class="status status-<?php echo mdh_thread_status_name(); ?>"><?php echo mdh_thread_status_title(); ?></small>
                            <?php endif; ?>
                        </h5>
                        <ul class="unstyled inline">
                            <li><?php _e("Change to", "madhouse_messenger"); ?>:&nbsp;</li>
                            <?php while(mdh_has_status()): ?>
                                <?php if(! mdh_thread_has_status() || (mdh_thread_has_status() && mdh_thread_status_id() !== mdh_status_id())): ?>
                                    <li><a class="status status-<?php echo mdh_status_name(); ?>" href="<?php echo mdh_status_url(); ?>"><?php echo mdh_status_title(); ?></a></li>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                        <div class="clear"></div>
                    </div>
                <?php endif; ?>
                <ul class="messages unstyled">
                    <?php while(mdh_has_messages()): ?>
                        <?php if(! mdh_message_is_auto()): ?>
                            <li class="message box">
                                <div class="message-delete pull-right">
                                    <a href="<?php echo mdh_message_delete_url(); ?>">
                                        <?php _e("Delete", "madhouse_messenger"); ?>
                                    </a>
                                </div>
                                <ul class="meta unstyled inline">
                                    <li class="message-sender">
                                        <a href="<?php echo mdh_message_sender_url(); ?>">
                                            <strong><?php echo mdh_message_sender_name(); ?></strong>
                                        </a>
                                    </li>
                                    <li class="message-sent-date">
                                        <em><?php echo mdh_message_formatted_sent_date(); ?></em>
                                    </li>
                                </ul>
                                <div class="text">
                                    <?php echo mdh_message_text(); ?>
                                </div>
                                <div class="message-date  inline">
                                    <?php if(mdh_message_is_read()): ?>
                                        <div class="read">
                                            <em><?php _e("Read ", "madhouse_messenger"); ?>
                                                <?php echo mdh_message_formatted_read_date(); ?>
                                            </em>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php else: ?>
                            <div class="message box transparent">
                                <em>
                                    <?php echo mdh_message_text(); ?>
                                    <small><?php echo mdh_message_formatted_sent_date(); ?></small>
                                </em>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </ul>
                <?php if(mdh_thread_has_more_messages()): ?>
                    <div class="more box">
                        <a href="#" class="btn btn-primary">
                            <?php _e("Show previous messages", "madhouse_messenger"); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="sidebar">
            <div class="item content">
                <h3>
                    <?php _e("Inquiry about", "madhouse_messenger"); ?>
                    <?php if(mdh_is_thread_item_owner()): ?>
                        <small><?php _e("(your ad)", "madhouse_messenger"); ?></small>
                    <?php endif; ?>
                </h3>
                <?php if(
                        mdh_thread_had_item() ||
                        (mdh_thread_has_item() && osc_item_is_expired()) ||
                        (mdh_thread_has_item() && function_exists("mdh_moreedit_is_archived") && mdh_moreedit_is_archived()) ||
                        (mdh_thread_has_item() && function_exists("mdh_moreedit_is_stopped") && mdh_moreedit_is_stopped())
                    ):
                ?>
                    <em><?php _e("A deleted/disabled ad", "madhouse_messenger"); ?></em>
                <?php elseif(mdh_thread_has_item() && (osc_item_is_spam() || ! osc_item_is_enabled() || ! osc_item_is_active())): ?>
                    <em><?php _e("A blocked/spam ad", "madhouse_messenger"); ?></em>
                <?php elseif(mdh_thread_has_item()): ?>
                    <a href="<?php echo osc_item_url(); ?>">
                        <?php echo osc_item_title(); ?><br />
                        <?php echo osc_item_city(); ?>,&nbsp;<?php echo osc_item_formated_price(); ?>
                        <div class="thumbnail">
                            <?php if(osc_has_item_resources()): ?>
                                <img src="<?php echo osc_resource_preview_url(); ?>" />
                            <?php else: ?>
                                <em><?php _e("No pictures for this ad!", "madhouse_messenger"); ?></em>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php else: ?>
                    <em><?php _e("No item linked to this thread.", "madhouse_messenger"); ?></em>
                <?php endif; ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
