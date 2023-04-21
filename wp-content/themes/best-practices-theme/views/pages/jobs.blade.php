@extends('views.layouts.main')

@section('content')
<main class="main">
@while (have_posts()) @php the_post() @endphp
			<div class="staff-visual add events-visual">
				<div class="container">
					<div class="dots-strip"></div>
					<div class="row justify-content-between">
						<div class="col-lg-7">
							<div class="text-holder">
								<h1>{{get_the_title(null, null, false)}}</h1>
								<p>{!!get_field('jobs_page_subhead')!!}</p>
							</div>
						</div>
						<div class="col-lg-5">
							
						</div>
					</div>
				</div>
				<div class="visual-bg">	
				</div>
			</div>
			<div class="job_filters">
				{!!get_field('jobs_page_content')!!}
			</div>


@endwhile
</main>
@endsection
