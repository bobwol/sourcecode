<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if(sizeof($teamInfo) == 0) : ?>
	<p>A team with this ID does not exist</P>
<?php else : ?>
	
	<!-- START: team_report -->
	<?php include(APPPATH.'/views/incl_listformat.php'); ?>
	<div class="pgHeading">
		<h1><?php echo $teamInfo->orgName.' '.write_field($teamInfo->mascot, '()'); ?></h1>
		<p>
		<?php
			echo write_field($teamInfo->address1, '');
			echo write_field($teamInfo->address2, '<br />');
			echo write_field($teamInfo->city, '<br />');
			echo write_field($teamInfo->state, ', ');
			echo write_field($teamInfo->zip, ' ').'<br />';
			echo write_field($teamInfo->contactName, '');
			echo write_field($teamInfo->contactEmail, ' | ');
			echo write_field($teamInfo->contactPhone, ' | ').'<br/>';
		?>
		</p>
	</div>

	<?php if($this->session->userdata('device_type') == 'mobile') : ?>
		<?php
			$listHeaderSchedule='';
			$listHeaderRoster='';
			$rptTop='<div id="sched" class="teamRptView hide">';
			$rptMid='</div><div id="roster" class="teamRptView hide">';
			$rptEnd='</div>';
		?>
		<script>
			$(function(){
				$('select#rptViewSelector').change(function() {
					setRptView(getSelect(document.getElementById('rptViewSelector')));
				});
				setRptView('sched');
			});
			function setRptView(newView) {
				$('.teamRptView').hide('slow');
				$('#'+newView).show('fast');
			}
		</script>
		<div class="contentHeaderMargin">
			<select id="rptViewSelector" name="rptViewSelector" data-role="slider">
				<option value="sched">Team Schedule</option>
				<option value="roster">Team Roster</option>
			</select>
		</div>
	<?php else : ?>
		<?php
			$listHeaderSchedule='<thead><tr><th class="stdHdr" >Start Date</th><th class="stdHdr" >Meet Info</th></tr></thead>';
			$listHeaderRoster='<thead><tr><th class="stdHdr" >Lastname, firstname</th></tr></thead>';
			$rptTop ='<table class="dashboard full"><tr><td class="col1" style="width: 60%;"><div><fieldset><legend>Meet Schedule</legend><div class="innertube">';
			$rptMid ='</div></div></fieldset></td><td class="spacer"></td><td class="col2" style="width: 36%;"><div><fieldset><legend>Team Roster</legend><div class="innertube">';
			$rptEnd ='</div></div></fieldset></td></tr></table>';	
		?>
		<script>
		$(function(){
			// Used to make the myteam table sortable and filterable.
			$('.dataTable').dataTable({ 
				'sDom': 'f<"mttoolbar">t<"tblFooter"ip>',
				'iDisplayLength': 50,
				'bPaginate': true, 
				'bLengthChange': false, 
				'bFilter': true, 
				'bSort': false, 
				'bInfo': true, 
				'bAutoWidth': false, 
				'bJQueryUI': true
			});
		});
		</script>
		<style>
		.dataTables_filter { width: 100% !important; }	
		</style>	
	<?php endif; ?>
	
	<?php
	echo $rptTop;
	// Show Schedule of Meets
	echo "\n".$listBegin.$listHeaderSchedule.$listBodyBegin."\n";
	foreach($schedule as $ts)
	{				
		echo $rowBegin;
		echo $cellBegin.'<a href="/meet/report/'.$ts->meetID.'" data-ajax="false"><span class="itemTitle">'.$ts->meetTitle.'</span>'.$nonMobileAnchorClose.'<br/>';
		echo $ts->venue.'<br/>';
		echo $ts->city.' '.$ts->state.$cellEnd;
		echo $cellBegin.'<span class="ui-li-aside" style="margin-right: 5px;">'.date('D, M j, Y', strtotime($ts->firstDay)).'</span>'.$cellEnd;
		echo $mobileAnchorClose;
		echo $rowEnd."\n";
	}
	echo $listBodyEnd.$listEnd."\n";
	echo $rptMid;
	// Show Roster
	echo "\n".$listBegin.$listHeaderRoster.$listBodyBegin."\n";
	foreach($roster as $tr)
	{	
		echo $rowBegin;
		if($tr->published)
		{
			echo $cellBegin.'<a href="/athlete/report/'.$tr->athleteid.'" data-ajax="false">'.$tr->lastName.', '.$tr->firstName.$nonMobileAnchorClose;
			echo ' ('.$tr->gender.') - '.$tr->academicYear.$cellEnd.$mobileAnchorClose;
		}
		else
		{
			echo $cellBegin.$tr->lastName.', '.$tr->firstName;
			echo ' ('.$tr->gender.') - '.$tr->academicYear.$cellEnd;
		}
		echo $rowEnd."\n";
	}
	echo $listBodyEnd.$listEnd."\n";
	echo $rptEnd;
	?>
<?php endif; ?>	
<!-- END: team_report -->