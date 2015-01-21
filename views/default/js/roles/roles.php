<?php
/**
 * TGS Roles JS Library
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
?>
//<script>
elgg.provide('elgg.roles');

elgg.roles.getUsersURL = 'roles/loadusers';
elgg.roles.getWidgetsURL = 'roles/loadwidgets';
elgg.roles.getTabsURL = 'roles/loadtabs';

// Init function 
elgg.roles.init = function() {
	// Remove confirmation click hander
	$('.elgg-requires-confirmation').die('click');
	
	// Click event for remove button
	$('a.remove-from-role').live('click', elgg.roles.remove_user);
	
	// Click event for add button
	$('.add-to-role').live('click', elgg.roles.add_user);

	// Init widget delete
	$('a.elgg-widget-delete-button').live('click', elgg.ui.widgets.remove);

	// Init roles assign button
	$('.roles-assign-tab, .roles-unassign-tab').live('click', elgg.roles.assign_tab);

	// Disable widget dragging on the home page
	$('.elgg-layout-one-sidebar-roles-home .elgg-widgets').sortable('disable');

	// Click handler for description show less link
	$('#user-about-showless').live('click', elgg.roles.showLessClick);

	// Click handler for description show more link
	$('#user-about-showmore').live('click', elgg.roles.showMoreClick);
}

elgg.roles.populated_module = function(event, type, params, value) {
	var $role_module = $('#role-list');
	$role_module.find('li.elgg-item').each(function() {
		// Extract guid from list item
		var id = $(this).attr('id');
		var guid = id.substring(id.lastIndexOf('-') + 1);
		
		$(this).bind('click', function(event) {
			if ($(event.target).parents(".elgg-menu-item-entity-actions").length == 0) {
				// Load users
				elgg.roles.load_users(guid);
			
				// Remove selected
				$role_module.find('li.elgg-item').each(function() {
					$(this).removeClass('role-state-selected');
				});
			
				// Select this role
				$(this).addClass('role-state-selected');
			}
		});
	});
}


elgg.roles.generic_populated_module = function(event, type, params, value) {
	var $tabs_module = $('#tab-list');
	var $role_module = $('#role-list');
	var $profile_module = $('#profile-list');

	if ($tabs_module.length > 0) {
		$tabs_module.find('li.elgg-item').each(function() {
			// Extract guid from list item
			var id = $(this).attr('id');
			var guid = id.substring(id.lastIndexOf('-') + 1);
			
			$(this).bind('click', function(event) {
				if ($(event.target).parents(".elgg-menu-item-entity-actions").length == 0) {
					elgg.roles.load_widgets(guid);

					// Remove selected
					$tabs_module.find('li.elgg-item').each(function() {
						$(this).removeClass('role-state-selected');
					});
				
					// Select this role
					$(this).addClass('role-state-selected');
				}
			});
		});
	} else if ($role_module.length > 0) {
		if ($role_module.hasClass('role-profile')) {
			var type = 'role_profile_tab';
		} else if ($role_module.hasClass('role-dashboard')) {
			var type = 'role_dashboard_tab';
		}

		$role_module.find('li.elgg-item').each(function() {
			// Extract guid from list item
			var id = $(this).attr('id');
			var id = $(this).attr('id');
			var guid = id.substring(id.lastIndexOf('-') + 1);
			
			$(this).bind('click', function(event) {
				if ($(event.target).parents(".elgg-menu-item-entity-actions").length == 0) {
					elgg.roles.load_tabs(guid, type);

					// Remove selected
					$role_module.find('li.elgg-item').each(function() {
						$(this).removeClass('role-state-selected');
					});
				
					// Select this role
					$(this).addClass('role-state-selected');
				}
			});
		});
	} else if ($profile_module.length > 0) {
		$profile_module.find('li.elgg-item').each(function() {
			// Extract guid from list item
			var id = $(this).attr('id');
			var guid = id.substring(id.lastIndexOf('-') + 1);
			
			$(this).bind('click', function(event) {
				if ($(event.target).parents(".elgg-menu-item-entity-actions").length == 0) {
					elgg.roles.load_widgets(guid);

					// Remove selected
					$profile_module.find('li.elgg-item').each(function() {
						$(this).removeClass('role-state-selected');
					});
				
					// Select this role
					$(this).addClass('role-state-selected');
				}
			});
		});
	}


}

// Load users by role
elgg.roles.load_users = function(role_guid) {
	// Spinner
	$('#user-list').addClass('elgg-ajax-loader');
	$('#user-list').html('');
	// Load
	elgg.get(elgg.roles.getUsersURL, {
		data: {guid: role_guid}, 
		success: function(data) {
			$('#user-list').removeClass('elgg-ajax-loader');
			$('#user-list').html(data);
		},
	});
}

// Load widgets by tab
elgg.roles.load_widgets = function(tab_guid) {
	// Spinner
	$('#widget-list-output').addClass('elgg-ajax-loader');
	$('#widget-list-output').html('');
	// Load
	elgg.get(elgg.roles.getWidgetsURL, {
		data: {guid: tab_guid}, 
		success: function(data) {
			$('#widget-list-output').removeClass('elgg-ajax-loader');
			$('#widget-list-output').html(data);

			// Bind addable widgets
			$('.elgg-widgets-add-panel li.elgg-state-available').bind(
				'click', 
				{tab_guid: tab_guid},
				elgg.roles.add_widget
			);

			// Init widgets sortable
			$(".elgg-widgets").sortable({
				items:                'div.elgg-module-widget.elgg-state-draggable',
				connectWith:          '.elgg-widgets',
				handle:               '.elgg-widget-handle',
				forcePlaceholderSize: true,
				placeholder:          'elgg-widget-placeholder',
				opacity:              0.8,
				revert:               500,
				stop:                 elgg.ui.widgets.move
			});
		},
	});
}

// Load tabs for role dashboards
elgg.roles.load_tabs = function(role_guid, type) {
	// Spinner
	$('#tab-list-output').addClass('elgg-ajax-loader');
	$('#tab-list-output').html('');
	// Load
	elgg.get(elgg.roles.getTabsURL, {
		data: {
			guid: role_guid,
			type: type
		}, 
		success: function(data) {
			$('#tab-list-output').removeClass('elgg-ajax-loader');
			$('#tab-list-output').html(data);
		},
	});
}

/**
 * Roles assign tab click handler
 */
