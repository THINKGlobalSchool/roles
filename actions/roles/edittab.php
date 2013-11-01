<?php
/**
 * TGS Roles Edit Dashboard Tab Action
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

// Get inputs
$title = get_input('title');
$description = get_input('description');
$tab_guid = get_input('tab_guid', NULL);
$priority = get_input('priority');
$default_tab = get_input('default_tab', FALSE);

// Create Sticky form
elgg_make_sticky_form('dashboard-tab-edit-form');

// Check inputs
if (!$title || !$description) {
	register_error(elgg_echo('roles:error:requiredfields'));
	forward(REFERER);
}

// New Tab
if (!$tab_guid) {
	$tab = new ElggObject();
	$tab->access_id = ACCESS_LOGGED_IN;
	$tab->subtype = 'role_dashboard_tab';
} else { // Editing
	$tab = get_entity($tab_guid);
	if (!elgg_instanceof($tab, 'object', 'role_dashboard_tab')) {
		register_error(elgg_echo('roles:error:edittab'));
		forward(REFERER);
	}
}

$tab->title = $title;
$tab->description = $description;
$tab->priority = $priority;
$tab->default_tab = $default_tab;

// Try saving
if (!$tab->save()) {
	// Error.. say so and forward
	register_error(elgg_echo('roles:error:savetab'));
	forward(REFERER);
} 

// Remove all other default tabs (only one)
$default_tabs = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'role_dashboard_tab',
	'limit' => 0,
	'metadata_name' => 'default_tab',
	'metadata_value' => 1,
));

foreach ($default_tabs as $d_tab) {
	if ($d_tab->guid != $tab->guid) {
		$d_tab->default_tab = FALSE;
		$d_tab->save();
	}
}

// Clear Sticky form
elgg_clear_sticky_form('dashboard-tab-edit-form');

system_message(elgg_echo('roles:success:savetab'));
forward(elgg_get_site_url() . 'admin/roles/edittab?guid=' . $tab->guid);