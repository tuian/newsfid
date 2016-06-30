<?php
/*
Plugin Name: Ajax search
Plugin URI: http://www.osclass.org/
Description: Plugin allow to search without page reload
Version: 1.0.1
Author: poh
Author URI: http://www.osclass.org/
*/

	function ajax_search_header(){
		echo '<script src="'.osc_base_url() . 'oc-content/plugins/ajax_search/ajax_search.js" type="text/javascript"></script>';
		echo '<link rel="stylesheet" type="text/css" href="'.osc_base_url() . 'oc-content/plugins/ajax_search/ajax_search.css" />';
	}
	
    osc_add_hook('search_form', 'ajax_search_header') ;

?>
