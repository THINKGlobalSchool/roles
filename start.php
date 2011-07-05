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
		
	// Add submenus
	elgg_register_event_handler('pagesetup', 'system', 'roles_submenus');
	
	// Page handler
	elgg_register_page_handler('roles','roles_page_handler');
					
	// Register URL handler
	elgg_register_entity_url_handler('object', 'role', 'role_url');		
	
	// Role entity menu hook
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'roles_setup_entity_menu', 999);	
	
	// Register a handler for creating roles
	elgg_register_event_handler('create', 'object', 'roles_create_event_listener');

	// Register a handler for deleting todos
	elgg_register_event_handler('delete', 'object', 'roles_delete_event_listener');

	// Register a handler for assigning users to roles
	elgg_register_event_handler('add','role','roles_add_user_event_listener');
	
	// Register a handler for removing assignees from roles
	elgg_register_event_handler('remove','role','roles_remove_user_event_listener');	
	
	// Plugin hook for write access
	elgg_register_plugin_hook_handler('access:collections:write', 'all', 'roles_write_acl_plugin_hook');
					
	// Register actions
	$action_base = elgg_get_plugins_path() . 'roles/actions/roles';
	elgg_register_action('roles/edit', "$action_base/edit.php", 'admin');
	elgg_register_action('roles/delete', "$action_base/delete.php", 'admin');
	elgg_register_action('roles/removeuser', "$action_base/removeuser.php", 'admin');
	elgg_register_action('roles/adduser', "$action_base/adduser.php", 'admin');
	
	// Register one once for subtype
	run_function_once("roles_run_once");

	return true;
}

/**
 * Roles page handler
 * @param array $page
 * @return NULL
 */
function roles_page_handler($page) {
	switch ($page[0]) {
		case 'loadusers':
			$guid = sanitise_string(get_input('guid'));
			echo elgg_view('roles/users', array('guid' => $guid));
			break;
		default: 
			break;
	}	
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

/**
 * Role created, so add users to access lists.
 */
function roles_create_event_listener($event, $object_type, $object) {
	if (elgg_instanceof($object, 'object', 'role')) {
		$role_acl = create_access_collection(elgg_echo('roles:role') . ": " . $object->title, $object->getGUID());
		if ($role_acl) {
			$object->member_acl = $role_acl;
			elgg_set_context('role_acl');
			add_user_to_access_collection($object->owner_guid, $role_acl);
			elgg_set_context($context);
			//error_log("role-debug: Create Event Fired | Created ID: $role_acl");
			//error_log("role-debug: Members: " . count(get_members_of_access_collection($role_acl)));
		} else {
			return FALSE;
		}
	}
	return TRUE;
}

/**
 * Role deleted, so remove access lists.
 */
function roles_delete_event_listener($event, $object_type, $object) {
	if (elgg_instanceof($object, 'object', 'role')) {
		$context = elgg_get_context();
		elgg_set_context('role_acl');
		//error_log("role-debug: Delete Event Fired | ID: {$object->member_acl}");
		//error_log("role-debug: Members Before: " . count(get_members_of_access_collection($object->member_acl)));
		delete_access_collection($object->member_acl);
		//error_log("role-debug: Delete Event | Deleted: {$object->member_acl}");
		//error_log("role-debug: Members After: " . count(get_members_of_access_collection($object->member_acl)));
		elgg_set_context($context);
	}
	return TRUE;
}

/**
 * Listens to a role add event and adds a user to the roles's ACL
 *
 */
function roles_add_user_event_listener($event, $object_type, $object) {
	$role = $object['role'];
	$user = $object['user'];
	$acl = $role->member_acl;
	$context = elgg_get_context();
	elgg_set_context('role_acl');
	$result = add_user_to_access_collection($user->getGUID(), $acl);
	//error_log("role-debug: Add Event Fired | Member Adding: {$user->guid} | Members: " . count(get_members_of_access_collection($acl)));
	elgg_set_context($context);		
	return TRUE;	
}

/**
 * Listens to a role remove event and removes a user from the todo's access control
 *
 */
function roles_remove_user_event_listener($event, $object_type, $object) {
	$role = $object['role'];
	$user = $object['user'];
	$acl = $role->member_acl;

	$context = elgg_get_context();
	elgg_set_context('role_acl');
	remove_user_from_access_collection($user->getGUID(), $acl);
	//error_log("role-debug: Remove Event Fired | Member Removing: {$user->guid} | Members: " . count(get_members_of_access_collection($acl)));
	elgg_set_context($context);	
	return TRUE;
}

/**
 * Return the write access for the current role if the user has write access to it.
 */
function roles_write_acl_plugin_hook($hook, $entity_type, $returnvalue, $params) {
	if (elgg_in_context('role_acl')) {
		// get all roles if logged in
		if ($loggedin = elgg_get_logged_in_user_entity()) {
			$roles = elgg_get_entities(array('types' => 'object', 'subtypes' => 'role'));
			if (is_array($roles)) {
				foreach ($roles as $role) {
					$returnvalue[$role->member_acl] = elgg_echo('roles:role') . ': ' . $roles->title;
				}
			}
		}
	}
	return $returnvalue;
}

/**
 * Register entity type objects, subtype role as
 * ElggRole.
 *
 * @return void
 */
function roles_run_once() {
	// Register a class
	add_subtype("object", "role", "ElggRole");
}