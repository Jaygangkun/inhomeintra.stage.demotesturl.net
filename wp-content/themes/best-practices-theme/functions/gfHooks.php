<?php 
//Gallery Picture Upload
add_action( 'gform_after_submission', 'set_post_content', 10, 2 );
function set_post_content( $entry, $form ) {
    

    /*
    Array
    (
        [id] => 42
        [status] => active
        [form_id] => 3
        [ip] => 206.84.142.99
        [source_url] => https://inhomeintra.stage.demotesturl.net/gallery/
        [currency] => USD
        [post_id] => 
        [date_created] => 2022-03-15 12:35:16
        [date_updated] => 2022-03-15 12:35:16
        [is_starred] => 0
        [is_read] => 0
        [user_agent] => Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36
        [payment_status] => 
        [payment_date] => 
        [payment_amount] => 
        [payment_method] => 
        [transaction_id] => 
        [is_fulfilled] => 
        [created_by] => 1
        [transaction_type] => 
        [6] => ["http:\/\/inhomeintra.stage.demotesturl.net\/wp-content\/uploads\/gravity_forms\/3-acace45223de041621619e59d19951ae\/2022\/03\/download1.png"]
        [3] => websupportpro
        [4] => websupportpro@websupportpro.net
    )
    */
    
    if($entry['form_id'] == "3"){
        $uploaded_images = json_decode($entry[6]);

        if(is_array($uploaded_images) && count($uploaded_images) > 0){
            
            $gallery_images_data = get_metadata( 'post', '197', '_rl_images');
            $gallery_images_count = get_metadata( 'post', '197', '_rl_images_count');
            $gallery_images_count = $gallery_images_count[0] + count($uploaded_images);

            
            foreach($uploaded_images as $key => $image_data){
                //http://inhomeintra.stage.demotesturl.net/wp-content/uploads/gravity_forms/3-acace45223de041621619e59d19951ae/2022/03/download18.png
                // $filename should be the path to a file in the upload directory.
                $image_data_arr = explode("/wp-content",$image_data);
                $image_data = ABSPATH."wp-content".$image_data_arr[1];
                $filename = $image_data;
                 
                // The ID of the post this attachment is for.
                $parent_post_id = 197;
                
                // Check the type of file. We'll use this as the 'post_mime_type'.
                $filetype = wp_check_filetype( basename( $filename ), null );
                 
                // Get the path to the upload directory.
                $wp_upload_dir = wp_upload_dir();
                 
                // Prepare an array of post data for the attachment.
                $attachment = array(
                    'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );
                 
                // Insert the attachment.
                $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );
                $gallery_images_data[0]['media']['attachments'][ids][] = $attach_id;
                // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                 
                // Generate the metadata for the attachment, and update the database record.
                $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
                wp_update_attachment_metadata( $attach_id, $attach_data );
                        
            }

            /*Array
            (
                [0] => Array
                    (
                        [media] => Array
                            (
                                [attachments] => Array
                                    (
                                        [ids] => Array
                                            (
                                                [0] => 274
                                                [1] => 273
                                                [2] => 436
                                                [3] => 433
                                            )

                                        [exclude] => Array
                                            (
                                            )

                                    )

                            )

                        [menu_item] => media
                    )

            )*/
            
            update_post_meta( '197', '_rl_images', $gallery_images_data[0]);
            update_post_meta( '197', '_rl_images_count', $gallery_images_count);
            
        }
    }
}