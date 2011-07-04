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