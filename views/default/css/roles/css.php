<?php
/**
 * TGS Roles General CSS
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
?>
/** Roles homepage **/
.elgg-layout-one-sidebar-roles-home.border-top div#elgg-widget-col-2 {
	border-top: 2px solid #AAA;
}

.elgg-layout-one-sidebar-roles-home.border-top div#elgg-widget-col-1 {
	border-top: 2px solid #DDD;
}

.elgg-menu-role-tab-menu {
	background: none;
	margin-bottom: 0;
}

.elgg-layout-one-sidebar-roles-home .elgg-module-widget.elgg-state-draggable .elgg-widget-handle {
	cursor: default;
}

.elgg-layout-one-sidebar-roles-home .elgg-module-widget > .elgg-head h3 {
	padding: 4px 45px 0 14px;
}


/** Role profiles **/
.roles-profile-user-block {
	padding: 10px 0 10px 0;
	min-height: 200px;
}

.roles-profile-user-block:before,
.roles-profile-user-block:after {
  content:"";
  display:table;
}
.roles-profile-user-block:after {
  clear:both;
}
.roles-profile-user-block {
  zoom:1; /* For IE 6/7 (trigger hasLayout) */
}

.roles-profile-user-block-avatar-container {
	height: 200px;
	width: 200px;
	border: 1px solid #AAA;
	box-shadow: 0px 0px 4px #999;
	float: left;
}

.roles-profile-user-block-about-container {
	width: 780px;
	float: right;
}

.roles-profile-user-block-about-header {
	width: 100%;
	padding: 5px 2px 8px 2px;
	border-bottom: 1px solid #CCC;
}

.roles-profile-user-block-about-content {
	padding: 5px 2px 8px 2px;
}

.roles-profile-user-block-about-content .user-brief {
	color: #666;
	font-style: italic;
	padding-top: 3px;
}

.roles-profile-unavailable-field {
	font-style: italic;
	color: #AAA;
}

#user-about-excerpt, #user-about-full {
	color: #333;
}

.roles-profile-user-block-contact-container .contact-top, .roles-profile-user-block-contact-container .contact-bottom {
	width: 100%;
	font-weight: bold;
}

.roles-profile-user-block-contact-container .contact-top > div, .roles-profile-user-block-contact-container .contact-bottom > div {
	float: left;
	padding-right: 4px;
}

.roles-profile-user-block-contact-container .contact-top > div:after, .roles-profile-user-block-contact-container .contact-bottom > div:after {
	content: ' | ';
	color: #999;
}

.roles-profile-user-block-contact-container .contact-top > div:only-of-type:after, .roles-profile-user-block-contact-container .contact-bottom > div:only-of-type:after {
	content: none;
}

.roles-profile-user-block-contact-container .contact-top > div:last-child:after, .roles-profile-user-block-contact-container .contact-bottom > div:last-child:after {
	content: none;
}
.roles-profile-user-block-contact-container label:after {
	content: ' ';
}