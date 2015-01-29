<?php
/**
 * TGS Roles Profile list Modules
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
	'subtype' => 'role',
	'limit' => 0,
	'full_view' => FALSE,
	'metadata_name' => 'profile',
	'metadata_value' => 1,
);

$content = elgg_list_entities_from_metadata($options);

if (!$content) {
	$content = elgg_echo('roles:label:noroles');
}

echo $content;