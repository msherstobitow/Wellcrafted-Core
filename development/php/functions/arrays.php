<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get an array value if key exists or return a default vakue
 * @param  array $array     Array to search in
 * @param  scalar $key      A key of an array
 * @param  string $default  Default value to return if a key doesn't exists
 * @return mixed            A value of an array or a default value
 *
 * @todo  write PHPDoc
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
 * @return array                            Modified array
 */
function wellcrafted_insert_to_array( $array, $position, $insert ) {
    if ( ! is_array( $array ) ) {
        return $array;
    }

    if ( ! is_int( $position ) ) {
        $position = (int)array_search( $position, array_keys( $array ) ) + 1;
    }

    $array = array_merge(
        array_slice( $array, 0, $position ),
        $insert,
        array_slice( $array, $position )
    );

    return $array;
}