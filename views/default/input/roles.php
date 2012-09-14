<?php
/**
 * TGS Roles input selector (for entities)
 * - Excludes hidden roles
 *
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 * @uses $vars['entity'] The entity to add roles to
 * @uses $vars['meta_name'] Optional name for metadata (default to roles)
 */

$entity = elgg_extract('entity', $vars);
$meta_name = elgg_extract('meta_name', $vars, 'roles');

if (elgg_instanceof($entity, 'object')) {
	$selected_roles = $entity->$meta_name;
}

// Get all site roles
$roles_entities = get_roles(0);

$roles = array();

foreach($roles_entities as $role) {
	$roles[$role->title] = $role->guid;
}

if (empty($selected_roles)) {
	$selected_roles = array();
}

if (!empty($roles)) {
	if (!is_array($roles)) {
		$roles = array($roles);
	}

	$roles_label = elgg_echo('roles');

	$roles_input = elgg_view('input/checkboxes', array(
		'options' => $roles,
		'value' => $selected_roles,
		'name' => 'roles_list',
		'align' => 'horizontal',
	));

	echo <<<HTML
		<div class="roles">
			<label>$roles_label</label><br />
			$roles_input
			<input type="hidden" name="roles_marker" value="on" />
		</div>
HTML;
}
