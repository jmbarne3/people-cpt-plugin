<?php
/**
 * Defines the `people-list` shortcode
 */
if ( ! class_exists( 'JMB_People_List_Shortcode' ) ) {
    class JMB_People_List_Shortcode {
        /**
         * Registers the `people-list` shortcode
         * @author Jim Barnes
         * @since 1.0.0
         */
        public static function register_shortcode() {
            add_shortcode( 'people-list', array( 'JMB_People_List_Shortcode', 'callback' ) );
        }

        /**
         * The callback function for the `people-list` shortcode.
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $atts The shortcode attributes
         * @param string $content The inner content
         * @return string
         */
        public static function callback( $atts, $content='' ) {
            $atts = shortcode_atts( array(
                'layout'        => 'default',
                'person_layout' => 'default',
                'name_element'  => 'h3',
                'categories'    => null,
                'limit'         => null,
                'offset'        => null
            ), $atts, 'people-list' );

            /**
             * Get the posts to send to the layout function
             */
            $layout = $atts['layout'];

            // Remove layout now that we have the value.
            unset( $atts['layout'] );

            $args = array(
                'post_type'      => 'person',
                'posts_per_page' => -1,
                'orderby'        => 'order',
                'order'          => 'ASC'
            );

            if ( $atts['categories'] ) {
                $args['category_name'] = $atts['categories'];
            }

            if ( $atts['limit'] ) {
                $args['posts_per_page'] = $atts['limit'];
            }

            if ( $atts['offset'] ) {
                $args['offset'] = $atts['offset'];
            }

            $people = get_posts( $args );

            if ( $people ) {
                return JMB_People_List_Common::display_people( $people, $layout, $atts );
            }

            return '';
        }
    }
}