<?php
/**
 * Plugin Name:     Ultimate Member - Triple Forms Shortcode
 * Description:     Extension to Ultimate Member for Triple UM Forms and Directories for Screens, Tablets and Mobiles.
 * Version:         1.1.0
 * Requires PHP:    7.4
 * Author:          Miss Veronica
 * License:         GPL v2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Author URI:      https://github.com/MissVeronica
 * Plugin URI:      https://github.com/MissVeronica/um-triple-forms
 * Update URI:      https://github.com/MissVeronica/um-triple-forms
 * Text Domain:     ultimate-member
 * Domain Path:     /languages
 * UM version:      2.9.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; 
if ( ! class_exists( 'UM' ) ) return;

Class UM_Triple_Forms_Shortcode {

    public $tablets = array(    'iPad',             // iPad
                                'SM-X906C',         // Samsung Galaxy Tab S8 Ultra
                                'YT-J706X',         // Lenovo Yoga Tab 11
                                'Pixel C',          // Google Pixel C
                                'SGP771',           // Sony Xperia Z4 Tablet
                                'SHIELD Tablet',    // Nvidia Shield Tablet
                                'SM-T827R4',        // Samsung Galaxy Tab S3
                                'SM-T550',          // Samsung Galaxy Tab A
                                'KFTHWI',           // Amazon Kindle Fire HDX 7
                                'LG-V410',          // LG G Pad 7.0
                            );

    function __construct() {

        add_shortcode( 'um_triple_forms', array( $this, 'um_triple_forms_shortcode' ), 10, 1 );
    }

    public function um_triple_forms_shortcode( $atts ) {

        $form_id = false;

        if ( isset( $atts['screen'] )) {
            $form_id = absint( sanitize_text_field( $atts['screen'] ));
        }

        if ( wp_is_mobile() ) {

            if ( isset( $atts['mobile'] )) {
                $form_id = absint( sanitize_text_field( $atts['mobile'] ));
            }
        }

        if ( $this->is_tablet() ) {

            if ( isset( $atts['tablet'] )) {
                $form_id = absint( sanitize_text_field( $atts['tablet'] ));
            }
        }

        if ( ! empty( $form_id )) {

            $form_type = get_post_type( $form_id );
            if ( in_array( $form_type, array( 'um_form', 'um_directory' ))) {

                $shortcode = '[ultimatemember form_id="' . $form_id . '"/]';

                if ( version_compare( get_bloginfo( 'version' ), '5.4', '<' ) ) {
                    return do_shortcode( $shortcode );
                } else {
                    return apply_shortcodes( $shortcode );
                }
            }
        }

        return '';
    }

    public function is_tablet() {

        foreach( $this->tablets as $tablet ) {
            if ( strpos( $_SERVER['HTTP_USER_AGENT'], $tablet ) !== false ) {
                return true;
            }
        }

        return false;
    }

}

new UM_Triple_Forms_Shortcode();


