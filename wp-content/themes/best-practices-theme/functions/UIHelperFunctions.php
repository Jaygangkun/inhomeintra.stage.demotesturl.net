<?php

if (! function_exists('mix')) {
    /**
     * Get the path to a versioned Mix file.
     *
     * @param  string  $path
     * @return string
     *
     * @throws \Exception
     */
    function mix($path)
    {
        static $manifests = [];
        if (strpos($path, '/') !== 0) {
            $path = '/'.$path;
        }
        /*if (file_exists(public_path($manifestDirectory.'/hot'))) {
            return new HtmlString("//localhost:8080{$path}");
        }*/
        $manifestPath = dirname(__DIR__).'/public/mix-manifest.json';
        if (! isset($manifests[$manifestPath])) {
            if (! file_exists($manifestPath)) {
                throw new Exception('The Mix manifest does not exist.' . $manifestPath);
            }
            $manifests[$manifestPath] = json_decode(file_get_contents($manifestPath), true);
        }
        $manifest = $manifests[$manifestPath];
        if (! isset($manifest[$path])) {
            throw new Exception("Unable to locate Mix file: {$path}.");
        }
        return public_path($manifest[$path]);
    }

    /**
     * Get the path to the specified file in the public assets folder (/public)
     *
     * @param string $path
     * @return string
     */
    function public_path($path) {
        return get_stylesheet_directory_uri().'/public/'.$path;
    }
}

function isVirtualEvent($event_id)
{
    return get_field('is_this_virtual_event', $event_id);
}

function getVirtualEventUrl($event_id)
{
    return get_field('virtual_event_url', $event_id);
}

function getVirtualEventHtml($event_id)
{
    if(isVirtualEvent( $event_id ))
    {
        ?>
        <?php echo getVirtualEventUrl($event_id); ?>
        <?php
    }
}

function getUpcomingEvents($posts_per_page = 5)
{
    if(function_exists('tribe_get_events'))
    {
        $events = tribe_get_events( [
           'start_date'     => current_time('mysql'),
           'posts_per_page' => $posts_per_page
        ] );

        return $events;
    }

    return false;
}

function getAllUpcomingEvents()
{
    $allEvents = [];
    $events = getUpcomingEvents(-1);

    if($events)
    {
        foreach($events as $event)
        {
            $start_date = date('Y-m', strtotime($event->event_date));
            $allEvents[$start_date][] = $event;
        }
    }

    return !empty($allEvents) ? $allEvents : false;
}

function getDocumentLibraryCategories()
{
    $terms = get_terms( array(
        'taxonomy' => 'doc_categories',
        'hide_empty' => false,
        'parent'   => 0
    ) );

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) )
    {
        return $terms;
    }
    else
    {
        return false;
    }
}

function getTermChildren($term_id)
{
    $term_children = get_terms( array( 
        'taxonomy' => 'doc_categories',
        'hide_empty' => true,
        'parent'   => $term_id
    ) );

    if ( ! is_wp_error( $term_children ) && !empty($term_children))
    {
        return $term_children;
    }
    return false;
}

function pagination_bar( $custom_query, $return = false )
{
    $total_pages = $custom_query->max_num_pages;
    $big = 999999999; // need an unlikely integer

    if ($total_pages > 1){
        $current_page = max(1, get_query_var('paged'));

        $output = paginate_links(array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => $current_page,
            'total' => $total_pages,
        ));

        if($return === true)
        {
            return $output;
        }
        else
        {
            echo $output;
        }
    }
}

function the_document_tags($post_tags)
{
    $tags = [];
    if ( $post_tags )
    {
        foreach( $post_tags as $tag )
        {
            $tags[] = $tag->name; 
        }
    }
    echo implode(', ', $tags);
}

