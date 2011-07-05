<?php
/**
 * TGS Roles Add User Form
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

// Get role guid
$role_guid = elgg_extract('role_guid', $vars);

// Labels/Input
$user_label = elgg_echo('roles:label:username');
$user_input = elgg_view('input/text', array(
	'name' => 'username',
));

$role_input = elgg_view('input/hidden', array(
	'name' => 'role_guid',
	'value' => $role_guid,
));

$submit_input = elgg_view('input/submit', array(
	'name' => 'submit', 
	'value' => elgg_echo('save'),
	'class' => 'add-to-role',
));

$form_body = <<<HTML
	<label>$user_label</label>
	$user_input 
	$submit_input
	$role_input
HTML;

echo $form_body;