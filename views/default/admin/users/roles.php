<?php
/**
 * TGS Roles Admin List
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
elgg_load_css('elgg.roles');
elgg_load_js('elgg.roles');
elgg_load_js('elgg.userpicker');
elgg_load_js('elgg.userpicker.html');

$content = "<a href='". elgg_get_site_url() . "admin/users/addrole' class='elgg-button elgg-button-action'>" . elgg_echo('roles:label:new') . "</a><div style='clear: both;'></div>";

$content .= elgg_view('modules/ajaxmodule', array(
	'title' => elgg_echo('roles:label:currentroles'),
	'subtypes' => array('role'),
	'limit' => 15,
	'module_type' => 'inline',
	'module_class' => 'roles-module',
	'module_id' => 'role-list',
));

// Placeholder for user list
$content .= "<div id='user-list' class='roles-module'></div>";
echo $content;