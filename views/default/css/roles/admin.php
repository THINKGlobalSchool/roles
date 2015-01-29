<?php
/**
 * TGS Roles Admin CSS
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
?>
li.elgg-item {
	border-bottom: 1px solid #ddd;
	margin: 0;
}

li.elgg-item:hover {
	background: #eee;
}

.roles-module {
	width: 47%;
	float: left;
}

.roles-widget-module {
	/*width: 100%;*/
}

#user-list, #tab-list-output {
	padding-left: 5px;
}

.elgg-menu-user-role-menu {
	color: #AAAAAA;
    float: right;
    font-size: 90%;
    margin-left: 15px;
}

.role-state-selected, .role-state-selected:hover {
	background: #ccc !important;
}

#widget-list-output #widgets-add-panel.hidden {
	display: block;
}

#tab-list-output .elgg-menu-item-add a,
#tab-list-output .elgg-menu-item-remove a {
	color: #FFFFFF;
}

/** Draggable stuff **/
#profile-list li.elgg-state-draggable, #tab-list li.elgg-state-draggable {
	cursor: move;
}
