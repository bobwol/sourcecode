<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	$frmAttributes = array('id' => 'frmAdjustSchedule', 'name' => 'frmAdjustSchedule', 'class' => 'editForm');
?>

<!-- START: adjust_schedule -->
<script>
	function performAction(selectedAction) {
		switch(selectedAction.toUpperCase()) {
			case 'SAVE':
					document.getElementById('frmMeetInfo').action = '/dashboard/';
					document.getElementById('frmMeetInfo').submit();
				}
				break;
			case 'GENERATE':
				document.getElementById('frmMeetInfo').action = '/dashboard/generate_schedule';
				document.getElementById('frmMeetInfo').submit();
				break;
		}
	}	
</script>
<div class="topRegion">
	<ul class="hList">
	<?php if($hasEventsScheduled) : ?>
		<li><a href="JavaScript:void(0);" onclick="$('#saveLink').fadeIn(2000);" >Save</a></li>
	<?php else : ?>		
		<li><a href="JavaScript:void(0);" onclick="performAction('generate');"  >Generate Schedule</a></li>
	<?php endif; ?>		
		<li><a href="/dashboard/" >Return to Dashboard</a></li>
	</ul>
	<div id="saveLink" class="confirm hide" style="margin-right: 100px;">Are you sure?&nbsp;
		<span><a href="JavaScript:void(0);" class="close" >No</a></span>&nbsp;&nbsp;
		<span><a href="JavaScript:void(0);" onclick="performAction('regenerate');" >Yes</a></span>
	</div>
</div>
<h1>Adjust Schedule</h1>
<h4>Meet Name</h4>
<h5 class="contentHeaderMargin">Meet Type</h5>
<?php if(!$hasEventsScheduled) : ?>
	<p><span style="color: red;">**WARNING: </span>You do not have schedule entries for this meet. You need to generate a schedule first.</p> 
<?php else : ?>
	<?php echo form_open('', $frmAttributes); ?>
	<?php echo form_close(); ?>
	<table class="dashboard full">
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
<?php endif; ?>

<!-- END: arrange_events -->
