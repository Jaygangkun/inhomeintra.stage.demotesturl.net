@php 
global $post;
global $wp;

$events = getUpcomingEvents();

@endphp
@extends('views.layouts.main')

@section('content')
@while (have_posts()) @php the_post() @endphp
		@if(get_field('show_notification_bar'))
   		<div class="topbar">
			<div class="container">
				<p>{!!get_field('notification_bar')!!}</p>
				<a href="#" class="close-btn"><i class="icon-times-circle-light"></i></a>
			</div>
		</div>
		@endif
		<main class="main">
			<section class="info-area">
				<div class="container">
					<div class="dots-strip"></div>
					<div class="row justify-content-between">
						<div class="col-lg-7">
							<nav class="main_menu">
								<ul class="list-unstyled">
									<li class="active">
										<a href="/">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image1.svg" alt="" width="21" height="21">
						    				</div>
						    				<span class="text">Dashboard</span>
						    			</a>
									</li>
									<li>
										<a href="/document-library/?doc_cat=compliance-and-quality-resources">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2023/04/ComplianceandQualityResources.svg" alt="" width="24">
						    				</div>	
						    				<span class="text">Compliance and Quality Resources</span>
						    			</a>
									</li>
									
									<li>
										<a href="/purpose-and-values">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image2.svg" alt="" width="26" height="21">
						    				</div>	
						    				<span class="text">Purpose and Values</span>
						    			</a>
									</li>
									<li>
										<a href="/staff-directory/">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image3.svg" alt="" width="23" height="24">
						    				</div>
						    				<span class="text">Staff Directory</span>
						    			</a>
									</li>
									<li>
										<a href="/agency-directory/">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image4.svg" alt="" width="23" height="24">
						    				</div>
						    				<span class="text">Agency Directory</span>
						    			</a>
									</li>
									<li>
										<a href="#poll" class="smooth-links">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image15.svg" alt="" width="23" height="24">
						    				</div>
						    				<span class="text">Poll</span>
						    			</a>
									</li>
									<li>
										<a href="#employee-sec" class="smooth-links">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image17.svg" alt="" width="23" height="24">
						    				</div>
						    				<span class="text">Employee Highlight</span>
						    			</a>
									</li>
									<li>
										<a href="#gallery-sec" class="smooth-links">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image16.svg" alt="" width="23" height="24">
						    				</div>
						    				<span class="text">Gallery</span>
						    			</a>
									</li>
									<li>
										<a href="/job-opportunities/">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image5.svg" alt="" width="25" height="24">
						    				</div>
						    				<span class="text">Job Opportunities</span>
						    			</a>
									</li>
									<li>
										<a href="/refer/">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image6.svg" alt="" width="26" height="26">
						    				</div>
						    				<span class="text">Referrals</span>
						    			</a>
									</li>
									<!-- <li>
										<a href="/clinical-director-feed">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image7.svg" alt="" width="27" height="21">
						    				</div>
						    				<span class="text">Clinical Director Feed</span>
						    			</a>
									</li> -->
									<li>
										<a href="/document-library/">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image8.svg" alt="" width="22" height="26">
						    				</div>
						    				<span class="text">Agency Assets</span>
						    			</a>
									</li>
									<li>
										<a href="/credentialing/">
						    				<div class="img">
						    					<img src="{{public_path('images/credentialing-ico.svg')}}" alt="" width="21" height="20">
						    				</div>
						    				<span class="text">Credentialing</span>
						    			</a>
									</li>
									<!-- <li>
										<a href="/document-library/?doc_cat=florida-agency-assets">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image10.svg" alt="" width="36" height="28">
						    				</div>
						    				<span class="text">FL Agency Assets </span>
						    			</a>
									</li>
									<li>
										<a href="/document-library/?doc_cat=illinois-agency-assets">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image11.svg" alt="" width="18" height="27">
						    				</div>
						    				<span class="text">IL Agency Assets</span>
						    			</a>
									</li>
									<li>
										<a href="/document-library/?doc_cat=pennsylvania-agency-assets">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image12.svg" alt="" width="37" height="23">
						    				</div>
						    				<span class="text">PA Agency Assets </span>
						    			</a>
									</li>
									<li>
										<a href="/document-library/?doc_cat=texas-agency-assets">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image13.svg" alt="" width="32" height="29">
						    				</div>
						    				<span class="text">TX Agency Assets </span>
						    			</a>
									</li>
									<li>
										<a href="/document-library/?doc_cat=universal-forms">
						    				<div class="img">
						    					<img src="/wp-content/uploads/2022/09/menu-image14.svg" alt="" width="23" height="26">
						    				</div>
						    				<span class="text">Universal Forms</span>
						    			</a>
									</li> -->
								</ul>
							</nav>
							@if(get_field('message_view') == 'Message')
							<div class="holder text-block-holder">
								{!!get_field('message')!!}
							</div>
							@elseif(get_field('message_view') == 'Video')
							<div class="holder video-block-holder">
								{!!getHomePageWistiaVideo()!!}
							</div>
							@elseif(get_field('message_view') == 'Flyer')
							<div class="holder flyer-block-holder">
								{!!get_field('flyer')!!}
							</div>
							@endif
							
						</div>
						<div class="col-lg-5 col-xl-4">
							<div class="events-block">
								<strong class="datetime"><span>today</span> {{date('l')}}, {{date('F')}} {{date('d')}}, {{date('Y')}}</strong>
								<h2><img src="{{public_path('images/ico-calender.svg')}}" width="21" height="20"> Upcoming Events @if($events)<a href="{{home_url('/upcoming-events/')}}" class="view">View All</a>@endif</h2>
								@if($events)
								<ul class="list-unstyled">
									@foreach($events as $event)
									@php
									$start_date = $event->event_date;
									@endphp
									<li>
										<a href="#" data-toggle="modal" data-target="#events-modal-{{$event->ID}}">
											<span class="date-box">{{date('d', strtotime($start_date))}}<span>{{date('M', strtotime($start_date))}}</span></span>
											<div class="description">											
											<strong class="title">{{$event->post_title}}</strong>
											@if ( tribe_has_venue( $event->ID ) )
												<p>{{ucwords(tribe_get_city( $event->ID ))}}, {{tribe_get_stateprovince( $event->ID )}}</p>
											@else
												@if(isVirtualEvent( $event->ID ))
													<p>Virtual Event</p>
												@endif
											@endif
											</div>
											{{-- <strong class="date">{{date('n/j/y', strtotime($start_date))}}</strong> --}}
										</a>
									</li>
									@endforeach
								</ul>
								@endif
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="about-blocks">
				@if(get_field('enable_leader_board','options'))
				<div class="container">
					<div class="about_topics">
						<div class="about_topics__head">
							<h2>{!!get_field('leader_board_head','options')!!}</h2>
							<p>{!!get_field('leader_board_content','options')!!}</p>
							<a href="/leader-board/" class="view">View All</a>
						</div>
						<ul class="about_topics__list list-unstyled">
							@foreach(get_field('leaders','options') as $leaders)
							<li>
								<div class="holder">
									<span class="first_let">{{substr($leaders['leader_name'],0,1)}}</span>
									<strong class="name">{{$leaders['leader_name']}}</strong>
								</div>
								<span class="result">{{$leaders['leader_score']}} %</span>
							</li>
							@if($loop->iteration == 10) @break @endif
							@endforeach
						</ul>
					</div>
				</div>
				@endif
				<div class="about-blocks__subsection">
					<div class="circle"></div>
					<div class="container">
						<div class="row">
							<div class="col-lg-7">
								<div class="block" id="employee-sec">
									<div class="employee-slider">
										{!!employeeHighlightBlock()!!}
									</div>
								</div>
							</div>
							<div class="col-lg-5">
								@if(get_field('show_comic'))
								<div class="block add block-comic">
									<span class="tag-text"><img src="{{public_path('images/ico-comic.svg')}}" width="20" height="19"> Daily Comic</span>
									<div class="img"><img src="{{get_field('comic_image')['url']}}" alt="Comic"></div>
									<span class="text">{!!get_field('comic_text')!!}</span>
								</div>							
								@else
									@if(get_field('enable_poll'))
										<div class="block add pollForm" id="poll">
											<span class="tag-text"><img src="{{public_path('images/poll_ico.svg')}}" width="14" height="13"> Poll</span>
			                                @php echo do_shortcode(get_field('poll_form')); @endphp
										</div>
									@else
										<div class="block add">
											<div class="img"><img src="{{get_field('fun_fact_image')['url']}}" alt="Fun Facts"></div>
											<span class="tag-text"><img src="{{public_path('images/ico-fun-fact.svg')}}" width="19" height="19"> Fun Fact</span>
											<h2 class="h3">{!!get_field('fun_fact_title')!!}</h2>
											<p>{!!get_field('fun_fact_description')!!}</p>
										</div>
									@endif

								@endif
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="topics-blocks">
				<div class="container">
					<div class="dots-strip animate__animated animate__slideInUp animate__slow"></div>
					<div class="row">
						<div class="col-lg-6">
							<div class="left-blocks">
								<div class="head">
									<strong class="title"><img src="{{public_path('images/ico-link.svg')}}" alt="image-description" width="22" height="19" class="icon">{!!get_field('community_tool_box_head')!!}</strong>
									<h2>{!!get_field('community_tool_box_subhead')!!}</h2>
								</div>
								<ul class="list-unstyled">
									@foreach(get_field('community_tool_box_category') as $cat)
									<li>
										<a href="{{$cat['community_tool_box_category_link']}}">
											<div class="img">
												@if($loop->iteration == 6)
												<img src="{{$cat['community_tool_box_category_image']['url']}}" width="80" height="64" alt="image-description">
												@else
												<img src="{{$cat['community_tool_box_category_image']['url']}}" width="68" height="59" alt="image-description">
												@endif
											</div>
											<span class="text">{{$cat['community_tool_box_category_name']}}</span>
										</a>
									</li>
									@endforeach
								</ul>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="cat-blocks">
								<div class="head">
									<strong class="title"><i class="icon icon-link-light"></i> Resources</strong>
									<h2>Protected: <br>InHome Therapy Resources</h2>
								</div>
								@if($doc_lib_terms = getDocumentLibraryCategories())
								<ul class="list-unstyled cat-list">
									@foreach($doc_lib_terms as $doc_lib_term)
									<li><a href="{{home_url('/document-library/') . '?doc_cat=' . $doc_lib_term->slug}}">{{$doc_lib_term->name}}</a></li>
									@endforeach
								</ul>
								@endif
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="services-blocks">
				<div class="container">
					<h2>{!!get_field('training_module_head')!!}</h2>
					<div class="row">
						@foreach(get_field('training_module') as $tmodule)
						<div class="col-lg-6">
							<span class="services-block">
								<div class="image">
									<span class="text">{{$tmodule['training_module_name']}}</span>
									<img src="{{$tmodule['training_module_image']}}" alt="{{$tmodule['training_module_name']}}">
								</div>
								<div class="description">
									<strong class="title">{!!$tmodule['training_module_head']!!}</strong>
									<p>{!!$tmodule['training_module_description']!!}</p>
								</div>
								<div class="hover-box">
									<strong class="text2">
										<a href="{{$tmodule['training_module_download_link']}}" target="_blank">
											<i class="icon-down-to-line"></i>{{$tmodule['training_module_hover_text']}}
										</a>
									</strong>
								</div>
							</span>
						</div>
						@endforeach
					</div>
					<a href="/training-resources/" class="btn btn-primary">View All Training Resources</a>
				</div>
			</section>
			
			<section class="article-area">
				<div class="container">
					<h2>{!!get_field('gallery_description')!!}</h2>
					<div class="row">
						@foreach(get_field('gallery_images') as $gallery)
						@if($gallery['is_featured'])
						<div class="col-lg-3 col-md-6 col-6">
							@if($gallery['gallery_link'])
							<a href="{{$gallery['gallery_link']}}" class="article-block">
							@endif
								<img src="{{$gallery['gallery_image']['url']}}" alt="{{$gallery['gallery_image']['alt']}}">
							@if($gallery['gallery_link'])
							</a>
							@endif
						</div>
						@endif
						@endforeach
					</div>
					<!-- @php
					//gallery-id = 197 
				    $gallery_images = get_metadata( 'post', '197', '_rl_images');
				    if(is_array($gallery_images)){
				    @endphp
				    <div class="image-slider">	
				    	@foreach($gallery_images[0][media][attachments][ids] as $key => $att_id)
				    		<div class="slide">
				    		@php
				    			echo wp_get_attachment_image( $att_id, array('300', '300'), "", array( "class" => "img-responsive" ) );
				    		@endphp
				    		</div>
				    	@endforeach
				    </div>
					<a href="{{get_field('view_more')}}" class="btn btn-primary">View More</a>
					@php
					}
					@endphp
					-->
					<div class="image-slider" id="gallery-sec">
						@foreach(get_field('gallery_images') as $gallery)
						<div class="slide">
							<img src="{{$gallery['gallery_image']['url']}}" alt="{{$gallery['gallery_image']['alt']}}">
						</div>
						@endforeach
					</div>
					<a href="{{get_field('view_more')}}" class="btn btn-primary">View More</a>
				</div>
			</section>
			<section class="social-area">
				<div class="container">
					<div class="head">
						<h2>Follow Us</h2>
						<ul class="social-networks list-unstyled">
							<li><a href="https://www.instagram.com/inhome_therapy/" target="_blank"><i class="icon icon-instagram"></i> @inhome_therapy </a></li>
							<li><a href="https://www.facebook.com/InHome-Therapy-103364085475182" target="_blank"><i class="icon icon-facebook"></i> InHome Therapy</a></li>
							<li><a href="https://www.linkedin.com/company/78019992" target="_blank"><i class="icon icon-linkedin"></i> InHome Therapy</a></li>
							<li><a href="https://twitter.com/inhome_therapy" target="_blank"><i class="icon icon-twitter-square-brands"></i> @inhome_therapy</a></li>
						</ul>
					</div>
					@php 
					echo do_shortcode('[ff id="4"]');
					@endphp
					
				</div>
			</section>
		</main>
		<!-- Modal -->
		@include('views.partials.event-popup', compact('events'))
@endwhile
@endsection
@push('custom-scripts')
    <script type="text/javascript">
    var ajaxurl = '{{admin_url('admin-ajax.php')}}';
    (function($)
    {
		$(document).ready(function()
		{
		    $(".topbar a.close-btn").click(function(e)
		    {
		    	$('.topbar').fadeOut('slow');

		    	sendAjax(ajaxurl, {'action' : 'read_notification_bar'});

		    	e.preventDefault();
		    	e.stopPropagation();
		    });
		});

		function sendAjax(ajaxurl, data)
        {
            $.ajax({
                method : 'POST',
                url : ajaxurl,
                dataType : 'json',
                data : data,
                success : function(output)
                {
                    console.log(output);
                }
            });
        }
	}(jQuery));
    </script>
@endpush