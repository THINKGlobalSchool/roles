<?php
/**
 * TGS Roles Helper Lib
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

/** CONTENT **/

/**
 * Get roles edit/add form
 */
function roles_get_edit_content($type, $guid = NULL) {	
	elgg_push_breadcrumb(elgg_echo('admin:roles:manage'), elgg_get_site_url() . 'admin/roles/manage');
	if ($type == 'edit') {
		$role = get_entity($guid);
		elgg_push_breadcrumb($role->title, $role->getURL());
		elgg_push_breadcrumb(elgg_echo('edit'));
		if (!elgg_instanceof($role, 'object', 'role')) {
			forward(REFERER);
		}
	} else {
		elgg_push_breadcrumb(elgg_echo('Add'));
		$role = null;
	}
	
	$form_vars = roles_prepare_form_vars($role);
	
	$content = elgg_view('navigation/breadcrumbs');
	
	$content .= elgg_view_form('roles/edit', array('name' => 'role-edit-form', 'id' => 'role-edit-form'), $form_vars);
	
	echo $content;
}

/**
 * Dashbaord tab edit content form
 */
function roles_dashboard_tab_get_edit_content($type, $guid = NULL) {
	elgg_push_breadcrumb(elgg_echo('admin:roles:tabs'), elgg_get_site_url() . 'admin/roles/tabs');
	if ($type == 'edit') {
		$tab = get_entity($guid);
		elgg_push_breadcrumb($tab->title, $tab->getURL());
		elgg_push_breadcrumb(elgg_echo('edit'));
		if (!elgg_instanceof($tab, 'object', 'role_dashboard_tab')) {
			forward(REFERER);
		}
	} else {
		elgg_push_breadcrumb(elgg_echo('Add'));
		$tab = null;
	}
	
	$form_vars = roles_dashboard_tab_prepare_form_vars($tab);
	
	$content = elgg_view('navigation/breadcrumbs');
	
	$content .= elgg_view_form('roles/edittab', array('name' => 'dashboard-tab-edit-form', 'id' => 'dashboard-tab-edit-form'), $form_vars);
	
	echo $content;
}

/**
 * Role profile tab edit form
 */
function roles_dashboard_profile_get_edit_content($type, $guid = NULL) {
	elgg_push_breadcrumb(elgg_echo('admin:roles:profiletabs'), elgg_get_site_url() . 'admin/roles/profiletabs');
	if ($type == 'edit') {
		$profile = get_entity($guid);
		elgg_push_breadcrumb($profile->title, $profile->getURL());
		elgg_push_breadcrumb(elgg_echo('edit'));
		if (!elgg_instanceof($profile, 'object', 'role_profile_tab')) {
			forward(REFERER);
		}
	} else {
		elgg_push_breadcrumb(elgg_echo('Add'));
		$profile = null;
	}
	
	$form_vars = roles_dashboard_profile_prepare_form_vars($profile);
	
	$content = elgg_view('navigation/breadcrumbs');
	
	$content .= elgg_view_form('roles/editprofiletab', array('name' => 'dashboard-tab-edit-form', 'id' => 'dashboard-tab-edit-form'), $form_vars);
	
	echo $content;
}
/**
 * Prepare the add/edit form variables
 *
 * @param ElggRole $role
 * @return array
 */
function roles_prepare_form_vars($role= null) {

	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'guid' => NULL,
		'hidden' => '',
		'dashboard' => NULL,
		'profile' => NULL
	);

	if ($role) {
		foreach (array_keys($values) as $field) {
			$values[$field] = $role->$field;
		}
	}

	if (elgg_is_sticky_form('role-edit-form')) {
		foreach (array_keys($values) as $field) {
			$values[$field] = elgg_get_sticky_value('role-edit-form', $field);
		}
	}

	elgg_clear_sticky_form('role-edit-form');

	return $values;
}

/**
 * Prepare the add/edit form variables for dashboard tabs
 *
 * @param ElggObject $tab
 * @return array
 */
function roles_dashboard_tab_prepare_form_vars($tab = null) {

	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'priority' => '',
		'guid' => NULL,
		'default_tab' => 0,
	);

	if ($tab) {
		foreach (array_keys($values) as $field) {
			$values[$field] = $tab->$field;
		}
	}

	if (elgg_is_sticky_form('dashboard-tab-edit-form')) {
		foreach (array_keys($values) as $field) {
			$values[$field] = elgg_get_sticky_value('dashboard-tab-edit-form', $field);
		}
	}

	elgg_clear_sticky_form('dashboard-tab-edit-form');

	return $values;
}

