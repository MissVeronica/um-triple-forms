<?php
/**
 * Plugin Name:     Ultimate Member - Triple Forms Shortcode
 * Description:     Extension to Ultimate Member for Triple UM Forms and Directories for Screens, Tablets and Mobiles.
 * Version:         1.0.0
 * Requires PHP:    7.4
 * Author:          Miss Veronica
 * License:         GPL v2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Author URI:      https://github.com/MissVeronica
 * Text Domain:     ultimate-member
 * Domain Path:     /languages
 * UM version:      2.8.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; 
if ( ! class_exists( 'UM' ) ) return;

Class UM_Triple_Forms_Shortcode {

    function __construct() {

        add_shortcode( 'um_triple_forms', array( $this, 'um_triple_forms_shortcode' ), 10, 1 );
    }

    public function um_triple_forms_shortcode( $atts ) {

        $form_id = false;

        if ( isset( $atts['screen'] )) {
            $form_id = absint( sanitize_text_field( $atts['screen'] ));
        }

        if ( UM()->mobile()->isMobile() ) {

            if ( isset( $atts['mobile'] )) {
                $form_id = absint( sanitize_text_field( $atts['mobile'] ));
            }
        }

        if ( UM()->mobile()->isTablet() ) {

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

}

new UM_Triple_Forms_Shortcode();
