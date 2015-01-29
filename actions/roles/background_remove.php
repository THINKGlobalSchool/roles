<?php
/**
 * TGS Roles Background Upload Action
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.com/
 * 
 */

$user_guid = get_input('guid');
$user = get_user($user_guid);

if (!$user || !$user->canEdit()) {
	register_error(elgg_echo('roles:error:backgroundremove'));
	forward(REFERER);
}

$file_types = array('cropped', 'master');

// Delete background(s)
foreach ($file_types as $type) {
	$file = new ElggFile();
	$file->owner_guid = $user_guid;
	$file->setFilename("background/{$user_guid}_background_{$type}.jpg");
	$filepath = $file->getFilenameOnFilestore();
	if (!$file->delete()) {
		elgg_log("Background file remove failed. Remove $filepath manually, please.", 'WARNING');
	}
}

// Remove crop coords
unset($user->bg_x1);
unset($user->bg_x2);
unset($user->bg_y1);
unset($user->bg_y2);

// Remove icon
unset($user->bg_icontime);

system_message(elgg_echo('roles:success:backgroundremove'));
forward(REFERER);
