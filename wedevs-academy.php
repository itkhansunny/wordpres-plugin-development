<?php
/**
 * Plugin Name: weDevs Academy
 * Description: A plugins for weDevs Academy
 * Plugin URI: https://itkhansunny.me
 * Author: Khan Sunny
 * Author URI: https://itkhansunny.me
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if( ! defined( 'ABSPATH' ) ){
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */

final class WeDevs_Academy{

    /**
     * Plugins version
     *
     * var string
     */
    const version = '1.0';

    /**
     * Class constructor
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook( __FILE__, [$this, 'activate' ]);

        add_action( 'plugins_loaded', [$this, 'init_plugin'] );
    }

    /**
     * Initialize a singleton instance
     *
     * @return \WeDevs_Academy
     */
    public static function init()
    {
        static $instance = false;

        if(!$instance){
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('WD_ACADEMY_VERSION', self::version);
        define('WD_ACADEMY_FILE', __FILE__);
        define('WD_ACADEMY_PATH', __DIR__);
        define('WD_ACADEMY_URL', plugins_url( '', WD_ACADEMY_FILE ));
        define('WD_ACADEMY_ASSETS', WD_ACADEMY_URL . '/assets');
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin()
    {
        if(is_admin(  )){
            new WeDevs\Academy\Admin();
        }else{
            new WeDevs\Academy\Frontend();
        }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate()
    {
        $installer = new \WeDevs\Academy\Installer();

        $installer->run();
    }

}

/**
 * Initializes the main plugin
 *
 * @return \WeDevs_Academy
 */
function wedevs_academy()
{
    return WeDevs_Academy::init();
}

//Kick-of the plugin
wedevs_academy();