<?php

namespace WeDevs\Academy;


class Installer{
    
    
    /**
     * Run the installer
     *
     * @return void
     */
    public function run()
    {
        $this->add_version();
        $this->create_tables();
    }

    public function add_version()
    {
        $installed = get_option( 'wd_academy_installed' );

        if(!$installed){
            update_option( 'wd_academy_installed', time() );
        }

        update_option( 'wd_academy_version', WD_ACADEMY_VERSION);
    }
    
    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_tables()
    {
        global $wpdb;

        $charset_collect = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE `{$wpdb->prefix}ac_addresses` (
            `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(100) NOT NULL DEFAULT '' COLLATE 'latin1_swedish_ci',
            `address` VARCHAR(255) NULL DEFAULT '' COLLATE 'latin1_swedish_ci',
            `phone` VARCHAR(30) NULL DEFAULT '' COLLATE 'latin1_swedish_ci',
            `created_by` BIGINT(20) UNSIGNED NOT NULL,
            `created_at` DATETIME NOT NULL,
            PRIMARY KEY (`id`)
        )$charset_collect;";

        if(! function_exists('dbDelta')){
            require_once ABSPATH . "wp-admin/includes/upgrade.php";
        }

        dbDelta($schema);
    }
}
