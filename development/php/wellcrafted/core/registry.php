<?php

namespace Wellcrafted\Core;

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Registry is a registry class. 
 * Each plugin class that inherits from Wellcrafted_Plugin class can have a registry to store variables which are accessible from anywhere.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Registry {

    /**
     * An array to caontain a registry data
     * @var array
     * @since  1.0.0
     */
    private $registry = [];
 
    /**
     * A magic method to set a registry variables.
     * 
     * @param mixed $key   A key of data value
     * @param mixed $value A value for a key
     * @since  1.0.0
     */
    public function __set( $key, $value ) {
        $this->registry[ $key ] = $value;
   }
 
    /**
     * A magic method to get a registry variables.
     * 
     * @param mixed $key   A key of data value
     * @since  1.0.0
     */
   public function __get( $key ) {
        if ( ! isset( $this->registry[ $key ] ) ) {
            return '';
        }
 
        return $this->registry[ $key ];
    }

     /**
     * Get a value from registry.
     *
     * A function also take a default value to return insted of an empty key
     * 
     * @param mixed $key   A key of data value
     * @param mixed $value A value for a key
     * @since  1.0.0
     */
    public function get( $key, $default = '' ) {
        if ( ! isset( $this->registry[ $key ] ) ) {
            return $default;
        }
 
        return $this->registry[ $key ];
    }
}