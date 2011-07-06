<?php
/**
 * TGS Roles output
 *  
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 * @uses $vars['entity'] The entity to add roles to
 */

$entity = elgg_extract('entity', $vars);

$content = '';
if (elgg_instanceof($entity, 'object')) {
	$roles = $entity->roles;
	if (!empty($roles)) {
		if (!is_array($roles)) {
			$roles = array($roles);
		}
		
		foreach($roles as $role_guid) {
			$role = get_entity($role_guid);
			if (!empty($content)) {
				$content .= ', ';
			}
			$content .= $role->title;
		}
	}
}

if ($content) {
	echo '<p class="elgg-output-categories">' . elgg_echo('roles') . ": $content</p>";
}

