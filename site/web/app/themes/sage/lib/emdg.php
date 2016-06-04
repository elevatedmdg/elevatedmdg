<?php

/**
 * elevated Media Design Group
 *
 * Custom Site Utilities and Settings
 *
 * @link http://www.elevatedMDG.com
 *
 */

 // default load all additional templates as neccessary
 // require_once locate_template('/lib/emdg/emdg-post-formats.php');			  // eMDG Custom - Post Formatsd
 // require_once locate_template('/lib/emdg/emdg-staff.php');                  // eMDG Custom - CPT Staff
 // require_once locate_template('/lib/emdg/emdg-testimonials.php');			      // eMDG Custom - CPT Testimonials
 // require_once locate_template('/lib/emdg/emdg-portfolio.php');				      // eMDG Custom - Portfolio
 // require_once locate_template('/lib/emdg/emdg-metaboxes.php');				      // eMDG Custom - Enable Meta Boxes
 // require_once locate_template('/lib/emdg/emdg-metaboxes-post-formats.php');	// eMDG Custom - Enable Post Format Meta Boxes
 // require_once locate_template('/lib/emdg/emdg-shortcodes.php');				      // eMDG Custom - Shortcodes
 // require_once locate_template('/lib/emdg/emdg-breadcrumbs.php');				    // eMDG Custom - Breadcrumbs
 // require_once locate_template('/lib/emdg/emdg-sidebar.php');					    // eMDG Custom - Sidebar Control
 // require_once locate_template('/lib/emdg/emdg-gforms-2.php');				    // eMDG Custom - Gravity Forms Fixes
 // require_once locate_template('/lib/emdg/emdg-gforms-styles.php');		    // eMDG Custom - Gravity Forms Fixes
 // require_once locate_template('/lib/emdg/emdg-fonts.php');					        // eMDG Custom - Font Loader
 // require_once locate_template('/lib/emdg/emdg-redux.php');				        // eMDG Custom - Redux
 // require_once locate_template('/lib/emdg/emdg-custom.php');					        // eMDG Custom - Custom Functions
 // require_once locate_template('/lib/emdg/emdg-menus.php');					        // eMDG Custom - Menu Loader
 // require_once locate_template('/lib/emdg/emdg-theme-menu.php');				  // eMDG Custom - Theme Menu
 // require_once locate_template('/lib/emdg/emdg-class-tgm-plugin-activation.php');		// eMDG Custom - TGM Class Activation
 // require_once locate_template('/lib/emdg/emdg-tgm-req-plugins.php');			// eMDG Custom - Plugin Loader List

namespace eMDG\ArticlesMenuChange;

 function change_post_menu_label() {
     global $menu;
     global $submenu;
     $menu[5][0] = 'Articles';
     $submenu['edit.php'][5][0] = 'Articles';
     $submenu['edit.php'][10][0] = 'Add New Article';
 //    $submenu['edit.php'][15][0] = 'Status'; // Change name for categories
 //    $submenu['edit.php'][16][0] = 'Labels'; // Change name for tags
     echo '';
 }

namespace eMDG\ArticlesNameChange;

 function change_post_object_label() {
         global $wp_post_types;
         $labels = &$wp_post_types['post']->labels;
         $labels->name = 'Articles';
         $labels->singular_name = 'Article';
         $labels->add_new = 'Add Article';
         $labels->add_new_item = 'Add Article';
         $labels->edit_item = 'Edit Articles';
         $labels->new_item = 'Article';
         $labels->view_item = 'View Article';
         $labels->search_items = 'Search Articles';
         $labels->not_found = 'No Articles found';
         $labels->not_found_in_trash = 'No Articles found in Trash';
     }
     add_action( 'init', 'change_post_object_label' );
     add_action( 'admin_menu', 'change_post_menu_label' );
