<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- START: incl_features -->
<link rel="stylesheet" href="css/nivo-slider/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
	$(window).load(function() { $('#slider').nivoSlider({
		effect: 'fade', 
		animSpeed: 500,
      pauseTime: 8000,
		slices:15,
		boxCols:8,
		boxRows:4,
		startSlide:0,
		directionNav:true,
		directionNavHide:true,
		controlNav:true,
		controlNavThumbs:false,
		controlNavThumbsFromRel:true,
		keyboardNav:true,
		pauseOnHover:true, 
		manualAdvance:false
		});
	});
</script>
<div class="slider-wrapper theme-default">
	<div id="slider" class="nivoSlider">
		<img src="images/Feature03.jpg" alt="" title="#featureCaption1"/>
		<img src="images/Feature05.jpg" alt="" title="#featureCaption2"/>
		<img src="images/Feature02.jpg" alt="" title="#featureCaption3"/>
		<img src="images/Feature04.jpg" alt="" title="#featureCaption4"/>
		<img src="images/Feature01.jpg" alt="" title="#featureCaption5"/>
		<img src="images/Feature06.jpg" alt="" title="#featureCaption6"/>
	</div>
	<div id="featureCaption1" class="nivo-html-caption">NalliTrack is a complete set of on-line services that enable you to manage track & field teams and/or run meets. </div>
	<div id="featureCaption2" class="nivo-html-caption">With Nallitrack there's nothing to download or install,<br/> you manage everything in the cloud. </div>
	<div id="featureCaption3" class="nivo-html-caption">Information on meets, teams and athletes can be published for all, and is accessible from PCs, Macs, tablets, iPads, and mobile phones.</div>
	<div id="featureCaption4" class="nivo-html-caption">Officials can update meet information during the competition so coaches, athletes, and spectators stay informed in real time using their mobile devices.</div>
	<div id="featureCaption5" class="nivo-html-caption">Already have a site? No problem...<br />NalliTrack provides tools to seemlessly integrate its reports into most any website.</div>
	<div id="featureCaption6" class="nivo-html-caption">And best of all, sign up is free. So what are you waiting for?<br />Why not <a href="/go/register/">get started now</a>?</div>
</div>
<!-- END: incl_features -->
