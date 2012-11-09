<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	$frmAttributes = array('id' => 'frmAssignAthletes', 'name' => 'frmAssignAthletes', 'class' => 'editForm');
?>

<!-- START: assign_atheletes -->
<div class="topRegion">
	<ul class="hList">
		<li><a href="JavaScript:void(0);" onclick="$('#saveLink').fadeIn(2000);" >Save</a></li>
		<li><a href="/dashboard/" >Return to Dashboard</a></li>
	</ul>
	<div id="saveLink" class="confirm hide" style="margin-right: 35px;">Are you sure?&nbsp;
		<span><a href="JavaScript:void(0);" class="close" >No</a></span>&nbsp;&nbsp;
		<span><a href="JavaScript:void(0);" onclick="performAction('save');" >Yes</a></span>
	</div>
</div>
<h1>Assign Athletes</h1>
<h4>Meet Name</h4>
<h5 class="contentHeaderMargin">Meet Type</h5>
<?php echo form_open('', $frmAttributes); ?>
	<table id="dashboard" class="full">
		<tr>
			<td class="col1" style="width: 48%;" >
				<div>
					<fieldset>
						<legend>Track Events</legend>
						<div class="innertube">
						<div>
					</fieldset>
				</div>
			</td>
			<td class="spacer" ></td>
			<td class="col2" style="width: 48%;">
				<div>
					<fieldset>
						<legend>Field Events</legend>
						<div class="innertube">
						<div>
					</fieldset>
				</div>
			</td>
		</tr>
	</table>
<?php echo form_close(); ?>
<!-- END: arrange_events -->
