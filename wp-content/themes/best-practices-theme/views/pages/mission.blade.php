@extends('views.layouts.main')
@section('content')
@while (have_posts()) @php the_post() @endphp
<main class="main">
    <div class="staff-visual add">
        <div class="container">
            <div class="dots-strip"></div>
            <div class="row justify-content-between">
                <div class="col-lg-6 col-xl-7">
                    <div class="text-holder">
                        <h1>{!!get_field('mission_head')!!}</h1>
                        <p>{!!get_field('mission_desc')!!}</p>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5">
                    <div class="image">
                        <img src="{{get_field('mission_visual')}}" alt="image-description">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="about-intro">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="image">
                        <img src="{{get_field('mission_sec1_image')}}" alt="image-description">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="description">
                        <div class="data-wrap">
                            <strong class="title">Purpose</strong>
                            <h2>{!!get_field('mission_sec1_title')!!}</h2>
                        </div>
                        <div class="holder">
                            {!!get_field('mission_sec1_content')!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endwhile
@endsection
