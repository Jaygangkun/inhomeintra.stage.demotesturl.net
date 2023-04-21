@php 
$get_unique_data = get_unique_data();
@endphp
@extends('views.layouts.main')
@section('content')
<main class="main">
    @while (have_posts()) @php the_post() @endphp
        <div class="staff-visual">
            <div class="container">
                <div class="dots-strip"></div>
                <div class="row justify-content-between">
                    <div class="col-lg-6 col-xl-7">
                        <div class="text-holder">
                            <h1>{{get_field('staff_directory_head')}}</h1>
                            <p>{{get_field('staff_directory_desc')}}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-5">
                        <div class="image">
                            <img src="{{get_field('staff_directory_image')['url']}}" alt="{{get_field('staff_directory_image')['alt']}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endwhile
    <div class="staff-section">
        <div class="container">
            <div class="loaderBlock">
                <img src="{{public_path('images/loader.gif')}}">
            </div>
            <div class="search_block">
                <form id="staff-directory-form" name="staff" action="{{home_url('/staff-directory/')}}">
                    <ul class="list-unstyled form-list">
                        <li>
                            <div class="search-field">
                                <label>Member</label>
                                <input type="text" id="member_name" name="member_name" placeholder="Name" class="text-field" value="{{$_GET['member_name']}}">
                            </div>
                        </li>
                        <li>
                            <div class="search-field custom-search">
                                <label>Location</label>
                                <select id="member_location" name="member_location" placeholder="City, State" >
                                    <option value="">Please select</option>
                                @if(!empty($get_unique_data['cities']))
                                @foreach($get_unique_data['cities'] as $city)
                                    <option value="{{$city}}" @if($city == $_GET['member_location']) selected="selected" @endif>{{$city}}</option>
                                @endforeach
                                @endif
                                </select>
                            </div>
                        </li>
                        {{-- <li>
                            <div class="search-field custom-search">
                                <label>State</label>
                                <select id="member_state" name="member_state" value="{{$_GET['member_state']}}">
                                    <option value="">Please select</option>
                                @foreach(states() as $state)
                                    <option value="{{$state}}" @if($state == $_GET['member_state']) selected="selected" @endif>{{$state}}</option>
                                @endforeach
                                </select>
                            </div>
                        </li> --}}
                        <li>
                            <div class="search-field custom-search">
                                <label>Position</label>
                                <select id="member_position" name="member_position">
                                    <option value="">Please select</option>
                                @if(!empty($get_unique_data['sroles']))
                                @foreach($get_unique_data['sroles'] as $srole)
                                    <option value="{{$srole}}" @if($srole == $_GET['member_position']) selected="selected" @endif>{{$srole}}</option>
                                @endforeach
                                @endif
                                </select>
                            </div>
                        </li>
                        <li>
                            <input type="hidden" name="search_staff" value="1">
                            <input type="submit" class="submit" value="Search">
                            <a href="#" class="reset_link">Reset Search</a>
                        </li>
                    </ul>
                    <p><strong>Privacy Notice:</strong> InHome Therapy tracks the usage of all of our affiliated web pages. The information below is sensitive, and it should only be used for authorized purposes. Inappropriate handling of this data may result in disciplinary or even legal action. </p>
                </form>
            </div>
            @php 
            $wp_user_query = search_staff_directory();
            $result_pagination = '';
            @endphp
            <div class="members_holder">
            @if($wp_user_query->get_total() > 0)
                @php 
                $results = loop_staff_directory($wp_user_query);
                $result_pagination = $results['pagination'];
                @endphp
            @else
                @include('views.partials.doc_categories_no_person')
            @endif
            </div>
            <div class="members_pagination">{!! $result_pagination !!}</div>
        </div>
    </div>
</main>
@endsection

@push('custom-scripts')
    <script type="text/javascript">
    var ajaxurl = '{{home_url('/staff-directory/')}}';
    var data = {};
    (function($)
    {
        
        $(document).ready(function(){
            $('#member_location').change(function(){    
                $('#staff-directory-form').submit(); 
            });


            $(".reset_link").click(function(e)
            {
                $('#member_location').val('');
                $('#member_position').val('');
                $('.search-field.custom-search .jcf-select-text span').text('Please select');
                $('input[name="member_name"]').val('').attr('value', '');
                $('#staff-directory-form').submit();

                e.preventDefault();
                e.stopPropagation();
            });
        });

        $(document).ready(function(){
            $('#member_position').change(function(){    
                $('#staff-directory-form').submit(); 
            });
        });

        $(document).ready(function()
        {
            $("#staff-directory-form").submit(function(e)
            {
                e.preventDefault();
                e.stopPropagation();

                data = $(this).serialize();

                //data = data + "&action=search_staff";

                sendAjax(ajaxurl, data);
            });

            $('body').on('click', '.members_pagination a.page-numbers', function(e)
            {
                sendAjax($(this).attr('href'), {});

                e.preventDefault();
                e.stopPropagation();
            });
        });

        function sendAjax(ajaxurl, data)
        {
            $('.loaderBlock').show();
            $.ajax({
                method : 'GET',
                url : ajaxurl,
                dataType : 'text',
                data : data,
                success : function(output)
                {
                    var str = output;
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(str, "text/html");
                    var bodyHTML = doc.getElementsByTagName('body')[0].innerHTML;
                    
                    var bodyHTML = '<div id="body-mock">' + bodyHTML + '</div>';
                    var $body = $(bodyHTML);

                    $('.members_holder').html($body.find('.members_holder').html());
                    $('.members_pagination').html($body.find('.members_pagination').html());
                    $('.loaderBlock').hide();
                }
            });
            /*$.get(ajaxurl, data, function(output)
            {
                console.log($(output).html());
                if(typeof output.html != "undefined")
                {
                    $('.members_holder').html(output.html);
                }

                if(typeof output.pagination != "undefined")
                {
                    $('.members_pagination').html(output.pagination);
                }
            });*/
        }
    }(jQuery));
    </script>
@endpush
