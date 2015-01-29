<?php
/**
 * Elgg Role Widgets layout
 *
 * Modified version of the page/layouts/widgets layout
 *
 * @uses $vars['widget_type']      Type of widget to use
 * @uses $vars['content']          Optional display box at the top of layout
 * @uses $vars['num_columns']      Number of widget columns for this layout (3)
 * @uses $vars['show_add_widgets'] Display the add widgets button and panel (false)
 * @uses $vars['show_add_panel']   Display the add widgets button and panel (false)
 * @uses $vars['show_access']      Show the access control (true)
 */

$num_columns = elgg_extract('num_columns', $vars, 2);
$class = elgg_extract('class', $vars, '');
$show_add_widgets = elgg_extract('show_add_widgets', $vars, false);
$show_add_panel = elgg_extract('show_add_panel', $vars, false);
$widget_type = elgg_extract('widget_type', $vars);
$user_info_column = $num_columns;
$user = elgg_get_page_owner_entity();
$menu = elgg_extract('profile_menu', $vars, FALSE);

// $show_access = elgg_extract('show_access', $vars, true);

$entity_guid = elgg_extract('guid', $vars, false);
$entity = get_entity($entity_guid);

if (!elgg_instanceof($entity, 'object', 'role_dashboard_tab') && !elgg_instanceof($entity, 'object', 'role_profile_tab')) {
	echo elgg_echo('roles:error:widgetsnotfound');
	return;
}

$widget_types = elgg_get_widget_types($widget_type);

$context = $widget_type;
$show_access = false;

elgg_push_context('widgets');

$widgets = elgg_get_widgets($entity->guid, $context);

if (elgg_can_edit_widget_layout($context)) {
	if ($show_add_widgets) {
		echo elgg_view('page/layouts/widgets/add_button');
	}
	if ($show_add_panel) {
		$params = array(
			'widgets' => $widgets,
			'context' => $context,
			'exact_match' => true,
			'show_access' => $show_access,
		);
		echo elgg_view('page/layouts/widgets/add_panel', $params);
	}
}

$icon = elgg_view_entity_icon($user, 'large');

echo $vars['content'];

echo "<div class='elgg-layout clearfix {$class}'>";

if ($menu) {
	$menu_content = "<div class='roles-profile-user-avatar-block-menu'>{$menu}</div>";
}



if (!$user->bg_icontime) {
	$background_class = 'no-bg';
} else {
	$url = elgg_normalize_url(roles_get_user_background_url($user));
	$background_style = "style='background: url($url);'";
}

echo "<div class='roles-profile-user-avatar-block {$background_class}' {$background_style}>
	$icon
	$menu_content
</div>";

$widget_class = "elgg-col-1of{$num_columns}";
for ($column_index = 1; $column_index <= $num_columns; $column_index++) {
	if (isset($widgets[$column_index])) {
		$column_widgets = $widgets[$column_index];
	} else {
		$column_widgets = array();
	}

	echo "<div class=\"$widget_class elgg-widgets\" id=\"elgg-widget-col-$column_index\">";

	// Output the user info block (sort of like a persistent widget)
	if ($column_index == $user_info_column) {
		echo elgg_view('roles/profile/user', array('user' => $user));
	}

	if (sizeof($column_widgets) > 0) {
		foreach ($column_widgets as $widget) {
			if (array_key_exists($widget->handler, $widget_types)) {
				echo elgg_view_entity($widget, array('show_access' => $show_access));
			}
		}
	}
	echo '</div>';
}

echo "</div>";

elgg_pop_context();

echo elgg_view('graphics/ajax_loader', array('id' => 'elgg-widget-loader'));
