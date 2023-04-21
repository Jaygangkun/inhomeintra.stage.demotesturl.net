@php 
$result = check_forgot_password();
@endphp
@extends('views.layouts.main')
@section('content')
@while (have_posts()) @php the_post() @endphp
<main class="main">
    <div class="loginbox-wrap">
        <div class="container">
            <h1>{{the_title()}}</h1>
            <form name="loginform" action="{{the_permalink()}}" method="post">
            @if($_GET['pass'] === 'sent')
                <p class="form-success">Reset password email has been sent successfully</p>
            @endif
                <p class="login-username"> 
                    <label for="user_login">Username or Email Address</label>
                    <input type="text" name="user_login" id="user_login" class="input" value="" >
                    @if($result !== null && $result['is_valid'] == false)
                        <span class="form-error">{{$result['message']}}</span>
                    @endif
                </p>
                <p class="login-submit">
                    <input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Submit">
                </p>
            </form>
        </div>
    </div>
</main>
@endwhile
@endsection
