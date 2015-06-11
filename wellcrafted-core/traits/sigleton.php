<?php

trait Wellcrafted_Singleton_Trait {
    
    private static $instance;
 
    public static function instance() {
        if ( ! ( self::$instance instanceof self ) ) {
            self::$instance = new self;
        }
        
        return self::$instance;
    }
}