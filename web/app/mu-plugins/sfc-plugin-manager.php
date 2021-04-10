<?php

/**
 * @package sfc-plugin-manager
 * @version 1.0
 *
 * Plugin Name: SFC Plugin Manager
 * Plugin URI: http://wordpress.org/extend/plugins/#
 * Description: This is a development plugin 
 * Author: Marko Medic
 * Version: 1.0
 */

add_shortcode(
    'sfc_active_plugins',
    function () {

        $active_plugins = get_option('active_plugins');
        $plugins = "";
        if (count($active_plugins) > 0) {
            $plugins = "<ul>";
            foreach ($active_plugins as $plugin) {
                $plugins .= "<li>" . $plugin . "</li>";
            }
            $plugins .= "</ul>";
        }
        return $plugins;
    }
);

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$is_admin = strpos($_SERVER["REQUEST_URI"], '/wp-admin/') !== false;
$is_customizer = strpos($_SERVER["REQUEST_URI"], 'customize_theme') !== false;

if (!$is_admin and !$is_customizer) {

    // filter active plugins
    add_filter(
        'option_active_plugins',
        function ($plugins) {
            global $request_uri;
            // only admin plugins
            $admin_plugins = array("wp-phpmyadmin-extension/index.php");

            // woocommerce plugins to disable
            $woocom_plugins_to_disable = array(
                "woocommerce/woocommerce.php",
            );

            $woocom_pages = array("products", "cart", "checkout", "my-account");
            $page_slug = substr($request_uri, 1, strlen($request_uri) - 2);

            $all_pages_slug = array_map(
                function ($page) {
                    return $page->post_name;
                },
                get_pages()
            );

            $is_woocom_page = in_array($page_slug, $woocom_pages);
            $is_extra_page = !in_array($page_slug, $all_pages_slug); // $is_extra_page is often single product page or 404
            $is_home_page = $request_uri === '/';
            $is_contact_page = strpos($page_slug, 'contact') !== false;

            if (!$is_contact_page) {
                $woocom_plugins_to_disable[] = "contact-form-7/wp-contact-form-7.php";
            }


            // unload plugins on non woocom pages (products, product, cart,...)
            if ((!$is_woocom_page and !$is_extra_page) or $is_home_page) {
                $plugins = array_diff($plugins, $woocom_plugins_to_disable);
            }

            // unload admin only plugins
           foreach ($plugins as $key => $plugin) {
               if (in_array($plugin, $admin_plugins)) {
                   unset($plugins[$key]);
               }
           }
           
            return $plugins;
        }
    );
}

// Removing plugin controls from admin
function sfc_remove_plugin_controls($actions, $plugin_file, $plugin_data, $context){
 
 
    if (array_key_exists('edit', $actions)) {
      unset($actions['edit']);
    }
   
    if (array_key_exists('deactivate', $actions)) {
        unset($actions['deactivate']);
    }
   
    if (array_key_exists('activate', $actions)) {
      unset($actions['activate']);
    }
   
    if (array_key_exists('delete', $actions)) {
      unset($actions['delete']);
    }
   
    return $actions;
   
  }
  add_filter('plugin_action_links', 'sfc_remove_plugin_controls', 10, 4);
  
  
  // Remove bulk action options for managing plugins
  function sfc_disable_bulk_actions($actions){
   
    if (array_key_exists('deactivate-selected', $actions)) {
      unset($actions['deactivate-selected']);
    }
   
   
    if (array_key_exists('activate-selected', $actions)) {
      unset($actions['activate-selected']);
    }
   
   
    if (array_key_exists('delete-selected', $actions)) {
      unset($actions['delete-selected']);
    }
   
   
    if (array_key_exists('update-selected', $actions)) {
      unset($actions['update-selected']);
    }
    
  }
  add_filter('bulk_actions-plugins','sfc_disable_bulk_actions');