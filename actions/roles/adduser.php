<?php
/**
 * TGS Roles add user action
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 */

// Get user/role inputs
$username = sanitise_string(get_input('username'));
$role_guid = (int)sanitise_string(get_input('role_guid'));

// Get user entity
$user = get_user_by_username($username);

// Check for user
if (!$user) {
	register_error(elgg_echo('roles:error:invaliduser'));
	forward(REFERER);
}

// Get role entity
$role = get_entity($role_guid);

// Check for role
if (!$role || !elgg_instanceof($role, 'object', 'role')) {
	register_error(elgg_echo('roles:error:invalidrole'));
	forward(REFERER);
}

// Check if user is already a member, don't try to add them
if ($role->isMember($user)) {
	register_error(elgg_echo('roles:error:existing', array($user->name, $role->title)));
	forward(REFERER);
}

// Try to remove
if ($role->add($user)) {
	// All good!
	system_message(elgg_echo('roles:success:add'));
} else {
	// There was an error
	register_error(elgg_echo('roles:error:add'));
}
forward(REFERER);