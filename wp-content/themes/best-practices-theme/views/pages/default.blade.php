@extends('views.layouts.main')

@section('content')
<main class="main" style="margin: 100px auto">
@while (have_posts()) @php the_post() @endphp
	<div class="container">
	    <h1>{{get_the_title(null, null, false)}}</h1>
	    {!!the_content()!!}
	</div>
@endwhile
</main>
@endsection
