<?php
/**
 * TGS Roles Tab List
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 * 
 */

$guid = elgg_extract('guid', $vars, NULL);

$role = get_entity($guid);

if (!$role) {
	return;
}

elgg_push_context('role_tab_assignment');
set_input('role_guid', $guid);

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'role_dashboard_tab',
	'limit' => 0,
	'full_view' => FALSE
));

if (!$content) {
	$content = elgg_echo('roles:label:notabs');
}

$tabs_label = elgg_echo('admin:roles:tabs');
$tabs_module = elgg_view_module('inline', $tabs_label, $content);	

echo $tabs_module;