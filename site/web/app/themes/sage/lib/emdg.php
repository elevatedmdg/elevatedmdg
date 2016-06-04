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



 // auto add data and class to link anchor for lightbox in posts and pages
 // best so far http://stackoverflow.com/questions/24042890/add-class-to-wordpress-image-a-anchor-elements

 // add custom image sizes and make them available to posts and pages
 add_action( 'after_setup_theme', 'image_additions' );
 function image_additions() {
 	add_image_size( 'small', 97, 9999 ); // small image thumbnails for inside posts with no height crop
 	add_image_size( 'post-full', 750, 9999 ); // full width image for inside posts with no height crop
 	add_image_size( 'video-post', 750, 422, true ); // widescreen video thumbnail for post with sidebar
 	add_image_size( 'video-full', 1170, 658, true ); // widescreen video thumbnail for full pages
 	add_image_size( 'header', 1170, 280, true ); // header for full-width pages & posts, resized for posts with sidebars
 }

 // add to post insert options
 add_filter( 'image_size_names_choose', 'custom_image_sizes_choose' );
 function custom_image_sizes_choose( $sizes ) {
     $custom_sizes = array(
         'featured-image' => 'Featured Image',
         'small' => 'Small Thumbnail',
         'post-full' => 'Full Post',
         'video-post' => 'Video Post Thumbnail',
         'video-full' => 'Video Full Thumbnail'
     );
     return array_merge( $sizes, $custom_sizes );
 }

 // media attachment defaults
 add_action( 'after_setup_theme', 'default_attachment_display_settings' );
 function default_attachment_display_settings() {
 	update_option( 'image_default_align', 'left' );
 	update_option( 'image_default_link_type', 'file' );
 	update_option( 'image_default_size', 'small' );
 }

 // add data-toggle to image links in posts and pages
 function add_lightbox_to_linked_images($html) {
 	$lightbox = 'data-toggle="lightbox"';

     $patterns = array();
     $replacements = array();

     $patterns[0] = '/<a(?![^>]*class)([^>]*)>\s*<img([^>]*)>\s*<\/a>/'; // matches img tag wrapped in anchor tag where anchor tag where anchor has no existing classes
     $replacements[0] = '<a\1 ' . $lightbox . '><img\2></a>';

 	$html = preg_replace($patterns, $replacements, $html);

 	return $html;
 }

 add_filter('the_content', 'add_lightbox_to_linked_images', 100, 1);

 // add classes and data to image links in posts and pages
 function add_classes_to_linked_images($html) {
     $classes = 'img-responsive thumbnail'; // can do multiple classes, separate with space

     $patterns = array();
     $replacements = array();

     $patterns[0] = '/<img(?![^>]*class)([^>]*)>/'; // matches img tag wrapped in anchor tag where anchor tag where anchor has no existing classes
     $replacements[0] = '<img\1 class="' . $classes . '">';

     $patterns[1] = '/<img([^>]*)class="([^"]*)"([^>]*)>/'; // matches img tag wrapped in anchor tag where anchor has existing classes contained in double quotes
     $replacements[1] = '<img\1class="' . $classes . ' \2"\3>';

     $patterns[2] = '/<img([^>]*)class=\'([^\']*)\'([^>]*)>/'; // matches img tag wrapped in anchor tag where anchor has existing classes contained in single quotes
     $replacements[2] = '<img\1class="' . $classes . ' \2"\3>';

     $html = preg_replace($patterns, $replacements, $html);

     return $html;
 }

 add_filter('the_content', 'add_classes_to_linked_images', 100, 1);

 // add data-title for lightbox
 // function add_datatitle_to_linked_images($html) {
 //     $datatitle = 'Generic Title'; // can do multiple classes, separate with space

 //     $patterns = array();
 //     $replacements = array();

 //     $patterns[0] = '/<a(?![^>]*data-title)([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
 //     $replacements[0] = '<a\1 data-title="' . $datatitle . '"><img\2></a>';

 //     $patterns[1] = '/<a([^>]*)data-title="([^"]*)"([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
 //     $replacements[1] = '<a\1data-title="' . $datatitle . ' \2"\3><img\4></a>';

 //     $patterns[2] = '/<a([^>]*)data-title=\'([^\']*)\'([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
 //     $replacements[2] = '<a\1data-title="' . $datatitle . ' \2"\3><img\4></a>';

 //     $html = preg_replace($patterns, $replacements, $html);

 //     return $html;
 // }

 // add_filter('the_content', 'add_datatitle_to_linked_images', 100, 1);

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

 // check if is child page of
 function is_child($pageID) {
     global $post;
     if( is_page() && ($post->post_parent==$pageID) ) {
                return true;
     } else {
                return false;
     }
 }

 /**
  * Display template for breadcrumbs.
  * @link https://github.com/rachelbaker/bootstrapwp-Twitter-Bootstrap-for-WordPress
  */
 function bootstrapwp_breadcrumbs()
 {
     $home      = __('Home', 'bootstrapwp'); // text for the 'Home' link
     $before    = '<li class="active">'; // tag before the current crumb
 //  $sep       = '<span class="divider">/</span>';
     $after     = '</li>'; // tag after the current crumb

     if (!is_home() && !is_front_page() || is_paged()) {

         echo '<ul class="breadcrumb">';

         global $post;
         $homeLink = home_url();
             echo '<li><a href="' . $homeLink . '">' . $home . '</a> '.$sep. '</li> ';
             if (is_category()) {
                 global $wp_query;
                 $cat_obj   = $wp_query->get_queried_object();
                 $thisCat   = $cat_obj->term_id;
                 $thisCat   = get_category($thisCat);
                 $parentCat = get_category($thisCat->parent);
                 if ($thisCat->parent != 0) {
                     echo get_category_parents($parentCat, true, $sep);
                 }
                 echo $before . __('Archive by category', 'bootstrapwp') . ' "' . single_cat_title('', false) . '"' . $after;
             } elseif (is_day()) {
                 echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time(
                     'Y'
                 ) . '</a></li> ';
                 echo '<li><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time(
                     'F'
                 ) . '</a></li> ';
                 echo $before . get_the_time('d') . $after;
             } elseif (is_month()) {
                 echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time(
                     'Y'
                 ) . '</a></li> ';
                 echo $before . get_the_time('F') . $after;
             } elseif (is_year()) {
                 echo $before . get_the_time('Y') . $after;
             } elseif (is_single() && !is_attachment()) {
                 if (get_post_type() != 'post') {
                     $post_type = get_post_type_object(get_post_type());
                     $slug      = $post_type->rewrite;
                     echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ';
                     echo $before . get_the_title() . $after;
                 } else {
                     $cat = get_the_category();
                     $cat = $cat[0];
                     echo '<li>'.get_category_parents($cat, true, $sep).'</li>';
                     echo $before . get_the_title() . $after;
                 }
             } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                 $post_type = get_post_type_object(get_post_type());
                 echo $before . $post_type->labels->singular_name . $after;
             } elseif (is_attachment()) {
                 $parent = get_post($post->post_parent);
                 $cat    = get_the_category($parent->ID);
                 $cat    = $cat[0];
                 echo get_category_parents($cat, true, $sep);
                 echo '<li><a href="' . get_permalink(
                     $parent
                 ) . '">' . $parent->post_title . '</a></li> ';
                 echo $before . get_the_title() . $after;

             } elseif (is_page() && !$post->post_parent) {
                 echo $before . get_the_title() . $after;
             } elseif (is_page() && $post->post_parent) {
                 $parent_id   = $post->post_parent;
                 $breadcrumbs = array();
                 while ($parent_id) {
                     $page          = get_page($parent_id);
                     $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title(
                         $page->ID
                     ) . '</a>' . $sep . '</li>';
                     $parent_id     = $page->post_parent;
                 }
                 $breadcrumbs = array_reverse($breadcrumbs);
                 foreach ($breadcrumbs as $crumb) {
                     echo $crumb;
                 }
                 echo $before . get_the_title() . $after;
             } elseif (is_search()) {
                 echo $before . __('Search results for', 'bootstrapwp') . ' "'. get_search_query() . '"' . $after;
             } elseif (is_tag()) {
                 echo $before . __('Posts tagged', 'bootstrapwp') . ' "' . single_tag_title('', false) . '"' . $after;
             } elseif (is_author()) {
                 global $author;
                 $userdata = get_userdata($author);
                 echo $before . __('Articles posted by', 'bootstrapwp') . ' ' . $userdata->display_name . $after;
             } elseif (is_404()) {
                 echo $before . __('Error 404', 'bootstrapwp') . $after;
             }
             // if (get_query_var('paged')) {
             //     if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()
             //     ) {
             //         echo ' (';
             //     }
             //     echo __('Page', 'bootstrapwp') . $sep . get_query_var('paged');
             //     if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()
             //     ) {
             //         echo ')';
             //     }
             // }

         echo '</ul>';

     }
 }

 // remove comments from attachment pages
 add_action( 'pre_comment_on_post', 'remove_comments_from_attachments', 10, 2 );
 /**
  * Function to remove the comment section from all attachment pages
  *
  * @param  $open
  * @param  $post_id
  */
 function remove_comments_from_attachments( $open, $post_id ){
     return ( 'attachment' == get_post_type( $post_id )  ) ? false : $open;
 }

 // if search returns single post forward to that result
 add_action('template_redirect', 'single_result');
 function single_result() {
     if (is_search()) {
         global $wp_query;
         if ($wp_query->post_count == 1) {
             wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
         }
     }
 }

 // auto replace words with affiliate links
 function replace_text_wps($text){
     $replace = array(
     // 'WORD TO REPLACE' => 'REPLACE WORD WITH THIS'
     'thesis' => '<a href="http://mysite.com/myafflink">thesis</a>',
     'studiopress' => '<a href="http://mysite.com/myafflink">studiopress</a>'
     );
     $text = str_replace(array_keys($replace), $replace, $text);
     return $text;
 }

 add_filter('the_content', 'replace_text_wps');
 add_filter('the_excerpt', 'replace_text_wps');

 // disable emojis
 function disable_wp_emojicons() {
   // all actions related to emojis
   remove_action( 'admin_print_styles', 'print_emoji_styles' );
   remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
   remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
   remove_action( 'wp_print_styles', 'print_emoji_styles' );
   remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
   remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
   remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

 // filter to remove TinyMCE emojis
   add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
 }
 add_action( 'init', 'disable_wp_emojicons' );

 function disable_emojicons_tinymce( $plugins ) {
   if ( is_array( $plugins ) ) {
     return array_diff( $plugins, array( 'wpemoji' ) );
   } else {
     return array();
   }
 }

 // get and store page id or slug
 function get_page_content($page_id_or_slug) {
 	if(!is_int($page_id_or_slug)) {
 		$page = get_page_by_path($page_id_or_slug);
 		$page_id_or_slug = $page->ID;
 	}
 	$page_data = get_page($page_id_or_slug);
 	$content = apply_filters('the_content', $page_data->post_content);
 	return $content;
 }

 // in use
 // echo get_page_content("about-me");
 // echo get_page_content(15);

 // add copyright date to media uploader
 /**
  * Adding a "Copyright" field to the media uploader $form_fields array
  *
  * @param array $form_fields
  * @param object $post
  *
  * @return array
  */

 function add_copyright_field_to_media_uploader( $form_fields, $post ) {
 	$form_fields['copyright_field'] = array(
 		'label' => __('Copyright'),
 		'value' => get_post_meta( $post->ID, '_custom_copyright', true ),
 		'helps' => 'Set a copyright credit for the attachment'
 	);

 	return $form_fields;
 }
 add_filter( 'attachment_fields_to_edit', 'add_copyright_field_to_media_uploader', null, 2 );

 /**
  * Save our new "Copyright" field
  *
  * @param object $post
  * @param object $attachment
  *
  * @return array
  */
 function add_copyright_field_to_media_uploader_save( $post, $attachment ) {
 	if ( ! empty( $attachment['copyright_field'] ) )
 		update_post_meta( $post['ID'], '_custom_copyright', $attachment['copyright_field'] );
 	else
 		delete_post_meta( $post['ID'], '_custom_copyright' );

 	return $post;
 }
 add_filter( 'attachment_fields_to_save', 'add_copyright_field_to_media_uploader_save', null, 2 );

 /**
  * Display our new "Copyright" field
  *
  * @param int $attachment_id
  *
  * @return array
  */
 function get_featured_image_copyright( $attachment_id = null ) {
 	$attachment_id = ( empty( $attachment_id ) ) ? get_post_thumbnail_id() : (int) $attachment_id;

 	if ( $attachment_id )
 		return get_post_meta( $attachment_id, '_custom_copyright', true );

 }

 // in use wrapped in php
 // echo get_featured_image_copyright();

 // get gravatar with MD5 hash conversion
  function my_gravatar_url() { // Get user email
 $user_email = get_the_author_meta( 'user_email' );
 // Convert email into md5 hash and set image size to 80 px
 $user_gravatar_url = 'http://www.gravatar.com/avatar/' . md5($user_email) . '?s=80';
 echo $user_gravatar_url; }
 // now my_gravatar_url() is available for use

 // store post view counts
 function getPostViews($postID){
     $count_key = 'post_views_count';
     $count = get_post_meta($postID, $count_key, true);
     if($count==''){
         delete_post_meta($postID, $count_key);
         add_post_meta($postID, $count_key, '0');
         return "0 View";
     }
     return $count.' Views';
 }
 function setPostViews($postID) {
     $count_key = 'post_views_count';
     $count = get_post_meta($postID, $count_key, true);
     if($count==''){
         $count = 0;
         delete_post_meta($postID, $count_key);
         add_post_meta($postID, $count_key, '0');
     }else{
         $count++;
         update_post_meta($postID, $count_key, $count);
     }
 }

 // Remove issues with prefetching adding extra views
 remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

 // fetch copyright dates for oldest post to current date
 function full_copyright() {
     global $wpdb;
     $copyright_dates = $wpdb->get_results("
         SELECT
         YEAR(min(post_date_gmt)) AS firstdate,
         YEAR(max(post_date_gmt)) AS lastdate
         FROM
         $wpdb->posts
         WHERE
         post_status = 'publish'
         ");
     $output = '';
         if($copyright_dates) {
             $copyright = "&copy; " . $copyright_dates[0]->firstdate;
         if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
             $copyright .= ' - ' . $copyright_dates[0]->lastdate;
         }
         $output = $copyright;
     }
     return $output;
 }
