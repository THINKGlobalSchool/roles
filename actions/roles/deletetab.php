<?php
/**
 * TGS Roles Delete Dashboard Tab Action
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
	
// Get inputs
$tab_guid = get_input('guid');

$tab = get_entity($tab_guid);

if (elgg_instanceof($tab, 'object', 'role_dashboard_tab')) {
	if ($tab->delete()) {
		// Success
		system_message(elgg_echo('roles:success:deletetab'));
		forward('admin/roles/tabs');
		
	} else {
		// Error
		register_error(elgg_echo('roles:error:deletetab'));
		forward(REFERER);
	}		
}
