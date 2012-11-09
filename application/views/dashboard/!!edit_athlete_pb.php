<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	$frmAttributes		= array('id' => 'frmAthleteProfile', 'name' => 'frmAthleteProfile', 'class' => 'editForm');
	$allTrackEvents = '';
	$allFieldEvents = '';
	$set_pb = '';
	$set_sp = '';
	if(isset($trackEvent))
	{
		foreach($trackEvent as $event) 
		{
			$allTrackEvents = $allTrackEvents.'<tr id="event'.$event->eventID.'" class="allevents hide">';
			$allTrackEvents = $allTrackEvents.'<td><input type="checkbox" name="sp_event'.$event->eventID.'"  id="sp_event'.$event->eventID.'" value="" class="sp_event" /><label for="pb_event'.$event->eventID.'">'.$event->eventName.'</label></td>';
			$allTrackEvents = $allTrackEvents.'<td><input type="text" name="pb_event'.$event->eventID.'" id="pb_event'.$event->eventID.'" size="10"  maxlength="10" value="" class="pb_event" title="'.$event->eventCategory.'"/></td>';
			$allTrackEvents = $allTrackEvents."</tr>\n\t\t\t\t\t\t\t\t\t\t";

		}
	}
	if(isset($fieldEvent))
	{
		foreach($fieldEvent as $event) 
		{
			$allFieldEvents = $allFieldEvents.'<tr id="event'.$event->eventID.'" class="allevents hide">';
			$allFieldEvents = $allFieldEvents.'<td><input type="checkbox" name="sp_event'.$event->eventID.'"  id="sp_event'.$event->eventID.'" value="" class="sp_event" /><label for="pb_event'.$event->eventID.'">'.$event->eventName.'</label></td>';
			$allFieldEvents = $allFieldEvents.'<td><input type="text" name="pb_event'.$event->eventID.'" id="pb_event'.$event->eventID.'" size="10" maxlength="10" value="" class="pb_event" title="'.$event->eventCategory.'"/></td>';
			$allFieldEvents = $allFieldEvents."</tr>\n\t\t\t\t\t\t\t\t\t\t";
		}
	}
	if(isset($personalBest))
	{
		foreach($personalBest as $pb) 
		{
			$set_pb = $set_pb.'document.getElementById("pb_event'.$pb->eventID.'").value = "'.$pb->performance.'";';
			$set_pb = $set_pb."\n\t\t";
		}
	}
	if(isset($specialties))
	{
		foreach($specialties as $sp) 
		{
			$set_sp = $set_sp.'document.getElementById("sp_event'.$sp->eventID.'").checked = true;';
			$set_sp = $set_sp."\n\t\t";
		}
	}
?>
<!-- START: edit_athlete -->
<script>
	$(function(){
		<?php echo $set_pb.$set_sp; ?>
		
		$('#pb_view').bind( 'change', function(event, ui) {
			 setpbView(); 
		});
		setpbView();
	});

	function setpbView() {
		$(".allevents").hide();
		if(getSelect(document.getElementById('pb_view')) == 'all') {
			$(".sp_event").show();
			$(".allevents").show();
		} else {
			$(".sp_event").hide();
			$('.allevents').each(function(){
	    	if(document.getElementById('sp_'+$(this).attr("id")).checked) {
	   			$(this).show();
	    	}
			});			
		}
	}

	function collectData() {
		var personalBests = '';
		var mySpecialties = '';
		var athleteid = <?php echo $athleteid; ?>;
		var eventID = '';
		var performance = '';
		var delimiter = '';
		var eventCategory = '';
		var isValid = true;
		
		$('.pb_event').each(function(){
				eventID = $(this).attr("id").substr(8);
				performance = document.getElementById($(this).attr("id")).value;
				eventCategory = $(this).attr("title");
	    	if(performance != '') {
	    		if(reFormat(performance, eventCategory) == 'INVALID') {
	    			isValid = false;
	    		}else{
	    			personalBests = personalBests+delimiter+"("+athleteid+", '"+eventID+"', '"+performance+"' )";
	    			delimiter=",\n";
	    		}
	    	}
		});			
		var delimiter = '';
		$('.sp_event').each(function(){
				eventID = $(this).attr("id").substr(8);
	    	if(document.getElementById($(this).attr("id")).checked) {
	    		mySpecialties = mySpecialties+delimiter+"("+athleteid+", '"+eventID+"' )";
	    		delimiter=",\n";
	    	}
		});			
		//alert(personalBests);
		if(isValid) {
			document.getElementById('personalBests').value = personalBests+";";
			document.getElementById('mySpecialties').value = mySpecialties+";";
		}
		return isValid;
	}

