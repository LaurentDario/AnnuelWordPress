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
	);
	register_post_type( 'student', $args );

}
add_action( 'init', 'cpt_student', 0 );
	

// Metaboxes
add_filter( 'rwmb_meta_boxes', 'students_meta_boxes' );
function students_meta_boxes( $meta_boxes ) {
	$meta_boxes[] = array(
		'title'      => __( 'Projects', 'annuel2016' ),
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
				'name'             => __( 'Project Images', 'annuel2016' ),
				'id'               => "project_images_1",
				'type'             => 'image_advanced',
				'max_file_uploads' => 4,
			),
			array(
				'id'   => 'project_name_2',
				'name' => __( 'Project #2', 'annuel2016' ),
				'type' => 'text',
			),
			array(
				'id'   => 'project_description_1',
				'name' => __( 'Description', 'annuel2016' ),
				'type' => 'textarea',
			),
			array(
				'name'             => __( 'Project Images', 'annuel2016' ),
				'id'               => "project_images_1",
				'type'             => 'image_advanced',
				'max_file_uploads' => 4,
			)
		),
	);
	return $meta_boxes;
}

?>
