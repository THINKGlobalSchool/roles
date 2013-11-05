<?php
/**
 * TGS Roles General Widget Edit Extension
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 * 
 */

// Only add global edit content to role widgets
if (isset($vars['entity']) && $vars['entity']->context == 'rolewidget') {

	$params = array(
		'name' => 'params[hide_empty]',
		'value' => (int)$vars['entity']->hide_empty,
		'options_values' => array(
			1 => elgg_echo('Yes'),
			0 => elgg_echo('No'),
		),
	);

	$hide_label = elgg_echo('roles:label:hide_empty');
	$hide_input = elgg_view('input/dropdown', $params);

	$content = <<<HTML
		<div>
			<label>$hide_label</label>
			$hide_input
		</div>
HTML;
	echo $content;	
}