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
 * @TODO 
 * - Determin permissions, ie: is it terrible if users can see whos in a role?
 */

elgg_register_event_handler('init', 'system', 'roles_init');

function roles_init() {	
	
	// Register and load library
	elgg_register_library('roles', elgg_get_plugins_path() . 'roles/lib/roles.php');
	elgg_load_library('roles');
	
	// Register class
	elgg_register_class('ElggRole', elgg_get_plugins_path() . 'roles/lib/classes/ElggRole.php');
	
	// Define role relationship constant
	define('ROLE_RELATIONSHIP', 'member_of_role');
		
	// Register CSS
	$r_css = elgg_get_simplecache_url('css', 'roles/css');
	elgg_register_css('elgg.roles', $r_css);
		
	// Register JS library
	$r_js = elgg_get_simplecache_url('js', 'roles/roles');
	elgg_register_js('elgg.roles', $r_js);
	
	// Load CSS/JSS @todo elsewhere?
	elgg_load_js('elgg.roles');
	
	// Add submenus
	elgg_register_event_handler('pagesetup', 'system', 'roles_submenus');
	
	// Page handler
	elgg_register_page_handler('roles','roles_page_handler');
					
	// Register URL handler
	elgg_register_entity_url_handler('object', 'role', 'role_url');		
	
	// Role entity menu hook
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'roles_setup_entity_menu', 999);		
					
	// Register actions
	$action_base = elgg_get_plugins_path() . 'roles/actions/roles';
	elgg_register_action('roles/edit', "$action_base/edit.php");
	elgg_register_action('roles/delete', "$action_base/delete.php");

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
 * Populates the ->getUrl() method for role entities
 *
 * @param ElggRole entity
 * @return string request url
 */
function role_url($entity) {
	return elgg_get_site_url() . 'admin/users/viewrole?guid=' . $entity->guid;
}

/**
 * Setup Roles Submenus
 */
function roles_submenus() {
	if (elgg_in_context('admin')) {
		elgg_register_admin_menu_item('administer', 'roles', 'users');
	}
}

/**
 * Roles entity plugin hook
 */
function roles_setup_entity_menu($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	
	if (!elgg_instanceof($entity, 'object', 'role')) {
		return $return;
	}

	$return = array();

	$options = array(
		'name' => 'edit',
		'text' => elgg_echo('edit'),
		'href' => elgg_get_site_url() . 'admin/users/editrole?guid=' . $entity->guid,
		'priority' => 2,
	);
	$return[] = ElggMenuItem::factory($options);
	
	$options = array(
		'name' => 'delete',
		'text' => elgg_view_icon('delete'),
		'title' => elgg_echo('delete:this'),
		'href' => "action/{$params['handler']}/delete?guid={$entity->getGUID()}",
		'confirm' => elgg_echo('deleteconfirm'),
		'priority' => 3,
	);

	$return[] = ElggMenuItem::factory($options);

	return $return;
}