<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */

/**
 * Get an array value if key exists or return a default value
 * @param  array $array     Array to search in
 * @param  scalar $key      A key of an array
 * @param  string $default  Default value to return if a key doesn't exists
 * @return mixed            A value of an array or a default value
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @since  1.0.0
 * @package Wellcrafted\Core
 */
function wellcrafted_array_value( $array, $key, $default = '' ) {
    if ( is_array( $array ) && isset( $array[ $key ] ) ) {
        return $array[ $key ];
    }

    return $default;
}

/**
 * Insert an array to an array at a desired position
 * 
 * @param  array                $array      Array to insert in
 * @param  integer or string    $position   An integer or a string key position to insert after
 * @param  array                $insert     An array to insert
 * @param  boolean              $before     Should an item be instrted before a position. It works only on non-integer position.
 * @return array                            Modified array
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @since  1.0.0
 * @package Wellcrafted\Core
 * 
 */
function wellcrafted_insert_to_array( $array, $position, $insert, $before = false ) {
    if ( ! is_array( $array ) ) {
        return $array;
    }

    if ( ! is_int( $position ) ) {
        $position = (int)array_search( $position, array_keys( $array ) ) ;

        if ( ! $before ) {
            $position++;
        }
    }

    $array = array_merge(
        array_slice( $array, 0, $position ),
        $insert,
        array_slice( $array, $position )
    );

    return $array;
}