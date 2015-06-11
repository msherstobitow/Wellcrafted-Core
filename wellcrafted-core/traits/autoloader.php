<?php

trait Wellcrafted_Autoloader_Trait {
    
     /**
     * Add Wellcrafted autoloader to autoloader queue
     */
    private function run_autoloader() {

        spl_autoload_register( function ( $class ) {
            if ( strpos( $class, 'Wellcrafted_' ) === 0 ) {
                $folder = strpos( $class, '_Trait' ) === false ? 'classes' : 'traits';

                $reflection_class = new ReflectionClass( __CLASS__ );
                $filename = dirname( $reflection_class->getFileName() )  . '/../' . $folder . '/' . strtolower( str_replace( ['Wellcrafted_', '_Trait', '_'], [ '', '', '-'], $class ) ) . '.php';

                var_dump($filename);
                if ( file_exists( $filename ) ) {
                    require $filename;
                }
            }
        });
    }

}