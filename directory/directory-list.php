<?php
/*
Plugin Name: eFolio Directory List 
Plugin URI: http://www.baylor.edu/soe
Description: This plugin allow for displaying a directory of efolios on main site
Author: Kevin Sauer
Version: 0.1
Author URI: http://blogs.baylor.edu/kevin_sauer

Copyright 2015  Kevin Sauer  (email : Kevin_Sauer@Baylor.edu)

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

global $wp_version;

// Checks for Wordpress version
if ( !version_compare( $wp_version, '3.0', '>=' ) ) :
	
	die( 'You need at least version 3.0 of Wordpress to use the eFolio Directory List plugin!' );

endif;

// Function that writes to error log when plugin activated
function efolio_directory_list_plugin_activate() {
	
	error_log( 'eFolio Directory List plugin activated' );	

}

register_activation_hook( __FILE__, 'efolio_directory_list_plugin_activate' );

// Function that writes to error log when plugin deactivated
function efolio_directory_list_plugin_deactivate() {
	
	error_log( 'eFolio Directory List plugin deactivated' );	

}

register_deactivation_hook( __FILE__, 'efolio_directory_list_plugin_deactivate' );	

// Adds menu 
function efolio_directory_list_plugin_menu() {
	
	global $blog_id;

	if ( $blog_id == 1 ) {
	
		if ( is_admin() ) : 
			
			add_menu_page( 'Directory List Options', 'Directory List', 'manage_options', 'directory-list', 'efolio_directory_list_plugin_options', '
	dashicons-list-view' );
			
			add_action( 'admin_init', 'efolio_directory_list_plugin_register_settings' );	
		
		endif;
		
	}
	
}

add_action( 'admin_menu', 'efolio_directory_list_plugin_menu' );

// CACHING

// Updates the existing blogs cache
function efolio_directory_blogs_get_fresh() {
	
		// get blog list 
		$args = array(
			'network_id' => $wpdb->siteid,
			'public'     => NULL,
			'archived'   => 0,
			'mature'     => 0,
			'spam'       => 0,
			'deleted'    => 0,
			'limit'      => 10000,
			'offset'     => 0,
		);	
				
		$blogs = wp_get_sites( $args );
		
		$cache = $blogs;
		
		$option = 'efolio_directory_blogs_cache'; // Set option variable
		
		update_option( 'efolio_directory_blogs_cache', $cache, 'no' ); // Updates the option or adds option if doesn't exist
			
}

// Updates existing directory cache
function efolio_directory_get_fresh() {
	
	$directory = efolio_display_site_list();
	
	$cache = $directory;
	
	$option = 'efolio_directory_cache'; // Set option variable
		
	update_option( 'efolio_directory_cache', $cache, 'no' ); // Updates the option or adds option if doesn't exist
			
}

// Cache Refresh Cron, runs hourly
function efolio_directory_cron_activation() {
	
	if ( !wp_next_scheduled( 'efolio_directory_cron' ) ) {
		
		wp_schedule_event( current_time( 'timestamp' ), 'hourly', 'efolio_directory_cron');
	
	}

}

add_action('wp', 'efolio_directory_cron_activation');

// Function performed by cron
function efolio_directory_refresh() {
	
	efolio_directory_blogs_get_fresh();
	
	efolio_directory_get_fresh();

}

add_action('efolio_directory_cron', 'efolio_directory_refresh');

// Register settings
function efolio_directory_list_plugin_register_settings() { // whitelist options
  
  register_setting( 'efolio_directory_list_group', 'excluded_site_ids' );
  
}

// Options Form 
function efolio_directory_list_plugin_options() {
	
	// Checks user permissions
	if ( !current_user_can( 'manage_options' ) )  :
	
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	
	endif;	

?>		
	
    <div class="wrap">
	
    <h2>Directory List - Options</h2>
    
    <p>List of all sites not marked archived, mature, spam or deleted in alphabetical order by last name.</p>
	
    <form method="post" action="options.php">
    
	<?php settings_errors(); ?>
    
	<?php settings_fields( 'efolio_directory_list_group' ); ?>
    
	<?php do_settings_sections( 'efolio_directory_list_group' ); ?>
    
    <table class="form-table">
    
        <tr valign="top">
    
        <th scope="row">Exclude Sites:</th>
    
        <td>
        
        <?php
		
		$excluded = get_option( 'excluded_site_ids' );
		
		$option = 'efolio_directory_blogs_cache'; // Set option variable
	
		// Checks if option exists
		if( get_option( $option ) !== FALSE ) :
			
			$blogs =  get_option( $option ); // Pull list of sites from the options table
			
		else: // No option, fetch sites and store in option
			
			// get blog list 
			efolio_directory_blogs_get_fresh();
			
			$blogs = '';
			
		endif;
		
		//make sure there are still blogs left
		if ( $blogs !== '' ) {

			foreach ( $blogs as $blog ) {

				$sitedetails = get_blog_details($blog['blog_id']);
				
				if ( $sitedetails ) { //as long as blog exists display it with a checkbox
				
					// changes the site name to last name first name prior to sort
					$org_sitename = $sitedetails->blogname;
					
					// Format the site name last, first middle.
					$sitename_array = explode ( " ", $org_sitename );
					
					$last_name = array_pop( $sitename_array );
					
					$first_name = $sitename_array[0];
					
					$middle_name = $sitename_array[1];
					
					$sitename = $last_name . ", " . $first_name;
					
					if ( $middle_name ) {
					
						$sitename .= " " . $middle_name;
						
					}
				
					$siteArray[ $sitename ]['id']   = $sitedetails->blog_id;
				
					$siteArray[ $sitename ]['title'] = $sitedetails->blogname;
					
					$siteArray[ $sitename ]['name'] = $sitename; // last, first middle
				
					$siteArray[ $sitename ]['url']  = $sitedetails->siteurl;
					
					if ( is_array( $excluded) ) { //get array of excluded blog id's
				
						$excluded_id = $excluded;
					
					} else if (isset( $excluded )) {
					
						$excluded_id = unserialize( $excluded );
					
					} else {
					
						$excluded_id = array();
					
					}
	
					if ( is_array( $excluded_id ) && in_array( $blog['blog_id'], $excluded_id ) ) { //to check or not to check
					
						$siteArray[ $sitename ]['checked'] = "checked";
					
					} else {
					
						$siteArray[ $sitename ]['checked'] = "";
					
					}
				
				}
					
			}
	
			ksort( $siteArray ); //sort array
			
			//add sites to output string
			foreach ( $siteArray as $site => $value ) {		
		
				echo '<input type="checkbox" ' . $value['checked'] . ' name="excluded_site_ids[' . $value['id'] . ']" value="' . $value['id'] . '" id="' . $value['id'] . '" /> <a href="' . $value['url'] . '">' . $value['name']. '</a><br />';
					
				
			}
		
		} else {
			
			echo '<p>Site list is temporarily unavailable at this time.</p>';
		
		}
		?>
		
        <p>Put a checkmark below next to the sites you would like to remove from the directory list.</p>
        
        </td>
    
        </tr>
    
    </table>
    
    <?php submit_button(); ?>


	</form>

	</div>

<?php

}

/**
 * Create site list
 */
