<?php

/*
Plugin Name: Dynamic Menu Logo Switcher
Description: Automatically switch website logos based on active navigation menus. Perfect for multi-brand sites, different sections, or dynamic branding needs.
Version: 2.0.0
Author: Deeb Al Turk
Plugin URI: https://github.com/deeb-al-turk/dynamic-menu-logo-switcher
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
License: Free for everyone
License URI: https://github.com/deeb-al-turk/dynamic-menu-logo-switcher
Network: false
*/

if (!defined('ABSPATH')) exit;

class CustomLogoBasedMenu {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'save_settings'));
        add_action('wp_head', array($this, 'output_custom_logo'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'settings_page_menu-logo-settings') return;
        wp_enqueue_media();
    }
    
    public function add_admin_menu() {
        add_options_page('Menu Logo Settings', 'Menu Logos', 'manage_options', 'menu-logo-settings', array($this, 'admin_page'));
    }
    
    public function admin_page() {
        $menus = wp_get_nav_menus();
        $settings = get_option('menu_logo_settings', array());
        $selected_menu = isset($_GET['menu_id']) ? intval($_GET['menu_id']) : 0;
        
        echo '<div class="wrap">';
        echo '<h1><span class="dashicons dashicons-format-image"></span> Menu Logo Settings</h1>';
        echo '<p class="description">Set custom logos for different menus. The logo will automatically change based on which menu is displayed on each page.</p>';
        
        // Overview table
        if (!empty($settings)) {
            echo '<div class="card" style="margin: 20px 0;">';
            echo '<h2>Current Logo Settings</h2>';
            echo '<table class="wp-list-table widefat fixed striped">';
            echo '<thead><tr><th>Menu</th><th>Logo Preview</th><th>Actions</th></tr></thead><tbody>';
            
            foreach ($menus as $menu) {
                if (isset($settings[$menu->term_id]) && !empty($settings[$menu->term_id])) {
                    echo '<tr>';
                    echo '<td><strong>' . esc_html($menu->name) . '</strong></td>';
                    echo '<td><img src="' . esc_url($settings[$menu->term_id]) . '" style="max-width:100px;max-height:50px;" /></td>';
                    echo '<td><a href="?page=menu-logo-settings&menu_id=' . $menu->term_id . '" class="button">Edit</a></td>';
                    echo '</tr>';
                }
            }
            echo '</tbody></table></div>';
        }
        
        // Menu selection
        echo '<div class="card">';
        echo '<h2>Add/Edit Menu Logo</h2>';
        echo '<form method="get" style="margin-bottom: 20px;">';
        echo '<input type="hidden" name="page" value="menu-logo-settings">';
        echo '<table class="form-table"><tr><th scope="row"><label for="menu_id">Select Menu:</label></th><td>';
        echo '<select name="menu_id" id="menu_id" onchange="this.form.submit()" class="regular-text">';
        echo '<option value="0">-- Choose a Menu --</option>';
        foreach ($menus as $menu) {
            $selected = ($selected_menu == $menu->term_id) ? 'selected' : '';
            echo '<option value="' . $menu->term_id . '" ' . $selected . '>' . esc_html($menu->name) . '</option>';
        }
        echo '</select></td></tr></table></form>';
        
        // Logo configuration for selected menu
        if ($selected_menu > 0) {
            $menu_name = '';
            foreach ($menus as $menu) {
                if ($menu->term_id == $selected_menu) {
                    $menu_name = $menu->name;
                    break;
                }
            }
            $logo_url = isset($settings[$selected_menu]) ? $settings[$selected_menu] : '';
            
            echo '<form method="post">';
            wp_nonce_field('menu_logo_nonce');
            echo '<input type="hidden" name="menu_id" value="' . $selected_menu . '">';
            echo '<h3>Configure Logo for: ' . esc_html($menu_name) . '</h3>';
            echo '<table class="form-table">';
            echo '<tr><th scope="row"><label for="logo_url">Logo URL:</label></th><td>';
            echo '<input type="url" name="logo_url" id="logo_url" value="' . esc_url($logo_url) . '" class="regular-text" placeholder="https://example.com/logo.png">';
            echo '<button type="button" class="button" onclick="openMediaUploader()">Choose Image</button>';
            echo '<p class="description">Enter the URL of your logo image or use the media uploader.</p>';
            echo '</td></tr>';
            
            if (!empty($logo_url)) {
                echo '<tr><th scope="row">Preview:</th><td>';
                echo '<img id="logo-preview" src="' . esc_url($logo_url) . '" style="max-width:200px;max-height:100px;border:1px solid #ddd;padding:10px;background:#f9f9f9;" />';
                echo '</td></tr>';
            }
            
            echo '</table>';
            echo '<p class="submit"><input type="submit" name="save_menu_logo" value="Save Logo" class="button-primary"> ';
            if (!empty($logo_url)) {
                echo '<input type="submit" name="remove_menu_logo" value="Remove Logo" class="button-secondary" onclick="return confirm(\'Are you sure you want to remove this logo?\')">';
            }
            echo '</p></form>';
        }
        
        echo '</div></div>';
        
        // Media uploader script
        echo '<script>
        function openMediaUploader() {
            var mediaUploader = wp.media({
                title: "Choose Logo Image",
                button: { text: "Use This Image" },
                multiple: false
            });
            mediaUploader.on("select", function() {
                var attachment = mediaUploader.state().get("selection").first().toJSON();
                document.getElementById("logo_url").value = attachment.url;
                updatePreview(attachment.url);
            });
            mediaUploader.open();
        }
        function updatePreview(url) {
            var preview = document.getElementById("logo-preview");
            if (preview) {
                preview.src = url;
            } else {
                var previewRow = document.querySelector(".form-table");
                previewRow.innerHTML += "<tr><th scope=\"row\">Preview:</th><td><img id=\"logo-preview\" src=\"" + url + "\" style=\"max-width:200px;max-height:100px;border:1px solid #ddd;padding:10px;background:#f9f9f9;\" /></td></tr>";
            }
        }
        </script>';
    }
    
    public function save_settings() {
        if (isset($_POST['save_menu_logo']) && wp_verify_nonce($_POST['_wpnonce'], 'menu_logo_nonce')) {
            $menu_id = intval($_POST['menu_id']);
            $logo_url = esc_url_raw($_POST['logo_url']);
            $settings = get_option('menu_logo_settings', array());
            $settings[$menu_id] = $logo_url;
            update_option('menu_logo_settings', $settings);
            add_action('admin_notices', function() { echo '<div class="notice notice-success is-dismissible"><p><strong>Success!</strong> Logo saved successfully.</p></div>'; });
        }
        
        if (isset($_POST['remove_menu_logo']) && wp_verify_nonce($_POST['_wpnonce'], 'menu_logo_nonce')) {
            $menu_id = intval($_POST['menu_id']);
            $settings = get_option('menu_logo_settings', array());
            unset($settings[$menu_id]);
            update_option('menu_logo_settings', $settings);
            add_action('admin_notices', function() { echo '<div class="notice notice-success is-dismissible"><p><strong>Success!</strong> Logo removed successfully.</p></div>'; });
        }
    }
    
    public function output_custom_logo() {
        if (is_admin()) return;
        
        $settings = get_option('menu_logo_settings', array());
        $menu_mapping = $this->get_menu_mapping();
        
        echo '<script>';
        echo 'document.addEventListener("DOMContentLoaded", function() {';
        echo 'var settings = ' . json_encode($settings) . ';';
        echo 'var menuMapping = ' . json_encode($menu_mapping) . ';';
        echo 'for (var menuSlug in menuMapping) {';
        echo 'var menuElement = document.querySelector("#menu-" + menuSlug);';
        echo 'if (menuElement && settings[menuMapping[menuSlug]]) {';
        echo 'var logos = document.querySelectorAll(".logo img");';
        echo 'for (var i = 0; i < logos.length; i++) {';
        echo 'logos[i].src = settings[menuMapping[menuSlug]];';
        echo '}';
        echo 'break;';
        echo '}';
        echo '}';
        echo '});';
        echo '</script>';
    }
    
    private function get_menu_mapping() {
        $menus = wp_get_nav_menus();
        $mapping = array();
        
        foreach ($menus as $menu) {
            $menu_slug = sanitize_title($menu->name);
            $mapping[$menu_slug] = $menu->term_id;
        }
        
        return $mapping;
    }
    

}

new CustomLogoBasedMenu();

