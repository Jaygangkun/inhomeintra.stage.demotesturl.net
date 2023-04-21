@if($events)
	@foreach($events as $event)
	@php 
	$ical_link = get_the_permalink( $event->ID );
	$ical_link = str_replace('https:', 'webcal:', $ical_link);
	$ical_link = rtrim($ical_link, '/') . '/?ical=1'; 
	@endphp
	<div class="modal fade" id="events-modal-{{$event->ID}}" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content events-modal-content">
				<button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
				<div class="head">
					<div class="ico"></div>
					<h2>{{get_the_title( $event->ID )}}</h2>
					<span class="datetime">
						{!! tribe_events_event_schedule_details( $event->ID ) !!}
					{{-- {{tribe_get_start_date( $event->ID )}}
						{{!tribe_event_is_all_day( $event->ID ) ? ' - ' . tribe_get_end_time( $event->ID ) : ''}} --}}
					{{-- December 15 @ 8:00 am - 5:00 pm --}}</span>
				</div>
				{!! get_the_content(null, false, $event->ID) !!}
				<div class="btn-holder">
					<a target="_blank" href="{{tribe_get_gcal_link( $event->ID )}}" class="btn btn-primary">Add to Google Calendar</a>
					<a href="{{$ical_link}}" class="btn btn-primary">Add to iCalendar</a>
				</div>
				<strong class="title">Details</strong>
				<ul class="list-unstyled ">
					<li class="date"><strong>Date:</strong> {{tribe_get_start_date($event->ID, false, 'F j')}}</li>
				@if(!tribe_event_is_all_day( $event->ID ))
					<li class="time"><strong>Time:</strong> {{tribe_get_start_time($event->ID)}}{!! tribe_events_event_schedule_details( $event->ID ) !!}</li> 					
				@endif
				</ul>
				@if ( tribe_has_venue( $event->ID ) )
					<strong class="title">Venue</strong>
					<ul class="list-unstyled venue-detail">
						<li>{{tribe_get_venue( $event->ID )}}</li>
						<li>{{tribe_get_address( $event->ID )}}</li>
						<li>{{tribe_get_city( $event->ID )}}, {{tribe_get_stateprovince( $event->ID )}} {{tribe_get_zip( $event->ID )}}</li>
					</ul>
				@else
					@if(isVirtualEvent( $event->ID ))
					<strong class="title">Virtual Event</strong>
					<ul class="list-unstyled venue-detail">
						<li><p><a target="_blank" href="{{getVirtualEventUrl( $event->ID )}}">{{getVirtualEventUrl( $event->ID )}}</a></p></li>
					</ul>
					@endif
				@endif
			</div>
		</div>
	</div>
	@endforeach
@endif