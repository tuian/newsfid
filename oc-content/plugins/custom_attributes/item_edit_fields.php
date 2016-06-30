<?php
if ( !defined('ABS_PATH') ) { 
	exit('ABS_PATH is not loaded. Direct access is not allowed.');
}
?>

<?php
foreach ($fields as $field) {
	$field_id = $field['pk_i_id'];
	$label = $field['s_label'];
	$type = $field['s_type'];
	$name = 'field_' . $field['pk_i_id'];
	$value = Attributes::newInstance()->getValue($item_id, $field_id); 
	$required = $field['b_required'];
	// Build classes
	if ($required) {
		$class = 'required';
	} else {
		$class = '';
	}
	if ($type == 'date') {
		$class .= 'edit_date';
	}
	if (!empty($class)) {
		$class = "" . trim($class) . "";
	}
	// Get saved value from sesssion
	if( Session::newInstance()->_getForm($name) != '') {
		$value = Session::newInstance()->_getForm($name);
	}	
?>
<div class="form-group">
	<input type='hidden' name='fields[]' value='<?php echo $field_id; ?>' />
    <label class="col-sm-3 control-label" for='<?php echo $name; ?>'><?php echo $label; ?></label>
    <?php if ($type == 'checkbox') {  ?>
    <?php $checked = ($value == 'checked') ? " checked='checked'" : ''; ?>
    <div class="col-sm-8 checkbox">
    	<input id='<?php echo $name; ?>' type='checkbox' name='<?php echo $name; ?>' value='checked'<?php echo $checked; ?> />&nbsp;&nbsp;<?php _e('Tick for "Yes"', CA_PLUGIN_NAME); ?>
    </div>
    <?php } elseif ($type == 'date') { ?>
    <div class="col-sm-8">
    	<input id='<?php echo $name; ?>' class='form-control <?php echo $class; ?>' type='text' name='<?php echo $name; ?>' value='<?php echo $value; ?>' />
    </div>
    <?php } elseif ($type == 'radio') { ?>
    <div class="col-sm-8 checkbox">
    	<?php $this->radio_buttons($field_id, $name, $value, $required); ?>	
    </div>
	<?php } elseif ($type == 'select') { ?>
    <div class="col-sm-8">
        <select id='<?php echo $name; ?>'<?php echo $class; ?> name='<?php echo $name; ?>'>
            <?php $this->select_options($field_id, $value); ?>
        </select>
    </div>
	<?php } elseif ($type == 'text') { ?>
    <div class="col-sm-8">
    	<input id='<?php echo $name; ?>' class='form-control <?php echo $class; ?>' type='text' name='<?php echo $name; ?>' value='<?php echo $value; ?>' />
	</div>
	<?php } elseif ($type == 'textarea') {  ?>
    <div class="col-sm-8">
    	<textarea id='<?php echo $name; ?>' class='form-control <?php echo $class; ?>' name='<?php echo $name; ?>'><?php echo $value; ?></textarea>
	</div>
	<?php } ?>
</div>
<?php } ?>
<?php /*?><?php if ($required) { ?>
	<span class='required'>*</span>
<?php } ?><?php */?>