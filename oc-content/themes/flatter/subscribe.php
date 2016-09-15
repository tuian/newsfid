<?php
require '../../../oc-load.php';
require 'functions.php';
?>
<?php osc_current_web_theme_path('header.php'); ?>

<div class="subscribe-page">
    <div class="cover-img">
        <div class="container">
            <div class="col-md-8">
                <h3 class="font-color-white bold-600 margin-0">Start now with</h3>
                <h1 class="font-color-white bold-600 font-65px margin-0">NEWSFID PRO</h1>
                <div class="col-md-8 border-bottom"></div>
                <h2 class="font-color-white bold-600">Freedom, Notoriety , Difference , Simplicity</h2>
                <div class="col-md-offset-1 margin-top-20">
                    <button type="submit" class="btn btn-lg button-orng" data-toggle="modal" data-target="#payment">Get Newsfid pro with 30 days trials right now</button>
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
                                                    <h1 class="bold font-color-light-blue">Newsfid Premium</h1>
                                                    <h3 class="bold font-color-royal-blue margin-0">Improve your experience</h3>
                                                </div>
                                                <div class="col-md-12 padding-top-13per">
                                                    Subscribers benefit from advantageous services. 
                                                    You can better manage your reputation and reach more users easily.                                               </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="breack-line"></div>
                                <div class="payment-section-2 bg-white col-md-12 border-radius-10 padding-0">
                                    <div class="col-md-12 theme-modal-header">
                                        <div class="col-md-offset-1">
                                            <h2 class="bold margin-0"> Select payment mode </h2>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="col-md-12 margin-top-20">
                                            <table class="table margin-0">
                                                <thead>
                                                    <tr class="bg-blue-light">
                                                        <th class="border-right-white font-color-black">Date</th>
                                                        <th class="border-right-white font-color-black">Description</th>
                                                        <th class="border-right-white font-color-black">Quantity</th>
                                                        <th class="border-right-white font-color-black">Unit Price</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-bottom">
                                                        <td class="font-color-black"><?php echo date('d/m/Y'); ?></td>
                                                        <td class="font-color-black">Newsfid Premium (12 month Payment) 1 Month for free</td>
                                                        <td class="font-color-black">1</td>
                                                        <td class="font-color-black">$4.99</td>
                                                        <td class="font-color-black">4.99$</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="font-color-black"><h1 class="bold">TOTAL</h1></td>
                                                        <td class="font-color-black"></td>
                                                        <td class="font-color-black"></td>
                                                        <td class="font-color-black"></td>
                                                        <td class="font-color-black">4.99$</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="theme-modal-footer"></div> 
                                    <div class="col-md-12 bg-white">
                                        <div class="col-md-offset-1 col-md-2 text-center">
                                            <div class="payment-img">
                                                <img class="img img-responsive" src="../flatter/images/CreditCards.png">
                                            </div>
                                            <input type="radio" class="payment-option" name="payment" value="payment-card" checked>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <div class="payment-img">
                                                <img class="img img-responsive" src="../flatter/images/paypal.png">
                                            </div>
                                            <input type="radio" class="payment-option" name="payment" value="paypal">
                                        </div>
                                        <div class="col-md-6 padding-3per bg-green-light">
                                            You will not be charged until the end of your trial period dated <?php echo date('d/m/Y', strtotime("+1 months", strtotime("NOW"))); ?>, You could cancel your membership online at any time.
                                        </div>

                                    </div>
                                    <div class="col-md-offset-3 col-md-6" id="payment-card">
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
                                                    Expiration date
                                                </div>
                                                <div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2">
                                                    CVV<span class="circle-border"> ?</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 margin-top-20 padding-0 vertical-row">
                                            <div class="col-md-3 col-sm-3 grey-border">
                                                <input type="text" placeholder="MM" required class="expiry_month">

                                            </div>
                                            <div class="col-md-1 col-sm-1">
                                                /
                                            </div>
                                            <div class="col-md-3 col-sm-3 grey-border">
                                                <input type="text" placeholder="YY" required class="expiry_year">
                                            </div>
                                            <div class="col-md-offset-2 col-md-3 col-sm-3 grey-border">
                                                <input type="text" placeholder="Code" required class="card_cvv_code">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-12 margin-top-20 grey-border">
                                            <?php UserForm::country_select(array_slice(osc_get_countries(), 1, -1)); ?>
                                        </div>
                                        <div class="col-md-12 margin-top-20 grey-border">
                                            <input type="text" placeholder="Address">
                                        </div>
                                        <div class="col-md-12 margin-top-20 grey-border" >
                                            <input type="text">
                                        </div>
                                        <div class="col-md-12 margin-top-20 grey-border">
                                            <input type="text" placeholder="Zip code">
                                        </div>
                                        <div class="col-md-12 margin-top-20 grey-border">
                                            <input type="text" placeholder="Ville">
                                        </div>
                                        <div class="col-md-12 margin-top-20 grey-border">
                                            <input type="text" placeholder="CEDEX">
                                        </div>
                                    </div>
                                    <div class="center-contant vertical-row none" id="paypal">
                                        <div class="col-md-4">
                                            <img class="img img-responsive" src="images/paypal-iphone.png">
                                        </div>
                                        <div class="col-md-8">
                                            You will be redirected to PayPal 
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
                                        <div class="col-md-8"><h4 class=" bold"> I have read and accepted the Terms & Conditions</h4> </div>
                                    </div>
                                    <div class="col-md-offset-2 col-md-10 theme-modal-header">

                                        <div class="col-md-9">
                                            I accept the terms of use and additional requirements related to the use of newsfid service. One case of conflict with my content I agree to b I accept the terms of use
                                        </div>
                                        <div class="col-md-9 margin-top-20">You have an option to terminate your subscription online at any time </div>
                                        <div class="col-md-9 margin-top-20">
                                            <button type="submit" class="btn btn-lg button-orng btn-radius-0 payment_btn">Activate my 30 days trials</button>
                                            <div class="payment_result"></div>
                                            <div class="margin-top-20">* Free offer valid only once</div>
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
            <h4 class="bold-600 margin-0 font-color-black">Start newsfid pro and get 30 days trial. You can stop it when you want.</h4>
        </div>
        <div class="sub-info col-md-12   margin-top-20">
            <div class="col-md-5">
                <img class="img img-responsive" src="../flatter/images/responsivei-img.png">
            </div>
            <!------------table title Start-------------->
            <div class="col-md-7">
                <div class="col-md-12 border-bottom  vertical-row">
                    <div class="col-md-8 col-sm-8 col-xs-6">
                        <div class="font-color-black">Options</div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3">
                        <div class="font-color-black bold">Free</div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-3">
                        <div class="font-color-black bold">Premium</div>
                    </div>
                </div>
                <!--------------Table title End----------------->
                <!------------------Table row Start-------1--------->
                <div class="col-md-12 border-bottom  vertical-row">
                    <div class="col-md-8 col-sm-8 col-xs-6">
                        <div class="orange bold padding-top-4per">Post an audio track</div>
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
                        <div class="orange bold padding-top-4per">Post GIF image</div>
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
                        <div class="orange bold padding-top-4per">Post video link ( youtube / Vimeo / Dailymotion)</div>
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
                        <div class="orange bold padding-top-4per">Get a professional logo to make difference with users.</div>
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
            $('.payment-option').on('change', function () {
                $('.payment-option').each(function () {
                    var remove = $(this).val();
                    $('#' + remove).addClass('none');
                });
                var data = $(this).val();
                $('#' + data).removeClass('none');
            });

            $('.payment_btn').click(function () {
                var selected_payment_method = $('.payment-option:checked').val();
                if (selected_payment_method == 'paypal') {
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
                                $('.payment_result').text('Payment not added successfully');
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

