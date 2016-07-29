<?php
osc_run_hook('payment_pro_done_page', Params::getParam('tx'));
$user = get_user_data(osc_logged_user_id());
$transaction_array['dt_date'] = date("Y-m-d H:i:s");
$transaction_array['s_code'] = Params::getParam('tx');
$transaction_array['i_amount'] = 4.99;
$transaction_array['s_currency_code'] = 'USD';
$transaction_array['s_email'] = $user['s_email'];
$transaction_array['fk_i_user_id'] = $user['user_id'];
$transaction_array['s_source'] = 'PAYPAL';
$transaction_array['i_status'] = '1';

$transaction_data = new DAO();
$transaction_data->dao->insert("{$db_prefix}t_payment_pro_invoice", $transaction_array);


$user_data = new DAO();
$user_data->dao->update("{$db_prefix}t_user", array('user_type' => '1', 'valid_date' => date("Y-m-d H:i:s")), array('pk_i_id' => $user['user_id']));
osc_add_flash_ok_message('Payment added successfully');
?>
<script type="text/javascript">
    window.location.href = "<?php echo osc_base_url(); ?>";
</script>
<div style='text-align: center;width: 100%; '>
    <div style="margin:2em;font-size: 2em;line-height: 1.2em;">
        <p><?php _e('Want to publish more listings?', 'payment_pro'); ?></p>
    </div>

    <a class="ui-button ui-button-main" href="<?php echo osc_item_post_url_in_category(); ?>"><?php _e("Publish another listing", 'payment_pro'); ?></a>
    <a class="ui-button ui-button-blacktext" href="<?php echo osc_base_url(); ?>"><?php _e('Continue browsing', 'payment_pro'); ?></a>
</div>
