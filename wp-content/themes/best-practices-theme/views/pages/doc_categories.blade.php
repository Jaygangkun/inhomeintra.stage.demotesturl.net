@php 
global $wp;

$current_page_url = rtrim(home_url( $wp->request ), '/') . '/';

if(!is_user_logged_in())
{
	wp_redirect(get_home_url() . '/log-in/');
	exit;
}

$term = get_queried_object();
@endphp
@extends('views.layouts.main')

@section('content')
<main class="main doc_categories">
	@include('views.partials.doc_categories_visual', compact('term', 'current_page_url'))
	<div class="container">
		@php 
		    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		    $args = array(  
		        'post_status' => 'publish',
		        'post_type' => 'dlp_document',
		        'posts_per_page' => -1,
		        'paged'          => $paged,
		        'order'          => 'DESC',
		        's'				=> $_GET['search_text'],
			    'tax_query' => array(
			        array (
			            'taxonomy' => 'doc_categories',
			            'field' => 'slug',
			            'terms' => $term->slug,
			        )
			    )
		    );
		    $query = new WP_Query($args);
		@endphp
		<div class="doc-table-wrapper">
			@if ( $query->have_posts() )
			<table class="doc-table-list">
				<thead>
					<tr>
						<th class="col-excerpt">Name</th>
						<th class="col-doc_tags">Tags</th>
						<th class="col-file_size">File Size</th>
						<th class="col-file_type">File Type</th>
						<th class="col-link">Link</th>
					</tr>
				</thead>
				<tbody>
				    @while ( $query->have_posts() )
				        @php 
				            $query->the_post();
				            $document = dlp_get_document( get_the_ID() );
				            $document_file = '';
				            if($document)
							{
								$document_file = $document->get_download_url();
								if($document_file && !empty($document_file))
								{
									$document_file = '<a href="'.get_home_url().'/document-file/?id='.get_the_ID().'"><i class="icon-down-to-line"></i> Download</a>';
								}
							}
				        @endphp
				        <tr>
				        	<td class="col-row-excerpt">
				        		<strong class="title">{{the_title()}}</strong>
				        		{{the_excerpt()}}
				        	</td>
				        	<td class="col-row-doc_tags">{{$document->get_tag_list()}}</td>
				        	<td class="col-row-file_size">{{$document->get_file_size()}}</td>
				        	<td class="col-row-file_type">{{$document->get_file_type()}}</td>
				        	<td class="col-row-link">{!! $document_file !!}</td>
				        </tr>
				    @endwhile
				</tbody>
				{{-- <tfoot>
					<tr>
						<td colspan="10">{{pagination_bar( $query )}}</td>
					</tr>
				</tfoot> --}}
			</table>
			@else
			@include('views.partials.doc_categories_no_document')
			@endif
		</div>
		{{-- {!! do_shortcode('[doc_library content="title,excerpt,doc_tags,file_size,file_type,link" doc_category="'.$term->slug.'"]') !!} --}}
	</div>
</main>
@endsection
@section('no-content')
<main class="main doc_categories">
	@include('views.partials.doc_categories_visual', compact('term', 'current_page_url'))
	<div class="container" >
		<div class="doc-table-wrapper">
			@include('views.partials.doc_categories_no_document')
		</div>
	</div>
</main>
@endsection
@push('custom-scripts')
    <script type="text/javascript">
    var ajaxurl = '{{$current_page_url}}';
    var data = {};
    (function($)
    {
        $(document).ready(function()
        {
            $("#doc-categories-form").submit(function(e)
            {
                e.preventDefault();
                e.stopPropagation();

                data = $(this).serialize();

                sendAjax(ajaxurl, data);
            });
        });

        function sendAjax(ajaxurl, data)
        {
            $.ajax({
                method : 'GET',
                url : ajaxurl,
                dataType : 'text',
                data : data,
                success : function(output)
                {
                    var str = output;
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(str, "text/html");
                    var bodyHTML = doc.getElementsByTagName('body')[0].innerHTML;
                    
                    var bodyHTML = '<div id="body-mock">' + bodyHTML + '</div>';
                    var $body = $(bodyHTML);

                    $('.doc-table-wrapper').html($body.find('.doc-table-wrapper').html());
                }
            });
        }
    }(jQuery));
    </script>
@endpush