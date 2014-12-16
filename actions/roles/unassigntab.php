<?php
/**
 * TGS Roles Unassign Dashboard Action
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
	
// Get inputs
$tab_guid = get_input('tab_guid');
$role_guid = get_input('role_guid');

$tab = get_entity($tab_guid);

// Determine which relationship to create
if ($tab->getSubtype() == 'role_profile_tab') {
	$relationship = ROLE_PROFILE_TAB_RELATIONSHIP;
} else if ($tab->getSubtype() == 'role_dashboard_tab') {
	$relationship = ROLE_DASHBOARD_TAB_RELATIONSHIP;
}

$result = remove_entity_relationship($tab_guid, $relationship, $role_guid);

if ($result) {
	system_message(elgg_echo('roles:success:tabunassigned'));
} else {
	register_error(elgg_echo('roles:error:tabunassigned'));
}

forward(REFERER);