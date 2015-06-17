<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Singleton_Trait add into a class Singleton pattern ability
 * 
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 * @see https://en.wikipedia.org/wiki/Singleton_pattern
 */
trait Wellcrafted_Singleton_Trait {

    /**
     * Create an instance of a class object (if not initialized) and return 
     * a class object
     */
    public static function instance() {
        static $instance = null;

        if ( ! $instance ) {
            $instance = new self;
        }

        return $instance;
    }

}