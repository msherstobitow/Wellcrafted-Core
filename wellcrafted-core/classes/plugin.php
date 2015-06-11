<?php

/**
 * @todo  PHPDoc
 */
class Wellcrafted_Plugin {

    protected $use_autoloader = true;
    protected $use_styles = false;
    protected $use_scripts = false;
    protected $plugin_name = null;
    protected $plugin_path = null;
    protected $plugin_url = null;

    public function __construct() {
        if ( $this->use_autoloader ) {
            $this->run_autoloader();
        }

        if ( $this->use_styles ) {
            Wellcrafted_Assets::add_admin_style( 
                $this->get_plugin_name() . '_base_admin_style', 
                $this->get_plugin_url() . 'assets/css/style.css'
            );
        }

        if ( $this->use_scripts ) {
            Wellcrafted_Assets::add_admin_footer_script( 
                $this->get_plugin_name() . '_base_admin_script', 
                $this->get_plugin_url() . 'assets/javascript/script.js',
                array( 'jquery' )
            );
        }
    }

    private function init_parameters() {
        $reflector = new ReflectionClass( $this );
        $filename = $reflector->getFileName();
        $dirname = dirname( $filename );
        
        $this->plugin_name = strtolower( $reflector->getName() );
        $this->plugin_path = realpath( $dirname . '/../' );
        $this->plugin_url = plugin_dir_url( $dirname );

    }

    public function get_plugin_name() {
        if ( null === $this->plugin_name ) {
            $this->init_parameters();
        }

        return $this->plugin_name;
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
}