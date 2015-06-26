<?php

namespace Wellcrafted\Core\Taxonomy;

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Category is a taxonomy class to represent hierarchical taxonomies (aka categories)
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Category extends \Wellcrafted\Core\Taxonomy {

    /**
     * Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags. 
     * Hierarchical taxonomies will have a list with checkboxes to select an existing category in the taxonomy admin box on the post edit page (like default post categories). Non-hierarchical taxonomies will just have an empty text field to type-in taxonomy terms to associate with the post (like default post tags). 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $hierarchical = true;

}