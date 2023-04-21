@php 
global $gf_reset_user;
$result = recover_password();
@endphp
@extends('views.layouts.main')
@section('content')
@while (have_posts()) @php the_post() @endphp
<main class="main">
    <div class="loginbox-wrap">
        <div class="container">
            <h1>{{the_title()}}</h1>
            @if ( !$gf_reset_user || is_wp_error( $gf_reset_user ) )
                <form name="loginform">
                    @if ( $gf_reset_user && $gf_reset_user->get_error_code() === 'expired_key' )
                        <span class="form-error">The key has expired.</span>
                    @else
                        <span class="form-error">The key is invalid.</span>
                    @endif
                </form>
            @else
                <form name="loginform" action="{{get_home_url() . $_SERVER['REQUEST_URI']}}" method="post">
                @if($result === true)
                    <p class="form-success">Password has been reset successfully</p>
                @endif
                    <p class="login-username"> 
                        <label for="user_password">New Password</label>
                        <input type="password" name="user_password" id="user_password" class="input" value="" >
                        @if($result !== null && $result['is_valid'] == false)
                            <span class="form-error">{{$result['message']}}</span>
                        @endif
                    </p>
                    <p class="login-username"> 
                        <label for="user_password_confirm">Confirm Password</label>
                        <input type="password" name="user_password_confirm" id="user_password_confirm" class="input" value="" >
                        @if($result !== null && $result['is_valid'] == false)
                            <span class="form-error">{{$result['message2']}}</span>
                        @endif
                    </p>
                    <p class="login-submit">
                        <input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Submit">
                    </p>
                </form>
            @endif
        </div>
    </div>
</main>
@endwhile
@endsection
