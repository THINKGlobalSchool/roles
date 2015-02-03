<?php
/**
 * TGS Roles Edit Action
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

// Get inputs
$title = get_input('title');
$description = get_input('description');
$hidden = get_input('hidden', 0);
$dashboard = get_input('dashboard', 0);
$profile = get_input('profile', 0);
$role_guid = get_input('role_guid', NULL);

// Create Sticky form
elgg_make_sticky_form('role-edit-form');

// Check inputs
if (!$title || !$description) {
	register_error(elgg_echo('roles:error:requiredfields'));
	forward(REFERER);
}

// New Role
if (!$role_guid) {
	$role = new ElggRole();
	$role->access_id = ACCESS_LOGGED_IN; // @TODO .. what should this be
	$fwd = elgg_normalize_url('admin/roles/manage');	
} else { // Editing
	$role = get_entity($role_guid);
	if (!elgg_instanceof($role, 'object', 'role')) {
		register_error(elgg_echo('roles:error:edit'));
		forward(REFERER);
	}
	$fwd = elgg_normalize_url('admin/roles/editrole?guid=' . $role->guid);
}

$role->title = $title;
$role->description = $description;
$role->hidden = $hidden;
$role->dashboard = $dashboard;
$role->profile = $profile;

// Try saving
if (!$role->save()) {
	// Error.. say so and forward
	register_error(elgg_echo('roles:error:save'));
	forward(REFERER);
} 

// Clear Sticky form
elgg_clear_sticky_form('role-edit-form');

system_message(elgg_echo('roles:success:save'));
forward($fwd);
