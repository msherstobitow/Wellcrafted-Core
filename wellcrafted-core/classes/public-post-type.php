<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Public_Post_Type is a base class for Wellcrafted Public Post Type classes.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Wellcrafted_Public_Post_Type extends Wellcrafted_Post_Type {
    /**
     * Controls how the type is visible to authors (show_in_nav_menus, show_ui) and readers (exclude_from_search, publicly_queryable).
     * 
     * @see https://codex.wordpress.org/Function_Reference/register_post_type
     * @var boolean
     * @since  1.0.0
     */
    protected $public = true;
}