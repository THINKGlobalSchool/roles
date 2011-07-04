<?php
/**
 * TGS Roles Helper Lib
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

/** CONTENT **/

/** Get roles edit/add form **/
function roles_get_edit_content($type, $guid = NULL) {	
	elgg_push_breadcrumb(elgg_echo('admin:users:roles'), elgg_get_site_url() . 'admin/users/roles');
	if ($type == 'edit') {
		$role = get_entity($guid);
		elgg_push_breadcrumb($role->title, $role->getURL());
		elgg_push_breadcrumb(elgg_echo('edit'));
		if (!elgg_instanceof($role, 'object', 'role')) {
			forward(REFERER);
		}
	} else {
		elgg_push_breadcrumb(elgg_echo('Add'));
		$role = null;
	}
	
	$form_vars = roles_prepare_form_vars($role);
	
	$content = elgg_view('navigation/breadcrumbs');
	
	$content .= elgg_view_form('roles/edit', array('name' => 'role-edit-form', 'id' => 'role-edit-form'), $form_vars);
	
	echo $content;
}

/**
 * Prepare the add/edit form variables
 *
 * @param ElggRole $role
 * @return array
 */
function roles_prepare_form_vars($role= null) {

	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'guid' => NULL,
	);

	if ($role) {
		foreach (array_keys($values) as $field) {
			$values[$field] = $role->$field;
		}
	}

	if (elgg_is_sticky_form('role-edit-form')) {
		foreach (array_keys($values) as $field) {
			$values[$field] = elgg_get_sticky_value('role-edit-form', $field);
		}
	}

	elgg_clear_sticky_form('role-edit-form');

	return $values;
}

/** HELPERS **/
/**
 * Return a list of this role's members.
 *
 * @param int  $role_guid  The ID of the role.
 * @param int  $limit      The limit
 * @param int  $offset     The offset
 * @param int  $site_guid  The site
 * @param bool $count      Return the users (false) or the count of them (true)
 *
 * @return mixed
 */
function roles_get_members($role_guid, $limit = 10, $offset = 0, $site_guid = 0, $count = false) {

	// in 1.7 0 means "not set."  rewrite to make sense.
	if (!$site_guid) {
		$site_guid = ELGG_ENTITIES_ANY_VALUE;
	}
	return elgg_get_entities_from_relationship(array(
		'relationship' => ROLE_RELATIONSHIP,
		'relationship_guid' => $role_guid,
		'inverse_relationship' => TRUE,
		'types' => 'user',
		'limit' => $limit,
		'offset' => $offset,
		'count' => $count,
		'site_guid' => $site_guid
	));
}

/**
 * Return whether a given user is a member of the role or not.
 *
 * @param int $role_guid The role ID
 * @param int $user_guid  The user guid
 *
 * @return bool
 */
function roles_is_member($role_guid, $user_guid) {
	$object = check_entity_relationship($user_guid, ROLE_RELATIONSHIP, $role_guid);
	if ($object) {
		return true;
	} else {
		return false;
	}
}

/**
 * Add a user to a role.
 *
 * @param int $role_guid The group GUID.
 * @param int $user_guid  The user GUID.
 *
 * @return bool
 */
function roles_add_user($role_guid, $user_guid) {
	$result = add_entity_relationship($user_guid, ROLE_RELATIONSHIP, $role_guid);

	if ($result) {
		$params = array('role' => get_entity($role_guid), 'user' => get_entity($user_guid));
		elgg_trigger_event('add', 'role', $params);
	}

	return $result;
}

/**
 * Remove a user from a role.
 *
 * @param int $role_guid The group.
 * @param int $user_guid  The user.
 *
 * @return bool
 */
function roles_remove_user($role_guid, $user_guid) {
	// event needs to be triggered while user is still member of role to have access to group acl
	$params = array('role' => get_entity($role_guid), 'user' => get_entity($user_guid));

	elgg_trigger_event('remove', 'role', $params);
	$result = remove_entity_relationship($user_guid, ROLE_RELATIONSHIP, $role_guid);
	return $result;
}