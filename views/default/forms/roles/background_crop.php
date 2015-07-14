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

elgg_load_js('jquery.cropit');
elgg_load_js('elgg.background_cropper');

if (!$vars['entity']->bg_icontime) {
	$nobg = 'upload-no-bg';
} else {
	$background_master = roles_get_user_background_url($vars['entity'], 'master');
	$file = new ElggFile();
	$file->owner_guid = $vars['entity']->guid;
	$file->setFilename("background/{$vars['entity']->guid}_background_master.jpg");

	$bg_scale =  PROFILE_BACKGROUND_WIDTH / PROFILE_BACKGROUND_PREVIEW_WIDTH; 
}

$master_img = elgg_view('output/img', array(
	'src' => $background_master,
	'alt' => elgg_echo('avatar'),
	'class' => "hidden",
	'id' => 'master-bg',
	'data-bg_scale' => $bg_scale
));

echo $master_img;

?>
<div id="image-cropper">
	<div class="cropit-image-preview"></div>
	<div class='cropit-control-container'>
		<i class="fa fa-picture-o fa-fw"></i>
		<input type="range" class="cropit-image-zoom-input" />  
		<i class="fa fa-picture-o fa-2x fa-fw"></i>
	</div>
</div>
<?php
echo elgg_view('input/submit', array(
	'value' => elgg_echo('roles:profile:create'),
	'id' => 'bg-submit'
));

echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid));
echo elgg_view('input/hidden', array('name' => 'image_data', 'value' => ''));
