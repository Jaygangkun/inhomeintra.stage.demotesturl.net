@php 
global $wp;

$current_page_url = rtrim(home_url( $wp->request ), '/') . '/';
@endphp
@extends('views.layouts.main')

@section('content')
<main class="main">
	@while (have_posts()) @php the_post() @endphp
	@include('views.partials.document_library_visual')
	<div class="container">
		@php 
		    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		    $args = array(
		        'post_status' => 'publish',
		        'post_type' => 'dlp_document',
		        'posts_per_page' => -1,
		        'paged'          => $paged,
		        's'				 => $_GET['search_text'],
                'order'          => 'ASC',
                'orderby' => 'title'
		    );

		    if(!empty($_GET['doc_cat']))
		    {
		    	$args['tax_query'] = array(
			        array (
			            'taxonomy' => 'doc_categories',
			            'field' => 'slug',
			            'terms' => $_GET['doc_cat'],
			        )
			    );
                
                if ($_GET['doc_cat'] == "compliance-and-quality-resources") {
                    $args['meta_key'] = 'custom_order';
                    $args['meta_type'] = 'NUMERIC';
                    $args['orderby'] = [
                        'meta_value_num' => 'ASC'
                    ];
                }
		    }

		    if(!empty($_GET['doc_sub_cat']))
		    {
		    	$args['tax_query'] = array(
			        array (
			            'taxonomy' => 'doc_categories',
			            'field' => 'slug',
			            'terms' => $_GET['doc_sub_cat'],
			        )
			    );
		    }

		    $query = new WP_Query($args);
		@endphp
		<div class="doc-table-wrapper">
			@if ( $query->have_posts() )
			<table class="doc-table-list">
				<thead>
					<tr>
						<th class="col-excerpt">Name</th>
						<th class="col-doc_categories">Categories</th>
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
				        	<td class="col-row-doc_categories">{{$document->get_category_list()}}</td>
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
		@php 
		wp_reset_postdata();
		@endphp
		{{-- {!! do_shortcode('[doc_library content="title,excerpt,doc_tags,file_size,file_type,link" doc_category="'.$term->slug.'"]') !!} --}}
	</div>
	@endwhile
</main>
@endsection
@push('custom-scripts')
    <script type="text/javascript">
    var ajaxurl = '{{$current_page_url}}';
    var data = {};
    (function($)
    {
        
		$(document).ready(function(){
			$('#doc_cat').change(function(){    
				$('#doc-categories-form').submit(); 
			});
			$('#doc_sub_cat').change(function(){
				$('#doc-categories-form').submit();
			});
      	});   


        $(document).ready(function()
        {
        	$('body').on('click', '.doc-sub-cat li a', function(e)
        	{
        		var slug = $(this).data('slug');
        		$('#doc_cat').val(slug).trigger('change');

        		e.preventDefault();
                e.stopPropagation();
        	});
        	$(".reset_link").click(function(e)
        	{
        		$('ul.doc-sub-cat').remove();
        		$('input[name="search_text"]').val('').attr('value', '');
        		$('#doc_cat').val('').trigger('change');

        		e.preventDefault();
                e.stopPropagation();
        	});

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
            $('.loaderBlock').show();
            $.ajax({
                method : 'GET',
                url : ajaxurl,
                dataType : 'text',
                data : data,
                success : function(output)
                {
                    var subCatHTML = "";
                    var str = output;
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(str, "text/html");
                    var bodyHTML = doc.getElementsByTagName('body')[0].innerHTML;
                    
                    var bodyHTML = '<div id="body-mock">' + bodyHTML + '</div>';
                    var $body = $(bodyHTML);

                    /*if($body.find('.doc-sub-cat').length > 0)
                    {
                    	if($('.doc-sub-cat').length > 0)
                    	{
                    		$('.doc-sub-cat').html($body.find('.doc-sub-cat').html());
                    	}
                    	else
                    	{
	                    	subCatHTML = $body.find('.doc-sub-cat').get(0).outerHTML;

	                    	$(subCatHTML).appendTo(".staff-section .container");
	                    }
                    }
                    else
                    {
                    	$('.doc-sub-cat').remove();
                    }*/
                    if($body.find('#doc_sub_cat option').length > 1)
                    {
                        $('#doc_sub_cat').empty();
                        var $options = $body.find('#doc_sub_cat > option').clone();
                        $('#doc_sub_cat').append($options);
                    } else {
                        $('#doc_sub_cat').empty().append('<option value="">Please select</option>');
                        $('#doc_sub_cat').closest('.search-field.custom-search').find('.jcf-select-text span').text('Please select');
                    }

                    $('.doc-table-wrapper').html($body.find('.doc-table-wrapper').html());
                    $('.text-holder h1').html($body.find('.text-holder h1').html());
                    $('.loaderBlock').hide();
                }
            });
        }
    }(jQuery));
    </script>
@endpush