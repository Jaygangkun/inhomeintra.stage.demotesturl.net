<div class="slide">
	<div class="image">
		<img src="{{$employeeImage}}" alt="Employee highlight">
	</div>
	<span class="tag-text"><img src="{{public_path('images/ico-badge.svg')}}" width="14" height="19"> Therapist highlight</span>
	<h2>{!!get_field('highlight_title',get_the_ID())!!}</h2>
	<p>{!!the_content()!!}</p>
	<strong class="name">{!!the_title()!!}</strong>
	<span class="address">{!!get_field('employee_location',get_the_ID())!!}</span>
	<span class="position">{!!get_field('employee_position',get_the_ID())!!}</span>
</div>