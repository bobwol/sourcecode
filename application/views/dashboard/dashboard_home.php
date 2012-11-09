<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- START: dashboard_home -->
<script>
$(function(){
	// Used to make the myteam table sortable and filterable.
	$('#myteam').dataTable({ 
		'sDom': 'f<"mttoolbar">t<"tblFooter"ip>',
		'iDisplayLength': 50,
		'bPaginate': true, 
		'bLengthChange': false, 
		'bFilter': true, 
		'bSort': true, 
		'bInfo': true, 
		'bAutoWidth': false, 
		'bJQueryUI': true,
    	'aaSorting': [[ 0, 'asc' ]]
	});
	$("div.mttoolbar").html('<a href="/athlete/edit">Add a new athlete</a>');

	// Used to make the myteam table sortable and filterable.
	$('#mymeets').dataTable({ 
		//'sDom': 'f<"clear">t<"tblFooter"ip>',
		'sDom': 'f<"mmtoolbar">t<"tblFooter"ip>',
		'iDisplayLength': 20,
		'bPaginate': true, 
		'bLengthChange': false, 
		'bFilter': true, 
		'bSort': true, 
		'bInfo': true, 
		'bAutoWidth': false, 
		'bJQueryUI': true,
		'aaSorting': [[ 0, 'asc' ]],
		'aoColumnDefs': [ { 'sType': 'title-string', 'aTargets': [ 0 ] } ]
	});
	$("div.mmtoolbar").html('<a href="/meet/edit/">Add a new meet</a>');
});
</script>

<!-- Page section: topRegion -->
<div class="topRegion">
	Account Settings:&nbsp;
	<ul class="hList">
		<li><a href="/go/change_password/" >Change Password</li>
		<li><a href="/go/change_email/" >Change Email Address</a></li>
		<li><a href="/go/unregister/" >Cancel Account</a></li>
	</ul>
</div>

<!-- Page section: pgHeading -->
<div class="pgHeading">
	<h1><?php echo $teamInfo->orgName; ?> Track & Field Dashboard</h1>
</div>

<!-- Page section: pgHeading -->
<table class="dashboard full">
	<tr>
		<td class="col1" style="width: 56%;">
			<div>
				<fieldset>
					<legend>General Info</legend>
					<div class="innertube">
						<div class="flRt">
							<ul class="hList">
								<li><a href="/team/edit/">Edit</a></li>
								<li><a href="/team/report/<?php echo $teamInfo->teamid; ?>">Report</a></li>
							</ul>
						</div>
						<table class="nonEdit">
							<tr>
								<th>Organization</td>
								<td><?php echo $teamInfo->orgName; ?></td>
							</tr>
							<tr>
								<th>Mascot</td>
								<td><?php echo $teamInfo->mascot; ?></td>
							</tr>
							<tr>
								<th>Contact Name</td>
								<td><?php echo $teamInfo->contactName; ?></td>
							</tr>
							<tr>
								<th>Contact Email</td>
								<td><?php echo $teamInfo->contactEmail; ?></td>
							</tr>
							<tr>
								<th>Contact Phone</td>
								<td><?php echo $teamInfo->contactPhone; ?></td>
							</tr>
						</table>
					</div>
				</fieldset>
				<fieldset>
					<legend>Meet Schedule</legend>
					<div class="innertube">
						<table id="mymeets" class="dataTable full" >
							<thead>
								<tr>
									<th class="stdHdr" >Start Date</th>
									<th class="stdHdr" >Meet Info</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$delimiter = '';
									$teamSchedule = '';
								?>
								<?php foreach($schedule as $meet) : ?>
								<?php $teamSchedule = $teamSchedule.$delimiter.$meet->meetID; ?>
								<tr>
									<td><span title="'<?php echo date('Ymd', strtotime($meet->firstDay)); ?>'"></span><?php echo date('D, M j, Y', strtotime($meet->firstDay)); ?></td>
									<td>
										<?php if($meet->owner == $this->session->userdata('user_id')) : ?>
										<div class="flRt">[<a href="/meet/edit/<?php echo $meet->meetID; ?>">Edit</a>]</div>
										<?php endif; ?>
										<a href="/meet/report/<?php echo $meet->meetID; ?>" ><?php echo $meet->meetTitle; ?></a>&nbsp;<br /><?php echo $meet->venue; ?><br /><?php echo $meet->city.' '.$meet->state; ?></div>
									</td>
								</tr>
								<?php $delimiter = '|'; ?>
								<?php endforeach; ?>	
								<?php $this->session->set_userdata('teamSchedule', $teamSchedule); ?>
							</tbody>
						</table>
					<div>
				</fieldset>
			</div>
		</td>
		<td class="spacer"></td>
		<td class="col2" style="width: 40%;">
			<div>
				<fieldset>
					<legend>Team Roster</legend>
					<div class="innertube">
						<table id="myteam" class="dataTable full" >
							<thead>
								<tr>
									<th class="stdHdr" >Lastname, firstname</th>
									<th class="stdHdr" >Year</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($roster as $teamMember) : ?>
								<tr><td><div class="flRt">[<a href="#" rel="/images/help/help1.html">PR</a> | <a href="/athlete/edit/<?php echo $teamMember->athleteid; ?>">Edit</a>]</div><a href="/athlete/report/<?php echo $teamMember->athleteid; ?>"><?php echo $teamMember->lastName.', '.$teamMember->firstName; ?></a> (<?php echo $teamMember->gender; ?>)</td><td><?php echo $teamMember->academicYear; ?></td></tr>
								<?php endforeach; ?>	
							</tbody>
						</table>
					</div>
				</fieldset>
			</div>
		<td>
	</tr>
</table>
<!-- END: dashboard_home -->
