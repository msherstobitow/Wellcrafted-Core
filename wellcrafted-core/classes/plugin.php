<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @todo  PHPDoc
 */
class Wellcrafted_Plugin {

    protected $use_autoloader = true;
    protected $use_styles = false;
    protected $use_scripts = false;
    protected $plugin_name = null;
    protected $plugin_system_name = null;
    protected $plugin_path = null;
    protected $plugin_url = null;
    protected $support_email = null;
    

    /**
     * A variable to keep a Wellcrefted_Registry class in.
     * Note that each of child classes should define this variable to have a separate registry.
     * @var null
     */
    protected static $registry = null;
    
    /**
     * Whether a plugin should use registry.
     * Note that if a child class doesn't define static::$registry variable the plugin
     * will use common plugins registry
     * @var boolean
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

    private function init_parameters() {
        $reflector = new ReflectionClass( $this );
        $filename = $reflector->getFileName();
        $dirname = dirname( $filename );

        $plugin_folder_name = basename( dirname( $dirname ) );
        $plugin_wp_key = $plugin_folder_name . '/' . $plugin_folder_name . '.php';

        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $all_plugins = get_plugins();

        if ( isset( $all_plugins[ $plugin_wp_key ] ) ) {
            $this->plugin_name = $all_plugins[ $plugin_wp_key ][ 'Name' ];
        } else {
            $this->plugin_name = strtolower( $reflector->getName() );
        }

        $this->plugin_system_name = sanitize_title( $this->plugin_name );
        $this->plugin_path = realpath( $dirname . '/../' );
        $this->plugin_url = plugin_dir_url( $dirname );

        self::registry()->plugin_system_name = $this->plugin_system_name;

    }

    public function get_plugin_name() {
        if ( null === $this->plugin_name ) {
            $this->init_parameters();
        }

        return $this->plugin_name;
    }

    public function get_plugin_system_name() {
        if ( null === $this->plugin_system_name ) {
            $this->init_parameters();
        }

        return $this->plugin_system_name;
    }

    public function get_plugin_path() {
        if ( null === $this->plugin_path ) {
            $this->init_parameters();
        }

        return $this->plugin_path;
    }

    public function get_plugin_url() {
        if ( null === $this->plugin_url ) {
            $this->init_parameters();
        }

        return $this->plugin_url;
    }

    protected static function init_registry() {
        static::$registry = new Wellcrafted_Registry();
    }

    public static function registry() {
        if ( ! static::$use_registry ) {
            static::$use_registry = false;
        } else if ( null === static::$registry ) {
            static::init_registry();
        }
        return static::$registry;
    }

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

    public function connect_to_support_plugin() {
        add_filter( 'wellcrafted_support_developers_emails', [ &$this, 'add_developer_support_email' ] );
    }

    public function add_developer_support_email( $emails ) {
        if ( $this->support_email ) {
            $emails[ $this->get_plugin_name() ] = $this->support_email;
        }

        return $emails;
    }
}