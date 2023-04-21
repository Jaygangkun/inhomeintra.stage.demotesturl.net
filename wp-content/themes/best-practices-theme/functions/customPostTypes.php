<?php

/**
 * custom post type for Agency
 */
function agencies_custom_post_type (){
    
    $labels = array(
        'name' => 'Agencies',
        'singular_name' => 'Agency',
        'add_new' => 'Add Agency',
        'all_items' => 'All Agencies',
        'add_new_item' => 'Add Agency',
        'edit_item' => 'Edit Agency',
        'new_item' => 'New Agency',
        'view_item' => 'View Agency',
        'search_item' => 'Search Agencies',
        'not_found' => 'No items found',
        'not_found_in_trash' => 'No Agency found in trash',
        'parent_item_colon' => 'Parent Agency'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'rewrite' => array('slug' => 'agency'),
        'capability_type' => 'post',
        'hierarchical' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revisions',
        ),
        'taxonomies' => array('agencies_category', 'post_tag'),
         register_taxonomy(
            'agencies_category',
            'jobs',
            array(
                'hierarchical' => true,
                'label' => 'Agencies Categories',
                'query_var' => true,
                'rewrite' => true,
                'show_in_nav_menus'=> true,
                'rewrite' => array( 'hierarchical' => true, 'slug' => 'agencies' )
            ) 
        ),
        'menu_position' => 5,
        'exclude_from_search' => false
    );
    register_post_type('Agencies', $args);
}
add_action('init','agencies_custom_post_type');




/**
 * custom post type for Clinical Director Feed
 */
function clinical_director_custom_post_type (){
    
    $labels = array(
        'name' => 'Clinical Directors',
        'singular_name' => 'Feed Item',
        'add_new' => 'Add Feed',
        'all_items' => 'All Feed Items',
        'add_new_item' => 'Add Feed Item',
        'edit_item' => 'Edit Feed Item',
        'new_item' => 'New Feed Item',
        'view_item' => 'View Feed Item',
        'search_item' => 'Search Clinical Directors Feed',
        'not_found' => 'No items found',
        'not_found_in_trash' => 'No Feed Item found in trash',
        'parent_item_colon' => 'Parent Feed Item'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'rewrite' => array('slug' => 'clinical_director_feed'),
        'capability_type' => 'post',
        'hierarchical' => true,
        'supports' => array(
            'title',
            'editor',
            'author',
            'excerpt',
            'thumbnail',
            'revisions',
        ),
        'taxonomies' => array('clinical_director_feed_category', 'post_tag'),
         register_taxonomy(
            'clinical_director_feed_category',
            'jobs',
            array(
                'hierarchical' => true,
                'label' => 'Clinical Director Feed Categories',
                'query_var' => true,
                'rewrite' => true,
                'show_in_nav_menus'=> true,
                'rewrite' => array( 'hierarchical' => true, 'slug' => 'clinical_director_feeds' )
            ) 
        ),
        'menu_position' => 5,
        'exclude_from_search' => false
    );
    register_post_type('Clinical Directors', $args);
}
add_action('init','clinical_director_custom_post_type');

/*function add_author_support_to_posts() {
   add_post_type_support( 'clinicaldirectors', 'author' ); 
}
add_action( 'init', 'add_author_support_to_posts' );
*/
/**
 * custom post type for Videos
 */
function videos_custom_post_type (){
    
    $labels = array(
        'name' => 'Videos',
        'singular_name' => 'Video',
        'add_new' => 'Add Video',
        'all_items' => 'All Videos',
        'add_new_item' => 'Add Video',
        'edit_item' => 'Edit Video',
        'new_item' => 'New Video',
        'view_item' => 'View Video',
        'search_item' => 'Search Videos',
        'not_found' => 'No items found',
        'not_found_in_trash' => 'No Video found in trash',
        'parent_item_colon' => 'Parent Video'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'rewrite' => array('slug' => 'video'),
        'capability_type' => 'post',
        'hierarchical' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revisions',
        ),
        'menu_position' => 6,
        'exclude_from_search' => false
    );
    register_post_type('Videos', $args);
}
add_action('init','videos_custom_post_type');


/**
 * custom post type for Employees
 */
function employees_custom_post_type (){
    
    $labels = array(
        'name' => 'Employees',
        'singular_name' => 'employee',
        'add_new' => 'Add Employee',
        'all_items' => 'All Employees',
        'add_new_item' => 'Add Employee',
        'edit_item' => 'Edit Employee',
        'new_item' => 'New Employee',
        'view_item' => 'View Employee',
        'search_item' => 'Search Employees',
        'not_found' => 'No data found',
        'not_found_in_trash' => 'No Employee found in trash',
        'parent_item_colon' => 'Parent Employee'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'rewrite' => array('slug' => 'employee'),
        'capability_type' => 'post',
        'hierarchical' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revisions',
        ),
        'menu_position' => 7,
        'exclude_from_search' => false
    );
    register_post_type('Employees', $args);
}
add_action('init','employees_custom_post_type');


add_filter( 'register_post_type_args', 'change_capabilities_of_clinicaldirectors' , 10, 2 );

function change_capabilities_of_clinicaldirectors( $args, $post_type ){

 if ( 'clinicaldirectors' !== $post_type ) {

     return $args;

 }

 $args['capabilities'] = array(
            'delete_post' => 'delete_clinicaldirectors',
            'delete_published_posts' => 'delete_published_clinicaldirectors',
            'edit_post' => 'edit_clinicaldirector',
            'edit_posts' => 'edit_clinicaldirectors',
            'edit_published_posts' => 'edit_published_clinicaldirectors',
            'publish_posts' => 'publish_clinicaldirectors',
            'read_post' => 'read_clinicaldirectors',
            'read_private_posts' => 'read_private_clinicaldirectors'
            );

  return $args;

}

flush_rewrite_rules();