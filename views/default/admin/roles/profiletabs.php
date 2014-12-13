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

echo "<a href='". elgg_get_site_url() . "admin/roles/addprofiletab' class='elgg-button elgg-button-action'>" . elgg_echo('roles:label:newprofiletab') . "</a><div style='clear: both;'></div>";

$module = elgg_view('modules/genericmodule', array(
	'view' => 'roles/modules/profile_tabs',
	'module_class' => '',
	'module_id' => 'profile-list',
	'module_type' => 'inline',
	'view_vars' => array(),
));

echo elgg_view_module('inline', elgg_echo('admin:roles:profiletabs'), $module, array(
	'class' => 'elgg-module roles-widget-module elgg-module-inline',
));

// Placeholder for widgets list
$content .= "<div id='widget-list-output' class='roles-widget-module'></div>";
echo $content;