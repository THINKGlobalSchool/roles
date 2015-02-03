<?php
/**
 * TGS Roles Tab List
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 * 
 */

$guid = elgg_extract('guid', $vars, NULL);
$subtype = elgg_extract('type', $vars);

$role = get_entity($guid);

if (!$role) {
	return;
}

elgg_push_context('role_tab_assignment');
set_input('role_guid', $guid);

$content = elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => $subtype,
	'limit' => 0,
	'full_view' => FALSE,
	'order_by_metadata' => array('name' => 'priority')
));

if (!$content) {
	$content = elgg_echo('roles:label:notabs');
}

$tabs_label = elgg_echo('admin:roles:tabs');
$tabs_module = elgg_view_module('inline', $tabs_label, $content, array('id' => 'tab-list'));	

echo <<<JAVASCRIPT
	<script type='text/javascript'>
		elgg.roles.initSortableTabs();
	</script>
JAVASCRIPT;
echo $tabs_module;
