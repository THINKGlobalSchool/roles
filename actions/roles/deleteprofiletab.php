<?php
/**
 * TGS Roles Delete Role Profile Action
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
	
// Get inputs
$profile_guid = get_input('guid');

$profile = get_entity($profile_guid);

if (elgg_instanceof($profile, 'object', 'role_profile_tab')) {
	if ($profile->delete()) {
		// Success
		system_message(elgg_echo('roles:success:deleteprofiletab'));
		forward('admin/roles/profile');
		
	} else {
		// Error
		register_error(elgg_echo('roles:error:deleteprofiletab'));
		forward(REFERER);
	}		
}