function efolio_display_site_list() {

	$output = '';
	
	$excluded = get_option( 'excluded_site_ids' ); 
	
	$option = 'efolio_directory_blogs_cache'; // Set option variable
	
	// Checks if option exists
	if( get_option( $option ) !== FALSE ) :
		
		$blogs =  get_option( $option ); // Pull list of sites from the options table
		
	else: // No option, fetch sites and store in option
		
		// get blog list 
		efolio_directory_blogs_get_fresh();
		
		$blogs = '';
		
	endif;
	
	//make sure there are blogs
	if ( $blogs !== '' ) {

		$output .= '<div id="mssls">'; //assign a div to make styling easier
		
		$siteArray = array(); //initial array of sites to display

		foreach ( $blogs as $blog ) {
			
			if ( is_array( $excluded ) ) { //get array of excluded blog id's
				
				$excluded_id = $excluded;
			
			} else if (isset($excluded)) {
			
				$excluded_id = unserialize( $excluded );
			
			} else {
			
				$excluded_id = array();
			
			}
			
			$sitedetails = get_blog_details($blog['blog_id']);
			
			if ( $sitedetails && ! in_array( $blog['blog_id'], $excluded_id ) ) { //if the blog exists and isn't on the exclusion list add it to array
			
				// changes the site name to last name first name prior to sort
				$org_sitename = $sitedetails->blogname;
			
				// Format the site name last, first middle.
				$sitename_array = explode ( " ", $org_sitename );
				
				$last_name = array_pop( $sitename_array );
				
				$first_name = $sitename_array[0];
				
				$middle_name = $sitename_array[1];
				
				$sitename = $last_name . ", " . $first_name;
				
				if ( $middle_name ) {
				
					$sitename .= " " . $middle_name;
					
				}
			
				$siteArray[ $sitename ]['id']   = $sitedetails->blog_id;
			
				$siteArray[ $sitename ]['title'] = $sitedetails->blogname;
			
				$siteArray[ $sitename ]['url']  = $sitedetails->siteurl;
			
				$siteArray[ $sitename ]['avatar']  = get_avatar(get_blog_option($sitedetails->blog_id, 'admin_email'));
			
			}
		}
		
		ksort( $siteArray ); //sort array

		//add sites to output string
		foreach ( $siteArray as $site => $value ) {		
		
			if ( preg_match("/^A/", $site ) ) {	
		
				$a .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^B/", $site ) ) {	
		
				$b .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^C/", $site ) ) {	
		
				$c .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^D/", $site ) ) {	
		
				$d .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^E/", $site ) ) {	
		
				$e .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^F/", $site ) ) {	
		
				$f .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^G/", $site ) ) {	
		
				$g .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^H/", $site ) ) {	
		
				$h .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^I/", $site ) ) {	
		
				$i .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^J/", $site ) ) {	
		
				$j .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^K/", $site ) ) {
		
				$k .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^L/", $site ) ) {	
		
				$l .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^M/", $site ) ) {	
		
				$m .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^N/", $site ) ) {	
		
				$n .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^O/", $site ) ) {	
		
				$o .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^P/", $site ) ) {	
		
				$p .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^Q/", $site ) ) {	
		
				$q .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^R/", $site ) ) {	
		
				$r .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^S/", $site ) ) {	
		
				$s .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^T/", $site ) ) {	
		
				$t .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^U/", $site ) ) {	
		
				$u .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^V/", $site ) ) {	
		
				$v .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^W/", $site ) ) {	
		
				$w .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^X/", $site ) ) {	
		
				$x .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^Y/", $site ) ) {	
		
				$y .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
			elseif ( preg_match("/^Z/", $site ) ) {	
		
				$z .= '<li><a href="' . $value['url'] . '">' . $value['avatar'] . $site . '</a></li>';
		
			}
		
		}
		
		$output .= '<ul id="student-nav">';
		$output .= '<li><a href="#a">A</a> |</li>' ;
		$output .= '<li><a href="#b">B</a> |</li>' ;
		$output .= '<li><a href="#c">C</a> |</li>' ;
		$output .= '<li><a href="#d">D</a> |</li>' ;
		$output .= '<li><a href="#e">E</a> |</li>' ;
		$output .= '<li><a href="#f">F</a> |</li>' ;
		$output .= '<li><a href="#g">G</a> |</li>' ;
		$output .= '<li><a href="#h">H</a> |</li>' ;
		$output .= '<li><a href="#i">I</a> |</li>' ;
		$output .= '<li><a href="#j">J</a> |</li>' ;
		$output .= '<li><a href="#k">K</a> |</li>' ;
		$output .= '<li><a href="#l">L</a> |</li>' ;
		$output .= '<li><a href="#m">M</a> |</li>' ;
		$output .= '<li><a href="#n">N</a> |</li>' ;
		$output .= '<li><a href="#o">O</a> |</li>' ;
		$output .= '<li><a href="#p">P</a> |</li>' ;
		$output .= '<li><a href="#q">Q</a> |</li>' ;
		$output .= '<li><a href="#r">R</a> |</li>' ;
		$output .= '<li><a href="#s">S</a> |</li>' ;
		$output .= '<li><a href="#t">T</a> |</li>' ;
		$output .= '<li><a href="#u">U</a> |</li>' ;
		$output .= '<li><a href="#v">V</a> |</li>' ;
		$output .= '<li><a href="#w">W</a> |</li>' ;
		$output .= '<li><a href="#x">X</a> |</li>' ;
		$output .= '<li><a href="#y">Y</a> |</li>' ;
		$output .= '<li><a href="#z">Z</a></li>' ;
		$output .= '</ul>' ;
		
		$output .= '<div id="alpha">';
		$output .= '<a id="a">A</a><a class="back" href="#content">Back to top</a><ul><hr />' . $a . '</ul>' ;
		$output .= '<a id="b">B</a><a class="back" href="#content">Back to top</a><ul><hr />' . $b . '</ul>' ;
		$output .= '<a id="c">C</a><a class="back" href="#content">Back to top</a><ul><hr />' . $c . '</ul>' ;
		$output .= '<a id="d">D</a><a class="back" href="#content">Back to top</a><ul><hr />' . $d . '</ul>' ;
		$output .= '<a id="e">E</a><a class="back" href="#content">Back to top</a><ul><hr />' . $e . '</ul>' ;
		$output .= '<a id="f">F</a><a class="back" href="#content">Back to top</a><ul><hr />' . $f . '</ul>' ;
		$output .= '<a id="g">G</a><a class="back" href="#content">Back to top</a><ul><hr />' . $g . '</ul>' ;
		$output .= '<a id="h">H</a><a class="back" href="#content">Back to top</a><ul><hr />' . $h . '</ul>' ;
		$output .= '<a id="i">I</a><a class="back" href="#content">Back to top</a><ul><hr />' . $i . '</ul>' ;
		$output .= '<a id="j">J</a><a class="back" href="#content">Back to top</a><ul><hr />' . $j . '</ul>' ;
		$output .= '<a id="k">K</a><a class="back" href="#content">Back to top</a><ul><hr />' . $k . '</ul>' ;
		$output .= '<a id="l">L</a><a class="back" href="#content">Back to top</a><ul><hr />' . $l . '</ul>' ;
		$output .= '<a id="m">M</a><a class="back" href="#content">Back to top</a><ul><hr />' . $m . '</ul>' ;
		$output .= '<a id="n">N</a><a class="back" href="#content">Back to top</a><ul><hr />' . $n . '</ul>' ;
		$output .= '<a id="o">O</a><a class="back" href="#content">Back to top</a><ul><hr />' . $o . '</ul>' ;
		$output .= '<a id="p">P</a><a class="back" href="#content">Back to top</a><ul><hr />' . $p . '</ul>' ;
		$output .= '<a id="q">Q</a><a class="back" href="#content">Back to top</a><ul><hr />' . $q . '</ul>' ;
		$output .= '<a id="r">R</a><a class="back" href="#content">Back to top</a><ul><hr />' . $r . '</ul>' ;
		$output .= '<a id="s">S</a><a class="back" href="#content">Back to top</a><ul><hr />' . $s . '</ul>' ;
		$output .= '<a id="t">T</a><a class="back" href="#content">Back to top</a><ul><hr />' . $t . '</ul>' ;
		$output .= '<a id="u">U</a><a class="back" href="#content">Back to top</a><ul><hr />' . $u . '</ul>' ;
		$output .= '<a id="v">V</a><a class="back" href="#content">Back to top</a><ul><hr />' . $v . '</ul>' ;
		$output .= '<a id="w">W</a><a class="back" href="#content">Back to top</a><ul><hr />' . $w . '</ul>' ;
		$output .= '<a id="x">X</a><a class="back" href="#content">Back to top</a><ul><hr />' . $x . '</ul>' ;
		$output .= '<a id="y">Y</a><a class="back" href="#content">Back to top</a><ul><hr />' . $y . '</ul>' ;
		$output .= '<a id="z">Z</a><a class="back" href="#content">Back to top</a><ul><hr />' . $z . '</ul>' ;
		$output .= '</div>';	
		$output .= '</div>';
		
	}
	
	return $output;
	
}

// Displays the directory
function efolio_directory() {
	
	// Checks if option exists
	$option = 'efolio_directory_cache'; // Set option variable
	
	// Checks if option exists
	if( get_option( $option ) !== FALSE ) :
		
		$directory =  get_option( $option ); // Pull directory from the options table
		
	else: // No option, fetch directory and store in option
	
		// get directory
		efolio_directory_get_fresh();
		
		$directory = '<p><strong>Directory is temporarily unavailable at this time.</strong></p>';
		
	endif;
	
	return $directory;
		
}

?>