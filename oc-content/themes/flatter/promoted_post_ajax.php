<?php
// meta tag robots
require_once '../../../oc-load.php';
require_once 'functions.php';

if ($_REQUEST['action'] == 'promoted_post'):
    ?>
    <div id="premium" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content bg-transperent">

                <div class="payment-section-2 bg-white col-md-12 border-radius-10 padding-0">
                    <button type="button" class="close premium_close" data-dismiss="modal">&times;</button>
                    <div class="col-md-12 theme-modal-header">
                        <div class="col-md-offset-1">
                            <h2 class="bold margin-0"><?php _e("Select payment mode", 'flatter') ?>  </h2>
                        </div>
                    </div>
                    <div class="container">
                        <div class="col-md-12 margin-top-20">
                            <table class="table margin-0">
                                <thead>
                                    <tr class="bg-blue-light">
                                        <th class="border-right-white font-color-black"><?php _e("Date", 'flatter') ?></th>
                                        <th class="border-right-white font-color-black"><?php _e("Description", 'flatter') ?></th>
                                        <th class="border-right-white font-color-black"><?php _e("Quantity", 'flatter') ?></th>
                                        <th class="border-right-white font-color-black"><?php _e("Unit Price", 'flatter') ?></th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-bottom">
                                        <td class="font-color-black"><?php echo date('d/m/Y'); ?></td>
                                        <td class="font-color-black"><span class="bold"><?php echo $_REQUEST['name']; ?></span> <?php _e("Premium Post for", 'flatter') ?> <?php echo $_REQUEST['posts']; ?> <?php _e("day", 'flatter') ?></td>
                                        <td class="font-color-black">1</td>
                                        <td class="font-color-black">$<?php echo $_REQUEST['amount']; ?></td>
                                        <td class="font-color-black"><?php echo $_REQUEST['amount']; ?>$</td>
                                    </tr>
                                    <tr>
                                        <td class="font-color-black"><h1 class="bold"><?php _e("TOTAL", 'flatter') ?></h1></td>
                                        <td class="font-color-black"></td>
                                        <td class="font-color-black"></td>
                                        <td class="font-color-black"></td>
                                        <td class="font-color-black"><?php echo $_REQUEST['amount']; ?>$</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="theme-modal-footer"></div> 
                    <div class="col-md-12 bg-white">
<!--                        <div class="col-md-offset-1 col-md-2 text-center">
                            <div class="payment-img">
                                <img class="img img-responsive" src="<?php echo osc_current_web_theme_url(); ?>images/CreditCards.png">
                            </div>
                            <input type="radio" class="payment-option" name="payment" value="payment-card" checked>
                        </div>-->
                        <div class="col-md-2 text-center">
                            <div class="payment-img">
                                <img class="img img-responsive" src="<?php echo osc_current_web_theme_url(); ?>images/paypal.png">
                            </div>
                            <input type="radio" class="payment-option" name="payment" value="paypal" checked="">
                        </div>
                        <div class="col-md-6 padding-3per bg-green-light">
                            <?php _e("You will get a benefits of Premium Post up to dated", 'flatter') ?> <?php echo date('d/m/Y', strtotime("+2 days", strtotime("NOW"))); ?>. 
                        </div>

                    </div>
