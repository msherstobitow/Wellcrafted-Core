<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Plugin is a base class for Wellcrafted plugins.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Wellcrafted_Plugin {
    /**
     * Whether a plugin should use its own autoloader.
     *
     * Autoloader will load classes by "Wellcrafted_*" pattern. For example:
     * - Wellcrefted_Post_Type will match PLUGIN-FOLDER/classes/post-type.php
     * - Wellcrafted_Singleton_Trait will mattch PLUGIN-FOLDER/traits/singleton.php
     * 
     * @since  1.0.0
     */
    protected $use_autoloader = true;

    /**
     * Whether to use plugin's default styles
     * 
     * The style should be placed at ./assets/css/style.css
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_styles = false;

    /**
     * Whether to use plugin's default scripts
     * 
     * The script should be placed at ./assets/javascript/script.js
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_scripts = false;

    /**
     * Define a plugin name.
     *
     * If not defined a wordpress plugin name will be used
     * 
     * @var null
     * @since  1.0.0
     */
    protected $plugin_name = null;

    /**
     * Define a plugin system name. It builds from sanitized plugin name. 
     * 
     * @var null
     * @since  1.0.0
     */
    protected $plugin_system_name = null;

    /**
     * A plugin absolute path.
     *
     * @var null
     * @since  1.0.0
     */
    protected $plugin_path = null;

    /**
     * A plugin folder URL.
     *
     * @var null
     * @since  1.0.0
     */
    protected $plugin_url = null;

    /**
     * A developer's support email. 
     * 
     * Any plugin based on Wellcrafted_Plugin class can use this property to add a support email address to be used in "Wellcrafted Support" plugin.
     *
     * @var null
     * @since  1.0.0
     */
    protected $support_email = null;
    

    /**
     * A variable to keep a Wellcrefted_Registry class in.
     * Note that each of child classes should define this variable to have a separate registry.
     * 
     * @var null
     * @since  1.0.0
     */
    protected static $registry = null;
    
    /**
     * Whether a plugin should use registry.
     * Note that if a child class doesn't define static::$registry variable the plugin
     * will use common plugins registry
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected static $use_registry = true;


    public function __construct() {
        if ( $this->use_autoloader ) {
            $this->run_autoloader();
        }

        if ( $this->use_styles ) {
            Wellcrafted_Assets::add_admin_style( 
                $this->get_plugin_system_name() . '_base_admin_style', 
                $this->get_plugin_url() . 'assets/css/style.css'
            );
        }

        if ( $this->use_scripts ) {
            Wellcrafted_Assets::add_admin_footer_script( 
                $this->get_plugin_system_name() . '_base_admin_script', 
                $this->get_plugin_url() . 'assets/javascript/script.js',
                array( 'jquery' )
            );
        }

        $this->connect_to_support_plugin();
    }

    /**
     * Init plugin parameters. It shouldn't be called explicitly.
     * 
     * @since  1.0.0
     */
    private function init_parameters() {
        $reflector = new ReflectionClass( $this );
        $filename = $reflector->getFileName();
        $dirname = dirname( $filename );

        if ( ! $this->plugin_name ) {
            $plugin_folder_name = basename( dirname( $dirname ) );
            $plugin_wp_key = $plugin_folder_name . '/' . $plugin_folder_name . '.php';

            if ( ! function_exists( 'get_plugins' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }

            $all_plugins = get_plugins();

            $this->plugin_name = $all_plugins[ $plugin_wp_key ][ 'Name' ];
        }


        $this->plugin_system_name = sanitize_title( $this->plugin_name );
        $this->plugin_path = realpath( $dirname . '/../' );
        $this->plugin_url = plugin_dir_url( $dirname );

        self::registry()->plugin_system_name = $this->plugin_system_name;

    }

    /**
     * Return a nice plugin's name
     * 
     * @return string Plugin's name
     * @since  1.0.0
     */
    public function get_plugin_name() {
        if ( null === $this->plugin_name ) {
            $this->init_parameters();
        }

        return $this->plugin_name;
    }

    /**
     * Return a nice plugin's system name.
     * 
     * @return string Plugin's system name.
     * @since  1.0.0
     */
    public function get_plugin_system_name() {
        if ( null === $this->plugin_system_name ) {
            $this->init_parameters();
        }

        return $this->plugin_system_name;
    }

    /**
     * Return a nice plugin's absolute path.
     * 
     * @return string Plugin's absolute path.
     * @since  1.0.0
     */
    public function get_plugin_path() {
        if ( null === $this->plugin_path ) {
            $this->init_parameters();
        }

        return $this->plugin_path;
    }

    /**
     * Return a nice plugin's fiolder URL.
     * 
     * @return string Plugin's fiolder URL.
     * @since  1.0.0
     */
    public function get_plugin_url() {
        if ( null === $this->plugin_url ) {
            $this->init_parameters();
        }

        return $this->plugin_url;
    }

    /**
     * Init plugin's registry
     * 
     * @since  1.0.0
     */
    protected static function init_registry() {
        static::$registry = new Wellcrafted_Registry();
    }

    /**
     * Return plugin's registry to get regisry's stored data
     *
     * @return  Wellcrafted_Registry A Wellcrafted_Registry instance
     * @since  1.0.0
     */
    public static function registry() {
        if ( ! static::$use_registry ) {
            static::$use_registry = false;
        } else if ( null === static::$registry ) {
            static::init_registry();
        }
        return static::$registry;
    }

    /**
     * Add a common autoload logic to a plugin
     *
     * Autoloader will load classes by "Wellcrafted_*" pattern. For example:
     * - Wellcrefted_Post_Type will match PLUGIN-FOLDER/classes/post-type.php
     * - Wellcrafted_Singleton_Trait will mattch PLUGIN-FOLDER/traits/singleton.php
     * 
     * @since  1.0.0
     */
    protected function run_autoloader() {
        spl_autoload_register( function ( $class ) {
            if ( strpos( $class, 'Wellcrafted_' ) === 0 ) {
                $folder = strpos( $class, '_Trait' ) === false ? 'classes' : 'traits';
                
                $filename = $this->get_plugin_path()  . '/' . $folder . '/' . strtolower( str_replace( ['Wellcrafted_', '_Trait', '_'], [ '', '', '-'], $class ) ) . '.php';

                if ( file_exists( $filename ) ) {
                    require $filename;
                }
            }
        });
    }

    /**
     * Add a filter to enqeue developer's support email to "Wellcrafted Support" plugin
     * 
     * @since  1.0.0
     */
    public function connect_to_support_plugin() {
        add_filter( 'wellcrafted_support_developers_emails', [ &$this, 'add_developer_support_email' ] );
    }

    /**
     * Add plugin developer's support email(-s)
     * 
     * @param array Registered developers' support emails
     * @since  1.0.0
     */
    public function add_developer_support_email( $emails ) {
        if ( $this->support_email ) {
            $emails[ $this->get_plugin_name() ] = $this->support_email;
        }

        return $emails;
    }
}