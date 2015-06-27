<?php

namespace Wellcrafted\Core\Assets;

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

use \Wellcrafted\Core\Assets as Assets;

/**
 * Assets allows to add a predefinde vendor assets
 * 
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Vendor {

    /**
     * Wellcrafted_Singleton_Trait add into a class Singleton pattern ability
     */
    use \Wellcrafted\Core\Traits\Singleton;

    private $assets = array();
    private $prefix = 'wellcrafted_asset_vendor_';

    public function __construct() {

        $core_assets_url = \Wellcrafted\Core\Core::registry()->plugin_url . 'assets/';

        $this->assets[ 'modernizr' ] = array(
            array(
                'handle' => $this->prefix . 'modernizr',
                'src' => $core_assets_url . 'bower_components/modernizr/modernizr.js',
                'in_footer' => true,
                'type' => 'js'
            )
        );

        $this->assets[ 'googlemaps' ] = array(
            array(
                'handle' => $this->prefix . 'googlemap',
                'src' => 'https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false',
                'in_footer' => true,
                'type' => 'js'
            )
        );
    }

    /**
     * Check and enqueue vendor asset.
     * 
     * @param  string $name A name of an asset group
     * @param  string $area A name of an end to load assets. Can be empty (for frontend only), 'admin' (for backend) and 'both' (for both ends).
     * @since 1.0.0
     */
    public function enqueue( $name, $area = 'front' ) {
        /**
         * Check area
         */
        if ( ! in_array( $area, [ 'front', 'admin', 'both' ] ) ) {
            return;
        }

        if ( ! (
            'both' === $area ||
             ( 'admin' === $area && is_admin() ) ||
             ( 'front' === $area && !is_admin() ) 
            )
        ) {
            return;
        }

        /**
         * Check group existence
         */
        if ( empty( $this->assets[ $name ] ) ) {
            return;
        }

        /**
         * Enqueue assets group
         */
        foreach ( $this->assets[ $name ] as $asset) {
            $this->_enqueue( $asset );
        }
    }

    /**
     * Enqueue vendor asset.
     * 
     * @param  array $asset Asset params description
     * @since 1.0.0
     */
    private function _enqueue( $asset ) {
        if ( empty( $asset[ 'src' ] ) ) {
            return;
        }

        $asset = wp_parse_args( $asset, array(
            'handle' => md5( time() ),
            'deps' => array(),
            'ver' => 1
        ) );

        if ( ( !empty( $asset[ 'type' ] ) && 'js' == $asset[ 'type' ] ) || '.js' == substr( $asset[ 'src' ], strlen( $asset[ 'src' ] ) - 3 ) ) {
            $asset = wp_parse_args( $asset, array(
                'in_footer' => true
            ) );
            Assets::add_script( $asset[ 'handle'], $asset[ 'src' ], $asset[ 'deps' ], $asset[ 'ver' ], $asset[ 'in_footer' ] );
        } else {
            $asset = wp_parse_args( $asset, array(
                'media' => null
            ) );
            Assets::add_style( $asset[ 'handle'], $asset[ 'src' ], $asset[ 'deps' ], $asset[ 'ver' ], $asset[ 'media' ] );
        }
    }
}

