@php
$upcoming_events = getAllUpcomingEvents();
$events = getUpcomingEvents(-1);
@endphp

@extends('views.layouts.main')
@section('content')
@while (have_posts()) @php the_post() @endphp
<main class="main upcomingEventsBlock">
    <div class="staff-visual add events-visual">
        <div class="container">
            <div class="dots-strip"></div>
            <div class="row justify-content-between">
                <div class="col-lg-7">
                    <div class="text-holder">
                        <h1>{!!get_field('event_head')!!}</h1>
                        <p>{!!get_field('event_desc')!!}</p>
                    </div>
                </div>
                <div class="col-lg-5">

                </div>
            </div>
        </div>
        <div class="visual-bg"></div>
    </div>
    @if($upcoming_events)
        @foreach($upcoming_events as $start_date => $_events)
            @php 
            $start_date = $start_date . '-01';
            $month_icon = strtolower(date('M', strtotime($start_date)));
            $month_full = date('F', strtotime($start_date));
            @endphp
            <div class="events_detail_wrap">
                <div class="container">
                    <div class="events_detail_area">
                        <h2>
                            <img src="{{public_path('images/ico-'.$month_icon.'.svg')}}" alt="{{$month_full}}" width="24" height="24">
                            <span class="text">{{$month_full}}</span>
                        </h2>
                        <div class="events_detail_holder">
                        @foreach($_events as $_event)
                            @php 
                            $_start_date = $_event->event_date;
                            @endphp
                            <div class="events_detail_row">
                                <div class="span span1">
									<span class="date-box">
										<strong class="date">{{date('j', strtotime($_start_date))}}</strong>
										<span class="month">{{date('M', strtotime($_start_date))}}</span>
									</span>
                                </div>
                                <div class="span span2">
                                    <strong class="name">{{$_event->post_title}}</strong>
                                @if ( tribe_has_venue( $_event->ID ) )
                                    <span class="info">{{ucwords(tribe_get_city( $_event->ID ))}}, {{tribe_get_stateprovince( $_event->ID )}}</span>
                                @else
                                    @if(isVirtualEvent( $_event->ID ))
                                        <span class="info desktop-hidden"><a target="_blank" href="{{getVirtualEventUrl( $_event->ID )}}">Virtual Event</a></span>
                                    @endif
                                @endif
                                </div>
                                <div class="span span3">
                                    <span class="time">{{tribe_get_start_time($_event->ID)}} - {{tribe_get_end_time( $_event->ID )}}</span>
                                </div>
                                <div class="span span4">
                                @if ( tribe_has_venue( $_event->ID ) )
                                    <div class="description">
                                        <span class="venue">{{tribe_get_venue( $_event->ID )}}</span>
                                        <span class="address">{{tribe_get_address( $_event->ID )}}</span>
                                        <span class="city">{{tribe_get_city( $_event->ID )}}, {{tribe_get_stateprovince( $_event->ID )}} {{tribe_get_zip( $_event->ID )}}</span>
                                    </div>
                                @else
                                    @if(isVirtualEvent( $_event->ID ))
                                    <div class="description mobile-hidden">
                                        <span class="venue">Virtual Event</span>
                                        <span class="address"><a target="_blank" href="{{getVirtualEventUrl( $_event->ID )}}">{{getVirtualEventUrl( $_event->ID )}}</a></span>
                                    </div>
                                    @endif
                                @endif
                                </div>
                                <div class="span span5">
                                    <span class="link"><a href="#" data-toggle="modal" data-target="#events-modal-{{$_event->ID}}">View Details</a></span>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- Modal -->
        @include('views.partials.event-popup', compact('events'))
    @endif
</main>
@endwhile
@endsection
