<?php
/**
 * TGS Roles dropdown, for choosing one specific role
 * - Excludes hidden roles by default
 *  
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 * @uses $vars['show_all'] Include an 'All' entry
 * @uses $vars['show_hidden'] Include hidden roles
 */

// Get all site roles
$roles_entities = get_roles(0);

$vars['options_values'] = array();

if ($vars['show_all']) {
	$vars['options_values'] = array(
		0 => elgg_echo('all'),
	);
}

foreach($roles_entities as $role) {
	if ($vars['show_hidden'] || !$role->hidden) {
		$vars['options_values'][$role->guid] = $role->title;
	}
}

echo elgg_view('input/dropdown', $vars);