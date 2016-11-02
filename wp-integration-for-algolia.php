<?php
/*
 * Plugin Name: Shifter Algolia
 * Version: 0.1.0
 * Plugin URI:https://github.com/getshifter/wp-integration-for-algolia
 * Description: Integration plugin between shifter and algolia
 * Author: hideokamoto
 * Author URI: https://go.getshifter.io/
 * License: GNU General Public License v2.0
 * Text Domain: shifter-algolia
 * @package shifter-algolia
 */

add_filter( 'algolia_post_shared_attributes', 'shifter_replace_algolia_permalink', 10, 2 );
add_filter( 'algolia_searchable_post_shared_attributes', 'shifter_replace_algolia_permalink', 10 ,2);
function shifter_replace_algolia_permalink(  $shared_attributes, $post  ){
	$replaced_domain = getenv( 'SHIFTER_DOMAIN' );
	if ( ! $replaced_domain ) {
		$replaced_domain =getenv( 'CF_DOMAIN' );
	}
	if ( $replaced_domain ) {
		$url = $shared_attributes['permalink'];
		$parsed_url = parse_url( $url );
		$replace_target = $parsed_url['host'];
		if ( isset( $parsed_url['port'] ) && $parsed_url['port'] ) {
			$replace_target .= ":{$parsed_url['port']}";
		}
		$shared_attributes['permalink'] = preg_replace( "#{$replace_target}#i", $replaced_domain, $url );
	}
	return $shared_attributes;
}
