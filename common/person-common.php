<?php
/**
 * 
 */
if ( ! class_exists( 'JMB_Person_Common' ) ) {
    class JMB_Person_Common {
        /**
         * The function that handles displaying an individual person
         * @author Jim Barnes
         * @since 1.0.0
         * @param WP_Post $person The person object
         * @param string $layout The layout to use to display the person
         * @param array $args Any additional arguments
         * @return string
         */
        public static function display_person( $person, $layout='default', $args=array() ) {
            $output = JMB_Person_Common::display_person_default( $person, $args );

            if ( has_filter( `display_person_{$layout}` ) ) {
                $output = apply_filters( `jmb_display_person_{$layout}`, $output, $person, $args );
            }

            return $output;
        }

        public static function display_person_default( $person, $args ) {
            $name_element = $args['name_element'];

            ob_start();
        ?>
            <div class="card mb-4 h-100">
                <?php if ( $person->person_portrait ) : ?>
                    <img class="card-img-top" src="<?php echo wp_get_attachment_image_src( $person->person_portrait, 'medium' )[0]; ?>">
                <?php endif; ?>
                <div class="card-body">
                    <<?php echo $name_element; ?> class="card-title"><?php echo $person->post_title; ?></<?php echo $name_element; ?>>
                    <p class="card-text"><?php echo $person->post_content; ?></p>
                </div>
                <div class="card-footer">
                    <a href="<?php echo get_permalink( $person->ID ); ?>" class="btn btn-primary btn-block">Read More</a>
                </div>
            </div>
        <?php
            return ob_get_clean();
        }
    }
}