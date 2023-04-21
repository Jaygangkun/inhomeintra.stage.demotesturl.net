@extends('views.layouts.main')
@section('content')
@while (have_posts()) @php the_post() @endphp
<!-- <main class="main">
    <div class="loginbox-wrap">
        <div class="container">
            <h1>{{the_title()}}</h1>
            <form name="loginform" action="{{the_permalink()}}" method="post">
                @if(isset($_GET['error_mesg']) && !empty($_GET['error_mesg']))
                    <span class="form-error">{!!base64_decode(urldecode($_GET['error_mesg']))!!}</span>
                @endif
                <p class="login-username"> 
                    <label for="user_login">Username</label>
                    <input type="text" name="userName" id="user_login" class="input" value="" >
                </p>
                <p class="login-password">
                    <label for="user_pass">Password</label>
                    <input type="password" name="passWord" id="user_pass" class="input" value="" >
                </p>
                <p class="login-remember">
                    <label><input name="rememberMe" type="checkbox" id="rememberme" value="forever"> Remember Me</label>
                    <a class="forgot-password" href="{{home_url('/forgot-password/')}}">Forgot Password?</a>
                </p>
                <p class="login-submit">
                    <input type="hidden" name="login_Sbumit" >
                    <input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Log In">
                    <input type="hidden" name="redirect_to" value="{{home_url('/log-in/')}}">
                </p>
            </form>
        </div>
    </div>           
</main> -->


<main class="main">
    <div class="login_section">
        <div class="circle"></div>
        <div class="container">
            <div class="dots-strip"></div>
            <div class="row">
                <div class="col-md-7">
                    <ul class="list-unstyled image_list">
                        <li>
                            <div class="image">
                                <img src="{{public_path('images/login_image1.png')}}" alt="image-description">
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{public_path('images/login_image2.png')}}" alt="image-description">
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{public_path('images/login_image3.png')}}" alt="image-description">
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{public_path('images/login_image4.png')}}" alt="image-description">
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{public_path('images/login_image5.png')}}" alt="image-description">
                            </div>
                        </li>
                        <li>
                            <div class="image">
                                <img src="{{public_path('images/login_image6.png')}}" alt="image-description">
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-5">
                    <div class="login_form_area">
                        <strong class="logo"><a href="{{get_home_url()}}"><img src="{{public_path('images/logo.svg')}}" alt="In Home Therapy"></a></strong>
                        <h1>Welcome to Our Portal!</h1>
                        <div class="loginbox-wrap">
                            <form name="loginform" action="{{the_permalink()}}" method="post">
                            @if(isset($_GET['error_mesg']) && !empty($_GET['error_mesg']))
                                <span class="form-error">{!!base64_decode(urldecode($_GET['error_mesg']))!!}</span>
                            @endif
                            @if(isset($_GET['pass']) && !empty($_GET['pass']) && $_GET['pass']=='updated')
                                <span class="form-success">Password has been updated.</span>
                            @endif
                                <p class="login-username"> 
                                    <label for="user_login">Username</label>
                                    <input type="text" name="userName" id="user_login" class="input" value="" >
                                </p>
                                <p class="login-password">
                                    <label for="user_pass">Password</label>
                                    <input type="password" name="passWord" id="user_pass" class="input" value="" >
                                </p>
                                <p class="login-remember">
                                    <label><input name="rememberMe" type="checkbox" id="rememberme" value="forever"> Remember Me</label>
                                    <a class="forgot-password" href="{{home_url('/forgot-password/')}}">Forgot Password?</a>
                                </p>
                                <p class="login-submit">
                                    <input type="hidden" name="login_Sbumit" >
                                    <input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Log In">
                                    <input type="hidden" name="redirect_to" value="{{home_url('/log-in/')}}">
                                </p>
                            </form>
                            <div class="text">
                                <p>Having trouble logging in? Email us at<br> <a href="mailto:support@inhometherapy.com">support@inhometherapy.com</a></p>
                            </div>
                            <div class="captcha">
                                <p>This site is protected by reCAPTCHA and the Google <a href="https://www.inhometherapy.com/privacy-policy/" target="_blank">Privacy Policy</a> and <a href="https://www.google.com/intl/en/policies/terms/" target="_blank">Terms of Service</a> apply.</p>
                            </div>
                        </div>
                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endwhile
@endsection
