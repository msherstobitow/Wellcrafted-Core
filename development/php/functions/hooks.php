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
 * An alias to "add_action()" function.
 *
 * The function allows to pass an array of callbacks as a fucntion_to_add argument. All callbacks should accept the same parameters.
 *
 * @param string   $tag             The name of the action to which the $function_to_add is hooked.
 * @param callback $function_to_add The name of the function you wish to be called.
 * @param int      $priority        Optional. Used to specify the order in which the functions
 *                                  associated with a particular action are executed. Default 10.
 *                                  Lower numbers correspond with earlier execution,
 *                                  and functions with the same priority are executed
 *                                  in the order in which they were added to the action.
 * @param int      $accepted_args   Optional. The number of arguments the function accept. Default 1.
 * @return bool Will always return true.
 * 
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @since  1.0.0
 * @package Wellcrafted\Core
 */
function wellcrafted_add_action( $tag, $function_to_add,  $priority = 10, $accepted_args = 1 ) {
    if ( is_array( $function_to_add ) ) {
        foreach ( $function_to_add as $index => $callback ) {
            if ( is_array( $callback ) ) {
                add_action( $tag, [ $callback[0], $callback[1] ], $priority, $accepted_args );
            } else {
                add_action( $tag, $callback, $priority, $accepted_args );
            }
        }
    } else {
        add_action( $tag, $function_to_add, $priority, $accepted_args );
    }

    return true;
}

/**
 * An alias to "add_filter()" function.
 *
 * The function allows to pass an array of callbacks as a fucntion_to_add argument. All callbacks should accept the same parameters.
 *
 * @param string   $tag             The name of the action to which the $function_to_add is hooked.
 * @param callback $function_to_add The name of the function you wish to be called.
 * @param int      $priority        Optional. Used to specify the order in which the functions
 *                                  associated with a particular action are executed. Default 10.
 *                                  Lower numbers correspond with earlier execution,
 *                                  and functions with the same priority are executed
 *                                  in the order in which they were added to the action.
 * @param int      $accepted_args   Optional. The number of arguments the function accept. Default 1.
 * @return bool Will always return true.
 * 
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @since  1.0.0
 * @package Wellcrafted\Core
 */
function wellcrafted_add_filter( $tag, $function_to_add,  $priority = 10, $accepted_args = 1 ) {
    if ( is_array( $function_to_add ) ) {
        foreach ( $function_to_add as $index => $callback ) {
            if ( is_array( $callback ) ) {
                add_filter( $tag, [ $callback[0], $callback[1] ], $priority, $accepted_args );
            } else {
                add_filter( $tag, $callback, $priority, $accepted_args );
            }
        }
    } else {
        add_filter( $tag, $function_to_add, $priority, $accepted_args );
    }

    return true;
}