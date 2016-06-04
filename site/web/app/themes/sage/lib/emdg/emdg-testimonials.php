<?php

/**
 * elevated Media Design Group
 *
 * Testimonials Template
 *
 * @link http://www.elevatedMDG.com
 *
 */

// add custom post type

namespace eMDG\Testimonials;

add_action( 'init', 'create_post_type_testimonials' );
function create_post_type_testimonials() {
	register_post_type( 'testimonials',
		array(
			'labels' => array(
				'name' => __( 'Testimonials' ),
				'singular_name' => __( 'Testimonial' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Testimonial' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Testimonial' ),
				'new_item' => __( 'New Testimonial' ),
				'view' => __( 'View Testimonial' ),
				'view_item' => __( 'View Testimonial' ),
				'search_items' => __( 'Search Testimonials' ),
				'not_found' => __( 'No Testimonials Found' ),
				'not_found_in_trash' => __( 'No Testimonials Found in Trash' ),
				'parent' => __( 'Parent' )
			),
		'public' => true,
		'menu_position' => 5,
        	'show_ui' => true,
        	'capability_type' => 'post',
        	'hierarchical' => false,
		'supports' => array('title'),
		'rewrite' => array('slug' => 'testimonial', 'with_front' => false),
		'has_archive' => 'testimonial-archives',
		)
	);
}

//add associated meta boxes
$meta_box['testimonials'] = array(
	'id' => 'testimonials-written',
	'title' => 'Testimonials',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Author',
			'desc' => '',
			'id' => 'testimonial_author',
			'type' => 'text',
			'default' => ''
			),
		array(
			'name' => 'Testimonial',
			'desc' => '',
			'id' => 'testimonial_actual',
			'type' => 'textarea',
			'default' => ''
			),
		array(
			'name' => 'Star Rating',
			'desc' => '',
			'id' => 'testimonial_rating',
			'type' => 'select',
			'options' => array('5', '4', '3', '2', '1')
			),
		)
	);
