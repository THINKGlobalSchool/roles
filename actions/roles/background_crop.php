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

if (!$owner || !($owner instanceof ElggUser) || !$owner->canEdit()) {
	register_error(elgg_echo('roles:error:backgroundcrop'));
	forward(REFERER);
}

$x1 = (int) get_input('bg_x1', 0);
$y1 = (int) get_input('bg_y1', 0);
$x2 = (int) get_input('bg_x2', 0);
$y2 = (int) get_input('bg_y2', 0);

$width = $x2 - $x1;
$height = $y2 - $y1;

$filehandler = new ElggFile();
$filehandler->owner_guid = $owner->getGUID();
$filehandler->setFilename("background/{$guid}_background_master.jpg");
$filename = $filehandler->getFilenameOnFilestore();

// ensuring the avatar image exists in the first place
if (!file_exists($filename)) {
	register_error(elgg_echo('roles:error:backgroundcrop'));
	forward(REFERER);
}

// get the images and save their file handlers into an array
// so we can do clean up if one fails.
$files = array();

$resized = get_resized_image_from_existing_file($filename, $width, $height, FALSE, $x1, $y1, $x2, $y2, FALSE);

if ($resized) {
	//@todo Make these actual entities.  See exts #348.
	$file = new ElggFile();
	$file->owner_guid = $guid;
	$file->setFilename("background/{$guid}_background_cropped.jpg");
	$file->open('write');
	$file->write($resized);
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

$owner->bg_x1 = $x1;
$owner->bg_x2 = $x2;
$owner->bg_y1 = $y1;
$owner->bg_y2 = $y2;

system_message(elgg_echo('roles:success:backgroundcrop'));
// elgg_delete_river(array('subject_guid' => $owner->guid, 'view' => $view));
// add_to_river($view, 'update', $owner->guid, $owner->guid);
forward(REFERER);
