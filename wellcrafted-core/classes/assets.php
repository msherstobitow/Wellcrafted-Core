<?php
defined('ABSPATH') or die();

/**
 * @todo  PHPDoc
 */
class Wellcrafted_Assets {

    use Wellcrafted_Singleton_Trait;

    private $version = '1.0.0';
    private $wp_styles = array();
    private $wp_scripts = array();
    private $admin_styles = array();
    private $admin_scripts = array();
    private $admin_script_localizations = array();
    private $use_media = false;
    private $inline_css = array();
    private $inline_js = array();

    public function __construct() {

        $this->inline_css = get_option( WELLCRAFTED . '_asset_inline_css', '' );
        $this->inline_js = get_option( WELLCRAFTED . '_asset_inline_js', '' );

        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
        } else {
            add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
            add_action( 'wp_footer', array( &$this, 'wp_footer' ) );
        }
    }

    public static function use_admin_media() {
        self::instance()->use_media = true;
    }

    public static function add_style( $handle, $src, $deps = array(), $ver = null, $media = null ) {
        self::instance()->wp_styles[] = array(
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'media' => $media,
        );
    }

    public static function add_admin_style( $handle, $src, $deps = array(), $ver = null, $media = null ) {
        if ( !in_array( 'wp-admin', $deps ) ) {
            $deps[] = 'wp-admin';
        }

        self::instance()->admin_styles[] = array(
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'media' => $media,
        );
    }

    public static function add_common_style( $handle, $src, $deps = array(), $ver = null, $media = null ) {
        if ( is_admin() ) {
            self::add_admin_style( $handle, $src, $deps, $ver, $media );
        } else {
            self::add_style( $handle, $src, $deps, $ver, $media );
        }
    }

    public static function add_script( $handle, $src, $deps = array(), $ver = null, $in_footer = false ) {
        self::instance()->wp_scripts[] = array(
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'in_footer' => ( bool )$in_footer,
        );
    }

    public static function add_admin_script( $handle, $src, $deps = array(), $ver = null, $in_footer = false ) {
        self::instance()->admin_scripts[] = [
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'in_footer' => ( bool )$in_footer,
        ];
    }
    
    public static function add_footer_script( $handle, $src, $deps = array(), $ver = null ) {
        self::add_script( $handle, $src, $deps, $ver, true );
    }
    
    public static function add_admin_footer_script( $handle, $src, $deps = array(), $ver = null ) {
        self::add_admin_script( $handle, $src, $deps, $ver, true );
    }

    public static function localize_admin_script( $handle, $object_name, $data ) {
        self::instance()->admin_script_localizations[] = [
            'handle' => $handle,
            'object_name' => $object_name,
            'data' => $data
        ];
    }

    // TODO: remove style tag if exists
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

    // TODO: remove script tag if exists
    public function wp_footer() {
        if ( isset( $this->inline_js ) ) {
            echo '<script>' . $this->inline_js . '</script>';
        }
    }

    /**
     * @todo A modern list of favicons links
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
