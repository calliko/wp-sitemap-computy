<?php
/*
 * Plugin Name:   WP Sitemap Computy
 * Version:       1.8
 * Text Domain:   wp-sitemap-computy
 * Plugin URI:    https://computy.ru/blog/
 * Description: This functionality does not imply settings and all pages are displayed in the sitemap.
 * Author:        computy
 * Author URI:    https://computy.ru
 */

/*Инструкции по дальнейшему функционалу:
https://make.wordpress.org/core/2020/07/22/new-xml-sitemaps-functionality-in-wordpress-5-5/
*/
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WP_SITEMAP_COMPUTY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WP_SITEMAP_COMPUTY_VERSION', '1.8');

/*Страница админки*/
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
    require_once( WP_SITEMAP_COMPUTY_PLUGIN_DIR . 'wp-sitemap-admin.php' );
    add_action( 'init', array( 'WP_Sitemap_Admin', 'init' ) );
}
/*Страница админки*/

$r = get_option( 'wp_sitemap_computy_option_name' );
if(isset($r['vkl'])){
    if($r['vkl'] == '1'){
        add_filter('wp_sitemaps_enabled', '__return_false');
        //функция отключения sitemap
    }
}





