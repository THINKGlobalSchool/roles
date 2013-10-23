<?php
/**
 * TGS Roles View Role
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
elgg_load_css('elgg.roles.admin');

$role = get_entity(get_input('guid'));

elgg_push_breadcrumb(elgg_echo('admin:users:roles'), elgg_get_site_url() . 'admin/users/roles');

if (elgg_instanceof($role, 'object', 'role')) {
	$content = elgg_view_entity($role, array('full_view' => TRUE));
	elgg_push_breadcrumb($role->title, $role->getURL());
} else {
	$content = elgg_echo('roles:error:notfound');
}

$breadcrumbs = elgg_view('navigation/breadcrumbs');

echo $breadcrumbs . $content;