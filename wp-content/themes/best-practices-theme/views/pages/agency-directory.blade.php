@extends('views.layouts.main')
@section('content')
@php
$states = get_agencies_unique_locations();
@endphp
<main class="main">
            <div class="staff-visual">
                <div class="container">
                    <div class="dots-strip"></div>
                    <div class="row justify-content-between">
                        <div class="col-lg-5">
                            <div class="text-holder">
                                <h1>{{get_field('visual_head')}}</h1>
                                <p>{{get_field('visual_content')}}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="image">
                                <img src="{{get_field('visual_image')}}" alt="image-description">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="staff-section">
                <div class="container">
                    <div class="loaderBlock">
                        <img src="{{public_path('images/loader.gif')}}">
                    </div>
                    <div class="search_block">
                        <form id="agency-directory-form" name="agency" action="{{home_url('/agency-directory/')}}">
                            <ul class="list-unstyled form-list">
                                <li>
                                    <div class="search-field">
                                        <label>Agency</label>
                                        <input onkeyup="fetch()" type="text" id="agency_name" name="agency_name" placeholder="Enter Name" class="text-field" value="{{$_GET['agency_name']}}">
                                    </div>
                                </li>
                                <li>
                                    <div class="search-field custom-search">
                                        <label>State</label>
                                        <select name="search_state" id="search_state" class="text-field">
                                            <option value="">Please Select</option>
                                            @foreach($states as $state)
                                                @php $state = ucwords($state); @endphp
                                                <option @if($_GET['search_state'] == $state) selected="selected" @endif value="{{$state}}">{{$state}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </li>
                                <li>
                                    <input type="hidden" name="search_agency" value="1">
                                    <input type="submit" class="submit" value="Search">
                                        <a href="#" class="reset_link" style="display:none;">Reset Search</a>
                                </li>
                            </ul>
                            <p><strong>Privacy Notice:</strong> InHome Therapy tracks the usage of all of our affiliated web pages. The information below is sensitive, and it should only be used for authorized purposes. Inappropriate handling of this data may result in disciplinary or even legal action. </p>
                        </form>
                        <div id="datafetch"></div>
                    </div>
                    @php 
                    $wpQuery = search_agency_directory();
                    @endphp
                    <div class="agency_data-wrap">
                    @if($wpQuery->have_posts() && (($_GET['search_agency']==1 && $_GET['agency_name']!="") || (isset($_GET['search_state']) && !empty($_GET['search_state']))))
                        @php 
                        $results = loop_agency_directory($wpQuery);
                        @endphp
                    @else
                        <div class="agency_box_holder">
                            <div class="find_box">
                                <div class="image">
                                    <img src="{{public_path('images/agency_image2.svg')}}" alt="image-description">
                                </div>
                                <span class="text">Find Your Support Contact</span>
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </main>

@endsection
@push('custom-scripts')
    <script type="text/javascript">
    var ajaxurl = '{{home_url('/agency-directory/')}}';
    var data = {};
    var selectThisResult;
    (function($)
    {
        $(document).ready(function()
        {

            $('#search_state').change(function(){    
                $('#agency-directory-form').submit(); 
            });


            $(".reset_link").click(function(e)
            {
                $('input[name="agency_name"]').val('').attr('value', '');
                $('#search_state :selected').remove();
                $('#search_state').val('');
                $('#agency-directory-form').submit();
                $('.reset_link').hide();

                e.preventDefault();
                e.stopPropagation();
            });

            $("#agency-directory-form").submit(function(e)
            {
                e.preventDefault();
                e.stopPropagation();

                data = $(this).serialize();

                //data = data + "&action=search_staff";


                sendAjax(ajaxurl, data);

                if($('input[name="agency_name"]').val()!=""){
                    $('.reset_link').show();
                }

                if($('#search_state').val()!=""){
                    $('.reset_link').show();
                }

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

                    $('.agency_data-wrap').html($body.find('.agency_data-wrap').html());
                    $('.loaderBlock').hide();
                }
            });
        }

        selectThisResult = function (auto_search_result){
            

            $('input[name="agency_name"]').val(auto_search_result);
            $('#agency-directory-form').submit();
            $('.reset_link').show();
            $("#datafetch").empty();
            

        }
    }(jQuery));
    </script>
@endpush