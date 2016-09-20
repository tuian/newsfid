<?php
require '../../../oc-load.php';
require 'functions.php';
$comment_user_id = osc_logged_user_id();
$data = new DAO();
$data->dao->select('item.*, item_location.*, item_user.pk_i_id as item_user_id, item_user.has_private_post as item_user_has_private_post');
$data->dao->join(sprintf('%st_item_location AS item_location', DB_TABLE_PREFIX), 'item_location.fk_i_item_id = item.pk_i_id', 'INNER');
$data->dao->join(sprintf('%st_user AS item_user', DB_TABLE_PREFIX), 'item_user.pk_i_id = item.fk_i_user_id', 'INNER');
$data->dao->from(sprintf('%st_item AS item', DB_TABLE_PREFIX));
$data->dao->orderBy('item.dt_pub_date', 'DESC');
$following_user = get_user_following_data($comment_user_id);
if ($following_user):
    $data->dao->where(sprintf('(item.fk_i_category_id IN (%s) OR item.fk_i_user_id IN (%s))', implode(',', get_user_categories($comment_user_id)), implode(',', $following_user)));
endif;

if (isset($_REQUEST['search_by'])):
    $city_id = $_REQUEST['country_code'];
    $region_id = $_REQUEST['region_id'];
    $country_code = $_REQUEST['country_code'];
    $data->dao->where('item_location.fk_c_country_code', $country_code);
    $data->dao->where('item_location.fk_i_city_id', $city_id);
    $data->dao->where('item_location.pk_i_id', $region_id);
endif;

if (!empty($_REQUEST['category_id'])):
    $categories = $_REQUEST['category_id'];
    if (Category::newInstance()->isRoot($_REQUEST['category_id'])):
        $categories = array_column(Category::newInstance()->findSubcategories($_REQUEST['category_id']), 'pk_i_id');
        $categories = implode(',', $categories);
    endif;
    $data->dao->where(sprintf('item.fk_i_category_id IN (%s)', $categories));
else:
    $data->dao->whereIn('item.fk_i_category_id', get_user_categories($comment_user_id));
endif;

if (!empty($_REQUEST['country_id'])):
    $data->dao->where('item_location.fk_c_country_code', $_REQUEST['country_id']);
endif;

if (isset($_REQUEST['location_type'])):
    $location_type = $_REQUEST['location_type'];
    $location_id = isset($_REQUEST['location_id']) ? $_REQUEST['location_id'] : '';
    if ($_REQUEST['location_type'] == 'world'):

    elseif ($_REQUEST['location_type'] == 'country'):
        $data->dao->where('item_location.fk_c_country_code', $location_id);
    elseif ($_REQUEST['location_type'] == 'city'):
        if (!empty($location_id)):
            $data->dao->where('item_location.fk_i_city_id', $location_id);
        endif;
    endif;
endif;
if (!empty($_REQUEST['post_type'])):
    if ($_REQUEST['post_type'] != 'all'):
        $data->dao->where('item.item_type', $_REQUEST['post_type']);
    endif;
endif;

if ($following_user):
    $following_user = implode(',', $following_user);
    $data->dao->where("(item_user.has_private_post = 0 OR (item_user.has_private_post = 0 AND item.fk_i_user_id IN ({$following_user})))");
else:
    $data->dao->where("item_user.has_private_post = 0");
endif;

