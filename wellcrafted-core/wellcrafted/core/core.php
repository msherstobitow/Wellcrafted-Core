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
     * Whether a plugin should load its own translations.
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $load_translations = false;

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
        add_action( 'plugins_loaded', [ &$this, 'load_theme_filters' ] );

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

    /**
     * @todo PHPDoc
     * @return [type] [description]
     */
    protected function textdomain() {
        return WELLCRAFTED;
    }

    public function load_theme_filters() {
        $filters_path = get_stylesheet_directory() . '/wellcrafted/filters.php';
        if ( file_exists( $filters_path ) ) {
            require $filters_path;
        }
    }

} 

new Core();