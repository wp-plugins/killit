<?php
/*
Plugin Name: Killit
Plugin URI: http://thebyob.com/killit
Description: Killit disables all WordPress auto-formatting. Similar to the popular Raw HTML plugin but applies the effect to all posts and pages automatically.
Version: 0.5
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

function killit_formatting_filters(){
	$types = array(
		'wpautop',
		'wptexturize',
		'convert_chars',
		'convert_smilies',
	);
	$filters = array(
		'the_content' => $types,
		'the_excerpt' => $types,
	);
	
	foreach ( $filters as $tag => $functions ){
		foreach ( $functions as $func ){
			remove_filter($tag, $func);
		}
	}
}
add_action('init', 'killit_formatting_filters');

?>
