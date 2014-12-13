<?php
/**
 * TGS Roles Role profiles module
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 * 
 */

$options = array(
	'type' => 'object',
	'subtype' => 'role_profile_tab',
	'limit' => 10,
	'full_view' => FALSE,
);

$content = elgg_list_entities_from_metadata($options);

if (!$content) {
	$content = elgg_echo('roles:label:noprofiletabs');
}

echo $content;