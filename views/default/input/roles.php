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
 * @uses $vars['name'] Name of the field
 * @uses $vars['meta_name'] Optional name for metadata (Default to roles)
 * @uses $vars['label'] Optional label (Default to roles)
 */

$value = elgg_extract('value', $vars);
$label = elgg_extract('label', $vars, elgg_echo('roles'));
$name = elgg_extract('name', $vars, 'roles_list');

// Get all site roles
$roles_entities = get_roles(0);

$roles = array();

foreach($roles_entities as $role) {
	$roles[$role->title] = $role->guid;
}

if (empty($value)) {
	$value = array();
}

if (!empty($roles)) {
	if (!is_array($roles)) {
		$roles = array($roles);
	}

	$roles_input = elgg_view('input/checkboxes', array(
		'options' => $roles,
		'value' => $value,
		'name' => $name,
		'align' => 'horizontal',
	));

	echo <<<HTML
		<div class="roles">
			<label>$label</label><br />
			$roles_input
			<input type="hidden" name="roles_marker" value="on" />
		</div>
HTML;
}
