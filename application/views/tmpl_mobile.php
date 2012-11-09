<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	$mobileNav_meetTab = '';
	$mobileNav_teamTab = '';
	$mobileNav_athleteTab = '';
	if(!$this->uri->segment(3, 0))
	{
		switch (strtoupper($this->uri->segment(2)))
		{
			case 'MEETS':
				$mobileNav_meetTab = 'class="ui-btn-active ui-state-persist"';
				break;	
			case 'TEAMS':
				$mobileNav_teamTab = 'class="ui-btn-active ui-state-persist"';
				break;	
			case 'ATHLETES':
				$mobileNav_athleteTab = 'class="ui-btn-active ui-state-persist"';
				break;
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Nallitrack</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="http://yui.yahooapis.com/3.0.0b1/build/cssreset/reset-min.css" rel="stylesheet" type="text/css" />
		<link href="http://yui.yahooapis.com/3.0.0b1/build/cssfonts/fonts-min.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile.structure-1.0.1.min.css" />
		<link rel="stylesheet" href="/css/themes/nallitrack-mobile.min.css" />
		<link rel="stylesheet" href="http://nallitrack.com/css/nallitrack.css" type="text/css" />
		<!-- <script src="http://code.jquery.com/jquery-1.6.4.min.js"></script> -->
		<script src="http://nallitrack.com/js/jquery-1.6.2.min.js" type="text/javascript"></script>
		<script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js" type="text/javascript"></script>
		<script src="http://nallitrack.com/js/nallitrack.js" type="text/javascript"></script>
	</head>
	<body>
		<div data-role="page" data-position="inline" data-title="NalliTrack" data-theme="a">
			<div data-role="header" id="mobileHeader" data-theme="a" >
				<h1 id="mobileLogo"></h1>
				<div data-role="navbar" style="clear: both;" >
					<ul>
						<li><a href="/search/meets" <?php echo $mobileNav_meetTab ?> data-ajax="false">Find a Meet</a></li>
						<li><a href="/search/teams" <?php echo $mobileNav_teamTab ?> data-ajax="false">Find a Team</a></li>
						<li><a href="/search/athletes" <?php echo $mobileNav_athleteTab ?> data-ajax="false">Find an Athlete</a></li>
					</ul>
				</div>
			</div>
			<div data-role="content" id="mobileContent" data-theme="b" >
				<?php echo $contents ?>
			</div>
		</div>
		<!-- Start of second page used for popups -->
		<div data-role="page" id="popup" data-position="inline">
			<div data-role="header" data-theme="b" >
				<div id="popupTitle"></div>
				<a href="#" class="ui-btn-right" data-theme="b" data-rel="back" data-icon="delete" >Exit</a>
			</div>
			<div data-role="content" class="mobileContent" id="popupContent"></div>
		</div>
	</body>
</html>