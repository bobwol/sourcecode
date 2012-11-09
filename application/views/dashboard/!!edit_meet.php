<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
	$frmAttributes= array('id' => 'frmMeetInfo', 'name' => 'frmMeetInfo', 'class' => 'editForm');
	$meetID				= set_value('meetID', isset($meetInfo->meetID) ? $meetInfo->meetID : 0);
	$meetTitle		= set_value('meetTitle', isset($meetInfo->meetTitle) ? $meetInfo->meetTitle : '');
	$meetType			= set_value('meetType', isset($meetInfo->meetType) ? $meetInfo->meetType : 'dual');
	$venue				= set_value('venue', isset($meetInfo->venue) ? $meetInfo->venue : $this->session->userdata('venue'));
	$address1			= set_value('address1', isset($meetInfo->address1) ? $meetInfo->address1 : $this->session->userdata('address1'));
	$address2			= set_value('address2', isset($meetInfo->address2) ? $meetInfo->address2 : $this->session->userdata('address2'));
	$city					= set_value('city', isset($meetInfo->city) ? $meetInfo->city : $this->session->userdata('city'));
	$state				= set_value('state', isset($meetInfo->state) ? $meetInfo->state : $this->session->userdata('state'));
	$zip					= set_value('zip', isset($meetInfo->zip) ? $meetInfo->zip : $this->session->userdata('zip'));
	$contactName	= set_value('contactName', isset($meetInfo->contactName) ? $meetInfo->contactName : $this->session->userdata('contactName'));
	$contactEmail	= set_value('contactEmail', isset($meetInfo->contactEmail) ? $meetInfo->contactEmail : $this->session->userdata('contactEmail'));
	$contactPhone	= set_value('contactPhone', isset($meetInfo->contactPhone) ? $meetInfo->contactPhone : $this->session->userdata('contactPhone'));
	$points1st 		= set_value('points1st', isset($meetInfo->points1st) ? $meetInfo->points1st : 0);
	$points2nd 		= set_value('points2nd', isset($meetInfo->points2nd) ? $meetInfo->points2nd : 0);
	$points3rd 		= set_value('points3rd', isset($meetInfo->points3rd) ? $meetInfo->points3rd : 0);
	$points4th 		= set_value('points4th', isset($meetInfo->points4th) ? $meetInfo->points4th : 0);
	$points5th 		= set_value('points5th', isset($meetInfo->points5th) ? $meetInfo->points5th : 0);
	$points6th 		= set_value('points6th', isset($meetInfo->points6th) ? $meetInfo->points6th : 0);
	$points7th 		= set_value('points7th', isset($meetInfo->points7th) ? $meetInfo->points7th : 0);
	$points8th 		= set_value('points8th', isset($meetInfo->points8th) ? $meetInfo->points8th : 0);
	$points9th 		= set_value('points9th', isset($meetInfo->points9th) ? $meetInfo->points9th : 0);
	$points10th 	= set_value('points10th', isset($meetInfo->points10th) ? $meetInfo->points10th : 0);
	$scores 			= set_value('scores', isset($meetInfo->scores) ? $meetInfo->scores : '');
	$participantInfo	= set_value('participantInfo', isset($meetInfo->participantInfo) ? $meetInfo->participantInfo : '');
	$spectatorInfo		= set_value('spectatorInfo', isset($meetInfo->spectatorInfo) ? $meetInfo->spectatorInfo : '');
	$published		= set_value('published', isset($meetInfo->published) ? $meetInfo->published : 0);
	$setSelectStatements = '';
	$pageTitle = 'Add a New Meet';
	$meetDiv = array();
	$maxDivs = $this->session->userdata('maxDivs');
	$n_divs = '';
	$numOfDivs		= set_value('numOfDivs', isset($meetDivs) ? sizeof($meetDivs) : 2);
	$orgNumOfDivs	= set_value('orgNumOfDivs', $numOfDivs);
	$meetDay = array();
	$maxDays = $this->session->userdata('maxDays');
	$n_days = '';
	$numOfDays		= set_value('numOfDays', isset($meetDates) ? sizeof($meetDates) : 1);
	$orgNumOfDays	= set_value('orgNumOfDays', $numOfDays);
	
	if(isset($meetDivs))
	{
		foreach($meetDivs as $dv) 
		{
			$meetDiv[$dv->divisionID] = array(
				'genderDiv' => $dv->gender, 
				'divName' => $dv->description 
			);
		}
	}
	for($i=1; $i<=$maxDivs; $i++)
	{
		$divName = set_value('divName'.$i, isset($meetDiv[$i]['divName']) ? $meetDiv[$i]['divName'] : '');
		$n_divs = $n_divs.'<div id="Division'.$i.'" class="stackedBoxes hide" ><select name="genderDiv'.$i.'" id="genderDiv'.$i.'" size="1"><option value="Mens" selected="selected">Mens</option><option value="Womens">Womens</option><option value="Boys">Boys</option><option value="Girls">Girls</option></select><input type="text" name="divName'.$i.'" id="divName'.$i.'" size="25" value="'.$divName.'" >';
		$nextrec = $i+1;
		switch ($i)
		{
			case 1:
				$n_divs = $n_divs.'<span id="addDivLink1" class="labelSpacing" ><a href="JavaScript:void(0);" onclick="divisionList(1, 2);" >Add more divisions</a></span>';
				break;
			case $maxDivs:
				$n_divs = $n_divs.'<span id="addDivLink'.$i.'" class="labelSpacing" >Max '.$i.' divisions or age groups<span class="divider">|</span><a href="JavaScript:void(0);" onclick="divisionList( 0, '.$i.');" >Remove this division</a></span>';
				break;
			default:
				$n_divs = $n_divs.'<span id="addDivLink'.$i.'" class="labelSpacing" ><a href="JavaScript:void(0);" onclick="divisionList(1, '.$nextrec.');" >Add more divisions</a><span class="divider">|</span><a href="JavaScript:void(0);" onclick="divisionList(0, '.$i.');" >Remove this division</a></span>';			
		}
		$n_divs = $n_divs."</div>\n\t\t\t\t\t";
		$setSelectStatements = $setSelectStatements.'setSelect(document.getElementById("genderDiv'.$i.'"), "'.set_value("genderDiv".$i, isset($meetDiv[$i]['genderDiv']) ? $meetDiv[$i]['genderDiv'] : '').'");';
		$setSelectStatements = $setSelectStatements."\n\t\t";
	}
	$n_divs = $n_divs."\n";

	if(isset($meetDates))
	{
		foreach($meetDates as $dt)
		{
			$meetDay[$dt->day] = array(
				'startDate' => date( 'm/d/Y' ,strtotime($dt->startDate)), 
				'startTimeTRACK' => date('g:i' ,strtotime($dt->startTimeTE)), 
				'startTimeFIELD' => date('g:i' ,strtotime($dt->startTimeFE)),
				'startTimeTRACK_AMPM' => date('A' ,strtotime($dt->startTimeTE)), 
				'startTimeFIELD_AMPM' => date('A' ,strtotime($dt->startTimeFE))
			);
		}
	}
	for($i=1; $i<=$maxDays; $i++)
	{
		$day = set_value('meetDay'.$i, isset($meetDay[$i]['startDate']) ? $meetDay[$i]['startDate'] : 'mm/dd/yyyy');
		$startTimeTRACK = set_value('startTimeTRACKDay'.$i, isset($meetDay[$i]['startTimeTRACK']) ? $meetDay[$i]['startTimeTRACK'] : 'hh:mm');
		$startTimeFIELD = set_value('startTimeFIELDDay'.$i, isset($meetDay[$i]['startTimeFIELD']) ? $meetDay[$i]['startTimeFIELD'] : 'hh:mm');
		$n_days = $n_days.'<div id="meetDay'.$i.'info" class="stackedBoxes hide" ><input type="text" class="meetDateSel datePicker" name="meetDay'.$i.'" id="meetDay'.$i.'" size="9" value="'.$day.'" /><label for="startTimeTRACKDay'.$i.'" class="labelSpacing" >Track:</label><input type="text" name="startTimeTRACKDay'.$i.'" id="startTimeTRACKDay'.$i.'" value="'.$startTimeTRACK.'" size="5" maxlength="5" /><select class="ampm" name="startTimeTRACKDay'.$i.'_AMPM" id="startTimeTRACKDay'.$i.'_AMPM"><option value="AM" selected="selected">AM</option><option value="PM">PM</option></select><label for="startTimeFIELDDay'.$i.'" class="labelSpacing" >Field:</label><input type="text" name="startTimeFIELDDay'.$i.'" id="startTimeFIELDDay'.$i.'" value="'.$startTimeFIELD.'" size="5" maxlength="5" /><select class="ampm" name="startTimeFIELDDay'.$i.'_AMPM" id="startTimeFIELDDay'.$i.'_AMPM"><option value="AM" selected="selected">AM</option><option value="PM">PM</option></select>';
		$nextrec = $i+1;
		switch ($i)
		{
			case 1:
				$n_days = $n_days.'<span id="addDayLink1" class="labelSpacing" ><a href="JavaScript:void(0);" onclick="meetDayList(1, 2);" >Add more days</a></span>';
				break;
			case $maxDays:
				$n_days = $n_days.'<span id="addDayLink'.$i.'" class="labelSpacing" >Max '.$i.' days<span class="divider">|</span><a href="JavaScript:void(0);" onclick="meetDayList( 0, '.$i.');" >Remove this day</a></span>';
				break;
			default:
				$n_days = $n_days.'<span id="addDayLink'.$i.'" class="labelSpacing" ><a href="JavaScript:void(0);" onclick="meetDayList(1, '.$nextrec.');" >Add more days</a><span class="divider">|</span><a href="JavaScript:void(0);" onclick="meetDayList(0, '.$i.');" >Remove this day</a></span>';			
		}
		$n_days = $n_days."</div>\n\t\t\t\t\t";
		$setSelectStatements = $setSelectStatements.'setSelect(document.getElementById("startTimeTRACKDay'.$i.'_AMPM"), "'.set_value("startTimeTRACKDay".$i."_AMPM", isset($meetDay[$i]['startTimeTRACK_AMPM']) ? $meetDay[$i]['startTimeTRACK_AMPM'] : '').'");';
		$setSelectStatements = $setSelectStatements."\n\t\t";
		$setSelectStatements = $setSelectStatements.'setSelect(document.getElementById("startTimeFIELDDay'.$i.'_AMPM"), "'.set_value("startTimeFIELDDay".$i."_AMPM", isset($meetDay[$i]['startTimeFIELD_AMPM']) ? $meetDay[$i]['startTimeFIELD_AMPM'] : '').'");';
		$setSelectStatements = $setSelectStatements."\n\t\t";
	}
	$n_days = $n_days."\n";

