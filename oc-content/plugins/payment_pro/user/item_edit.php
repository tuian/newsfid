
<h2><?php _e('Publish options', 'payment_pro') ; ?></h2>
<div class="control-group">
    <?php if($payment_pro_premium_fee>0) { ?>
        <div class="controls checkbox">
            <input type="checkbox"  name="payment_pro_make_premium" id="payment_pro_make_premium" value="1"  /> <label style="color: red; font-size: 14px;" ><?php printf(__(' Promoted this story (+%s)', 'payment_pro'), osc_format_price($payment_pro_premium_fee*1000000, osc_get_preference('Devise', 'payment_pro'))); ?></label>
      </div>
    <?php };
    if($payment_pro_publish_fee>0) { ?>
    <div class="controls checkbox">
        <label><?php printf(__(' Promote this story costs %s', 'payment_pro'), osc_format_price($payment_pro_publish_fee*1000000, osc_get_preference('Devise', 'payment_pro'))); ?></label>
    </div>
    <?php }; ?>
</div>