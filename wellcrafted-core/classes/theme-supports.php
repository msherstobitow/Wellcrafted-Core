<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @todo  PHPDoc
 */
class Wellcrafted_Theme_Supports {

    use Wellcrafted_Singleton_Trait;

    private $supports = [];

    public function __construct() {
        add_action( 'after_setup_theme', array( &$this, 'add_theme_supports' ) );
    }

    /**
     * Add registered theme supports with params
     */
    public function add_theme_supports() {
        foreach ( $this->supports as $support => $params ) {
            add_theme_support( $support, $params );
        }
    }

    /**
     * Register theme support for future using
     * @param string $support A support name
     */
    public function register_support( $support ) {
        $this->supports[ $support ] = true;
    }

    /**
     * Register a support with params
     * @param  string $support Support name
     * @param  mixed $param   Param name
     * @param  string $value   Param value name; may be empty if support param is plain string
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