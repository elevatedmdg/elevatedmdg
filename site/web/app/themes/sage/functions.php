<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php', // Theme customizer
  'lib/emdg.php',      // eMDG functions
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

// add custom post type
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

//run once for all meta boxes
add_action('admin_menu', 'plib_add_box');
//add meta boxes to post types
function plib_add_box() {
    global $meta_box;

    foreach($meta_box as $post_type => $value) {
        add_meta_box($value['id'], $value['title'], 'plib_format_box', $post_type, $value['context'], $value['priority']);
    }
}

//format meta boxes
function plib_format_box() {
  global $meta_box, $post;

  //use nonce for verification
  echo '<input type="hidden" name="plib_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

  echo '<table class="form-table">';

  foreach ($meta_box[$post->post_type]['fields'] as $field) {

   // get current post meta data
      $meta = get_post_meta($post->ID, $field['id'], true);

      echo '<tr>'.
              '<th style="width:20%"><label for="'. $field['id'] .'">'. $field['name']. '</label></th>'.
              '<td>';
      switch ($field['type']) {
          case 'text':
              echo '<input type="text" name="'. $field['id']. '" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['default']) . '" size="30" style="width:97%" />'. '<br />'. $field['desc'];
              break;
          case 'textarea':
              echo '<textarea name="'. $field['id']. '" id="'. $field['id']. '" cols="60" rows="4" style="width:97%">'. ($meta ? $meta : $field['default']) . '</textarea>'. '<br />'. $field['desc'];
              break;
          case 'select':
              echo '<select name="'. $field['id'] . '" id="'. $field['id'] . '">';
              foreach ($field['options'] as $option) {
                  echo '<option '. ( $meta == $option ? ' selected="selected"' : '' ) . '>'. $option . '</option>';
              }
              echo '</select>';
              break;
          case 'radio':
              foreach ($field['options'] as $option) {
                  echo '<input type="radio" name="' . $field['id'] . '" value="' . $option['value'] . '"' . ( $meta == $option['value'] ? ' checked="checked"' : '' ) . ' />' . $option['name'];
              }
              break;
          case 'checkbox':
              echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '"' . ( $meta ? ' checked="checked"' : '' ) . ' />';
              break;
      }
      echo     '<td>'.'</tr>';
  }

  echo '</table>';

}

//save data from meta box
function plib_save_data($post_id) {
    global $meta_box,  $post;

    //verify nonce
    if (!wp_verify_nonce($_POST['plib_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    //check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    //check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box[$post->post_type]['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

add_action('save_post', 'plib_save_data');



/// create metaboxes
add_action( 'admin_init', 'add_post_format_metabox' );

function add_post_format_metabox() {
    global $metaboxes;

    if ( ! empty( $metaboxes ) ) {
        foreach ( $metaboxes as $id => $metabox ) {
            add_meta_box( $id, $metabox['title'], 'show_metaboxes', $metabox['applicableto'], $metabox['location'], $metabox['priority'], $id );
        }
    }
}


/// show metaboxes

function show_metaboxes( $post, $args ) {
    global $metaboxes;

    $custom = get_post_custom( $post->ID );
    $fields = $tabs = $metaboxes[$args['id']]['fields'];

    /** Nonce **/
    $output = '<input type="hidden" name="post_format_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';

    if ( sizeof( $fields ) ) {
        foreach ( $fields as $id => $field ) {
            switch ( $field['type'] ) {
                default:
                case "text":

                    $output .= '<label for="' . $id . '">' . $field['title'] . '</label><input id="' . $id . '" type="text" name="' . $id . '" value="' . $custom[$id][0] . '" size="' . $field['size'] . '" />';

                    break;
            }
        }
    }

    echo $output;
}


/// save metaboxes
add_action( 'save_post', 'save_metaboxes' );

function save_metaboxes( $post_id ) {
    global $metaboxes;

    // verify nonce
    if ( ! wp_verify_nonce( $_POST['post_format_meta_box_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    // check permissions
    if ( 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }

    $post_type = get_post_type();

    // loop through fields and save the data
    foreach ( $metaboxes as $id => $metabox ) {
        // check if metabox is applicable for current post type
        if ( $metabox['applicableto'] == $post_type ) {
            $fields = $metaboxes[$id]['fields'];

            foreach ( $fields as $id => $field ) {
                $old = get_post_meta( $post_id, $id, true );
                $new = $_POST[$id];

                if ( $new && $new != $old ) {
                    update_post_meta( $post_id, $id, $new );
                }
                elseif ( '' == $new && $old || ! isset( $_POST[$id] ) ) {
                    delete_post_meta( $post_id, $id, $old );
                }
            }
        }
    }
}


/// load jquery
add_action( 'admin_print_scripts', 'display_metaboxes', 1000 );

/// control metabox display
function display_metaboxes() {
    global $metaboxes;
    if ( get_post_type() == "post" ) :
        ?>
        <script type="text/javascript">// <![CDATA[
            $ = jQuery;

            <?php
            $formats = $ids = array();
            foreach ( $metaboxes as $id => $metabox ) {
                array_push( $formats, "'" . $metabox['display_condition'] . "': '" . $id . "'" );
                array_push( $ids, "#" . $id );
            }
            ?>

            var formats = { <?php echo implode( ',', $formats );?> };
            var ids = "<?php echo implode( ',', $ids ); ?>";
/// trigger corrct metabox
            function displayMetaboxes() {
                // Hide all post format metaboxes
                $(ids).hide();
                // Get current post format
                var selectedElt = $("input[name='post_format']:checked").attr("id");

                // If exists, fade in current post format metabox
                if ( formats[selectedElt] )
                    $("#" + formats[selectedElt]).fadeIn();
            }

            $(function() {
                // Show/hide metaboxes on page load
                displayMetaboxes();

                // Show/hide metaboxes on change event
                $("input[name='post_format']").change(function() {
                    displayMetaboxes();
                });
            });

        // ]]></script>
        <?php
    endif;
}

?>