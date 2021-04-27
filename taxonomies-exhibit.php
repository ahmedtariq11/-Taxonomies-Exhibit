<?php
/**
 * Plugin Name: Taxonomies Exhibit
 * Plugin URI: https://github.com/yttechiepress/taxonomies-exhibit
 * Author: Techiepress
 * Author URI: https://github.com/yttechiepress/taxonomies-exhibit
 * Description: Showing what taxonomies can do for you in WordPress
 * Version: 0.1.0
 * License: GPL2 or later
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: taxonomies-exhibit
*/

/**
 * Register a custom post type called "book".
 *
 * @see get_post_type_labels() for label keys.
 */
function wpdocs_codex_book_init() {
    $labels = array(
        'name'                  => _x( 'Books', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Book', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Books', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Book', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Book', 'textdomain' ),
        'new_item'              => __( 'New Book', 'textdomain' ),
        'edit_item'             => __( 'Edit Book', 'textdomain' ),
        'view_item'             => __( 'View Book', 'textdomain' ),
        'all_items'             => __( 'All Books', 'textdomain' ),
        'search_items'          => __( 'Search Books', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Books:', 'textdomain' ),
        'not_found'             => __( 'No books found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No books found in Trash.', 'textdomain' ),
        'featured_image'        => _x( 'Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'archives'              => _x( 'Book archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
        'insert_into_item'      => _x( 'Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
        'filter_items_list'     => _x( 'Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
        'items_list_navigation' => _x( 'Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
        'items_list'            => _x( 'Books list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'book' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'show_in_rest'       => true,
    );
 
    register_post_type( 'book', $args );
}
 
add_action( 'init', 'wpdocs_codex_book_init' );

// Add taxonomy for genres
/**
 * Create two taxonomies, genres and writers for the post type "book".
 *
 * @see register_post_type() for registering custom post types.
 */
function wpdocs_create_book_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Genres', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search Genres', 'textdomain' ),
        'all_items'         => __( 'All Genres', 'textdomain' ),
        'parent_item'       => __( 'Parent Genre', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Genre:', 'textdomain' ),
        'edit_item'         => __( 'Edit Genre', 'textdomain' ),
        'update_item'       => __( 'Update Genre', 'textdomain' ),
        'add_new_item'      => __( 'Add New Genre', 'textdomain' ),
        'new_item_name'     => __( 'New Genre Name', 'textdomain' ),
        'menu_name'         => __( 'Genre', 'textdomain' ),
    );
 
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'genre' ),
        'show_in_rest'       => true,
    );
 
    register_taxonomy( 'genre', array( 'book' ), $args );
 
}
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'wpdocs_create_book_taxonomies', 0 );

// Remove the description field in the Genre taxonomy
add_action( 'admin_footer', 'techiepress_remove_genre_fields');

function techiepress_remove_genre_fields() {
    global $current_screen;

    // var_dump($current_screen);

    if( 'edit-genre' === $current_screen->id ) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $('#tag-description').parent().remove();
                $('.term-description-wrap').remove();
                $('#tag-slug').parent().remove();
            });
        </script>
        <?php
    }
}

// remove column for description
add_filter( 'manage_edit-genre_columns', 'techiepress_remove_genre_columns' );

function techiepress_remove_genre_columns( $columns ) {
    if( $columns['description'] ) {
        unset($columns['description']);
        unset($columns['slug']);

        $columns['characterization'] = 'Characterization';
    }
    
    return $columns;
}

// Add info to the new columns
add_action( 'manage_genre_custom_column', 'techiepress_manage_genre_custom_columns', 10, 3 );

function techiepress_manage_genre_custom_columns( $string, $columns, $term_id ) {
    switch ( $columns ) {
        case 'characterization':
            echo get_term_meta( $term_id, 'genre-characterization', true );
            break;
    }
}

// Add new fields to genre
add_action( 'genre_add_form_fields', 'techiepress_add_genre_fields' );

function techiepress_add_genre_fields() {
    ?>
        <div class="form-field">
            <label for="genre-characterization">Characterization</label>
            <input type="text" name="genre-characterization" id="genre-characterization">
            <p>Every Genre has a particular characterization of it e.g Fiction - lies.</p>
        </div>
    <?php
}

// add the field to the edit screen.
add_action( 'genre_edit_form_fields', 'techiepress_edit_genre_fields', 10, 2 );

function techiepress_edit_genre_fields( $term, $taxonomy ) {
    // var_dump($term);
    $value = get_term_meta($term->term_id, 'genre-characterization', true );
    ?>
        <tr class="form-field">
			<th scope="row"><label for="genre-characterization">Characterization</label></th>
			<td><input type="text" name="genre-characterization" id="genre-characterization" value="<?php echo esc_attr( $value ); ?>" size="40">
			<p class="description">Every Genre has a particular characterization of it e.g Fiction - lies.</p></td>
		</tr>
    <?php
}

add_action( 'created_genre', 'techiepress_created_genre_fields' );
add_action( 'edited_genre', 'techiepress_created_genre_fields' );

function techiepress_created_genre_fields( $term_id ) {
    update_term_meta( $term_id, 'genre-characterization', sanitize_text_field( $_POST['genre-characterization'] ) );
}
