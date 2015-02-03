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

$guid = get_input('guid');
$owner = get_entity($guid);

if (!$owner || !($owner instanceof ElggUser) || !$owner->canEdit()) {
	register_error(elgg_echo('roles:error:backgroundupload'));
	forward(REFERER);
}

if ($_FILES['background']['error'] != 0) {
	register_error(elgg_echo('roles:error:backgroundupload'));
	forward(REFERER);
}

// Store files for cleanup on failure
$files = array();

try {
	// Create and open file to guarantee it and it's directory exist
	$file = new ElggFile();
	$file->owner_guid = $guid;
	$file->setFilename("background/{$guid}_background_master.jpg");
	$file->open('write');



	// Get file size info
	$size_info = getimagesize($_FILES['background']['tmp_name']);

	if ($size_info[0] > PROFILE_BACKGROUND_WIDTH) {
		$max_width = PROFILE_BACKGROUND_WIDTH * 1.5;

		// Resize the image
		$resized = get_resized_image_from_uploaded_file('background', $max_width, $size_info[1], false, false);
		
		$file->write($resized);
		$file->close();
	} else {
		// File is smaller than the background area, just the file in place
		$file->close();
		move_uploaded_file($_FILES['background']['tmp_name'], $file->getFilenameOnFilestore());
	}
	
	$files[] = $file;

	// Copy the file for the cropped image
	$file_copy = new ElggFile();
	$file_copy->owner_guid = $guid;
	$file_copy->setFilename("background/{$guid}_background_cropped.jpg");
	$file_copy->open('write');
	$file_copy->close();

	copy($file->getFilenameOnFilestore(), $file_copy->getFilenameOnFilestore());

	$files[] = $file_copy;

} catch (Exception $e) {
	foreach ($files as $file) {
		$file->close();
		$file->delete();
	}
	register_error(elgg_echo('roles:error:backgroundupload'));
	forward(REFERER);
}

// reset crop coordinates
$owner->bg_x1 = 0;
$owner->bg_x2 = 0;
$owner->bg_y1 = 0;
$owner->bg_y2 = 0;

$owner->bg_icontime = time();

system_message(elgg_echo("roles:success:backgroundupload"));

forward(REFERER);
