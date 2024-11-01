<?php
/**
 * WP LibreJS setup
 *
 * @package WP LibreJS
 */

namespace LibreJS;

defined( 'ABSPATH' ) || exit;

/**
 * Main WP LibreJS class.
 *
 * @class Loader
 */
final class Loader {
    /**
     * Web labels list
     *
     * @var array
     */
    private static $weblabels;

    /**
     * Post type
     *
     * @var string
     */
    const POST_TYPE = 'weblabel';

    /**
     * Initialization
     */
    public static function init() {
        register_uninstall_hook( LIBREJS_PLUGIN_FILE, array ( self::class, 'uninstall' ) );
        add_action( 'wp_head', array ( self::class, 'show_license_notice' ), 0 );
        add_action( 'wp_footer', array ( self::class, 'show_link' ) );
        if ( ! is_admin() ) {
            add_action( 'plugins_loaded', array ( self::class, 'update_weblabels' ) );
        }
        add_filter( 'init', array ( self::class, 'show_weblabels' ), 0 );
        // add_action( 'init', array ( self::class, 'create_post_type' ) );
    }

    /**
     * Get all web labels
     *
     * @return \WP_Post[]
     */
    public static function get_weblabels() {
        return get_posts( array ( 'post_type' => self::POST_TYPE, 'numberposts' => -1  ) );
    }

    /**
     * Add new web labels
     */
    public static function update_weblabels() {
        if ( ! current_user_can( 'administrator' ) ) {
            return;
        }
        $weblabels = self::get_weblabels();
        foreach ($weblabels as $weblabel) {
            self::$weblabels[$weblabel->post_title] = true;
        }
        add_filter( 'script_loader_src', array ( self::class, 'insert_weblabel' ) );
    }

    /**
     * Add web label if it does not exists yet
     *
     * @param string $src
     * @return string
     */
    public static function insert_weblabel( $src ) {
        if ( ! $src ) {
            return $src;
        }
        // Normalize URL
        $nsrc = strtok( $src, '?' );
        if ( substr( $nsrc, 0, 1 ) == '/' ) {
            $nsrc = get_site_url() . $nsrc;
        }
        if ( isset( self::$weblabels[$nsrc] ) ) {
            return $src;
        }
        $data = array(
            'post_title' => $nsrc,
            'post_type' => self::POST_TYPE,
            'post_status' => 'publish'
        );
        wp_insert_post( $data );
        self::$weblabels[$nsrc] = true;
        return $src;
    }

    /**
     * Drop custom posts
     */
    public static function uninstall() {
        $weblabels = self::get_weblabels();
        foreach ($weblabels as $weblabel) {
            wp_delete_post( $weblabel->ID, true );
        }
    }

    /**
     * Add global license notice
     */
    public static function show_license_notice() {
?>
<script>
    /*
    @licstart  The following is the entire license notice for the
    JavaScript code in this page.

    The JavaScript code in this page is free software: you can
    redistribute it and/or modify it under the terms of the GNU
    General Public License (GNU GPL) as published by the Free Software
    Foundation, either version 3 of the License, or (at your option)
    any later version.  The code is distributed WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS
    FOR A PARTICULAR PURPOSE.  See the GNU GPL for more details.

    As additional permission under GNU GPL version 3 section 7, you
    may distribute non-source (e.g., minimized or compacted) forms of
    that code without the copy of the GNU GPL normally required by
    section 4, provided you include this license notice and a URL
    through which recipients can access the Corresponding Source.

    @licend  The above is the entire license notice
    for the JavaScript code in this page.
    */
</script>
<?php
    }

    /**
     * Add HTML anchor link
     */
    public static function show_link() {
?>
<a href="?librejs-weblabels" rel="jslicense" style="display: none">JavaScript licenses</a>
<?php
    }

    /**
     * Add Web labels table to output
     *
     * @return string
     */
    public static function show_weblabels() {
        if ( ! isset( $_GET['librejs-weblabels'] ) ) {
            return;
        }
        include( LIBREJS_TEMPLATES . '/weblabels.phtml' );
        die;
    }

    /**
     * Register custom post type
     */
    public static function create_post_type() {
        register_post_type( self::POST_TYPE,
            // CPT Options
            array(
                'labels' => array(
                    'name' => __( 'Web labels' ),
                    'singular_name' => __( 'Web label' )
                ),
                'rewrite' => false,
                'show_ui' => true,
                'supports' => ['title', 'editor', 'excerpt'],
            )
        );
    }
}
