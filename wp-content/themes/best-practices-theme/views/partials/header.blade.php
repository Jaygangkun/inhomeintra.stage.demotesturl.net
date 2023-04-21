<header class="header">
  <div class="container">
    <strong class="logo"><a href="{{get_home_url()}}"><img src="{{get_field('site_logo','options')['url']}}" alt="In Home Therapy"></a></strong>
    <div class="nav-drop">
		<div class="nav-area">
		    <div class="right-area">
		    	<ul class="list-unstyled topics-menu">
		    		@foreach(get_field('navigation','options') as $nav)
		    		<li>
		    			<a href="{{$nav['nav_item']['url']}}">
		    				<div class="img">
		    					<img src="{{$nav['nav_icon']['url']}}" alt="" width="{{$nav['nav_icon_width']}}" height="{{$nav['nav_icon_height']}}">
		    				</div>
		    				<span class="text">{{$nav['nav_item']['title']}}</span>
		    			</a>
		    		</li>
		    		@endforeach
		    	</ul>
		    @if(is_user_logged_in())
		    	<ul class="top-links list-unstyled">
		    		<li>{{wp_get_current_user()->data->display_name}}
		    			<br>
		    			<span class="ip">{!! do_shortcode('[display_ip]') !!}</span>
		    		</li>
		    		<li><a href="{{wp_logout_url(get_home_url() . '/log-in/')}}"><i class="icon-sign-out-regular"></i> Log Out</a></li>
		    	</ul>
		    @endif
		    	<a href="{{get_field('support_link','options')['url']}}" class="btn btn-primary">{{get_field('support_link','options')['title']}}</a>
		    </div>
		</div>
	</div>
	<a href="#" class="menu-opener"><span></span></a>
	<div class="nav-drop-des">
		<div class="nav-area-des">
		    <div class="site-menu">
		    	<ul class="list-unstyled">
		    		@foreach(get_field('navigation','options') as $nav)
		    		<li>
		    			<a href="{{$nav['nav_item']['url']}}">
		    				<div class="img">
		    					<img src="{{$nav['nav_icon']['url']}}" alt=""
		    					@if($loop->iteration == 1)
		    					 width="42" height="37"
		    					@elseif($loop->iteration == 2)
		    					width="42" height="37"
		    					@elseif($loop->iteration == 3)
		    					width="42" height="37"
		    					@elseif($loop->iteration == 4)
		    					width="39" height="43"
		    					@elseif($loop->iteration == 5)
		    					width="42" height="45"
		    					@endif
		    					>
		    				</div>
		    				<span class="text">{{$nav['nav_item']['title']}}</span>
		    			</a>
		    		</li>
		    		@endforeach
		    	</ul>
		    	<div class="logo-ico">
		    		<img src="/wp-content/uploads/2022/01/logo-ico.png" alt="">
		    	</div>
		    </div>
		</div>
	</div>
	<a href="#" class="menu-opener-des"><span></span></a>
  </div>
</header>