/**
 * Prepare the add/edit form variables for role profiles
 *
 * @param ElggObject $profile
 * @return array
 */
function roles_dashboard_profile_prepare_form_vars($profile = null) {

	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'priority' => '',
		'guid' => NULL,
		'default_profile' => 0,
	);

	if ($profile) {
		foreach (array_keys($values) as $field) {
			$values[$field] = $profile->$field;
		}
	}

	if (elgg_is_sticky_form('profile-tab-edit-form')) {
		foreach (array_keys($values) as $field) {
			$values[$field] = elgg_get_sticky_value('profile-tab-edit-form', $field);
		}
	}

	elgg_clear_sticky_form('profile-tab-edit-form');

	return $values;
}


/** HELPERS **/
/**
 * Return a list of this role's members.
 *
 * @param int  $role_guid  The ID of the role.
 * @param int  $limit      The limit
 * @param int  $offset     The offset
 * @param int  $site_guid  The site
 * @param bool $count      Return the users (false) or the count of them (true)
 * @param bool $alphabetical Sort the users alphabetically
 *
 * @return mixed
 */
function roles_get_members($role_guid, $limit = 10, $offset = 0, $site_guid = 0, $count = false, $alphabetical = false) {

	// in 1.7 0 means "not set."  rewrite to make sense.
	if (!$site_guid) {
		$site_guid = ELGG_ENTITIES_ANY_VALUE;
	}

	$options = array(
		'relationship' => ROLE_RELATIONSHIP,
		'relationship_guid' => $role_guid,
		'inverse_relationship' => TRUE,
		'types' => 'user',
		'limit' => $limit,
		'offset' => $offset,
		'count' => $count,
		'site_guid' => $site_guid
	);

	if ($alphabetical) {
		$dbprefix = elgg_get_config('dbprefix');
		$options['joins'] = array(
			"JOIN {$dbprefix}users_entity ue on e.guid = ue.guid"
		);

		$options['order_by'] = 'ue.name';
	}
		
	return elgg_get_entities_from_relationship($options);
}

/**
 * Return whether a given user is a member of the role or not.
 *
 * @param int $role_guid The role ID
 * @param int $user_guid  The user guid
 *
 * @return bool
 */
function roles_is_member($role_guid, $user_guid) {
	$object = check_entity_relationship($user_guid, ROLE_RELATIONSHIP, $role_guid);
	if ($object) {
		return true;
	} else {
		return false;
	}
}

/**
 * Add a user to a role.
 *
 * @param int $role_guid The role GUID.
 * @param int $user_guid The user GUID.
 *
 * @return bool
 */
function roles_add_user($role_guid, $user_guid) {
	try {
		$result = add_entity_relationship($user_guid, ROLE_RELATIONSHIP, $role_guid);
	} catch (DatabaseException $e) {
		$result = FALSE;
	}

	if ($result) {
		$params = array('role' => get_entity($role_guid), 'user' => get_entity($user_guid));
		elgg_trigger_event('add', 'role', $params);
	}

	return $result;
}

/**
 * Remove a user from a role.
 *
 * @param int $role_guid The group.
 * @param int $user_guid  The user.
 *
 * @return bool
 */
function roles_remove_user($role_guid, $user_guid) {
	// event needs to be triggered while user is still member of role to have access to group acl
	$params = array('role' => get_entity($role_guid), 'user' => get_entity($user_guid));

	elgg_trigger_event('remove', 'role', $params);
	$result = remove_entity_relationship($user_guid, ROLE_RELATIONSHIP, $role_guid);
	return $result;
}

/**
 * Helper function to grab an array of existing roles
 * - This is pretty simplistic for now, because all roles 
 * are accessible by logged in users
 * 
 * @param int  $limit      The limit
 * @param int  $offset     The offset
 * @param int  $site_guid  The site
 * @param bool $count      Return the users (false) or the count of them (true)
 * @return array
 */