//$data->dao->where(sprintf('item.fk_i_user_id !=%s', osc_logged_user_id()));
//if (empty($location_id) && empty($_REQUEST['category_id'])):
//    $data->dao->orWhere(sprintf('item.fk_i_user_id = %s', osc_logged_user_id()));
//endif;
$page_number = isset($_REQUEST['page_number']) ? $_REQUEST['page_number'] : 0;
$offset = 20;
$start_from = $page_number * $offset;
$data->dao->limit($start_from, $offset);
$result = $data->dao->get();
if ($result) {
    $items = $result->result();
} else {
    $items = array();
}
if ($items):
    $item_result = Item::newInstance()->extendData($items);
    $conn = DBConnectionClass::newInstance();
    $data = $conn->getOsclassDb();
    $comm = new DBCommandClass($data);
    $db_prefix = DB_TABLE_PREFIX;
    foreach ($item_result as $k => $item):
        osc_query_item(array('id' => $item['pk_i_id'], 'results_per_page' => 1000));
        while (osc_has_custom_items()):
            $date = osc_item_field("dt_pub_date");
            setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
            $date_in_french = strftime("%d %B %Y ", strtotime($date));
            $item_id = osc_item_id();
            $user = get_user_data(osc_item_user_id());

            if (!empty($user['s_path'])):
                $user_image_url = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . "_nav." . $user['s_extension'];
            else:
                $user_image_url = osc_current_web_theme_url('images/user-default.jpg');
            endif;
            ?>
            <div class="box box-widget">
                <div class="box-header with-border">
                    <div class="user-block ">
                        <div class="user_image">
                            <?php get_user_profile_picture($user['user_id']); ?>
                        </div>
                        <span class="username"><a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>"><?php echo $user['user_name'] ?></a>
                            <?php if (osc_logged_user_id() == $user['user_id']): ?>
                                <button type="button" class="btn btn-box-tool pull-right dropdown"><i class="fa fa-chevron-down" data-toggle="dropdown"></i>
                                    <ul class="dropdown-menu padding-10" role="menu" aria-labelledby="menu1">
                                        <li class="delete_post" data-user-id="<?php echo $user['user_id'] ?>" data-post-id="<?php echo $item_id; ?>"><a><!--Supprimer la publication-->Delete</a></li>
                                        <li class="edit_user_post" item_id="<?php echo $item_id; ?>"><a><!--Modifier--> Edit</a></li>
                                        <?php
                                        $items = get_item_premium();
                                        if (!in_array($item_id, $items)):
                                            $pack = get_user_pack_details(osc_logged_user_id());
                                            if ($pack['remaining_post'] == 0):
                                                ?>
                                                <li class="premium" item_id="<?php echo $item_id; ?>"><a href="<?php echo osc_current_web_theme_url('promoted_post_pack.php') ?>"> Premium</a></li>
                                            <?php else: ?>
                                                <li class="premium add_premium_post" item_id="<?php echo $item_id; ?>"><a href="javascript:void(0)"> Premium</a></li>
                                            <?php
                                            endif;
                                        endif;
                                        ?>
                                        <!--                                    <li><a></a></li>
                                                                                        <li class="disabled light_gray padding-left-10per">Sponsoriser</li>
                                                                                        <li class="disabled light_gray padding-left-10per">Remonter en tête de liste</li>
                                                                                        <li><a></a></li>
                                                                                        <li><a>Signaler la publication</a></li>-->
                                    </ul>
                                </button>
                            <?php endif; ?>
                        </span>
                        <span class="description"><?php echo time_elapsed_string(strtotime($item['dt_pub_date'])); ?></span>                        
                    </div>
                    <!--                     /.user-block 
                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Mark as read">
                                                <i class="fa fa-circle-o"></i></button>
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                        </div>
                                         /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p class="item_title_head" data_item_id="<?php echo osc_item_id(); ?>"><?php echo osc_item_title(); ?></p>
                    <div class="item_title_head" data_item_id="<?php echo osc_item_id(); ?>">                    
                        <?php item_resources(osc_item_id()); ?>
                    </div>
                    <p><?php //echo osc_highlight(osc_item_description(), 200);                                                  ?></p>

                    <?php echo item_like_box(osc_logged_user_id(), osc_item_id()) ?>

                    &nbsp;&nbsp;

                    <?php echo user_share_box(osc_logged_user_id(), osc_item_id()) ?>

                    &nbsp;&nbsp;&nbsp;
                    <span class="comment_text"><i class="fa fa-comments"></i>&nbsp;<span class="comment_count_<?php echo osc_item_id(); ?>"><?php echo get_comment_count(osc_item_id()) ?></span>&nbsp;
                        <?php echo 'Comments' ?>
                    </span>
                    &nbsp;&nbsp;
                    <a href="#"><?php echo 'Tchat' ?></a>&nbsp;

                    &nbsp;&nbsp;
                    <?php echo user_watchlist_box(osc_logged_user_id(), osc_item_id()) ?>

                </div>
                <!-- /.box-body -->

                <div class="cmnt comments_container_<?php echo osc_item_id(); ?>">                    
                    <?php
                    $c_data;
                    $comments_data = new DAO();
                    $comments_data->dao->select(sprintf('%st_item_comment.*', DB_TABLE_PREFIX));
                    $comments_data->dao->from(sprintf('%st_item_comment', DB_TABLE_PREFIX));
                    $conditions = array('fk_i_item_id' => osc_item_id(),
                        'b_active' => 1,
                        'b_enabled' => 1);
                    //$comments_data->dao->limit(3);
                    $comments_data->dao->where($conditions);
                    $comments_data->dao->orderBy('dt_pub_date', 'ASC');
                    $comments_result = $comments_data->dao->get();
                    $c_data = $comments_result->result();
                    ?>
                    <?php
                    if ($c_data):
                        ?>
                        <?php if (count($c_data) > 3): ?>
                            <div class="box-body">
                                <span class="load_more_comment"> <i class="fa fa-plus-square-o"></i> Display <?php echo count($c_data) - 3 ?> comments more </span>
                                <span class="comment_count"><?php echo count($c_data) - 3 ?></span>
                            </div>
                        <?php endif; ?>
                        <?php
                        $total_comment = count($c_data);
                        foreach ($c_data as $k => $comment_data):
                            $comment_user = get_user_data($comment_data['fk_i_user_id']);
                            if ($k < $total_comment - 3 && !$load_more):
                                $load_more = 'load more';
                                echo '<div class="load_more">';
                            endif;
                            ?>
                            <div class="box-footer box-comments <?php echo $comment_data['fk_i_user_id'] == $item['fk_i_user_id'] ? 'border-blue-left' : '' ?>">
                                <div class="box-comment">
                                    <!-- User image -->
                                    <div class="comment_user_image col-md-1 padding-0">
                                        <?php get_user_profile_picture($comment_user['user_id']) ?>
                                    </div>
                                    <div class="comment-area col-md-10">
                                        <span class="username">
                                            <?php echo $comment_user['user_name'] ?>
                                            <!--                                                <div class="dropdown  pull-right">
                                                                                                <i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-hidden="true"></i>
                                                                                                <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                                                                                                    <li class="delete_cmnt" onclick="deleteComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item['pk_i_id']; ?>)"><a>Supprimer la publication</a></li>
                                                                                                    <li class="edit_cmnt comment_text_<?php echo $comment_data['pk_i_id']; ?>" data-item-id='<?php echo $item['pk_i_id']; ?>' data_text="<?php echo $comment_data['s_body']; ?>" data_id="<?php echo $comment_data['pk_i_id']; ?>" onclick="editComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $item['pk_i_id']; ?>)"><a>Modifier</a></li>
                                                                                                    <li><a></a></li>
                                                                                                    <li><a>Sponsoriser</a></li>
                                                                                                    <li><a>Remonter en tête de liste</a></li>
                                                                                                    <li><a></a></li>
                                                                                                    <li><a>Signaler la publication</a></li>
                                            
                                                                                                </ul>
                                                                                            </div>-->
                                            <span class="text-muted margin-left-5"><?php echo time_elapsed_string(strtotime($comment_data['dt_pub_date'])) ?></span>
                                        </span>
                                        <span class="comment_text comment_edt_<?php echo $comment_data['pk_i_id']; ?>" data-text="<?php echo $comment_data['s_body']; ?>">
                                            <?php echo $comment_data['s_body']; ?>
                                        </span>

                                    </div>
                                    <!-- /.comment-text -->
                                </div>                       
                            </div>  
                            <?php
                            if ($k == (count($c_data) - 4)):
                                unset($load_more);
                                echo "</div>";
                            endif;
                        endforeach;
                    endif;
                    ?>
                </div>
                <!-- /.box-footer -->
                <div class="box-footer">
                    <form class="comment_form" data_item_id="<?php echo osc_item_id() ?>" data_user_id ="<?php echo osc_logged_user_id() ?>" method="post">
                        <?php
                        $current_user = get_user_data(osc_logged_user_id());
                        $current_user_image_url = '';
                        ?>
                        <div class="comment_user_image">
                            <?php get_user_profile_picture($current_user['user_id']) ?>
                        </div>
                        <!-- .img-push is used to add margin to elements next to floating images -->
                        <div class="img-push">
                            <textarea type="text" class="form-control input-sm comment_text" placeholder="Press enter to post comment"></textarea>
                        </div>
                    </form>
                </div>
                <!-- /.box-footer -->
            </div>
            <?php
        endwhile;
    endforeach;

