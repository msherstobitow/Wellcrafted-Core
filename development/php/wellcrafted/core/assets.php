<?php

namespace Wellcrafted\Core;

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Assets allows to add any assets to a head or a footer of a page, both front and admin
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Assets {

    /**
     * Wellcrafted_Singleton_Trait add into a class Singleton pattern ability
     */
    use Traits\Singleton;

    /**
     * An array of styles options to link in both client and admin
     * 
     * @var array
     * @since  1.0.0
     */
    private $wp_styles = [];

    /**
     * An array of scripts options to link in both client and admin
     * 
     * @var array
     * @since  1.0.0
     */
    private $wp_scripts = [];

    /**
     * An array of styles options to link in admin area
     * @var array
     */
    private $admin_styles = [];

    /**
     * An array of scripts options to link in admin area
     * 
     * @var array
     * @since  1.0.0
     */
    private $admin_scripts = [];

    /**
     * An array of scripts localizations options to link in admin area
     * 
     * @var array
     * @since  1.0.0
     */
    private $admin_script_localizations = [];

    /**
     * Whether to use media assets in admin
     * 
     * @var boolean
     * @since  1.0.0
     */
    private $use_media = false;

    /**
     * An array of inline styles options
     * 
     * @var array
     * @since  1.0.0
     */
    private $inline_css = [];

    /**
     * An array of inline scripts options
     * 
     * @var array
     * @since  1.0.0
     */
    private $inline_js = [];

    public function __construct() {

        $this->inline_css = get_option( WELLCRAFTED . '_asset_inline_css', '' );
        $this->inline_js = get_option( WELLCRAFTED . '_asset_inline_js', '' );

        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', [ &$this, 'enqueue_scripts' ] );
        } else {
            add_action( 'wp_enqueue_scripts', [ &$this, 'enqueue_scripts' ] );
            add_action( 'wp_footer', [ &$this, 'wp_footer' ] );
        }
    }

    /**
     * Set admin to use media assets
     * 
     * @since  1.0.0
     */
    public static function use_admin_media() {
        self::instance()->use_media = true;
    }

    
    /**
     * Add a style to assets queue
     *
     * @param string      $handle    Name of the script.
     * @param string|bool $src       Path to the script from the root directory of WordPress. Example: '/js/myscript.js'.
     * @param array       $deps      An array of registered handles this script depends on. Default empty array.
     * @param string|bool $ver       Optional. String specifying the script version number, if it has one. This parameter
     *                               is used to ensure that the correct version is sent to the client regardless of caching,
     *                               and so should be included if a version number is available and makes sense for the script.
     * @param string      $media  Optional. The media for which this stylesheet has been defined.
     *                            Default 'all'. Accepts 'all', 'aural', 'braille', 'handheld', 'projection', 'print',
     *                            'screen', 'tty', or 'tv'.
     *
     * @since  1.0.0
     */
    public static function add_style( $handle, $src, $deps = [], $ver = null, $media = null ) {
        self::instance()->wp_styles[] = [
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'media' => $media,
        ];
    }


    /**
     * Add a style to admin assets queue
     *
     * @param string      $handle    Name of the script.
     * @param string|bool $src       Path to the script from the root directory of WordPress. Example: '/js/myscript.js'.
     * @param array       $deps      An array of registered handles this script depends on. Default empty array.
     * @param string|bool $ver       Optional. String specifying the script version number, if it has one. This parameter
     *                               is used to ensure that the correct version is sent to the client regardless of caching,
     *                               and so should be included if a version number is available and makes sense for the script.
     * @param string      $media  Optional. The media for which this stylesheet has been defined.
     *                            Default 'all'. Accepts 'all', 'aural', 'braille', 'handheld', 'projection', 'print',
     *                            'screen', 'tty', or 'tv'.
     *
     * @since  1.0.0
     */
    public static function add_admin_style( $handle, $src, $deps = [], $ver = null, $media = null ) {
        if ( !in_array( 'wp-admin', $deps ) ) {
            $deps[] = 'wp-admin';
        }

        self::instance()->admin_styles[] = [
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'media' => $media,
        ];
    }

    /**
     * Add a style to assets queue both client and admin
     *
     * @param string      $handle    Name of the script.
     * @param string|bool $src       Path to the script from the root directory of WordPress. Example: '/js/myscript.js'.
     * @param array       $deps      An array of registered handles this script depends on. Default empty array.
     * @param string|bool $ver       Optional. String specifying the script version number, if it has one. This parameter
     *                               is used to ensure that the correct version is sent to the client regardless of caching,
     *                               and so should be included if a version number is available and makes sense for the script.
     * @param string      $media  Optional. The media for which this stylesheet has been defined.
     *                            Default 'all'. Accepts 'all', 'aural', 'braille', 'handheld', 'projection', 'print',
     *                            'screen', 'tty', or 'tv'.
     *
     * @since  1.0.0
     */
    public static function add_common_style( $handle, $src, $deps = [], $ver = null, $media = null ) {
        if ( is_admin() ) {
            self::add_admin_style( $handle, $src, $deps, $ver, $media );
        } else {
            self::add_style( $handle, $src, $deps, $ver, $media );
        }
    }

    /**
     * Add a script to assets queue
     *
     * @param string      $handle    Name of the script.
     * @param string|bool $src       Path to the script from the root directory of WordPress. Example: '/js/myscript.js'.
     * @param array       $deps      An array of registered handles this script depends on. Default empty array.
     * @param string|bool $ver       Optional. String specifying the script version number, if it has one. This parameter
     *                               is used to ensure that the correct version is sent to the client regardless of caching,
     *                               and so should be included if a version number is available and makes sense for the script.
     * @param string      $deps     Optional. The media for which this stylesheet has been defined.
     *                            Default 'all'. Accepts 'all', 'aural', 'braille', 'handheld', 'projection', 'print',
     *                            'screen', 'tty', or 'tv'.
     * @param bool        $in_footer Optional. Whether to enqueue the script before </head> or before </body>.
     *                               Default 'false'. Accepts 'false' or 'true'.
     *
     * @since  1.0.0
     */
    public static function add_script( $handle, $src, $deps = [], $ver = null, $in_footer = false ) {
        self::instance()->wp_scripts[] = [
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'in_footer' => ( bool )$in_footer,
        ];
    }

    /**
     * Add a script to admin assets queue
     *
     * @param string      $handle    Name of the script.
     * @param string|bool $src       Path to the script from the root directory of WordPress. Example: '/js/myscript.js'.
     * @param array       $deps      An array of registered handles this script depends on. Default empty array.
     * @param string|bool $ver       Optional. String specifying the script version number, if it has one. This parameter
     *                               is used to ensure that the correct version is sent to the client regardless of caching,
     *                               and so should be included if a version number is available and makes sense for the script.
     * @param string      $deps     Optional. The media for which this stylesheet has been defined.
     *                            Default 'all'. Accepts 'all', 'aural', 'braille', 'handheld', 'projection', 'print',
     *                            'screen', 'tty', or 'tv'.
     * @param bool        $in_footer Optional. Whether to enqueue the script before </head> or before </body>.
     *                               Default 'false'. Accepts 'false' or 'true'.
     *                               
     * @since  1.0.0
     */
    public static function add_admin_script( $handle, $src, $deps = [], $ver = null, $in_footer = false ) {
        self::instance()->admin_scripts[] = [
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'in_footer' => ( bool )$in_footer,
        ];
    }
    
    /**
     * Add a script to assets queue
     *
     * @param string      $handle    Name of the script.
     * @param string|bool $src       Path to the script from the root directory of WordPress. Example: '/js/myscript.js'.
     * @param array       $deps      An array of registered handles this script depends on. Default empty array.
     * @param string|bool $ver       Optional. String specifying the script version number, if it has one. This parameter
     *                               is used to ensure that the correct version is sent to the client regardless of caching,
     *                               and so should be included if a version number is available and makes sense for the script.
     * @param string      $deps     Optional. The media for which this stylesheet has been defined.
     *                            Default 'all'. Accepts 'all', 'aural', 'braille', 'handheld', 'projection', 'print',
     *                            'screen', 'tty', or 'tv'.
     *                            
     * @since  1.0.0
     */
    public static function add_footer_script( $handle, $src, $deps = [], $ver = null ) {
        self::add_script( $handle, $src, $deps, $ver, true );
    }

    /**
     * Add a script to admin assets queue
     *
     * @param string      $handle    Name of the script.
     * @param string|bool $src       Path to the script from the root directory of WordPress. Example: '/js/myscript.js'.
     * @param array       $deps      An array of registered handles this script depends on. Default empty array.
     * @param string|bool $ver       Optional. String specifying the script version number, if it has one. This parameter
     *                               is used to ensure that the correct version is sent to the client regardless of caching,
     *                               and so should be included if a version number is available and makes sense for the script.
     * @param string      $deps     Optional. The media for which this stylesheet has been defined.
     *                            Default 'all'. Accepts 'all', 'aural', 'braille', 'handheld', 'projection', 'print',
     *                            'screen', 'tty', or 'tv'.
     *                            
     * @since  1.0.0
     */
    public static function add_admin_footer_script( $handle, $src, $deps = [], $ver = null ) {
        self::add_admin_script( $handle, $src, $deps, $ver, true );
    }

    /**
     * @param string $handle      Script handle the data will be attached to.
     * @param string $object_name Name for the JavaScript object. Passed directly, so it should be qualified JS variable.
     *                            Example: '/[a-zA-Z0-9_]+/'.
     * @param array $data         The data itself. The data can be either a single or multi-dimensional array.
     * 
     * @since  1.0.0
     */
    public static function localize_admin_script( $handle, $object_name, $data ) {
        self::instance()->admin_script_localizations[] = [
            'handle' => $handle,
            'object_name' => $object_name,
            'data' => $data
        ];
    }


    /**
     * Enqueue all queued assets
     * 
     * @since  1.0.0
     */
    public function enqueue_scripts() {
        if ( is_admin() ) {

            if ( self::instance()->use_media ) {
                wp_enqueue_media();
            }

            foreach ( $this->admin_styles as $style ) {
                wp_enqueue_style( $style[ 'handle' ], $style[ 'src' ], $style[ 'deps' ], $style[ 'ver' ], $style[ 'media' ] );
            }

            foreach ( $this->admin_scripts as $script ) {
                wp_enqueue_script( $script[ 'handle' ], $script[ 'src' ], $script[ 'deps' ], $script[ 'ver' ], $script[ 'in_footer' ] );
            }

            foreach ( $this->admin_script_localizations as $localization ) {
                wp_localize_script( $localization[ 'handle' ], $localization[ 'object_name' ], $localization[ 'data' ] );
            }
        } else {
            if ( isset( $this->inline_css ) ) {
                preg_replace( "/<script.*?\/script>/s", '', $this->inline_css ) ? : $this->inline_css;
                wp_add_inline_style( 'theme_style', $this->inline_css );
            }
            foreach ( $this->wp_styles as $style ) {
                wp_enqueue_style( $style[ 'handle' ], $style[ 'src' ], $style[ 'deps' ], $style[ 'ver' ], $style[ 'media' ] );
            }

            foreach ( $this->wp_scripts as $script ) {
                wp_enqueue_script( $script[ 'handle' ], $script[ 'src' ], $script[ 'deps' ], $script[ 'ver' ], $script[ 'in_footer' ] );
            }
        }
    }

    /**
     * Remove 'script' tags and print footer inline script.
     * 
     * @since  1.0.0
     */
    public function wp_footer() {
        if ( isset( $this->inline_js ) ) {
            echo preg_replace( "/<script.*?\/script>/s", '', $this->inline_js ) ? : $this->inline_js;
        }
    }


    /**
     * Print a favicon link
     * 
     * @todo A modern list of favicons links
     * @since  1.0.0
     */
    public static function favicon() {
        $favicon_id = get_option( WELLCRAFTED . '_favicon' );
        
        if ( $favicon_id ) {
            $favicon = wp_get_attachment_url( $favicon_id );
        } else {
            $favicon = '/favicon.ico';
        }

        echo '<link href="' . $favicon . '" rel="shortcut icon" type="image/x-icon">';
    }


}
