<?php
/**
 * Common functions for displaying people
 */
if ( ! class_exists( 'JMB_People_Common' ) ) {
    class JMB_People_List_Common {
        /**
         * The function that handles displaying a list of people
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $people An array of people objects
         * @param string $layout The layout to use to display the people list
         * @param array $args Any additional arguments
         * @return string
         */
        public static function display_people( $people, $layout='default', $args=array() ) {
            $before = JMB_People_List_Common::display_people_default_before( $people, $args );

            if ( has_filter( `jmb_display_people_list_{$layout}_before` ) ) {
                $before = apply_filters( `jmb_display_people_list_{$layout}_before`, $before, $people, $args );
            }

            $content = JMB_People_List_Common::display_people_default( $people, $args );

            if ( has_filter( `jmb_display_people_list_{$layout}` ) ) {
                $content = apply_filters( `jmb_display_people_list_{$layout}`, $content, $people, $args );
            }

            $after = JMB_People_List_Common::display_people_default_after( $people, $args );

            if ( has_filter( `jmb_display_people_list_{$layout}_after` ) ) {
                $after = apply_filters( `jmb_display_people_list_{$layout}_after`, $after, $people, $args );
            }

            return $before . $content . $after;
        }

        /**
         * Handles the default opening tag for displaying a people list
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $people The array of people
         * @param array $args The argument array
         * @return string
         */
        public static function display_people_default_before( $people, $args ) {
            ob_start();
        ?>
            <div class="row people-list-default">
        <?php
            return ob_get_clean();
        }

        /**
         * Handles the templating for displaying the list of people
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $people The array of people
         * @param array $args The argument array
         * @return string
         */
        public static function display_people_default( $people, $args ) {
            $person_layout = $args['person_layout'];
            $person_args = array(
                'name_element' => $args['name_element']
            );

            ob_start();

            foreach( $people as $person ) :
        ?>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">
                <?php echo JMB_Person_Common::display_person( $person, $person_layout, $person_args ); ?>
            </div>
        <?php
            endforeach;

            return ob_get_clean();
        }

        /**
         * Handles the default closing tag for displaying a people list
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $people The array of people
         * @param array $args The argument array
         * @return string
         */
        public static function display_people_default_after( $people, $args ) {
            ob_start();
        ?>
            </div>
        <?php
            return ob_get_clean();
        }
    }
}