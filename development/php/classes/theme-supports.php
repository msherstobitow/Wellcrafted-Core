<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Theme_Supports class allows to add theme supports and modify params before "after_setup_theme" hook.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Wellcrafted_Theme_Supports {

    use Wellcrafted_Singleton_Trait;

    /**
     * A list of theme supports.
     * 
     * @var array
     * @since  1.0.0
     */
    private $supports = [];

    public function __construct() {
        add_action( 'after_setup_theme', [ &$this, 'add_theme_supports' ] );
    }

    /**
     * Add registered theme supports with params
     * 
     * @since  1.0.0
     */
    public function add_theme_supports() {
        foreach ( $this->supports as $support => $params ) {
            add_theme_support( $support, $params );
        }
    }

    /**
     * Register theme support for future using
     * 
     * @param string $support A support name
     * @since  1.0.0
     */
    public function register_support( $support ) {
        $this->supports[ $support ] = true;
    }

    /**
     * Register a support with params
     * 
     * @param  string $support Support name
     * @param  mixed $param   Param name
     * @param  string $value   Param value name; may be empty if support param is plain string
     * @since  1.0.0
     */
    public function register_support_param( $support, $param, $value = '' ) {
        $this->register_support( $support );

        if ( ! is_array( $this->supports[ $support ] ) ) {
            $this->supports[ $support ] = [];
        }

        if ( $value ) {
            $this->supports[ $support ][ $param ] = $value;
        } else {
            $this->supports[ $support ][] = $param;
        }
    }
}