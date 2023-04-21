@extends('views.layouts.main')

@section('content')
<main class="main" style="margin: 100px auto 0">
@while (have_posts()) @php the_post() @endphp
    <div class="container postinner">
        <h1>{{the_title(null, null, false)}}</h1>
        {!!the_content()!!}
        <p><a href="{{get_field('download_article')}}" target="_blank">Download Article Here</a></p>
        <a href="/clinical-director-feed/" class="back_link">
            <i class="icon-chevron-left-regular"></i> Back to the Clinical Director Feed
        </a>
    </div>
@endwhile
@endsection
