<?php
/**
 * Web label
 *
 * @package WP LibreJS
 */

namespace LibreJS;

defined( 'ABSPATH' ) || exit;

/**
 * Web label class
 *
 * @class WebLabel
 */
class WebLabel {

    /**
     * Web label data
     *
     * @var \WP_Post
     */
    private $post;

    const LICENSES = array(
        'http://www.gnu.org/licenses/gpl-2.0.html' => 'GNU-GPL-2.0-or-later',
        'http://www.gnu.org/licenses/gpl-3.0.html' => 'GNU-GPL-3.0-or-later',
        'http://www.gnu.org/licenses/lgpl-2.1.html' => 'GNU-LGPL-2.1-or-later',
        'http://www.gnu.org/licenses/lgpl-3.0.html' => 'GNU-LGPL-3.0-or-later',
        'http://www.gnu.org/licenses/agpl-3.0.html' => 'GNU-AGPL-3.0-or-later',
        'http://www.apache.org/licenses/LICENSE-2.0' => 'Apache-2.0-only',
        'http://directory.fsf.org/wiki/License:BSD_3Clause' => 'Modified-BSD',
        'http://creativecommons.org/publicdomain/zero/1.0/legalcode' => 'CC0-1.0-only',
        'http://www.jclark.com/xml/copying.txt' => 'Expat',
        'http://www.mozilla.org/MPL/2.0' => 'MPL-2.0-or-later'
    );

    /**
     * Constructor
     *
     * @param \WP_Post $post
     */
    public function __construct( \WP_Post $post ) {
        $this->post = $post;
    }

    /**
     * Get script's file
     *
     * @return string
     */
    public function get_file() {
        return $this->post->post_title;
    }

    /**
     * Get script's file name
     *
     * @return string
     */
    public function get_file_name() {
        return parse_url( $this->post->post_title, PHP_URL_PATH );
    }

    /**
     * Get script's license
     *
     * @return string
     */
    public function get_license() {
        return $this->post->post_excerpt ?: 'http://www.gnu.org/licenses/gpl-3.0.html';
    }

    /**
     * Get script's license name
     *
     * @return string
     */
    public function get_license_name() {
        if ( isset( self::LICENSES[$this->get_license()] ) ) {
            return self::LICENSES[$this->get_license()];
        }
        else {
            return 'Other';
        }
    }

    /**
     * Get script's source
     *
     * @return string
     */
    public function get_source() {
        return $this->post->post_content;
    }

    /**
     * Get script's source name
     *
     * @return string
     */
    public function get_source_name() {
        return parse_url( $this->post->post_content, PHP_URL_PATH );
    }
}
