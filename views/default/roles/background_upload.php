<?php
/**
 * TGS Roles Profile Background Upload View
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.com/
 * 
 */


if (!$vars['entity']->bg_icontime) {
	$background_photo = elgg_normalize_url("_graphics/icons/default/large.png");
	$nobg = 'no-bg';
} else {
	$background_photo = elgg_normalize_url(roles_get_user_background_url($vars['entity']));
	
	$bg_scale = PROFILE_BACKGROUND_PREVIEW_WIDTH / PROFILE_BACKGROUND_WIDTH; 

	$file = new ElggFile();
	$file->owner_guid = $vars['entity']->guid;
	$file->setFilename("background/{$vars['entity']->guid}_background_cropped.jpg");

	$size_info = getimagesize($file->getFilenameOnFilestore());

	$scaled_width = $size_info[0] * $bg_scale;
	$background_size = "{$scaled_width}px auto";
	
	$background_style = "style='background: url($background_photo); height: 156px; background-size: $background_size;'";
}

$current_label = elgg_echo('roles:profile:current');

$remove_button = '';
if ($vars['entity']->bg_icontime) {
	$remove_button = elgg_view('output/url', array(
		'text' => elgg_echo('remove'),
		'title' => elgg_echo('roles:profile:remove'),
		'href' => 'action/roles/background_remove?guid=' . elgg_get_page_owner_guid(),
		'is_action' => true,
		'class' => 'elgg-button elgg-button-cancel',
	));
}

$form_params = array('enctype' => 'multipart/form-data');
$upload_form = elgg_view_form('roles/background_upload', $form_params, $vars);

?>

<p class="mtm">
	<?php echo elgg_echo('roles:profile:backgroundinstructions'); ?>
</p>

<?php

$current_background = <<<HTML
<div id="current-user-background" class="mbl $nobg" $background_style>
</div>
$remove_button
HTML;

$upload = <<<HTML
<div id="avatar-upload">
	$upload_form
</div>
HTML;

echo elgg_view_module('aside', $current_label, $current_background);
echo elgg_view_module('aside', elgg_echo("roles:profile:upload"), $upload );
