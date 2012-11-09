<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- START: incl_footer -->
<table >
	<thead>
		<tr>
			<th>Main Menu</th>
			<th>Example Reports</th>
			<th>Support</th>
			<th>Follow Us</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<ul class="bulletedlist">
					<?php require('incl_mainmenu.php'); ?>
				</ul>
			</td>
			<td>
				<ul class="bulletedlist">
					<?php require('staticpages/incl_examples.php'); ?>
				</ul>
			</td>
			<td>
				<ul class="bulletedlist">
					<li><a href="/go/view/contact_us">Contact Us</a></li>
					<li><a href="/go/view/report_error">Report Errors or Omissions</a></li>
					<li><a href="/go/view/terms">Terms of Use</a></li>
					<li><a href="/go/view/privacy">Privacy Policy</a></li>
				</ul>
			</td>
			<td>
				<ul class="bulletedlist">
					<li><a href="#">Facebook</a></li>
					<li><a href="#">Twitter</a></li>
					<li><a href="#">YouTube</a></li>
					<li><a href="#">Blog</a></li>
				</ul>
			</td>
		</tr>
	</tbody>
</table>
<div id="copyright">Copyright &#169; 2011 NalliTrack &#8482;. All Rights Reserved</div>
<!-- END: incl_footer -->