?>

<!-- START: edit_meet -->
<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script>
	$(function(){
		var numOfDays = '<?php echo $numOfDays ?>';
		var numOfDivs = '<?php echo $numOfDivs ?>';
		setSelect(document.getElementById('published'), '<?php echo $published; ?>');
		setSelect(document.getElementById('meetType'), '<?php echo $meetType; ?>');
		setSelect(document.getElementById('state'), '<?php echo $state; ?>');
		<?php echo $setSelectStatements ?>
		
		for(i=1; i <= numOfDays; i++) {
			document.getElementById('meetDay'+i+'info').style.display = 'block';
			if(i!=1) { document.getElementById('addDayLink'+(i-1)).style.display = 'none'; }
		}

		for(i=1; i <= numOfDivs; i++) {
			document.getElementById('Division'+i).style.display = 'block';
			if(i!=1) { document.getElementById('addDivLink'+(i-1)).style.display = 'none'; }
		}
		document.getElementById('meetTitle').focus();
	});

	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		skin_variant : "silver",
		editor_selector : "tinymce",

		// Theme options
		//theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontsizeselect,bullist,numlist,undo,redo,|,link,unlink,cleanup,code,|,forecolor,backcolor",
	    theme_advanced_buttons1 : "bold,italic,underline,fontsizeselect,forecolor,backcolor,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,separator,link,unlink,separator,undo,redo",
	    theme_advanced_buttons2 : "",
	    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Skin options

		// Example content CSS
		//content_css : "/css/nallitrack-editor.css",
	});
		
	function performAction(selectedAction) {
		switch(selectedAction.toUpperCase()) {
			case 'SAVE':
				if((document.getElementById('meetType').value == "dual") && (parseInt(document.getElementById('numOfDays').value) > 1)){
					alert('Error: Only invitationals or championship meets can span multipule days');
				} else{ 
					document.getElementById('frmMeetInfo').action = '/dashboard/edit_meet';
					document.getElementById('frmMeetInfo').submit();
				}
				break;
			case 'GENERATE':
				document.getElementById('frmMeetInfo').action = '/dashboard/generate_schedule';
				document.getElementById('frmMeetInfo').submit();
				break;
			case 'ADJUST':
				document.getElementById('frmMeetInfo').action = '/dashboard/adjust_schedule';
				document.getElementById('frmMeetInfo').submit();
				break;
			case 'ASSIGN':
				document.getElementById('frmMeetInfo').action = '/dashboard/assign_athletes';
				document.getElementById('frmMeetInfo').submit();
				break;
			case 'DELETE':
				document.getElementById('frmMeetInfo').action = '/dashboard/delete_meet';
				document.getElementById('frmMeetInfo').submit();
				break;
		}
	}
	
	function meetDayList(isIncrement, meetDay) {
		if(isIncrement) {
			$('#meetDay'+meetDay+'info').fadeIn('fast');
			$('#addDayLink'+(meetDay-1)).fadeOut('fast');
			document.getElementById('numOfDays').value=meetDay;
		} else {
			$('#addDayLink'+(meetDay-1)).fadeIn('fast');
			$('#meetDay'+meetDay+'info').fadeOut('fast');
			document.getElementById('numOfDays').value=(meetDay-1);	
		}
	}	

	function divisionList(isIncrement, divNo) {
		if(isIncrement) {
			$('#Division'+divNo).fadeIn('slow');
			$('#addDivLink'+(divNo-1)).fadeOut('slow');
			document.getElementById('numOfDivs').value=divNo;
		} else {
			$('#addDivLink'+(divNo-1)).fadeIn('slow');
			$('#Division'+divNo).fadeOut('slow');
			document.getElementById('numOfDivs').value=(divNo-1);
		}
	}
