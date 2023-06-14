<?php
/*
 * Plugin Name:       Orbit Menu
 * Plugin URI:        https://writecode6.wordpress.com/%D0%BF%D0%BB%D0%B0%D0%B3%D0%B8%D0%BD-%D0%BC%D0%B5%D0%BD%D1%8E-%D0%BE%D1%80%D0%B1%D0%B8%D1%82%D0%B0-%D0%B8%D0%BB%D0%B8-orbit-menu/
 * Description:       Menu to circule
 * Version:           1.0
 * Requires PHP:      7.3
 * Author:            Artem Litvinov
 * Author URI:        https://writecode6.wordpress.com/%d0%be%d0%b1%d0%be-%d0%bc%d0%bd%d0%b5/
 * Text Domain:       orbit-menu-plugin
 * Domain Path:       /languages
 */

add_action( 'admin_menu', 'orbit_menu_plugin_add_admin_page' );

function orbit_menu_plugin_add_admin_page() {
    $hook_suffix = add_menu_page( __('Orbit Menu Options', 'orbit-menu-plugin'), __('Orbit Menu', 'orbit-menu-plugin'), 'manage_options', 'orbit-menu-plugin-options', 'orbit_menu_plugin_create_page', 'dashicons-admin-site-alt3' );

    add_action( "admin_print_scripts-{$hook_suffix}", 'orbit_menu_plugin_admin_scripts' );
    add_action( 'admin_init', 'orbit_menu_plugin_custom_setting' );
}


function orbit_menu_plugin_admin_scripts() {
    wp_enqueue_style( 'orbit-menu-plugin-main-style', __DIR__ . '/assets/css/main.css' );
    wp_enqueue_script( 'orbit-menu-plugin-main-script', __DIR__ . '/assets/js/main.js', array( 'jquery' ), false, true );
}

function orbit_menu_plugin_create_page() {
    require __DIR__ . '/templates/orbit-menu-plugin-options.php';
}

function orbit_menu_plugin_custom_setting() {
    register_setting( 'orbit_menu_plugin_general_group', 'orbit_menu_plugin_name_cat' );
    add_settings_section( 'orbit_menu_plugin_general_section', __('Add categories to Orbit', 'orbit-menu-plugin'), '', 'orbit-menu-plugin-options' );
    add_settings_field( 'name_cat', __('Category list', 'orbit-menu-plugin'), 'orbit_menu_plugin_add_categories', 'orbit-menu-plugin-options', 'orbit_menu_plugin_general_section' );
}

function orbit_menu_plugin_add_categories() {

    $val = 0;    
    
    $options = get_option( 'orbit_menu_plugin_name_cat', [] );

    $checkbox_field_1 = isset( $options['field_1'] )
        ? (array) $options['field_1'] : [];

    $categories = get_categories( [
        'taxonomy' => 'product_cat',
    ] );

    if( $categories ){
        foreach( $categories as $cat ){
            // Данные в объекте $cat

            // $cat->term_id
            // $cat->name (Рубрика 1)
            // $cat->slug (rubrika-1)
            // $cat->term_group (0)
            // $cat->term_taxonomy_id (4)
            // $cat->taxonomy (category)
            // $cat->description (Текст описания)
            // $cat->parent (0)
            // $cat->count (14)
            // $cat->object_id (2743)
            // $cat->cat_ID (4)
            // $cat->category_count (14)
            // $cat->category_description (Текст описания)
            // $cat->cat_name (Рубрика 1)
            // $cat->category_nicename (rubrika-1)
            // $cat->category_parent (0)

            $val = in_array( $cat->cat_ID, $checkbox_field_1);           

            echo '<div class="cat-item">';
            echo '<label for="' .$cat->slug. '"><input name="orbit_menu_plugin_name_cat[field_1][]" type="checkbox" id="' .$cat->slug. '" value="' .$cat->cat_ID. '"' . checked( 1, $val, false ) .' >' .$cat->name.' - ' .$cat->cat_ID. '</label>';
            echo '</div>';
        }
    }   
}