elgg.roles.assign_tab = function(event) {
	var $_this = $(this);
	elgg.action($(this).attr('href'), {
		data: {},
		success: function(data) {
			if (data.status == -1) {
				// Error.. do nothing
			} else {
				// Switch links/classes
				if ($_this.hasClass('roles-assign-tab')) {
					// Replace classes
					$_this.removeClass('roles-assign-tab');
					$_this.addClass('roles-unassign-tab');

					// Replace text/title
					$_this.html(elgg.echo('remove'));
					$_this.attr('title', elgg.echo('remove'));

					// Replace link
				 	$_this.attr('href', $_this.attr('href').replace("roles/assigntab", "roles/unassigntab"));
				} else if ($_this.hasClass('roles-unassign-tab')) {
					// Replace classes
					$_this.removeClass('roles-unassign-tab');
					$_this.addClass('roles-assign-tab');

					// Replace text/title
					$_this.html(elgg.echo('add'));
					$_this.attr('title', elgg.echo('add'));

					// Replace link
					$_this.attr('href', $_this.attr('href').replace("roles/unassigntab", "roles/assigntab"));
				}
			}
		}
	});
	
	event.preventDefault();	
}

/**
 * Adds a new widget to given role
 */
elgg.roles.add_widget = function(event) {
	var tab_guid = event.data.tab_guid;

	// elgg-widget-type-<type>
	var type = $(this).attr('id');
	type = type.substr(type.indexOf('elgg-widget-type-') + "elgg-widget-type-".length);

	// if multiple instances not allow, disable this widget type add button
	var multiple = $(this).attr('class').indexOf('elgg-widget-multiple') != -1;
	if (multiple == false) {
		$(this).addClass('elgg-state-unavailable');
		$(this).removeClass('elgg-state-available');
		$(this).unbind('click', elgg.ui.widgets.add);
	}

	elgg.action('widgets/add', {
		data: {
			handler: type,
			owner_guid: tab_guid,
			context: $("input[name='widget_context']").val(),
			default_widgets: $("input[name='default_widgets']").val() || 0,
			show_access: '0'
		},
		success: function(json) {
			$('#elgg-widget-col-1').prepend(json.output);
		}
	});
	event.preventDefault();
};

// Click handler for remove links
elgg.roles.remove_user = function(event) {
	var confirmText = $(this).attr('rel') || elgg.echo('question:areyousure');
	if (confirm(confirmText)) {
		// Grab user ID and role ID
		var user_guid = $(this).attr('id');
		var role_guid = $(this).attr('name');
		var _this = $(this);

		elgg.action('roles/removeuser', {
			data: {
				user_guid: user_guid,
				role_guid: role_guid
			},
			success: function(data) {
				if (data.status == -1) {
					//console.log('error: ' + data.system_messages.error);
				} else {
					// Remove element from DOM
					_this.closest('div.elgg-image-block').fadeOut('slow');
				}
			}
		});
	} 
	event.preventDefault();
}

elgg.roles.add_user = function(event) {
	var data = $('#roles-add-user-form').serialize();
	var role_guid = $('#roles-add-user-form input[name=role_guid]').val();

	elgg.action('roles/adduser', {
		data: data,
		success: function(data) {
			if (data.status == -1) {
				//console.log('error: ' + data.system_messages.error);
			} else {
				elgg.roles.load_users(role_guid);
			}
		}
	});
	
	event.preventDefault();
}

/**
 * Click handler for description show less link
 */
elgg.roles.showLessClick = function(event) {
	$('#user-about-full').hide();
	$('#user-about-excerpt').show();
	event.preventDefault();
}

/**
 * Click handler for description show more link
 */
elgg.roles.showMoreClick = function(event) {
	$('#user-about-excerpt').hide();
	$('#user-about-full').show();
	event.preventDefault();
}

elgg.register_hook_handler('init', 'system', elgg.roles.init);
elgg.register_hook_handler('populated', 'modules', elgg.roles.populated_module);
elgg.register_hook_handler('generic_populated', 'modules', elgg.roles.generic_populated_module);