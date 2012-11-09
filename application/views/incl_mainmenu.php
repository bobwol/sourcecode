<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- START: incl_mainmenu -->
<ul>                    	
	<li><a href="/search" id="mm_search" ><span>Search</span></a></li>
	<li><a href="/go/view/learn_more" id="mm_learnmore" ><span>Learn More</span></a></li>
<?php 
	if($this->session->userdata('user_id'))
	{
		echo '<li><a href="/dashboard/" id="mm_dashboard" ><span>Dashboard</span></a></li>';
		echo '<li><a href="/go/logout/" id="mm_logout" ><span>Sign Out</span></a></li>';
	}
	else
	{
		echo '<li><a href="/go/register/" id="mm_register" ><span>Sign Up... It\'s Free!</span></a></li>';
		echo '<li><a href="/go/login/" id="mm_login" ><span>Sign In</span></a></li>';
	}
?>
</ul>
<!-- END: incl_mainmenu -->
