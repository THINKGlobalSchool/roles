<?php
/**
 * TGS Roles Delete Action
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
	
// Get inputs
$role_guid = get_input('guid');

$role = get_entity($role_guid);

if (elgg_instanceof($role, 'object', 'role')) {
	if ($role->delete()) {
		// Success
		system_message(elgg_echo('roles:success:delete'));
		forward('admin/roles/manage');
		
	} else {
		// Error
		register_error(elgg_echo('roles:error:delete'));
		forward(REFERER);
	}		
}
