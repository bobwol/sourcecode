<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	$frmAttributes = array('id' => 'frmArrangeEvents', 'name' => 'frmArrangeEvents', 'class' => 'editForm');
	$divOptions = '';
	$tbl = '';
	$delimiter = '';
	foreach($meetDivs as $dv)
	{
		$divOptions = $divOptions.'<option value="'.$dv->gender.'_'.$dv->divisionID.'">'.$dv->gender.' '.$dv->description.'</option>';
	}
	for($i = 1; $i <= $noOfDays; $i++)
	{
		$tbl = $tbl.$delimiter."'trackevents".$i."', 'fieldevents".$i."'";
		$delimiter=', ';
	}
?>

<!-- START: arrange_events -->
<script type="text/javascript" src="http://nallitrack.com/js/tablednd.js"></script>	
<script>
	$(function(){		
	<?php 
	for($i = 1; $i <= $noOfDays; $i++)
	{
		echo "var tableDnD_track".$i." = new TableDnD();\n";
		echo "var tableDnD_field".$i." = new TableDnD();\n";
		echo "var trackevents".$i." = document.getElementById('trackevents".$i."');\n";
		echo "var fieldevents".$i." = document.getElementById('fieldevents".$i."');\n";
		echo "tableDnD_track".$i.".init(trackevents".$i.");\n";
		echo "tableDnD_field".$i.".init(fieldevents".$i.");\n";
		foreach($trackEvent as $event)
		{
			echo "setSelect(document.getElementById('trackevents".$i."_t_".$event->eventID."'), '".$event->allocatedTime."');\n\t\t";
			if($event->forOutdoorSeason) {
				if($event->forMen) {
					echo "setSelect(document.getElementById('trackevents".$i."_p_".$event->eventID."'), 'Boys', '_');\n\t\t";
					echo "setSelect(document.getElementById('trackevents".$i."_p_".$event->eventID."'), 'Mens', '_');\n\t\t";
				}
				if($event->forWomen) {
					echo "setSelect(document.getElementById('trackevents".$i."_p_".$event->eventID."'), 'Girls', '_');\n\t\t";
					echo "setSelect(document.getElementById('trackevents".$i."_p_".$event->eventID."'), 'Womens', '_');\n\t\t";
				}
			}
		}
		foreach($fieldEvent as $event)
		{
			echo "setSelect(document.getElementById('fieldevents".$i."_t_".$event->eventID."'), '".$event->allocatedTime."');\n\t\t";
			if($event->forOutdoorSeason) {
				if($event->forMen) {
					echo "setSelect(document.getElementById('fieldevents".$i."_p_".$event->eventID."'), 'Boys', '_');\n\t\t";
					echo "setSelect(document.getElementById('fieldevents".$i."_p_".$event->eventID."'), 'Mens', '_');\n\t\t";
				}
				if($event->forWomen) {
					echo "setSelect(document.getElementById('fieldevents".$i."_p_".$event->eventID."'), 'Girls', '_');\n\t\t";
					echo "setSelect(document.getElementById('fieldevents".$i."_p_".$event->eventID."'), 'Womens', '_');\n\t\t";
				}
			}
		}
	}
	?>
	
	});

	function performAction(selectedAction) {
		switch(selectedAction.toUpperCase()) {
			case 'SAVE':
				collectData();
				document.getElementById('frmArrangeEvents').action = '/meet/regenerate_event_sched';
				document.getElementById('frmArrangeEvents').submit();
				break;
		}
	}
	
	function collectData() {
		var divisionID=new Array();
		var divGender=new Array();
		var tableName = [<?php echo $tbl; ?>];
		var numTables = tableName.length;
		var schedEntries = '';
		var meetEvents = '';
		var meetid = <?php echo $meetID; ?>;
		var mDay = 1;
		var eventOrder = 1;
		var allocatedTime = '';
		var eventID = '';
		var delimiter = '';
		var opt = new Array(); 
		var eventArr = new Array(); 
		
		for(var x=0; x < numTables; x++) {	
			tblObj = document.getElementById(tableName[x]);
			eventOrder = 1;
			mDay = Math.round((x+1)/2);
			for (var i = 0, row; row = tblObj.rows[i]; i++) {    //iterate through rows 
				if (i>0) {
					eventID = row.id.substr(5);
					allocatedTime = getSelect(document.getElementById(tableName[x]+'_t_'+eventID));
					selParticipants = document.getElementById(tableName[x]+'_p_'+eventID);
					//(!meetID, !day, !eventOrder, !allocatedTime, !eventID, !divisionID)
					for (var j = 0; j < selParticipants.options.length; j++)  {
						if (selParticipants.options[j].selected) {
							opt = selParticipants.options[j].value.split('_');
							schedEntries = schedEntries+delimiter+"("+meetid+", "+mDay+", "+eventOrder+", "+allocatedTime+", '"+eventID+"', "+opt[1]+" )";
							if($.inArray(eventID, eventArr) == -1){
								meetEvents = meetEvents+delimiter+"("+meetid+", '"+eventID+"' )";
								eventArr.push(eventID);
							}
							eventOrder++;
							delimiter=",\n";
						}
					}
				}
			}
		}
		document.getElementById('schedEntries').value = schedEntries+";";
		document.getElementById('meetEvents').value = meetEvents+";";
	}

	function reOrder(table) {
		for (var i = 0, row; row = table.rows[i]; i++) {    //iterate through rows 
			if (i>0) {
				row.cells[0].innerHTML = i;
			}
		}
	}
