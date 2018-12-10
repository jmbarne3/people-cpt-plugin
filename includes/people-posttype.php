<?php
/**
 * Defines the People custom post type
 */
if ( ! class_exists( 'JMB_People_PostType' ) ) {
    class JMB_People_PostType {
        public static
            $text_domain = 'jmb_people',
            $labels = array(
                'singular' => 'Person',
                'plural'   => 'People',
                'slug'     => 'people'
            );

        /**
         * Registers the People custom type
         * @author Jim Barnes
         * @since 1.0.0
         */
        public static function register_posttype() {
            $labels = apply_filters( 'jmb_people_labels', self::$labels );
            register_post_type( 'person', self::args( $labels ) );
        }

        /**
         * Returns the labels array for post type registration
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $labels The array of base labels
         * @return array
         */
        public static function labels( $labels ) {
            $singular = $labels['singular'];
            $plural   = $labels['plural'];

            return apply_filters( 'jmb_people_label_args', array(
                'name'                  => _x( $plural, 'Post Type General Name', self::$text_domain ),
				'singular_name'         => _x( $singular, 'Post Type Singular Name', self::$text_domain ),
				'menu_name'             => __( $plural, self::$text_domain ),
				'name_admin_bar'        => __( $singular, self::$text_domain ),
				'archives'              => __( $singular . ' Archives', self::$text_domain ),
				'parent_item_colon'     => __( 'Parent ' . $singular . ':', self::$text_domain ),
				'all_items'             => __( 'All ' . $plural, self::$text_domain ),
				'add_new_item'          => __( 'Add New ' . $singular, self::$text_domain ),
				'add_new'               => __( 'Add New', self::$text_domain ),
				'new_item'              => __( 'New ' . $singular, self::$text_domain ),
				'edit_item'             => __( 'Edit ' . $singular, self::$text_domain ),
				'update_item'           => __( 'Update ' . $singular, self::$text_domain ),
				'view_item'             => __( 'View ' . $singular, self::$text_domain ),
				'search_items'          => __( 'Search ' . $plural, self::$text_domain ),
				'not_found'             => __( 'Not found', self::$text_domain ),
				'not_found_in_trash'    => __( 'Not found in Trash', self::$text_domain ),
				'featured_image'        => __( 'Featured Image', self::$text_domain ),
				'set_featured_image'    => __( 'Set featured image', self::$text_domain ),
				'remove_featured_image' => __( 'Remove featured image', self::$text_domain ),
				'use_featured_image'    => __( 'Use as featured image', self::$text_domain ),
				'insert_into_item'      => __( 'Insert into ' . $singular, self::$text_domain ),
				'uploaded_to_this_item' => __( 'Uploaded to this ' . $singular, self::$text_domain ),
				'items_list'            => __( $plural . ' list', self::$text_domain ),
				'items_list_navigation' => __( $plural . ' list navigation', self::$text_domain ),
				'filter_items_list'     => __( 'Filter ' . $singular . ' list', self::$text_domain ),
            ) );
        }

        /**
         * Returns the args array for post type registration
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $labels The array of base labels
         * @return array
         */
        public static function args( $labels ) {
            $singular = $labels['singular'];
            $plural   = $labels['plural'];
            $slug     = $labels['slug'];

            $args = array(
				'label'                 => __( $singular, self::$text_domain ),
				'description'           => __( 'Used for defining staff members or other people.', self::$text_domain ),
				'labels'                => self::labels( $labels ),
				'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields' ),
				'taxonomies'            => self::taxonomies(),
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-admin-users',
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => true,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'rewrite'               => array(
                    'slug'       => $slug,
                    'with_front' => false
                )
            );

            $args = apply_filters( 'jmb_people_post_type_args', $args );

			return $args;
        }

        /**
         * Defines which taxonomies are avilable to the post type
         * @author Jim Barnes
         * @since 1.0.0
         * @return array
         */
        public static function taxonomies() {
            $taxonomies = array(
                'categories'
            );

            $taxonomies = apply_filters( 'jmb_people_taxonomies', $taxonomies );

            return $taxonomies;
        }

        /**
         * Loads the ACF fields in
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $paths The paths to look for the ACF JSON file
         * @return array
         */
        public static function add_fields() {
            if ( function_exists( 'acf_add_local_field_group' ) ) {
                acf_add_local_field_group( array(
                    'title'  => 'Person Fields',
                    'fields' => array(
                        array(
                            'key'           => 'field_jmb_person_portrait',
                            'label'         => 'Portrait',
                            'name'          => 'person_portrait',
                            'type'          => 'image',
                            'instructions'  => 'the image to display for the person\'s profile image.',
                            'return_format' => 'id',
                            'preview_size'  => 'medium',
                            'library'       => 'all',
                            'min_width'     => '300px',
                            'min_height'    => '300px'
                        ),
                        array(
                            'key'           => 'field_jmb_person_title',
                            'label'         => 'Title',
                            'name'          => 'person_title',
                            'type'          => 'text',
                            'instructions'  => 'Enter the title of the person. Can be left blank.',
                            'required'      => 0,
                            'placeholder' => 'Senior Pastor',
                        ),
                        array(
                            'key'          => 'field_jmb_person_email',
                            'label'        => 'Email',
                            'name'         => 'person_email',
                            'type'         => 'email',
                            'instructions' => 'Enter the email of the person. Can be left blank.',
                            'required'     => 0,
                        ),
                        array(
                            'key'          => 'field_jmb_person_twitter_profile',
                            'label'        => 'Twitter Profile',
                            'name'         => 'person_twitter_profile',
                            'type'         => 'url',
                            'instructions' => 'Enter the URL of the twitter profile of the person. Can be left blank.',
                            'required'     => 0,
                        )
                    ),
                    'location' => array(
                        array(
                            array(
                                'param'    => 'post_type',
                                'operator' => '==',
                                'value'    => 'person',
                            ),
                        ),
                    )
                ));
            }
        }

        /**
         * The function that adds additional meta data to the post object
         * @author Jim Barnes
         * @since 1.0.0
         * @param array $posts The array of posts
         * @return array
         */
        public static function add_meta_data( $posts ) {
            foreach( $posts as $post ) {
                $post->person_title           = get_post_meta( $post->ID, 'person_title', true );
                $post->person_email           = get_post_meta( $post->ID, 'person_email', true );
                $post->person_twitter_profile = get_post_meta( $post->ID, 'person_twitter_profile', true );
                $post->person_portrait        = get_post_meta( $post->ID, 'person_portrait', true );
            }

            return $posts;
        }
    }
}