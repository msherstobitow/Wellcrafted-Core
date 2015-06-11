<?php

class Wellcrafted_Admin_Notices {

    public static function add( $message, $type ) {
        add_action( 'admin_notices', function() use ( $message, $type )  {
            echo "<div class=\"$type\"> <p>$message</p></div>";
        } ); 
    }

    public static function error( $message ) {
        self::add( $message, 'error' );
    }

    public static function updated( $message ) {
        self::add( $message, 'updated' );
    }

    public static function update_nag( $message ) {
        self::add( $message, 'update-nag' );
    }
}