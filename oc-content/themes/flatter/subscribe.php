<?php
require '../../../oc-load.php';
require 'functions.php';
?>
<?php osc_current_web_theme_path('header.php'); ?>
<style>
    #t_chat_menu{
        display: none;
    }
    .main_content{
        width: 85%;
    }
</style>
<div class="subscribe-page">
    <div class="cover-img">
        <div class="container">
            <div class="col-md-8">
                <h3 class="font-color-white bold-600 margin-0"><?php _e("Start now with", 'flatter') ?></h3>
                <h1 class="font-color-white bold-600 font-65px margin-0"><?php _e("NEWSFID PRO", 'flatter') ?></h1>
                <div class="col-md-8 border-bottom"></div>
                <h2 class="font-color-white bold-600"><?php _e("Freedom, Notoriety , Difference , Simplicity", 'flatter') ?></h2>
                <div class="col-md-offset-1 margin-top-20">
                    <button type="submit" class="btn btn-lg button-orng" data-toggle="modal" data-target="#payment"><?php _e("Get Newsfid pro with 30 days trials right now", 'flatter') ?></button>
                    <!-- Payment modal start -->
                    <div id="payment" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content bg-transperent">
                                <div class="modal-header bg-white">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="payment-section-1 bg-white">
                                    <div class="container">
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <img class="img img-responsive" src="../flatter/images/balance.png">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="col-md-12">
                                                    <h1 class="bold font-color-light-blue"><?php _e("Newsfid Premium", 'flatter') ?></h1>
                                                    <h3 class="bold font-color-royal-blue margin-0"><?php _e("Improve your experience", 'flatter') ?></h3>
                                                </div>
                                                <div class="col-md-12 padding-top-13per">
                                                    <?php _e("Subscribers benefit from advantageous services. 
                                                    You can better manage your reputation and reach more users easily.", 'flatter') ?>                                    </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="breack-line"></div>
                                <div class="payment-section-2 bg-white col-md-12 border-radius-10 padding-0">
<!--                                    <div class="col-md-12 theme-modal-header">
                                        <div class="col-md-offset-1">
                                            <h2 class="bold margin-0"><?php _e("Select payment mode ", 'flatter') ?> </h2>
                                        </div>
                                    </div>-->
<!--                                    <div class="container">
                                        <div class="col-md-12 margin-top-20">
                                            <table class="table margin-0">
                                                <thead>
                                                    <tr class="bg-blue-light">
                                                        <th class="border-right-white font-color-black"><?php _e("Date", 'flatter') ?></th>
                                                        <th class="border-right-white font-color-black"><?php _e("Description", 'flatter') ?></th>
                                                        <th class="border-right-white font-color-black"><?php _e("Quantity", 'flatter') ?></th>
                                                        <th class="border-right-white font-color-black"><?php _e("Unit Price", 'flatter') ?></th>
                                                        <th><?php _e("Amount", 'flatter') ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-bottom">
                                                        <td class="font-color-black"><?php echo date('d/m/Y'); ?></td>
                                                        <td class="font-color-black"><?php _e("Newsfid Premium (12 month Payment) 1 Month for free", 'flatter') ?></td>
                                                        <td class="font-color-black">1</td>
                                                        <td class="font-color-black">$4.99</td>
                                                        <td class="font-color-black">4.99$</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-color-black"><h1 class="bold"><?php _e("TOTAL", 'flatter') ?></h1></td>
                                                        <td class="font-color-black"></td>
                                                        <td class="font-color-black"></td>
                                                        <td class="font-color-black"></td>
                                                        <td class="font-color-black">4.99$</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>-->
                                    <div class="theme-modal-footer"></div> 
                                    <div class="col-md-12 bg-white">
<!--                                        <div class="col-md-offset-1 col-md-2 text-center">
                                            <div class="payment-img">
                                                <img class="img img-responsive" src="../flatter/images/CreditCards.png">
                                            </div>
                                            <input type="radio" class="payment-option" name="payment" value="payment-card" checked>
                                        </div>-->
                                        <div class="col-md-2 text-center">
                                            <div class="payment-img">
                                                <img class="img img-responsive" src="../flatter/images/paypal.png">
                                            </div>
                                            <input type="radio" class="payment-option" name="payment" value="paypal" checked="">
                                        </div>
                                        <div class="col-md-6 padding-3per bg-green-light">
                                            <?php _e("You will not be charged until the end of your trial period dated", 'flatter') ?> <?php echo date('d/m/Y', strtotime("+1 months", strtotime("NOW"))); ?>, <?php _e("You could cancel your membership online at any time.", 'flatter') ?>
                                        </div>

                                    </div>
<!--                                    <div class="col-md-offset-3 col-md-6" id="payment-card">
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
                                            <input type="text" placeholder="<?php _e("CEDEX", 'flatter') ?>">
                                        </div>
                                    </div>-->
                                    <div class="center-contant vertical-row none" id="paypal">
                                        <div class="col-md-4">
                                            <img class="img img-responsive" src="images/paypal-iphone.png">
                                        </div>
                                        <div class="col-md-8">
                                            <?php _e("You will be redirected to PayPal ", 'flatter') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="breack-line"></div>
                                <div class="col-md-12 padding-0 bg-white border-radius-10 padding-top-4per">
                                    <div class="col-md-12 theme-modal-header">
                                        <div class="col-md-offset-2 col-md-1">
                                            <div class="onoffswitch margin-top-10">
                                                <input type="checkbox" name="accept" class="onoffswitch-checkbox post_type_switch" data_post_type="accept" id="accept" value="accept">
                                                <label class="onoffswitch-label" for="accept"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-8"><h4 class=" bold"><?php _e("I have read and accepted the Terms & Conditions", 'flatter') ?> </h4> </div>
                                    </div>
                                    <div class="col-md-offset-2 col-md-10 theme-modal-header">

                                        <div class="col-md-9">
                                            <?php _e(" I accept the terms of use and additional requirements related to the use of newsfid service. One case of conflict with my content I agree to b I accept the terms of use", 'flatter') ?>
                                           
                                        </div>
                                        <div class="col-md-9 margin-top-20"><?php _e("You have an option to terminate your subscription online at any time ", 'flatter') ?></div>
                                        <div class="col-md-9 margin-top-20">
                                            <button type="submit" class="btn btn-lg button-orng btn-radius-0 payment_btn"><?php _e("Activate my 30 days trials", 'flatter') ?></button>
                                            <div class="col-md-10">
                                                <span class="error-term red"><?php _e("Please Accept Term & Condition", 'flatter') ?></span>
                                            </div>
                                            <div class="payment_result"></div>
                                            <div class="margin-top-20">* <?php _e("Free offer valid only once", 'flatter') ?></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!----------payment modal end-->
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="contant bg-white col-md-12">

        <div class="col-md-12 text-center padding-top-4per ">
            <h4 class="bold-600 margin-0 font-color-black"><?php _e("Start newsfid pro and get 30 days trial. You can stop it when you want.", 'flatter') ?></h4>
        </div>
        <div class="sub-info col-md-12   margin-top-20">
            <div class="col-md-5">
                <img class="img img-responsive" src="../flatter/images/responsivei-img.png">
            </div>
            <!------------table title Start-------------->
            <div class="col-md-7">
                <div class="col-md-12 border-bottom  vertical-row">
                    <div class="col-md-8 col-sm-8 col-xs-6">
                        <div class="font-color-black"><?php _e("Options", 'flatter') ?></div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3">
                        <div class="font-color-black bold"><?php _e("Free", 'flatter') ?></div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3">
                        <div class="font-color-black bold"><?php _e("Premium", 'flatter') ?></div>
                    </div>
                </div>
                <!--------------Table title End----------------->
                <!------------------Table row Start-------1--------->
                <div class="col-md-12 border-bottom  vertical-row">
                    <div class="col-md-8 col-sm-8 col-xs-6">
                        <div class="orange bold padding-top-4per"><?php _e("Post an audio track", 'flatter') ?></div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                        <div class="white-round margin-left-15"></div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                        <div class="green-round margin-left-15"></div>
                    </div>
                </div>
                <!---------------Table Row End---------1-------->
                <!------------------Table row Start-------2--------->
                <div class="col-md-12 border-bottom  vertical-row">
                    <div class="col-md-8 col-sm-8 col-xs-6">
                        <div class="orange bold padding-top-4per"><?php _e("Post GIF image", 'flatter') ?></div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                        <div class="green-round margin-left-15"></div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                        <div class="green-round margin-left-15"></div>
                    </div>
                </div>
                <!------------------Table row End-------2--------->
                <!------------------Table row Start-------3--------->
<!--                <div class="col-md-12 border-bottom  vertical-row">
                    <div class="col-md-8 col-sm-8 col-xs-6">
                        <div class="orange bold padding-top-4per">Sponsoriser vos publications quand vous le voulez</div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                        <div class="white-round margin-left-15"></div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                        <div class="green-round margin-left-15"></div>
                    </div>
                </div>-->
                <!------------------Table row End-------3--------->
                <!------------------Table row Start-------4--------->
                <div class="col-md-12 border-bottom  vertical-row">
                    <div class="col-md-8 col-sm-8 col-xs-6">
                        <div class="orange bold padding-top-4per"><?php _e("Post video link ( youtube / Vimeo / Dailymotion)", 'flatter') ?></div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                        <div class="green-round margin-left-15"></div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                        <div class="green-round margin-left-15"></div>
                    </div>
                </div>
                <!------------------Table row End-------4--------->
                <!------------------Table row Start-------5--------->
                <div class="col-md-12 border-bottom  vertical-row">
                    <div class="col-md-8 col-sm-8 col-xs-6">
                        <div class="orange bold padding-top-4per"><?php _e("Get a professional logo to make difference with users.", 'flatter') ?></div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                        <div class="white-round margin-left-15"></div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3 padding-top-3per">
                        <div class="green-round margin-left-15"></div>
                        <?php
                        $id = '11';
                        $description = 'Subscription amount';
                        $amount = '4.99';
                        $tax = '0';
                        $quantity = 1;
                        //$extra = '';
                        $k = 0;
                        $items[$k]['id'] = $id;
                        $items[$k]['description'] = $description;
                        $items[$k]['amount'] = $amount;
                        $items[$k]['tax'] = $tax;
                        $items[$k]['quantity'] = $quantity;
                        //$items['extra'] = $extra;

                        $paypal_btn = new PaypalPayment();
                        $paypal_btn->standardButton($items);
                        ?>
                    </div>
                </div>
                <!------------------Table row end-------5--------->
            </div>
        </div>
    </div>
</div>
<?php osc_add_hook('footer', 'payment_script'); ?>
<?php

function payment_script() {
    ?>
    <script>
        jQuery(document).ready(function ($) {
            $('.error-term').hide();
            $('.payment-option').on('change', function () {
                $('.payment-option').each(function () {
                    var remove = $(this).val();
                    $('#' + remove).addClass('none');
                });
                var data = $(this).val();
                $('#' + data).removeClass('none');
            });

            $('.payment_btn').click(function () {
                
                if (!$("#accept").is(":checked")) {
                    $('.error-term').show();
                    return false;
                }
                var selected_payment_method = $('.payment-option:checked').val();
                if (selected_payment_method == 'paypal') {
                    var pay_action = $('input[name=notify_url]').val()+'&paymement_type=subscription&user_id=<?php echo osc_logged_user_id()?>&user_email=<?php echo osc_logged_user_email()?>';
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
                            subscribe: 'subscribe',
                            braintree_number: braintree_number,
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
                                <?php // osc_add_flash_ok_message('Payment added successfully'); ?>
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
        });
    </script>
<?php } ?>
<?php osc_current_web_theme_path('footer.php'); ?>

