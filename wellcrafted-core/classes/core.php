<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Load a Plugin class
 */
require 'plugin.php';

/**
 * Require functions
 */
$wellcrafted_function_path = dirname( __FILE__ ) . '/../functions/';
require $wellcrafted_function_path . 'system.php';
require $wellcrafted_function_path . 'arrays.php';
require $wellcrafted_function_path . 'mail.php';

/**
 * Wellcrafted_Core is a base framework class.
 * It checks envoronment state and makes all Wellcrafted products work.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Wellcrafted_Core extends Wellcrafted_Plugin {

    /**
     * Whether to use plugin's default styles
     * 
     * The style should be placed at ./assets/css/style.css
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_styles = true;

    /**
     * Whether to use plugin's default scripts
     * 
     * The script should be placed at ./assets/javascript/script.js
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_scripts = true;

    /**
     * Contain aplugin's own registry.
     * If not defined the plugin will use common Wellcrafted plugins registry.
     * 
     * @var null
     * @since  1.0.0
     */
    protected static $registry = null;

    public function __construct() {
        parent::__construct();
        $this->init();
    }

    /**
     * Init the plugin and trigger Wellcrafted plugins initialisation process
     *
     * @since  1.0.0
     */
    private function init() {
        // Run all wellcrafted plugins
        add_action( 'plugins_loaded', function() {
            do_action( 'wellcrafted_core_initilized' );
        });

        add_action( 'init', function() {
            do_action( 'wellcrafted_core_register_post_types' );
            do_action( 'wellcrafted_core_register_taxonomy' );
        });
    }

} 

new Wellcrafted_Core();