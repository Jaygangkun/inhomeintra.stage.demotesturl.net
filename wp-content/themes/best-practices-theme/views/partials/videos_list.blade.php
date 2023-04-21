<div class="videos-wrap">
	<div class="data-holder">
	    <div class="video-block">
	        <script src="https://fast.wistia.com/embed/medias/{!! get_field('wistia_video_code',get_the_ID()) !!}.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><span class="wistia_embed wistia_async_{!! get_field('wistia_video_code',get_the_ID()) !!} popover=true popoverAnimateThumbnail=true videoFoam=true" style="display:inline-block;height:100%;position:relative;width:100%">&nbsp;</span></div></div></div><div class="text-block"><h2>{{the_title()}}</h2>{{the_content()}}</div>
	</div>
</div>