function get_unique_data()
{
    $output = [];
    $cities = [];
    $sroles = [];

    // WP_User_Query arguments
    $args = array (
        'number' => -1,
        'role' => 'subscriber'
    );

    // Create the WP_User_Query object
    $wp_user_query = new WP_User_Query($args);

    $staffs = $wp_user_query->get_results();

    if(!empty($staffs))
    {
        foreach($staffs as $staff)
        {
            $staff_role = esc_attr( get_the_author_meta( 'staff_role', $staff->ID ) );

            $staff_city = esc_attr( get_the_author_meta( 'city', $staff->ID ) );
            $staff_state = esc_attr( get_the_author_meta( 'state', $staff->ID ) );

            $cities[] = (!empty(trim($staff_city)) ? trim($staff_city) . ', ' : '') . $staff_state;

            if(!empty($staff_role))
            {
                $sroles[] = trim($staff_role);
            }
        }
    }

    $cities = array_unique($cities);
    $sroles = array_unique($sroles);

    $cities = array_map('strtolower', $cities);
    //$sroles = array_map('strtolower', $sroles);

    $cities = array_map('ucwords', $cities);
    $sroles = array_map('ucwords', $sroles);

    sort($cities);
    sort($sroles);

    return compact('cities', 'sroles');
}

function get_agencies_unique_locations () 
{
    $location = array();
    $args = array (
        'posts_per_page' => -1,
        'post_type' => 'agencies',
        'post_status' => 'publish',
        'order' => 'DESC'
    );

    $wpQuery = new WP_Query($args);

    if($wpQuery->have_posts())
    {
        while($wpQuery->have_posts())
        {
            $wpQuery->the_post();
            $agencyLocation = get_field('agency_location');
            if (!in_array($agencyLocation, $location)) {
                $location[] = $agencyLocation;
            }
        }
    }
    wp_reset_postdata();    
    sort($location);

    return $location;

}

function split_name($name) {
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
    return array($first_name, $last_name);
}

function search_staff_directory()
{
    $number = 30;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // WP_User_Query arguments
    $args = array (
        'number' => $number,
        'paged' => $paged,
        'role__in' => array( 'contractor', 'subscriber', 'clinical-director' ),
        //'meta_key' => 'nickname',
        //'orderby' => 'meta_value',
        'orderby' => 'display_name',
        'order' => 'ASC',
    );

    if(!empty($_GET))
    {
        $_GET = array_map('trim', $_GET);

        extract($_GET);
    }

    if(!empty($_GET) && $search_staff*1 == 1)
    {
        /*if(!empty($member_position))
        {
            $args['role'] = $member_position;
        }*/

        if(!empty($member_name) || !empty($member_location) || !empty($member_position))
        {
            $args['meta_query']['relation'] = 'AND';
        }

        if(!empty($member_name))
        {
            
            $member_name_split = split_name($member_name);
            $args['meta_query'][] = array(
                'relation' => 'OR',
                array(
                    'key'     => 'first_name',
                    'value'   => $member_name_split[0],
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'last_name',
                    'value'   => (empty($member_name_split[1])?$member_name_split[0]:$member_name_split[1]),
                    'compare' => 'LIKE'
                )
            );
        }

        if(!empty($member_location))
        {
            $city = '';

            if(strstr($member_location, ','))
            {
                list($city, $state) = array_map('trim', explode(',', $member_location));

                $args['meta_query'][] = array(
                    'relation' => 'AND',
                    array(
                        'key'     => 'city',
                        'value'   => $city,
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'state',
                        'value'   => $state,
                        'compare' => 'LIKE'
                    )
                );
            }
            else
            {
                $state = trim($member_location);

                $args['meta_query'][] = array(
                    'relation' => 'AND',
                    array(
                        'key'     => 'state',
                        'value'   => $state,
                        'compare' => 'LIKE'
                    )
                );
            }

            
        }

        if(!empty($member_position))
        {
            $args['meta_query'][] = array(
                'relation' => 'AND',
                array(
                    'key'     => 'staff_role',
                    'value'   => $member_position,
                    'compare' => 'LIKE'
                )
            );
        }
    }
     
    /*echo "arg: <pre>";
    print_r($args);
    echo "</pre>"; */
    // Create the WP_User_Query object
    $wp_user_query = new WP_User_Query($args);
    //echo "<Br>".$wp_user_query;
    //exit; 
    return $wp_user_query;
}

