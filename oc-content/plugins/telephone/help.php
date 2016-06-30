<style>
    .rights {display: block;
             background: #EBF6F6;
             padding: 10px;
             border: 1px solid #D6FFFF;
             line-height:20px;
    }
    .author {
        display: inline-block;
        background: #EBF6F6;
        border: 1px solid #D6FFFF;
        width:100%;
        margin-top:10px;
    }
</style>
<div class="rights">
    <a href="http://theme.calinbehtuk.ro" title="Premium theme and plugins for oslcass">
        <img src="<?php echo osc_base_url() ?>oc-content/plugins/telephone/images/calinbehtuk.png" title="premium theme and plugins for oslcass"/></a>
    <span style="float:right;line-height:40px;font-weight:700;"><?php _e('Follow:', 'telephone'); ?><a target="blank" style="text-decoration:none;" href="https://www.facebook.com/Calinbehtuk-themes-1086739291344584/"> <img style="margin-bottom:-5px;margin-left:5px;" src="<?php echo osc_base_url() ?>oc-content/plugins/telephone/images/facebook.png" title="facebook"/></a></span>
</div>
<div id="settings_form" style="border: 1px solid #ccc; background: #F3F3F3;margin-top:20px; ">
    <div style="padding: 0 20px 20px;">
        <div>
            <fieldset>
                <legend style="width:100%;">
                    <div style="float:right;">
                        <p style="display:block;color:#f80;font-weight:700;"><?php _e('Help us to keep this free', 'telephone'); ?></p>
                        <form style="display:block;margin-top:10px;" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="TL5PLDQHJB3XA">
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                        </form>
                    </div>
                    <h1><?php _e('Telephone Help', 'telephone'); ?></h1>
                </legend> 
                <p><?php _e('This plugin allow you to display a phone field in publish/edit page, in what area you want on this page. Custom fields are displayed all in the same area, but this plugin give you the option to display the phone field in different part of the page.', 'telephone'); ?></p>
                <p><?php _e('For using this plugin you have to insert this line in item post page and item edit page, in the area you want this field to appear', 'telephone'); ?>:
                </p>
                <pre>
                    &lt;?php osc_set_telephone_number(); ?&gt;
                </pre>
                <p><?php _e('To display the number of telephone you have to insert this line in the item page in the are you want to show the number', 'telephone'); ?>:
                </p>
                <pre>
                    &lt;?php osc_telephone_number(); ?&gt;
                </pre>
                <center>
                    <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/LkbM_ZYpkDI?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                </center>
            </fieldset>
        </div>
    </div>
</div>
<div class="author">
    <span style="float:right;padding:10px;"class="text"><a href="http://theme.calinbehtuk.ro/"><?php _e('2016 All rights reserved theme.calinbehtuk, telephone plugin by Puiu Calin', 'one'); ?></a></span>
</div>