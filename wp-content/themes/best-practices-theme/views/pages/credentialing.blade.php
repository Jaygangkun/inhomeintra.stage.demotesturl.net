@extends('views.layouts.main')
@section('content')
<main class="main">
	
	@while (have_posts()) @php the_post() @endphp
		<div class="staff-visual">
			<div class="container">
				<div class="row justify-content-between">
					<div class="col-lg-5">
						<div class="text-holder">
							<h1>Credentialing</h1>
							<p>Document Uploads by State</p>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="image">
							<img src="{{public_path('images/credentialing-img1.png')}}" alt="Credentialing">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="staff-section">
			<div class="container">
				<div class="dots-strip"></div>
				<div class="search_block">
					<form>
						<ul class="list-unstyled form-list">
							<li>
								<div class="search-field custom-search">
									<label>State</label>
									<select id="state_switcher">
										@foreach(get_field_object('field_63a1ff2e41242')['choices'] as $state)
											<option value="{{$state}}">{{$state}}</option>
										@endforeach
									</select>
								</div>
							</li>
							<li>
								<div class="search-field">
									<label>Search</label>
									<input type="text" class="text-field" style="pointer-events:none">
								</div>
							</li>
							<li>
								<a role="button" style="cursor: pointer;" class="reset_link">Reset Search</a>
							</li>
						</ul>
					</form>
				</div>
			</div>
		</div>
		<div class="credentialing-section">
			<div class="container">
				<div class="no_files_wrap" id="preload_box">
					<div>
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							 viewBox="0 0 31.8 21.2" style="enable-background:new 0 0 31.8 21.2;" xml:space="preserve">
						<style type="text/css">
							.st0{clip-path:url(#SVGID_2_);fill-rule:evenodd;clip-rule:evenodd;fill:#97CA4C;}
							.st1{clip-path:url(#SVGID_2_);fill:none;stroke:#25282A;stroke-width:0.5;stroke-miterlimit:10;}
						</style>
						<g>
							<defs>
								<rect id="SVGID_1_" y="0" width="31.8" height="21.2"/>
							</defs>
							<clipPath id="SVGID_2_">
								<use xlink:href="#SVGID_1_"  style="overflow:visible;"/>
							</clipPath>
							<path class="st0" d="M2,13.8c0.5,1.6,2.9,3,5.6,3.4c2.7,0.4,3.6,0.3,5,1.7c1.4,0,1.6-0.8,2,0.1c0.3,0.9,2.3,2.7,2.7,2.1
								s-0.7-1.4,0.1-1.7c0.8-0.3,1-0.7,3.1-0.6c2.1,0.1,1.9-1.1,3.8-0.8c1.9,0.3,1.9,2.2,3.2,2.5c1.3,0.2,0.4-2.1,0.4-2.1
								s-1.2-1.6-0.9-2.2c0.3-0.7,2.7-2.2,2.7-2.6c0-0.4-1.2-1.2-1.1-1.6c0.1-0.5,1.7-2.6,2.5-2.7C32,9,30.6,7.8,30.6,7.8l0.1-2.3
								C30.7,5.5,1.6,12.2,2,13.8"/>
							<path class="st1" d="M1.3,2.1c0,0-1.5,6.4-1,8.4c0.5,2,2.7,4.5,5.6,5c2.9,0.5,3.8,0.4,5.3,2c1.4,0,1.7-0.9,2.1,0.1
								c0.4,1,2.4,3.3,2.9,2.5c0.5-0.8-0.8-1.7,0-2c0.8-0.3,1-0.8,3.3-0.8c2.3,0.1,2-1.4,4-1s2,2.7,3.4,3c1.4,0.3,0.5-2.5,0.5-2.5
								s-1.3-1.9-1-2.7c0.3-0.8,2.8-2.6,2.8-3.1c0-0.5-1.2-1.4-1.1-1.9c0.1-0.6,1.7-3.1,2.6-3.2c0.9-0.1-0.6-1.5-0.6-1.5l1.4-1.3l-1.3-2.9
								c0,0-0.7-0.1-1.5,2.1c-0.8,2.2-2.4,0.9-2.5,1.6c0,0.7,0.4,1.5-0.1,1.6c-0.4,0.1-1,1.2-1.7,1.4c-0.7,0.1-0.8-2.7-2.3-3.3
								c-1.5-0.6-1.5-0.1-2.4-0.1c-0.9,0-0.4-1.5-2-1.6C16.4,1.8,3.2,1.1,2.8,1.3C2.4,1.6,1.3,2.1,1.3,2.1z"/>
						</g>
						</svg>
						<p>Select your state</p>
					</div>
				</div>
				<div class="credentialing-table" id="formsTbl">
					<div id="forms">
						<input class="fuzzy-search">
						<table class="credentialing-table-list">
							<thead>
								<tr>
									<th class="col-excerpt">Name</th>
									<th class="col-link">Link</th>
								</tr>
							</thead>
							<tbody class="list">
							@foreach(get_field('credentialing_forms') as $forms)
							<tr>
								<td class="col-excerpt"><strong class="title name">{{$forms['form_title']}}</strong> </td>
								<td class="col-link "><a href="{{$forms['form_link']}}" class="link" target="_blank"><i class="icon-file-edit"></i> View Form</a></td>
								<td class="state" style="display: none">
									@foreach($forms['form_state'] as $mf)
										{{$mf['value']}}
									@endforeach
								</td>
							</tr>
							@endforeach
							</tbody>
						</table>
						</div>
				</div>
			</div>
		</div>
	@endwhile
</main>
<script>
	jQuery('.reset_link').click(function(){
		jQuery('.fuzzy-search').val('');
	});

	var options = {
		valueNames: [ 'name', 'link' , 'state'],
		fuzzySearch: {
			searchClass: "fuzzy-search",
			location: 0,
			distance: 100,
			threshold: 0.4,
			multiSearch: true
		}
    };

    var formList = new List('forms', options);
       
	jQuery('#state_switcher').change(function() {
		var value = jQuery(this).val();
		jQuery('#preload_box').hide();
		jQuery('#formsTbl').show();
		jQuery('.credentialing-section').addClass('selected');
		
		formList.filter(function(item) {
			if (item.values().state.includes(value)) {
				return true;
			} else {
				return false;
			} 
		});
	});

	console.log((window.location.hash || '#Florida').slice(1));
	// set initial state
	jQuery('#state_switcher').val((window.location.hash || '#Florida').slice(1)).change();
	//setTimeout(function() {
	//}, 1000);

</script>
@endsection
