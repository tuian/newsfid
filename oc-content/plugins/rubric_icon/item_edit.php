<h3><?php _e('MyOwn attributes', 'myown_attributes') ; ?></h3>
<table>
    <tr>
        <?php
            // This lines prevent to clear the field if the form is reloaded
            if( Session::newInstance()->_getForm('myown_myfield') != '' ) {
                $detail['myown_myfield'] = Session::newInstance()->_getForm('myown_myfield');
            }
        ?>
        <td><label for="make"><?php _e('MyField', 'myown_attributes'); ?></label></td>
    	<td><input type="text" name="myown_myfield" id="myown_myfield" value="<?php if(@$detail['s_myfield'] != ''){echo @$detail['s_myfield']; } ?>" size="20" /></td>
    </tr>
</table>
