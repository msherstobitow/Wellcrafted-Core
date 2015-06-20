<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Plugin_Template_Loader is a class to load plugin templates basing on plugin system name.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Wellcrafted_Plugin_Template_Loader {

    protected $templates_folder = '';

    public function __construct( $plugin_system_name ) {
        add_filter( 'template_include', array( __CLASS__, 'template_loader' ) );
    }

    /**
     * Load a template.
     *
     * @param mixed $template
     * @return string
     */
    public static function template_loader( $template ) {
        return $template;
        $find = array( 'woocommerce.php' );
        $file = '';

        if ( is_single() && get_post_type() == 'product' ) {

            $file   = 'single-product.php';
            $find[] = $file;
            $find[] = WC()->template_path() . $file;

        } elseif ( is_product_taxonomy() ) {

            $term   = get_queried_object();

            if ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
                $file = 'taxonomy-' . $term->taxonomy . '.php';
            } else {
                $file = 'archive-product.php';
            }

            $find[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
            $find[] = WC()->template_path() . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
            $find[] = 'taxonomy-' . $term->taxonomy . '.php';
            $find[] = WC()->template_path() . 'taxonomy-' . $term->taxonomy . '.php';
            $find[] = $file;
            $find[] = WC()->template_path() . $file;

        } elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {

            $file   = 'archive-product.php';
            $find[] = $file;
            $find[] = WC()->template_path() . $file;

        }

        if ( $file ) {
            $template       = locate_template( array_unique( $find ) );
            if ( ! $template || WC_TEMPLATE_DEBUG_MODE ) {
                $template = WC()->plugin_path() . '/templates/' . $file;
            }
        }

        return $template;
    }

}