function reFormat(performance, eventType) {
	var reFormatPerf = 'INVALID';
	if(eventType = 'TRACK') {
		// time mm:ss.xx (minutes are optional)
		var timePattern = /^((\d{1,2}):)?(\d{1,2}).(\d{2})$/;
		var perfVal = performance.match(timePattern);
		var minutes='00';
		var seconds='00';
		var fract='00';
		if (perfVal != null) {
			if(perfVal[1]) {
				minutes = perfVal[1].substring(0,perfVal[1].length-1);
			}
			seconds = perfVal[3];
			fract = perfVal[4];
			if(minutes >= 0 || minutes <= 59) {
				if(minutes.length < 2) minutes = '0' + minutes;
				if(seconds >= 0 || seconds <= 59) {
					if(seconds.length < 2) seconds = '0' + seconds;
					if(fract >= 0 || fract <= 99) {
						if(fract.length < 2) fract = '0' + fract;
						reFormatPerf = minutes+':'+seconds+'.'+fract;			
					}
				}				
			}
		}
	}else{
		// distance or height xx-xx.xx
		var distPattern = /^((\d{1,2,3})-)?(\d{1,2}).(\d{2})$/;
		var perfVal = performance.match(distPattern);
		var meters='00';
		var cmeters='00';
		var fract='00';
		if (perfVal != null) {
			if(perfVal[1]) {
				meters = perfVal[1].substring(0,perfVal[1].length-1);
			}
			seconds = perfVal[3];
			fract = perfVal[4];
			if(meters >= 0 ) {
				if(cmeters >= 0 || cmeters <= 99) {
					if(cmeters.length < 2) cmeters = '0' + cmeters;
					if(fract >= 0 || fract <= 99) {
						if(fract.length < 2) fract = '0' + fract;
						reFormatPerf = meters+':'+cmeters+'.'+fract;			
					}
				}				
			}
		}
	}
	return reFormatPerf;
}

	function performAction(selectedAction) {
		switch(selectedAction.toUpperCase()) {
			case 'SAVE':
				if(collectData()) {
					document.getElementById('frmAthleteProfile').action = '/dashboard/edit_athlete_pb';
					document.getElementById('frmAthleteProfile').submit();
				} else {
					alert('Error: Check the format of the data in the personal best table');
				}
				break;
			case 'REPORT':
				document.getElementById('frmAthleteProfile').action = '/athletefinder/view_athlete/<?php echo $athleteid; ?>';
				document.getElementById('frmAthleteProfile').submit();
				break;
			case 'DELETE':
				document.getElementById('frmAthleteProfile').action = '/dashboard/delete_athlete';
				document.getElementById('frmAthleteProfile').submit();
				break;
		}
	}
</script>
<div class="topRegion">
	<ul class="hList">
		<li><a href="JavaScript:void(0);" onclick="performAction('save');" >Save</a></li>
		<?php if($athleteid != 0) : ?>		
			<?php $pageTitle = 'Edit Athlete Profile'; ?>
			<li><a href="JavaScript:void(0);" onclick="$('#delLink').fadeIn(2000);" >Delete</a></li>
			<li><a href="JavaScript:void(0);" onclick="performAction('report');" >View Report</a></li>
		<?php endif; ?>
		<li><a href="/dashboard/" >Return to Dashboard</a></li>
	</ul>
	<div id="delLink" class="confirm hide" style="margin-right: 260px;">Are you sure?&nbsp;
		<span><a href="JavaScript:void(0);" class="close" >No</a></span>&nbsp;&nbsp;
		<span><a href="JavaScript:void(0);" onclick="performAction('delete');" >Yes</a></span>
	</div>
</div>
<h1>Event Specialties and Personal Bests</h1>
<h5 class="contentHeaderMargin"><?php echo $subTitle ?></h5>
<?php echo form_open('', $frmAttributes); ?>
			<select id="pb_view" name="pb_view" class="contentHeaderMargin">
				<option value="some">Show only the athlete's specialties</option>
				<option value="all">Show all events</option>
			</select>
			<table class="dashboard full">
				<tr>
					<td class="col1" style="width: 48%;" >
						<div>
							<fieldset>
								<legend>Track Events</legend>
								<div class="innertube">
									<table id="trackevents" class="dataTable full" >
										<tbody>
											<tr><td></td><td>Format (mm:ss.xx)</td></tr>
											<?php echo $allTrackEvents; ?>
										</tbody>
									</table>
								</div>
							</fieldset>
						</div>
					</td>
					<td class="spacer" ></td>
					<td class="col2" style="width: 48%;">
						<div>
							<fieldset>
								<legend>Field Events</legend>
								<div class="innertube">
									<table id="fieldevents" class="dataTable full" >
										<tbody>
											<tr><td></td><td>Format (xx-xx.xx)</td>
											<?php echo $allFieldEvents; ?>
										</tbody>
									</table>
								</div>
							</fieldset>
						</div>
					</td>
				</tr>
			</table>
	<input type="hidden" name="personalBests" id="personalBests" value="" />
	<input type="hidden" name="mySpecialties" id="mySpecialties" value="" />
	<input type="hidden" name="athleteid" id="athleteid" value="<?php echo $athleteid; ?>" />
<?php echo form_close(); ?>
<!-- END: edit_athlete -->
