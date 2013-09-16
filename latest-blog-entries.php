<?php
/*
Plugin Name: Latest Blog Entries
Author: Enrique Chávez
Author URI: http://enriquechavez.co
Version: 1.1
Description: Latest Blogs Entries is a very powerful section for Pagelines which displays your recent posts with thumbnail, excerpt, title, date and read more link . It’s the perfect solution to show specific entries on the home page or in any other page. With more that 15 options in general.
Class Name: TmLatestBlog
PageLines: true
*/

define( 'EC_STORE_URL', 'http://enriquechavez.co' );
add_action( 'admin_init', 'latest_check_for_updates' );

function latest_check_for_updates(){
	$item_name  = "Latest Blog Entries";
	$item_key = strtolower( str_replace(' ', '_', $item_name) );

	if( get_option( $item_key."_activated" )){
		if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			include( dirname( __FILE__ ) . '/sections/latest-blog-entries/inc/EDD_SL_Plugin_Updater.php' );
		}

		$license_key = trim( get_option( $item_key."_license", $default = false ) );

		$edd_updater = new EDD_SL_Plugin_Updater( EC_STORE_URL, __FILE__, array(
				'version' 	=> '1.1',
				'license' 	=> $license_key,
				'item_name' => $item_name,
				'author' 	=> 'Enrique Chavez'
			)
		);
	}
}
