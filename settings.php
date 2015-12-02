<?php 
add_action('admin_menu', 'register_bb_repost_setting_page');

function register_bb_repost_setting_page(){
	add_options_page('BB Repost Social Media','BB Repost', 'manage_options', 'bb_repost_options', 'bb_repost_options_page' );
	add_action('admin_init', 'register_bb_repost_options');
}

function bb_repost_options_page(){
	echo '<div class="wrap">'."\n";
	echo '<h2>BB Repost Settings</h2>'."\n";
	echo "<form action='options.php' method = 'post'>"."\n";
	echo "<label>Twitter : </label><input type='text' name='bb_repost_twitter' value='".get_option('bb_repost_twitter')."'><br>"."\n";
	submit_button();
	settings_fields('bb-repost-option-group');
	do_settings_fields('bb-repost-option-group');
	echo "</form>"."\n";
}

function register_bb_repost_options(){
	$fields = array('bb_repost_twitter' => 'twitter');
    foreach ($fields as $field => $value) {
        register_setting('bb-repost-option-group', $field);
        if (!empty($value) && !get_option($field)) {
            update_option($field, $value);
        }
    }
}