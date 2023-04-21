@php
if(!is_user_logged_in())
{
	wp_redirect(get_home_url() . '/log-in/');
	exit;
}

$document_id = $_GET['id']*1;
$document = dlp_get_document( $document_id );

if($document)
{
	$document_file = $document->get_download_url();
	if($document_file && !empty($document_file))
	{
		$parsed_url = parse_url($document_file);
		
		if($parsed_url['host'] == $_SERVER['HTTP_HOST'])
		{
			force_download($parsed_url['path']);
		}
		else
		{
			wp_redirect($document_file);
			exit;
		}
	}
	else
	{
		http_response_code(404);
        die();
	}
}
else
{
	wp_redirect(get_home_url() . '/log-in/');
	exit;
}
