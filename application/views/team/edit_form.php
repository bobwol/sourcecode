<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	$pageTitle = 'Edit General Information';
	$frmAttributes	= array('id' => 'frmTeamInfo', 'name' => 'frmTeamInfo', 'class' => 'editForm');
	$teamid			= set_value('teamid', isset($teamInfo->teamid) ? $teamInfo->teamid : '');
	$orgName		= set_value('orgName', isset($teamInfo->orgName) ? $teamInfo->orgName : '');
	$type				= set_value('type', isset($teamInfo->type) ? $teamInfo->type : '');
	$mascot			= set_value('mascot', isset($teamInfo->mascot) ? $teamInfo->mascot : '');
	$venue			= set_value('venue', isset($teamInfo->venue) ? $teamInfo->venue : '');
	$address1		= set_value('address1', isset($teamInfo->address1) ? $teamInfo->address1 : '');
	$address2		= set_value('address2', isset($teamInfo->address2) ? $teamInfo->address2 : '');
	$city				= set_value('city', isset($teamInfo->city) ? $teamInfo->city : '');
	$state			= set_value('state', isset($teamInfo->state) ? $teamInfo->state : '');
	$zip				= set_value('zip', isset($teamInfo->zip) ? $teamInfo->zip : '');
	$contactName	= set_value('contactName', isset($teamInfo->contactName) ? $teamInfo->contactName : '');
	$contactEmail	= set_value('contactEmail', isset($teamInfo->contactEmail) ? $teamInfo->contactEmail : '');
	$contactPhone	= set_value('contactPhone', isset($teamInfo->contactPhone) ? $teamInfo->contactPhone : '');
	$frmAction	= set_value('frmAction', isset($frmAction) ? $frmAction : 'insert');
	$addlMenuOptions = '';
	if($teamid != 0) {	
		$pageTitle = 'Edit General Information';
		$frmAction	= set_value('frmAction', isset($frmAction) ? $frmAction : 'update');
		$addlMenuOptions = $addlMenuOptions.'<li><a href="JavaScript:void(0);" onclick="performAction(\'report\');" >View Report</a></li>';
	}
?>
<!-- START: edit_form -->
<script>
	$(function(){
		setSelect(document.getElementById('type'), '<?php echo $type; ?>');
		setSelect(document.getElementById('state'), '<?php echo $state; ?>');
	});
	function performAction(selectedAction) {
		switch(selectedAction.toUpperCase()) {
			case "SAVE":
				document.getElementById('frmTeamInfo').submit();
				break;
			case 'REPORT':
				document.getElementById('frmTeamInfo').action = '/team/report/<?php echo $teamid; ?>';
				document.getElementById('frmTeamInfo').submit();
				break;
		}
	}
</script>

<!-- Page section: topRegion -->
<div class="topRegion">
	<ul class="hList">
		<li><a href="JavaScript:void(0);" onclick="performAction('save');" >Save</a></li>
		<?php echo $addlMenuOptions ?>
		<li><a href="/dashboard/" >Return to Dashboard</a></li>
	</ul>
</div>

<!-- Page section: pgHeading -->
<div class="pgHeading">
	<h1><?php echo $pageTitle ?></h1>
</div>

<!-- Page section: editForm -->
<?php echo form_open($this->uri->uri_string(), $frmAttributes); ?>
	<table class="frm full" >	
		<tbody>
			<tr>
				<th><label for="organizationName">Organization name / type</label></th>
				<td><input type="text" name="orgName" id="orgName" size="50" maxlength="45" value="<?php echo $orgName; ?>" />
					Type: <select name="type" id="type" ><option value="">Select organization type...</option><option value="HS">High School</option><option value="IC">Intercollegiate</option><option value="TC">Track Club</option></select>
					<?php echo '<div class="errMsg">'.form_error('orgName').form_error('type').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="mascot">Mascot</th>
				<td><input type="text" name="mascot" id="mascot" size="50" maxlength="45" value="<?php echo $mascot; ?>" />
					<?php echo '<div class="errMsg">'.form_error('mascot').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="venue">Venue</th>
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
						<option value="" selected="selected">Select state...</option>
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
						<option value="IT">International location</option>
					</select>
					<input type="text" name="zip" id="zip" size="5" maxlength="5" value="<?php echo $zip; ?>" />
						<?php echo '<div class="errMsg">'.form_error('city').form_error('state').form_error('zip').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="contactName">Contact Name</label></th>
				<td ><input type="text" name="contactName" id="contactName" size="50" maxlength="45" value="<?php echo $contactName; ?>" />
					<?php echo '<div class="errMsg">'.form_error('contactName').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="contactEmail">Contact Email</label></th>
				<td ><input type="text" name="contactEmail" id="contactEmail" size="50" maxlength="45" value="<?php echo $contactEmail; ?>" />
					<?php echo '<div class="errMsg">'.form_error('contactEmail').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="contactPhone">Contact Phone</label></th>
				<td ><input type="text" name="contactPhone" id="contactPhone" size="50" maxlength="15" value="<?php echo $contactPhone; ?>" />
					<?php echo '<div class="errMsg">'.form_error('contactPhone').'</div>'; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="teamid" id="teamid" size="11" value="<?php echo $teamid; ?>" >
	<input type="hidden" name="frmAction" id="frmAction" size="11" value="<?php echo $frmAction; ?>" >
<?php echo form_close(); ?>
<!-- END: edit_form -->