<!--                    <div class="col-md-offset-3 col-md-6" id="payment-card">
                        <div class="col-md-12">
                            <div class="blue_text bold"><?php echo __('Method of payment'); ?></div>
                        </div>
                        <div class="col-md-12 margin-top-20 grey-border">
                            <input type="text" placeholder="<?php echo __("Cardholder's name"); ?>" required class="card_name">
                            <span class="card-icon"></span>
                        </div>
                        <div class="col-md-12 margin-top-20 grey-border">
                            <input type="text" placeholder="<?php echo __('Card number'); ?>" required class="card_number">                                           
                        </div>
                        <div class="col-md-12">                                           
                            <div class="margin-top-20">
                                <div class="col-md-5 col-sm-5">
                                    <?php _e("Expiration date", 'flatter') ?>
                                </div>
                                <div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2">
                                    <?php _e("CVV", 'flatter') ?><span class="circle-border"> ?</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 margin-top-20 padding-0 vertical-row">
                            <div class="col-md-3 col-sm-3 grey-border">
                                <input type="text" placeholder="<?php _e("MM", 'flatter') ?>" required class="expiry_month">

                            </div>
                            <div class="col-md-1 col-sm-1">
                                /
                            </div>
                            <div class="col-md-3 col-sm-3 grey-border">
                                <input type="text" placeholder="<?php _e("YY", 'flatter') ?>" required class="expiry_year">
                            </div>
                            <div class="col-md-offset-2 col-md-3 col-sm-3 grey-border">
                                <input type="password" placeholder="<?php _e("Code", 'flatter') ?>" required class="card_cvv_code">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 margin-top-20 grey-border">
                            <?php UserForm::country_select(array_slice(osc_get_countries(), 1, -1)); ?>
                        </div>
                        <div class="col-md-12 margin-top-20 grey-border">
                            <input type="text" placeholder="<?php _e("Address", 'flatter') ?>">
                        </div>
                        <div class="col-md-12 margin-top-20 grey-border" >
                            <input type="text">
                        </div>
                        <div class="col-md-12 margin-top-20 grey-border">
                            <input type="text" placeholder="<?php _e("Zip code", 'flatter') ?>">
                        </div>
                        <div class="col-md-12 margin-top-20 grey-border">
                            <input type="text" placeholder="<?php _e("City", 'flatter') ?>">
                        </div>
                        <div class="col-md-12 margin-top-20 grey-border">
                            <input type="text" placeholder="CEDEX">
                        </div>
                    </div>-->
                    <div class="center-contant vertical-row none" id="paypal">
                        <div class="col-md-4 payment-img">
                            <img class="img img-responsive" src="<?php echo osc_current_web_theme_url(); ?>images/paypal-iphone.png">
                        </div>
                        <div class="col-md-8">
                            <?php _e("You will be redirected to PayPal", 'flatter') ?> 
                        </div>
                    </div>
                    <div class="col-md-12 padding-0 bg-white padding-top-4per">
                        <div class="col-md-offset-3 col-md-9 theme-modal-header">
                            <div class="col-md-9 margin-top-20">
                                <button type="submit" class="btn btn-lg button-orng btn-radius-0 pay_now" pack-name="<?php echo $_REQUEST['name']; ?>" pack-id='<?php echo $_REQUEST['pack_id']; ?>' post="<?php echo $_REQUEST['posts']; ?>" user-id="<?php echo osc_logged_user_id(); ?>"><?php _e("Pay now", 'flatter') ?></button>
                                <div class="payment_result"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!----------payment modal end-->
    </div><?php
endif;
if ($_REQUEST['add_premium'] == 'add_premium'):
    $db_prefix = DB_TABLE_PREFIX;

    $premium['user_id'] = $_REQUEST['user_id'];
    $premium['item_id'] = $_REQUEST['item_id'];
    $premium['start_date'] = date("Y-m-d H:i:s");
    $premium['created'] = date("Y-m-d H:i:s");
    $premium['end_date'] = date("Y-m-d H:i:s", strtotime("+2 days", strtotime("NOW")));
    $premium_data = new DAO();
    $premium_data->dao->insert("{$db_prefix}t_premium_items", $premium);


    $message = 'Created promoted post';
    set_user_notification($_REQUEST['user_id'], $_REQUEST['user_id'], $message, $_REQUEST['item_id']);

    $pack = get_user_pack_details($_REQUEST['user_id']);
    $remaining_post = $pack['remaining_post'] - 1;
    $pack_id = $pack['pack_id'];
    $update_user_pack = new DAO();
    $update_user_pack->dao->update("{$db_prefix}t_user_pack", array('remaining_post' => $remaining_post), array('pack_id' => $pack_id));
    die();

endif;
if ($_REQUEST['action'] == 'promoted_post'):
    if (osc_logged_user_id()):
        $id = $_REQUEST['item_id'];
        $description = $_REQUEST['name'] . ' Premium post amount';
        $amount = $_REQUEST['amount'];
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
                var pack_id = $(this).attr('pack-id');
                var selected_payment_method = $('.payment-option:checked').val();
                if (selected_payment_method == 'paypal') {
                    var pay_action = $('input[name=notify_url]').val() + '&paymement_type=pack&pack_id=' + pack_id;
                    $('input[name=notify_url]').val(pay_action);
                    $('.paypal-btn').trigger('click');
                }
                if (selected_payment_method == 'payment-card') {
                    var braintree_number = $('.card_number').val();
                    var braintree_cvv = $('.card_cvv_code').val();
                    var braintree_month = $('.expiry_month').val();
                    var braintree_year = $('.expiry_year').val();
                    $.ajax({
                        url: "<?php echo osc_current_web_theme_url('braintree_make_payment.php') ?>",
                        type: 'post',
                        data: {
                            premium: 'premium',
                            braintree_number: braintree_number,
                            pack_id: pack_id,
                            braintree_cvv: braintree_cvv,
                            braintree_month: braintree_month,
                            braintree_year: braintree_year,
                        },
                        success: function (data, textStatus, jqXHR) {
                            if (data == 1) {
                                //                                $('.payment_result').empty().addClass('success').removeClass('error');
                                //                                $('.payment_result').text('Payment added successfully');
                                //                                data = '';
        <?php // osc_add_flash_ok_message('Payment added successfully');                            ?>
                                alert('Payment added successfully');
                                window.location.href = "<?php echo osc_base_url(); ?>";
                            } else {
                                $('.payment_result').empty().addClass('error').removeClass('success');
                                $('.payment_result').text('<?php _e("Payment not added successfully", 'flatter') ?>');
                                $('.payment_result').text(data);
                            }
                        }
                    });
                }
            });
        </script>
    <?php endif; ?>
<?php endif; ?>