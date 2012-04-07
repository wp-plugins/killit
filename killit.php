<?php
/*
Plugin Name: Killit
Plugin URI: http://thebyob.com/killit
Description: Killit disables all WordPress auto-formatting. Similar to the popular Raw HTML plugin but applies the effect to all posts and pages automatically.
Version: 1.0
Author: Josh Davis
Author URI: http://josh.isthecatsmeow.com/
*/

/*  Copyright 2012  Josh Davis

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function register_mysettings() {
	$setting_vars = array(
		'autop',
		'texturize',
		'chars',
		'smilies',
		'wpexcerpt',
		'wpcontent'
		);
	foreach ( $setting_vars as $setting_var ){
		$old_option = get_option( $setting_var );
		register_setting( 'killit_son', $setting_var );
		update_option( $setting_var, '1' );
		update_option( $setting_var, $old_option );
	}
}
add_action( 'admin_init', 'register_mysettings' );

function killit_menu() {
	add_options_page( 'Killit Settings', 'Killit', 'manage_options', 'killit_uid', 'killit_options' );
}

function killit_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap"><h2>Killit Settings</h2><form method="post" action="options.php">';
	settings_fields('killit_son');
?>

<style>.wrap form td span{color:#888;} .wrap legend{font-size:13px; font-weight:bold; margin-left:-5px;} .wrap fieldset{margin:10px 0px; padding:15px; padding-top:0px; border:1px solid #ccc;}</style>
<fieldset>
	<legend>Remove this formatting:</legend>
	<table class="form-table">
		<tr><td><input type="checkbox" name="autop" value="1" <?php checked( '1', get_option( 'autop' ) ); ?> /> wpautop <span>- Replaces line breaks with &lt;p&gt; &amp; &lt;br /&gt; tags</span></td></tr>
        	<tr><td><input type="checkbox" name="texturize" value="1" <?php checked( '1', get_option( 'texturize' ) ); ?> /> wptexturize <span>- Transforms dashes, quotes, and symbols</span></td></tr>
        	<tr><td><input type="checkbox" name="chars" value="1" <?php checked( '1', get_option( 'chars' ) ); ?> /> convert_chars <span>- Removes metadata and replaces &lt;br&gt; &amp; &lt;hr&gt; tags into correct XHTML and Unicode characters</span></td></tr>
        	<tr><td><input type="checkbox" name="smilies" value="1" <?php checked( '1', get_option( 'smilies' ) ); ?> /> convert_smilies <span>- Converts text equivalent of smilies to images</span></td></tr>
	</table>
</fieldset>
<fieldset>
	<legend>from these places:</legend>
	<table class="form-table">
		<tr><td><input type="checkbox" name="wpexcerpt" value="1" <?php checked( '1', get_option( 'wpexcerpt' ) ); ?> /> the_excerpt <span>- The excerpt</span></td></tr>
		<tr><td><input type="checkbox" name="wpcontent" value="1" <?php checked( '1', get_option( 'wpcontent' ) ); ?> /> the_content <span>- The content</span></td></tr>
	</table>
</fieldset>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

<?php
	echo '</form></div>';
}
add_action( 'admin_menu', 'killit_menu' );

function killit_formatting_filters(){
	$filters = array();
	if ( get_option('autop') == 1) {
		$filters[] = 'wpautop';
	}
	if ( get_option('texturize') == 1) {
		$filters[] = 'wptexturize';
	}
	if ( get_option('chars') == 1) {
		$filters[] = 'convert_chars';
	}
	if ( get_option('smilies') == 1) {
		$filters[] = 'convert_smilies';
	}
	$places = array();
	if ( get_option('wpexcerpt') == 1) {
		$places[] = 'the_excerpt';
	}
	if ( get_option('wpcontent') == 1) {
		$places[] = 'the_content';
	}
	foreach ($places as $place){
		foreach ($filters as $filter){
			remove_filter($place,$filter);
		}
	}
}
add_action('init', 'killit_formatting_filters');

?>
