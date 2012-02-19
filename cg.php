<?php
/*
Plugin Name: CityGrid
Plugin URI: 
Description: CityGrid Hyp3rL0cal Directoy
Version: 0.1.1.1
Author: Kin Lane kinlane@gmail.com
Author URI: http://developer.citygridmedia.com
License: GPL2
*/
?><?php

// some definition we will use
define( 'CG_PUGIN_NAME', 'CityGrid');
define( 'CG_PLUGIN_DIRECTORY', 'citygrid');
define( 'CG_CURRENT_VERSION', '0.1.1.1' );
define( 'CG_CURRENT_BUILD', '3' );
define( 'CG_LOGPATH', str_replace('\\', '/', WP_CONTENT_DIR).'/cg-logs/');
define( 'CG_DEBUG', false);

// i18n plugin domain for language files
define( 'EMU2_I18N_DOMAIN', 'cg' );

// how to handle log files, don't load them if you don't log
require_once('cg_logfilehandling.php');

// load language files
function cg_set_lang_file() {
	# set the language file
	$currentLocale = get_locale();
	if(!empty($currentLocale)) {
		$moFile = dirname(__FILE__) . "/lang/" . $currentLocale . ".mo";
		if (@file_exists($moFile) && is_readable($moFile)) {
			load_textdomain(EMU2_I18N_DOMAIN, $moFile);
		}

	}
}
cg_set_lang_file();

// create custom plugin settings menu
add_action( 'admin_menu', 'cg_create_menu' );

//call register settings function
add_action( 'admin_init', 'cg_register_settings' );
add_action('wp_enqueue_scripts', 'cg_scripts_method');

register_activation_hook(__FILE__, 'cg_activate');
register_deactivation_hook(__FILE__, 'cg_deactivate');
register_uninstall_hook(__FILE__, 'cg_uninstall');

function cg_scripts_method() {
    wp_deregister_script( 'citygrid' );
    wp_register_script( 'citygrid', 'http://static.citygridmedia.com/ads/scripts/v2/loader.js');
    wp_enqueue_script( 'citygrid' );
}    

// activating the default values
function cg_activate() {
	add_option('cg_option_3', 'any_value');
}

// deactivating
function cg_deactivate() {
	// needed for proper deletion of every option
	delete_option('cg_option_3');
}

// uninstalling
function cg_uninstall() {
	# delete all data stored
	delete_option('cg_option_3');
	// delete log files and folder only if needed
	if (function_exists('cg_deleteLogFolder')) cg_deleteLogFolder();
}

function cg_create_menu() {

	// create new top-level menu
	add_menu_page( 
	__('CityGrid', EMU2_I18N_DOMAIN),
	__('CityGrid', EMU2_I18N_DOMAIN),
	0,
	CG_PLUGIN_DIRECTORY.'/cg_main_page.php',
	'',
	plugins_url('/images/icon.png', __FILE__));
	
	
	add_submenu_page( 
	CG_PLUGIN_DIRECTORY.'/cg_main_page.php',
	__("Main", EMU2_I18N_DOMAIN),
	__("Main", EMU2_I18N_DOMAIN),
	0,
	CG_PLUGIN_DIRECTORY.'/cg_main_page.php'
	);	
	
	add_submenu_page( 
	CG_PLUGIN_DIRECTORY.'/cg_main_page.php',
	__("Settings", EMU2_I18N_DOMAIN),
	__("Settings", EMU2_I18N_DOMAIN),
	0,
	CG_PLUGIN_DIRECTORY.'/cg_settings_page.php'
	);	

	
	
	$the_page_title = "Hyp3rL0cal";
	$the_page_body = "<p>Welcome to the CityGrid Hyp3rL0cal Directory</p>";
	
	$the_page = get_page_by_title( $the_page_title );
	
	if ( ! $the_page ) {
	
	    $_p = array();
	    $_p['post_title'] = $the_page_title;
	    $_p['post_content'] = '';
	    $_p['post_status'] = 'publish';
	    $_p['post_type'] = 'page';
	    $_p['comment_status'] = 'closed';
	
	    // Insert the post into the database
	    $the_page_id = wp_insert_post( $_p );
	    
	    update_post_meta( $the_page_id, '_wp_page_template', 'cg-search.php' );
	
	}
	else {

	    $the_page_id = $the_page->ID;
	
	    $the_page->post_status = 'publish';
	    $the_page_id = wp_update_post( $the_page );
	    
	    update_post_meta( $the_page_id, '_wp_page_template', 'cg-search.php' );
	
	}	
	
}

// Filter page template
add_filter('page_template', 'catch_plugin_template');

// Page template filter callback
function catch_plugin_template($template) {
	
    // If tp-file.php is the set template
    if( is_page_template('cg-search.php') )
    
        // Update path(must be path, use WP_PLUGIN_DIR and not WP_PLUGIN_URL) 
        $template = WP_PLUGIN_DIR . '/citygrid/cg-search.php';
    // Return
    return $template;
}


function cg_register_settings() {
	//register settings
	register_setting( 'cg-settings-group', 'what' );
	register_setting( 'cg-settings-group', 'where' );
	register_setting( 'cg-settings-group', 'publishercode' );
}

// check if debug is activated
function cg_debug() {
	# only run debug on localhost
	if ($_SERVER["HTTP_HOST"]=="localhost" && defined('EPS_DEBUG') && EPS_DEBUG==true) return true;
}
?>