function get_roles($limit = 10, $offset = 0, $site_guid = ELGG_ENTITIES_ANY_VALUE, $count = FALSE, $alphabetical = FALSE) {
	$options = array(
		'type' => 'object',
		'subtype' => 'role',
		'limit' => $limit,
		'offset' => $offset,
		'count' => $count,
		'site_guid' => $site_guid
	);

	if ($alphabetical) {
		$dbprefix = elgg_get_config('dbprefix');
		$options['joins'] = array(
			"JOIN {$dbprefix}objects_entity oe on e.guid = oe.guid"
		);

		$options['order_by'] = 'oe.title';
	}

	return elgg_get_entities($options);
}

/**
 * Helper function to retrieve a role with given title (case insensitive)
 * This will return the first role with given title
 * 
 * @param int $title Title of the role (careful, these could change!)
 */
function get_role_by_title($title) {
	$options = array(
		'type' => 'object',
		'subtype' => 'role',
		'limit' => 1,
	);

	$dbprefix = elgg_get_config('dbprefix');

	// Customize query to grab only roles with given title (more efficient)
	$options['joins'][] = "JOIN {$dbprefix}objects_entity as oe";
	$options['wheres'][] = "oe.guid = e.guid";
	$options['wheres'][] = "oe.title = '{$title}'";
	
	$role = elgg_get_entities($options);

	if ($role[0]) {
		return $role[0];
	}

	return FALSE;
}

/**
 * Helper function to grab a given users roles
 * 
 * @param ElggUser $user       The user
 * @param int      $limit      The limit
 * @param int      $offset     The offset
 * @param int      $site_guid  The site
 * @param bool     $count      Return the users (false) or the count of them (true)
 * @return array
 */
function get_user_roles($user, $limit = 10, $offset = 0, $site_guid = ELGG_ENTITIES_ANY_VALUE, $count = FALSE) {
	return elgg_get_entities_from_relationship(array(
		'relationship' => 'member_of_role',
		'relationship_guid' => $user->guid,
		'inverse_relationship' => FALSE,
		'types' => 'object',
		'subtypes' => 'role',
		'limit' => $limit,
		'offset' => $offset,
		'count' => $count,
		'site_guid' => $site_guid
	));
}

/**
 * Helper function to grab roles that a 
 * user does not belong to
 * - Not too sure about that function name :S
 * 
 * @param ElggUser $user       The user
 * @param int      $limit      The limit
 * @param int      $offset     The offset
 * @param int      $site_guid  The site
 * @param bool     $count      Return the users (false) or the count of them (true)
 * @return array
 */
function get_user_roles_without($user, $limit = 10, $offset = 0, $site_guid = ELGG_ENTITIES_ANY_VALUE, $count = FALSE) {
	
	$options = array(
		'types' => 'object',
		'subtypes' => 'role',
		'limit' => $limit,
		'offset' => $offset,
		'count' => $count,
		'site_guid' => $site_guid
	);
	
	$relationship = 'member_of_role';
	$db_prefix = elgg_get_config('dbprefix');
	
	// This is the magic SQL that handles the 'without' relationship part
	$options['wheres'][] = "NOT EXISTS (
				SELECT 1 FROM {$db_prefix}entity_relationships
					WHERE guid_one = '$user->guid'
					AND relationship = '$relationship'
					AND guid_two = e.guid
			)";
	
	return elgg_get_entities($options);
}

/**
 * Helper function to grab user dashboard roles
 * 
 * @param  int        $user_guid  The user guid (if not supplied, returns all roles)
 * @return array
 */
function get_user_dashboard_roles($user_guid = 0) {
	$options = array(
		'type' => 'object',
		'subtype' => 'role',
		'limit' => 0,
		'metadata_name' => 'dashboard',
		'metadata_value' => 1,
	);

	if ($user_guid) {
		$options['relationship'] = ROLE_RELATIONSHIP;
		$options['relationship_guid'] = $user_guid;
		$options['inverse_relationship'] = FALSE;
		$roles = elgg_get_entities_from_relationship($options);
	} else {
		$roles = elgg_get_entities_from_metadata($options);
	}

	return $roles;
}

/**
 * Helper function to grab all user dashboard role tabs
 * (for all roles a user is a member of)
 *
 * @param  int    $user_guid The user guid (defaults to current user)
 * @param  int    $role_guid Specific role to grab tabs for
 * @return array
 */
