<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// Register Custom Post Type
function cpt_student() {

	$labels = array(
		'name'                  => _x( 'Students', 'Post Type General Name', 'annuel2016' ),
		'singular_name'         => _x( 'Student', 'Post Type Singular Name', 'annuel2016' ),
		'menu_name'             => __( 'Students', 'annuel2016' ),
		'name_admin_bar'        => __( 'Students', 'annuel2016' ),
		'archives'              => __( 'Student Archives', 'annuel2016' ),
		'parent_item_colon'     => __( 'Parent Student:', 'annuel2016' ),
		'all_items'             => __( 'All Students', 'annuel2016' ),
		'add_new_item'          => __( 'Add New Student', 'annuel2016' ),
		'add_new'               => __( 'Add New', 'annuel2016' ),
		'new_item'              => __( 'New Student', 'annuel2016' ),
		'edit_item'             => __( 'Edit Student', 'annuel2016' ),
		'update_item'           => __( 'Update Student', 'annuel2016' ),
		'view_item'             => __( 'View Student', 'annuel2016' ),
		'search_items'          => __( 'Search Student', 'annuel2016' ),
		'not_found'             => __( 'Not found', 'annuel2016' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'annuel2016' ),
		'featured_image'        => __( 'Picture', 'annuel2016' ),
		'set_featured_image'    => __( 'Set Picture', 'annuel2016' ),
		'remove_featured_image' => __( 'Remove Picture', 'annuel2016' ),
		'use_featured_image'    => __( 'Use as Picture', 'annuel2016' ),
		'insert_into_item'      => __( 'Insert into student', 'annuel2016' ),
		'uploaded_to_this_item' => __( 'Uploaded to this student', 'annuel2016' ),
		'items_list'            => __( 'Students list', 'annuel2016' ),
		'items_list_navigation' => __( 'Students list navigation', 'annuel2016' ),
		'filter_items_list'     => __( 'Filter students list', 'annuel2016' ),
	);
	$args = array(
		'label'                 => __( 'Student', 'annuel2016' ),
		'description'           => __( 'Student', 'annuel2016' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'       		=> true,
		'rest_base'          		=> 'student-api',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'rewrite' => array(
			'slug'	=> 'student',
			'with_front'  => false,
		)
	);
	register_post_type( 'student', $args );

}
add_action( 'init', 'cpt_student', 0 );
	

// Metaboxes
add_filter( 'rwmb_meta_boxes', 'students_meta_boxes' );
function students_meta_boxes( $meta_boxes ) {
	$meta_boxes[] = array(
		'title'      => __( 'Project #1', 'annuel2016' ),
		'post_types' => 'student',
		'fields'     => array(
			array(
				'id'   => 'project_name_1',
				'name' => __( 'Project #1', 'annuel2016' ),
				'type' => 'text',
			),
			array(
				'id'   => 'project_description_1',
				'name' => __( 'Description', 'annuel2016' ),
				'type' => 'textarea',
			),
			array(
				'id'   => 'project_credits_1',
				'name' => __( 'Professeurs et Coéquipiers', 'annuel2016' ),
				'type' => 'textarea',
			),
			array(
				'name'             => __( 'Project Images', 'annuel2016' ),
				'id'               => "project_images_1",
				'type'             => 'image_advanced',
				'max_file_uploads' => 4,
			),
			array(
				'id'   => 'project_video_1',
				'name' => 'YouTube Video',
				'type' => 'oembed',
			)
		)
	);
	$meta_boxes[] = array(
		'title'      => __( 'Project #2', 'annuel2016' ),
		'post_types' => 'student',
		'fields'     => array(
			array(
				'id'   => 'project_name_2',
				'name' => __( 'Project #2', 'annuel2016' ),
				'type' => 'text',
			),
			array(
				'id'   => 'project_description_2',
				'name' => __( 'Description', 'annuel2016' ),
				'type' => 'textarea',
			),
			array(
				'id'   => 'project_credits_2',
				'name' => __( 'Professeurs et Coéquipiers', 'annuel2016' ),
				'type' => 'textarea',
			),
			array(
				'name'             => __( 'Project Images', 'annuel2016' ),
				'id'               => "project_images_2",
				'type'             => 'image_advanced',
				'max_file_uploads' => 4,
			),
			array(
				'id'   => 'project_video_2',
				'name' => 'YouTube Video',
				'type' => 'oembed',
			)
		),
	);
	return $meta_boxes;
}

/**
 * Add the field "spaceship" to REST API responses for posts read and write
 */
add_action( 'rest_api_init', 'custom_meta' );
function custom_meta() {
	register_rest_field( 'student',
		'projects',
		array(
			'get_callback'    => 'get_projects',
			'schema'          => null
		)
	);
	register_rest_field( 'student',
		'avatar',
		array(
			'get_callback'    => 'get_student_avatar',
			'schema'          => null
		)
	);
}


/**
 * Handler for getting custom field data. WP-API
 *
 * @since 0.1.0
 *
 * @param array $object The object from the response
 * @param string $field_name Name of field
 * @param WP_REST_Request $request Current request
 *
 * @return mixed
 */
function get_projects( $object, $field_name, $request ) {
	$projects = array(
		array(
			'title' => get_post_meta( $object['id'], 'project_name_1', true),
			'description' => get_post_meta( $object['id'], 'project_description_1', true),
			'credits' => get_post_meta( $object['id'], 'project_credits_1', true),
			'images' => array(),
			'video' => wp_oembed_get(get_post_meta( $object['id'], 'project_video_1', true)),
		),
		array(
			'title' => get_post_meta( $object['id'], 'project_name_2', true),
			'description' => get_post_meta( $object['id'], 'project_description_2', true),
			'credits' => get_post_meta( $object['id'], 'project_credits_2', true),
			'images' => array(),
			'video' => wp_oembed_get(get_post_meta( $object['id'], 'project_video_2', true)),
		)
	);
	$images_p1 = get_post_meta( $object['id'],'project_images_1');
	$images_p2 = get_post_meta( $object['id'],'project_images_2');
	foreach($images_p1 as $image){
		$projects[0]['images'][] = wp_get_attachment_image_src($image, 'full-width')[0];
	}
	foreach($images_p2 as $image){
		$projects[1]['images'][] = wp_get_attachment_image_src($image, 'full-width')[0];
	}
	return $projects;
}


function get_student_avatar( $object, $field_name, $request ){
	$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $object['id'] ), 'large' );
	return $thumbnail[0];
}