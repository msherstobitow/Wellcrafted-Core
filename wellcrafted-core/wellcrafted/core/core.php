<?php

namespace Wellcrafted\Core;

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}


/**
 * Wellcrafted_Core is a base framework class.
 * It checks envoronment state and makes all Wellcrafted products work.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Core extends Plugin {

    /**
     * Add into a class Singleton pattern ability
     *
     * @since  1.0.0
     */
    use Traits\Singleton;

    /**
     * Whether to use plugin's style on backend
     * 
     * The style should be placed at ./assets/css/admin-style.css
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_admin_style = true;

    /**
     * Whether to use plugin's script on both backend and frontend
     * 
     * The script should be placed at ./assets/javascript/admin-script.js
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_admin_script = true;

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
            // new Wellcrafted_Plugin_Template_Loader( apply_filters( 'wellcrafted_core_templates_rules', [] ) );
        });
    }

} 

new Core();