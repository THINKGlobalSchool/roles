<?php
/**
 * TGS Roles Edit Role Profile Form
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 * 
 */
// Map values
$title = elgg_extract('title', $vars, '');
$guid = elgg_extract('guid', $vars, NULL);
$description = elgg_extract('description', $vars, '');
$priority = elgg_extract('priority', $vars, '');
$default_profile = elgg_extract('default_profile', $vars, 0);

// Check if we've got an entity, if so, we're editing.
if ($guid) {
	$entity_hidden  = elgg_view('input/hidden', array(
		'name' => 'tab_guid', 
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

$priority_label = elgg_echo('roles:label:priority');
$priority_input = elgg_view('input/text', array(
	'name' => 'priority',
	'value' => $priority
));

$default_profile_label = elgg_echo('roles:label:default_profile');
$default_profile_input = elgg_view('input/dropdown', array(
	'name' => 'default_tab', 
	'value' => $default_tab,
	'options_values' => array(
		1 => elgg_echo('roles:label:yes'),
		0 => elgg_echo('roles:label:no'),
	)
));

$submit_input = elgg_view('input/submit', array(
	'name' => 'submit', 
	'value' => elgg_echo('save')
));	

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
		<label>$priority_label</label><br />
		$priority_input
	</div><br />
	<div>
		<label>$default_profile_label</label><br />
		$default_profile_input
	</div><br />
	<div class='elgg-foot'>
		$submit_input
		$entity_hidden
	</div>
</div>
HTML;

echo $form_body;
