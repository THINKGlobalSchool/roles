<?php
/**
 * TGS Roles Profile User Block
 * 
 * @package TGSRoles
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2014
 * @link http://www.thinkglobalschool.com/
 * 
 * @uses $vars['user'] User entity
 */

$user = elgg_extract('user', $vars);

$icon = elgg_view_entity_icon($user, 'large');

$user_name = $user->name;

$unavailable = 'roles-profile-unavailable-field';

// Check for description
if ($user->description) {
	$user_about = elgg_view('output/longtext', array('value' => $user->description));

	// If the user description is quite a bit longer than an excerpt display a 'show more/show less' link
	$threshhold = 580;
	if (strlen($user_about) > $threshhold) {
		// Show more link for description excerpt
		$show_more = "<br />" . elgg_view('output/url', array(
			'text' => elgg_echo('roles:profile:showmore'),
			'href' => '#user-about-full',
			'id' => 'user-about-showmore' ,
		));

		// Excerpt
		$description_excerpt = elgg_view('output/longtext', array(
			'value' => roles_get_excerpt($user_about, ($threshhold - 200)) . $show_more,
			'class' => 'user-about',
			'id' => 'user-about-excerpt',
		));

		// Show less link for description full
		$show_less = elgg_view('output/url', array(
			'text' => elgg_echo('roles:profile:showless'),
			'href' => '#user-about-excerpt',
			'id' => 'user-about-showless' ,
		));

		$hide = 'display: none;';
	}

	// Full description
	$description_full = elgg_view('output/longtext', array(
		'value' => $user->description . $show_less,
		'class' => 'user-about',
		'id' => 'user-about-full',
		'style' => $hide,
	));

	$user_about = $description_excerpt . $description_full;
} else {
	$user_about = elgg_echo('roles:profile:nodescription');
	$user_about_class = $unavailable;
}

$user_link = elgg_view('output/url', array(
	'text' => $user_name,
	'value' => $user->getURL()
));

$user_brief = $user->briefdescription;

// Check for contact values
if ($user->twitter) {
	$twitter_label = elgg_echo('roles:profile:twitter');
	$twitter_url = "https://twitter.com/{$user->twitter}";
	$twitter_link = elgg_view('output/url', array(
		'text' => $twitter_url,
		'value' => $twitter_url
	));
	$twitter = "<div><label>{$twitter_label}</label>$twitter_link</div>";
}

if ($user->website) {
	$website_label = elgg_echo('roles:profile:website');
	$website_link = elgg_view('output/url', array(
		'text' => $user->website,
		'value' => $user->website
	));
	$website = "<div><label>{$website_label}</label>$website_link</div>";
}

if ($user->email) {
	$email_label = elgg_echo('roles:profile:email');
	$email_link = elgg_view('output/url', array(
		'text' => $user->email,
		'value' => $user->email
	));
	$email = "<div><label>{$email_label}</label>$email_link</div>";
}

if ($user->phone) {
	$phone_label = elgg_echo('roles:profile:phone');
	$phone_link = elgg_view('output/url', array(
		'text' => $user->phone,
		'value' => $user->phone
	));
	$phone = "<div><label>{$phone_label}</label>$phone_link</div>";
}

if ($user->mobile) {
	$mobile_label = elgg_echo('roles:profile:mobile');
	$mobile_link = elgg_view('output/url', array(
		'text' => $user->mobile,
		'value' => $user->mobile
	));
	$mobile = "<div><label>{$mobile_label}</label>$mobile_link</div>";
}

$content = <<<HTML
	<div class='roles-profile-user-block'>
		<div class='roles-profile-user-block-avatar-container'>
			$icon
		</div>
		<div class='roles-profile-user-block-about-container'>
			<div class='roles-profile-user-block-about-header'>
				<h1>$user_link</h1>
			</div>
			<div class='roles-profile-user-block-about-meta'></div>
			<div class='roles-profile-user-block-about-content $user_about_class'>
				<div class='user-brief'>$user_brief</div>
				$user_about
			</div>
			<div class='roles-profile-user-block-contact-container'>
				<div class='contact-top'>
					$twitter$website
				</div>
				<div class='clearfix'>
				</div>
				<div class='contact-bottom'>
					$phone$mobile$email
				</div>
			</div>
		</div>
	</div>
HTML;

echo $content;
