<?php
/**
 * TGS Roles Set Tab Priority
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.com/
 *
 */

$tab_guid = get_input('tab_guid');
$priority = get_input('priority');

$tab = get_entity($tab_guid);

if (!elgg_instanceof($tab, 'object', 'role_dashboard_tab') && !elgg_instanceof($tab, 'object', 'role_profile_tab')) {
	register_error(elgg_echo('roles:error:invalidtab', array($tab_guid)));
	forward(REFERER);
}

if (!roles_set_tab_priority($tab, $priority)) {
	register_error(elgg_echo('roles:error:setpriority'));
}

forward(REFERER);