<?php
/**
  Required theme functions
 * */
include 'ddfunctions.php';

define('FLATTER_THEME_VERSION', '2.1.0');

/* Search placeholder */
if (!osc_get_preference('keyword_placeholder', 'flatter_theme')) {
    osc_set_preference('keyword_placeholder', __('What are you looking for?', 'flatter'), 'flatter_theme');
}
/* Premium Count */
if (!osc_get_preference('premium_count', 'flatter_theme')) {
    osc_set_preference('premium_count', __('5', 'flatter'), 'flatter_theme');
}

/* Promo Text */
if (!osc_get_preference('fpromo_text', 'flatter_theme')) {
    osc_set_preference('fpromo_text', __('Post your ad Today. It&rsquo;s totally free!', 'flatter'), 'flatter_theme');
}
/* Useful Information */
if (!osc_get_preference('usefulinfo_msg', 'flatter_theme')) {
    osc_set_preference('usefulinfo_msg', __('<ul><li>Avoid scams by acting locally or paying with PayPal</li><li>Never pay with Western Union, Moneygram or other anonymous payment services</li><li>Don\'t buy or sell outside of your country. Don\'t accept cashier cheques from outside your country</li><li>This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer "buyer protection" or "seller certification"</li></ul>', 'flatter'), 'flatter_theme');
}

/* Address Map */
if (!osc_get_preference('address_map', 'flatter_theme')) {
    osc_set_preference('address_map', __('Disneyland, Anaheim, CA, United States', 'flatter'), 'flatter_theme');
}

/* Landing Popup */
if (!osc_get_preference('pop_heading', 'flatter_theme')) {
    osc_set_preference('pop_heading', __('Popup heading', 'flatter'), 'flatter_theme');
}
if (!osc_get_preference('landing_pop', 'flatter_theme')) {
    osc_set_preference('landing_pop', __('Popup content here', 'flatter'), 'flatter_theme');
}

//jaysukh
//authoirize user
if (!osc_logged_user_id()):
    $allow = array('');

//    osc_add_flash_error_message('You need to login to watch profile');
//    osc_redirect_to(osc_base_url());
endif;

//end jaysukh

/* Category Icons */

function category_icons() {
    $i = 0;
    while (osc_has_categories()) {
        ?>
        <div class="form-group">
            <label class="col-sm-2"><span><i class="<?php echo osc_esc_html(osc_get_preference('cat_icon_' . osc_category_id(), 'flatter_theme')); ?> fa-lg"></i></span>&nbsp;&nbsp;<?php echo osc_category_name(); ?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="cat_icon_<?php echo osc_category_id(); ?>" value="<?php echo osc_esc_html(osc_get_preference('cat_icon_' . osc_category_id(), 'flatter_theme')); ?>">
            </div>
        </div>
        <?php
        if (!osc_get_preference('cat_icon_' . osc_category_id(), 'flatter_theme')) {
            osc_set_preference('cat_icon_' . osc_category_id(), __('fa fa-star', 'flatter'), 'flatter_theme');
        }
        $i++;
    }
}

/**
  JQUERY FUNCTIONS
 * */
osc_remove_script('jquery'); // Remove osclass default(old version) jquery
osc_register_script('jquery', osc_current_web_theme_url('js/jquery/jquery-1.11.2.min.js')); // Add new version(1.11.2) of jquery
//osc_register_script('jquery-ui', osc_current_web_theme_url('js/jquery-ui/jquery-ui.min.js')); // Add new version(1.11.4) of jquery-ui
osc_enqueue_script('jquery-ui');
osc_enqueue_style('jquery-ui', osc_current_web_theme_url('js/jquery-ui/jquery-ui.min.css'));

// used for date/dateinterval custom fields
osc_enqueue_script('php-date');
if (!OC_ADMIN) {
    osc_enqueue_style('fine-uploader-css', osc_assets_url('js/fineuploader/fineuploader.css'));
    osc_enqueue_style('flatter-fine-uploader-css', osc_current_web_theme_url('css/ajax-uploader.css'));
}
if (osc_is_publish_page() || osc_is_edit_page()) {
    osc_enqueue_script('jquery-fineuploader');
}


/**
  FUNCTIONS
 * */
// install options
if (!function_exists('flatter_theme_install')) {

    function flatter_theme_install() {
        osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'flatter_theme');
        osc_set_preference('version', FLATTER_THEME_VERSION, 'flatter_theme');
        osc_set_preference('footer_link', '1', 'flatter_theme');
        osc_set_preference('facebook_likebox', '1', 'flatter_theme');
        osc_set_preference('contact_enable', '1', 'flatter_theme');
        osc_set_preference('google_adsense', '0', 'flatter_theme');
        osc_set_preference('subscribe_show', '1', 'flatter_theme');
        osc_set_preference('geo_ads', '1', 'flatter_theme');
        osc_set_preference('anim', '1', 'flatter_theme');
        osc_set_preference('usefulinfo_show', '1', 'flatter_theme');
        osc_set_preference('pop_enable', '0', 'flatter_theme');
        osc_set_preference('location_input', '0', 'flatter_theme');

        osc_set_preference('position1_enable', '0', 'flatter_theme');
        osc_set_preference('position2_enable', '0', 'flatter_theme');
        osc_set_preference('position3_enable', '0', 'flatter_theme');
        osc_set_preference('position4_enable', '0', 'flatter_theme');
        osc_set_preference('position5_enable', '0', 'flatter_theme');
        osc_set_preference('position6_enable', '0', 'flatter_theme');
        osc_set_preference('position7_enable', '0', 'flatter_theme');
        osc_set_preference('position8_enable', '0', 'flatter_theme');
        osc_set_preference('position9_enable', '0', 'flatter_theme');
        osc_set_preference('position10_enable', '0', 'flatter_theme');

        osc_set_preference('position1_hide', '1', 'flatter_theme');
        osc_set_preference('position2_hide', '1', 'flatter_theme');
        osc_set_preference('position3_hide', '1', 'flatter_theme');
        osc_set_preference('position4_hide', '1', 'flatter_theme');
        osc_set_preference('position5_hide', '1', 'flatter_theme');
        osc_set_preference('position6_hide', '1', 'flatter_theme');
        osc_set_preference('position7_hide', '1', 'flatter_theme');
        osc_set_preference('position8_hide', '1', 'flatter_theme');
        osc_set_preference('position9_hide', '1', 'flatter_theme');
        osc_set_preference('position10_hide', '1', 'flatter_theme');

        osc_set_preference('premium_count', Params::getParam('premium_count'), 'flatter_theme');
        osc_set_preference('terms_link', Params::getParam('terms_link'), 'flatter_theme');
        osc_set_preference('privacy_link', Params::getParam('privacy_link'), 'flatter_theme');
        osc_set_preference('facebook_page', Params::getParam('facebook_page'), 'flatter_theme');
        osc_set_preference('twitter_page', Params::getParam('twitter_page'), 'flatter_theme');
        osc_set_preference('gplus_page', Params::getParam('gplus_page'), 'flatter_theme');
        osc_set_preference('pinterest_page', Params::getParam('pinterest_page'), 'flatter_theme');
        osc_set_preference('g_analytics', Params::getParam('g_analytics'), 'flatter_theme');
        osc_set_preference('g_webmaster', Params::getParam('g_webmaster'), 'flatter_theme');
        osc_set_preference('fpromo_text', Params::getParam('fpromo_text'), 'flatter_theme');
        osc_set_preference('fcwidget_title', Params::getParam('fcwidget_title'), 'flatter_theme');

        osc_set_preference('custom_css', Params::getParam('custom_css'), false, 'flatter_theme');
        osc_set_preference('landing_pop', Params::getParam('landing_pop'), false, 'flatter_theme');
        osc_set_preference('pop_heading', Params::getParam('pop_heading'), false, 'flatter_theme');

        osc_set_preference('position1_content', Params::getParam('position1_content'), false, 'flatter_theme');
        osc_set_preference('position2_content', Params::getParam('position2_content'), false, 'flatter_theme');
        osc_set_preference('position3_content', Params::getParam('position3_content'), false, 'flatter_theme');
        osc_set_preference('position4_content', Params::getParam('position4_content'), false, 'flatter_theme');
        osc_set_preference('position5_content', Params::getParam('position5_content'), false, 'flatter_theme');
        osc_set_preference('position6_content', Params::getParam('position6_content'), false, 'flatter_theme');
        osc_set_preference('position7_content', Params::getParam('position7_content'), false, 'flatter_theme');
        osc_set_preference('position8_content', Params::getParam('position8_content'), false, 'flatter_theme');
        osc_set_preference('position9_content', Params::getParam('position9_content'), false, 'flatter_theme');
        osc_set_preference('position10_content', Params::getParam('position10_content'), false, 'flatter_theme');

        osc_set_preference('contact_address', false, 'flatter_theme');
        osc_set_preference('usefulinfo_msg', false, 'flatter_theme');
        osc_set_preference('address_map', false, 'flatter_theme');

        osc_set_preference('adsense_sidebar', false, 'flatter_theme');
        osc_set_preference('adsense_listing', false, 'flatter_theme');
        osc_set_preference('adsense_searchtop', false, 'flatter_theme');
        osc_set_preference('adsense_searchbottom', false, 'flatter_theme');
        osc_set_preference('adsense_searchside', false, 'flatter_theme');

        osc_set_preference('fcwidget_content', false, 'fcwidget_content');

        $i = 0;
        while (osc_has_categories()) {
            osc_set_preference('cat_icon_' . osc_category_id(), Params::getParam('cat_icon_' . osc_category_id()), 'flatter_theme');
            $i++;
        }
        osc_set_preference('defaultShowAs@all', 'list', 'flatter_theme');
        osc_set_preference('defaultShowAs@search', 'list');
        osc_set_preference('defaultColor@all', 'green', 'flatter_theme');
        osc_reset_preferences();
    }

}
// update options
if (!function_exists('flatter_theme_update')) {

    function flatter_theme_update() {
//osc_set_preference('version', FLATTER_THEME_VERSION, 'flatter_theme');
        osc_delete_preference('default_logo', 'flatter_theme');

        $logo_prefence = osc_get_preference('logo', 'flatter_theme');
        $logo_name = 'flatter_logo';
        $temp_name = WebThemes::newInstance()->getCurrentThemePath() . 'images/logo.jpg';
        if (file_exists($temp_name) && !$logo_prefence) {

            $img = ImageResizer::fromFile($temp_name);
            $ext = $img->getExt();
            $logo_name .= '.' . $ext;
            $img->saveToFile(osc_uploads_path() . $logo_name);
            @unlink($temp_name);
            osc_set_preference('logo', $logo_name, 'flatter_theme');
        }
        osc_reset_preferences();
    }

}
if (!function_exists('check_install_flatter_theme')) {

    function check_install_flatter_theme() {
        $current_version = osc_get_preference('version', 'flatter_theme');
//check if current version is installed or need an update<
        if (!$current_version) {
            flatter_theme_install();
        } else if ($current_version < FLATTER_THEME_VERSION) {
            flatter_theme_update();
        }
    }

}