function loop_staff_directory($wp_user_query)
{
    $staffs = $wp_user_query->get_results();

    if(!empty($staffs))
    {
        foreach($staffs as $staff)
        {
            $staff_role = esc_attr( get_the_author_meta( 'staff_role', $staff->ID ) );
            $staff_city = esc_attr( get_the_author_meta( 'city', $staff->ID ) );
            $staff_state = esc_attr( get_the_author_meta( 'state', $staff->ID ) );
            $staff_cell = esc_attr( get_the_author_meta( 'cell', $staff->ID ) );
            $staff_aboutus_text = esc_attr( get_the_author_meta( 'aboutus_text', $staff->ID ) );
            if(!empty($staff_city))
            {
                $staff_city = $staff_city . ',';
            }

            if(empty($staff_cell))
            {
                $staff_cell = 'N/A';
            }

            if(empty($staff_role))
            {
                $staff_role = 'N/A';
            }

            if(empty($staff_aboutus_text))
            {
                $staff_aboutus_text = 'N/A';
            }

            bladerunner('views.partials.members_list', compact('staff', 'staff_role', 'staff_city', 'staff_state', 'staff_cell', 'staff_aboutus_text'));
        }

        $total_user = $wp_user_query->total_users;  
        $total_pages = ceil( $total_user / ($wp_user_query->query_vars['number']*1) );

        $pagination = '';

        $big = 999999999; // need an unlikely integer

        if ($total_pages > 1)
        {
            $current_page = max(1, get_query_var('paged'));

            $base_url = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );

            $pagination = paginate_links(array(
                'base' => $base_url,
                'format' => (strstr($base_url, '?') ? '&' : '?') . 'paged=%#%',
                'current' => $current_page,
                'total' => $total_pages,
            ));
        }

        return ['pagination' => $pagination];
    }
}

function search_agency_directory()
{
    $number = 30;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // WP_Query arguments
    $args = array (
        'posts_per_page' => $number,
        'paged' => $paged,
        'post_type' => 'agencies',
        'post_status' => 'publish',
        'order' => 'DESC',
    );

    if(!empty($_GET))
    {
        $_GET = array_map('trim', $_GET);

        extract($_GET);
    }

    if (isset($_GET['search_state']) && !empty($_GET['search_state'])) {
        $state = trim($_GET['search_state']);

        $args['meta_query'] = array(
            array(
                'key'     => 'agency_location',
                'value'   => $state,
                'compare' => '='
            )
        );
    }

    if(!empty($_GET) && $search_agency*1 == 1)
    {
        if(!empty($agency_name))
        {
            $args['s'] = $agency_name;
        }
    }
     
    // Create the WP_User_Query object
    $wpQuery = new WP_Query($args);

    //dump($wpQuery->request);
     
    return $wpQuery;
}

function loop_agency_directory($wpQuery)
{
    if($wpQuery->have_posts())
    {
        while($wpQuery->have_posts())
        {
            $wpQuery->the_post();

            bladerunner('views.partials.agencies_list');
        }
        
        $pagination = pagination_bar($wpQuery, true);

        echo '<div class="members_pagination">'.$pagination.'</div>';

        //return ['pagination' => $pagination];
    }
    /* Restore original Post Data */
    wp_reset_postdata();
}

function read_notification_bar_function()
{
    global $wpdb;
    $output = ['success' => false];
    
    if(is_user_logged_in())
    {
        $user_id = wp_get_current_user()->ID;

        if(intval($user_id) > 0)
        {
            $wpdb->insert($wpdb->prefix . 'users_notification_bar_log', [
                'user_id' => $user_id,
                'read' => 1
            ]);

            $output['success'] = true;
        }
    }

    wp_die(json_encode($output));
}

function show_notification_bar()
{
    global $wpdb;
    if(is_user_logged_in())
    {
        $user_id = wp_get_current_user()->ID;

        if(intval($user_id) > 0)
        {
            $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}users_notification_bar_log WHERE user_id = %d", $user_id ) );

            return $count == 0;
        }
    }

    return true;
}

function notification_bar_update_value( $value, $post_id, $field )
{
    global $wpdb;
    $old_value = trim(get_post_meta( $post_id, 'notification_bar', true ));

    if(strtolower(trim($value)) != strtolower($old_value))
    {
        $wpdb->query("DELETE FROM {$wpdb->prefix}users_notification_bar_log WHERE 1");
    }

    return trim($value);
}

