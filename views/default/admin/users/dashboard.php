<?php
/**
 * TGS Roles Dashboard Management Form
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 * 
 */
elgg_load_js('elgg.roles');
elgg_load_css('elgg.roles.admin');

$module = elgg_view('modules/genericmodule', array(
	'view' => 'roles/modules/dashboard_roles',
	'module_class' => '',
	'module_id' => 'role-list',
	'module_type' => 'inline',
	'view_vars' => array(),
));

echo elgg_view_module('inline', elgg_echo('admin:users:dashboard'), $module, array(
	'class' => 'elgg-module roles-widget-module elgg-module-inline',
));

// Placeholder for user list
$content .= "<div id='widget-list' class='roles-widget-module'></div>";
echo $content;