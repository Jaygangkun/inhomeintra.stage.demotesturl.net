@php 
if(!is_user_logged_in())
{
    if ( !is_page('log-in') && !is_page('forgot-password') && !is_page('recover-password') )
    {
        wp_redirect(get_home_url() . '/log-in/');
        exit;
    }
}
else
{
    if ( is_page('log-in') || is_page('forgot-password') || is_page('recover-password') )
    {
        wp_redirect(get_home_url());
        exit;
    }
}
@endphp
<!DOCTYPE html>
<html>
    <head>
        @section('head')
            <meta charset="{{bloginfo( 'charset' )}}">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
            <link rel="profile" href="http://gmpg.org/xfn/11">

            {!! wp_head() !!}
            <link rel="stylesheet" href="{{mix('main.css')}}">
            <link rel="stylesheet" href="{{public_path('custom.css')}}?var={{date('Y-m-d')}}">
            <script src="{{public_path('list.min.js')}}"></script>
        @show
    </head>

    <body {{body_class()}}>
        <div class="wrapper">
            @section('header')
                @include('views.partials.header')
            @show

            @yield('pre-content')

            @section('the-loop')
                @if (have_posts())
                    @yield('content')
                @else
                    @yield('no-content')
                @endif
            @show

            @yield('post-content')

            @section('footer')
                @include('views.partials.footer')
            @show

            @php $page_slug = basename(get_permalink()); @endphp
            @section('scripts')
                @if($page_slug != 'join')
                <script src="{{public_path('jquery.min.js')}}"></script>
                @endif
                <script src="{{mix('main.js')}}"></script>
                <script src="{{public_path('custom-select.js')}}"></script>
                <script src="{{public_path('map-config.js')}}"></script>
                <script src="{{public_path('map-interact.js')}}"></script>
                
                <?php wp_footer(); ?>
            @show
            @stack('custom-scripts')
        </div>
    </body>

</html>