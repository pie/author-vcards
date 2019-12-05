<?php
/**
 * Plugin Name: Author VCards
 * Plugin URI:  #
 * Version:     1.0.0
 * Author:      The team at PIE
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function makeplugins_add_vcard_endpoint() {
    add_rewrite_endpoint( 'vcf', EP_AUTHORS );
}
add_action( 'init', 'makeplugins_add_vcard_endpoint' );

function makeplugins_json_template_redirect() {
    global $wp_query;

    // if this is not a request for json or a singular object then bail
    if ( ! isset( $wp_query->query_vars['vcf'] ) || ! is_author() )
        return;

    // include custom template
    include dirname( __FILE__ ) . '/vcf-template.php';
    exit;
}
add_action( 'template_redirect', 'makeplugins_json_template_redirect' );