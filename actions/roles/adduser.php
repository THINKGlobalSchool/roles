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
$users = get_input('members');
$role_guid = (int)sanitise_string(get_input('role_guid'));

// Check for user
if (empty($users)) {
	register_error(elgg_echo('roles:error:userrequired'));
	forward(REFERER);
}

// Get role entity
$role = get_entity($role_guid);

// Check for role
if (!$role || !elgg_instanceof($role, 'object', 'role')) {
	register_error(elgg_echo('roles:error:invalidrole'));
	forward(REFERER);
}

// Loop and add users
foreach ($users as $guid) {
	$user = get_entity($guid);
	if (elgg_instanceof($user, 'user')) {
		// Check if user is already a member, don't try to add them
		if ($role->isMember($user)) {
			register_error(elgg_echo('roles:error:existing', array($user->name, $role->title)));
		} else {
			// Try to add
			if ($role->add($user)) {
				// All good!
				system_message(elgg_echo('roles:success:add', array($role->title)));
			} else {
				// There was an error
				register_error(elgg_echo('roles:error:add'));
			}
		}	
	} else {
		register_error(elgg_echo('roles:error:invaliduser', array($guid)));
	}
}
forward(REFERER);