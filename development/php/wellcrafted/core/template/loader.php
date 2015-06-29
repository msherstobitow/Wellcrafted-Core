<?php

namespace Wellcrafted\Core\Template;

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
class Loader {

    protected $template_rules = [];

    public function __construct() {
        add_filter( 'template_include', [ &$this, 'template_loader' ] );
    }

    public function add_rules_set( $name, $set = [] ) {
        $this->template_rules[ $name ] = $set; 
    }

    /**
     * Load a template.
     *
     * @param mixed $template
     * @return string
     */
    public function template_loader( $template ) {
        $this->template_rules = apply_filters( 'wellcrfated_template_loader_rules', $this->template_rules );
        $rendered = false;

        if ( is_array( $this->template_rules ) && !empty( $this->template_rules ) ) {
            foreach ( $this->template_rules as $rules_set ) {
                if ( is_array( $rules_set ) && 
                    !empty( $rules_set ) &&
                    isset( $rules_set[ 'default_path' ] ) && 
                    isset( $rules_set[ 'plugin_theme_folder' ] ) && 
                    isset( $rules_set[ 'rules' ] ) ) {
                    foreach ( $rules_set[ 'rules' ] as $rule ) {
                        if ( isset( $rule[ 'condition' ] ) && isset( $rule[ 'template' ] ) ) {
                            if ( $this->check_condition( $rule[ 'condition' ] ) ) {
                                if ( isset( $rule[ 'vendor_assets' ] ) ) {
                                    if ( !is_array( $rule[ 'vendor_assets' ] ) ) {
                                        $rule[ 'vendor_assets' ] = [ $rule[ 'vendor_assets' ] ];
                                    }
                                    foreach ( $rule[ 'vendor_assets' ] as $asset ) {
                                        \Wellcrafted\Core\Assets\Vendor::instance()->enqueue( $asset );
                                    }
                                }

                                /**
                                 * Link template-specific CSS
                                 */
                                if ( ! empty( $rules_set[ 'default_url' ] ) && isset( $rule[ 'css' ] ) ) {
                                    if ( !is_array( $rule[ 'css' ] ) ) {
                                        $rule[ 'css' ] = [ $rule[ 'css' ] ];
                                    }
                                    foreach ( $rule[ 'css' ] as $css ) {
                                        \Wellcrafted\Core\Assets::add_style(
                                            $rules_set[ 'plugin_theme_folder' ] . '/' . $css,
                                            $rules_set[ 'default_url' ] . 'assets/css/templates/' . $css . '.css'
                                        );
                                    }
                                }

                                /**
                                 * Add template-specific JS
                                 */
                                if ( ! empty( $rules_set[ 'default_url' ] ) && isset( $rule[ 'js' ] ) ) {
                                    if ( !is_array( $rule[ 'js' ] ) ) {
                                        $rule[ 'js' ] = [ $rule[ 'js' ] ];
                                    }
                                    foreach ( $rule[ 'js' ] as $js ) {
                                        \Wellcrafted\Core\Assets::add_footer_script(
                                            $rules_set[ 'plugin_theme_folder' ] . '/' . $js,
                                            $rules_set[ 'default_url' ] . 'assets/javascript/templates/' . $js . '.js',
                                            [ 'jquery' ]
                                        );
                                    }
                                }
                                

                                $rendered = $this->render_template( $rule[ 'template' ], $rules_set[ 'plugin_theme_folder' ], $rules_set[ 'default_path' ] );
                                
                                if ( $rendered ) {
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }

        if ( $rendered ) {
            return $rendered;
        }

        return $template;
    }

    /**
     * @todo PHPDoc
     * @param  [type] $conditions [description]
     * @return [type]             [description]
     *
     * If it doesn't work, update permalinks!
     */
    protected function check_condition( $conditions ) {
        $satisfied = false;

        if ( ! is_array( $conditions ) || empty( $conditions ) ) {
            return $satisfied;
        }

        $satisfied = true;

        foreach ( $conditions as $condition => $value ) {
            switch ( $condition ) {
                case 'single':
                    if ( is_bool( $value ) ) {
                        if ( is_single() !== $value ) {
                            $satisfied = false;
                        }
                    } else if ( is_string( $value ) ) {
                        if ( ! is_single() || get_post_type() !== $value ) {
                            $satisfied = false;
                        }
                    }
                    break;
                case 'archive':
                    if ( ! is_post_type_archive( $value ) ) {
                        $satisfied = false;
                    }
                    break;
                case 'post_type':
                    if ( get_post_type() !== $value ) {
                        $satisfied = false;
                    }
                    break;
                default: 
                    $satisfied = false;
                    break;
            }
        }

        return $satisfied;
    }

    /**
     * @todo PHPDoc
     * @param  [type] $template     [description]
     * @param  [type] $default_path [description]
     * @return [type]               [description]
     */
    protected function render_template( $template, $plugin_theme_folder, $default_path ) {
        $located_template = locate_template( [ '/wellcrafted/' . untrailingslashit( $plugin_theme_folder ) . '/templates/' . $template . '.php' ] );

        if ( $located_template ) {
            return $located_template;
        }

        $default_template_path = $default_path . 'templates/'. $template . '.php';
        
        if ( file_exists( $default_template_path ) ) {
            return $default_template_path;
        }

        return;
    }

}