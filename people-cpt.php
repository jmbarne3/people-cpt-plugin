<?php
/**
 * Plugin Name: People Custom Post Type
 * Version: 1.0.0
 * Author: Jim Barnes
 * Author URI: https://github.com/jmbarne3/
 * Description: Provides a shortcode for displaying tuition and fees
 * Github Plugin URI: jmbarne3/people-cpt-plugin
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'JMB_PEOPLE__PLUGIN_URL', plugins_url( basename( dirname( __FILE__ ) ) ) );
define( 'JMB_PEOPLE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'JMB_PEOPLE__STATIC_URL', JMB_PEOPLE__PLUGIN_URL . '/static' );
define( 'JMB_PEOPLE__PLUGIN_FILE', __FILE__ );


include_once 'includes/people-posttype.php';
include_once 'common/people-list-common.php';

if ( ! function_exists( 'jmb_people_plugin_activation' ) ) {
    function jmb_people_plugin_activation() {
        JMB_People_PostType::register_posttype();
        flush_rewrite_rules();
    }

    register_activation_hook( JMB_PEOPLE__PLUGIN_FILE, 'jmb_people_plugin_activation' );
}

if ( ! function_exists( 'jmb_people_plugin_deactivation' ) ) {
    function jmb_people_plugin_deactivation() {
        flush_rewrite_rules();
    }
}

if ( ! function_exists( 'jmb_people_init' ) ) {
    function jmb_people_init() {
        add_action( 'init', array( 'JMB_People_PostType', 'register_posttype' ), 10, 0 );
        add_action( 'acf/init', array( 'JMB_People_PostType', 'add_fields' ), 10, 0 );
        add_action( 'posts_results', array( 'JMB_People_PostType', 'add_meta_data' ), 10, 1 );
    }

    add_action( 'plugins_loaded', 'jmb_people_init' );
}