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
 * Return text/html content type for WordPress wp_mail function
 * 
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @since  1.0.0
 * @package Wellcrafted\Core
 */
function wellcrafted_set_html_content_type() {
    return 'text/html';
}