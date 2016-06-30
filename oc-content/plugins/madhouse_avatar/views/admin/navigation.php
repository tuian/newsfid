<div class="bg-white">
    <ul class="nav nav-tabs nav-tabs-alt nav-md vpadder-lg">
        <li class="<?php echo (Params::getParam("route") == mdh_current_plugin_name())?"active": ""; ?>">
            <a href="<?php echo mdh_avatar_settings_url(); ?>"><?php _e("Settings",mdh_current_plugin_name()); ?></a>
        </li>
        <li class="<?php echo (Params::getParam("route") == mdh_current_plugin_name()."_regenerate")?"active":"";?>">
            <a href="<?php echo mdh_avatar_regenerate_url(); ?>"><?php _e("Regenerate",mdh_current_plugin_name()); ?></a>
        </li>
        <li class="">
        <a href="http://wearemadhouse.wordpress.com" target="_blank"><?php _e("Help",mdh_current_plugin_name()); ?></a>
        </li>
    </ul>
</div>