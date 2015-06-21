<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Admin_Taxonomy creates a taxonomy to be visible just in admin area
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Wellcrafted_Admin_Taxonomy extends Wellcrafted_Taxonomy {
    /**
     * True makes this taxonomy available for selection in navigation menus.
     * If not set, defaults to value of public argument 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_in_nav_menus = false;

    /**
     * Whether to allow the Tag Cloud widget to use this taxonomy. 
     * If not set, defaults to value of show_ui argument 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_tagcloud = false;
}