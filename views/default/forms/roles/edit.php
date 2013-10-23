<?php
/**
 * TGS Roles Edit Form
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
// Map values
$title = elgg_extract('title', $vars, '');
$guid = elgg_extract('guid', $vars, NULL);
$description = elgg_extract('description', $vars, '');
$hidden = elgg_extract('hidden', $vars, 0);
$dashboard = elgg_extract('dashboard', $vars, 0);

// Check if we've got an entity, if so, we're editing.
if ($guid) {
	$entity_hidden  = elgg_view('input/hidden', array(
		'name' => 'role_guid', 
		'value' => $guid,
	));
} 

// Labels/Input
$title_label = elgg_echo('title');
$title_input = elgg_view('input/text', array(
	'name' => 'title',
	'value' => $title
));

$description_label = elgg_echo("description");
$description_input = elgg_view("input/longtext", array(
	'name' => 'description', 
	'value' => $description
));

$hidden_label = elgg_echo('roles:label:hidden');
$hidden_input = elgg_view('input/dropdown', array(
	'name' => 'hidden', 
	'value' => $hidden,
	'options_values' => array(
		1 => elgg_echo('roles:label:yes'),
		0 => elgg_echo('roles:label:no'),
	)
));

$dashboard_label = elgg_echo('roles:label:dashboard');
$dashboard_input = elgg_view('input/dropdown', array(
	'name' => 'dashboard', 
	'value' => $dashboard,
	'options_values' => array(
		1 => elgg_echo('roles:label:yes'),
		0 => elgg_echo('roles:label:no'),
	)
));

$submit_input = elgg_view('input/submit', array(
	'name' => 'submit', 
	'value' => elgg_echo('save')
));	

// Add a view to extend the role form
$role_form_extend = elgg_view('forms/roles/edit/extend', $vars);

// Build Form Body
$form_body = <<<HTML

<div class='margin_top'>
	<div>
		<label>$title_label</label><br />
        $title_input
	</div><br />
	<div>
		<label>$description_label</label><br />
        $description_input
	</div><br />
	<div>
		<label>$hidden_label</label>
		$hidden_input
	</div><br />
	<div>
		<label>$dashboard_label</label>
		$dashboard_input
	</div><br />
	$role_form_extend
	<div class='elgg-foot'>
		$submit_input
		$entity_hidden
	</div>
</div>
HTML;

echo $form_body;
