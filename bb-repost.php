<?php
/*
Plugin Name: BB Repost
Description: Provides a simple framework for reposting articles from other sites etc
Version: 1.0
Author: Brown Box
Author URI: http://brownbox.net.au
License: GPLv2
Copyright 2015 Brown Box
*/

include('classes/cpt_.php');
include('classes/meta_.php');
include('classes/tax_.php');
include('classes/tax_meta_.php');

include('ui.php');
include('settings.php');

new bb_repost\cptClass('Repost','Reposts', array('taxonomies' => array('post_tag')));

$fields = array(
		array(
				'title' => 'Source Article',
				'field_name' => 'source_article',
		),
		array(
				'title' => 'Source Excerpt',
				'field_name' => 'source_excerpt',
				'type' => 'textarea',
		),
		array(
				'title' => 'Twitter',
				'field_name' => 'twitter',
				'type' => 'checkbox',
		),
);
new bb_repost\metaClass('Reposts', array('repost'), $fields);

new bb_repost\taxClass('Source Type', 'Source Types', array('repost'));

$config = array(
        'id' => 'sourcetype_meta_box',          // meta box id, unique per meta box
        'title' => 'Source Type Meta',          // meta box title
        'pages' => array('sourcetype'),        // taxonomy name, accept categories, post_tag and custom taxonomies
        'local_images' => true,          // Use local or hosted images (meta box images for add/remove)
        'use_with_theme' => false,
);
$sourcetype_meta = new Tax_Meta_Class($config);
$sourcetype_meta->addText('tagline', array('name'=> 'Tag Line', 'desc' => 'Text to display at the bottom of each post'));
$sourcetype_meta->addImage('avatar', array('name' => 'Post Avatar', 'desc' => 'Custom avatar for this type of post. If left blank will use author avatar.'));
$sourcetype_meta->addImage('button_image', array('name' => 'Button Image', 'desc' => 'Custom button image for this type of post. If left blank will use plain HTML button.'));
$sourcetype_meta->Finish();

add_action( 'wp_enqueue_scripts', 'bb_repost_frontend_scripts' );
function bb_repost_frontend_scripts(){
	wp_enqueue_style( 'normalize', '/wp-content/plugins/bb-repost/css/normalize.css');
}

add_action('init', 'bb_repost_add_default_source_types', 10);
function bb_repost_add_default_source_types() {
	$inited = get_option('bb_repost_initialised');
	if (!$inited) {
		$terms = array(
				'We did this' => '',
				"We're listening to this" => 'Todays artist of the day is...',
				'We read this' => '',
				'We wrote this' => '',
		);

		foreach ($terms as $term => $description) {
			wp_insert_term($term, 'sourcetype', array('description' => $description));
		}

		update_option('bb_repost_initialised', true);
	}
}

