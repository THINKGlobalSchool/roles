<?php
/**
 * TGS Roles Background Crop Action
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.com/
 * 
 */

$guid = get_input('guid');
$owner = get_entity($guid);
$image_data = get_input('image_data');

if (!$owner || !($owner instanceof ElggUser) || !$owner->canEdit()) {
	register_error(elgg_echo('roles:error:backgroundcrop'));
	forward(REFERER);
}

// get the images and save their file handlers into an array
// so we can do clean up if one fails.
$files = array();

if ($image_data) {
	//@todo Make these actual entities.  See exts #348.
	$file = new ElggFile();
	$file->owner_guid = $guid;
	$file->setFilename("background/{$guid}_background_cropped.jpg");
	$file->open('write');
	$file->write(base64_decode($image_data));
	$file->close();
	$files[] = $file;
} else {
	// cleanup on fail
	foreach ($files as $file) {
		$file->delete();
	}

	register_error(elgg_echo('roles:error:backgroundresize'));
	forward(REFERER);
}

$owner->bg_icontime = time();

system_message(elgg_echo('roles:success:backgroundcrop'));
forward(REFERER);