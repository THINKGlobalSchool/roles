<?php
/**
 * TGS Roles Widget List
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

$widgets = elgg_get_widgets($guid, 'rolewidget');

$params = array(
	'widgets' => $widgets,
	'role_guid' => $guid,
	'show_add_panel' => TRUE,
);

$content = elgg_view_layout('role_widgets', $params);

$available_label = elgg_echo('roles:label:availablewidgets');
$available_module = elgg_view_module('inline', $available_label, $content);	

echo $available_module;