<?php

namespace Wellcrafted\Core;

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Taxonomy is a base class for Wellcrafted Taxonomy classes
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Taxonomy {

    /**
     * The name of the taxonomy. Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long (database structure restriction). 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $taxonomy = '';

    /**
     * Name of the object type for the taxonomy object. Object-types can be built-in Post Type or any Custom Post Type that may be registered. 
     * 
     * @var string or array
     * @since  1.0.0
     */
    protected $object_type = '';
    
    /**
     * A plural descriptive name for the taxonomy marked for translation. 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $label = '';

    /**
     * General name for the taxonomy, usually plural. The same as and overridden by $tax->label. Default is _x( 'Post Tags', 'taxonomy general name' ) or _x( 'Categories', 'taxonomy general name' ). When internationalizing this string, please use a gettext context matching your post type. Example: _x('Writers', 'taxonomy general name');
     * 
     * @var string
     * @since  1.0.0
     */
    protected $name_label = '';
    
    /**
     * Name for one object of this taxonomy. Default is _x( 'Post Tag', 'taxonomy singular name' ) or _x( 'Category', 'taxonomy singular name' ). When internationalizing this string, please use a gettext context matching your post type. Example: _x('Writer', 'taxonomy singular name');
     * 
     * @var string
     * @since  1.0.0
     */
    protected $singular_name_label = '';
    
    /**
     * The menu name text. This string is the name to give menu items. If not set, defaults to value of name label. 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $menu_name_label = '';
    
    /**
     * The all items text. Default is __( 'All Tags' ) or __( 'All Categories' )
     * 
     * @var string
     * @since  1.0.0
     */
    protected $all_items_label = '';
    
    /**
     * The edit item text. Default is __( 'Edit Tag' ) or __( 'Edit Category' )
     * 
     * @var string
     * @since  1.0.0
     */
    protected $edit_item_label = '';
    
    /**
     * The view item text, Default is __( 'View Tag' ) or __( 'View Category' )
     * 
     * @var string
     * @since  1.0.0
     */
    protected $view_item_label = '';
    
    /**
     * The update item text. Default is __( 'Update Tag' ) or __( 'Update Category' )
     * 
     * @var string
     * @since  1.0.0
     */
    protected $update_item_label = '';
    
    /**
     * The add new item text. Default is __( 'Add New Tag' ) or __( 'Add New Category' )
     * 
     * @var string
     * @since  1.0.0
     */
    protected $add_new_item_label = '';
    
    /**
     * The new item name text. Default is __( 'New Tag Name' ) or __( 'New Category Name' )
     * 
     * @var string
     * @since  1.0.0
     */
    protected $new_item_name_label = '';
    
    /**
     * The parent item text. This string is not used on non-hierarchical taxonomies such as post tags. Default is null or __( 'Parent Category' )
     * 
     * @var string
     * @since  1.0.0
     */
    protected $parent_item_label = '';
    
    /**
     * The same as parent_item, but with colon : in the end null, __( 'Parent Category:' )
     * 
     * @var string
     * @since  1.0.0
     */
    protected $parent_item_colon_label = '';
    
    /**
     * The search items text. Default is __( 'Search Tags' ) or __( 'Search Categories' )
     * 
     * @var string
     * @since  1.0.0
     */
    protected $search_items_label = '';
    
    /**
     * The popular items text. This string is not used on hierarchical taxonomies. Default is __( 'Popular Tags' ) or null 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $popular_items_label = '';
    
    /**
     * The separate item with commas text used in the taxonomy meta box. This string is not used on hierarchical taxonomies. Default is __( 'Separate tags with commas' ), or null 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $separate_items_with_commas_label = '';
    
    /**
     * The add or remove items text and used in the meta box when JavaScript is disabled. This string is not used on hierarchical taxonomies. Default is __( 'Add or remove tags' ) or null 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $add_or_remove_items_label = '';
    
    /**
     * The choose from most used text used in the taxonomy meta box. This string is not used on hierarchical taxonomies. Default is __( 'Choose from the most used tags' ) or null 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $choose_from_most_used_label = '';
    
    /**
     * The text displayed via clicking 'Choose from the most used tags' in the taxonomy meta box when no tags are available and (4.2+) - the text used in the terms list table when there are no items for a taxonomy. Default is __( 'No tags found.' ) or __( 'No categories found.' )
     * 
     * @var string
     * @since  1.0.0
     */
    protected $not_found_label = '';
    
    /**
     * If the taxonomy should be publicly queryable. 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $public = true;
    
    /**
     * Whether to generate a default UI for managing this taxonomy. 
     * If not set, defaults to value of public argument. As of 3.5, setting this to false for attachment taxonomies will hide the UI. 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_ui = null;
    
    /**
     * True makes this taxonomy available for selection in navigation menus.
     * If not set, defaults to value of public argument 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_in_nav_menus = null;
    
    /**
     * Whether to allow the Tag Cloud widget to use this taxonomy. 
     * If not set, defaults to value of show_ui argument 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_tagcloud = null;
    
    /**
     * Whether to show the taxonomy in the quick/bulk edit panel. (Available since 4.2) 
     * If not set, defaults to value of show_ui argument 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_in_quick_edit = null;
    
    /**
     * Provide a callback function name for the meta box display. (Available since 3.8) 
     * Defaults to the categories meta box (post_categories_meta_box() in meta-boxes.php) for hierarchical taxonomies and the tags meta box (post_tags_meta_box()) for non-hierarchical taxonomies. No meta box is shown if set to false. 
     * 
     * @var null
     * @since  1.0.0
     */
    protected $meta_box_cb = null;
    
    /**
     * Whether to allow automatic creation of taxonomy columns on associated post-types table. (Available since 3.5) 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_admin_column = false;
    
    /**
     * Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags. 
     * Hierarchical taxonomies will have a list with checkboxes to select an existing category in the taxonomy admin box on the post edit page (like default post categories). Non-hierarchical taxonomies will just have an empty text field to type-in taxonomy terms to associate with the post (like default post tags). 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $hierarchical = false;
    
    /**
     * A function name that will be called when the count of an associated $object_type, such as post, is updated. Works much like a hook. 
     * While the default is '', when actually performing the count update in wp_update_term_count_now(), if the taxonomy is only attached to post types (as opposed to other WordPress objects, like user), the built-in _update_post_term_count() function will be used to count only published posts associated with that term, otherwise _update_generic_term_count() will be used instead, that does no such checking.
     * This is significant in the case of attachments. Because an attachment is a type of post, the default _update_post_term_count() will be used. However, this may be undesirable, because this will only count attachments that are actually attached to another post (like when you insert an image into a post). This means that attachments that you simply upload to WordPress using the Media Library, but do not actually attach to another post will not be counted. If your intention behind associating a taxonomy with attachments was to leverage the Media Library as a sort of Document Management solution, you are probably more interested in the counts of unattached Media items, than in those attached to posts. In this case, you should force the use of _update_generic_term_count() by setting '_update_generic_term_count' as the value for update_count_callback. 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $update_count_callback = '';
    
    /**
     * False to disable the query_var, set as string to use custom query_var instead of default which is $taxonomy, the taxonomy's "name". 
     * The query_var is used for direct queries through WP_Query like new WP_Query(array('people'=>$person_name)) and URL queries like /?people=$person_name. Setting query_var to false will disable these methods, but you can still fetch posts with an explicit WP_Query taxonomy query like WP_Query(array('taxonomy'=>'people', 'term'=>$person_name)). 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $query_var = null;
    
    /**
     * Set to false to prevent automatic URL rewriting a.k.a. "pretty permalinks". Pass an $args array to override default URL settings for permalinks as outlined below:
     *     'slug' - Used as pretty permalink text (i.e. /tag/) - defaults to $taxonomy (taxonomy's name slug)
     *     'with_front' - allowing permalinks to be prepended with front base - defaults to true
     *     'hierarchical' - true or false allow hierarchical urls (implemented in Version 3.1) - defaults to false
     *     'ep_mask' - (Required for pretty permalinks) Assign an endpoint mask for this taxonomy - defaults to EP_NONE. If you do not specify the EP_MASK, pretty permalinks will not work. For more info see this Make WordPress Plugins summary of endpoints.
     *     You may need to flush the rewrite rules after changing this. You can do it manually by going to the Permalink Settings page and re-saving the rules -- you don't need to change them -- or by calling $wp_rewrite->flush_rules(). You should only flush the rules once after the taxonomy has been created, not every time the plugin/theme loads.
     * 
     * @var boolean or array
     * @since  1.0.0
     */
    protected $rewrite = true;
    
    /**
     * An array of the capabilities for this taxonomy. 
     *    'manage_terms' - 'manage_categories'
     *    'edit_terms' - 'manage_categories'
     *    'delete_terms' - 'manage_categories'
     *    'assign_terms' - 'edit_posts'
     * 
     * @var array
     * @since  1.0.0
     */
    protected $capabilities = [];
    
    /**
     * Whether this taxonomy should remember the order in which terms are added to objects. 
     * 
     * @var null
     * @since  1.0.0
     */
    protected $sort = null;

    /**
     * Avoiding the following reserved terms is particularly important if you are passing the term through the $_GET or $_POST array. Doing so can cause WordPress to respond with a 404 error without any other hint or explanation. 
     * 
     * @var array
     * @since  1.0.0
     */
    protected static $reserved_terms = [
        'attachment',
        'attachment_id',
        'author',
        'author_name',
        'calendar',
        'cat',
        'category',
        'category__and',
        'category__in',
        'category__not_in',
        'category_name',
        'comments_per_page',
        'comments_popup',
        'customize_messenger_channel',
        'customized',
        'cpage',
        'day',
        'debug',
        'error',
        'exact',
        'feed',
        'fields',
        'hour',
        'link_category',
        'm',
        'minute',
        'monthnum',
        'more',
        'name',
        'nav_menu',
        'nonce',
        'nopaging',
        'offset',
        'order',
        'orderby',
        'p',
        'page',
        'page_id',
        'paged',
        'pagename',
        'pb',
        'perm',
        'post',
        'post__in',
        'post__not_in',
        'post_format',
        'post_mime_type',
        'post_status',
        'post_tag',
        'post_type',
        'posts',
        'posts_per_archive_page',
        'posts_per_page',
        'preview',
        'robots',
        's',
        'search',
        'second',
        'sentence',
        'showposts',
        'static',
        'subpost',
        'subpost_id',
        'tag',
        'tag__and',
        'tag__in',
        'tag__not_in',
        'tag_id',
        'tag_slug__and',
        'tag_slug__in',
        'taxonomy',
        'tb',
        'term',
        'theme',
        'type',
        'w',
        'withcomments',
        'withoutcomments',
        'year'
    ];

    /**
     * Taxonomy params array.
     * 
     * @var array
     * @since  1.0.0
     */
    protected $taxonomy_params = [];

    public function __construct() {
        /**
         * Normalize a taxonomy value. The value will be unspaced and cut to 32 chars as it is WordPress requirements.
         *
         * @see  https://codex.wordpress.org/Function_Reference/register_taxonomy An official Codex page
         */
        $this->taxonomy = substr( str_replace( ' ', '', strtolower( $this->taxonomy ) ), 0, 32 );

        if ( null == $this->taxonomy || 
            in_array( $this->taxonomy, self::$reserved_terms ) ) {
            return;
        }

        $this->set_params();
        $this->normalize_params();
        $this->create_params();

        if ( empty( $this->taxonomy_params ) ) {
            return;
        }

        add_action( 'wellcrafted_core_register_taxonomy', array( &$this, 'register_taxonomy' ) );

        $this->init();
    }

    /**
     * Init function for child classes
     * 
     * @since  1.0.0
     */
    protected function init() {}

    /**
     * Allows to set params before normalizing
     * 
     * @since  1.0.0
     */
    protected function set_params() {}

    /**
     * Normaliaze a taxonomy parameters in accordance width WordPress Codex
     *
     * @see  https://codex.wordpress.org/Function_Reference/register_taxonomy An official Codex page
     * @since  1.0.0
     */
    protected function normalize_params() {
        if ( $this->hierarchical ) {
            $this->name_label = $this->name_label ? $this->name_label : _x( 'Categories', 'taxonomy general name' );
            $this->singular_name_label = $this->singular_name_label ? $this->singular_name_label : _x( 'Category', 'taxonomy singular name' );
            $this->all_items_label = $this->all_items_label ? $this->all_items_label : __( 'All Categories' );
            $this->edit_item_label = $this->edit_item_label ? $this->edit_item_label : __( 'Edit Category' );
            $this->view_item_label = $this->view_item_label ? $this->view_item_label : __( 'View Category' );
            $this->update_item_label = $this->update_item_label ? $this->update_item_label : __( 'Update Category' );
            $this->add_new_item_label = $this->add_new_item_label ? $this->add_new_item_label : __( 'Add New Category' );
            $this->new_item_name_label = $this->new_item_name_label ? $this->new_item_name_label : __( 'New Category Name' );
            $this->parent_item_label = $this->parent_item_label ? $this->parent_item_label : __( 'Parent Category' );
            $this->parent_item_colon_label = $this->parent_item_colon_label ? $this->parent_item_colon_label : __( 'Parent Category:' );
            $this->search_items_label = $this->search_items_label ? $this->search_items_label : __( 'Search Categories' );
            $this->not_found_label = $this->not_found_label ? $this->not_found_label : __( 'No categories found.' );
        } else {
            $this->name_label = $this->name_label ? $this->name_label : _x( 'Post Tags', 'taxonomy general name' );
            $this->singular_name_label = $this->singular_name_label ? $this->singular_name_label : _x( 'Post Tag', 'taxonomy singular name' );
            $this->all_items_label = $this->all_items_label ? $this->all_items_label : __( 'All Tags' );
            $this->edit_item_label = $this->edit_item_label ? $this->edit_item_label : __( 'Edit Tag' );
            $this->view_item_label = $this->view_item_label ? $this->view_item_label : __( 'View Tag' );
            $this->update_item_label = $this->update_item_label ? $this->update_item_label : __( 'Update Tag' );
            $this->add_new_item_label = $this->add_new_item_label ? $this->add_new_item_label : __( 'Add New Tag' );
            $this->new_item_name_label = $this->new_item_name_label ? $this->new_item_name_label : __( 'New Tag Name' );
            $this->search_items_label = $this->search_items_label ? $this->search_items_label : __( 'Search Tags' );
            $this->popular_items_label = $this->popular_items_label ? $this->popular_items_label : __( 'Popular Tags' );
            $this->separate_items_with_commas_label = $this->separate_items_with_commas_label ? $this->separate_items_with_commas_label : __( 'Separate tags with commas' );
            $this->add_or_remove_items_label = $this->add_or_remove_items_label ? $this->add_or_remove_items_label : __( 'Add or remove tags' );
            $this->choose_from_most_used_label = $this->choose_from_most_used_label ? $this->choose_from_most_used_label : __( 'Choose from the most used tags' );
            $this->not_found_label = $this->not_found_label ? $this->not_found_label : __( 'No tags found.' );

        }

        $this->label = $this->label ? $this->label : $this->name_label;
        $this->menu_name_label = $this->menu_name_label ? $this->menu_name_label : $this->name_label;

        $this->show_ui = null !== $this->show_ui ? $this->show_ui : $this->public;
        $this->show_in_nav_menus = null !== $this->show_in_nav_menus ? $this->show_in_nav_menus : $this->public;
        $this->show_tagcloud = null !== $this->show_tagcloud ? $this->show_tagcloud : $this->show_ui;
        $this->show_in_quick_edit = null !== $this->show_in_quick_edit ? $this->show_in_quick_edit : $this->show_ui;
        $this->query_var = null !== $this->query_var ? $this->query_var : $this->taxonomy;

    }

    /**
     * Create taxonomy params for registering function
     * 
     * @since  1.0.0
     */
    protected function create_params() {
        $labels = [
            'name' => $this->name_label,
            'singular_name' => $this->singular_name_label,
            'menu_name' => $this->menu_name_label,
            'all_items' => $this->all_items_label,
            'edit_item' => $this->edit_item_label,
            'view_item' => $this->view_item_label,
            'update_item' => $this->update_item_label,
            'add_new_item' => $this->add_new_item_label,
            'new_item_name' => $this->new_item_name_label,
            'parent_item' => $this->parent_item_label,
            'parent_item_colon' => $this->parent_item_colon_label,
            'search_items' => $this->search_items_label,
            'popular_items' => $this->popular_items_label,
            'separate_items_with_commas' => $this->separate_items_with_commas_label,
            'add_or_remove_items' => $this->add_or_remove_items_label,
            'choose_from_most_used' => $this->choose_from_most_used_label,
            'not_found' => $this->not_found_label
        ];

        $this->taxonomy_params = [
            'label' => $this->label,
            'labels' => $labels,
            'public' => $this->public,
            'show_ui' => $this->show_ui,
            'show_in_nav_menus' => $this->show_in_nav_menus,
            'show_tagcloud' => $this->show_tagcloud,
            'show_in_quick_edit' => $this->show_in_quick_edit,
            'meta_box_cb' => $this->meta_box_cb,
            'show_admin_column' => $this->show_admin_column,
            'hierarchical' => $this->hierarchical,
            'update_count_callback' => $this->update_count_callback,
            'query_var' => $this->query_var,
            'rewrite' => $this->rewrite,
            'capabilities' => $this->capabilities,
            'sort' => $this->sort
        ];


    }

    /**
     * Register current class taxonomy
     * 
     * @since  1.0.0
     */
    public function register_taxonomy() {
        register_taxonomy( $this->taxonomy, [ $this->object_type ], $this->taxonomy_params );
        self::$reserved_terms[] = $this->taxonomy;
    }

}