<?php

/**
 * Plugin Name: Author VCards
 * Plugin URI:  https://github.com/pie/author-vcards/
 * Version:     1.1.0
 * Author:      The team at PIE
 */
namespace PIE\AuthorVcards;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Load Composer autoloader
 */

require_once __DIR__ . '/vendor/autoload.php';
$update_checker = \Puc_v4_Factory::buildUpdateChecker(
    'http://212.71.239.229/releases/plugins/author-vcards/release-data.json',
    __FILE__,
    'author-vcards'
);

function add_vcard_endpoint()
{
    add_rewrite_endpoint('vcf', EP_AUTHORS);
}
add_action('init', __NAMESPACE__ . '\add_vcard_endpoint');

function json_template_redirect()
{
    global $wp_query;

    // if this is not a request for json or a singular object then bail
    if (! isset($wp_query->query_vars['vcf']) || ! is_author()) {
        return;
    }

    // include custom template
    include dirname(__FILE__) . '/vcf-template.php';
    exit;
}
add_action('template_redirect', __NAMESPACE__ . '\json_template_redirect');