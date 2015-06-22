<?php

namespace Wellcrafted\Core\Post;

use Wellcrafted\Core\Core as Core;
use Wellcrafted\Core\Assets as Assets;
use Wellcrafted\Core\Theme\Supports as Theme_Supports;

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Post_Type is a base class for Wellcrafted Post Type classes.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Core
 */
class Type {

    /**
     * Post type. (max. 20 characters, cannot contain capital letters or spaces) 
     * 
     * @var null
     * @since  1.0.0
     */
    protected $post_type = null;

    /**
     * General name for the post type, usually plural. The same as, and overridden by $post_type_object->label 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $name_label = '';

    /**
     * Name for one object of this post type. Defaults to value of 'name'. 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $singular_name_label = '';

    /**
     * The menu name text. This string is the name to give menu items. Defaults to a value of 'name'. 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $menu_name_label = '';

    /**
     * Name given for the "Add New" dropdown on admin bar. Defaults to 'singular_name' if it exists, 'name' otherwise. 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $name_admin_bar_label = '';

    /**
     * The all items text used in the menu. Default is the value of 'name'.
     * 
     * @var string
     * @since  1.0.0
     */
    protected $all_items_label = '';

    /**
     * The add new text. The default is "Add New" for both hierarchical and non-hierarchical post types. 
     * When internationalizing this string, please use a gettext context matching your post type. 
     * 
     * Example: _x('Add New', 'product');
     * 
     * @var string
     * @since  1.0.0
     */
    protected $add_new_label = '';

    /**
     * The add new item text. Default is Add New Post/Add New Page 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $add_new_item_label = '';

    /**
     * The new item text. Default is "New Post" for non-hierarchical and "New Page" for hierarchical post types. 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $new_item_label = '';

    /**
     * The edit item text. In the UI, this label is used as the main header on the post's editing panel. 
     * The default is "Edit Post" for non-hierarchical and "Edit Page" for hierarchical post types. 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $edit_item_label = '';

    /**
     * The view item text. Default is View Post/View Page 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $view_item_label = '';

    /**
     * The search items text. Default is Search Posts/Search Pages
     * 
     * @var string
     * @since  1.0.0
     */
    protected $search_items_label = '';

    /**
     * The parent text. This string is used only in hierarchical post types. Default is "Parent Page". 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $parent_item_colon_label = '';

    /**
     * The not found text. Default is No posts found/No pages found 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $not_found_label = '';

    /**
     * The not found in trash text. Default is No posts found in Trash/No pages found in Trash. 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $not_found_in_trash_label = '';

    /**
     * Controls how the type is visible to authors (show_in_nav_menus, show_ui) and readers (exclude_from_search, publicly_queryable).
     * 
     * @see https://codex.wordpress.org/Function_Reference/register_post_type
     * @var boolean
     * @since  1.0.0
     */
    protected $public = false;

    /**
     * Whether to exclude posts with this post type from front end search results. 
     * 
     * @var null
     * @since  1.0.0
     */
    protected $exclude_from_search = null;

    /**
     * Whether queries can be performed on the front end as part of parse_request(). 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $publicly_queryable = null;

    /**
     * Whether to generate a default UI for managing this post type in the admin. 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_ui = null;

    /**
     * Whether post_type is available for selection in navigation menus.
     * 
     * @var null
     * @since  1.0.0
     */
    protected $show_in_nav_menus = null;

    /**
     * Where to show the post type in the admin menu. show_ui must be true. 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_in_menu = null;

    /**
     * Whether to make this post type available in the WordPress admin bar. 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_in_admin_bar = null;

    /**
     * Sets the query_var key for this post type. 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $query_var = true;

    /**
     * The string to use to build the read, edit, and delete capabilities. May be passed as an array to allow for alternative plurals when using this argument as a base to construct the capabilities, e.g. array('story', 'stories') the first array element will be used for the singular capabilities and the second array element for the plural capabilities, this is instead of the auto generated version if no array is given which would be "storys". The 'capability_type' parameter is used as a base to construct capabilities unless they are explicitly set with the 'capabilities' parameter. It seems that `map_meta_cap` needs to be set to true, to make this work. 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $capability_type = 'post';

    /**
     * An array of the capabilities for this post type. 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $capabilities = [];

    /**
     * Whether to use the internal default meta capability handling.
     * 
     * @var null
     * @since  1.0.0
     */
    protected $map_meta_cap = null;

    /**
     * Enables post type archives. Will use $post_type as archive slug by default. 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $has_archive = false;

    /**
     * Whether the post type is hierarchical (e.g. page). Allows Parent to be specified. The 'supports' parameter should contain 'page-attributes' to show the parent select box on the editor page. 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $hierarchical = false;

    /**
     * Provide a callback function that will be called when setting up the meta boxes for the edit form. The callback function takes one argument $post, which contains the WP_Post object for the currently edited post. Do remove_meta_box() and add_meta_box() calls in the callback. 
     * 
     * @var null
     * @since  1.0.0
     */
    protected $register_meta_box_cb = null;

