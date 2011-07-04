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

$content = "<a href='". elgg_get_site_url() . "admin/users/addrole' class='elgg-button elgg-button-action'>" . elgg_echo('roles:label:new') . "</a>";


$roles_label = elgg_echo('roles:label:currentroles');
$roles .= elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'role', 
	'full_view' => FALSE,
	'limit' => 10,
));

$content .= elgg_view_module('inline', $roles_label, $roles);

echo $content;