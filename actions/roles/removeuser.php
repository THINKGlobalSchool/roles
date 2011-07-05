<?php
/**
 * TGS Roles remove user action
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 */

// Get user/role inputs
$user_guid = (int)sanitise_string(get_input('user_guid'));
$role_guid = (int)sanitise_string(get_input('role_guid'));

// Get user entity
$user = get_user($user_guid);

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

// Try to remove
if ($role->remove($user)) {
	// All good!
	system_message(elgg_echo('roles:success:remove'));
} else {
	// There was an error
	register_error(elgg_echo('roles:error:remove'));
}
forward(REFERER);