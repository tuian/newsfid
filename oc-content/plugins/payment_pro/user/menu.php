<?php

    $itemsPerPage = (Params::getParam('itemsPerPage')!='')?Params::getParam('itemsPerPage'):10;
    $page         = (Params::getParam('iPage') > 0) ? Params::getParam('iPage') -1 : 0;
    $itemType     = 'all';
    $total_items  = Item::newInstance()->countItemTypesByUserID(osc_logged_user_id(), $itemType);
    $total_pages  = ceil($total_items/$itemsPerPage);
    $items        = Item::newInstance()->findItemTypesByUserID(osc_logged_user_id(), $page*$itemsPerPage, $itemsPerPage, $itemType);

    View::newInstance()->_exportVariableToView('items', $items);
    View::newInstance()->_exportVariableToView('search_total_pages', $total_pages);
    View::newInstance()->_exportVariableToView('list_total_items', $total_items);
    View::newInstance()->_exportVariableToView('items_per_page', $itemsPerPage);
    View::newInstance()->_exportVariableToView('list_page', $page);

?>
<div class="wrapper wrapper-flash">
    <div id="flash_js"></div>
</div>
<h2><?php _e('Your listings', 'payment_pro'); ?></h2>
<?php if(osc_count_items() == 0) { ?>
    <h3><?php _e('You don\'t have any listing yet', 'payment_pro'); ?></h3>
<?php } else { ?>
    <?php while(osc_has_items()) {

        $options = array();

        if (osc_get_preference("pay_per_post", 'payment_pro') == "1") {
            if (ModelPaymentPro::newInstance()->publishFeeIsPaid(osc_item_id())) {
                $options[] = '<strong>' . __('Paid!', 'payment_pro') . '</strong>';
            } else {
                $opt = '<strong>';
                $opt .= '<button id="pub_' . osc_item_id() .'" onclick="javascript:addProduct(\'pub\',' . osc_item_id() . ');">' . __('Publish this listing', 'payment_pro') . '</button>';
                $opt .= '</strong>';
                $options[] = $opt;
            };
        };
        if (osc_get_preference("allow_premium", 'payment_pro') == "1") {
            if (ModelPaymentPro::newInstance()->premiumFeeIsPaid(osc_item_id())) {
                $options[] = '<strong>' . __('Already premium!', 'payment_pro') . '</strong>';
            } else {
                $opt = '<strong>';
                $opt .= '<button id="prm_' . osc_item_id() . '" onclick="javascript:addProduct(\'prm\',' . osc_item_id() . ');">' . __('Make premium', 'payment_pro') . '</button>';
                $opt .= '</strong>';
                $options[] = $opt;
            }
        }
        if (osc_get_preference("allow_top", 'payment_pro') == "1") {
            if (time()-strtotime(osc_item_pub_date())<(7*24*3600)) {
                //$options[] = '<strong>' . __('Can not move to top', 'payment_pro') . '</strong>';
            } else {
                $opt = '<strong>';
                $opt .= '<button id="top_' . osc_item_id() . '" onclick="javascript:addProduct(\'top\',' . osc_item_id() . ');">' . __('Move to top', 'payment_pro') . '</button>';
                $opt .= '</strong>';
                $options[] = $opt;
            }
        }

        if (osc_get_preference("allow_highlight", 'payment_pro') == "1") {
            if (ModelPaymentPro::newInstance()->highlightFeeIsPaid(osc_item_id())) {
                $options[] = '<strong>' . __('Already highlighted!', 'payment_pro') . '</strong>';
            } else {
                $opt = '<strong>';
                $opt .= '<button id="hlt_' . osc_item_id() . '" onclick="javascript:addProduct(\'hlt\',' . osc_item_id() . ');">' . __('Highlight this listing', 'payment_pro') . '</button>';
                $opt .= '</strong>';
                $options[] = $opt;
            }
        }

        ?>
            <div class="item" >
                    <h3>
                        <a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a>
                    </h3>
                    <p>
                    <?php _e('Publication date', 'payment_pro') ; ?>: <?php echo osc_format_date(osc_item_pub_date()) ; ?><br />
                    <?php _e('Price', 'payment_pro') ; ?>: <?php echo osc_format_price(osc_item_price()); ?>
                    </p>
                    <?php
                    if(osc_get_preference('pay_per_post')!=1)
                    if((osc_get_preference('pay_per_post', 'payment_pro')!=1 && osc_item_is_enabled()) || (osc_get_preference('pay_per_post', 'payment_pro')==1 && ModelPaymentPro::newInstance()->isEnabled(osc_item_id()))) {
                        if(count($options)>0) {
                            echo '<p class="options">' . join("<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>", $options) . '</p>';
                        }
                    } else { ?>
                        <p class="options">
                            <strong><?php _e('This listing is blocked', 'payment_pro'); ?></strong>
                        </p>
                    <?php }; ?>
                    <br />
            </div>
    <?php } ?>
    <br />
    <div class="paginate">
    <?php for($i = 0 ; $i < $total_pages ; $i++) {
        if($i == $page) {
            printf('<a class="searchPaginationSelected" href="%s">%d</a>', osc_route_url('payment-pro-user-menu', array('iPage' => $i+1)), ($i + 1));
        } else {
            printf('<a class="searchPaginationNonSelected" href="%s">%d</a>', osc_route_url('payment-pro-user-menu', array('iPage' => $i+1)), ($i + 1));
        }
    } ?>
    </div>
    <script type="text/javascript">
        function addProduct(prd, id) {
            $("#" + prd + "_" + id).attr('disabled', true);
            $.ajax({
                type: "POST",
                url: '<?php echo osc_ajax_plugin_url(PAYMENT_PRO_PLUGIN_FOLDER . 'ajax.php'); ?>&' + prd + '=' + id,
                dataType: 'json',
                success: function(data){
                    if(data.error==0) {
                        window.location = '<?php echo osc_route_url('payment-pro-checkout'); ?>';
                    } else {
                        $("#" + prd + "_" + id).attr('disabled', false);
                        var flash = $("#flash_js");
                        var message = $('<div>').addClass('flashmessage').addClass('flashmessage-error').attr('id', 'flashmessage').html(data.msg);
                        flash.html(message);
                        $("#flashmessage").slideDown('slow').delay(3000).slideUp('slow');
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                }
            });
        }
    </script>
<?php } ?>
