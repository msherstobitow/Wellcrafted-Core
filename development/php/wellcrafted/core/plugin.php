<?php

namespace Wellcrafted\Core;

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
abstract class Plugin {
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
     * Whether a plugin should load its own translations.
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $load_translations = true;

    /**
     * Whether to use vendor autoloader for compaser packages.
     * 
     * @var boolean
     */
    protected $use_vendor = false;

    /**
     * Whether to use plugin's style on frontend
     * 
     * The style should be placed at ./assets/css/style.css
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_style = false;

    /**
     * Whether to use plugin's script on frontend
     * 
     * The script should be placed at ./assets/javascript/script.js
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_script = false;

    /**
     * Whether to use plugin's style on backend
     * 
     * The style should be placed at ./assets/css/admin-style.css
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_admin_style = false;

    /**
     * Whether to use plugin's script on both backend and frontend
     * 
     * The script should be placed at ./assets/javascript/admin-script.js
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_admin_script = false;

    /**
     * Whether to use plugin's style on both backend and frontend
     * 
     * The style should be placed at ./assets/css/common-style.css
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_common_style = false;

    /**
     * Whether to use plugin's script on backend
     * 
     * The script should be placed at ./assets/javascript/common-script.js
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_common_script = false;

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

    /**
     * A template loader for plugin.
     *
     * Plugin's templates can be overriden if placed in theme/wellcrafted/plugin-system-name/templates/ folder.
     * 
     * @var null
     * @since  1.0.0
     */
    protected static $template_loader = null;

    /**
     * Whether to use template loader
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_template_loader = false;

    /**
     * Define a folder name to store plugin data in theme.
     *
     * The resulting folder is 'THEME_FOLDER/wellcrafted/$templates_folder/'
     * @var null
     * @since  1.0.0
     */
    protected $plugin_theme_folder = null;

    /**
     * All installed WordPress plugins data.
     * 
     * @var null
     * @since  1.0.0
     */
    protected static $all_plugins_data = null;


    public function __construct() {
        if ( $this->use_autoloader ) {
            $this->run_autoloader();
        }

        if ( $this->load_translations ) {
            $this->load_translations();
        }

        if ( $this->use_vendor ) {
            $this->run_vendor_autoloader();
        }

        $this->init_assets();

        if ( !is_admin() ) {
            if ( $this->use_template_loader ) {
                $this->init_template_loader();
            }
        }
        

        $this->connect_to_support_plugin();
    }

    /**
     * Init plugin parameters. It shouldn't be called explicitly.
     * 
     * @since  1.0.0
     */
    private function init_parameters() {
        $reflector = new \ReflectionClass( $this );
        $filename = $reflector->getFileName();
        $dirname = dirname( $filename );
        $folder_name = reset( explode( DIRECTORY_SEPARATOR, trim( str_replace( WP_PLUGIN_DIR, '', $dirname ), DIRECTORY_SEPARATOR ) ) );
        $this->plugin_system_name = self::registry()->plugin_system_name = $folder_name . '/' . $folder_name . '.php';
        $this->plugin_url = self::registry()->plugin_url = plugin_dir_url( WP_PLUGIN_DIR . '/' . $this->plugin_system_name );
        $this->plugin_path = WP_PLUGIN_DIR . '/' . $folder_name . '/';

        if ( ! $this->plugin_name ) {
            $this->plugin_name = $this->all_plugins_data()[ $this->plugin_system_name ][ 'Name' ];
        }

    }

    /**
     * @todo PHPDoc
     * @return [type] [description]
     * @since  1.0.0
     */
    protected function load_translations() {
        $locale = apply_filters( 'plugin_locale', get_locale(), $this->textdomain() );
        load_textdomain( 
            $this->textdomain(), 
            $this->get_plugin_path() . 'translations/' . $locale . '.mo'
        );

    }

    /**
     * Return plugin's textdomain
     * @return string textdomain
     * @since  1.0.0
     */
    abstract protected function textdomain();

    /**
     * Return all installed WordPress plugins data
     * @return array plugins data array
     */
    protected function all_plugins_data() {
        if ( null === self::$all_plugins_data ) {
            if ( ! function_exists( 'get_plugins' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }
            self::$all_plugins_data = get_plugins();
        }

        return self::$all_plugins_data;
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
        static::$registry = new Registry();
    }


    /**
     * Init plugin assets.
     *
     * Plugin can have separate admin, client and common assets.
     */
    protected function init_assets() {
        if ( is_admin() ) {
            if ( $this->use_admin_style ) {
                Assets::add_admin_style( 
                    $this->get_plugin_system_name() . '_base_admin_style', 
                    $this->get_plugin_url() . 'assets/css/admin-style.css'
                );
            }

            if ( $this->use_admin_script ) {
                Assets::add_admin_footer_script( 
                    $this->get_plugin_system_name() . '_base_admin_script', 
                    $this->get_plugin_url() . 'assets/javascript/admin-script.js',
                    [ 'jquery' ]
                );
            }
        } else {
            if ( $this->use_style ) {
                Assets::add_style( 
                    $this->get_plugin_system_name() . '_base_style', 
                    $this->get_plugin_url() . 'assets/css/style.css'
                );
            }

            if ( $this->use_script ) {
                Assets::add_footer_script( 
                    $this->get_plugin_system_name() . '_base_script', 
                    $this->get_plugin_url() . 'assets/javascript/script.js',
                    [ 'jquery' ]
                );
            }
        }

        if ( $this->use_common_style ) {
            Assets::add_common_style( 
                $this->get_plugin_system_name() . '_base_common_style', 
                $this->get_plugin_url() . 'assets/css/common-style.css'
            );
        }

        if ( $this->use_common_script ) {
            Assets::add_common_footer_script( 
                $this->get_plugin_system_name() . '_base_common_script', 
                $this->get_plugin_url() . 'assets/javascript/common-script.js',
                [ 'jquery' ]
            );
        }
    }

    /**
     * @todo PHPDoc
     * @return [type] [description]
     */
    protected function init_template_loader() {
        if ( null === self::$template_loader ) {
            self::$template_loader = new Template\Loader();
        }

        if ( ! $this->plugin_theme_folder ) {
            $this->plugin_theme_folder = $this->textdomain;
        }

        /**
         * Filter 'PLUGIN_TEXTDOMAIN_template_loader_rules' allows to modify current template loader rules
         * @var array
         */
        $rules_set = apply_filters( 
            $this->textdomain() . '_template_loader_rules',
            [
                'plugin_theme_folder' => $this->plugin_theme_folder,
                'default_path' => $this->get_plugin_path(),
                'default_url' => $this->get_plugin_url(),
                'rules' => $this->template_loader_rules()
            ]
        );

        self::$template_loader->add_rules_set( $this->textdomain(), $rules_set );
    }

    /**
     * @todo PHPDoc
     * @param [type] $rules [description]
     */
    public function template_loader_rules() {
        return [];
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
            if ( strpos( $class, 'Wellcrafted' ) === 0 ) {
                $folder = strpos( $class, 'Traits' ) === false ? 'classes' : 'traits';
                $folder = '';
                $filename = $this->get_plugin_path() . strtolower( str_replace( ['\\', '_'], [ '/', '-' ], $class ) ) . '.php';
                if ( file_exists( $filename ) ) {
                    require $filename;
                }
            }
        });
    }

    protected function run_vendor_autoloader() {
        $autoloader_path = __DIR__ . '/../vendor/autoload.php';
        if ( file_exists( $autoloader_path ) ) {
            require $autoloader_path;
        }
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