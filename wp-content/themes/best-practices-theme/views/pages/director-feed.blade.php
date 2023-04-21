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
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="profile" href="http://gmpg.org/xfn/11">

            {!! wp_head() !!}
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"> 
            <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light+Two&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="{{mix('main.css')}}">
            <link rel="stylesheet" href="{{public_path('custom.css')}}">
        @show
    </head>
    <body {{body_class()}}>
        <div class="wrapper">
            @section('header')
                @include('views.partials.header')
            @show

            @yield('pre-content')

            @if (have_posts())
                @while ( have_posts() )
                @php
                the_post();
                @endphp
                <main class="main">
                    <section class="staff-visual feed-visual">
                        <div class="container">
                            <div class="dots-strip"></div>
                            <div class="row justify-content-between">
                                <div class="col-xl-8">
                                    <div class="text-holder">
                                        <h1>{{get_the_title(null, null, false)}}</h1>
                                        <p>{!!get_field('directory_feed_subheading')!!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="staff-section feed-section">
                        <div class="container">
                            <div class="dots-strip"></div>
                            <div class="feed-section-items">
                                <div class="feed-filters">
                                    <strong class="title">Sort By:</strong>
                                    <form id="clinical_director_feed_form" name="clinical_director_feed_form" method="post">
                                        <div class="fields-row">
                                            <div class="fields-holder">
                                                <label>Date: </label>
                                                <div class="select-holder">
                                                    <select name="order" id="order">
                                                        <option value="ASC">Ascending</option>
                                                        <option value="DESC">Descending</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="fields-holder">
                                                <label>Author: </label>
                                                <div class="select-holder">
                                                    <select id="author" name="author">
                                                        <option value="">Please Select</option>
                                                        @php

                                                        $getAuthors = get_users(array( 'role__in' => array('clinical-director' ) ));
                                                        foreach ($getAuthors as $getAuthor) 
                                                        {
                                                           @endphp
                                                           <option value="@php echo $getAuthor->ID; @endphp">@php echo $getAuthor->display_name; @endphp</option>
                                                           @php
                                                        }
                                                        @endphp
                                                    </select>
                                                </div>
                                            </div>

                                            @php

                                            $args = array(
                                                    'type' => 'clinical_director_feed',
                                                    'orderby' => 'name',
                                                    'order' => 'ASC'
                                            );
                                            $tags = get_tags($args);
                                            @endphp
                                            <div class="fields-holder">
                                                <label>Tag: </label>
                                                <div class="select-holder">
                                                    <select id="tag" name="tag">
                                                        <option value="">Please Select</option>
                                                        @php
                                                        foreach($tags as $tag) { 
                                                        @endphp
                                                            <option value="@php echo $tag->name; @endphp">@php echo $tag->name; @endphp</option>
                                                        @php    
                                                        }
                                                        @endphp
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="submit" name="btnSubmit" value="" style="display: none;" />
                                    </form>
                                </div>
                                <div class="feeds_wrap">
                                    {!!do_shortcode('[ajax_load_more id="clinical_director_feed" post_type="clinicaldirectors" post_status="publish" order="ASC" repeater="template_1" button_label="Load More" posts_per_page="2" scroll="false"]')!!}
                                    
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="social-area">
                        <div class="container">
                            <div class="head">
                                <h2>Follow Us</h2>
                                <ul class="social-networks list-unstyled">
                                    <li><a href="https://www.instagram.com/inhome_therapy/" target="_blank"><i class="icon icon-instagram"></i> @inhome_therapy </a></li>
                                    <li><a href="https://www.facebook.com/InHome-Therapy-103364085475182" target="_blank"><i class="icon icon-facebook"></i> InHome Therapy</a></li>
                                    <li><a href="https://www.linkedin.com/company/78019992" target="_blank"><i class="icon icon-linkedin"></i> InHome Therapy</a></li>
                                    <li><a href="https://twitter.com/inhome_therapy" target="_blank"><i class="icon icon-twitter-square-brands"></i> @inhome_therapy</a></li>
                                </ul>
                            </div>
                            @php 
                            echo do_shortcode('[ff id="4"]');
                            @endphp
                            
                        </div>
                    </section>
                </main>
                @endwhile
            @endif

            @yield('post-content')

            @section('footer')
                @include('views.partials.footer')
            @show

            @section('scripts')
            {!! wp_footer() !!}
            <script src="{{mix('main.js')}}"></script>
            <script src="{{public_path('custom-select.js')}}"></script>

        
            @show

            @stack('custom-scripts')
            <script type="text/javascript">
            (function($){
                $(document).ready(function() {
                    $("#clinical_director_feed_form").submit(function(e) {
                        var paramsArray = $(this).serializeArray();
                        var filters = {};
                        for(var i in paramsArray) {
                            var paramsValue = paramsArray[i];
                            
                            if(paramsValue.name=='tag'){
                                var str = paramsValue.value;
                                str = str.replace(/\s+/g, '-').toLowerCase();
                                paramsValue.value = str;

                            }
                            filters[paramsValue.name] = paramsValue.value;
                        }
                        ajaxloadmore.filter('fade', 300, filters);
                        e.preventDefault();
                        e.stopPropagation();
                    });

                    $(".fields-row select").change(function(e) {
                        $(this.form).trigger("submit");
                    });
                });
            }(jQuery));
            </script>

        </div>
    </body>
</html>