<?php

/**
 * @todo  PHPDoc
 */
trait Wellcrafted_Singleton_Trait {
 
    public static function instance() {
        static $instance = null;

        if ( ! $instance ) {
            $instance = new self;
        }

        return $instance;
    }
}