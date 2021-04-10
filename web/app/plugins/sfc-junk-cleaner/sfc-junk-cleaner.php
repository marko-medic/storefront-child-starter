<?php
/*
Plugin Name: SFC Junk Cleaner
Description: Core SFC Junk Cleaner Plugin
Version: 1.0.0
Text Domain: sfc
Author: Marko Medic
*/

if (!defined("WPINC")) {
    die;
}

/*Removes RSD, XMLRPC, WLW, WP Generator, ShortLink and Comment Feed links*/
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);


function sfc_deregister_styles()
{
    // gutenberg block library
    wp_dequeue_style('wp-block-library'); // WordPress core
    wp_dequeue_style('wp-block-library-theme'); // WordPress core
}


function sfc_deregister_scripts()
{
    wp_deregister_script('wp-embed');
}
 
// Disable emojis

function sfc_disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
    if ('dns-prefetch' == $relation_type) {
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
        $urls = array_diff($urls, array($emoji_svg_url));
    }
    return $urls;
}

function sfc_disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

add_filter('tiny_mce_plugins', 'sfc_disable_emojis_tinymce');
add_filter('wp_resource_hints', 'sfc_disable_emojis_remove_dns_prefetch', 10, 2);

add_action('wp_enqueue_scripts', 'sfc_deregister_styles', 100);
add_action('wp_enqueue_scripts', 'sfc_deregister_scripts');
