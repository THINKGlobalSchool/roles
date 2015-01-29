<?php
/**
 * TGS Roles Background Crop Form
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.com/
 * 
 */

elgg_load_js('jquery.imgareaselect');
elgg_load_js('elgg.background_cropper');
elgg_load_css('jquery.imgareaselect');

if (!$vars['entity']->bg_icontime) {
	$nobg = 'upload-no-bg';
} else {
	$background_master = roles_get_user_background_url($vars['entity'], 'master');

	$file = new ElggFile();
	$file->owner_guid = $vars['entity']->guid;
	$file->setFilename("background/{$vars['entity']->guid}_background_master.jpg");

	$size_info = getimagesize($file->getFilenameOnFilestore());

	$bg_scale = PROFILE_BACKGROUND_PREVIEW_WIDTH / PROFILE_BACKGROUND_WIDTH; 

	if ($size_info[0] > PROFILE_BACKGROUND_WIDTH) {
		$downscaled = 'bg-downscaled';
		$bg_scale = ($size_info[0] - PROFILE_BACKGROUND_PREVIEW_WIDTH) / $size_info[0];
	}
}

$master_img = elgg_view('output/img', array(
	'src' => $background_master,
	'alt' => elgg_echo('avatar'),
	'class' => "mrl {$downscaled}",
	'id' => 'user-background-cropper',
	'data-bg_scale' => $bg_scale,
	'data-bg_width' => PROFILE_BACKGROUND_WIDTH,
	'data-bg_preview_width' => PROFILE_BACKGROUND_PREVIEW_WIDTH,
	'data-bg_original_width' => $size_info[0],
	'data-bg_original_height' => $size_info[1]
));

?>
<div class="clearfix">
	<?php echo $master_img; ?>
	<div id="user-background-preview-title"><label><?php echo elgg_echo('roles:profile:preview'); ?></label></div>
	<canvas id="user-background-preview-canvas" height='156px' width='<?php echo PROFILE_BACKGROUND_PREVIEW_WIDTH; ?>px'></canvas>
</div>
<div class="elgg-foot">
<?php
$coords = array('bg_x1', 'bg_x2', 'bg_y1', 'bg_y2');
foreach ($coords as $coord) {
	echo elgg_view('input/hidden', array('name' => $coord, 'value' => $vars['entity']->$coord));
}

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid));

echo elgg_view('input/submit', array('value' => elgg_echo('roles:profile:create')));

?>
</div>
