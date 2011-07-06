<?php
/**
 * TGS Roles English Language Translation
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$english = array(
	// Generic
	'admin:users:roles' => 'Roles',
	'admin:users:addrole' => 'Add Role',
	'admin:users:viewrole' => 'View Role',
	'admin:users:editrole' => 'Edit Role',
	'roles:role' => 'Role',
	'item:object:role' => 'Roles',
	
	// Page titles 
	
	// Labels 
	'roles:label:new' => 'New Role',
	'roles:label:currentroles' => 'Current Roles',
	'roles:label:users' => 'Users',
	'roles:label:adduser' => 'Add User',
	'roles:label:nousers' => 'No users',
	'roles:label:username' => 'Username',
	'roles:label:hoveradd' => 'Set Role %s',
	
	// River
	
	// Messages
	'roles:error:requiredfields' => 'One or more required fields are missing',
	'roles:error:delete' => 'There was an error deleting the Role',
	'roles:error:edit' => 'There was an error editing the Role',
	'roles:error:save' => 'There was an error saving the Role',
	'roles:error:notfound' => 'Role not found',
	'roles:error:invaliduser' => 'Invalid User',
	'roles:error:invalidrole' => 'Invalid Role',
	'roles:error:remove' => 'There was an error removing the user from the role',
	'roles:error:add' => 'There was an error adding the user to the role',
	'roles:error:existing' => '%s is already a member of the role %s',
	'roles:success:add' => 'Successfully added user to role %s',
	'roles:success:remove' => 'Successfully removed user from role %s',
	'roles:success:save' => 'Successfully Saved Role',
	'roles:success:delete' => 'Successfully Deleted Role',
	'roles:removeconfirm' => 'Are you sure you want to remove this user from the role?',


	
	
	// Other content
);

add_translation('en',$english);
