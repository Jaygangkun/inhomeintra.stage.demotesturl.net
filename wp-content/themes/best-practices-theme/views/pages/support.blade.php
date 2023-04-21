@extends('views.layouts.main')
@section('content')
@while (have_posts()) @php the_post() @endphp
<main class="main">
            <section class="contact-section">
                <div class="container">
                    <div class="dots-strip animate__animated animate__slideInUp animate__slow"></div>
                    <div class="row justify-content-between">
                        <div class="col-lg-6 col-xl-6">
                            <div class="description">
                                <h1>{!!get_field('support_visual_head')!!}</h1>
                                <p>{!!get_field('support_visual__content')!!}</p>
                                <div class="image">
                                    <img src="{{get_field('support_visual_image')['url']}}" alt="{{get_field('support_visual_image')['alt']}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-5">
                            <div class="form-holder">
                                {!!get_field('support_visual_form')!!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="contact-list-col">
                <div class="container">
                    @foreach(get_field('locations') as $location)
                    @php $main  = $loop->iteration @endphp
                    <div class="holder">
                        <div class="head">
                            <strong class="location">{{$location['location_head']}}</strong>
                            @if($location['location_phone'])
                                @php $phone= $location['location_phone']; 
                                $phone_num = str_replace("-", "", $phone);
                                @endphp
                                <strong class="tel"><a href="tel:{{$phone_num}}">{{$location['location_phone']}}</a></strong>@endif
                            @if($location['location_fax'])
                            <strong class="tel" style="display:block;">Fax: {{$location['location_fax']}}</strong>
                            @endif
                        </div>
                        <div class="col-holder">                            
                            <div class="contact-column clm{{$main}}">
                                @foreach($location['agent'] as $agent)
                                <div class="contact-block">
                                    @if($agent['agent_name'])<strong class="name">{{$agent['agent_name']}}</strong>@endif
                                    @if($agent['agent_designation'])<span class="position">{{$agent['agent_designation']}}</span>@endif
                                    @if($agent['agent_email'])<span class="email"><a href="mailto:{{$agent['agent_email']}}">{{$agent['agent_email']}}</a></span>@endif
                                    @if($agent['agent_ext'])<span class="ext">{{$agent['agent_ext']}}</span>@endif
                                    @if($agent['agent_phone'])
                                        @php $phone= $agent['agent_phone']; 
                                        $phone_num = str_replace("-", "", $phone);
                                        @endphp
                                        <span class="tel"><a href="tel:{{$phone_num}}">{{$agent['agent_phone']}}</a></span>@endif
                                </div>
                                @if($main == 1 && $loop->iteration %4 == 0 )
                                </div>
                                <div class="contact-column">
                                @elseif($main == 2 && $loop->iteration %1 == 0)
                                </div>
                                <div class="contact-column">
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </main>
@endwhile
@endsection