    /**
     * An array of registered taxonomies like category or post_tag that will be used with this post type. This can be used in lieu of calling register_taxonomy_for_object_type() directly. Custom taxonomies still need to be registered with register_taxonomy(). 
     * 
     * @var array
     * @since  1.0.0
     */
    protected $taxonomies = [];
    
    /**
     * The url to the icon to be used for this menu or the name of the icon from the iconfont
     * 
     * @var null
     * @see http://melchoyce.github.io/dashicons/
     * @since  1.0.0
     */
    protected $menu_icon = null;

    /**
     * The position in the menu order the post type should appear. show_in_menu must be true. 
     * 
     * @var null
     * @since  1.0.0
     */
    protected $menu_position = null;

    /**
     * An alias for calling add_post_type_support() directly. As of 3.5, boolean false can be passed as value instead of an array to prevent default (title and editor) behavior. 
     * 
     * Avaialble supports:
     *     'title'
     *     'editor' (content)
     *     'author'
     *     'thumbnail' (featured image, current theme must also support post-thumbnails https://codex.wordpress.org/Post_Thumbnails)
     *     'excerpt'
     *     'trackbacks'
     *     'custom-fields'
     *     'comments' (also will see comment count balloon on edit screen)
     *     'revisions' (will store revisions)
     *     'page-attributes' (menu order, hierarchical must be true to show Parent option)
     *     'post-formats' add post formats, see Post Formats https://codex.wordpress.org/Post_Formats
     * 
     * @var array
     * @since  1.0.0
     */
    protected $supports = [ 'title', 'editor' ];
    
    /**
     * Adds extra supports to defaults
     * 
     * @var array
     * @since  1.0.0
     */
    protected $extra_supports = [];

    /**
     * Triggers the handling of rewrites for this post type. To prevent rewrites, set to false. 
     * 
     * @var array
     * @since  1.0.0
     */
    protected $rewrite = true;

    /**
     * Can this post_type be exported. 
     * 
     * @var array
     * @since  1.0.0
     */
    protected $can_export = true;

    /**
     * Params to create a post type
     * 
     * @var array
     * @since  1.0.0
     */
    protected $post_type_params = [];

    /**
     * Whether to use meta boxes with this post type
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_meta_boxes = false;

    /**
     * Whether to use a featured image column. It will be shown if a post type supports thumbnails.
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_thumbnail_column = true;

    /**
     * A key for a post type meta boxes nonce
     * 
     * @var string
     * @since  1.0.0
     */
    protected $meta_boxes_nonce_action = '';

    /**
     * Whether a script was localized.
     * 
     * @var boolean
     * @since  1.0.0
     */
    private $is_script_localized = false;

    /**
     * The following post types are reserved and used by WordPress already.
     * In general, you should always prefix your post types, or specify a custom `query_var`, to avoid conflicting with existing WordPress query variables.
     * Also, if the post type contains dashes you will not be able to add columns to the custom post type's admin page (using the 'manage_<Custom Post Type Name>_posts_columns' action). 
     * 
     * @var array
     * @since  1.0.0
     */
    protected static $reserved_post_types = [
        'post',
        'page',
        'attachment',
        'revision',
        'nav_menu_item',
        'action',
        'author',
        'order',
        'theme'
    ];


    public function __construct() {
        /**
         * Normalize a post type value. The value will be unspaced and cut to 32 chars as it is WordPress requirements.
         *
         * @see https://codex.wordpress.org/Function_Reference/register_post_type An official Codex page.
         */
        $this->post_type = substr( str_replace( ' ', '', strtolower( $this->post_type ) ), 0, 20 );

        if ( null == $this->post_type || 
            in_array( $this->post_type, self::$reserved_post_types ) ) {
            return;
        }


        $this->set_params();
        $this->normalize_params();
        $this->create_params();
        $this->add_theme_support();

        if ( empty( $this->post_type_params ) ) {
            return;
        }

        add_action( 'wellcrafted_core_register_post_types', [ &$this, 'register_post_type' ] );

        wellcrafted_add_action( 
            'manage_' . $this->post_type . '_posts_columns' , 
            [
                [ &$this, 'modify_columns' ], 
                [ &$this, 'add_thumbnail_column' ], 
            ]
        );

        wellcrafted_add_filter( 
            'manage_' . $this->post_type . '_posts_custom_column', 
            [ 
                [ &$this, 'edit_column' ],
                [ &$this, 'add_thumbnail_column_image' ],
            ],
            10,
            2
        );

        if ( $this->use_meta_boxes ) {
            add_action( 'add_meta_boxes', [ &$this, 'add_meta_boxes' ] );
            add_action( 'save_post', [ &$this, 'pre_save_meta_boxes_data'] );
        }

        $this->init();
        $this->localize_script();

    }

