<?php
require_once '../../../oc-load.php';
require_once 'functions.php';

$item_id = $_REQUEST['item_id'];

function get_item_location($item_id) {
    $item_data = new DAO();
    $db_prefix = DB_TABLE_PREFIX;
    $item_data->dao->select("item.*");
    $item_data->dao->from("{$db_prefix}t_item_location AS item");
    $item_data->dao->where("item.fk_i_item_id= {$item_id}");
    $result = $item_data->dao->get();
    $item = $result->row();
    return $item;
}

$item_location = get_item_location($item_id);

function get_item($item_id) {
    $item = new DAO();
    $db_prefix = DB_TABLE_PREFIX;
    $item->dao->select("cat.*");
    $item->dao->from("{$db_prefix}t_item AS cat");
    $item->dao->where("cat.pk_i_id= {$item_id}");
    $result = $item->dao->get();
    $item_data = $result->row();
    return $item_data;
}

$item = get_item($item_id);

osc_query_item(array('id' => $item_id, 'results_per_page' => 1));
while (osc_has_custom_items()):
    ?>

    <!-- Modal -->
    <div id="item_popup_modal" class="modal fade item_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="box-body">
                    <?php //osc_item($item_id);   ?>
                    <div id="columns">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="popup">
                                        <?php user_follow_box(osc_logged_user_id(), osc_item_user_id()); ?>
                                        <div class="user-block">
                                            <?php
                                            $user = get_user_data(osc_item_user_id());
                                            if (!empty($user['s_path'])):
                                                $user_image_url = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . "_nav." . $user['s_extension'];
                                            else:
                                                $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                            endif;
                                            ?>
                                            <img class="img-circle" src="<?php echo $user_image_url ?>" alt="<?php echo $user['user_name'] ?>">
                                            <span class="username">
                                                <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>"><?php echo $user['user_name'] ?></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 item-title">
                                    <h2><?php echo osc_item_title(); ?></h2>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                    <?php if (osc_get_preference('position7_enable', 'flatter_theme') != '0') { ?>
                                        <div id="position_widget"<?php
                                        if (osc_get_preference('position7_hide', 'flatter_theme') != '0') {
                                            echo " class='hidden-xs'";
                                        }
                                        ?>>
                                            <div class="dd-widget position_7">
                                                <?php echo osc_get_preference('position7_content', 'flatter_theme'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div id="content">
                                        <?php item_resources(osc_item_id()) ?>

                                        <div id="itemdetails" class="clearfix">
                                            <div class="description">
                                                <?php echo osc_item_description(); ?>
                                            </div>                                            

                                            <div id="extra-fields">
                                                <?php //osc_run_hook('item_detail', osc_item());   ?>
                                            </div>

                                        </div> <!-- Description End -->

                                    </div><!-- Item Content End -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="social-share">
                                                <li>
                                                    <?php echo item_like_box(osc_logged_user_id(), osc_item_id()) ?></li>

                                                &nbsp;&nbsp;
                                                <li>
                                                    <?php echo user_share_box(osc_logged_user_id(), osc_item_id()) ?></li>
                                                <li>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <span class="comment_text"><i class="fa fa-comments"></i>&nbsp;<span class="comment_count_<?php echo osc_item_id(); ?>"><?php echo get_comment_count(osc_item_id()) ?></span>&nbsp;
                                                        <?php echo 'Comments' ?>
                                                    </span></li>
                                                &nbsp;&nbsp;
                                                <?php if (osc_is_web_user_logged_in()): ?>
                                                    <li> <span><?php echo 'Tchat' ?></span>&nbsp;</li>
                                                <?php endif; ?>

                                                <li class="facebook margin-left-15">
                                                    <a class="whover" title="" data-toggle="tooltip" href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent('<?php echo osc_item_url(); ?>'), 'facebook-share-dialog', 'height=279, width=575');
                                                                return false;" data-original-title="<?php _e("Share on Facebook", 'flatter'); ?>">
                                                        <i class="fa fa-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="twitter">
                                                    <a class="whover" title="" href="https://twitter.com/intent/tweet?text=<?php echo osc_item_title(); ?>&url=<?php echo osc_item_url(); ?>" data-toggle="tooltip" data-original-title="<?php _e("Share on Twitter", 'flatter'); ?>"><i class="fa fa-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="googleplus">
                                                    <a class="whover" title="" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,height=600,width=600');
                                                                return false;" href="https://plus.google.com/share?url=<?php echo osc_item_url(); ?>" data-toggle="tooltip" data-original-title="<?php _e("Share on Google+", 'flatter'); ?>">
                                                        <i class="fa fa-google-plus"></i>
                                                    </a>
                                                </li> 
                                                <li> 
                                                    <?php if (osc_is_web_user_logged_in() && osc_logged_user_id() == osc_item_user_id()) { ?>
                                                        <div class="edit edit_post" >
                                                            <i class="fa fa-pencil"></i>
                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="comments_container_<?php echo osc_item_id(); ?>">
                                                <?php
                                                $c_data = get_item_comments(osc_item_id());
                                                if ($c_data):
                                                    foreach ($c_data as $k => $comment_data):
                                                        ?>
                                                        <?php
                                                        $comment_user = get_user_data($comment_data['fk_i_user_id']);
                                                        if ($comment_user['s_path']):
                                                            $user_image_url = osc_base_url() . $comment_user['s_path'] . $comment_user['pk_i_id'] . "_nav." . $comment_user['s_extension'];
                                                        else:
                                                            $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                                        endif;
                                                        ?>
                                                        <div class="box-footer box-comments">
                                                            <div class="box-comment">
                                                                <!-- User image -->
                                                                <img class="img-circle" src="<?php echo $user_image_url ?>" alt="<?php echo $comment_user['user_name'] ?>">

                                                                <div class="comment-area">
                                                                    <span class="username">
                                                                        <?php echo $comment_user['user_name'] ?>
                                                                        <!--                                                                        <div class="dropdown  pull-right">
                                                                                                                                                    <i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-hidden="true"></i>
                                                                                                                                                    <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                                                                                                                                                        <li class="delete_cmnt" onclick="deleteComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item_id; ?>)"><a>Supprimer la publication</a></li>
                                                                                                                                                        <li class="edit_cmnt comment_text_<?php echo $comment_data['pk_i_id']; ?>" data-item-id='<?php echo $item['pk_i_id']; ?>' data_text="<?php echo $comment_data['s_body']; ?>" data_id="<?php echo $comment_data['pk_i_id']; ?>" onclick="editComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item_id; ?>)"><a>Modifier</a></li>
                                                                                                                                                        <li><a></a></li>
                                                                                                                                                        <li><a>Sponsoriser</a></li>
                                                                                                                                                        <li><a>Remonter en tête de liste</a></li>
                                                                                                                                                        <li><a></a></li>
                                                                                                                                                        <li><a>Signaler la publication</a></li>
                                                                        
                                                                                                                                                    </ul>
                                                                                                                                                </div>-->
                                                                    </span><!-- /.username -->
                                                                    <span class="comment_text comment_edt_<?php echo $comment_data['pk_i_id']; ?>" data-text="<?php echo $comment_data['s_body']; ?>">
                                                                        <?php echo $comment_data['s_body']; ?>
                                                                    </span>
                                                                    <span class="text-muted pull-right"><?php echo time_elapsed_string(strtotime($comment_data['dt_pub_date'])) ?></span>                                                                    
                                                                </div>
                                                                <!-- /.comment-text -->
                                                            </div>                       
                                                        </div>                  
                                                        <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </div>
                                            <!-- /.box-footer -->
                                            <?php if (osc_is_web_user_logged_in()): ?>
                                                <div class="box-footer">
                                                    <form class="comment_form" data_item_id="<?php echo osc_item_id() ?>" data_user_id ="<?php echo osc_logged_user_id() ?>" method="post">
                                                        <?php
                                                        $current_user = get_user_data(osc_logged_user_id());
                                                        $current_user_image_url = '';

                                                        if ($current_user['s_path']):
                                                            $current_user_image_url = osc_base_url() . $current_user['s_path'] . $current_user['pk_i_id'] . "_nav." . $current_user['s_extension'];
                                                        else:
                                                            $current_user_image_url = osc_current_web_theme_url('images/user-default.jpg');
                                                        endif;
                                                        ?>
                                                        <img class="img-responsive img-circle img-sm" src="<?php echo $current_user_image_url ?>" alt="<?php echo $current_user['user_name'] ?>">
                                                        <!-- .img-push is used to add margin to elements next to floating images -->
                                                        <div class="img-push">
                                                            <input type="text" class="form-control input-sm comment_text" placeholder="Press enter to post comment">
                                                        </div>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if (osc_get_preference('google_adsense', 'flatter_theme') !== '0' && osc_get_preference('adsense_listing', 'flatter_theme') != null) { ?>
                                        <div class="pagewidget">
                                            <div class="gadsense">
                                                <?php echo osc_get_preference('adsense_listing', 'flatter_theme'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!-- Comments Template -->

                                </div><!-- Item Content -->

                                <!-- Sidebar Template -->

                            </div>

                        </div>
                    </div>
                </div>              
            </div>

        </div>
    </div>
<?php endwhile; ?>
<script>
    $(document).ready(function () {
        $('.error-desc').hide();
        $('.error-title').hide();
        $('.error-term').hide();
        $('.error-btn').hide();
        $('#post_update').submit(function () {
            var title = $('.p_title').val();
            var discription = $('.p_disc').val();
            if (title != '') {
                $('.error-title').hide();
            } else {
                $('.error-title').show();
                $('.error-btn').show();
                return false;
            }
            if (discription != '')
            {
                $('.error-desc').hide();
            }
            else {
                $('.error-desc').show();
                $('.error-btn').show();
                return false;
            }

            if (!$("#publier").is(":checked")) {
                $('.error-term').show();

                return false;
            }
            return true;

        });
    });
    $(".edit_post").click(function () {
        $('#popup-free-user-post').modal('show');
    });
</script>
<script>
    $(document).ready(function () {
        $('#s_region_name').typeahead({
            source: function (query, process) {
                var $items = new Array;
                var c_id = $('#countryId').val();
                console.log(c_id);
                if (c_id) {
                    $items = [""];
                    $.ajax({
                        url: "<?php echo osc_current_web_theme_url('region_ajax.php') ?>",
                        dataType: "json",
                        type: "POST",
                        data: {region_name: query, country_id: c_id},
                        success: function (data) {
                            $.map(data, function (data) {
                                var group;
                                group = {
                                    id: data.pk_i_id,
                                    name: data.s_name,
                                };
                                $items.push(group);
                            });

                            process($items);
                        }
                    });
                } else {
                    alert('Please select country first');
                }
            },
            afterSelect: function (obj) {
                $('#s_region_id').val(obj.id);
            },
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#s_city_name').typeahead({
            source: function (query, process) {
                var $items = new Array;
                var region_id = $('#s_region_id').val();
                if (region_id) {
                    $items = [""];
                    $.ajax({
                        url: "<?php echo osc_current_web_theme_url('search_city_by_region.php') ?>",
                        dataType: "json",
                        type: "POST",
                        data: {city_name: query, region_id: region_id},
                        success: function (data) {
                            $.map(data, function (data) {
                                var group;
                                group = {
                                    id: data.pk_i_id,
                                    name: data.city_name,
                                };
                                $items.push(group);
                            });

                            process($items);
                        }
                    });
                } else {
                    alert('Please select region first');
                }
            },
            afterSelect: function (obj) {
                //$('#sRegion').val(obj.id);
            },
        });
    });
</script>
<script>
    $(".post_type_switch").on('click', function () {
        var $box = $(this);
        if ($box.is(":checked")) {
            var group = ".post_type_switch";
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
        var selected_post_type = $('.post_type_switch').filter(':checked');

        if (selected_post_type.attr('data_post_type') == 'music' || selected_post_type.attr('data_post_type') == 'podcast') {
            var duplicate_post_media = $('#post_media').clone();
            $('#post_media').remove();
            $(selected_post_type).parent().after(duplicate_post_media);
        }
        if (selected_post_type.attr('data_post_type') == 'gif') {
            var duplicate_post_media2 = $('#post_media').clone();
            $('#post_media').remove();
            $(selected_post_type).parent().after(duplicate_post_media2);
        }
        if (selected_post_type.attr('data_post_type') == 'image' || selected_post_type.attr('data_post_type') == 'video') {
            var duplicate_post_media = $('#post_media').clone();
            $('#post_media').remove();
            $('.post_file_upload_container').append(duplicate_post_media);
        }

        if (selected_post_type.attr('data_post_type') == 'podcast' || selected_post_type.attr('data_post_type') == 'video') {
            $('#post_media').attr('type', 'text');
        } else {
            $('#post_media').attr('type', 'file');
        }
    });
</script>
<script>
    $(document).on('change', '.user_role_selector', function () {
        $.ajax({
            url: "<?php echo osc_current_web_theme_url('user_info_ajax.php'); ?>",
            data: {
                action: 'user_role',
                user_role_id: role_id,
            },
            success: function (data, textStatus, jqXHR) {
                if (data != 0) {
                    $('.user_role_name').text(data);
                }
                $('.user_role_selector').hide();
                $('.user_role_name').show();
            }
        });
    });
</script>