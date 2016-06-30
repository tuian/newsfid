<form id="dialog-authorize" method="get" action="#" class="has-form-actions hide">
    <div class="form-horizontal">
        <div class="form-row">
        </div>
        <div class="form-actions">
            <div class="wrapper">
                <a class="btn" href="javascript:void(0);" onclick="$('#dialog-authorize').dialog('close');"><?php _e('Cancel'); ?></a>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" >
    $(document).ready(function(){
        $("#dialog-authorize").dialog({
            autoOpen: false,
            modal: true,
            width: '90%',
            title: '<?php echo osc_esc_js( __('Authorize.Net help', 'payment_pro') ); ?>'
        });
    });
</script>