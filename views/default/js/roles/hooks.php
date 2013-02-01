<?php
/**
 * TGS Roles Global JS Hooks Library
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

elgg.provide('elgg.roles_hooks');

// Hook into tidypics listing filters to provide roles input
elgg.roles_hooks.initTidypicsRoleFilter = function(event, type, params, value) {
	$('select#photos-listing-role-input').change(function() {
		elgg.tidypics.filterListings();
	});
}

elgg.register_hook_handler('initListingFilters', 'tidypics', elgg.roles_hooks.initTidypicsRoleFilter);