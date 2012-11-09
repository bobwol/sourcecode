<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>                   	
<?php 
	if($this->session->userdata('user_id'))
	{
		echo '<div class="subheadingPurple roundedCorners" ><span>Account</span> Settings</div> ';
		echo '<div class="verticalMenu"><ul>';
		echo '<li><a href="/go/change_password/" id="cp" ><span>Change Password</span></a></li>';
		echo '<li><a href="/go/change_email/" id="ce" ><span>Change Email Address</span></a></li>';
		echo '<li><a href="/go/unregister/" id="ca" ><span>Cancel Account</span></a></li>';
		echo '<li><a href="/dashboard/" id="db" ><span>Return to Dashboard</span></a></li>';
		echo '</ul></div>';
	}
	else
	{
		// future home for testimonials
		echo '<div class="subheadingPurple roundedCorners" ><span>Customer</span> Testimonials</div>';
	}
?>