<?php
/**
 * TGS Roles Background View Page
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015	
 * @link http://www.thinkglobalschool.com/
 * 
 */

// page owner library sets this based on URL
$user = elgg_get_page_owner_entity();

// If user doesn't exist, return nothing
if (!$user) {
	return;
}

$user_guid = $user->getGUID();

$type = get_input('background_type', 'cropped');

// Try and get the icon
$filehandler = new ElggFile();
$filehandler->owner_guid = $user_guid;
$filehandler->setFilename("background/{$user_guid}_background_{$type}.jpg");

$success = false;

try {
	if ($filehandler->open("read")) {
		if ($contents = $filehandler->read($filehandler->getSize())) {
			$success = true;
		}
	}
} catch (InvalidParameterException $e) {
	elgg_log("Unable to get background for user with GUID $user_guid", 'ERROR');
}


if (!$success) {
	return;
}

header("Content-type: image/jpeg", true);
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
header("Pragma: public", true);
header("Cache-Control: public", true);
header("Content-Length: " . strlen($contents));

echo $contents;
