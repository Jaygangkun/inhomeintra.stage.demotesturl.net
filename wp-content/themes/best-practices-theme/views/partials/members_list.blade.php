<div class="members-data-box">
    <div class="data-box">
        <h2>{{$staff->data->display_name}}</h2>
        <ul class="list-unstyled">
            <li class="location">
                <strong class="title">Location: </strong>
                <span class="description">{{$staff_city}} {{$staff_state}}</span>
            </li>
            <li class="role">
                <strong class="title">Role:</strong>
                <span class="description">{{$staff_role}}</span>
            </li>
            <li class="email">
                <strong class="title">Email: </strong>
                <span class="description"><a href="mailto:{{$staff->data->user_email}}">{{$staff->data->user_email}}</a></span>
            </li>
            @if($staff_cell != 'N/A')
            <li class="cell">
                <strong class="title">Cell: </strong>
                <span class="description"><a href="tel:{{$staff_cell}}"> {{$staff_cell}}</a></span>
            </li>
            @endif
        </ul>
    </div>
</div>