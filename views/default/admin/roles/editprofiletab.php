<?php
/**
 * TGS Roles Edit Role Profile Form
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
elgg_load_css('elgg.roles.admin');
echo roles_dashboard_profile_get_edit_content('edit', get_input('guid'));

