<?php
/**
 * Defines the `person` shortcode.
 */
if ( ! class_exists( 'JMB_People_Person_Shortcode' ) ) {
    class JMB_People_Person_Shortcode {
        /**
         * Registers the `person` shortcode.
         * @author Jim Barnes
         * @since 1.0.0
         */
        public static function register_shortcode() {
            add_shortcode( 'person', array( 'JMB_People_Person_Shortcode', 'callback' ) );
        }

        /**
         * The callback function for the `person` shortcode
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $atts The shortcode attributes
         * @param string $content The inner content
         * @return string
         */
        public static function callback( $atts, $content='' ) {
            $atts = shortcode_atts( array(
                'name_element' => 'h3',
                'id'           => null,
                'slug'         => null,
                'name'         => null,
                'layout'       => 'default'
            ), $atts );

            $layout = $atts['layout'];

            // Remove layout now that we have the value.
            unset( $atts['layout'] );

            $person = null;

            if ( $atts['name'] ) {
                $args = array(
                    'post_type'      => 'people',
                    'posts_per_page' => 1,
                    'post_title'     => $atts['name']
                );

                $people = get_posts( $args );

                if ( count( $people ) > 0 ) {
                    // Get the first person found.
                    $person = $people[0];
                }
            }

            if ( $atts['slug'] ) {
                $args = array(
                    'post_type'      => 'people',
                    'posts_per_page' => 1,
                    'post_name'      => $atts['slug']
                );

                $people = get_posts( $args );

                if ( count( $people ) > 0 ) {
                    // Get the first person found.
                    $person = $people[0];
                }
            }

            if ( $atts['id'] ) {
                $person = get_post( $atts['id'] );
            }

            /**
             * Gather args and retrieve the person
             */

            if ( $person ) {
                return JMB_Person_Common::display_person( $person, $layout, $atts );
            }

            return '';
        }
    }
}