    /**
     * Add a wellcrafted_post_type.current_post_type javascript variable to a add/edit post screen.
     * 
     * @since  1.0.0
     */
    private function localize_script() {
        if ( ! $this->is_script_localized && is_admin() ) {

            add_action( 'admin_enqueue_scripts', function() {
                global $pagenow;

                if ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) {
                    global $post_type;
                }

                if ( isset( $post_type ) && $this->post_type === $post_type ) {
                    Assets::localize_admin_script(
                        Core::registry()->plugin_system_name . '_base_admin_script', 
                        'wellcrafted_post_type', 
                        [ 
                            'current_post_type' => $post_type
                        ]
                    );
                }
            }, 0);
            
            $this->is_script_localized = true;
        }
    }

    /**
     * Init function for child classes
     * 
     * @since  1.0.0
     */
    protected function init() {}

    /**
     * Allows to modify columns to show on post type items list
     * 
     * @param  array $columns columns to show
     * @since  1.0.0
     */
    public function modify_columns( $columns ) {
        return $columns;
    }

    public function add_thumbnail_column( $columns ) {
        if ( in_array( 'thumbnail', $this->supports ) ) {
            return wellcrafted_insert_to_array( 
                $columns, 
                'title', 
                [ WELLCRAFTED . '_featured_image' => __( 'Image', WELLCRAFTED ) ],
                true
            );
        }

        return $columns;
    }

    /**
     * Allows to edit columns data
     * 
     * @param  array    $column column to show
     * @param  int      $post_id An ID of a post 
     * @return array $column
     * @since  1.0.0
     */
    public function edit_column( $column, $post_id ) {
        return $column;
    }

    /**
     * Allows to edit columns data
     * 
     * @param  array    $column column to show
     * @param  int      $post_id An ID of a post 
     * @return array $column
     * @since  1.0.0
     */
    public function add_thumbnail_column_image( $column, $post_id ) {
        if ( WELLCRAFTED . '_featured_image' === $column ) {
            $image = wellcrafted_get_featured_image_src( $post_id );
            if ( $image ) {
                require Core::instance()->get_plugin_path() . '/views/thumbnail_column_image.php';
            }
        }
        return $column;
    }

    /**
     * Allows to set params before normalizing
     * 
     * @since  1.0.0
     */
    protected function set_params() {}

    /**
     * Normaliaze a post type parameters in accordance width WordPress Codex
     *
     * @see  https://codex.wordpress.org/Function_Reference/register_post_type An official Codex page
     * @since  1.0.0
     */
    protected function normalize_params() {
        $this->name_label = $this->name_label ? $this->name_label : $this->post_type;
        $this->singular_name_label = $this->singular_name_label ? $this->singular_name_label : $this->name_label;
        $this->menu_name_label = $this->menu_name_label ? $this->menu_name_label : $this->name_label;
        $this->name_admin_bar_label = $this->name_admin_bar_label ? $this->name_admin_bar_label : $this->singular_name_label;
        $this->all_items_label = $this->all_items_label ? $this->all_items_label : $this->name_label;
        $this->view_item_label = '' !== $this->view_item_label ? $this->view_item_label : __( 'View', WELLCRAFTED );
        $this->show_ui = null !== $this->show_ui ? $this->show_ui : $this->public;
        $this->show_in_nav_menus = null !== $this->show_ui ? $this->show_in_nav_menus : $this->public;
        $this->show_in_menu = null !== $this->show_in_menu ? $this->show_in_menu : $this->show_ui;
        $this->show_in_admin_bar = null !== $this->show_in_admin_bar ? $this->show_in_admin_bar : $this->show_in_menu;
        $this->exclude_from_search = null !== $this->exclude_from_search ? $this->exclude_from_search : !$this->public;
        $this->publicly_queryable = null !== $this->publicly_queryable ? $this->publicly_queryable : $this->public;
        $this->capabilities = null !== $this->capabilities ? $this->capabilities : $this->post_type;

        if ( !is_array( $this->extra_supports ) ) {
            $this->extra_supports = [];
        }

        $this->supports = array_merge( $this->supports, $this->extra_supports );
    }

    /**
     * Set all params to the object properties.
     * 
     * @since  1.0.0
     */
    protected function create_params() {
        $labels = [
            'name' => $this->name_label,
            'singular_name' => $this->singular_name_label,
            'menu_name' => $this->menu_name_label,
            'name_admin_bar' => $this->name_admin_bar_label,
            'all_items' => $this->all_items_label,
            'edit_item' => $this->edit_item_label,
            'new_item' => $this->new_item_label,
            'view_item' => $this->view_item_label,
            'search_items' => $this->search_items_label,
            'not_found' => $this->not_found_label,
            'not_found_in_trash' => $this->not_found_in_trash_label,
            'parent_item_colon' => $this->parent_item_colon_label
        ];

        if ( $this->add_new_label ) {
            $labels[ 'add_new' ] = $this->add_new_label;
        }

        if ( $this->add_new_item_label ) {
            $labels[ 'add_new_item' ] = $this->add_new_item_label;
        }

        $this->post_type_params = [
            'labels' => $labels,
            'public' => $this->public,
            'exclude_from_search' => $this->exclude_from_search,
            'publicly_queryable' => $this->publicly_queryable,
            'show_ui' => $this->show_ui,
            'show_in_nav_menus' => $this->show_in_nav_menus,
            'show_in_menu' => $this->show_in_menu,
            'show_in_admin_bar' => $this->show_in_admin_bar,
            'menu_icon' => $this->menu_icon,
            'menu_position ' => $this->menu_position,
            'capability_type' => $this->capability_type,
            'capabilities' => $this->capabilities,
            'map_meta_cap' => $this->map_meta_cap,
            'hierarchical' => $this->hierarchical,
            'supports' => $this->supports,
            'register_meta_box_cb' => $this->register_meta_box_cb,
            'taxonomies' => $this->taxonomies,
            'has_archive' => $this->has_archive,
            'rewrite' => $this->rewrite,
            'can_export' => $this->can_export,
            'query_var' => $this->query_var
        ];

        if ( $this->use_meta_boxes ) {
            $this->meta_boxes_nonce_action = $this->post_type . '_meta_boxes_nonce';
        }

    }

    /**
     * Add theme supports based on a post type properties
     *
     * @todo another theme supports
     * @since  1.0.0
     */
    private function add_theme_support() {
        if ( is_array( $this->post_type_params[ 'supports' ] ) ) {
            if ( in_array( 'thumbnail', $this->post_type_params[ 'supports' ] ) ) {
                Theme_Supports::instance()->register_support_param( 'post-thumbnails', $this->post_type );
            }
        }
    }

    /**
     * Register current post type.
     * 
     * @since  1.0.0
     */
    public function register_post_type() {
        register_post_type( $this->post_type, $this->post_type_params );
        self::$reserved_post_types[] = $this->post_type;
        add_filter('post_updated_messages', [ &$this, 'post_updated_messages' ] );
    }

    /**
     * Allows to modify messages of a post type.
     * 
     * @return array    Messages array
     * @since  1.0.0
     */
    final public function post_updated_messages( $messages ) {

        if ( ! array_key_exists( $this->post_type, $messages ) ) {
            if ( $this->hierarchical ) {
                $messages[ $this->post_type ] = $messages[ 'page' ];
            } else {
                $messages[ $this->post_type ] = $messages[ 'post' ];
            }
        }

        $post_type_messages = $this->current_post_updated_messages( $messages[ $this->post_type ] );
        
        if ( is_array( $post_type_messages ) ) {
            $messages[ $this->post_type ] = $post_type_messages;
        }

        return $messages;
    }

    /**
     * Allows post type to change its own messages
     * 
     * @param  array $messages Messages array
     * @return array           Modified messages array
     * @since  1.0.0
     */
    protected function current_post_updated_messages( $messages ) {}
    
    /**
     * Add metaboxes nonce
     *
     * @todo  render nonce in a proper place
     * @since  1.0.0
     */
    protected function render_nonce( $name ) {
        wp_nonce_field( $this->meta_boxes_nonce_action, $name );
    }

    /**
     * Add metaboxes
     * 
     * @since  1.0.0
     */
    public function add_meta_boxes() {}

    /**
     * Do meta boxes data presave operations
     * 
     * @since  1.0.0
     */
    public function pre_save_meta_boxes_data() {
        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        $this->save_meta_boxes_data();
    }

    /**
     * Check whether a nonce is valid
     * 
     * @param  string   A name of nonce
     * @return boolean  Whether a nonce is valid
     * @since  1.0.0
     */
    protected function check_nonce( $name ) {
        // Verify that the nonce is valid.
        if ( ! isset( $_POST[ $name ] ) || 
            ! wp_verify_nonce( $_POST[ $name  ], $this->meta_boxes_nonce_action ) ) {
            return false;
        }

        return true;
    }

    /**
     * Save metaboxes data
     * 
     * @since  1.0.0
     */
    protected function save_meta_boxes_data() {}

}