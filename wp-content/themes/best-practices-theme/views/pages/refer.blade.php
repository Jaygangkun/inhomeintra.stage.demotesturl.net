@extends('views.layouts.main')
@section('content')
@while (have_posts()) @php the_post() @endphp
<main class="main">
	<div class="refer-visual">
		<div class="container">
			<div class="refer-visual-left">
				<h1>{!!get_field('visual_head')!!}</h1>
				<p>{!!get_field('visual_content')!!}</p>
			</div>
			<div class="refer-visual-right">
				<img src="{{get_field('visual_image')['url']}}" alt="Visual">
			</div>
		</div>
	</div>
	<div class="refer-sec-2">
		<div class="container">
			{!!get_field('section_2')!!}
		</div>
	</div>
	<div class="refer-sec-3">
		<div class="container">
			{!!get_field('section_3')!!}
		</div>
	</div>
	<div class="refer-sec-4">
		<div class="container">
			<div class="refer-sec-4-inner">
				{!!get_field('section_4')!!}
			</div>
		</div>
	</div>
	<div class="refer-sec-5">
		<div class="container">
			{!!get_field('section_5')!!}
		</div>
	</div>
	<div class="refer-sec-6">
		<div class="container">
			{!!get_field('section_6')!!}
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="refer_modal1" tabindex="-1" role="dialog" aria-labelledby="refer_modal1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<button type="button" class="modal-close" data-dismiss="modal"><i class="icon-times-light2"></i></button>
				{!!get_field('thanks_modal')!!}
			</div>
		</div>
	</div>
	<!-- Modal2 -->
	<div class="modal fade" id="refer_modal2" tabindex="-1" role="dialog" aria-labelledby="refer_modal2" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<button type="button" class="modal-close" data-dismiss="modal" style="position: absolute;
					right: 0;width: 32px;height:37px;opacity: 0;cursor: pointer;"><i class="icon-times-light"></i></button>
				<img src="{{public_path('images/refer_modal-img.png')}}" alt="image-description">
			</div>
		</div>
	</div>
</main>
@endwhile
@endsection
