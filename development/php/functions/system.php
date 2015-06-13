<?php

/**
 * @todo  PHPDoc
 */
function wellcrafted_is_function_disabled( $function_name ) {
    $disabled_functions = explode( ',', str_replace( ' ', '', ini_get( 'disable_functions' ) ) );
    return in_array( $function_name, $disabled_functions );
}