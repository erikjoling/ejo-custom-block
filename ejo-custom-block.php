<?php
/*
Plugin Name:  EJO Custom Block
Plugin URI:   https://github.com/erikjoling/ejo-custom-block
Description:  WordPress Plugin for a Custom Block. Made to learn block development
Author:       Erik Joling <erik@ejoweb.nl>
Version:      1.0-dev
Author URI:   https://github.com/erikjoling/
Text Domain:  ejo/custom-block
Domain Path:  /assets/languages

GitHub Plugin URI:  https://github.com/erikjoling/ejo-custom-block
GitHub Branch:      master
*/

namespace Ejo\Custom_Block;

final class Custom_Block {

    /**
     * Version
     *
     * @access public
     * @var    string
     */
    public $version = '';

    /**
     * File
     *
     * @access public
     * @var    string
     */
    public $plugin_file = '';
    
    /**
     * Directory path with trailing slash.
     *
     * @access public
     * @var    string
     */
    public $dir = '';

    /**
     * Directory URI with trailing slash.
     *
     * @access public
     * @var    string
     */
    public $uri = '';

    /**
     * Menu slug
     *
     * @access public
     * @var    string
     */
    public $slug = 'ejo/custom-block';

    /**
     * Returns the instance.
     *
     * @access public
     * @return object
     */
    public static function get_instance() {

        static $instance = null;

        if ( is_null( $instance ) ) {
            $instance = new self;
            $instance->setup();
            $instance->core();
            $instance->setup_actions();
        }

        return $instance;
    }

    /**
     * Constructor method.
     *
     * @access private
     * @return void
     */
    private function __construct() {}

    /**
     * Sets up.
     *
     * @access private
     * @return void
     */
    private function setup() {

        // Main plugin file
        $this->plugin_file = __FILE__;

        // Set the directory properties.
        $this->dir = plugin_dir_path( $this->plugin_file );
        $this->uri = plugin_dir_url( $this->plugin_file );

        // Use `get_file_data` because `get_plugin_data` doesn't work on the frontend
        $plugin_data = get_file_data($this->plugin_file, array('Version' => 'Version'), false);

        // Set the version property
        $this->version = $plugin_data['Version'];

        // Inform WordPress of custom language directory
        load_plugin_textdomain( 'ejo/custom-block', false, basename( dirname( $this->plugin_file ) ) . '/assets/languages' );
    }

    /**
     * Loads the core files.
     *
     * @access private
     * @return void
     */
    private function core() {

        
    }

    /**
     * Adds the necessary setup actions for the theme.
     *
     * @access private
     * @return void
     */
    private function setup_actions() {

        // Activation and Deactivation of plugin
        register_activation_hook( $this->plugin_file, array( $this, 'on_plugin_activation' ) );
        register_deactivation_hook( $this->plugin_file, array( $this, 'on_plugin_deactivation' ) );

        
    }
    
    /**
     * Hook styles 'n scripts
     *
     * @access public
     * @return void
     */
    public function enqueue_scripts() {

        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        // Styles
        // wp_enqueue_style( 'ejo-rsv-style', $this->uri ."assets/css/plugin{$suffix}.css", array(), $this->version );

        // Scripts
        // wp_enqueue_script( 'ejo-rsv-vendor', $this->uri ."assets/js/vendor{$suffix}.js", array( 'jquery' ), $this->version, true );
    }


    public function on_plugin_activation() {}
    public function on_plugin_deactivation() {}

}

/**
 * Gets the instance of the `EJO_Core` class.  This function is useful for quickly grabbing data
 * used throughout the framework.
 *
 * @access public
 * @return object
 */
function boot() {
    return Custom_Block::get_instance();
}

// Startup!
boot();