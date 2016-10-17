
<script>
    $(document).ready(function () {
        $(document).on('click', '.load_more_comment', function () {
            var count = $(this).siblings('.comment_count').text();
            $(this).parent().parent().children('.load_more').toggle(500);
            if ($(this).hasClass('load_comment_text')) {
                $(this).html('<i class="fa fa-plus-square-o"></i> <?php _e("Display", "flatter") ?>' + count + ' <?php _e("comments more", "flatter") ?> ');
                $(this).removeClass('load_comment_text');
            } else {
                $(this).html('<i class="fa fa-minus-square-o"></i> <?php _e("Hide comments", "flatter") ?>');
                $(this).addClass('load_comment_text');
            }
        });

        $(document).on('click', '.like_box', function () {
            var item_id = $(this).attr('data_item_id');
            var user_id = $(this).attr('data_user_id');
            var action = $(this).attr('data_action');
            $.ajax({
                url: '<?php echo osc_current_web_theme_url() . 'item_like_ajax.php' ?>',
                data: {
                    item_id: item_id,
                    user_id: user_id,
                    action: action
                },
                success: function (data, textStatus, jqXHR) {
                    $('.item_like_box' + item_id).replaceWith(data);
                }
            });
        });

        $(document).on('click', '.follow-user', function () {
            var user_id = $(this).attr('data_current_user_id');
            var follow_user_id = $(this).attr('data_follow_user_id');
            var action = $(this).attr('data_action');
            $.ajax({
                url: '<?php echo osc_current_web_theme_url() . 'user_follow_ajax.php' ?>',
                data: {
                    user_id: user_id,
                    follow_user_id: follow_user_id,
                    action: action
                },
                success: function (data, textStatus, jqXHR) {
                    $('.follow_box_' + user_id + follow_user_id).replaceWith(data);
                }
            });
        });

        $(document).on('click', '.follow-user-btn', function () {
            var user_id = $(this).attr('data_current_user_id');
            var follow_user_id = $(this).attr('data_follow_user_id');
            var action = $(this).attr('data_action');
            $.ajax({
                url: '<?php echo osc_current_web_theme_url() . 'user_follow_btn_ajax.php' ?>',
                data: {
                    user_id: user_id,
                    follow_user_id: follow_user_id,
                    action: action
                },
                success: function (data, textStatus, jqXHR) {
                    $('.follow_btn_box_' + user_id + follow_user_id).replaceWith(data);
                }
            });
        });

        $(document).on('click', '.share_box', function () {
            var item_id = $(this).attr('data_item_id');
            var user_id = $(this).attr('data_user_id');
            var action = $(this).attr('data_action');
            $.ajax({
                url: '<?php echo osc_current_web_theme_url() . 'item_share_ajax.php' ?>',
                data: {
                    item_id: item_id,
                    user_id: user_id,
                    action: action
                },
                success: function (data, textStatus, jqXHR) {
                    $('.item_share_box' + user_id + item_id).replaceWith(data);
                }
            });
        });

        $(document).on('click', '.item_title_head', function () {
            var item_id = $(this).attr('data_item_id');
            $.ajax({
                url: '<?php echo osc_current_web_theme_url() . 'popup_ajax.php' ?>',
                data: {
                    item_id: item_id,
                },
                success: function (data, textStatus, jqXHR) {
                    $('.popup').empty().append(data);
                    $('#item_popup_modal').modal('show');
                }
            });
        });

        $(document).on('keypress', 'form.comment_form', function (e) {
            var key = e.which || e.keyCode;
            if (key == 13)
            {
                var comment_form = $(this);
                var item_id = comment_form.attr('data_item_id');
                var user_id = comment_form.attr('data_user_id');
                var comment_text = comment_form.find('.comment_text').val();
                if (!comment_text) {
                    return false;
                }
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url('item_comment_ajax.php') ?>",
                    type: 'POST',
                    data: {user_id: user_id, item_id: item_id, comment_text: comment_text},
                    success: function (data, textStatus, jqXHR) {
                        comment_form.find('.comment_text').val('');
                        $('.comments_container_' + item_id).replaceWith(data);
                        var current_comment_number = $('.comment_count_' + item_id).first().html();
                        $('.comment_count_' + item_id).html(parseInt(current_comment_number) + 1);
                    }
                });
                return false;
            }
        });
        $(document).on('focus.textarea', '.comment_text', function(){
			var savedValue = this.value;
			this.value = '';
			this.baseScrollHeight = this.scrollHeight;
			this.value = savedValue;
		})
		.on('input.textarea', '.comment_text', function(){
			var minRows = this.getAttribute('data-min-rows')|0,
				 rows;
			this.rows = minRows;
        console.log(this.scrollHeight , this.baseScrollHeight);
			rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 17);
			this.rows = minRows + rows;
		});

        $(document).on('click', '.watch_box', function () {
            var item_id = $(this).attr('data_item_id');
            var user_id = $(this).attr('data_user_id');
            var action = $(this).attr('data_action');
            $.ajax({
                url: '<?php echo osc_current_web_theme_url() . 'item_watchlist_ajax.php' ?>',
                data: {
                    item_id: item_id,
                    user_id: user_id,
                    action: action
                },
                success: function (data, textStatus, jqXHR) {
                    $('.item_watch_box' + user_id + item_id).replaceWith(data);
                }
            });
        });

    });
</script>
