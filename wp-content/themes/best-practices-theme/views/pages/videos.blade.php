@php 
if(!is_user_logged_in())
{
    if ( !is_page('log-in') && !is_page('forgot-password') && !is_page('recover-password') )
    {
        wp_redirect(get_home_url() . '/log-in/');
        exit;
    }
}
else
{
    if ( is_page('log-in') || is_page('forgot-password') || is_page('recover-password') )
    {
        wp_redirect(get_home_url());
        exit;
    }
}
@endphp
<!DOCTYPE html>
<html>
    <head>
        @section('head')
            <meta charset="{{bloginfo( 'charset' )}}">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="profile" href="http://gmpg.org/xfn/11">

            {!! wp_head() !!}
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"> 
            <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light+Two&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="{{mix('main.css')}}">
            <link rel="stylesheet" href="{{public_path('custom.css')}}">
        @show
    </head>
	<body {{body_class()}}>
		<div class="wrapper">
			@section('header')
                @include('views.partials.header')
            @show

            @yield('pre-content')

            @if (have_posts())
            	@while ( have_posts() )
            	@php
            	the_post();
            	@endphp
				<main class="main">
					<div class="staff-visual add">
						<div class="container">
							<div class="dots-strip"></div>
							<div class="row justify-content-between">
								<div class="col-lg-6 col-xl-7">
									<div class="text-holder">
										<h1>Videos</h1>
									</div>
								</div>
								<div class="col-lg-6 col-xl-5">
									<div class="image">
										<img src="{{public_path('images/videos_hero.png')}}" alt="image-description">
									</div>
								</div>
							</div>
						</div>
					</div>
				    <div class="gallerysec">
				    	<div class="container">
                            <div class="videos_blocks">
                            
                                @php
                                
                                $videosCount = wp_count_posts( 'videos' )->publish;

                                if($videosCount>0){
                                    echo do_shortcode('[ajax_load_more post_type="videos" post_status="publish" posts_per_page="4"]');
                                }else{

                                    @endphp
                                    <div class="members_holder">
                                        <div class="no_files_wrap">
                                            <div>
                                                <img src="/wp-content/uploads/2022/03/no_videos.svg" alt="">
                                                <p style="text-align: center">No videos available</p>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                }


                                @endphp 

                            </div>



					        




					    </div>
				    </div>
                    
				</main>
				@endwhile
			@endif

			@yield('post-content')

            @section('footer')
                @include('views.partials.footer')
            @show

            @section('scripts')
            {!! wp_footer() !!}
            <script src="{{mix('main.js')}}"></script>
            <script src="{{public_path('custom-select.js')}}"></script>

        
            @show

            @stack('custom-scripts')
		

        </div>
	</body>
</html>