</script>

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

<div class="pgHeading">
	<h1>Generate Schedule</h1>
	<h5 class="contentHeaderMargin"><?php echo $meetTitle ?></h5>
</div>

<ol style="margin-bottom: 15px;">
	<li>For each day:</li>
	<li>&nbsp;&nbsp;1. Select the participants for each event, multiple selections are allowed (Ctrl-Click). No participants means the event won't be scheduled.</li>
	<li>&nbsp;&nbsp;2. Order the events by clicking on the event name and dragging it to it correct position.</li>
	<li>&nbsp;&nbsp;3. For each event, select the amount of time allocated to execute one flight of the event.</li> 
	<li><br/>Click "Save" to generate a new schedule of events for this meet.</li> 
	<?php if($numberOfEvents) : ?>
	<li><span style="color: red;">**WARNING: </span>You have schedule entries for this meet already. Clicking "Save" will delete the existing schedule and generate a new one.</li> 
	<?php endif; ?>
</ol>

<?php echo form_open('', $frmAttributes); ?>
	<input type="hidden" name="schedEntries" id="schedEntries" value="" />
	<input type="hidden" name="meetEvents" id="meetEvents" value="" />
	<input type="hidden" name="meetTitle" id="meetTitle" value="<?php echo $meetTitle ?>" />
	<input type="hidden" name="meetID" id="meetID" value="<?php echo $meetID; ?>" />
<?php echo form_close(); ?>
<div class="tabs">
<ul>
<?php for($i = 1; $i <= $noOfDays; $i++) : ?>
	<li><a href="#tab-<?php echo $i; ?>">Events on day <?php echo $i; ?></a></li>
