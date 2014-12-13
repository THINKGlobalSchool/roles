<?php
/**
 * TGS Roles Profile Management Form
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
	'view' => 'roles/modules/profile_roles',
	'module_class' => 'role-profile',
	'module_id' => 'role-list',
	'module_type' => 'inline',
	'view_vars' => array(),
));

echo elgg_view_module('inline', elgg_echo('admin:roles:profile'), $module, array(
	'class' => 'elgg-module roles-module elgg-module-inline',
));

// Placeholder for tab list
$content .= "<div id='tab-list-output' class='roles-module'></div>";
echo $content;