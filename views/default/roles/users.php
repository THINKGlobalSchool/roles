<?php
/**
 * TGS Roles User List
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$guid = elgg_extract('guid', $vars, NULL);

$role = get_entity($guid);

if (!$role) {
	return;
}

$role_users = $role->getMembers();



if ($role_users) {
	foreach($role_users as $user) {
		$icon = elgg_view_entity_icon($user, 'tiny');
		
		$delete_button = elgg_view("output/confirmlink",array(
			'href' => "action/roles/removeuser?user_guid={$user->guid}&role_guid={$role_guid}",
			'text' => "<span class=\"elgg-icon elgg-icon-delete right\"></span>",
			'confirm' => elgg_echo('roles:removeconfirm'),
			'text_encode' => false,
			'id' => $user->guid,
			'class' => 'remove-from-role',
			'name' => $role->guid,
		));
		
		// Register the remove menu item
		$params = array(
			'name' => 'remove-from-role',
			'text' => $delete_button,
			'href' => FALSE,
		);
		
		elgg_register_menu_item('user-role-menu', $params);
		
		$metadata = elgg_view_menu('user-role-menu', array(
			'entity' => $user,
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz',
		));
		

		$title = "<a href=\"" . $user->getUrl() . "\">" . $user->name . "</a>";
		$params = array(
			'entity' => $user,
			'title' => $title,
			'metadata' => $metadata,
		);

		$list_body = elgg_view('user/elements/summary', $params);

		$content .= elgg_view_image_block($icon, $list_body);
	}
} else {
	$content = elgg_echo('roles:label:nousers');
} 

$users_label = elgg_echo('roles:label:users');

$users_module = elgg_view_module('inline', $users_label, $content);

echo $users_module;