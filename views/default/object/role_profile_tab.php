<?php
/**
 * TGS Roles Role Profile Object View
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 * 
 */

$full = elgg_extract('full_view', $vars, FALSE);

$profile_tab = (isset($vars['entity'])) ? $vars['entity'] : FALSE;

if (!$profile_tab) {
	return '';
}

$linked_title = "<h3 style='padding-top: 14px;'><a href=\"{$profile_tab->getURL()}\" title=\"" . htmlentities($profile_tab->title) . "\">{$profile_tab->title}</a></h3>";

$metadata = elgg_view_menu('entity', array(
	'entity' => $profile_tab,
	'handler' => 'roles',
	'class' => 'elgg-menu-hz',
));

if ($full) {
	forward(REFERER);
} else {
	// brief view
	$params = array(
		'title' => $profile_tab->title,
		'entity' => $profile_tab,
		'metadata' => $metadata,
	);
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block('', $list_body);
}
?>