function force_download($path)
{
    $filepath = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $path;

    // Process download
    if(file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        die();
    } else {
        http_response_code(404);
        die();
    }
}

/**
 * Utility to check if password reset is allowed based on user id.
 *
 * @param INT $user_id
 * @return BOOL true / false
 */
function check_if_reset_is_allowed($user_id) {
    $allow = apply_filters( 'allow_password_reset', true, $user_id );

    if ( !$allow ) {
        return false;
    } elseif ( is_wp_error( $allow ) ) {
        return false;
    }

    return true;
}

function check_forgot_password()
{
    global $wpdb, $wp_hasher;

    $result = null;
    if(!empty($_POST))
    {
        $result = [];
        $value = esc_sql($_POST['user_login']);

        // let's assume it's all valid
        $result['is_valid'] = true;

        // lets check if the user with such a username is already in the database
        // this means that the user has specified email
        if ( strpos( $value, '@' ) ) {
            $user_data = get_user_by( 'email', trim( $value ) );

            if ( empty( $user_data ) ) {
                $result['is_valid'] = false;
                $result['message'] = 'Username or email not found.';
            }

            $allow = check_if_reset_is_allowed( $user_data->ID );
        } else {
            // let's verify the username existence
            $user_id = username_exists( $value );

            if ( !$user_id ) {
                // let's mark this field is invalid
                $result['is_valid'] = false;
                $result['message'] = 'Username or email not found.';
            }

            $allow = check_if_reset_is_allowed( $user_id );
        }

        // if the password change is not allowed return false
        if ( !$allow ) {
            // let's mark this field is invalid
            $result['is_valid'] = false;
            $result['message'] = 'Password change is not allowed.';
        }

        if($result['is_valid'] === true)
        {
            // get the submitted value
            $email_or_username = $value;

            // let's check if the user has provided email or username
            if ( strpos( $email_or_username, '@' ) ) {
                $email = sanitize_email( $email_or_username );
                $user_data = get_user_by( 'email', $email );
            } else {
                $username = esc_attr( $email_or_username );
                $user_data = get_user_by( 'login', $username );
            }

            // Redefining user_login ensures we return the right case in the email.
            $user_login = $user_data->user_login;
            $user_email = $user_data->user_email;

            $key = wp_generate_password( 20, false );

            // Now insert the key, hashed, into the DB.
            if ( empty( $wp_hasher ) ) {
                require_once ABSPATH . WPINC . '/class-phpass.php';
                $wp_hasher = new PasswordHash( 8, true );
            }

            // obtain new hashed password
            $hashed = time() . ':' . $wp_hasher->HashPassword( $key );

            // update user with new activation key
            $wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

            // construct the email message for the user
            $message = __( 'Someone requested that the password be reset for the following account:' ) . "\r\n\r\n";
            $message .= network_home_url( '/' ) . "\r\n\r\n";
            $message .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";
            $message .= __( 'If this was a mistake, just ignore this email and nothing will happen.' ) . "\r\n\r\n";
            $message .= __( 'To reset your password, visit the following address:' ) . "\r\n\r\n";
            $message .= '<' . network_site_url( "/recover-password/?action=rp&method=gf&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n";

            if ( is_multisite() ) {
                $blogname = $GLOBALS['current_site']->site_name;
            } else {
                /*
                 * The blogname option is escaped with esc_html on the way into the database
                 * in sanitize_option we want to reverse this for the plain text arena of emails.
                 */
                $blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
            }

            $title = sprintf( __( '[%s] Password Reset' ), $blogname );

            /**
             * Filter the subject of the password reset email.
             *
             * @since 2.8.0
             *
             * @param string $title Default email title.
             */
            $title = apply_filters( 'retrieve_password_title', $title );

            /**
             * Filter the message body of the password reset mail.
             *
             * @since 2.8.0
             * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
             *
             * @param string  $message    Default mail message.
             * @param string  $key        The activation key.
             * @param string  $user_login The username for the user.
             * @param WP_User $user_data  WP_User object.
             */
            $message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

            if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
                wp_die(__('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.'));
//echo network_site_url( "/recover-password/?action=rp&method=gf&key=$key&login=" . rawurlencode( $user_login ), 'login' );

            wp_redirect('?pass=sent');
            exit;

            return true;
        }
    }
    return $result;
}

function recover_password()
{
    // we'll need the data created before to update the correct user
    global $gf_reset_user;

    $result = null;
    if(!empty($_POST))
    {
        $result = [];

        // let's assume it's all valid
        $result['is_valid'] = true;

        $pass = esc_sql($_POST['user_password']);
        $pass_confirm = esc_sql($_POST['user_password_confirm']);

        if(empty($pass))
        {
            $result['is_valid'] = false;
            $result['message'] = 'This field is required.';
        }
        else
        {
            if($pass != $pass_confirm)
            {
                $result['is_valid'] = false;
                $result['message2'] = 'Password mismatch.';
            }
        }

        if($result['is_valid'] === true)
        {
            list( $rp_path ) = explode( '?', wp_unslash( $_SERVER['REQUEST_URI'] ) );
            $rp_cookie = 'wp-resetpass-' . COOKIEHASH;

            // if we're doing a cron job let's forget about it
            if ( defined( 'DOING_CRON' ) || isset( $_GET['doing_wp_cron'] ) )
                return;

            // lets compare the validation cookie with the hash key stored with the database data
            // if they match user data will be returned
            if ( isset( $_COOKIE[$rp_cookie] ) && 0 < strpos( $_COOKIE[$rp_cookie], ':' ) ) {
                list( $rp_login, $rp_key ) = explode( ':', wp_unslash( $_COOKIE[$rp_cookie] ), 2 );
                $user = check_password_reset_key( $rp_key, $rp_login );
                if ( isset( $_POST['pass1'] ) && !hash_equals( $rp_key, $_POST['rp_key'] ) ) {
                    $user = false;
                }
            } else {
                $user = false;
            }

            // if any error occured make sure to remove the validation cookie
            if ( !$user || is_wp_error( $user ) ) {
                setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
            }

            // make sure our user is available for later reference
            $gf_reset_user = $user;

            // let's check if a user with given name exists
            // we're already doing that in the form validation, but this gives us another bridge of safety
            $user_id = username_exists( $gf_reset_user->data->user_login );

            // let's validate the email and the user
            if ($user_id) {
                // let's add another safety check to make sure that the passwords remain unchanged
                if ( !empty( $pass ) and ! empty( $pass_confirm ) and $pass === $pass_confirm ) {
                    reset_password( $gf_reset_user, $pass );
                    setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
                    wp_logout();
                    wp_redirect('/log-in/?pass=updated');
                }
            } else {
                $result['is_valid'] = false;
                $result['message'] = 'User does not exist.';
                return $result;
            }
        }
    }
    return $result;
}

function states()
{
    return array(
        "Alabama" => "Alabama",
        "Alaska" => "Alaska",
        "Arizona" => "Arizona",
        "Arkansas" => "Arkansas",
        "California" => "California",
        "Colorado" => "Colorado",
        "Connecticut" => "Connecticut",
        "Delaware" => "Delaware",
        "District of Columbia" => "District of Columbia",
        "Florida" => "Florida",
        "Georgia" => "Georgia",
        "Hawaii" => "Hawaii",
        "Idaho" => "Idaho",
        "Illinois" => "Illinois",
        "Indiana" => "Indiana",
        "Iowa" => "Iowa",
        "Kansas" => "Kansas",
        "Kentucky" => "Kentucky",
        "Louisiana" => "Louisiana",
        "Maine" => "Maine",
        "Maryland" => "Maryland",
        "Massachusetts" => "Massachusetts",
        "Michigan" => "Michigan",
        "Minnesota" => "Minnesota",
        "Mississippi" => "Mississippi",
        "Missouri" => "Missouri",
        "Montana" => "Montana",
        "Nebraska" => "Nebraska",
        "Nevada" => "Nevada",
        "New Hampshire" => "New Hampshire",
        "New Jersey" => "New Jersey",
        "New Mexico" => "New Mexico",
        "New York" => "New York",
        "North Carolina" => "North Carolina",
        "North Dakota" => "North Dakota",
        "Ohio" => "Ohio",
        "Oklahoma" => "Oklahoma",
        "Oregon" => "Oregon",
        "Pennsylvania" => "Pennsylvania",
        "Rhode Island" => "Rhode Island",
        "South Carolina" => "South Carolina",
        "South Dakota" => "South Dakota",
        "Tennessee" => "Tennessee",
        "Texas" => "Texas",
        "Utah" => "Utah",
        "Vermont" => "Vermont",
        "Virginia" => "Virginia",
        "Washington" => "Washington",
        "West Virginia" => "West Virginia",
        "Wisconsin" => "Wisconsin",
        "Wyoming" => "Wyoming"
    );
}

function custom_user_profile_fields($user){
    $states = states();

    $userState = esc_attr( get_the_author_meta( 'state', $user->ID ) );

  ?>
    <h3>Additional Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="staff_role">Staff Role</label></th>
            <td>
                <input type="text" class="regular-text" name="staff_role" value="<?php echo esc_attr( get_the_author_meta( 'staff_role', $user->ID ) ); ?>" id="staff_role" required /><br />
                
            </td>
        </tr>
        <tr>
            <th><label for="state">State</label></th>
            <td>
                <select class="regular-text" name="state" id="state">
                    <?php foreach ($states as $key => $value) { ?>
                        <option value="<?php echo $key; ?>" <?php if($userState==$key){ echo "selected='selected'"; } ?>><?php echo $value; ?></option>
                    <?php } ?>

                </select>
                <br />
                
            </td>
        </tr>
        <tr>
            <th><label for="cell">Cell</label></th>
            <td>
                <input type="text" placeholder="123-45-6789" pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" class="regular-text" name="cell" maxlength="14" value="<?php echo esc_attr( get_the_author_meta( 'cell', $user->ID ) ); ?>" id="cell" /><br />
                
            </td>
        </tr>

        <tr>
            <th><label for="city">About</label></th>
            <td>
                <textarea rows="10" name="aboutus_text" id="aboutus_text" class="regular-text"><?php echo esc_attr( get_the_author_meta( 'aboutus_text', $user->ID ) ); ?></textarea>
                <br />
                
            </td>
        </tr>
        
    </table>
  <?php
}

/*Recover Password*/
add_action( 'init', 'wp_doin_verify_user_key', 999 );

function wp_doin_verify_user_key()
{
    global $gf_reset_user;

    // analyze wp-login.php for a better understanding of these values
    list( $rp_path ) = explode( '?', wp_unslash( $_SERVER['REQUEST_URI'] ) );
    $rp_cookie = 'wp-resetpass-' . COOKIEHASH;

    // lets redirect the user on pass change, so that nobody could spoof his key
    if ( isset( $_GET['key'] ) and isset( $_GET['method'] ) ) {
        if ( $_GET['method'] == 'gf' ) {
            $value = sprintf( '%s:%s', wp_unslash( $_GET['login'] ), wp_unslash( $_GET['key'] ) );
            setcookie( $rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
            wp_safe_redirect( remove_query_arg( array( 'key', 'login', 'method' ) ) );
            exit;
        }
    }

    // lets compare the validation cookie with the hash key stored with the database data
    // if they match user data will be returned
    if ( isset( $_COOKIE[$rp_cookie] ) && 0 < strpos( $_COOKIE[$rp_cookie], ':' ) ) {
        list( $rp_login, $rp_key ) = explode( ':', wp_unslash( $_COOKIE[$rp_cookie] ), 2 );
        $user = check_password_reset_key( $rp_key, $rp_login );
        if ( isset( $_POST['pass1'] ) && !hash_equals( $rp_key, $_POST['rp_key'] ) ) {
            $user = false;
        }
    } else {
        $user = false;
    }

    // if any error occured make sure to remove the validation cookie
    if ( !$user || is_wp_error( $user ) ) {
        setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
    }

    // make sure our user is available for later reference
    $gf_reset_user = $user;
}

add_action( 'template_redirect', 'members_page' );

function members_page()
{
    if ( is_page('members') )
    {
        if(!is_user_logged_in())
        {
            wp_redirect(get_home_url() . '/log-in/');
            exit;
        }
    }
}

add_action( 'show_user_profile', 'custom_user_profile_fields' );
add_action( 'edit_user_profile', 'custom_user_profile_fields' );
add_action( "user_new_form", "custom_user_profile_fields" );

function save_custom_user_profile_fields($user_id){
    # again do this only if you can
    if(!current_user_can('manage_options'))
        return false;

    # save my custom field
    update_usermeta($user_id, 'staff_role', trim($_POST['staff_role']));
    update_usermeta($user_id, 'city', trim($_POST['city']));
    update_usermeta($user_id, 'state', trim($_POST['state']));
    update_usermeta($user_id, 'cell', trim($_POST['cell']));
    update_usermeta($user_id, 'aboutus_text', trim($_POST['aboutus_text']));
}
add_action('user_register', 'save_custom_user_profile_fields');
add_action('profile_update', 'save_custom_user_profile_fields');

add_action( 'wp_ajax_read_notification_bar', 'read_notification_bar_function' );
add_action( 'wp_ajax_nopriv_read_notification_bar', 'read_notification_bar_function' );

add_filter('acf/update_value/name=notification_bar', 'notification_bar_update_value', 10, 3);

function change_role_name() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    $wp_roles->roles['subscriber']['name'] = 'Staff';
    $wp_roles->role_names['subscriber'] = 'Staff';           
}
add_action('init', 'change_role_name');

function dump($output)
{
    echo '<pre>';
    (is_null($output)||is_bool($output)?var_dump($output):print_r($output));
    echo '</pre>';
}


add_filter('wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 10, 3);

function custom_wp_new_user_notification_email($wp_new_user_notification_email, $user, $blogname) {
    
    $message = str_replace("wp-login.php","recover-password/",$wp_new_user_notification_email['message']);

    $message = str_replace("?action=rp&","?action=rp&method=gf&",$message);
    $wp_new_user_notification_email['message'] = $message;
    return $wp_new_user_notification_email;
}

function getHomePageWistiaVideo(){

    $args = array (
                'post_type' => 'videos',
                'post_status' => 'publish',
                'order' => 'DESC',
                'posts_per_page' => 1
            );
    $wpQuery = new WP_Query($args);
    if($wpQuery->have_posts())
    {
        while($wpQuery->have_posts())
        {
            $wpQuery->the_post();
            bladerunner('views.partials.home_video_block');
        }
        
    }else{
        return '<div class="video-block">No Video Available.</div>';
    }
    wp_reset_postdata();
    
}


function employeeHighlightBlock(){

    $args = array (
        'post_type' => 'employees',
        'post_status' => 'publish',
        'order' => 'DESC',
    );

    $wpQuery = new WP_Query($args);

    if($wpQuery->have_posts())
    {
        while($wpQuery->have_posts())
        {
            $wpQuery->the_post();
            $employeeImage = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
            bladerunner('views.partials.employee_highlight',compact('employeeImage'));
        }
    }
    wp_reset_postdata();
}

add_filter( 'tribe_events_single_event_time_formatted', 'tec_custom_single_event_time_add_timezone', 999, 2 );

function tec_custom_single_event_time_add_timezone( $time_formatted, $event_id ) {
    $event_timezone     = get_post_meta( $event_id, '_EventTimezone', true );
    $timezone_formatted = ' ';
    if ( $event_timezone !== '' ) {
        $timezone_formatted .= Tribe__Timezones::abbr( $time_formatted, $event_timezone );
    } else {
        $timezone_formatted .= tribe_get_start_date( $event_id, false, 'T' );
    }
    // Make sure we've got more than the hyphen as a sanity check
    if ( ' - ' !== $timezone_formatted ) {
        $pos = stripos( $time_formatted, '</div>' );
        if (false === $pos) {
            $pos = strlen($time_formatted);
        }           
        $time_formatted = substr_replace($time_formatted, $timezone_formatted, $pos, 0);
    }
    return $time_formatted;
}

