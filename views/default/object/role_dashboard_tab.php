<?php
/**
 * TGS Roles Dashboard Tab Object View
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$full = elgg_extract('full_view', $vars, FALSE);

$tab = (isset($vars['entity'])) ? $vars['entity'] : FALSE;

if (!$tab) {
	return '';
}

$linked_title = "<h3 style='padding-top: 14px;'><a href=\"{$tab->getURL()}\" title=\"" . htmlentities($tab->title) . "\">{$tab->title}</a></h3>";

$metadata = elgg_view_menu('entity', array(
	'entity' => $tab,
	'handler' => 'roles',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

if ($full) {
	forward(REFERER);
} else {
	// brief view
	$params = array(
		'title' => $tab->title,
		'entity' => $tab,
		'metadata' => $metadata,
	);
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block('', $list_body);
}
?>