</script>

<div class="topRegion">
	<ul class="hList">
		<li><a href="JavaScript:void(0);" onclick="performAction('save');" >Save</a></li>
		<?php if($meetID != 0) : ?>		
			<?php $pageTitle = 'Edit Meet Information'; ?>
			<li><a href="JavaScript:void(0);" onclick="$('#delLink').fadeIn(2000);" >Delete</a></li>
			<li><a href="JavaScript:void(0);" onclick="performAction('generate');"  >Generate Schedule</a></li>
			<?php if(isset($hasEventsScheduled)) : ?>
			<?php if($hasEventsScheduled) : ?>
				<li><a href="JavaScript:void(0);" onclick="performAction('adjust');"  >Adjust Schedule</a></li>
			<?php endif; ?>
			<?php endif; ?>
			<li><a href="JavaScript:void(0);" onclick="performAction('assign');" >Assign Athletes</a></li>
			<li><a href="/meetfinder/view_meet/<?php echo $meetID ?>">View Report</a></li>
		<?php endif; ?>
		<li><a href="/dashboard/" >Return to Dashboard</a></li>
	</ul>
	<div id="delLink" class="confirm hide" style="margin-right: 320px;">Are you sure?&nbsp;
		<span><a href="JavaScript:void(0);" class="close" >No</a></span>&nbsp;&nbsp;
		<span><a href="JavaScript:void(0);" onclick="performAction('delete');" >Yes</a></span>
	</div>
