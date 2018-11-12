<?php
/**
 * Plugin Name:  EJO Custom Block
 * Plugin URI:   https://github.com/erikjoling/ejo-custom-block
 * Description:  WordPress Plugin for a Custom Block. Made to learn block development
 * Version:      1.0-dev
 * Author:       Erik Joling <erik@ejoweb.nl>
 * Author URI:   https://erik.joling.me/
 * Text Domain:  ejo/custom-block
 * Domain Path:  /resources/languages
 * Requires PHP: 7
 * License:      GPLv3
 * 
 * GitHub Plugin URI:  https://github.com/erikjoling/ejo-custom-block
 * GitHub Branch:      master
 */

namespace Ejo\Custom_Block;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main class that bootstraps the plugin.
 */
final class Plugin {

    /**
     * Version
     *
     * @var string
     */
    private static $version = '';

    /**
     * File
     *
     * @var string
     */
    private static $file = '';
    
    /**
     * Directory path with trailing slash.
     *
     * @var string
     */
    private static $dir = '';

    /**
     * Directory URI with trailing slash.
     *
     * @var string
     */
    private static $uri = '';

    /**
     * Plugin identifier
     *
     * @var string
     */
    private static $id = '';

    /**
     * Constructor method.
     *
     * @access private
     * @return void
     */
    private function __construct() {}

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
            $instance::setup();
        }

        return $instance;
    }

    /**
     * Sets up.
     *
     * @access private
     * @return void
     */
    private static function setup() {
        
        // Setting file has priority because other setters are dependant on it
        static::set_file();
        static::set_dir();
        static::set_uri();
        static::set_version();
        static::set_id();
        
        // Inform WordPress of custom language directory
        load_plugin_textdomain( 'ejo/custom-block', false, __DIR__ . '/resources/languages' );

        // Give off the loaded hook for this plugin
        do_action( static::get_id() . '_loaded' );

        // Debug
        // log(static::plugin_data());
    }

    /*=============================================================*/
    /**                     Getters & Setters                      */
    /*=============================================================*/

    /**
     * Sets the plugin file
     *
     * @return void
     */
    private static function set_file() {
        static::$file = __FILE__;
    }

    /**
     * Gets the plugin file
     *
     * @return string
     */
    private static function get_file() {
        return static::$file;
    }

    /**
     * Sets the plugin directory
     *
     * @return void
     */
    private static function set_dir() {
        static::$dir = plugin_dir_path( static::get_file() );
    }

    /**
     * Gets the plugin directory path
     *
     * @return string
     */
    private static function get_dir() {
        return static::$dir;
    }

    /**
     * Sets the plugin URI
     *
     * @return void
     */
    private static function set_uri() {
        static::$uri = plugin_dir_url( static::get_file() );
    }

    /**
     * Gets the plugin uri path
     *
     * @return string
     */
    private static function get_uri() {
        return static::$uri;
    }

    /**
     * Sets the plugin ID
     *
     * @return void
     */
    private static function set_id() {
        static::$id = basename(__DIR__);
    }

    /**
     * Gets the plugin id
     *
     * @return string
     */
    private static function get_id() {
        return static::$id;
    }

    /**
     * Sets the plugin version
     *
     * @return void
     */
    private static function set_version() {

        // Note: Can't use `get_plugin_data()` because it doesn't work on the frontend
        $plugin_data = get_file_data( static::get_file(), array('Version' => 'Version') );

        // Set the version property
        static::$version = $plugin_data['Version'];
    }

    /**
     * Gets the plugin version
     *
     * @return string
     */
    private static function get_version() {
        return static::$version;
    }


    /*=============================================================*/
    /**                    Plugin de/activation                    */
    /*=============================================================*/

    public static function on_activation() {}
    public static function on_deactivation() {}


    /*=============================================================*/
    /**                           Debug                            */
    /*=============================================================*/
    
    /**
     * Debug plugin data
     *
     * @return string
     */
    private static function plugin_data() {

        return [
            'file'    => static::get_file(),
            'dir'     => static::get_dir(),
            'uri'     => static::get_uri(),
            'id'      => static::get_id(),
            'version' => static::get_version()
        ];
    }
}

/**
 * Gets the instance of the class.  This function is useful for quickly grabbing data
 * used throughout the framework.
 *
 * @access public
 * @return object
 */
function plugin() {
    return Plugin::get_instance();
}

/**
 * Load the plugin, when WP is loaded
 */
add_action('plugins_loaded', function(){
    \Ejo\Custom_Block\plugin();
});

/**
 * Registration & deactivation:
 */
register_activation_hook( __FILE__, function(){
    \Ejo\Custom_Block\plugin()::on_activation();
});
register_deactivation_hook( __FILE__, function(){
    \Ejo\Custom_Block\plugin()::on_deactivation();
});


/*=============================================================*/
/**                         Debugging                          */
/*=============================================================*/


/** No need to check for function_exist because it is in namespace

/**
 * Print_R in a <pre> tag
 */
function dump( $arr ){
    echo '<pre>';
        print_r( $arr );
    echo '</pre>';
}

/**
 * Print_R in a <pre> tag and die
 */
function dd( $arr ){
    dump( $arr );
    die();
}

/**
 * Log data to wp-content/debug.log
 */
function log( $data )  {
    if ( true === WP_DEBUG ) {
        if ( is_array( $data ) || is_object( $data ) ) {
            error_log( print_r( $data, true ) );
        } else {
            error_log( $data );
        }
    }
}