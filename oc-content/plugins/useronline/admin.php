<?php
/*
 *      OSCLass – software for creating and publishing online classified
 *                           advertising platforms
 *
 *                        Copyright (C) 2010 OSCLASS
 *
 *       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
 if (Params::getParam('plugin_action') == 'done')

{
	osc_set_preference('useronline_set_text_image',Params::getParam('image_text'), 'useronline', 'STRING');

	osc_set_preference('useronline_text',Params::getParam('online_text'), 'useronline', 'STRING');

	osc_set_preference('useroffline_text',Params::getParam('offline_text'), 'useronline', 'STRING');

	echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Congratulations. The plugin is now configured', 'useronline') . '.<a href="#" title="Close Message" onclick="parentNode.remove()" style="float:right;font-weight:bold;padding-right:50px;color:#FFFFFF;">' . __('x', 'deletespam') . '</a></p></div>';

	osc_reset_preferences();

}
 
?>

<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
<div style="padding:20px;">
 <form name="useronline_form" id="useronline_form" action="<?php

echo osc_admin_base_url(true);

?>" method="POST" enctype="multipart/form-data" >

                                <div style="float: left; width: 100%;">



                                    <input type="hidden" name="page" value="plugins" />



                                    <input type="hidden" name="action" value="renderplugin" />



                                    <input type="hidden" name="file" value="<?php

echo osc_plugin_folder(__FILE__);

?>admin.php" />



                                    <input type="hidden" name="plugin_action" value="done" />



                                    <label for="image_text" style="font-weight:700;font-size:16px;"><?php

_e('Set if you want image or text', 'useronline');

?></label>
<?php

$ImageOrText = osc_get_preference('useronline_set_text_image', 'useronline');

?>
<input type="radio" name="image_text" id="image_text" value="image" <?php

if ($ImageOrText == 'image')

{

	echo ' checked';

}

?> /><span>Image</span>



                                    <input type="radio" name="image_text" id="image_text" value="text" <?php

if ($ImageOrText == 'text')

{

	echo ' checked';

}

?> /><span>Text</span><br/><br/>

<label for="online_text" style="font-weight:700;font-size:16px;"><?php

_e('User Online Text', 'useronline');

?></label>
<input type="text" name="online_text" id="online_text" value="<?php echo osc_get_preference('useronline_text', 'useronline'); ?>"  />
<br/><br/>
<label for="offline_text" style="font-weight:700;font-size:16px;"><?php

_e('User Offline Text', 'useronline');

?></label>
<input type="text" name="offline_text" id="offline_text" value="<?php echo osc_get_preference('useroffline_text', 'useronline'); ?>"  />
<p><button style="font-size:16px; font-weight:700;" type="submit" ><?php

_e('Update', 'useronline');

?></button></p>  <br/>
</form>
</div><hr/>
    <div style="padding: 0 20px 20px;"><h1>Stats</h1>
        <div><br/>
        <?php total_user_online(); ?>
        </div>
        <div><br/>
        <style type="text/css">
    .counterstyle { text-align:center; border: solid #ccc 1px; -moz-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px; -webkit-box-shadow: 0 1px 1px #ccc; -moz-box-shadow: 0 1px 1px #ccc; box-shadow: 0 1px 1px #ccc; font-family: "trebuchet MS", "Lucida sans", Arial; font-size: 13px; color: #444; *border-collapse: collapse; /* IE7 and lower */ border-spacing: 0; width: auto;}
    .counterstyle tr:hover { background: #fbf8e9;}
    .counterstyle td{text-align:center; border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 3px;}
    .counterstyle td.flag img{text-align:center; width: 30px; height: 20px;}
  </style>
  <table width="100%" class="counterstyle"><tbody>
  <tr>
  <td >User Name</td>
	<td>User Id</td>
	<td>User Registration Date</td>
	<td>User Email</td>
    <td>User Total Ads</td>
	<td>User Access IP</td>
	<td>User Access Date</td>
  </tr>
        <?php list_user_online(); ?>	
</tbody></table>
        </div>
        <hr />
<div class="donationpaypal">
<p>Support cartagena68 by donating with PayPal</p><form action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="business" value="cartagena68@plugins-zone.com" data-original-title="" title=""> <input type="hidden" name="return" value="http://plugins-zone.com/" data-original-title="" title=""> <input type="hidden" name="rm" value="2" data-original-title="" title=""> <input type="hidden" name="cancel_return" value="http://plugins-zone.com/" data-original-title="" title=""> <input type="hidden" name="charset" value="UTF-8" data-original-title="" title=""> <input type="hidden" name="cmd" value="_donations" data-original-title="" title=""> <input type="hidden" name="bn" value="_Donate_WPS_en" data-original-title="" title=""> <input type="hidden" name="currency_code" value="USD" data-original-title="" title=""> <input type="hidden" name="lc" value="en-us" data-original-title="" title=""><div class="form-group lbab-amount"> <input type="text" name="amount" maxlength="16" data-original-title="" title=""><span>$</span></div><input type="hidden" name="item_name" value="Support Plugins Zone" data-original-title="" title=""> <input type="hidden" name="page_style" value="paypal" data-original-title="" title=""> <input type="hidden" name="cbt" value="Return to Plugins Zone" data-original-title="" title=""><div class="form-group lbab-donation-btn"><br /> <input type="submit" name="submit" value="Donate Now" data-original-title="" title=""></div></form></div>
<br /><br />
<style>.donationpaypal .form-group.lbab-amount span{color:#908f8f;padding:5px 0;font-size:25px;position:absolute;right:18px;top:4px;width:35px;height:30px;background:#cecece;z-index:100;text-shadow:1px 1px 1px #FFF;text-align:center;border-radius:0 3px 3px 0}.donationpaypal .lbab-donation-btn input{cursor:pointer;font:600 18px/22px "Open Sans",sans-serif;background:#cecece;border-radius:3px;text-transform:uppercase;padding:6px;border:0;width:150px;font-size:18px;color:#908f8f;text-shadow:1px 1px 1px #FFF}.donationpaypal .form-group.lbab-amount,.donationpaypal .lbab-donation-btn{position:relative;width:170px}.donationpaypal .form-group.lbab-amount input{margin-top:4px;padding:10px 37px 10px 10px;border:1px solid #b2b2b2;-webkit-appearance:textfield;box-sizing:content-box;border-radius:3px;box-shadow:0 1px 4px 0 rgba(168,168,168,.6) inset;transition:all .2s linear;width:102px;position:relative}</style>
        </div>
        </div>