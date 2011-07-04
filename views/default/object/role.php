<?php
/**
 * TGS Roles Object View
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$full = elgg_extract('full_view', $vars, FALSE);

$role = (isset($vars['entity'])) ? $vars['entity'] : FALSE;

if (!$role) {
	return '';
}

$linked_title = "<h3 style='padding-top: 14px;'><a href=\"{$role->getURL()}\" title=\"" . htmlentities($role->title) . "\">{$role->title}</a></h3>";

$metadata = elgg_view_menu('entity', array(
	'entity' => $role,
	'handler' => 'roles',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

if ($full) {
	$description = elgg_view('output/longtext', array('value' => $role->description));

	$role_users = elgg_list_entities_from_relationship(array(
		'relationship' => ROLE_RELATIONSHIP,
		'relationship_guid' => $role->getGUID(),
		'inverse_relationship' => TRUE,
		'types' => array('user'),
		'limit' => 0,
		'offset' => 0,
		'count' => FALSE,
		'full_view' => FALSE,
	));
	
	if (!$role_users) {
		$role_users = elgg_echo('roles:label:nousers');
	}
	
	$users_label = elgg_echo('roles:label:users');
	
	$users_module = elgg_view_module('inline', $users_label, $role_users);
		
	// brief view
	$params = array(
		'entity' => $role,
		'metadata' => $metadata,
	);
	$list_body = elgg_view('object/elements/summary', $params);


	$role_info = elgg_view_image_block('', $list_body);
	
	echo <<<HTML
		$role_info
		$description
		$users_module
HTML;
} else {
	// brief view
	$params = array(
		'entity' => $role,
		'metadata' => $metadata,
	);
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block('', $list_body);
}
?>