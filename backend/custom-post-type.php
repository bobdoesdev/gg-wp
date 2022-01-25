<?php

add_action('init', 'wistia_video__register');

function wistia_video__register()
{

    $labels = array(

        'name' => _x('Wistia Video', 'post type general name'),
        'singular_name' => _x('Wistia Video', 'post type singular name'),
        'add_new' => _x('Add New', 'custom item'),
        'add_new_item' => __('Add New Wistia Video'),
        'edit_item' => __('Edit Wistia Video'),
        'new_item' => __('New Wistia Video'),
        'view_item' => __('View Wistia Video'),
        'search_items' => __('Search Wistia Video'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash')
    );

    $args = array(
        'labels' => $labels,
        'public' => true, // – should the posts be shown in the admin UI
        'publicly_queryable' => true, // - whether queries can be performed on the front end as part of parse_request()
        'show_ui' => true, // – should we display an admin panel for this custom post type
        'query_var' => true, // - the query_var key for this post type
        // 'menu_icon' => get_stylesheet_directory_uri() . '/someIcon.png', // – a custom icon for the admin panel
        'rewrite' => true, // – rewrites permalinks using the slug ‘portfolio’
        'capability_type' => 'post', // – WordPress will treat this as a ‘post’ for read, edit, and delete capabilities
        'hierarchical' => false, // – is it hierarchical, like pages
        'menu_position' => null, // - position in the menu order the post type should appear. show_in_menu must be true.
        'supports' => array('title',) // – which items do we want to display on the add/edit post page
    );


    register_post_type('wistia_video', $args);
}

add_action("admin_init", "admin_init");

function admin_init()
{
    add_meta_box("custom_meta", "Others & More", "custom_meta", "wistia_video", "normal", "low");
}

function custom_meta()
{
    global $post;
    $custom = get_post_custom($post->ID);
    $wistia_video_url = $custom["wistia_video_url"][0];

?>
    <label>Video ID:</label><br />
    <input type="text" name="wistia_video_url" value="<?php echo $wistia_video_url; ?>" />

<?php

}

// Save the info
add_action('save_post', 'save_details');

function save_details()
{
    global $post;
    // Make sure we reuse and save all the values triggered in year_completed() and custom_meta()

    update_post_meta($post->ID, "wistia_video_url", $_POST["wistia_video_url"]);
}

/* Filter the single_template with our custom function*/
add_filter('single_template', 'wistia_video_template');

function wistia_video_template($single) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'wistia_video' ) {
        if ( file_exists( plugin_dir_path( __FILE__ ) . 'template-single-video.php' ) ) {
            return plugin_dir_path( __FILE__ ) . 'template-single-video.php';
        }
    }

    return $single;

}

function add_async_forscript($url)
{
    if (strpos($url, '#asyncload')===false)
        return $url;
    else if (is_admin())
        return str_replace('#asyncload', '', $url);
    else
        return str_replace('#asyncload', '', $url)."' async='async";
}
add_filter('clean_url', 'add_async_forscript', 11, 1);