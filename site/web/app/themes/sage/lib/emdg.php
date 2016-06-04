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
 require_once locate_template('/lib/emdg/emdg-testimonials.php');			      // eMDG Custom - CPT Testimonials
 // require_once locate_template('/lib/emdg/emdg-portfolio.php');				      // eMDG Custom - Portfolio
 require_once locate_template('/lib/emdg/emdg-metaboxes.php');				      // eMDG Custom - Enable Meta Boxes
 require_once locate_template('/lib/emdg/emdg-metaboxes-post-formats.php');	// eMDG Custom - Enable Post Format Meta Boxes
 // require_once locate_template('/lib/emdg/emdg-shortcodes.php');				      // eMDG Custom - Shortcodes
 // require_once locate_template('/lib/emdg/emdg-breadcrumbs.php');				    // eMDG Custom - Breadcrumbs
 // require_once locate_template('/lib/emdg/emdg-sidebar.php');					    // eMDG Custom - Sidebar Control
 // require_once locate_template('/lib/emdg/emdg-gforms-2.php');				    // eMDG Custom - Gravity Forms Fixes
 // require_once locate_template('/lib/emdg/emdg-gforms-styles.php');		    // eMDG Custom - Gravity Forms Fixes
 // require_once locate_template('/lib/emdg/emdg-fonts.php');					        // eMDG Custom - Font Loader
 // require_once locate_template('/lib/emdg/emdg-redux.php');				        // eMDG Custom - Redux
 require_once locate_template('/lib/emdg/emdg-custom.php');					        // eMDG Custom - Custom Functions
 // require_once locate_template('/lib/emdg/emdg-menus.php');					        // eMDG Custom - Menu Loader
 // require_once locate_template('/lib/emdg/emdg-theme-menu.php');				  // eMDG Custom - Theme Menu
 // require_once locate_template('/lib/emdg/emdg-class-tgm-plugin-activation.php');		// eMDG Custom - TGM Class Activation
 // require_once locate_template('/lib/emdg/emdg-tgm-req-plugins.php');			// eMDG Custom - Plugin Loader List
