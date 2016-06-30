<div style='text-align: center;width: 100%; '>
<div style="margin:2em;font-size: 2em;line-height: 1.2em;">
    <p><?php _e(' Publier une autre annonce?', 'payment_pro'); ?></p>
</div>

<a class="ui-button ui-button-main" href="<?php echo osc_item_post_url_in_category(); ?>"><?php _e("Publier une autre annonce", 'payment_pro'); ?></a>
<a class="ui-button ui-button-blacktext" href="<?php echo osc_base_url(); ?>"><?php _e('Continuer la naviguation', 'payment_pro'); ?></a>
</div>
<?php osc_run_hook('payment_pro_done_page', Params::getParam('tx'));