<?php endfor; ?>
</ul>
<?php for($i = 1; $i <= $noOfDays; $i++) : ?>
<div id="tab-<?php echo $i; ?>" >
	<br />
	<table class="dashboard full">
		<tr>
			<td class="col1" style="width: 48%;" >
				<div>
					<fieldset>
						<legend>Track Events</legend>
						<div class="innertube">
							<table id="trackevents<?php echo $i; ?>" class="dataTable full" >
								<thead>
									<tr>
										<th class="stdHdr" style="width: 10px;"></th>
										<th class="stdHdr" style="width: 100px;">Event Name</th>
										<th class="stdHdr" >Participants</th>
										<th class="stdHdr" >Allocated time</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($trackEvent as $event) : ?>
									<tr id="event<?php echo $event->eventID ?>">
										<td><?php echo $event->order ?></td>
										<td><?php echo $event->eventName ?></td>
										<td>
											<select MULTIPLE size="<?php echo sizeof($meetDivs); ?>" name="trackevents<?php echo $i; ?>_p_<?php echo $event->eventID ?>" id="trackevents<?php echo $i; ?>_p_<?php echo $event->eventID ?>">
												<?php echo $divOptions; ?>
											</select>
										</td>
										<td>
											<select name="trackevents<?php echo $i; ?>_t_<?php echo $event->eventID ?>" id="trackevents<?php echo $i; ?>_t_<?php echo $event->eventID ?>">
												<option value="0">0</option>
												<option value="3">3 min</option>
												<option value="4">4 min</option>
												<option value="5">5 min</option>
												<option value="6">6 min</option>
												<option value="7">7 min</option>
												<option value="8">8 min</option>
												<option value="9">9 min</option>
												<option value="10">10 min</option>
												<option value="11">11 min</option>
												<option value="12">12 min</option>
												<option value="13">13 min</option>
												<option value="14">14 min</option>
												<option value="15">15 min</option>
												<option value="16">16 min</option>
												<option value="17">17 min</option>
												<option value="18">18 min</option>
												<option value="19">19 min</option>
												<option value="20">20 min</option>
												<option value="21">21 min</option>
												<option value="22">22 min</option>
												<option value="23">23 min</option>
												<option value="24">24 min</option>
												<option value="25">25 min</option>
												<option value="26">26 min</option>
												<option value="27">27 min</option>
												<option value="28">28 min</option>
												<option value="29">29 min</option>
												<option value="30">30 min</option>
											</select>
										</td>
									</tr>
									<?php endforeach; ?>	
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
							<table id="fieldevents<?php echo $i; ?>" class="dataTable full" >
								<thead>
									<tr>
										<th class="stdHdr" style="width: 10px;"></th>
										<th class="stdHdr" style="width: 100px;">Event Name</th>
										<th class="stdHdr" >Participants</th>
										<th class="stdHdr" >Allocated time</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($fieldEvent as $event) : ?>
									<tr id="event<?php echo $event->eventID ?>">
										<td><?php echo $event->order; ?></td>
										<td><?php echo $event->eventName; ?></td>
										<td>
											<select MULTIPLE size="<?php echo sizeof($meetDivs); ?>" name="fieldevents<?php echo $i; ?>_p_<?php echo $event->eventID; ?>" id="fieldevents<?php echo $i; ?>_p_<?php echo $event->eventID; ?>">
												<?php echo $divOptions; ?>
											</select>
										</td>
										<td>
											<select name="fieldevents<?php echo $i; ?>_t_<?php echo $event->eventID; ?>" id="fieldevents<?php echo $i; ?>_t_<?php echo $event->eventID; ?>">
												<option value="0">0</option>
												<option value="3">3 min</option>
												<option value="4">4 min</option>
												<option value="5">5 min</option>
												<option value="6">6 min</option>
												<option value="7">7 min</option>
												<option value="8">8 min</option>
												<option value="9">9 min</option>
												<option value="10">10 min</option>
												<option value="11">11 min</option>
												<option value="12">12 min</option>
												<option value="13">13 min</option>
												<option value="14">14 min</option>
												<option value="15">15 min</option>
												<option value="16">16 min</option>
												<option value="17">17 min</option>
												<option value="18">18 min</option>
												<option value="19">19 min</option>
												<option value="20">20 min</option>
											</select>
										</td>
									</tr>
									<?php endforeach; ?>	
								</tbody>
							</table>
						</div>
					</fieldset>
				</div>
			</td>
		</tr>
	</table>
</div>
<?php endfor; ?>
</div>
<!-- END: arrange_events -->