</div>
<h1 class="contentHeaderMargin"><?php echo $pageTitle ?></h1>

<?php echo form_open($this->uri->uri_string(), $frmAttributes); ?>
	<table class="frm full" >	
		<tbody>
			<tr>
				<th><label for="meetTitle">Meet Title</label></th>
				<td><input type="text" name="meetTitle" id="meetTitle" size="50" maxlength="90" value="<?php echo $meetTitle; ?>" />
						Published: <select name="published" id="published" ><option value="0">No</option><option value="1">Yes</option></select>
						<?php echo '<div class="errMsg">'.form_error('meetTitle').form_error('published').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="meetType">Meet Type</label></th>
				<td>
					<select name="meetType" id="meetType" >
					<option value="dual">Dual, tri or quad team meet</option>
					<option value="inv">Multi-team invitational</option>
					<option value="chp">League, region, or state championship meet</option>
					</select>
					<?php echo '<div class="errMsg">'.form_error('meetType').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="divName1">Divisions / Age Groups</label></th>
				<td>
					<?php echo $n_divs; ?>
					<?php echo '<div class="errMsg">'.form_error('genderDiv1').form_error('divName1').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="meetDay1">Dates / Times</label></th>
				<td>
					<?php echo $n_days ?>
					<?php echo '<div class="errMsg">'.form_error('meetDay1').form_error('startTimeTRACKDay1').form_error('startTimeTRACKDay1_AMPM').form_error('startTimeFIELDDay1').form_error('startTimeFIELDDay1_AMPM').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="venue">Venue</label></th>
				<td><input type="text" name="venue" id="venue" size="50" maxlength="60" value="<?php echo $venue; ?>" />
					<?php echo '<div class="errMsg">'.form_error('venue').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="address1">Address 1</label></th>
				<td><input type="text" name="address1" id="address1" size="50" maxlength="45" value="<?php echo $address1; ?>" />
					<?php echo '<div class="errMsg">'.form_error('address1').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="address2">Address 2</label></th>
				<td ><input type="text" name="address2" id="address2" size="50" maxlength="45" value="<?php echo $address2; ?>" />
					<?php echo '<div class="errMsg">'.form_error('address2').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="city">City, State Zip</label></th>
				<td>
					<input type="text" name="city" id="city" size="30" maxlength="45" value="<?php echo $city; ?>" />
					<select name="state" id="state">
						<option value="">Select state...</option>
						<option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="DC">District of Columbia</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
						<option value="PR">Puerto Rico</option>
						<option value="VI">Virgin Islands</option>										
						<option value="Intl">International location</option>
					</select>
					<input type="text" name="zip" id="zip" size="5" maxlength="5" value="<?php echo $zip; ?>" />
					<?php echo '<div class="errMsg">'.form_error('city').form_error('state').form_error('zip').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="contactName">Contact Name</label></th>
				<td><input type="text" name="contactName" id="contactName" size="50" maxlength="45" value="<?php echo $contactName; ?>" />
					<?php echo '<div class="errMsg">'.form_error('contactName').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="contactEmail">Contact Email</label></th>
				<td><input type="text" name="contactEmail" id="contactEmail" size="50" maxlength="45" value="<?php echo $contactEmail; ?>" />
					<?php echo '<div class="errMsg">'.form_error('contactEmail').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="contactPhone">Contact Phone</label></th>
				<td><input type="text" name="contactPhone" id="contactPhone" size="50" maxlength="45" value="<?php echo $contactPhone; ?>" />
					<?php echo '<div class="errMsg">'.form_error('contactPhone').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th style="width: 170px;"><label for="scores">Scoring</label></th>
				<td>
					<table>
						<thead>
							<tr>
								<th><div class="alignCt">1st</div></th>
								<th><div class="alignCt">2nd</div></th>
								<th><div class="alignCt">3rd</div></th>
								<th><div class="alignCt">4th</div></th>
								<th><div class="alignCt">5th</div></th>
								<th><div class="alignCt">6th</div></th>
								<th><div class="alignCt">7th</div></th>
								<th><div class="alignCt">8th</div></th>
								<th><div class="alignCt">9th</div></th>
								<th><div class="alignCt">10th</div></th>
							<tr>
						</thead>
						<body>
							<tr>
								<td><input type="text" name="points1st" id="points1st" size="3" maxlength="2" value="<?php echo $points1st; ?>" /></td>
								<td><input type="text" name="points2nd" id="points2nd" size="3" maxlength="2" value="<?php echo $points2nd; ?>" /></td>
								<td><input type="text" name="points3rd" id="points3rd" size="3" maxlength="2" value="<?php echo $points3rd; ?>" /></td>
								<td><input type="text" name="points4th" id="points4th" size="3" maxlength="2" value="<?php echo $points4th; ?>" /></td>
								<td><input type="text" name="points5th" id="points6th" size="3" maxlength="2" value="<?php echo $points5th; ?>" /></td>
								<td><input type="text" name="points6th" id="points6th" size="3" maxlength="2" value="<?php echo $points6th; ?>" /></td>
								<td><input type="text" name="points7th" id="points7th" size="3" maxlength="2" value="<?php echo $points7th; ?>" /></td>
								<td><input type="text" name="points8th" id="points8th" size="3" maxlength="2" value="<?php echo $points8th; ?>" /></td>
								<td><input type="text" name="points9th" id="points9th" size="3" maxlength="2" value="<?php echo $points9th; ?>" /></td>
								<td><input type="text" name="points10th" id="points10th" size="3" maxlength="2" value="<?php echo $points10th; ?>" /></td>
							</tr>
						</tbody>
					</table>
					<?php echo '<div class="errMsg">'.form_error('points1st').form_error('points2nd').form_error('points3rd').form_error('points4th').form_error('points5th').form_error('points6th').form_error('points7th').form_error('points8th').form_error('points9th').form_error('points10th').'</div>'; ?><br />				
				</td>
			</tr>
			<tr>
				<th style="width: 170px;" ><label for="spectatorInfo">Info for Attendees</label></th>
				<td><textarea name="spectatorInfo" id="spectatorInfo" rows="8" cols="80" class="tinymce"><?php echo $spectatorInfo; ?></textarea>
					<?php echo '<div class="errMsg">'.form_error('spectatorInfo').'</div>'; ?><br />
				</td>
			</tr>
			<tr>
				<th style="width: 170px;"><label for="participantInfo">Info for Coaches and Athletes</label></th>
				<td><textarea name="participantInfo" id="participantInfo" rows="8" cols="80" class="tinymce"><?php echo $participantInfo; ?></textarea>
					<?php echo '<div class="errMsg">'.form_error('participantInfo').'</div>'; ?><br />
				</td>
			</tr>
			<tr>
				<th style="width: 170px;"><label for="scores">Team Scores</label></th>
				<td><textarea name="scores" id="scores" rows="8" cols="80" class="tinymce"><?php echo $scores; ?></textarea>
					<?php echo '<div class="errMsg">'.form_error('scores').'</div>'; ?><br />
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="numOfDays" id="numOfDays" value="<?php echo $numOfDays; ?>" />
	<input type="hidden" name="numOfDivs" id="numOfDivs" value="<?php echo $numOfDivs; ?>" />
	<input type="hidden" name="orgNumOfDays" id="orgNumOfDays" value="<?php echo $orgNumOfDays; ?>" />
	<input type="hidden" name="orgNumOfDivs" id="orgNumOfDivs" value="<?php echo $orgNumOfDivs; ?>" />
	<input type="hidden" name="meetID" id="meetID" value="<?php echo $meetID; ?>" />
<?php echo form_close(); ?>
<!-- END: edit_meet -->
