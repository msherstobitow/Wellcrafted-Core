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
 * @todo PHPDoc
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
function wellcrafted_is_function_disabled( $function_name ) {
    $disabled_functions = explode( ',', str_replace( ' ', '', ini_get( 'disable_functions' ) ) );
    return in_array( $function_name, $disabled_functions );
}