elseif ($page_number > 0):
    echo '<h2 class="result_text">Ends of results</h2> ';
else:
    echo '<h2 class="result_text">Nothing to show off for now. Thanks to try later</h2> ';
endif;
if (osc_logged_user_id()):
    $id = '11';
    $description = 'Premium post amount';
    $amount = '1';
    $tax = '0';
    $quantity = 1;
//$extra = '';
    $k = 0;
    $items_pre[$k]["id"] = $id;
    $items_pre[$k]['description'] = $description;
    $items_pre[$k]['amount'] = $amount;
    $items_pre[$k]['tax'] = $tax;
    $items_pre[$k]['quantity'] = $quantity;
//$items['extra'] = $extra;
    $paypal_btn = new PaypalPayment();
    $paypal_btn->standardButton($items_pre);
    ?>
    <script>
        $(document).on('click', '.add_premium_post', function () {
            var item_id = $(this).attr('item_id');
            var user_id = <?php echo osc_logged_user_id() ?>;
            $.ajax({
                url: "<?php echo osc_current_web_theme_url('promoted_post_ajax.php') ?>",
                type: 'post',
                data: {
                    add_premium: 'add_premium',
                    item_id: item_id,
                    user_id: user_id
                },
                success: function () {
                    $(location).attr('href', '<?php echo osc_base_url(); ?>');
                }
            });
        });
        $(document).ready(function () {
            $('.premium').click(function () {
                var item_id = $(this).attr('item_id');
                $('#primium_item_id').val(item_id);
            })
        });
        $('.payment-option').on('change', function () {
            $('.payment-option').each(function () {
                var remove = $(this).val();
                $('#' + remove).addClass('none');
            });
            var data = $(this).val();
            $('#' + data).removeClass('none');
        });
        $('.pay_now').click(function () {
            var user_id = $(this).attr('user-id');
            var item_id = $('#primium_item_id').val();
            var selected_payment_method = $('.payment-option:checked').val();
            if (selected_payment_method == 'paypal') {
                var pay_action = $('input[name=notify_url]').val() + '&paymement_type=primium&user_id=<?php echo osc_logged_user_id(); ?>&user_email=<?php echo osc_logged_user_email(); ?>&item_id=' + item_id;
                $('input[name=notify_url]').val(pay_action);
                $('.paypal-btn').trigger('click');
            }
            if (selected_payment_method == 'payment-card') {
                var braintree_number = $('.card_number').val();
                var braintree_cvv = $('.card_cvv_code').val();
                var amount = 4.99;
                var braintree_month = $('.expiry_month').val();
                var braintree_year = $('.expiry_year').val();
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url('braintree_make_payment.php') ?>",
                    data: {
                        premium: 'premium',
                        braintree_number: braintree_number,
                        user_id: user_id,
                        item_id: item_id,
                        braintree_cvv: braintree_cvv,
                        amount: amount,
                        braintree_month: braintree_month,
                        braintree_year: braintree_year,
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (data == 1) {
                            //                                $('.payment_result').empty().addClass('success').removeClass('error');
                            //                                $('.payment_result').text('Payment added successfully');
                            //                                data = '';
    <?php // osc_add_flash_ok_message('Payment added successfully');                        ?>
                            alert('Payment added successfully');
                            window.location.href = "<?php echo osc_base_url(); ?>";
                        } else {
                            $('.payment_result').empty().addClass('error').removeClass('success');
                            $('.payment_result').text('Payment not added successfully');
                            $('.payment_result').text(data);
                        }
                    }
                });
            }
        });
        $(document).on('click', '.delete_post', function () {
            var user_id = $(this).attr('data-user-id');
            var post_id = $(this).attr('data-post-id');
            if (confirm('Are Sure Want To Delete This Post')) {
                $.ajax({
                    url: "<?php echo osc_current_web_theme_url() . 'delete_post_ajax.php'; ?>",
                    type: 'post',
                    data: {
                        action: 'delete_post',
                        user_id: user_id,
                        post_id: post_id
                    },
                    success: function () {
                        $(location).attr('href', '<?php echo osc_base_url(); ?>');
                    }
                });
            }
        });
        $(document).on('click', '.edit_user_post', function () {
            var item_id = $(this).attr('item_id');
            $.ajax({
                url: '<?php echo osc_current_web_theme_url() . 'update_user_post.php'; ?>',
                type: 'post',
                data: {
                    action: 'update_post',
                    redirect: 'homepage',
                    item_id: item_id
                },
                success: function (data) {
                    $('.free-user-post').html(data);
                    $('#popup-free-user-post').modal('show');
                }
            });
        });
        //   $(window).ready(function(){
        //        $('.edit_cmnt').click(function() { 
        //           
        //        });
        //    });
        function editComment(comment_id, data_item_id) {
            var text = $('.comment_edt_' + comment_id).attr('data-text');
            var input_box = '<input type="text" class="user_comment_textbox" data-item-id="' + data_item_id + '" data_id="' + comment_id + '" value="' + text + '">';
            $('.comment_edt_' + comment_id).html(input_box);
        }
        $(document).on('keypress', '.user_comment_textbox', function (e) {
            if (e.which == 13) {//Enter key pressed
                $('.user_comment_textbox').blur()
            }
        });
        $(document).on('blur', '.user_comment_textbox', function () {
            var new_text = $(this).val();
            var data_id = $(this).attr('data_id');
            var item_id = $(this).attr('data-item-id');
            if (!new_text) {
                return false;
            }
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'item_comment_ajax.php'; ?>",
                method: 'post',
                data: {
                    action: 'user_comment',
                    comment_text: new_text,
                    comment_id: data_id,
                    item_id: item_id
                },
                success: function (data, textStatus, jqXHR) {
                    $('.comment_edt_' + data_id).html(new_text);
                    $('.comment_edt_' + data_id).attr('data-text', new_text);
                }
            });
            //$('.user_website_text').html(new_text).attr('data_text', new_text);
        });

        function deleteComment(comment_id, data_item_id) {
            $.ajax({
                url: "<?php echo osc_current_web_theme_url() . 'item_comment_ajax.php'; ?>",
                method: 'post',
                data: {
                    action: 'user_comment',
                    comment_id: comment_id,
                    item_id: data_item_id,
                    delete: '1'
                },
                success: function (data, textStatus, jqXHR) {
                    $('.comments_container_' + data_item_id).replaceWith(data);
                    var current_comment_number = $('.comment_count_' + data_item_id).first().html();
                    $('.comment_count_' + data_item_id).html(parseInt(current_comment_number) - 1);
                }
            });
        }
    </script>
<?php endif; ?>