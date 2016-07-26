<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');


    $confPath = PAYMENT_PRO_PATH . 'payments/';
    $dir = opendir($confPath);
    while($file = readdir($dir)) {
        if(is_dir($confPath . $file) && $file!='.' && $file!='..') {
            if(file_exists($confPath . $file . '/load.php')) {
                include_once $confPath . $file . '/load.php';
            }
        }
    }
    closedir($dir);

    if(Params::getParam('plugin_action')=='done') {
        if(Params::getParam("pay_per_post")!=1 && Params::getParam("pay_per_post")!=osc_get_preference('pay_per_post', 'payment_pro')) {
            ModelPaymentPro::newInstance()->disablePaidItems();
        }

        osc_set_preference('default_premium_cost', Params::getParam("default_premium_cost") ? Params::getParam("default_premium_cost") : '1.0', 'payment_pro', 'STRING');
        osc_set_preference('allow_premium', Params::getParam("allow_premium") ? Params::getParam("allow_premium") : '0', 'payment_pro', 'BOOLEAN');
        osc_set_preference('default_publish_cost', Params::getParam("default_premium_cost") ? Params::getParam("default_publish_cost") : '1.0', 'payment_pro', 'STRING');
        osc_set_preference('pay_per_post', Params::getParam("pay_per_post") ? Params::getParam("pay_per_post") : '0', 'payment_pro', 'BOOLEAN');
        osc_set_preference('default_top_cost', Params::getParam("default_top_cost") ? Params::getParam("default_top_cost") : '1.0', 'payment_pro', 'STRING');
        osc_set_preference('allow_top', Params::getParam("allow_top") ? Params::getParam("allow_top") : '0', 'payment_pro', 'BOOLEAN');
        osc_set_preference('default_highlight_cost', Params::getParam("default_highlight_cost") ? Params::getParam("default_highlight_cost") : '1.0', 'payment_pro', 'STRING');
        osc_set_preference('allow_highlight', Params::getParam("allow_highlight") ? Params::getParam("allow_highlight") : '0', 'payment_pro', 'BOOLEAN');
        osc_set_preference('highlight_color', Params::getParam("highlight_color") ? Params::getParam("highlight_color") : '0', 'payment_pro', 'STRING');
        osc_set_preference('allow_wallet', Params::getParam("allow_wallet") ? Params::getParam("allow_wallet") : '0', 'payment_pro', 'BOOLEAN');
        osc_set_preference('premium_days', Params::getParam("premium_days") ? Params::getParam("premium_days") : '7', 'payment_pro', 'INTEGER');
        osc_set_preference('highlight_days', Params::getParam("highlight_days") ? Params::getParam("highlight_days") : '7', 'payment_pro', 'INTEGER');
        osc_set_preference('highlight_color', Params::getParam("highlight_color") ? Params::getParam("highlight_color") : 'fff000', 'payment_pro', 'STRING');
        osc_set_preference('currency', Params::getParam("currency")!='' ? strtoupper(Params::getParam("currency")) : 'USD', 'payment_pro', 'STRING');

        osc_set_preference('show_taxes', Params::getParam("show_taxes") ? Params::getParam("show_taxes") : '0', 'payment_pro', 'BOOLEAN');
        $taxes = Params::getParam("default_tax") ? Params::getParam("default_tax") : '';
        if(!is_numeric($taxes)) {
            $taxes = 0;
        }
        osc_set_preference('default_tax', $taxes, 'payment_pro', 'INTEGER');

        osc_run_hook('payment_pro_conf_save');

        // HACK : This will make possible use of the flash messages ;)
        ob_get_clean();
        osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'payment_pro'), 'admin');
        osc_redirect_to(osc_route_admin_url('payment-pro-admin-conf'));
    }
?>


