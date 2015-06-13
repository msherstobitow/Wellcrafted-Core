<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'WELLCRAFTED' ) ) {
	define( 'WELLCRAFTED', 'wellcrafted_core' );
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
 * @todo  PHPDoc
 */
class Wellcrafted_Core extends Wellcrafted_Plugin {

    private $compatible_php_version = '5.4.0';
    private $is_compatible = null;
    protected $use_styles = true;
    protected $use_scripts = true;

    public function __construct() {
        if ( ! $this->is_compatible() ) {
            return;
        }

        parent::__construct();

        $this->run_autoloader();
        $this->init();

    }

    /**
     * Init the plugin and trigger Wellcrafted plugins initialisation process
     *
     * @since  1.0 
     */
    private function init() {
        register_activation_hook( __FILE__, array( &$this, 'check_php_version' ) );

        // Run all wellcrafted plugins
        add_action( 'plugins_loaded', function() {
            do_action( 'wellcrafted_core_initilized' );
        });

        add_action( 'init', function() {
            do_action( 'wellcrafted_core_register_post_types' );
            do_action( 'wellcrafted_core_register_taxonomy' );
        });
    }

    /**
     * Set the plugin compatibility state
     *
     * @since 1.0
     * 
     * @return boolean Whether a PHP version is compatible with the plugin requirements
     */
    public function is_compatible() {
        if ( null == $this->is_compatible ) {
            $this->is_compatible = $this->check_php_version();
        }
        return $this->is_compatible;
    }

    /**
     * Check if a PHP version is compatible with the plugin requirements.
     *
     * @since 1.0
     * 
     * @return bool Whether a PHP version is compatible with the plugin requirements
     */
    public function check_php_version() {
        if ( version_compare( PHP_VERSION, $this->compatible_php_version, '<' ) ) {

            /**
             * Deactivate the plugin because it's not compatible
             */
            add_action( 'admin_init', function() {

                if ( is_plugin_active( plugin_basename( __FILE__ ) ) ) {

                    deactivate_plugins( plugin_basename( __FILE__ ) );

                    add_action( 'admin_notices', function () {
                        $message = sprintf( 
                            __( 'Wellcrafted Core plugin requires PHP version at least %s. You have %s' , WELLCRAFTED ),
                            $this->compatible_php_version,
                            PHP_VERSION );

                         echo "<div class=\"error\"> <p>$message</p></div>"; 
                    } );

                    if ( isset( $_GET['activate'] ) ) {
                        unset( $_GET['activate'] );
                    }
                }

            } );

            return false;
        }

        return true;
    }

} 

new Wellcrafted_Core();