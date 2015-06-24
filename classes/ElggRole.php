<?php
/**
 * TGS Roles Class
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

class ElggRole extends ElggObject {
	/**
	 * Set subtype to 'role'.
	 *
	 * @return void
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "role";
	}
	
	/**
	 * Loads an ElggRole entity
	 *
	 * @param int $guid GUID of the ElggRole object
	 */
	public function __construct($guid = null) {
		parent::__construct($guid);
	}
	
	/**
	 * Get a list of role members.
	 *
	 * @param int  $limit  Limit
	 * @param int  $offset Offset
	 * @param bool $count  Count
	 *
	 * @return mixed
	 */
	public function getMembers($limit = 10, $offset = 0, $count = false, $alphabetical = false) {
		return roles_get_members($this->getGUID(), $limit, $offset, 0, $count, $alphabetical);
	}

	/**
	 * Return whether a given user is a member of this role or not.
	 *
	 * @param ElggUser $user The user
	 *
	 * @return bool
	 */
	public function isMember($user = 0) {
		if (!($user instanceof ElggUser)) {
			$user = elgg_get_logged_in_user_entity();
		}
		if (!($user instanceof ElggUser)) {
			return false;
		}
		return roles_is_member($this->getGUID(), $user->getGUID());
	}

	/**
	 * Add an elgg user to this role.
	 *
	 * @param ElggUser $user User
	 *
	 * @return bool
	 */
	public function add(ElggUser $user) {
		return roles_add_user($this->getGUID(), $user->getGUID());
	}

	/**
	 * Remove a user from the role.
	 *
	 * @param ElggUser $user User
	 *
	 * @return void
	 */
	public function remove(ElggUser $user) {
		return roles_remove_user($this->getGUID(), $user->getGUID());
	}
}