<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Check if an environment runs a compatible PHP vesrion
 */
function wellcrafted_check_php_version() {
    
    $wellcrafted_compatible_php_version = '7.3.0';

    if ( version_compare( PHP_VERSION, $wellcrafted_compatible_php_version, '<' ) ) {

        if ( is_plugin_active( plugin_basename( WELLCRAFTED_PLUGIN_BASENAME ) ) ) {

            deactivate_plugins( plugin_basename( WELLCRAFTED_PLUGIN_BASENAME ) );

            add_action( 'admin_notices', function () use ( $wellcrafted_compatible_php_version ) {
                $message = sprintf( 
                    __( 'Wellcrafted Core plugin requires PHP version at least %s. You have %s' , WELLCRAFTED ),
                    $wellcrafted_compatible_php_version,
                    PHP_VERSION );

                 echo "<div class=\"error\"> <p>$message</p></div>"; 
            } );

            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }

        }
    }
    
}