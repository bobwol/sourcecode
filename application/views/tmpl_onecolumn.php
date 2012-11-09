<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>NalliTrack</title>
		<link href="http://yui.yahooapis.com/3.0.0b1/build/cssreset/reset-min.css" rel="stylesheet" type="text/css" />
		<link href="http://yui.yahooapis.com/3.0.0b1/build/cssfonts/fonts-min.css" rel="stylesheet" type="text/css" />
		<link href="http://nallitrack.com/css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
		<link href="http://nallitrack.com/css/datatable.css" rel="stylesheet" type="text/css" />
		<link href="http://nallitrack.com/css/datatable_jui.css" rel="stylesheet" type="text/css" />
		<link href="http://nallitrack.com/css/TableTools.css" rel="stylesheet" type="text/css" />
		<link href="http://nallitrack.com/css/TableTools_jui.css" rel="stylesheet" type="text/css" />
		<link href="http://nallitrack.com/css/nallitrack.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="/images/favicon.ico" />
			<script type="text/javascript" src="http://nallitrack.com/js/jquery-1.6.2.min.js"></script>
			<script type="text/javascript" src="http://nallitrack.com/js/jquery-ui-1.8.16.custom.min.js"></script>
			<script type="text/javascript" src="http://nallitrack.com/js/jquery.qtip-1.0.0-rc3.min.js"></script>
			<script type="text/javascript" src="http://nallitrack.com/js/jquery.dataTables.min.js"></script>
			<script type="text/javascript" src="http://nallitrack.com/js/TableTools.min.js"></script>	
			<script type="text/javascript" src="http://nallitrack.com/js/nallitrack.js"></script>
		<script>
			$(function(){
				<?php if($this->session->flashdata('flash_message') == '') : ?>
				$('#flashMessage').css('visibility', 'hidden');
				<?php else : ?>
				$('#flashMessage').delay(5000).animate({opacity:0});
				<?php endif; ?>
				$('#contentContainer').fadeIn('slow');	
			});
		</script>
	</head>
	<body>
		<div id="header">
			<div id="headerContentWrapper">
				<a href="/"><div id="logo">Manage Track Meets. Manage Track Teams.</div></a>
				<div id="mainMenuWrapper">
					<div id="mainMenuWrapperRight"></div>
					<div id="mainMenu">
						<?php require('incl_mainmenu.php'); ?>
					</div>
					<div id="mainMenuWrapperLeft"></div>
				</div>
			</div>
		</div>
		<div id="dividerTop"></div>
		<div id="contentContainer" class="hide">
			<div id="contentColumnWrapper">
				<div id="contentColumn" class="innertube roundedCorners whiteBackground fullPage">
					<div id="flashMessage"><?php echo $this->session->flashdata('flash_message'); ?></div>
					<div id="topSectionContent"></div>
					<?php echo $contents ?>
				</div>
			</div>
		</div>
		<div id="dividerBottom"></div>
		<div id="footer">
			<?php require('incl_footer.php'); 
			/* print_r($this->session->all_userdata()); */ ?>
		</div>
	</body>
</html>