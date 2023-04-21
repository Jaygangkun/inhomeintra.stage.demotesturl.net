<ol class="breadcrumb list-unstyled">
    @php
        $breadcrumbs = (new BreadcrumbFactory())->build();
    @endphp

    @foreach($breadcrumbs as $breadcrumb)
        @if($loop->last)
            <li>{{$breadcrumb->get_name()}}</li>
        @elseif($loop->first)
            <li><a href="{{get_home_url()}}">InHome Therapy Resources</a></li>
        @elseif($breadcrumb->get_link())
            <li><a href="{{$breadcrumb->get_link()}}">{{$breadcrumb->get_name()}}</a></li>
        @endif
    @endforeach
</ol> 