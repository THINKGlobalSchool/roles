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

// Init function 
elgg.roles.init = function() {
	// Remove confirmation click hander
	$('.elgg-requires-confirmation').die('click');
	
	// Click event for remove button
	$('a.remove-from-role').live('click', elgg.roles.remove_user);
}

elgg.roles.populated_module = function(event, type, params, value) {
	var roles_module = $('#role-list');
	roles_module.find('li.elgg-item').each(function() {
		// Extract guid from list item
		var id = $(this).attr('id');
		var guid = id.substring(id.lastIndexOf('-') + 1);
		
		$(this).bind('click', function() {
			// Spinner
			$('#user-list').addClass('elgg-ajax-loader');
			$('#user-list').html('');
			// Load
			elgg.get(elgg.roles.getUsersURL, {
				data: {guid: guid}, 
				success: function(data) {
					$('#user-list').removeClass('elgg-ajax-loader');
					$('#user-list').html(data);
				},
			});
		});
	});
}

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

elgg.register_hook_handler('init', 'system', elgg.roles.init);
elgg.register_hook_handler('populated', 'modules', elgg.roles.populated_module);
//</script>