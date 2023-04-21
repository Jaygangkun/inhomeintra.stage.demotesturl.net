<?php
/**
 * Stark functions and definitions
 *
 * @since Stark 1.0
 */

/**
 * This theme only works in WordPress 4.1 or later.
 */

if ( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
    acf_add_options_sub_page('Header');
    acf_add_options_sub_page('Footer');
    acf_add_options_sub_page('Leaders Board');
}

if ( ! function_exists( 'theme_setup' ) ) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function theme_setup() {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * TODO: Use this to add translation support
         */
        // load_theme_textdomain( 'stark', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /**
         * Remove a whole bunch of useless tags / security vulnerabilities
         */
        remove_action('wp_head', 'rsd_link'); //removes EditURI/RSD (Really Simple Discovery) link.
        remove_action('wp_head', 'wlwmanifest_link'); //removes wlwmanifest (Windows Live Writer) link.
        remove_action('wp_head', 'wp_generator'); //removes meta name generator.
        remove_action('wp_head', 'wp_shortlink_wp_head'); //removes shortlink.
        remove_action( 'wp_head', 'feed_links', 2 ); //removes feed links.
        remove_action('wp_head', 'feed_links_extra', 3 );  //removes comments feed.
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head'); //remove 'prev' and 'next' broken tags


        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support( 'post-thumbnails' );
        // TODO: Change this to desired size based on design
        set_post_thumbnail_size( 825, 510, true );

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus( array(
            'primary' => __( 'Header Menu' ),
            'footer'  => __( 'Footer Menu' ),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ) );
    }
endif; // theme_setup
add_action( 'after_setup_theme', 'theme_setup' );