<?php if(PAYMENT_PRO_CRYPT_KEY=='randompasswordchangethis') {
    echo '<div style="text-align:center; font-size:22px; background-color:#dd0000;"><p>' . sprintf(__('Please, change the crypt key (PAYMENT_PRO_CRYPT_KEY) in %s. <a id="howto" href="javascript:void(0);" onclick="$(\'#dialog-howto\').dialog(\'open\');">How to do it.</a>', 'payment_pro'), PAYMENT_PRO_PATH.'config.php') . '</p></div>';
};
?>
<div id="general-setting">
    <div id="general-settings">
        <h2 class="render-title"><?php _e('Payments settings', 'payment_pro'); ?></h2>
        <ul id="error_list"></ul>
        <form name="payment_pro_form" action="<?php echo osc_admin_base_url(true); ?>" method="post">
            <input type="hidden" name="page" value="plugins" />
            <input type="hidden" name="action" value="renderplugin" />
            <input type="hidden" name="route" value="payment-pro-admin-conf" />
            <input type="hidden" name="plugin_action" value="done" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label"><?php _e('Premium ads', 'payment_pro'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('allow_premium', 'payment_pro') ? 'checked="true"' : ''); ?> name="allow_premium" value="1" />
                                    <?php _e('Allow premium ads', 'payment_pro'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Default premium cost', 'payment_pro'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="default_premium_cost" value="<?php echo osc_get_preference('default_premium_cost', 'payment_pro'); ?>" /></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Premium days', 'payment_pro'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="premium_days" value="<?php echo osc_get_preference('premium_days', 'payment_pro'); ?>" /></div>
                    </div>

                    <div class="form-row">
                        <div class="form-label"><?php _e('Publish fee', 'payment_pro'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('pay_per_post', 'payment_pro') ? 'checked="true"' : ''); ?> name="pay_per_post" value="1" />
                                    <?php _e('Pay per post ads', 'payment_pro'); ?>
                                </label>
                            </div>
                        </div>
                        <span class="help-box">
                            <?php if(osc_get_preference('pay_per_post', 'payment_pro')==1) {
                                _e('<b>Important:</b> disabling this option will block all non-paid listings. If you want them visible on your website, you need to unblock them manually.', 'payment_pro');
                            } else {
                                _e('<b>Important:</b> while this option is disabled, unblocking listings will mark them as paid (if you enable this again).', 'payment_pro');
                            }; ?>
                        </span>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Default publish cost', 'payment_pro'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="default_publish_cost" value="<?php echo osc_get_preference('default_publish_cost', 'payment_pro'); ?>" /></div>
                    </div>

                    <div class="form-row">
                        <div class="form-label"><?php _e('Move to top fee', 'payment_pro'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('allow_top', 'payment_pro') ? 'checked="true"' : ''); ?> name="allow_top" value="1" />
                                    <?php _e('Allow move to top', 'payment_pro'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Default move to top cost', 'payment_pro'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="default_top_cost" value="<?php echo osc_get_preference('default_top_cost', 'payment_pro'); ?>" /></div>
                    </div>

                    <div class="form-row">
                        <div class="form-label"><?php _e('Highlight listings', 'payment_pro'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('allow_highlight', 'payment_pro') ? 'checked="true"' : ''); ?> name="allow_highlight" value="1" />
                                    <?php _e('Allow listings to have a different background on search and highlight them. You need to modify your theme, <a href="javascript:void(0);" onclick="$(\'#dialog-highlight\').dialog(\'open\');" >Learn how to do it</a>', 'payment_pro'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Default highlight cost', 'payment_pro'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="default_highlight_cost" value="<?php echo osc_get_preference('default_highlight_cost', 'payment_pro'); ?>" /></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Highlight days', 'payment_pro'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="highlight_days" value="<?php echo osc_get_preference('highlight_days', 'payment_pro'); ?>" /></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Highlight color', 'payment_pro'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="highlight_color" id="highlight_color" value="<?php echo osc_get_preference('highlight_color', 'payment_pro'); ?>" /> <span id="highlight_color_sample" style="background-color: #<?php echo osc_get_preference('highlight_color', 'payment_pro'); ?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                    </div>

                    <div class="form-row">
                        <div class="form-label"><?php _e('Allow users\'s wallets', 'payment_pro'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('allow_wallet', 'payment_pro') ? 'checked="true"' : ''); ?> name="allow_wallet" value="1" />
                                    <?php _e('Allow users to have credits and pay for products with that credit', 'payment_pro'); ?>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-label"><?php _e('Default currency', 'payment_pro'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="currency" id="currency" value="<?php echo osc_get_preference('currency', 'payment_pro'); ?>" /> </div>
                        <span class="help-box">
                            <?php _e('<b>Important:</b> use 3-digit ISO 4217 code like USD, AUD, GBP, EUR, ... <a href="https://en.wikipedia.org/wiki/ISO_4217#Active_codes">see more currency codes</a>', 'payment_pro'); ?>
                            <br/>
                            <?php _e('<b>Warning:</b> some currencies are not supported by all methods of payment, please check before use.', 'payment_pro'); ?>
                        </span>
                    </div>

                    <div class="form-row">
                        <div class="form-label"><?php _e('Show taxes in checkout', 'payment_pro'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('show_taxes', 'payment_pro') ? 'checked="true"' : ''); ?> name="show_taxes" value="1" />
                                    <?php _e('Force to show the taxes row in the checkout page even if taxes are 0.', 'payment_pro'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Default tax', 'payment_pro'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" name="default_tax" value="<?php echo osc_get_preference('default_tax', 'payment_pro'); ?>" /> % (percent)</div>
                        <span class="help-box"><?php _e('You could set a default tax that will apply to all products.', 'payment_pro'); ?></span>
                    </div>

                    <?php osc_run_hook('payment_pro_conf_form'); ?>
                    <div class="clear"></div>
                    <div class="form-actions">
                        <input type="submit" id="save_changes" value="<?php echo osc_esc_html( __('Save changes') ); ?>" class="btn btn-submit" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<form id="dialog-howto" method="get" action="#" class="has-form-actions hide">
    <div class="form-horizontal">
        <div class="form-row">
            <h3><?php _e('How to change PAYMENT_PRO_CRYPT_KEY', 'payment_pro'); ?></h3>
            <p>
                <?php _e('PAYMENT_PRO_CRYPT_KEY is an unique key of <b>16, 24 or 32 characters long</b> to encrypt your payment information. You need to change it to something unique and not too short.', 'payment_pro'); ?>.
                <br/>
                <?php printf(__('PAYMENT_PRO_CRYPT_KEY should be defined in %s . If you do not have said file, create it with the following content: ', 'payment_pro'), PAYMENT_PRO_PATH.'config.php'); ?>.
                <br/>
                <pre>
                    &lt;?php
                    if(!defined('PAYMENT_PRO_CRYPT_KEY')) {
                        define('PAYMENT_PRO_CRYPT_KEY', 'randompasswordchangethis');
                    }
                </pre>
            </p>
        </div>
        <div class="form-actions">
            <div class="wrapper">
                <a class="btn" href="javascript:void(0);" onclick="$('#dialog-howto').dialog('close');"><?php _e('Cancel'); ?></a>
            </div>
        </div>
    </div>
</form>
<form id="dialog-highlight" method="get" action="#" class="has-form-actions hide">
    <div class="form-horizontal">
        <div class="form-row">
            <h3><?php _e('More about highlighted listings', 'payment_pro'); ?></h3>
            <div>
                <?php _e('You could highlight some listings in the search pages with this option, but you need to modify your theme first.', 'payment_pro'); ?>.
                <br/>
                <?php _e('There are a few useful functions for highlighted listings. ', 'payment_pro'); ?>
               <ul>
                   <li>
                       <?php _e('"payment_pro_is_highlighted($id)" accepts an $id as parameter (optional) and will return true/false if a listings is or not highlighted.', 'payment_pro'); ?>
                   </li>
                   <li>
                       <?php _e('"payment_pro_print_highlight_class($id)" accepts an $id as parameter (optional) and will <b>print</b> the highlight class "payment-pro-highlighted"', 'payment_pro'); ?>
                   </li>
                   <li>
                       <?php _e('osc_run_hook("highlight_class") will also print the highlight class and <b>it is safe</b>, meaning that it will not output any error even if the plugin is disabled', 'payment_pro'); ?>
                   </li>
               </ul>
            </div>
            <h3><?php _e('Setting up your theme', 'payment_pro'); ?></h3>
            <div>
                <?php _e('In order to use the highlighted listing feature, you need to make a minimal modification to your theme.', 'payment_pro'); ?>:
                <br/>
                <?php _e('In the search page template, you need to add the following in the <b>class</b> attribute of the div of the listing', 'payment_pro'); ?>
                <br/>
                <pre>
                    class="&lt;?php osc_run_hook("highlight_class"); ?&gt;"
                </pre>
                <i><?php _e('(Note: you probably already have a class attribute, in that case, just add the osc_run_hook part)', 'payment_pro'); ?></i>
            </div>
            <h3><?php _e('Examples', 'payment_pro'); ?></h3>
            <div>
                <?php _e('In bender theme, you need to modify the file loop-single.php. Look for line 24, change it from ', 'payment_pro'); ?>.
                <br/>
                <pre>
                    &lt;li class="listing-card &lt;?php echo $class; if(osc_item_is_premium()){ echo ' premium'; } ?&gt;"&gt;
                </pre>
                <?php _e('to', 'payment_pro'); ?>.
                <br/>
                <pre>
                    &lt;li class="&lt;?php osc_run_hook("highlight_class"); ?&gt; listing-card &lt;?php echo $class; if(osc_item_is_premium()){ echo ' premium'; } ?&gt;"&gt;
                </pre>
            </div>
        </div>
        <div class="form-actions">
            <div class="wrapper">
                <a class="btn" href="javascript:void(0);" onclick="$('#dialog-paypal').dialog('close');"><?php _e('Cancel'); ?></a>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" >
    $(document).ready(function(){
        $("#dialog-howto").dialog({
            autoOpen: false,
            modal: true,
            width: '90%',
            title: '<?php echo osc_esc_js( __('How to change PAYMENT_PRO_CRYPT_KEY', 'payment_pro') ); ?>'
        });

        $("#dialog-highlight").dialog({
            autoOpen: false,
            modal: true,
            width: '90%',
            title: '<?php echo osc_esc_js( __('Highlight help', 'payment_pro') ); ?>'
        });

        $('#highlight_color').ColorPicker({
            onSubmit: function(hsb, hex, rgb, el) { },
            onChange: function (hsb, hex, rgb) {
                $('#highlight_color').val(hex);
                $('#highlight_color_sample').prop("style", "background-color: #" + hex + ";");
            }
        });

    });
</script>
<?php
    osc_run_hook('payment_pro_conf_footer');