function get_user_tabs($user_guid = 0, $role_guid = 0, $subtype = NULL) {
	if (!$user_guid) {
		$user_guid = elgg_get_logged_in_user_guid();
	}

	if (!$subtype) {
		return FALSE;
	}

	if ($subtype == 'role_dashboard_tab') {
		$relationship = ROLE_DASHBOARD_TAB_RELATIONSHIP;
	} else if ($subtype == 'role_profile_tab') {
		$relationship = ROLE_PROFILE_TAB_RELATIONSHIP;
	}

	$dbprefix = elgg_get_config('dbprefix');
	$user_guid = elgg_get_logged_in_user_guid();
	$rr = ROLE_RELATIONSHIP;
	$tr = $relationship;

	// Get all tabs, sorted by priority
	$tab_options = array(
		'type' => 'object',
		'subtype' => $subtype,
		'limit' => 0,
		'order_by_metadata' => array(
			'name' => 'priority',
			'as' => 'integer',
			'direction' => 'ASC'
		),
		'joins' => array(
			"JOIN {$dbprefix}entity_relationships tr"
		)
	);

	if ($role_guid) {
		$tab_roles_in = $role_guid;
	} else {
		$tab_roles_in = "SELECT err.guid from {$dbprefix}entities err
				JOIN {$dbprefix}entity_relationships rr ON err.guid = rr.guid_two
				WHERE rr.guid_one = {$user_guid} AND rr.relationship = '{$rr}'";
	}

	$tab_options['wheres'] = array(
			"tr.guid_two IN (
				{$tab_roles_in}
			) AND tr.guid_one = e.guid AND tr.relationship = '{$tr}'"
	);

	$tabs = elgg_get_entities_from_metadata($tab_options);

	// No tabs? Let's see if we have a default
	if (!$tabs) {
		// Remove all other default tabs (only one)
		$default_tabs = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtype' => $subtype,
			'limit' => 1, // There is only ever one default
			'metadata_name' => 'default_tab',
			'metadata_value' => 1,
		));

		// Will still return null if there's no tabs, that's ok that should be handled elsewhere
		return $default_tabs;
	}

	return $tabs;
}

/**
 * Extends a view with another view.
 *
 * @param string $view           The widget view to extend (content | edit)
 * @param string $view_extension The view to extend
 * @param int    $priority       Priority for the extension
 */
function roles_extend_widget_views($view, $view_extension, $priority = 501) {
	global $CONFIG;

	foreach ($CONFIG->views->locations['default'] as $name => $location) {
		if (strpos($name, 'widgets/') === 0 && $name != "widgets/role_edit"
		) {
			$view_name = substr($name, 0, strrpos($name, '/') + 1);
			$ext_array = $CONFIG->views->extensions[$view_name . $view];
			if (!$ext_array || !in_array($view_extension, $ext_array)) {
				elgg_extend_view($view_name . $view, $view_extension);
			}
		}
	}
}

/**
 * Modified version of the elgg get excerpt function
 * that doesn't butcher tags
 *
 * @param string $text      The full text to excerpt
 * @param int    $num_chars Return a string up to $num_chars long
 *
 * @return string
 */
function roles_get_excerpt($text, $num_chars = 250) {
	$text = trim($text);
	$string_length = elgg_strlen($text);

	if ($string_length <= $num_chars) {
		return $text;
	}

	// handle cases
	$excerpt = elgg_substr($text, 0, $num_chars);
	$space = elgg_strrpos($excerpt, ' ', 0);

	// don't crop if can't find a space.
	if ($space === FALSE) {
		$space = $num_chars;
	}
	$excerpt = trim(elgg_substr($excerpt, 0, $space));

	if ($string_length != elgg_strlen($excerpt)) {
		$excerpt .= '...';
	}

	return $excerpt;
}

/**
 * Get the user's background photo url
 *
 * @param ElggUser $user
 */
function roles_get_user_background_url($user, $type = FALSE) {
	if ($type) {
		$background_type = "/{$type}";
	}
	return "background/view/{$user->username}/{$user->bg_icontime}{$background_type}";
}

/**
 * Set tab priority
 */
function roles_set_tab_priority($tab, $priority) {
	$subtype = $tab->getSubtype();

	$tabs = elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'subtype' => $subtype,
		'limit' => 0,
		'metadata_name' => 'priority',
		'metadata_value' => $priority
	));

	$tab->priority = $priority;

	foreach ($tabs as $t) {
		roles_set_tab_priority($t, $priority + 1);
	}
	return TRUE;
}