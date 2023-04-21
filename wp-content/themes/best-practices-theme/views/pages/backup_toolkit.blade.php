@extends('views.layouts.main')
@section('content')
<main class="main">
	@while (have_posts()) @php the_post() @endphp
<div class="staff-visual">
    <div class="container">
        <div class="dots-strip"></div>
        <div class="row justify-content-between">
            <div class="col-lg-6 col-xl-7">
                <div class="text-holder">
                    <h1>{{the_title()}}</h1>
                    <p>Download Training Modules below</p>
                </div>
            </div>
            <div class="col-lg-6 col-xl-5">
                <div class="image">
                    <img src="{{public_path('images/files_image1.png')}}" alt="image-description">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="staff-section">
    <div class="container">
        <div class="loaderBlock">
            <img src="{{public_path('images/loader.gif')}}">
        </div>
        <div class="search_block">
            <form>
                <ul class="list-unstyled form-list">
                    <li style="width: 100%">
                        <div class="search-field custom-search">
                            <label>Category</label>
                            <select id="doc_toolkit" name="doc_toolkit" class="doctoolkit">
                                <option value="">Please select</option>
                                <option value="ot-toolkit">OT Toolkit</option>
                                <option value="pt-toolkit">PT Toolkit</option>
								<option value="alora-training">Alora Training</option>
								<option value="axxess-training">Axxess Training</option>
								<option value="devero-training">Devero Training</option>
								<option value="kantime-training">Kantime Training</option>
								<option value="kinnser-training">Kinnser Training</option>
								<option value="therapyboss-training">Therapyboss Training</option>
                            </select>
                        </div>
                    </li>
                </ul>
            <!-- <form id="doc-categories-form" name="doc-categories-form" action="{{the_permalink()}}">
                <ul class="list-unstyled form-list">
                    <li style="width: 100%">
                        <div class="search-field custom-search">
                            <label>Category</label>
                            <select id="doc_toolkit" name="doc_toolkit">
                                <option value="">Please select</option>
                                <option value="ot-toolkit">OT Toolkit</option>
                                <option value="pt-toolkit">PT Toolkit</option>
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="search-field custom-search">
                            <label>Folder</label>
                            <select id="doc_sub_cat" name="doc_sub_cat">
                                <option value="">Please select</option>
                                @if($term_id > 0)
                                    @php
                                    $term_children = getTermChildren($term_id);
                                    @endphp
                                    @if ( $term_children )
                                        @foreach($term_children as $term_child)
                                            @if($term_child->term_id != $term_id)
                                                <option value="{{$term_child->slug}}" @if($term_child->slug == $_GET['doc_cat']) selected="selected" @endif>{{$term_child->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="search-field">
                            <label>Search</label>
                            <input type="text" name="search_text" placeholder="Search files" class="text-field" value="{{$_GET['search_text']}}">
                        </div>
                    </li>
                    <li>
                        <input type="hidden" name="search_document_library" value="1">
                        <input type="submit" class="submit" value="Search">
                        <a href="#" class="reset_link">Reset Search</a>
                    </li>
                </ul> -->
                <p><strong>Reminder:</strong> All of the following documents are the property of InHome Therapy. Our Terms of Service forbids the unauthorized distribution of these resources.</p>
            </form>
        </div>
    </div>
</div>

	<div class="container">
		<div class="doc-table-wrapper">
			<table class="doc-table-list">
				<thead>
					<tr>
						<th class="col-excerpt">Name</th>
						<th class="col-doc_categories">Category</th>
						<th class="col-file_size">File Size</th>
						<th class="col-file_type">File Type</th>
						<th class="col-link">Link</th>
					</tr>
				</thead>
				<tbody>
					@foreach(get_field('toolkit_details') as $toolkit_file)
			        <tr class="{{str_replace(' ', '-', strtolower($toolkit_file['toolkit_category']))}}">
			        	<td class="col-row-excerpt"><strong class="title">{{$toolkit_file['toolkit_file_download']['title']}}</strong></td>
			        	<td class="col-row-doc_categories">{{$toolkit_file['toolkit_category']}}</td>
			        	<td class="col-row-file_size">{{substr($toolkit_file['toolkit_file_download']['filesize'] / 1000000,'0','5')}} MB</td>
			        	<td class="col-row-file_type">
			        		@php
			        			$file_ext = $toolkit_file['toolkit_file_download']['url'];
			        			echo substr($file_ext, strrpos($file_ext, '.') + 1)
			        		@endphp
			        	</td>
			        	<td class="col-row-link"><a href="{{$toolkit_file['toolkit_file_download']['url']}}" download><i class="icon-down-to-line"></i> Download</a></td>
			        </tr>
			        @endforeach
				</tbody>
			</table>
		</div>
	@endwhile
</main>
@endsection

@push('custom-scripts')
    <script type="text/javascript">
    	jQuery('#doc_toolkit').on("change", function(){
		  var val = jQuery(this).val();
          var base_url = window.location.origin;
		  var slug = jQuery(location).attr('pathname').replace(/\/+$/, '');
		  if('/'+val != slug && val != '') {
			  window.location.href = base_url+"/"+slug+"/#"+val;
		  }

        //   var myArray  = jQuery(location).attr('href').split("#"); 
        //   alert(myArray[1]);
        //   if(val == 'pt-toolkit' && val != '') {
        //     jQuery('.ot-toolkit').hide();
        //     jQuery('.pt-toolkit').show();
        //   }
        //   else if(val == 'ot-toolkit' && val != '') {
        //     jQuery('.ot-toolkit').show();
        //     jQuery('.pt-toolkit').hide();
        //   }
        //   else {
        //     jQuery('.ot-toolkit').show();
        //     jQuery('.pt-toolkit').show();
        //   }
		})
        jQuery(function(){
          var myArray  = jQuery(location).attr('href').split("#"); 
          var val = myArray[1];
          if(val) {
            jQuery('#doc_toolkit option[value="'+val+'"]').attr("selected", "selected");		
			 jQuery('.jcf-select-text span').text(jQuery("#doc_toolkit option:selected" ).text());
			  	jQuery('.pt-toolkit, .ot-toolkit, .alora-training, .axxess-training, .devero-training, .kantime-training, .kinnser-training, .therapyboss-training').hide();
             jQuery('.'+val).show();
          }
			else
			{
					jQuery('.pt-toolkit, .ot-toolkit, .alora-training, .axxess-training, .devero-training, .kantime-training, .kinnser-training, .therapyboss-training').show();
			}
//           else if(val == 'ot-toolkit') {
//             jQuery('#doc_toolkit option[value="ot-toolkit"]').attr("selected", "selected");
// 			  jQuery('.jcf-select-text span').text(jQuery("#doc_toolkit option:selected" ).text());
//             jQuery('.ot-toolkit').show();
//             jQuery('.pt-toolkit').hide();
// 			jQuery('.alora-training').hide();
// 			jQuery('.axxess-training').hide();
// 			jQuery('.devero-training').hide();
// 			jQuery('.kantime-training').hide();
// 			jQuery('.kinnser-training').hide();
// 			jQuery('.therapyboss-training').hide();
//           }
// 		  else if(val == 'alora-training') {
//             jQuery('#doc_toolkit option[value="alora-training"]').attr("selected", "selected");
//             jQuery('.ot-toolkit').hide();
//             jQuery('.pt-toolkit').hide();
// 			jQuery('.alora-training').show();
// 			jQuery('.axxess-training').hide();
// 			jQuery('.devero-training').hide();
// 			jQuery('.kantime-training').hide();
// 			jQuery('.kinnser-training').hide();
// 			jQuery('.therapyboss-training').hide();
//           }
// 		  else if(val == 'axxess-training') {
//             jQuery('#doc_toolkit option[value="axxess-training"]').attr("selected", "selected");
//             jQuery('.ot-toolkit').hide();
//             jQuery('.pt-toolkit').hide();
// 			jQuery('.alora-training').hide();
// 			jQuery('.axxess-training').show();
// 			jQuery('.devero-training').hide();
// 			jQuery('.kantime-training').hide();
// 			jQuery('.kinnser-training').hide();
// 			jQuery('.therapyboss-training').hide();
//           }
// 		 else if(val == 'devero-training') {
//             jQuery('#doc_toolkit option[value="devero-training"]').attr("selected", "selected");
//             jQuery('.ot-toolkit').hide();
//             jQuery('.pt-toolkit').hide();
// 			jQuery('.alora-training').hide();
// 			jQuery('.axxess-training').hide();
// 			jQuery('.devero-training').show();
// 			jQuery('.kantime-training').hide();
// 			jQuery('.kinnser-training').hide();
// 			jQuery('.therapyboss-training').hide();
//           }
// 		  else if(val == 'kantime-training') {
//             jQuery('#doc_toolkit option[value="kantime-training"]').attr("selected", "selected");
//             jQuery('.ot-toolkit').hide();
//             jQuery('.pt-toolkit').hide();
// 			jQuery('.alora-training').hide();
// 			jQuery('.axxess-training').hide();
// 			jQuery('.devero-training').hide();
// 			jQuery('.kantime-training').show();
// 			jQuery('.kinnser-training').hide();
// 			jQuery('.therapyboss-training').hide();
//           }
// 		  else if(val == 'kinnser-training') {
//             jQuery('#doc_toolkit option[value="kinnser-training"]').attr("selected", "selected");
//             jQuery('.ot-toolkit').hide();
//             jQuery('.pt-toolkit').hide();
// 			jQuery('.alora-training').hide();
// 			jQuery('.axxess-training').hide();
// 			jQuery('.devero-training').hide();
// 			jQuery('.kantime-training').hide();
// 			jQuery('.kinnser-training').show();
// 			jQuery('.therapyboss-training').hide();
//           }
// 		  else if(val == 'therapyboss-training') {
//             jQuery('#doc_toolkit option[value="therapyboss-training"]').attr("selected", "selected");
//             jQuery('.ot-toolkit').hide();
//             jQuery('.pt-toolkit').hide();
// 			jQuery('.alora-training').hide();
// 			jQuery('.axxess-training').hide();
// 			jQuery('.devero-training').hide();
// 			jQuery('.kantime-training').hide();
// 			jQuery('.kinnser-training').hide();
// 			jQuery('.therapyboss-training').show();
//           }
//           else {
//             jQuery('.ot-toolkit').show();
//             jQuery('.pt-toolkit').show();
// 			jQuery('.alora-training').show();
// 			jQuery('.axxess-training').show();
// 			jQuery('.devero-training').show();
// 			jQuery('.kantime-training').show();
// 			jQuery('.kinnser-training').show();
// 			jQuery('.therapyboss-training').show();
//           }
//           
}); 
    </script>
@endpush