if (!function_exists('flatter_add_body_class_construct')) {

    function flatter_add_body_class_construct($classes) {
        $flatterBodyClass = flatterBodyClass::newInstance();
        $classes = array_merge($classes, $flatterBodyClass->get());
        return $classes;
    }

}
if (!function_exists('flatter_body_class')) {

    function flatter_body_class($echo = true) {
        /**
         * Print body classes.
         *
         * @param string $echo Optional parameter.
         * @return print string with all body classes concatenated
         */
        osc_add_filter('flatter_bodyClass', 'flatter_add_body_class_construct');
        $classes = osc_apply_filter('flatter_bodyClass', array());
        if ($echo && count($classes)) {
            echo '' . implode(' ', $classes) . '';
        } else {
            return $classes;
        }
    }

}
if (!function_exists('flatter_add_body_class')) {

    function flatter_add_body_class($class) {
        /**
         * Add new body class to body class array.
         *
         * @param string $class required parameter.
         */
        $flatterBodyClass = flatterBodyClass::newInstance();
        $flatterBodyClass->add($class);
    }

}
if (!function_exists('flatter_nofollow_construct')) {

    /**
     * Hook for header, meta tags robots nofollos
     */
    function flatter_nofollow_construct() {
        echo '<meta name="robots" content="noindex, nofollow, noarchive" />' . PHP_EOL;
        echo '<meta name="googlebot" content="noindex, nofollow, noarchive" />' . PHP_EOL;
    }

}
if (!function_exists('flatter_follow_construct')) {

    /**
     * Hook for header, meta tags robots follow
     */
    function flatter_follow_construct() {
        echo '<meta name="robots" content="index, follow" />' . PHP_EOL;
        echo '<meta name="googlebot" content="index, follow" />' . PHP_EOL;
    }

}
/* logo edited by DD */
if (!function_exists('logo_header')) {

    function logo_header() {
        $logo = osc_get_preference('logo', 'flatter_theme');
        $html = '<div class="logoimg"><img border="0" alt="' . osc_page_title() . '" src="' . flatter_logo_url() . '"></div>';
        if ($logo != '' && file_exists(osc_uploads_path() . $logo)) {
            return $html;
        } else {
            return '<div class="logoname">' . osc_page_title() . '</div>';
        }
    }

}
/* logo */
if (!function_exists('flatter_logo_url')) {

    function flatter_logo_url() {
        $logo = osc_get_preference('logo', 'flatter_theme');
        if ($logo) {
            return osc_uploads_url($logo);
        }
        return false;
    }

}
if (!function_exists('flatter_draw_item')) {

    function flatter_draw_item($class = false, $admin = false, $premium = false) {
        $filename = 'loop-single';
        if ($premium) {
            $filename .='-premium';
        }
        require WebThemes::newInstance()->getCurrentThemePath() . $filename . '.php';
    }

}
if (!function_exists('flatter_show_as')) {

    function flatter_show_as() {

        $p_sShowAs = Params::getParam('sShowAs');
        $aValidShowAsValues = array('list', 'gallery');
        if (!in_array($p_sShowAs, $aValidShowAsValues)) {
            $p_sShowAs = flatter_default_show_as();
        }

        return $p_sShowAs;
    }

}
if (!function_exists('flatter_default_show_as')) {

    function flatter_default_show_as() {
        return getPreference('defaultShowAs@all', 'flatter_theme');
    }

}
if (!function_exists('flatter_def_color')) {

    function flatter_def_color() {
        return getPreference('defaultColor@all', 'flatter_theme');
    }

}
if (!function_exists('flatter_draw_categories_list')) {

    function flatter_draw_categories_list() {
        ?>
        <?php
//cell_3
        $total_categories = osc_count_categories();
        $col1_max_cat = ceil($total_categories / 4);

        osc_goto_first_category();
        $i = 0;

        while (osc_has_categories()) {
            ?>
            <?php
            if ($i % $col1_max_cat == 0) {
                if ($i > 0) {
                    echo '</div>';
                }
                if ($i == 0) {
                    echo '<div class="col-md-3 col-sm-6 col-xs-12 first_cel">';
                } else {
                    echo '<div class="col-md-3 col-sm-6 col-xs-12">';
                }
            }
            ?>
            <div class="cat-single">
                <div class="pull-left">
                    <a class="<?php echo osc_category_slug(); ?>" href="<?php echo osc_search_category_url(); ?>"><i class="<?php echo osc_esc_html(osc_get_preference('cat_icon_' . osc_category_id(), 'flatter_theme')); ?> fa-2x sclr"></i></a>
                </div>
                <ul class="category">
                    <li>
                        <h4 class="clr">
                            <a class="<?php echo osc_category_slug(); ?>" href="<?php echo osc_search_category_url(); ?>"><?php echo osc_category_name(); ?> </a>
                        </h4>
                        <p class="hidden-xs"><?php echo osc_category_description(); ?></p>
                        <?php if (osc_count_subcategories() > 0) { ?>
                            <ul class="sub-categories">
                                <?php while (osc_has_subcategories()) { ?>
                                    <li>
                                        <a class="<?php echo osc_category_slug(); ?>" href="<?php echo osc_search_category_url(); ?>"><?php echo osc_category_name(); ?> (<?php echo osc_category_total_items(); ?>)</a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                </ul>
            </div>
            <?php
            $i++;
        }
        echo '</div>';
        ?>
        <?php
    }

}
if (!function_exists('flatter_search_number')) {

    /**
     *
     * @return array
     */
    function flatter_search_number() {
        $search_from = ((osc_search_page() * osc_default_results_per_page_at_search()) + 1);
        $search_to = ((osc_search_page() + 1) * osc_default_results_per_page_at_search());
        if ($search_to > osc_search_total_items()) {
            $search_to = osc_search_total_items();
        }

        return array(
            'from' => $search_from,
            'to' => $search_to,
            'of' => osc_search_total_items()
        );
    }

}
/*
 * Helpers used at view
 */
if (!function_exists('flatter_item_title')) {

    function flatter_item_title() {
        $title = osc_item_title();
        foreach (osc_get_locales() as $locale) {
            if (Session::newInstance()->_getForm('title') != "") {
                $title_ = Session::newInstance()->_getForm('title');
                if (@$title_[$locale['pk_c_code']] != "") {
                    $title = $title_[$locale['pk_c_code']];
                }
            }
        }
        return $title;
    }

}
if (!function_exists('flatter_item_description')) {

    function flatter_item_description() {
        $description = osc_item_description();
        foreach (osc_get_locales() as $locale) {
            if (Session::newInstance()->_getForm('description') != "") {
                $description_ = Session::newInstance()->_getForm('description');
                if (@$description_[$locale['pk_c_code']] != "") {
                    $description = $description_[$locale['pk_c_code']];
                }
            }
        }
        return $description;
    }

}
if (!function_exists('related_listings')) {

    function related_listings() {
        View::newInstance()->_exportVariableToView('items', array());

        $mSearch = new Search();
        $mSearch->addCategory(osc_item_category_id());
        $mSearch->addRegion(osc_item_region());
        $mSearch->addItemConditions(sprintf("%st_item.pk_i_id < %s ", DB_TABLE_PREFIX, osc_item_id()));
        $mSearch->limit('0', '6');

        $aItems = $mSearch->doSearch();
        $iTotalItems = count($aItems);
        if ($iTotalItems == 6) {
            View::newInstance()->_exportVariableToView('items', $aItems);
            return $iTotalItems;
        }
        unset($mSearch);

        $mSearch = new Search();
        $mSearch->addCategory(osc_item_category_id());
        $mSearch->addItemConditions(sprintf("%st_item.pk_i_id != %s ", DB_TABLE_PREFIX, osc_item_id()));
        $mSearch->limit('0', '6');

        $aItems = $mSearch->doSearch();
        $iTotalItems = count($aItems);
        if ($iTotalItems > 0) {
            View::newInstance()->_exportVariableToView('items', $aItems);
            return $iTotalItems;
        }
        unset($mSearch);

        return 0;
    }

}

if (!function_exists('osc_is_contact_page')) {

    function osc_is_contact_page() {
        if (Rewrite::newInstance()->get_location() === 'contact') {
            return true;
        }

        return false;
    }

}

if (!function_exists('get_breadcrumb_lang')) {

    function get_breadcrumb_lang() {
        $lang = array();
        $lang['item_add'] = __('Publish a story', 'flatter');
        $lang['item_edit'] = __('Edit your story', 'flatter');
        $lang['item_send_friend'] = __('Send to a friend', 'flatter');
        $lang['item_contact'] = __('Contact publisher', 'flatter');
        $lang['search'] = __('Search results', 'flatter');
        $lang['search_pattern'] = __('Search results: %s', 'flatter');
        $lang['user_dashboard'] = __('Dashboard', 'flatter');
        $lang['user_dashboard_profile'] = __("%s's profile", 'flatter');
        $lang['user_account'] = __('Account', 'flatter');
        $lang['user_items'] = __('Stories', 'flatter');
        $lang['user_alerts'] = __('Alerts', 'flatter');
        $lang['user_profile'] = __('Update account', 'flatter');
        $lang['user_change_email'] = __('Change email', 'flatter');
        $lang['user_change_username'] = __('Change username', 'flatter');
        $lang['user_change_password'] = __('Change password', 'flatter');
        $lang['login'] = __('Login', 'flatter');
        $lang['login_recover'] = __('Recover password', 'flatter');
        $lang['login_forgot'] = __('Change password', 'flatter');
        $lang['register'] = __('Create a new account', 'flatter');
        $lang['contact'] = __('Contact', 'flatter');
        return $lang;
    }

}

if (!function_exists('user_dashboard_redirect')) {

    function user_dashboard_redirect() {
        $page = Params::getParam('page');
        $action = Params::getParam('action');
        if ($page == 'user' && $action == 'dashboard') {
            if (ob_get_length() > 0) {
                ob_end_flush();
            }
            header("Location: " . osc_user_profile_url(), TRUE, 301);
        }
    }

    osc_add_hook('init', 'user_dashboard_redirect');
}

if (!function_exists('get_user_menu')) {

    function get_user_menu() {
        $options = array();
        /* $options[] = array(
          'name' => __('Public Profile'),
          'url' => osc_user_public_profile_url(),
          'class' => 'opt_publicprofile'
          ); */
        $options[] = array(
            'name' => __('Account', 'flatter'),
            'url' => osc_user_profile_url(),
            'class' => 'opt_account'
        );
        $options[] = array(
            'name' => __('Listings', 'flatter'),
            'url' => osc_user_list_items_url(),
            'class' => 'opt_items'
        );
        $options[] = array(
            'name' => __('Alerts', 'flatter'),
            'url' => osc_user_alerts_url(),
            'class' => 'opt_alerts'
        );

        /* $options[] = array(
          'name'  => __('Change email', 'flatter'),
          'url'   => osc_change_user_email_url(),
          'class' => 'opt_change_email'
          );
          $options[] = array(
          'name'  => __('Change username', 'flatter'),
          'url'   => osc_change_user_username_url(),
          'class' => 'opt_change_username'
          );
          $options[] = array(
          'name'  => __('Change password', 'flatter'),
          'url'   => osc_change_user_password_url(),
          'class' => 'opt_change_password'
          ); */
        $options[] = array(
            'name' => __('Logout', 'flatter'),
            'url' => osc_user_logout_url(),
                //'class' => 'opt_delete_account'
        );

        return $options;
    }

}

if (!function_exists('user_info_js')) {

    function user_info_js() {
        $location = Rewrite::newInstance()->get_location();
        $section = Rewrite::newInstance()->get_section();

        if ($location === 'user' && in_array($section, array('dashboard', 'profile', 'alerts', 'change_email', 'change_username', 'change_password', 'items'))) {
            $user = User::newInstance()->findByPrimaryKey(Session::newInstance()->_get('userId'));
            View::newInstance()->_exportVariableToView('user', $user);
            ?>
            <script type="text/javascript">
                flatter.user = {};
                flatter.user.id = '<?php echo osc_user_id(); ?>';
                flatter.user.secret = '<?php echo osc_user_field("s_secret"); ?>';
            </script>
            <?php
        }
    }

    osc_add_hook('header', 'user_info_js');
}
if (!OC_ADMIN) {
    if (!function_exists('add_close_button_action')) {

        function add_close_button_action() {
            echo '<script type="text/javascript">';
            echo '$(".flashmessage .ico-close").click(function(){';
            echo '$(this).parent().hide();';
            echo '});';
            echo '</script>';
        }

        osc_add_hook('footer', 'add_close_button_action');
    }
}

function theme_flatter_actions_admin() {
//if(OC_ADMIN)
    switch (Params::getParam('action_specific')) {
        case('settings'):
            $googleCode = Params::getParam('google_analytics');
            $googleWebmaster = Params::getParam('google_webmaster');
            $contactEnable = Params::getParam('contact_enable');
            $subscribeShow = Params::getParam('subscribe_show');
            $geoAds = Params::getParam('geo_ads');
            $Anim = Params::getParam('anim');
            $usefulInfo = Params::getParam('usefulinfo_show');
            $popEnable = Params::getParam('pop_enable');
            $locationInput = Params::getParam('location_input');

            osc_set_preference('subscribe_show', ($subscribeShow ? '1' : '0'), 'flatter_theme');
            osc_set_preference('geo_ads', ($geoAds ? '1' : '0'), 'flatter_theme');
            osc_set_preference('anim', ($Anim ? '1' : '0'), 'flatter_theme');
            osc_set_preference('usefulinfo_show', ($usefulInfo ? '1' : '0'), 'flatter_theme');
            osc_set_preference('usefulinfo_msg', Params::getParam('usefulinfo_msg', false, false), 'flatter_theme');

            osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'flatter_theme');
            osc_set_preference('fpromo_text', Params::getParam('fpromo_text'), 'flatter_theme');
            osc_set_preference('premium_count', Params::getParam('premium_count'), 'flatter_theme');
            osc_set_preference('defaultShowAs@all', Params::getParam('defaultShowAs@all'), 'flatter_theme');
            osc_set_preference('defaultShowAs@search', Params::getParam('defaultShowAs@all'));
            osc_set_preference('defaultColor@all', Params::getParam('defaultColor@all'), 'flatter_theme');
            osc_set_preference('contact_enable', ($contactEnable ? '1' : '0'), 'flatter_theme');
            osc_set_preference('contact_address', Params::getParam('contact_address', false, false), 'flatter_theme');
            osc_set_preference('address_map', Params::getParam('address_map', false, false), 'flatter_theme');
            osc_set_preference('google_analytics', ($googleCode ? '1' : '0'), 'flatter_theme');
            osc_set_preference('g_analytics', Params::getParam('g_analytics'), 'flatter_theme');
            osc_set_preference('google_webmaster', ($googleWebmaster ? '1' : '0'), 'flatter_theme');
            osc_set_preference('g_webmaster', Params::getParam('g_webmaster'), 'flatter_theme');
            osc_set_preference('custom_css', Params::getParam('custom_css', false, false), 'flatter_theme');

            osc_set_preference('location_input', ($locationInput ? '1' : '0'), 'flatter_theme');
            osc_set_preference('pop_enable', ($popEnable ? '1' : '0'), 'flatter_theme');
            osc_set_preference('pop_heading', Params::getParam('pop_heading'), 'flatter_theme');
            osc_set_preference('landing_pop', Params::getParam('landing_pop', false, false), 'flatter_theme');

            osc_add_flash_ok_message(__('Theme settings updated correctly', 'flatter'), 'admin');
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/flatter/admin/settings.php'));
            break;
        case('page_settings'):

            osc_set_preference('terms_link', Params::getParam('terms_link'), 'flatter_theme');
            osc_set_preference('privacy_link', Params::getParam('privacy_link'), 'flatter_theme');
            osc_set_preference('facebook_page', Params::getParam('facebook_page'), 'flatter_theme');
            osc_set_preference('twitter_page', Params::getParam('twitter_page'), 'flatter_theme');
            osc_set_preference('gplus_page', Params::getParam('gplus_page'), 'flatter_theme');
            osc_set_preference('pinterest_page', Params::getParam('pinterest_page'), 'flatter_theme');

            osc_add_flash_ok_message(__('Page / Social links updated correctly', 'flatter'), 'admin');
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/flatter/admin/settings.php#page'));
            break;
        case('category_settings'):
            $i = 0;
            while (osc_has_categories()) {
                osc_set_preference('cat_icon_' . osc_category_id(), Params::getParam('cat_icon_' . osc_category_id()), 'flatter_theme');
                $i++;
            }

            osc_add_flash_ok_message(__('Category icons updated correctly', 'flatter'), 'admin');
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/flatter/admin/settings.php#category'));
            break;
        case('adsense_settings'):
            $adsenseEnable = Params::getParam('google_adsense');

            osc_set_preference('google_adsense', ($adsenseEnable ? '1' : '0'), 'flatter_theme');
            osc_set_preference('adsense_sidebar', Params::getParam('adsense_sidebar', false, false), 'flatter_theme');
            osc_set_preference('adsense_listing', Params::getParam('adsense_listing', false, false), 'flatter_theme');
            osc_set_preference('adsense_searchtop', Params::getParam('adsense_searchtop', false, false), 'flatter_theme');
            osc_set_preference('adsense_searchbottom', Params::getParam('adsense_searchbottom', false, false), 'flatter_theme');
            osc_set_preference('adsense_searchside', Params::getParam('adsense_searchside', false, false), 'flatter_theme');

            osc_add_flash_ok_message(__('Adsense settings updated correctly', 'flatter'), 'admin');
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/flatter/admin/settings.php#adsense'));
            break;
        case('footer_settings'):
            $facebookLink = Params::getParam('facebook_likebox');
            $footerLink = Params::getParam('footer_link');

            osc_set_preference('facebook_likebox', ($facebookLink ? '1' : '0'), 'flatter_theme');
            osc_set_preference('footer_link', ($footerLink ? '1' : '0'), 'flatter_theme');

            osc_set_preference('fcwidget_title', Params::getParam('fcwidget_title'), 'flatter_theme');
            osc_set_preference('fcwidget_content', Params::getParam('fcwidget_content', false, false), 'flatter_theme');

            osc_add_flash_ok_message(__('Widgets updated correctly', 'flatter'), 'admin');
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/flatter/admin/settings.php#footerwidget'));
            break;
        case('other_settings'):
            $position1 = Params::getParam('position1_enable');
            $position2 = Params::getParam('position2_enable');
            $position3 = Params::getParam('position3_enable');
            $position4 = Params::getParam('position4_enable');
            $position5 = Params::getParam('position5_enable');
            $position6 = Params::getParam('position6_enable');
            $position7 = Params::getParam('position7_enable');
            $position8 = Params::getParam('position8_enable');
            $position9 = Params::getParam('position9_enable');
            $position10 = Params::getParam('position10_enable');

            $positionhide1 = Params::getParam('position1_hide');
            $positionhide2 = Params::getParam('position2_hide');
            $positionhide3 = Params::getParam('position3_hide');
            $positionhide4 = Params::getParam('position4_hide');
            $positionhide5 = Params::getParam('position5_hide');
            $positionhide6 = Params::getParam('position6_hide');
            $positionhide7 = Params::getParam('position7_hide');
            $positionhide8 = Params::getParam('position8_hide');
            $positionhide9 = Params::getParam('position9_hide');
            $positionhide10 = Params::getParam('position10_hide');

            osc_set_preference('position1_enable', ($position1 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position2_enable', ($position2 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position3_enable', ($position3 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position4_enable', ($position4 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position5_enable', ($position5 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position6_enable', ($position6 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position7_enable', ($position7 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position8_enable', ($position8 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position9_enable', ($position9 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position10_enable', ($position10 ? '1' : '0'), 'flatter_theme');

            osc_set_preference('position1_hide', ($positionhide1 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position2_hide', ($positionhide2 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position3_hide', ($positionhide3 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position4_hide', ($positionhide4 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position5_hide', ($positionhide5 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position6_hide', ($positionhide6 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position7_hide', ($positionhide7 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position8_hide', ($positionhide8 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position9_hide', ($positionhide9 ? '1' : '0'), 'flatter_theme');
            osc_set_preference('position10_hide', ($positionhide10 ? '1' : '0'), 'flatter_theme');

            osc_set_preference('position1_content', Params::getParam('position1_content', false, false), 'flatter_theme');
            osc_set_preference('position2_content', Params::getParam('position2_content', false, false), 'flatter_theme');
            osc_set_preference('position3_content', Params::getParam('position3_content', false, false), 'flatter_theme');
            osc_set_preference('position4_content', Params::getParam('position4_content', false, false), 'flatter_theme');
            osc_set_preference('position5_content', Params::getParam('position5_content', false, false), 'flatter_theme');
            osc_set_preference('position6_content', Params::getParam('position6_content', false, false), 'flatter_theme');
            osc_set_preference('position7_content', Params::getParam('position7_content', false, false), 'flatter_theme');
            osc_set_preference('position8_content', Params::getParam('position8_content', false, false), 'flatter_theme');
            osc_set_preference('position9_content', Params::getParam('position9_content', false, false), 'flatter_theme');
            osc_set_preference('position10_content', Params::getParam('position10_content', false, false), 'flatter_theme');

            osc_add_flash_ok_message(__('Settings updated correctly', 'flatter'), 'admin');
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/flatter/admin/settings.php#others'));
            break;
        case('upload_logo'):
            $package = Params::getFiles('logo');
            if ($package['error'] == UPLOAD_ERR_OK) {
                $img = ImageResizer::fromFile($package['tmp_name']);
                $ext = $img->getExt();
                $logo_name = 'flatter_logo';
                $logo_name .= '.' . $ext;
                $path = osc_uploads_path() . $logo_name;
                $img->saveToFile($path);

                osc_set_preference('logo', $logo_name, 'flatter_theme');

                osc_add_flash_ok_message(__('The logo image has been uploaded correctly', 'flatter'), 'admin');
            } else {
                osc_add_flash_error_message(__("An error has occurred, please try again", 'flatter'), 'admin');
            }
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/flatter/admin/settings.php#logo'));
            break;
        case('remove'):
            $logo = osc_get_preference('logo', 'flatter_theme');
            $path = osc_uploads_path() . $logo;
            if (file_exists($path)) {
                @unlink($path);
                osc_delete_preference('logo', 'flatter_theme');
                osc_reset_preferences();
                osc_add_flash_ok_message(__('The logo image has been removed', 'flatter'), 'admin');
            } else {
                osc_add_flash_error_message(__("Image not found", 'flatter'), 'admin');
            }
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/flatter/admin/settings.php#logo'));
            break;
    }
}

function flatter_redirect_user_dashboard() {
    if ((Rewrite::newInstance()->get_location() === 'user') && (Rewrite::newInstance()->get_section() === 'dashboard')) {
        header('Location: ' . osc_user_profile_url());
        exit;
    }
}

function flatter_delete() {
    Preference::newInstance()->delete(array('s_section' => 'flatter'));
}

osc_add_hook('init', 'flatter_redirect_user_dashboard', 2);
osc_add_hook('init_admin', 'theme_flatter_actions_admin');
osc_add_hook('theme_delete_flatter', 'flatter_delete');
//osc_admin_menu_appearance(__('Header logo', 'flatter'), osc_admin_render_theme_url('oc-content/themes/flatter/admin/header.php'), 'header_flatter');
osc_admin_menu_appearance(__('Flatter Settings', 'flatter'), osc_admin_render_theme_url('oc-content/themes/flatter/admin/settings.php'), 'settings_flatter');
//osc_add_admin_menu_page( __('Flatter', 'flatter'), osc_admin_render_theme_url('oc-content/themes/flatter/admin/settings.php'), 'settings_flatter' );

/**

  TRIGGER FUNCTIONS

 */
check_install_flatter_theme();
/* if(osc_is_home_page()){
  osc_add_hook('inside-main','flatter_draw_categories_list');
  } else if( osc_is_static_page() || osc_is_contact_page() ){
  osc_add_hook('before-content','flatter_draw_categories_list');
  }

  if(osc_is_home_page() || osc_is_search_page()){
  flatter_add_body_class('has-searchbox');
  } */

function flatter_sidebar_category_search($catId = null) {
    $aCategories = array();
    if ($catId == null) {
        $aCategories[] = Category::newInstance()->findRootCategoriesEnabled();
    } else {
// if parent category, only show parent categories
        $aCategories = Category::newInstance()->toRootTree($catId);
        end($aCategories);
        $cat = current($aCategories);
// if is parent of some category
        $childCategories = Category::newInstance()->findSubcategoriesEnabled($cat['pk_i_id']);
        if (count($childCategories) > 0) {
            $aCategories[] = $childCategories;
        }
    }

    if (count($aCategories) == 0) {
        return "";
    }

    flatter_print_sidebar_category_search($aCategories, $catId);
}

function flatter_print_sidebar_category_search($aCategories, $current_category = null, $i = 0) {
    $class = '';
    if (!isset($aCategories[$i])) {
        return null;
    }

    if ($i === 0) {
        $class = 'class="category"';
    }

    $c = $aCategories[$i];
    $i++;
    if (!isset($c['pk_i_id'])) {
        echo '<ul ' . $class . '>';
        if ($i == 1) {
            echo '<li><a href="' . osc_esc_html(osc_update_search_url(array('sCategory' => null, 'iPage' => null))) . '">' . __('All categories', 'flatter') . "</a></li>";
        }
        foreach ($c as $key => $value) {
            ?>
            <li>
                <a id="cat_<?php echo osc_esc_html($value['pk_i_id']); ?>" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory' => $value['pk_i_id'], 'iPage' => null))); ?>">
                    <?php
                    if (isset($current_category) && $current_category == $value['pk_i_id']) {
                        echo '<strong>' . $value['s_name'] . '</strong>';
                    } else {
                        echo $value['s_name'];
                    }
                    ?>
                </a>

            </li>
            <?php
        }
        if ($i == 1) {
            echo "</ul>";
        } else {
            echo "</ul>";
        }
    } else {
        ?>
        <ul <?php echo $class; ?>>
            <?php if ($i == 1) { ?>
                <li><a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory' => null, 'iPage' => null))); ?>"><?php _e('All categories', 'flatter'); ?></a></li>
            <?php } ?>
            <li>
                <a id="cat_<?php echo osc_esc_html($c['pk_i_id']); ?>" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory' => $c['pk_i_id'], 'iPage' => null))); ?>">
                    <?php
                    if (isset($current_category) && $current_category == $c['pk_i_id']) {
                        echo '<strong>' . $c['s_name'] . '</strong>';
                    } else {
                        echo $c['s_name'];
                    }
                    ?>
                </a>
                <?php flatter_print_sidebar_category_search($aCategories, $current_category, $i); ?>
            </li>
            <?php if ($i == 1) { ?>
            <?php } ?>
        </ul>
        <?php
    }
}

/**

  CLASSES

 */
class flatterBodyClass {

    /**
     * Custom Class for add, remove or get body classes.
     *
     * @param string $instance used for singleton.
     * @param array $class.
     */
    private static $instance;
    private $class;

    private function __construct() {
        $this->class = array();
    }

    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function add($class) {
        $this->class[] = $class;
    }

    public function get() {
        return $this->class;
    }

}

/**
  HELPERS
 */
if (!function_exists('osc_uploads_url')) {

    function osc_uploads_url($item = '') {
        return osc_base_url() . 'oc-content/uploads/' . $item;
    }

}

/**
  PREMIUM CURRENCY by ERIC
 */
function osc_format_premium_price() {
    $price = osc_premium_field("i_price");
    if ($price == null)
        return osc_apply_filter('item_price_null', __('Check with seller'));
    if ($price == 0)
        return osc_apply_filter('item_price_zero', __('Free'));

    $price = $price / 1000000;

    $currencyFormat = osc_locale_currency_format();
    $currencyFormat = str_replace('{NUMBER}', number_format($price, osc_locale_num_dec(), osc_locale_dec_point(), osc_locale_thousands_sep()), $currencyFormat);
    $currencyFormat = str_replace('{CURRENCY}', osc_premium_currency_symbol(), $currencyFormat);
    return osc_apply_filter('item_price', $currencyFormat);
}

/**
  THEME VERSION
 * */
$info = WebThemes::newInstance()->loadThemeInfo(osc_theme());

osc_add_hook('user_register_completed', 'go_to_theme_select');

function go_to_theme_select($user) {
    if (isset($_REQUEST['s_birthday']) && !empty($_REQUEST['s_birthday'])):
        $conn = getConnection();
        $conn->osc_dbExec("UPDATE `%st_user` SET `s_birthday`= '%s',`s_gender`='%s' where `pk_i_id` = %s", DB_TABLE_PREFIX, $_REQUEST['s_birthday'], $_REQUEST['s_gender'], $user);
//UPDATE `oc_t_user` SET `s_birthday`= now(),`s_gender`= 'male' WHERE `pk_i_id` = 75        
    endif;
    Session::newInstance()->_set('user_id', $user);
    Session::newInstance()->_set('after_register', 'yes');
    osc_reset_static_pages();
    osc_get_static_page('interest');
    osc_redirect_to(osc_static_page_url());
}

osc_add_hook('after_login', 'user_login_redirect');

function user_login_redirect($user) {
    osc_redirect_to(osc_base_url());
}

function cust_admin_my_custom_items_column_header($table) {

    $table->addColumn('my_custom_items_column', '<span>' . __('My custom data name:' . '</span>', 'my_theme'));
}

function cust_admin_my_custom_items_column_data($row, $aRow) {

    $conn = getConnection();
    $item = $conn->osc_dbFetchResult("SELECT my_custom_db_field FROM my_custom_db_table WHERE fk_i_item_id = '%d'", $aRow['pk_i_id']);

    $row['my_custom_items_column'] = $item['my_custom_db_field'];
    return $row;
}

//osc_add_hook('admin_items_table', 'cust_admin_my_custom_items_column_header');
//osc_add_filter('items_processing_row', 'cust_admin_my_custom_items_column_data');
function get_user_data($user_id) {
    $db_prefix = DB_TABLE_PREFIX;
    $user_data = new DAO();
    $user_data->dao->select('user.pk_i_id as user_id, user.s_name as user_name, user.s_email, user.fk_i_city_id, user.s_city, user.s_region, user.fk_c_country_code, user.s_country, user.user_type, user.s_phone_mobile as phone_number, user.has_private_post, user.facebook as facebook, user.twitter as twitter, user.s_website as s_website, user.dt_reg_date as reg_date');
    $user_data->dao->select('user2.pk_i_id, user2.fk_i_user_id, user2.s_extension, user2.s_path');
    $user_data->dao->select('user_cover_picture.user_id AS cover_picture_user_id, user_cover_picture.pic_ext, user_cover_picture.cover_pic_ext');
    $user_data->dao->select('user_role.id as role_id, user_role.role_name');
    $user_data->dao->from("{$db_prefix}t_user user");
    $user_data->dao->join("{$db_prefix}t_user_resource user2", "user.pk_i_id = user2.fk_i_user_id", "LEFT");
    $user_data->dao->join("{$db_prefix}t_profile_picture user_cover_picture", "user.pk_i_id = user_cover_picture.user_id", "LEFT");
    $user_data->dao->join("{$db_prefix}t_user_roles user_role", "user.user_role = user_role.id", "LEFT");
    $user_data->dao->where("user.pk_i_id={$user_id}");
    $user_data->dao->limit(1);
    $result = $user_data->dao->get();
    $user = $result->row();
    return $user;
}

function item_resources_old($item_id) {
    $type = 'image';
    $item_podcast_data = new DAO();
    $item_podcast_data->dao->select(sprintf('%st_item_podcasts.*', DB_TABLE_PREFIX));
    $item_podcast_data->dao->from(sprintf('%st_item_podcasts', DB_TABLE_PREFIX));
    $item_podcast_data->dao->where(array('fk_i_item_id' => $item_id));
    $item_podcast_data->dao->limit(1);
    $item_podcast_result = $item_podcast_data->dao->get();
    $data = $item_podcast_result->result();
    $type = 'podcast';

    if (empty($data)):
        $item_video_data = new DAO();
        $item_video_data->dao->select(sprintf('%st_item_video_files.*', DB_TABLE_PREFIX));
        $item_video_data->dao->from(sprintf('%st_item_video_files', DB_TABLE_PREFIX));
        $item_video_data->dao->where(array('fk_i_item_id' => $item_id));
        $item_video_data->dao->limit(1);
        $item_video_result = $item_video_data->dao->get();
        $data = $item_video_result->result();
        $type = 'video';
    endif;

    if (empty($data)):
        $item_mp3_data = new DAO();
        $item_mp3_data->dao->select(sprintf('%st_item_mp3_files.*', DB_TABLE_PREFIX));
        $item_mp3_data->dao->from(sprintf('%st_item_mp3_files', DB_TABLE_PREFIX));
        $item_mp3_data->dao->where(array('fk_i_item_id' => $item_id));
        $item_mp3_data->dao->limit(1);
        $item_mp3_result = $item_mp3_data->dao->get();
        $data = $item_mp3_result->result();
        $type = 'mp3';
    endif;

    if (empty($data)):
        $item_image_data = new DAO();
        $item_image_data->dao->select(sprintf('%st_item_resource.*', DB_TABLE_PREFIX));
        $item_image_data->dao->from(sprintf('%st_item_resource', DB_TABLE_PREFIX));
        $item_image_data->dao->where(array('fk_i_item_id' => $item_id));
        $item_image_data->dao->limit(1);
        $item_image_result = $item_image_data->dao->get();
        $data = $item_image_result->result();
        $type = 'image';
    endif;


    switch ($type):

        case 'podcast':
            echo $data[0]['s_embed_code'];
            break;

        case 'video':
            ?>
            <video controls>
                <source src="<?php echo ITEM_VIDEO_FILE_URL . $data[0]['s_code'] . "_" . $data[0]['fk_i_item_id'] . "_" . $data[0]['s_name']; ?>" />
            </video>
            <?php
            break;

        case 'mp3':
            ?>
            <audio controls>
                <source src="<?php echo ITEM_MP3_FILE_URL . $data[0]['s_code'] . "_" . $data[0]['fk_i_item_id'] . "_" . $data[0]['s_name']; ?>" />
            </audio>
            <?php
            break;

        case 'image':
            if (empty($data)):
                $img_path = osc_current_web_theme_url('images/no-image.jpg');
            else:
                $img_path = osc_base_url() . $data[0]['s_path'] . $data[0]['pk_i_id'] . '_original.' . $data[0]['s_extension'];
            endif;
            ?>
            <img src="<?php echo $img_path ?>" class="img img-responsive pad">
            <?php
            break;

        default :
            break;
    endswitch;
}

function item_resources($item_id) {
    $db_prefix = DB_TABLE_PREFIX;
    $post_data = new DAO();
    $post_data->dao->select("item.*");
    $post_data->dao->from("{$db_prefix}t_item AS item");
    $post_data->dao->where("item.pk_i_id", $item_id);
    $post_data->dao->limit(1);
    $post_data_result = $post_data->dao->get();
    $post_data_array = $post_data_result->row();
    $type = $post_data_array['item_type'];

    $post_resource_data = new DAO();
    $post_resource_data->dao->select("item_resource.*");
    $post_resource_data->dao->from("{$db_prefix}t_item_resource AS item_resource");
    $post_resource_data->dao->where("item_resource.fk_i_item_id", $item_id);
    $post_resource_data->dao->limit(1);
    $post_resource_data_result = $post_resource_data->dao->get();
    $post_resource_array = $post_resource_data_result->row();
    switch ($type):

        case 'podcast':
            echo $post_resource_array['s_path'];
            break;

        case 'video':
            if (strpos($post_resource_array['s_path'], 'iframe') !== false):
                echo $post_resource_array['s_path'];
            else:
                preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $post_resource_array['s_path'], $matches);
                ?>
                <iframe src="<?php echo 'https://www.youtube.com/embed/' . $matches[0]; ?>" width="854" height="350" frameborder="0" allowfullscreen ></iframe>
            <?php
            endif;
            break;

        case 'music':
            if ($post_resource_array['s_extension'] == 'mp3'):
                ?>
                <audio controls class="audio">
                    <source src="<?php echo osc_base_url() . $post_resource_array['s_path'] . $post_resource_array['pk_i_id'] . '.' . $post_resource_array['s_extension'] ?>" />
                </audio>
                <?php
            else:
                ?>
                <video controls>
                    <source src="<?php echo osc_base_url() . $post_resource_array['s_path'] . $post_resource_array['pk_i_id'] . '.' . $post_resource_array['s_extension'] ?>" />
                </video>
            <?php
            endif;
            break;

        case 'image':
            if (empty($post_resource_array)):
                $img_path = osc_current_web_theme_url('images/no-image.jpg');
            else:
                $img_path = osc_base_url() . $post_resource_array['s_path'] . $post_resource_array['pk_i_id'] . '.' . $post_resource_array['s_extension'];
            endif;
            ?>
            <img src="<?php echo $img_path ?>" class="img img-responsive">
            <?php
            break;

        case 'gif':
            if (empty($post_resource_array)):
                $img_path = osc_current_web_theme_url('images/no-image.jpg');
            else:
                $img_path = osc_base_url() . $post_resource_array['s_path'] . $post_resource_array['pk_i_id'] . '.' . $post_resource_array['s_extension'];
            endif;
            ?>
            <img src="<?php echo $img_path ?>" class="img img-responsive">
            <?php
            break;

        default :
            break;
    endswitch;
}

function get_user_categories($user_id) {
    $category_array = array();
    $user_themes_data = new DAO();
    $user_themes_data->dao->select(sprintf('%st_user_themes.*', DB_TABLE_PREFIX));
    $user_themes_data->dao->from(sprintf('%st_user_themes', DB_TABLE_PREFIX));
    $user_themes_data->dao->where(array('user_id' => $user_id));
    $user_themes_result = $user_themes_data->dao->get();
    $user_themes = $user_themes_result->result();
    foreach ($user_themes as $theme):
        $category_array[] = $theme['theme_id'];
    endforeach;
    $user_rubrics_data = new DAO();
    $user_rubrics_data->dao->select(sprintf('%st_user_rubrics.*', DB_TABLE_PREFIX));
    $user_rubrics_data->dao->from(sprintf('%st_user_rubrics', DB_TABLE_PREFIX));
    $user_rubrics_data->dao->where(array('user_id' => $user_id));
    $user_rubrics_result = $user_rubrics_data->dao->get();
    $user_rubrics = $user_rubrics_result->result();
    foreach ($user_rubrics as $rubric):
        $category_array[] = $rubric['rubric_id'];
    endforeach;
    return $category_array;
}

function time_elapsed_string($ptime) {
    $etime = time() - $ptime;
    if ($etime < 1) {
        return '0 seconds';
    }

    $a = array(365 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    $a_plural = array('year' => 'years',
        'month' => 'months',
        'day' => 'days',
        'hour' => 'hours',
        'minute' => 'minutes',
        'second' => 'seconds'
    );
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            if ($secs < 86400) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            } else {
//                setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
                return date("d M", $ptime);
//               return strftime("%d %b", $ptime);
            }
        }
    }
}

function get_category_array($parent_category_id) {
    $category_array = array($parent_category_id);
    $category_data = new DAO();
    $category_data->dao->select(sprintf('%st_category.*', DB_TABLE_PREFIX));
    $category_data->dao->from(sprintf('%st_category', DB_TABLE_PREFIX));
    $category_data->dao->where('fk_i_parent_id', $parent_category_id);
    $result1 = $category_data->dao->get();
    $cat_data = $result1->result();
    foreach ($cat_data as $k => $cat):
        $category_array[] = $cat['pk_i_id'];
    endforeach;
    return $category_array;
}

function get_user_themes($user_id) {
    $user_theme_data = new DAO();
    $user_theme_data->dao->select(sprintf('%st_user_themes.*', DB_TABLE_PREFIX));
    $user_theme_data->dao->from(sprintf('%st_user_themes', DB_TABLE_PREFIX));
    $user_theme_data->dao->where('user_id', $user_id);
    $user_theme_result = $user_theme_data->dao->get();
    $user_theme_array = $user_theme_result->result();
    $theme_id_array = custom_array_column($user_theme_array, 'theme_id');
    return $theme_id_array;
}

function get_item_likes_count($item_id) {
    $item_like_data = new DAO();
    $item_like_data->dao->select(sprintf('%st_item_likes.*', DB_TABLE_PREFIX));
    $item_like_data->dao->from(sprintf('%st_item_likes', DB_TABLE_PREFIX));
    $item_like_data->dao->where('item_id', $item_id);
    $item_like_data->dao->where('like_value', '1');
    $item_like_result = $item_like_data->dao->get();
    $item_like_array = $item_like_result->result();
    return count($item_like_array);
}

function get_user_item_likes($user_id) {
    $user_like_data = new DAO();
    $user_like_data->dao->select(sprintf('%st_item_likes.*', DB_TABLE_PREFIX));
    $user_like_data->dao->from(sprintf('%st_item_likes', DB_TABLE_PREFIX));
    $user_like_data->dao->where('user_id', $user_id);
    $user_like_data->dao->where('like_value', '1');
    $user_like_result = $user_like_data->dao->get();
    $user_like_array = $user_like_result->result();
    if ($user_like_array):
        $item_result = custom_array_column($user_like_array, 'item_id');
    else:
        $item_result = false;
    endif;
    return $item_result;
}

function update_item_like($user_id, $item_id, $like_value) {

    $like_array['user_id'] = $user_id;
    $like_array['item_id'] = $item_id;
    $like_array['like_value'] = $like_value;

    $like_data = new DAO();
    $like_data->dao->select(sprintf('%st_item_likes.*', DB_TABLE_PREFIX));
    $like_data->dao->from(sprintf('%st_item_likes', DB_TABLE_PREFIX));
    $like_data->dao->where('user_id', $user_id);
    $like_data->dao->where('item_id', $item_id);
    $like_data->dao->limit(1);
    $like_data_result = $like_data->dao->get();
    $like_data_array = $like_data_result->result();
    if ($like_data_array):
        $like_reult = $like_data->dao->update(sprintf('%st_item_likes', DB_TABLE_PREFIX), $like_array, array('id' => $like_data_array[0]['id']));
    else:
        $like_reult = $like_data->dao->insert(sprintf('%st_item_likes', DB_TABLE_PREFIX), $like_array);
    endif;
//insert notification for author
//item detail
    $data = new DAO();
    $data->dao->select('item.*');
    $data->dao->from(sprintf('%st_item AS item', DB_TABLE_PREFIX));
    $data->dao->where('item.pk_i_id', $item_id);
    $result = $data->dao->get();
    $item = $result->row();
    if ($like_value == 1 && $user_id != $item['fk_i_user_id']):
        $message = 'liked your post';
        set_user_notification($user_id, $item['fk_i_user_id'], $message);
    endif;
    return $like_reult;
}

function item_like_box($user_id, $item_id) {

    $like = 'like';
    $like_text = 'Like';
    $like_class = '';
    $like_item_array = get_user_item_likes($user_id);
    if ($like_item_array && in_array($item_id, $like_item_array)):
        $like = 'unlike';
        $like_class = 'liked';
        $like_text = 'Unlike';
    endif;
    ?>
    <span class="like_box <?php echo $like_class ?> item_like_box<?php echo $item_id ?>" data_item_id = "<?php echo $item_id; ?>" data_user_id = "<?php echo $user_id; ?>" data_action = "<?php echo $like ?>">
        <?php
        $like_count = get_item_likes_count($item_id);
        if ($like_count > 0)
            echo $like_count;
        ?> &nbsp;
        <span class="item_like">
            <i class="fa fa-thumbs-o-up"></i>
        </span>&nbsp;
        <?php echo $like_text ?>
    </span>
    <?php
}

function get_item_comments($item_id) {
    $comments_data = new DAO();
    $comments_data->dao->select(sprintf('%st_item_comment.*', DB_TABLE_PREFIX));
    $comments_data->dao->from(sprintf('%st_item_comment', DB_TABLE_PREFIX));
    $conditions = array(
        'fk_i_item_id' => $item_id,
        'b_active' => 1,
        'b_enabled' => 1
    );
//    $comments_data->dao->limit(3);
    $comments_data->dao->where($conditions);
    $comments_data->dao->orderBy('dt_pub_date', 'ASC');
    $comments_result = $comments_data->dao->get();
    $comments = $comments_result->result();
    return $comments;
}

function get_country_array() {
    $item_like_data = new DAO();
    $item_like_data->dao->select(sprintf('%st_country.*', DB_TABLE_PREFIX));
    $item_like_data->dao->from(sprintf('%st_country', DB_TABLE_PREFIX));
    $item_like_result = $item_like_data->dao->get();
    $item_like_array = $item_like_result->result();
    return $item_like_array;
}

function get_user_following_data($user_id) {
    $user_like_data = new DAO();
    $user_like_data->dao->select(sprintf('%st_user_follow.*', DB_TABLE_PREFIX));
    $user_like_data->dao->from(sprintf('%st_user_follow', DB_TABLE_PREFIX));
    $user_like_data->dao->where('user_id', $user_id);
    $user_like_data->dao->where('follow_value', '1');
    $user_like_result = $user_like_data->dao->get();
    $user_like_array = $user_like_result->result();
    if ($user_like_array):
        $item_result = custom_array_column($user_like_array, 'follow_user_id');
    else:
        $item_result = false;
    endif;
    return $item_result;
}

function get_user_follower_data($user_id) {
    $user_like_data = new DAO();
    $user_like_data->dao->select(sprintf('%st_user_follow.*', DB_TABLE_PREFIX));
    $user_like_data->dao->from(sprintf('%st_user_follow', DB_TABLE_PREFIX));
    $user_like_data->dao->where('follow_user_id', $user_id);
    $user_like_data->dao->where('follow_value', '1');
    $user_like_result = $user_like_data->dao->get();
    $user_like_array = $user_like_result->result();
    if ($user_like_array):
        $item_result = custom_array_column($user_like_array, 'user_id');
    else:
        $item_result = false;
    endif;
    return $item_result;
}

function get_user_posts_count($user_id) {
    $user_posts_data = new DAO();
    $user_posts_data->dao->select(sprintf('%st_item.*', DB_TABLE_PREFIX));
    $user_posts_data->dao->from(sprintf('%st_item', DB_TABLE_PREFIX));
    $user_posts_data->dao->where('fk_i_user_id', $user_id);
    $user_posts_result = $user_posts_data->dao->get();
    $user_posts_array = $user_posts_result->result();
    return count($user_posts_array);
}

function user_follow_box($logged_in_user_id, $follow_user_id) {

    $following = 'following';
    $action = 'unfollow';
    $fa_class = 'fa fa-user-times';
    $follow_text = 'Unfollow';
    $user_following = get_user_following_data($logged_in_user_id);

    if (!($user_following && ( in_array($follow_user_id, $user_following)) )):
        $following = 'unfollowing';
        $action = 'follow';
        $fa_class = 'fa fa-user-plus';
        $follow_text = 'Follow';
    endif;
    ?>
    <span title="<?php echo $follow_text ?>" class="follow-user follow_box_<?php echo $logged_in_user_id . $follow_user_id ?> <?php echo $following ?>" data_action = "<?php echo $action ?>" data_current_user_id = "<?php echo $logged_in_user_id ?>" data_follow_user_id = "<?php echo $follow_user_id ?>">
        <i class="<?php echo $fa_class ?>"></i>     
    </span>
    <?php
}

function user_follow_btn_box($logged_in_user_id, $follow_user_id) {

    $following = 'following';
    $action = 'unfollow';
    $fa_class = 'fa fa-user-times';
    $follow_text = 'Unfollow';
    $user_following = get_user_following_data($logged_in_user_id);

    if (!($user_following && ( in_array($follow_user_id, $user_following)) )):
        $following = 'unfollowing';
        $action = 'follow';
        $fa_class = 'fa fa-user-plus';
        $follow_text = "Follow";
    endif;
    ?>   
    <button type="button" class="btn btn-box-tool frnd-sug-button pull-right follow-user-btn follow_btn_box_<?php echo $logged_in_user_id . $follow_user_id ?> <?php echo $following ?>" data_action = "<?php echo $action ?>" user-data=".user-<?php echo $follow_user_id ?>" data_current_user_id = "<?php echo $logged_in_user_id ?>" data_follow_user_id = "<?php echo $follow_user_id ?>" title="<?php echo $follow_text ?>"><?php echo $follow_text ?></button>                                                           
    <?php
}

function update_user_following($logged_in_user_id, $follow_user_id, $follow_value) {

    $follow_array['user_id'] = $logged_in_user_id;
    $follow_array['follow_user_id'] = $follow_user_id;
    $follow_array['follow_value'] = $follow_value;
    $user_follow_data = new DAO();
    $user_follow_data->dao->select(sprintf('%st_user_follow.*', DB_TABLE_PREFIX));
    $user_follow_data->dao->from(sprintf('%st_user_follow', DB_TABLE_PREFIX));
    $user_follow_data->dao->where('user_id', $logged_in_user_id);
    $user_follow_data->dao->where('follow_user_id', $follow_user_id);
    $user_follow_data->dao->limit(1);
    $user_follow_result = $user_follow_data->dao->get();
    $user_follow_array = $user_follow_result->result();

    if ($user_follow_array):
        $user_follow_data->dao->update(sprintf('%st_user_follow', DB_TABLE_PREFIX), $follow_array, array('id' => $user_follow_array[0]['id']));
    else:
        $user_follow_data->dao->insert(sprintf('%st_user_follow', DB_TABLE_PREFIX), $follow_array);
    endif;
    if ($follow_value == 1):
        $message = 'is now following you';
        set_user_notification($logged_in_user_id, $follow_user_id, $message);
    endif;
}

function get_user_shared_item($user_id) {
    $user_share_data = new DAO();
    $user_share_data->dao->select(sprintf('%st_user_share_item.*', DB_TABLE_PREFIX));
    $user_share_data->dao->from(sprintf('%st_user_share_item', DB_TABLE_PREFIX));
    $user_share_data->dao->where('user_id', $user_id);
    $user_share_data->dao->where('share_value', '1');
    $user_share_result = $user_share_data->dao->get();
    $user_share_array = $user_share_result->result();
    if ($user_share_array):
        $item_result = custom_array_column($user_share_array, 'item_id');
    else:
        $item_result = false;
    endif;
    return $item_result;
}

function get_item_shares_count($item_id) {
    $item_share_data = new DAO();
    $item_share_data->dao->select(sprintf('%st_user_share_item.*', DB_TABLE_PREFIX));
    $item_share_data->dao->from(sprintf('%st_user_share_item', DB_TABLE_PREFIX));
    $item_share_data->dao->where('item_id', $item_id);
    $item_share_data->dao->where('share_value', '1');
    $item_share_result = $item_share_data->dao->get();
    $item_share_array = $item_share_result->result();
    return count($item_share_array);
}

function user_share_box($user_id, $item_id) {

    $share_class = 'unshare';
    $action = 'unshare';
    $fa_class = 'fa fa-user-times';
    $share_text = 'Unshare';
    $user_share = get_user_shared_item($user_id);

    if (!($user_share && ( in_array($item_id, $user_share)) )):
        $share_class = 'share';
        $action = 'share';
        $fa_class = 'fa fa-user-plus';
        $share_text = 'Share';
    endif;
    ?>
    <span class="share_box <?php echo $share_class ?> item_share_box<?php echo $user_id . $item_id ?>" data_item_id = "<?php echo $item_id; ?>" data_user_id = "<?php echo $user_id; ?>" data_action = "<?php echo $action ?>">
        <?php
        $share_count = get_item_shares_count($item_id);
        if ($share_count > 0)
            echo $share_count;
        ?>
        &nbsp;
        <span class="item_share">
            <i class="fa fa-retweet"></i>
        </span>&nbsp;
        <?php echo $share_text ?>
    </span>
    <?php
}

function update_user_share_item($user_id, $item_id, $share_value) {

    $follow_array['user_id'] = $user_id;
    $follow_array['item_id'] = $item_id;
    $follow_array['share_value'] = $share_value;

    $user_follow_data = new DAO();
    $user_follow_data->dao->select(sprintf('%st_user_share_item.*', DB_TABLE_PREFIX));
    $user_follow_data->dao->from(sprintf('%st_user_share_item', DB_TABLE_PREFIX));
    $user_follow_data->dao->where('user_id', $user_id);
    $user_follow_data->dao->where('item_id', $item_id);
    $user_follow_data->dao->limit(1);
    $user_follow_result = $user_follow_data->dao->get();
    $user_follow_array = $user_follow_result->result();

    if ($user_follow_array):
        $user_follow_data->dao->update(sprintf('%st_user_share_item', DB_TABLE_PREFIX), $follow_array, array('id' => $user_follow_array[0]['id']));
    else:
        $user_follow_data->dao->insert(sprintf('%st_user_share_item', DB_TABLE_PREFIX), $follow_array);
    endif;
//insert notification for author
//item detail
    $data = new DAO();
    $data->dao->select('item.*');
    $data->dao->from(sprintf('%st_item AS item', DB_TABLE_PREFIX));
    $data->dao->where('item.pk_i_id', $item_id);
    $result = $data->dao->get();
    $item = $result->row();
    if ($share_value == 1 && $user_id != $item['fk_i_user_id']):
        $message = 'shared your post';
        set_user_notification($user_id, $item['fk_i_user_id'], $message);
    endif;
}

function get_user_watchlist_item($user_id) {
    $user_watchlist_data = new DAO();
    $item_result = false;
    $user_watchlist_data->dao->select(sprintf('%st_item_watchlist.*', DB_TABLE_PREFIX));
    $user_watchlist_data->dao->from(sprintf('%st_item_watchlist', DB_TABLE_PREFIX));
    $user_watchlist_data->dao->where('user_id', $user_id);
    $user_watchlist_data->dao->where('watchlist_value', '1');
    $user_watchlist_result = $user_watchlist_data->dao->get();
    if ($user_watchlist_result) {
        $user_watchlist_array = $user_watchlist_result->result();
        if ($user_watchlist_array):
            $item_result = custom_array_column($user_watchlist_array, 'item_id');
        endif;
    }
    return $item_result;
}

function user_watchlist_box($user_id, $item_id) {

    $watchlist_class = 'remove_from_watchlist';
    $action = 'remove_watchlist';
//$fa_class = 'fa fa-user-times';
    $watchlist_text = 'Remove from watchlist';
    $user_share = get_user_watchlist_item($user_id);

    if (!($user_share && ( in_array($item_id, $user_share)) )):
        $watchlist_class = 'add_watchlist';
        $action = 'add_watchlist';
//$fa_class = 'fa fa-user-plus';
        $watchlist_text = 'Add to watchlist';
    endif;
    ?>
    <span class="watch_box <?php echo $watchlist_class ?> item_watch_box<?php echo $user_id . $item_id ?>" data_item_id = "<?php echo $item_id; ?>" data_user_id = "<?php echo $user_id; ?>" data_action = "<?php echo $action ?>">
        <?php echo $watchlist_text ?>
    </span>
    <?php
}

function update_user_watchlist_item($user_id, $item_id, $watchlist_value) {
    $follow_array['user_id'] = $user_id;
    $follow_array['item_id'] = $item_id;
    $follow_array['watchlist_value'] = $watchlist_value;

    $user_watchlist_data = new DAO();
    $user_watchlist_data->dao->select(sprintf('%st_item_watchlist.*', DB_TABLE_PREFIX));
    $user_watchlist_data->dao->from(sprintf('%st_item_watchlist', DB_TABLE_PREFIX));
    $user_watchlist_data->dao->where('user_id', $user_id);
    $user_watchlist_data->dao->where('item_id', $item_id);
    $user_watchlist_data->dao->limit(1);
    $user_follow_result = $user_watchlist_data->dao->get();
    $user_follow_array = $user_follow_result->result();

    if ($user_follow_array):
        $user_watchlist_data->dao->update(sprintf('%st_item_watchlist', DB_TABLE_PREFIX), $follow_array, array('id' => $user_follow_array[0]['id']));
    else:
        $user_watchlist_data->dao->insert(sprintf('%st_item_watchlist', DB_TABLE_PREFIX), $follow_array);
    endif;
//insert notification for author
//item detail
    $data = new DAO();
    $data->dao->select('item.*');
    $data->dao->from(sprintf('%st_item AS item', DB_TABLE_PREFIX));
    $data->dao->where('item.pk_i_id', $item_id);
    $result = $data->dao->get();
    $item = $result->row();
    if ($watchlist_value == 1 && $user_id != $item['fk_i_user_id']):
        $message = 'added your post to his/her watchlist';
        set_user_notification($user_id, $item['fk_i_user_id'], $message);
    endif;
}

function get_item_watchlist_count($item_id) {
    $item_watchlist_data = new DAO();
    $item_watchlist_data->dao->select(sprintf('%st_item_watchlist.*', DB_TABLE_PREFIX));
    $item_watchlist_data->dao->from(sprintf('%st_item_watchlist', DB_TABLE_PREFIX));
    $item_watchlist_data->dao->where('item_id', $item_id);
    $item_watchlist_data->dao->where('watchlist_value', 1);
    $user_follow_result = $item_watchlist_data->dao->get();
    $user_follow_array = $user_follow_result->result();
    return count($user_follow_array);
}

function is_user_online($user_id) {
    $itemUserId = $user_id;
    $conn = getConnection();
    $userOnline = $conn->osc_dbFetchResult("SELECT * FROM %st_useronline WHERE userid = '%s'", DB_TABLE_PREFIX, $itemUserId);
    if ($userOnline != '') {
        if (osc_get_preference('useronline_set_text_image', 'useronline') == 'image') {
            echo '<img src="' . osc_base_url() . 'oc-content/plugins/useronline/images/online.png" />';
        } else {
            echo '<span style="color:#00CC00 !important; font-weight:bold">' . osc_get_preference('useronline_text', 'useronline') . '&nbsp;</span>';
        }
    } else {
        if (osc_get_preference('useronline_set_text_image', 'useronline') == 'image') {
            echo '<img src="' . osc_base_url() . 'oc-content/plugins/useronline/images/offline.png" />';
        } else {
            echo '<span style="color:#F00 !important; font-weight:bold">' . osc_get_preference('useroffline_text', 'useronline') . '&nbsp;</span>';
        }
    }
}

function get_comment_count($item_id) {
    $comments_data = new DAO();
    $comments_data->dao->select(sprintf('%st_item_comment.*', DB_TABLE_PREFIX));
    $comments_data->dao->from(sprintf('%st_item_comment', DB_TABLE_PREFIX));
    $conditions = array('fk_i_item_id' => osc_item_id(),
        'b_active' => 1,
        'b_enabled' => 1,
        'fk_i_item_id' => $item_id);

    $comments_data->dao->where($conditions);
    $comments_result = $comments_data->dao->get();
    $count = count($comments_result->result());
    return $count > 0 ? $count : '';
}

function get_user_last_post_resource($user_id) {
    $user_categories = get_user_categories($user_id);
    $user_last_post_data = new DAO();
    $user_last_post_data->dao->select(sprintf('%st_item.*', DB_TABLE_PREFIX));
    $user_last_post_data->dao->from(sprintf('%st_item', DB_TABLE_PREFIX));
    if ($user_categories):
        $user_last_post_data->dao->whereIn('fk_i_category_id', $user_categories);
    endif;
    $user_last_post_data->dao->orWhere('fk_i_user_id', $user_id);
    $user_last_post_data->dao->orderBy('dt_pub_date', 'DESC');
    $user_last_post_data->dao->limit(1);
    $user_last_post_array = $user_last_post_data->dao->get();
    $user_last_post_result = $user_last_post_array->result();
    if ($user_last_post_result):
        return item_resources($user_last_post_result[0]['pk_i_id']);
    else:
        return FALSE;
    endif;
}

function get_search_popup($search_newsfid, $item_search_array, $user_search_array) {
    ?>
    <!-- Modal content-->

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" style="right: 200px;top: 65px;position: absolute;background-color: grey;color: white;border-radius: 50%;width: 25px;padding-bottom: 3px; padding-left: 1px">&times;</button>
        <h5><b style="font-weight: 600;margin-left: 8px;">Search Newsfid</b></h5>
        <input type="text" class="search-modal-textbox search_newsfid_text" value="<?php echo $search_newsfid; ?>" placeholder="Start typing...">
    <!--        <h1><b style="font-size: 70px; font-weight: 700;"><?php echo $search_newsfid; ?></b></h1>-->
        <?php if (!$user_search_array): ?>
            <h5> Your Search did not return any results. Please try again. </h5>

        <?php endif; ?>
    </div>
    <div class="modal-body col-md-offset-2 ">
        <div class="col-md-12">
            <label  class="col-md-4  search-list">User</label>
            <label class="col-md-4 search-list">Publication</label>
        </div>
        <?php if ($user_search_array): ?>
            <div class="search-height col-md-12 padding-0">
                <div class="col-md-4">
                    <?php foreach ($user_search_array as $user) : ?>
                        <div class="col-md-12">
                            <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>" >
                                <?php echo $user['user_name']; ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-4">
                    <?php foreach ($item_search_array as $item) : ?>
                        <div class="col-md-12">
                            <a href="javascript:void(0)" class="item_title_head" data_item_id="<?php echo $item['pk_i_id'] ?>">
                                <?php echo $item['s_title']; ?>
                            </a>
                        </div>
                    <?php endforeach; ?> 
                </div>
            </div>   
        <?php endif; ?>
    </div>

    <?php
}

function get_suggested_users($user_id, $limit) {
    $user_categories = get_user_categories($user_id);
    if (!$user_categories):
        return FALSE;
    endif;
    $themes = implode(',', $user_categories);
    $db_prefix = DB_TABLE_PREFIX;

    $suggest_user_data = new DAO();
    $suggest_user_data->dao->select("user_themes.*");
    $suggest_user_data->dao->from("{$db_prefix}t_user_themes as user_themes");
    $suggest_user_data->dao->where("user_themes.theme_id IN ({$themes})");
    $suggest_user_data->dao->where("user_themes.user_id != {$user_id}");
    $suggest_user_data->dao->limit(4);
    $suggest_user_result = $suggest_user_data->dao->get();
    $suggest_user_array = $suggest_user_result->result();
    $theme_user_id = custom_array_column($suggest_user_array, 'user_id');
    $suggest_user_data->dao->select("user_rubrics.*");
    $suggest_user_data->dao->from("{$db_prefix}t_user_rubrics as user_rubrics");
    $suggest_user_data->dao->where("user_rubrics.rubric_id IN ({$themes})");
    $suggest_user_data->dao->where("user_rubrics.user_id != {$user_id}");
    $suggest_user_data->dao->limit($limit);
    $suggest_user_result = $suggest_user_data->dao->get();
    $suggest_user_array = $suggest_user_result->result();

    $rubric_user_id = custom_array_column($suggest_user_array, 'user_id');
    $users = array_merge($theme_user_id, $rubric_user_id);
    return array_slice(array_unique($users), 0, $limit);
}

function get_user_roles_array() {
    $db_prefix = DB_TABLE_PREFIX;
    $user_role_data = new DAO();
    $user_role_data->dao->select("user_roles.*");
    $user_role_data->dao->from("{$db_prefix}t_user_roles as user_roles");
//    $user_role_data->dao->orderBy("user_roles.role_name ASC");
    $user_role_data->dao->orderBy("user_roles.role_name_eng ASC");
    $user_role_result = $user_role_data->dao->get();
    $user_roles = $user_role_result->result();
    return $user_roles;
}

function get_user_profile_picture($user_id) {
    $user = get_user_data($user_id);
    if (!empty($user['s_path'])):
        $img_path = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
    else:
        $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
    endif;
    ?>
    <div class="user_profile_img">
        <img src="<?php echo $img_path ?>" alt="<?php echo $user['user_name'] ?>" class="img img-responsive img-circle">
        <?php
        if ($user['user_type'] == 1):
            $user_type_image_path = osc_current_web_theme_url() . 'images/Subscriber.png';
        endif;

        if ($user['user_type'] == 2):
            $user_type_image_path = osc_current_web_theme_url() . 'images/Certified.png';
        endif;

        if ($user['user_type'] == 3):
            $user_type_image_path = osc_current_web_theme_url() . 'images/Ciertified-subscriber.png';
        endif;
        ?>
        <?php if ($user['user_type'] != 0) : ?>
            <div class="user_type_icon_image">
                <img src="<?php echo $user_type_image_path ?>" alt="<?php echo $user['user_name'] ?>" class="img img-responsive img-circle">
            </div>
        <?php endif; ?>
    </div>
    <?php
}

function cust_admin_user_type_header($table) {
    $table->addColumn('user_type', '<span>Certify User</span>');
}

function cust_admin_user_type_data($row, $aRow) {
    if ($aRow['user_type'] == 2 || $aRow['user_type'] == 3):
        $checked = 'checked';
    else:
        $checked = '';
    endif;

    $user_subscribe_switch = '
                        <div class="user_type_switch">                            
                            <label class="switch">
                                <input type="checkbox" id="certified_box" name="certified_box" data_user_id="' . $aRow['pk_i_id'] . '" class="onoffswitch-checkbox certified_box"' . $checked . '>
                                <div class="slider round"></div>
                            </label>
                        </div>
                        ';

    $row['user_type'] = $user_subscribe_switch;
    return $row;
}

osc_add_hook('admin_users_table', 'cust_admin_user_type_header');
osc_add_filter("users_processing_row", "cust_admin_user_type_data");

osc_add_hook('admin_footer', 'admin_footer_script');

function admin_footer_script() {
    ?>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        .switch input {display:none;}
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }
        input:checked + .slider {
            background-color: #2196F3;
        }
        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }
        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }
        .slider.round {
            border-radius: 34px;
        }
        .slider.round:before {
            border-radius: 50%;
        }
    </style>

    <script>
        jQuery(document).ready(function ($) {
            $(document).on('change', '.certified_box', function () {
                var user_id = $(this).attr('data_user_id');
                console.log(user_id);
                var user_type_value = 0;
                if (this.checked) {
                    user_type_value = 1;
                }
                $.ajax({
                    url: '<?php echo osc_current_web_theme_url('user_info_ajax.php') ?>',
                    data: {
                        action: 'user_type_change',
                        user_id: user_id,
                        user_type_value: user_type_value
                    },
                    success: function (data, textStatus, jqXHR) {
                        console.log(data);
                        if (data == 1) {
                            console.log('user type updated successfully');
                        }
                        if (data == 0) {
                            console.log('user type not updated successfully');
                        }
                    }
                });
            });
        });
    </script>
    <?php
}

/*
  osc_current_web_theme_url(); // for gettiing path to current theme flatter

  osc_logged_user_id();

  $con =  Country::newInstance()-> // for accessing model

 */

/*
 * jaysukh
  client comments
 * Centre d’interet 
  - If user hasn’t selected center of interests choose these ones by default :

  Theme=  news + entertainment  /
  Rubrics = celebrity + news + international + entertainment

  Important because 80 users already have profiles created before re-built of the site si they will not have selected centers of interest, and we don’t want them to get a blank newsfeed on publication of the new site.
 * 
 *  */
// this code is not necessary once website live and old user update his interest
$user_id = osc_logged_user_id();
$interest_data = new DAO();
$interest_data->dao->select("theme.theme_id");
$interest_data->dao->from(DB_TABLE_PREFIX . 't_user_themes as theme');
$interest_data->dao->where("theme.user_id = $user_id");
$theme_list = $interest_data->dao->get();
$user_selected_themes = $theme_list->result();
if ($user_id != '0' && empty($user_selected_themes)):
    $conn = getConnection();
    $default_theme = array('1', '3'); // news, entertainment
    foreach ($default_theme as $k => $v):
        $conn->osc_dbExec("INSERT INTO %st_user_themes ( user_id, theme_id) VALUES (%s,'%s' )", DB_TABLE_PREFIX, $user_id, $v);
    endforeach;
    $conn->osc_dbExec("DELETE FROM `%st_user_rubrics` WHERE `user_id` = %s", DB_TABLE_PREFIX, $user_id);
    $default_rubrics = array('10', '13', '21', '117');
    foreach ($default_rubrics as $k => $v):
        $conn->osc_dbExec("INSERT INTO %st_user_rubrics ( user_id, rubric_id) VALUES (%s,'%s' )", DB_TABLE_PREFIX, $user_id, $v);
    endforeach;
endif;

function pr($arr = array()) {
    echo "<pre>";
    print_r($arr);
    die('die');
}

/*
  get user for chat
 * 
 * my subscriber + follower
 *  */

function get_chat_users($filter = 'all') {
    $user_id = osc_logged_user_id();
    $chat_user = array();
    if ($filter != 'circle') {
        $user_like_data = new DAO();
        $user_like_data->dao->select(sprintf('%st_user_follow.*', DB_TABLE_PREFIX));
        $user_like_data->dao->from(sprintf('%st_user_follow', DB_TABLE_PREFIX));
        $user_like_data->dao->where('(user_id =' . $user_id . ' OR follow_user_id =' . $user_id . ') AND follow_value=1');
//    $user_like_data->dao->where('follow_value', '1');
        $user_like_result = $user_like_data->dao->get();
        $user_like_array = $user_like_result->result();
        if ($user_like_array):
            $followed_user = custom_array_column($user_like_array, 'follow_user_id');
            $follow_user = custom_array_column($user_like_array, 'user_id');
        endif;
        $chat_user = array_unique(array_merge((array) $follow_user, (array) $followed_user)); // remove self user
        if (($key = array_search($user_id, $chat_user)) !== false) {
            unset($chat_user[$key]);
        }
    }
//get user from circle
    $user_circle_data = new DAO();
    $user_circle_data->dao->select(sprintf('%st_user_circle.circle_user_id', DB_TABLE_PREFIX));
    $user_circle_data->dao->from(sprintf('%st_user_circle', DB_TABLE_PREFIX));
    $user_circle_data->dao->where('user_id =' . $user_id);
    $user_circle_result = $user_circle_data->dao->get();
    $user_circle_array = $user_circle_result->result();
//    pr($user_circle_array);
    if ($user_circle_array):
        $circle_user = custom_array_column($user_circle_array, 'circle_user_id');
        $chat_user = array_unique(array_merge($chat_user, $circle_user));
    endif;

    if ($filter == 'all' && empty($chat_user)):
//get dummy users
        $user_circle_data->dao->select('user.pk_i_id as user_id');
        $user_circle_data->dao->from(DB_TABLE_PREFIX . "t_user user");
        $user_circle_data->dao->limit(10);
        $result = $user_circle_data->dao->get();
        $user_arr = $result->result();
        if ($user_arr):
            $circle_user = custom_array_column($user_arr, 'user_id');
            $chat_user = array_unique(array_merge($chat_user, $circle_user));
        endif;
    endif;

    $item_result = array();
    if (!empty($chat_user)):
        $item_result = get_users_data($chat_user);
    endif;
    return $item_result;
}

function get_users_data($users = array()) {
    $users = implode(",", $users);
    $db_prefix = DB_TABLE_PREFIX;
    $user_data = new DAO();
    $user_data->dao->select('user.pk_i_id as user_id, user.s_name as user_name, user.s_email, user.fk_i_city_id, user.s_city, user.s_region, user.fk_c_country_code, user.s_country, user.user_type, user.s_phone_mobile as phone_number, user.has_private_post, user.facebook as facebook, user.twitter as twitter, user.s_website as s_website');
    $user_data->dao->select('user2.pk_i_id, user2.fk_i_user_id, user2.s_extension, user2.s_path');
    $user_data->dao->select('user_cover_picture.user_id AS cover_picture_user_id, user_cover_picture.pic_ext');
    $user_data->dao->select('user_role.id as role_id, user_role.role_name');
    $user_data->dao->from("{$db_prefix}t_user user");
    $user_data->dao->join("{$db_prefix}t_user_resource user2", "user.pk_i_id = user2.fk_i_user_id", "LEFT");
    $user_data->dao->join("{$db_prefix}t_profile_picture user_cover_picture", "user.pk_i_id = user_cover_picture.user_id", "LEFT");
    $user_data->dao->join("{$db_prefix}t_user_roles user_role", "user.user_role = user_role.id", "LEFT");
    $user_data->dao->where("user.pk_i_id IN ({$users})");
    $result = $user_data->dao->get();
    $user = $result->result();
    return $user;
}

function add_user_circle($logged_in_user_id, $follow_user_id = NULL) {
    $follow_array['user_id'] = $logged_in_user_id;
    $follow_array['circle_user_id'] = $follow_user_id;
    $add_user_data = new DAO();
    if ($follow_user_id):
        $add_user_data->dao->insert(sprintf('%st_user_circle', DB_TABLE_PREFIX), $follow_array);
//insert notification for author    
        $message = 'added you to his/her circle';
        set_user_notification($logged_in_user_id, $follow_user_id, $message);

    endif;
}

function get_user_circle_data($user_id) {
    $user_circle_data = new DAO();
    $user_circle_data->dao->select(sprintf('%st_user_circle.*', DB_TABLE_PREFIX));
    $user_circle_data->dao->from(sprintf('%st_user_circle', DB_TABLE_PREFIX));
    $user_circle_data->dao->where('user_id', $user_id);
    $user_circle_result = $user_circle_data->dao->get();
    $user_circle_array = $user_circle_result->result();
    if ($user_circle_array):
        $item_result = custom_array_column($user_circle_array, 'circle_user_id');
    else:
        $item_result = false;
    endif;
    return $item_result;
}

function get_chat_message_data($user_id = null) {
    $user_message_data = new DAO();
    $user_message_data->dao->select('frei_chat.*');
    $user_message_data->dao->from('frei_chat');
    $user_message_data->dao->where('`from`', $user_id);
    $user_message_data->dao->orderBy("sent DESC");
    $user_message_data->dao->groupBy('`to`');
    $user_message_result = $user_message_data->dao->get();
    $user_messge_array = $user_message_result->result();
    return $user_messge_array;
}

function get_archives_message_data($user_id = null) {
    $user_message_data = new DAO();
    $user_message_data->dao->select('frei_chat_archives.*');
    $user_message_data->dao->from('frei_chat_archives');
    $user_message_data->dao->where('`from`', $user_id);
    $user_message_data->dao->orderBy("sent DESC");
    $user_message_data->dao->groupBy('`to`');
    $user_message_result = $user_message_data->dao->get();
    $user_messge_array = $user_message_result->result();
    return $user_messge_array;
}

function get_chat_conversion($user_id = null, $partner_user_id = null) {
    $user_conversion_data = new DAO();
    $user_conversion_data->dao->select('frei_chat.*');
    $user_conversion_data->dao->from('frei_chat');
    $user_conversion_data->dao->where('(`from` =' . $user_id . ' AND `to` =' . $partner_user_id . ') OR (`from` =' . $partner_user_id . ' AND `to` =' . $user_id . ')');
    $user_conversion_data->dao->orderBy("sent ASC");
    $user_conversion_result = $user_conversion_data->dao->get();
    $user_conversion_array = $user_conversion_result->result();
    return $user_conversion_array;
}

function get_archive_conversion($user_id = null, $partner_user_id = null) {
    $user_conversion_data = new DAO();
    $user_conversion_data->dao->select('frei_chat_archives.*');
    $user_conversion_data->dao->from('frei_chat_archives');
    $user_conversion_data->dao->where('(`from` =' . $user_id . ' AND `to` =' . $partner_user_id . ') OR (`from` =' . $partner_user_id . ' AND `to` =' . $user_id . ')');
    $user_conversion_data->dao->orderBy("sent ASC");
    $user_conversion_result = $user_conversion_data->dao->get();
    $user_conversion_array = $user_conversion_result->result();
    return $user_conversion_array;
}

function delete_chat_conversion($user_id = null, $partner_user_id = null) {
    $user_conversion_data = new DAO();
    $user_conversion_data->dao->delete('frei_chat', '(`from` =' . $user_id . ' AND `to` =' . $partner_user_id . ') OR (`from` =' . $partner_user_id . ' AND `to` =' . $user_id . ')');
    $user_conversion_result = $user_conversion_data->dao->get();
    return 1;
}

function get_pending_msg_cnt() {
    $user_id = osc_logged_user_id();
    $user_message_datacnt = new DAO();
    $user_message_datacnt->dao->select('COUNT(*) as msg');
    $user_message_datacnt->dao->from('frei_chat');
    $user_message_datacnt->dao->where('`to`', $user_id);
    $user_message_datacnt->dao->where('read_status', 0);
    $user_message_resultcnt = $user_message_datacnt->dao->get();
    $user_messge_cnt = $user_message_resultcnt->row();
    return $user_messge_cnt['msg'];
}

function get_pending_notification_cnt() {
    $user_id = osc_logged_user_id();
    $user_message_datacnt = new DAO();
    $user_message_datacnt->dao->select('COUNT(*) as msg');
    $user_message_datacnt->dao->from(sprintf('%st_user_notifications', DB_TABLE_PREFIX));
    $user_message_datacnt->dao->where('to_user_id', $user_id);
    $user_message_datacnt->dao->where('read_status', 0);
    $user_message_resultcnt = $user_message_datacnt->dao->get();
    $user_messge_cnt = $user_message_resultcnt->row();
    return $user_messge_cnt['msg'];
}

function custom_array_column($input = array(), $columnKey = null) {
    $resultArray = array();
    foreach ($input as $k => $v):
        $resultArray[$k] = $v[$columnKey];
    endforeach;
    return $resultArray;
}

function get_block_user_data() {
    $user_id = osc_logged_user_id();
    $db_prefix = DB_TABLE_PREFIX;
    $block_user_data = new DAO();
    $block_user_data->dao->select("block.*");
    $block_user_data->dao->from("{$db_prefix}t_user_access as block");
    $block_user_data->dao->where('user_id', $user_id);
    $block_user = $block_user_data->dao->get();
    $block = $block_user->result();
    return $block;
}

function set_user_notification($from_user_id = null, $to_user_id = null, $message = null) {
    if ($from_user_id):
        $created = date('Y-m-d H:i:s');
        $conn = getConnection();
        $conn->osc_dbExec("INSERT INTO %st_user_notifications (from_user_id, to_user_id, message, created) VALUES (%s, %s, '%s','%s')", DB_TABLE_PREFIX, $from_user_id, $to_user_id, $message, $created);
        return 1;
    endif;
}

function get_item_details($item_id = null) {
    $db_prefix = DB_TABLE_PREFIX;
    $post_data = new DAO();
    $post_data->dao->select("item.*");
    $post_data->dao->from("{$db_prefix}t_item_description AS item");
    $post_data->dao->where("item.fk_i_item_id", $item_id);
    $post_data_result = $post_data->dao->get();
    $post_desc = $post_data_result->result();
    return $post_desc;
}

function get_user_notification() {
    $user_id = osc_logged_user_id();
    if ($user_id):
        $db_prefix = DB_TABLE_PREFIX;
        $notification_data = new DAO();
        $notification_data->dao->select("noti.*");
        $notification_data->dao->from("{$db_prefix}t_user_notifications as noti");
        $notification_data->dao->where('to_user_id', $user_id);
        $notification_data->dao->orderBy('created DESC');
        $notifications = $notification_data->dao->get();
        $notifications = $notifications->result();
        if (!empty($notifications)):
            foreach ($notifications as $k => $n):
                $user = get_user_data($n['from_user_id']);
                $notifications[$k]['user_name'] = $user['user_name'];
                ;
                if (!empty($user['s_path'])):
                    $notifications[$k]['user_image'] = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
                    ;
                else:
                    $notifications[$k]['user_image'] = osc_current_web_theme_url() . '/images/user-default.jpg';
                endif;
            endforeach;
        endif;
        return $notifications;
    endif;
}

function get_item_premium() {
    $item = new DAO();
    $db_prefix = DB_TABLE_PREFIX;
    $item->dao->select("item.item_id");
    $item->dao->from("{$db_prefix}t_premium_items AS item");
    $item->dao->where('start_date <= NOW() AND end_date >= NOW()');
    $result = $item->dao->get();
    $item_data = $result->result();
    $item_array = array();
    if (!empty($item_data)):
        foreach ($item_data as $v):
            $item_array[] = $v['item_id'];
        endforeach;
    endif;
    return array_unique($item_array);
}

$page = Params::getParam('page');
$action = Params::getParam('action');
if ($page == 'user' && $action == 'profile') {
    if (ob_get_length() > 0) {
        ob_end_flush();
    }
    header("Location: " . osc_base_url());
}

//for paypal payment
//NOTIFY URL WILL LOOK LIKE http://www.newsfid.http5000.com/index.php?page=custom&route=paypal-notify&extra=NzlbEF8NMCr1Pjs3SKw+Pol3txeWLTifhfq0gAd18nU=
$page = Params::getParam('page');
$p_route = Params::getParam('route');
//if ($page == 'custom' && $p_route == 'payment-pro-done') {
if ($page == 'custom' && $p_route == 'paypal-notify') {    
    $transaction_array['dt_date'] = date("Y-m-d H:i:s");
    $transaction_array['s_code'] = ' ';
    $transaction_array['i_amount'] = 4.99;
    $transaction_array['s_currency_code'] = 'USD';
    $transaction_array['s_email'] = @$_GET['user_email'];
    $transaction_array['fk_i_user_id'] = @$_GET['user_id'];
    $transaction_array['s_source'] = 'PAYPAL';
    $transaction_array['i_status'] = '1';
    $transaction_array['debug_code'] = "<pre>".print_r($_POST)."<pre>";

    $db_prefix = DB_TABLE_PREFIX;
    $transaction_data = new DAO();
    $transaction_data->dao->insert("{$db_prefix}t_payment_pro_invoice", $transaction_array);

    $user_data = new DAO();
    $user_data->dao->update("{$db_prefix}t_user", array('user_type' => '1', 'valid_date' => date('d/m/Y', strtotime("+1 months", strtotime("NOW")))), array('pk_i_id' => @$_GET['user_id']));
}

function custom_echo($x, $length) {
    if (strlen($x) <= $length) {
        echo $x;
    } else {
        $y = substr($x, 0, $length) . '...';
        echo $y;
    }
}
?>