function stark_theme_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Homepage Introductory Text Area', '' ),
        'id'            => 'homepage-intro-text',
        'description'   => __( 'Appears in the homepage section of the site.', '' ),
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );
    register_sidebar( array(
        'name'          => __( 'Sidebar Widget Area', '' ),
        'id'            => 'sidebar_widget',
        'description'   => __( 'Appears in sidebar of pages.', '' ),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );
    register_sidebar( array(
        'name'          => __( 'Blog Widget Area', '' ),
        'id'            => 'blog_widget',
        'description'   => __( 'Appears on blog page.', '' ),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer Widget Area', '' ),
        'id'            => 'footer_widget',
        'description'   => __( 'Appears in the standard footer.', '' ),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );
}
add_action( 'widgets_init', 'stark_theme_widgets_init' , 11);

add_theme_support( 'infinite-transporter' ); // TODO: Figure out what this is hooking into

/* TODO: Figure out if any of this is strictly necessary or useful */

/*
1. Search for all headings
2. Generate the slug
3. Set that slug as id attribute */

function add_id_to_headings( $html ) {

    // Store all headings of the post in an array
    $tagNames = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' );
    $headings = array();
    $headingContents = array();
    foreach ( $tagNames as $tagName ) {
        $nodes = $html->getElementsByTagName( $tagName );
        foreach ( $nodes as $node ) {
            $headings[] = $node;
            $headingContents[ $node->textContent ] = 0;
        }
    }

    foreach ( $headings as $heading ) {

        $title = $heading->textContent;

        if ( $title === '' ) {
            continue;
        }

        $count = ++$headingContents[ $title ];

        $suffix = $count > 1 ? "-$count" : '';

        $slug = sanitize_title( $title );
        $heading->setAttribute( 'id', $slug . $suffix );
    }

}

/* Remove the wrapping paragraph from images and other elements, such as picture, video, audio, and iframe. */

function content_remove_wrapping_p( $html ) {

    // Iterating a nodelist while manipulating it is not a good thing, because
    // the nodelist dynamically updates itself. Get all things that must be
    // unwrapped and put them in an array.
    $tagNames = array( 'img', 'picture', 'video', 'audio', 'iframe' );
    $mediaElements = array();
    foreach ( $tagNames as $tagName ) {
        $nodes = $html->getElementsByTagName( $tagName );
        foreach ( $nodes as $node ) {
            $mediaElements[] = $node;
        }
    }

    foreach ( $mediaElements as $element ) {

        // Get a reference to the parent paragraph that may have been added by
        // WordPress. It might be the direct parent node or the grandparent
        // (LOL) in case of links
        $paragraph = null;

        // Get a reference to the image itself or to the link containing the
        // image, so we can later remove the wrapping paragraph
        $theElement = null;

        if ( $element->parentNode->nodeName == 'p' ) {
            $paragraph = $element->parentNode;
            $theElement = $element;
        } else if ( $element->parentNode->nodeName == 'a' &&
            $element->parentNode->parentNode->nodeName == 'p' ) {
            $paragraph = $element->parentNode->parentNode;
            $theElement = $element->parentNode;
        }

        // Make sure the wrapping paragraph only contains this child
        if ( $paragraph && $paragraph->textContent == '' ) {
            $paragraph->parentNode->replaceChild( $theElement, $paragraph );
        }
    }

}

class MSDOMDocument extends DOMDocument {
    public function saveHTML ( $node = null ) {
        $string = parent::saveHTML( $node );

        return str_replace( array( '<html><body>', '</body></html>' ), '', $string );
    }
}

// TODO: Figure out what this functions purpose exactly.
function example_the_content( $content ) {

    // First encode all characters to their HTML entities
    $encoded = mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' );

    // Load the content, suppressing warnings (libxml complains about not having
    // a root element (we have many paragraphs)
    $html = new MSDOMDocument();
    $ok = @$html->loadHTML( $encoded, LIBXML_HTML_NODEFDTD | LIBXML_NOBLANKS );

    // If it didn't parse the HTML correctly, do not proceed. Return the original, untransformed, post
    if ( !$ok ) {
        return $content;
    }

    // Pass the document to all filters
    add_id_to_headings( $html );
    content_remove_wrapping_p( $html );

    // Filtering is done. Serialize the transformed post
    return $html->saveHTML();

}
add_filter( 'the_content', 'example_the_content' );

function auth_cookie_expiration_filter($expiration, $user_id, $remember)
{
    $seconds = $expiration;

    $user_data = get_userdata( $user_id );

    if(!in_array('Administrator', $user_data->roles))
    {
        $seconds = DAY_IN_SECONDS * 39;
    }

    return $seconds;
}

add_filter('auth_cookie_expiration', 'auth_cookie_expiration_filter', 999, 3);



if(isset($_POST['login_Sbumit'])) {
    $creds                  = array();
    $creds['user_login']    = stripslashes( trim( $_POST['userName'] ) );
    $creds['user_password'] = stripslashes( trim( $_POST['passWord'] ) );
    $creds['remember']      = isset( $_POST['rememberMe'] ) ? sanitize_text_field( $_POST['rememberMe'] ) : '';
    $redirect_to            = esc_url_raw( $_POST['redirect_to'] );
    $secure_cookie          = null;



        
    if($redirect_to == '')
        $redirect_to= get_site_url(). '/' ; 
        
        if ( ! force_ssl_admin() ) {
            $user = is_email( $creds['user_login'] ) ? get_user_by( 'email', $creds['user_login'] ) : get_user_by( 'login', sanitize_user( $creds['user_login'] ) );

        if ( $user && get_user_option( 'use_ssl', $user->ID ) ) {
            $secure_cookie = true;
            force_ssl_admin( true );
        }
    }

    if ( force_ssl_admin() ) {
        $secure_cookie = true;
    }

    if ( is_null( $secure_cookie ) && force_ssl_login() ) {
        $secure_cookie = false;
    }

 
   

    $user = wp_signon( $creds, $secure_cookie );

    



    if ( $secure_cookie && strstr( $redirect_to, 'wp-admin' ) ) {
        $redirect_to = str_replace( 'http:', 'https:', $redirect_to );
    }

    if ( ! is_wp_error( $user ) ) {
        wp_safe_redirect( get_home_url() . '?logd='.rand() ); 
        exit;          
    } else { 
        $error_mesg = "";           
        if ( $user->errors ) {
            $error_mesg = __('<strong>ERROR</strong>: Invalid user or password.'); 
        } else {
            $error_mesg = __( 'Please enter your username and password to login.', 'kvcodes' );
        }
        wp_safe_redirect( get_home_url() . '/log-in/?error_mesg='.urlencode(base64_encode($error_mesg)) ); 
        exit;
    }        
}








add_action( 'user_register', function ( $user_id ) {
    global $wpdb; 

   /* $args =  array(
            'id' =>'' ,
            'component' =>'members' ,
            'type' =>'last_activity' ,
            'user_id' =>$user_id ,
            'item_id' =>0 ,
            'hide_sitewide' =>0 ,
            'is_spam' =>0 


                );
*/
  //  $activity_id = bp_activity_add( $args );

      $date_recorded = date('Y-m-d H:i:s'); //2021-12-13 13:30:23          

      $table_name = $wpdb->prefix . 'bp_activity';     
      $wpdb->insert($table_name, array(
                    'user_id' => $user_id, 
                    'component' => 'members',
                    'type' => 'last_activity',
                    'action' => '',
                    'content' => '',
                    'primary_link' => '',
                    'item_id' => 0,
                    'date_recorded' => $date_recorded,
                    'hide_sitewide' =>0,
                    'mptt_left'=>0,
                    'mptt_right'=>0,
                    'is_spam'=>0

                )); 
   
    //$userdata = array();
    //$userdata['ID'] = $user_id;
    //$userdata['telnumber'] = $_POST['telnumber'];
    //wp_update_user( $userdata );

    /*$user_id = $user_id;
    $user = get_user_by( 'id', $user_id ); 
    if( $user ) {
        wp_set_current_user( $user_id, $user->user_login );
        wp_set_auth_cookie( $user_id );
        do_action( 'wp_login', $user->user_login );
        wp_logout();
    }*/


} );










function bpdev_exclude_users( $qs = '', $object = '' ) {
    // list of users to exclude.
    $excluded_user = '1'; // comma separated ids of users whom you want to exclude.
 
    if ( $object != 'members' ) {
        // hide for members only.
        return $qs;
    }
 
    $args = wp_parse_args( $qs );
 
    // check if we are listing friends?, do not exclude in this case.
    if ( ! empty( $args['user_id'] ) ) {
        return $qs;
    }
 
    if ( ! empty( $args['exclude'] ) ) {
        $args['exclude'] = $args['exclude'] . ',' . $excluded_user;
    } else {
        $args['exclude'] = $excluded_user;
    }
 
    $qs = build_query( $args );
 
    return $qs;
 
}
 
add_action( 'bp_ajax_querystring', 'bpdev_exclude_users', 20, 2 );


function hide_wordpress_admin_bar($user){
    return ( current_user_can( 'administrator' ) ) ? $user : false;
}
add_filter( 'show_admin_bar' , 'hide_wordpress_admin_bar');




add_filter( 'retrieve_password_message', 'my_retrieve_password_message', 10, 4 );
function my_retrieve_password_message( $message, $key, $user_login, $user_data ) {

    $message = __( "Hello" ) . "\r\n\r\n";

    $message .= __( "We've received a request to reset the password for the following InHome Therapy account:" ) . "\r\n\r\n";

    $message .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";

    $message .= __( "No changes to your account have been made at this time. To reset your password, click this link:" ) . "\r\n\r\n";
    
    $message .= network_site_url( "recover-password/?action=rp&method=gf&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";

    $message .= __( "If this was a mistake, ignore this email. If you did not make this request, or if you’d like to get in touch with us, please contact our support team." ) . "\r\n\r\n\r\n";



    $message .= __( "– The InHome Therapy Team" ) . "\r\n\r\n";



    return $message;

}





// define the retrieve_password_title callback 
function filter_retrieve_password_title( $title="", $user_login="", $user_data="" ) { 
    $title = "InHome Password Reset Request";
    return $title; 
}; 
         
// add the filter 
add_filter( 'retrieve_password_title', 'filter_retrieve_password_title', 10, 3 ); 

/////// get user ip address - starts //////

function get_the_user_ip() {

if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {

//check ip from share internet

$ip = $_SERVER['HTTP_CLIENT_IP'];

} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

//to check ip is pass from proxy

$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

} else {

$ip = $_SERVER['REMOTE_ADDR'];

}

return apply_filters( 'wpb_get_ip', $ip );

}

add_shortcode('display_ip', 'get_the_user_ip');

/////// get user ip address - ends //////




// add the ajax fetch js
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
?>
    <script type="text/javascript">
    function fetch(){

        var currentLength = jQuery("#agency_name").val().length;
        if(currentLength >=3){ 

            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                data: { action: 'data_fetch', keyword: jQuery('#agency_name').val() },
                success: function(data) {
                    jQuery('#datafetch').html( data );
                }
            });
        }

    }
    </script>

    <?php
}


// the ajax function
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){

    /* $args = array (
        'posts_per_page' => $number,
        'paged' => $paged,
        'post_type' => 'agencies',
        'post_status' => 'publish',
        'order' => 'DESC',
    );*/

    $the_query = new WP_Query( 
      array( 
        'posts_per_page' => -1, 
        's' => esc_attr( $_POST['keyword'] ), 
        'post_type' => 'agencies' 
      ) 
    );
  
    if( $the_query->have_posts() ) :
        while( $the_query->have_posts() ): $the_query->the_post(); ?>

            <p><span onclick="selectThisResult('<?php the_title();?>');"><?php the_title();?></span></p>

        <?php endwhile;
        wp_reset_postdata();  
    endif;

    die();
}

