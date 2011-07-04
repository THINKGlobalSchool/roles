<?php
/**
 * TGS Roles
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

elgg_register_event_handler('init', 'system', 'roles_init');

function roles_init() {	
	
	// Register and load library
	elgg_register_library('roles', elgg_get_plugins_path() . 'roles/lib/roles.php');
	elgg_load_library('roles');
		
	// Register CSS
	$r_css = elgg_get_simplecache_url('css', 'roles/css');
	elgg_register_css('elgg.roles', $r_css);
		
	// Register JS library
	$r_js = elgg_get_simplecache_url('js', 'roles/roles');
	elgg_register_js('elgg.roles', $r_js);
	
	// Load CSS/JSS @todo elsewhere?
	elgg_load_css('elgg.roles');
	elgg_load_js('elgg.roles');
	
	// Add submenus
	elgg_register_event_handler('pagesetup', 'system', 'roles_submenus');
	
	// Page handler
	elgg_register_page_handler('roles','roles_page_handler');
					
	// Register actions
	$action_base = elgg_get_plugins_path() . 'roles/actions/roles';
	//elgg_register_action('roles/save', "$action_base/save.php");

	return true;
}

/**
 * Roles page handler
 * @param array $page
 * @return NULL
 */
function roles_page_handler($page) {
	return;
}


/**
 * Setup Roles Submenus
 */
function roles_submenus() {
	if (elgg_in_context('admin')) {
		//elgg_register_admin_menu_item('administer', 'roles');
		//elgg_register_admin_menu_item('administer', 'xyz', 'roles');
	}
}