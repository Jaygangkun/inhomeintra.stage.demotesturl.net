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
	<div class="about_topics--area">
		<div class="container">
			<div class="dots-strip"></div>
			<div class="about_topics__head">
				<h2>{!!get_field('leader_board_head','options')!!}</h2>
				<p>{!!get_field('leader_board_content','options')!!}</p>
			</div>
			<div class="about_topics">
				<ul class="about_topics__list list-unstyled">
					@foreach(get_field('leaders','options') as $leaders)
					<li>
						<div class="holder">
							<span class="first_let">{{substr($leaders['leader_name'],0,1)}}</span>
							<strong class="name">{{$leaders['leader_name']}}</strong>
						</div>
						<span class="result">{{$leaders['leader_score']}} %</span>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
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

@endwhile
@endsection