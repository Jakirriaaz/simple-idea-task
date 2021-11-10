<?php 

/**
 * Plugin Name:       Basic Form
 * Plugin URI:        https://jakirriaaz.com/plugins/basic-form/
 * Description:       Handle the basics form with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Jakir H.
 * Author URI:        https://jakirriaaz.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       td-basics-form
 * Domain Path:       /languages
 */

 
defined('ABSPATH') or die('directory path is desabled');

//start from here

class BF_basic_form{
   
    public function __construct(){
        
        add_action('init', array($this, 'bf_basic_form'));
        add_action('add_meta_boxes', array($this, 'additional_custome_field'));
        add_action('save_post', array($this, 'additional_custome_field_save'));
        add_action('wp_enqueue_scripts', array($this, 'stfb_enqueue_files'));
    }

    public function stfb_enqueue_files(){
        wp_enqueue_style('slick', PLUGINS_URL('css/slick.css', __FILE__));
        wp_enqueue_style('custom-style', PLUGINS_URL('css/style.css', __FILE__));
        wp_enqueue_script('slick-js', PLUGINS_URL('js/slick.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('custom-js', PLUGINS_URL('js/slick.custom.js', __FILE__), array('jquery'));
    }

    public function bf_main_basic_form(){
        add_shortcode('cbxcustomform', array($this, 'bf_basic_form_field'));
    }

    public function bf_basic_form_field(){
        ob_start();

        $var_post_type = new WP_Query(array(
            'post_type'         => 'cbxcustom',
            'posts_per_page'    => -1,
        )); ?>

        <div class="stfb-wrap-section">
            <?php while($var_post_type->have_posts()) : $var_post_type->the_post(); ?>
            <div class="student-feedback">
                <div class="title">
                   <h1><?php the_title(); ?></h1>
                   <p>Descriptions: <br/><?php the_content(); ?></p>
                </div>
                <div class="extra-field">
                    <?php global $value; ?>
                    <p>Singer Name: <span><?php echo esc_html(get_post_meta(get_the_id(), 'fav-singer', true)); ?></span></p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <?php return ob_get_clean();
    }

    public function bf_basic_form() {
        $labels = array(
            'name'                  => _x( 'StudentsSay', 'Post type general name', 'td-basics-form' ),
            'singular_name'         => _x( 'CBXcustom', 'Post type singular name', 'td-basics-form' ),
            'menu_name'             => _x( 'CBXcustoms', 'Admin Menu text', 'td-basics-form' ),
            'name_admin_bar'        => _x( 'CBXcustom', 'Add New on Toolbar', 'td-basics-form' ),
            'add_new'               => __( 'Add New', 'td-basics-form' ),
            'add_new_item'          => __( 'Add New CBXcustom', 'td-basics-form' ),
            'new_item'              => __( 'New CBXcustom', 'td-basics-form' ),
            'edit_item'             => __( 'Edit CBXcustom', 'td-basics-form' ),
            'view_item'             => __( 'View CBXcustom', 'td-basics-form' ),
            'all_items'             => __( 'All CBXcustoms', 'td-basics-form' ),
            'search_items'          => __( 'Search CBXcustoms', 'td-basics-form' ),
            'parent_item_colon'     => __( 'Parent CBXcustoms:', 'td-basics-form' ),
            'not_found'             => __( 'No CBXcustoms found.', 'td-basics-form' ),
            'not_found_in_trash'    => __( 'No CBXcustoms found in Trash.', 'td-basics-form' ),
            'featured_image'        => _x( 'CBXcustom Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'td-basics-form' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'td-basics-form' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'td-basics-form' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'td-basics-form' ),
            'archives'              => _x( 'CBXcustom archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'td-basics-form' ),
            'insert_into_item'      => _x( 'Insert into CBXcustom', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'td-basics-form' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this CBXcustom', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'td-basics-form' ),
            'filter_items_list'     => _x( 'Filter CBXcustoms list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'td-basics-form' ),
            'items_list_navigation' => _x( 'CBXcustoms list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'td-basics-form' ),
            'items_list'            => _x( 'CBXcustoms list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'td-basics-form' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'cbxcustom' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-editor-unlink',
            'supports'           => array( 'title', 'editor', ),
        );

        register_post_type( 'cbxcustom', $args );

    }

    public function additional_custome_field(){

        //Meta-box for additional field
        add_meta_box('fav-singer', 'Singer Information', array($this, 'singer_information'), 'cbxcustom', 'normal');
    }

    public function singer_information(){

        $value = get_post_meta(get_the_id(), 'fav-singer', true);
        ?>
        <table class="form-table editcomment">
            <tbody>
                <tr>
                    <td class="first"><label for="name">Singer Name: </label></td>
                    <td><input class="widefat" type="text" name="_cbxcustomform_singer" value="<?php echo esc_attr($value); ?>" id="name"></td>
                </tr>
            </tbody>
        </table>

        <?php
    }

    public function additional_custome_field_save($post_id){
        $name = $_POST['_cbxcustomform_singer'];
        update_post_meta($post_id, 'fav-singer', $name);
    }
   
}

$basicfrom = new BF_basic_form();
$basicfrom->bf_main_basic_form();