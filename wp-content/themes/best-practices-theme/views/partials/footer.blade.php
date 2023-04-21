<footer class="footer">
	<div class="container">
		<div class="holder">
			<strong class="logo"><a href="{{get_home_url()}}"><img src="{{get_field('footer_logo','options')['url']}}" alt="In Home Therapy"></a></strong>
			<p>©{{date('Y')}}, <a href="{{get_home_url()}}">InHome Therapy</a>  |  {{get_field('footer_text','options')}}</p>
			<a href="{{get_field('support_link','options')['url']}}" class="btn btn-primary">{{get_field('support_link','options')['title']}}</a>
		</div>
	</div>
</footer>