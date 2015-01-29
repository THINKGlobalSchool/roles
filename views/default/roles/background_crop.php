<?php
/**
 * TGS Roles Profile Background Crop View
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.com/
 * 
 */

$crop_title = elgg_echo('roles:profile:backgroundcrop');
$crop_desc = elgg_echo("roles:profile:backgroundcropinstructions");
$crop_form = elgg_view_form('roles/background_crop', array(), $vars);

$crop_tool = <<<HTML
<div id="background-croppingtool">
	<p>
		$crop_desc
	</p>
	$crop_form
</div>
HTML;

echo elgg_view_module('aside', $crop_title, $crop_tool);

