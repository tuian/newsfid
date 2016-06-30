<?php
/*
  Plugin Name: Telephone
  Plugin URI: http://theme.calinbehtuk.ro
  Description: This plugin allow you to include a phone field on each item
  Version: 1.0.0
  Author: Puiu Calin
  Author URI: http://theme.calinbehtuk.ro
  Short Name: telephone
  Plugin update URI: telephone-plugin
 */
require_once 'Modelphone.php';

function telephone_install() {
    Modelphone::newInstance()->install_db_phone();
}

function telephone_uninstall() {
    Modelphone::newInstance()->uninstall_db_phone();
}

function osc_set_telephone_number() {
    $detail = '';
    if (osc_is_publish_page()) {
        if (Session::newInstance()->_getForm('telephone') != '') {
            $detail = Session::newInstance()->_getForm('telephone');
        }
    } else if (osc_is_edit_page()) {
        if (Session::newInstance()->_getForm('telephone') != '') {
            $detail = Session::newInstance()->_getForm('telephone');
        } else {
            $value = Modelphone::newInstance()->t_check_value(osc_item_id());
            if (!empty($value)) {
                $detail = $value['s_telephone'];
            }
        }
    }
    ?>
    <div class="box control-group">
        <div class="row">
            <label for="telephone"><?php _e('Phone', 'telephone'); ?></label>
            <div class="controls">
                <input id="telephone" type="text" value="<?php echo $detail; ?>" name="telephone"></input>
            </div>
        </div>
    </div>
    <?php
}

function telephone_insert_number($item) {
    $id = $item['pk_i_id'];
    $number = Params::getParam("telephone");
    if ($number != '') {
        Modelphone::newInstance()->t_insert_number($id, $number);
    }
}

osc_add_hook('posted_item', 'telephone_insert_number');

function telephone_edited_number($item) {
    $id = $item['pk_i_id'];
    $number = Params::getParam("telephone");
    if ($number != '') {
        Modelphone::newInstance()->t_insert_number($id, $number);
    }
}

osc_add_hook('edited_item', 'telephone_edited_number');

function telephone_deleted_number($id) {
    Modelphone::newInstance()->delete_number($id);
}

osc_add_hook('delete_item', 'telephone_deleted_number');

function pre_post_store_value() {
    Session::newInstance()->_setForm('telephone', Params::getParam("telephone"));
    //Session::newInstance()->_keepForm('telephone');
}

function osc_telephone_number() {
    if(osc_is_ad_page()) {
        $detail = Modelphone::newInstance()->t_check_value(osc_item_id());
        if (isset($detail['s_telephone'])) { ?>
<div style="display:block;margin-bottom:5px;" class="phone_telephone"><?php _e('Phone', 'telephone'); ?>: <?php echo $detail['s_telephone']; ?></div>
        <?php }
    }
}

function thelephone_help() {
    osc_admin_menu_plugins('' . __('Telephone Help', 'telephone'), osc_admin_render_plugin_url('telephone/help.php'), 'telephone_submenu');
}
function telephone_config(){
    osc_admin_render_plugin('telephone/help.php');
}
osc_add_hook('pre_item_post', 'pre_post_store_value');
osc_add_hook('admin_menu_init', 'thelephone_help');
osc_register_plugin(osc_plugin_path(__FILE__), 'telephone_install');
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", 'telephone_uninstall');
osc_add_hook(osc_plugin_path(__FILE__)."_configure", 'telephone_config');

