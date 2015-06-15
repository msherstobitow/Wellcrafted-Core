<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @todo PHPDoc
 */
class Wellcrafted_Registry {

    private $registry = [];
 
    public function __set( $key, $value ) {
        $this->registry[ $key ] = $value;
   }
 
   public function __get( $key ) {
        if ( ! isset( $this->registry[ $key ] ) ) {
            return '';
        }
 
        return $this->registry[ $key ];
    }

    public function get( $key, $default = '' ) {
        if ( ! isset( $this->registry[ $key ] ) ) {
            return $default;
        }
 
        return $this->registry[ $key ];
    }
}