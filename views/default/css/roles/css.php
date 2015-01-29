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
}

.elgg-layout-one-sidebar-roles-home.border-top div#elgg-widget-col-1 {
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
	padding: 45px 15px 15px 15px;
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

.roles-profile-user-avatar-block {
	margin: 0 10px 15px;
	height: 200px;
	width: 968px;
	border-color: #ccc;
	border-style: solid;
	border-width: 0 1px 2px;
	position: relative;
}

.roles-profile-user-avatar-block:hover #edit-background-profile {
	display: block;
	top:  150px;
	right: 20px;
}

.no-bg {
-webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box;
  -o-text-overflow: clip;
  text-overflow: clip;
  background: -webkit-linear-gradient(60deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), -webkit-linear-gradient(-60deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), -webkit-linear-gradient(60deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), -webkit-linear-gradient(-60deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), -webkit-linear-gradient(30deg, rgb(187,187,187) 25%, rgba(0,0,0,0) 25.5%, rgba(0,0,0,0) 75%, rgb(187,187,187) 75%, rgb(187,187,187) 0), -webkit-linear-gradient(30deg, rgb(187,187,187) 25%, rgba(0,0,0,0) 25.5%, rgba(0,0,0,0) 75%, rgb(187,187,187) 75%, rgb(187,187,187) 0), rgb(170, 170, 170);
  background: -moz-linear-gradient(30deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), -moz-linear-gradient(150deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), -moz-linear-gradient(30deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), -moz-linear-gradient(150deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), -moz-linear-gradient(60deg, rgb(187,187,187) 25%, rgba(0,0,0,0) 25.5%, rgba(0,0,0,0) 75%, rgb(187,187,187) 75%, rgb(187,187,187) 0), -moz-linear-gradient(60deg, rgb(187,187,187) 25%, rgba(0,0,0,0) 25.5%, rgba(0,0,0,0) 75%, rgb(187,187,187) 75%, rgb(187,187,187) 0), rgb(170, 170, 170);
  background: linear-gradient(30deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), linear-gradient(150deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), linear-gradient(30deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), linear-gradient(150deg, rgb(153,153,153) 12%, rgba(0,0,0,0) 12.5%, rgba(0,0,0,0) 87%, rgb(153,153,153) 87.5%, rgb(153,153,153) 0), linear-gradient(60deg, rgb(187,187,187) 25%, rgba(0,0,0,0) 25.5%, rgba(0,0,0,0) 75%, rgb(187,187,187) 75%, rgb(187,187,187) 0), linear-gradient(60deg, rgb(187,187,187) 25%, rgba(0,0,0,0) 25.5%, rgba(0,0,0,0) 75%, rgb(187,187,187) 75%, rgb(187,187,187) 0), rgb(170, 170, 170);
  background-position: 0 0, 0 0, 40px 70px, 40px 70px, 0 0, 40px 70px;
  -webkit-background-origin: padding-box;
  background-origin: padding-box;
  -webkit-background-clip: border-box;
  background-clip: border-box;
  -webkit-background-size: 80px 140px;
  background-size: 80px 140px;
  height: 200px;
}

.roles-profile-user-avatar-block .roles-profile-user-avatar-block-menu {
	margin-left: 230px;
    position: relative;
    top: -37px;
}

.roles-profile-user-avatar-block .elgg-avatar {
	background: none repeat scroll 0 0 #fff;
    border: 1px solid #aaa;
    box-shadow: 0 0 2px #aaa;
    margin: 0 15px;
    padding: 2px;
    position: relative;
    top: 60px;
    width: 200px;
    z-index: 1000;
}

.roles-profile-user-block-about-container {

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
	padding-top: 10px;
}

.roles-profile-unavailable-field {
	font-style: italic;
	color: #AAA;
}

#user-about-excerpt, #user-about-full {
	color: #333;
}

.roles-profile-user-block-contact-container {
	width: 100%;
	font-weight: bold;
}

.roles-profile-user-block-contact-container label:after {
	content: ' ';
}

/** Profile Background Photo **/
#current-user-background {
	border-right:1px solid #ccc;
}

#user-background-preview {
	float: left;
	position: relative;
	overflow: hidden;
	height: 156px;
	width: 720px;
}

#user-background-preview-canvas {
	height: 156px;
	width: <?php echo PROFILE_BACKGROUND_PREVIEW_WIDTH; ?>px;
}

#current-user-background {
	height: 156px;
}

img#user-background-cropper {
	max-width: <?php echo PROFILE_BACKGROUND_PREVIEW_WIDTH; ?>px;
}

#current-user-background.upload-no-bg img {
	width: auto;
}

#edit-background-profile {
	display: none;
	position: absolute;
	z-index: 1000;
}