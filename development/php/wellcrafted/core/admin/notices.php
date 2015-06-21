<?php

namespace Wellcrafted\Core\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Admin_Notices class allows to add admin area notices in an easy way.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Notices {

    /**
     * Print admin notice
     *
     * @since 1.0.0
     */
    public static function add( $message, $type ) {
        add_action( 'admin_notices', function() use ( $message, $type )  {
            echo "<div class=\"$type\"> <p>$message</p></div>";
        } ); 
    }

    /**
     * Print admin error notice
     *
     * @since 1.0.0
     */
    public static function error( $message ) {
        self::add( $message, 'error' );
    }

    /**
     * Print admin updated notice
     *
     * @since 1.0.0
     */
    public static function updated( $message ) {
        self::add( $message, 'updated' );
    }

    /**
     * Print admin updated nag notice
     *
     * @since 1.0.0
     */
    public static function update_nag( $message ) {
        self::add( $message, 'update-nag' );
    }
}