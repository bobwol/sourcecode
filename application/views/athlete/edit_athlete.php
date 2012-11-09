<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	$frmAttributes		= array('id' => 'frmAthleteProfile', 'name' => 'frmAthleteProfile', 'class' => 'editForm');
	$athleteid 			= set_value('athleteid', isset($athleteInfo->athleteid) ? $athleteInfo->athleteid : 0);
	$firstName 			= set_value('firstName', isset($athleteInfo->firstName) ? $athleteInfo->firstName : '');
	$lastName 			= set_value('lastName', isset($athleteInfo->lastName) ? $athleteInfo->lastName : '');
	$gender 				= set_value('gender', isset($athleteInfo->gender) ? $athleteInfo->gender : '');
	$dob	 				= set_value('dob', isset($athleteInfo->dob) ? date( 'm/d/Y' ,strtotime($athleteInfo->dob)) : '');
	$academicYear	 	= set_value('academicYear', isset($athleteInfo->academicYear) ? $athleteInfo->academicYear : 'Junior');
	$contactEmail		= set_value('contactEmail', isset($athleteInfo->contactEmail) ? $athleteInfo->contactEmail : '');
	$contactPhone 		= set_value('contactPhone', isset($athleteInfo->contactPhone) ? $athleteInfo->contactPhone : '');
	$alternateContact	= set_value('alternateContact', isset($athleteInfo->alternateContact) ? $athleteInfo->alternateContact : '');
	$alternateEmail 	= set_value('alternateEmail', isset($athleteInfo->alternateEmail) ? $athleteInfo->alternateEmail : '');
	$alternatePhone 	= set_value('alternatePhone', isset($athleteInfo->alternatePhone) ? $athleteInfo->alternatePhone : '');
	$relationship	 	= set_value('relationship', isset($athleteInfo->relationship) ? $athleteInfo->relationship : '');
	$pageTitle = 'Add a New Athlete';
?>
<!-- START: edit_athlete -->
<script>
	$(function(){
		setSelect(document.getElementById('gender'), '<?php echo $gender; ?>');
		setSelect(document.getElementById('academicYear'), '<?php echo $academicYear; ?>');
		setSelect(document.getElementById('relationship'), '<?php echo $relationship; ?>');		
	});

	function performAction(selectedAction) {
		var isValid = true;
		switch(selectedAction.toUpperCase()) {
			case 'SAVE':
				document.getElementById('frmAthleteProfile').action = '/dashboard/edit_athlete';
				document.getElementById('frmAthleteProfile').submit();
				break;
			case 'PERSONALBEST':
				document.getElementById('frmAthleteProfile').action = '/dashboard/edit_athlete_pb/';
				document.getElementById('frmAthleteProfile').submit();
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
			<li><a href="JavaScript:void(0);" onclick="performAction('personalBest');" >Edit Event Specialties and Personal Bests</a></li>
		<?php endif; ?>
		<li><a href="/dashboard/" >Return to Dashboard</a></li>
	</ul>
	<div id="delLink" class="confirm hide" style="margin-right: 260px;">Are you sure?&nbsp;
		<span><a href="JavaScript:void(0);" class="close" >No</a></span>&nbsp;&nbsp;
		<span><a href="JavaScript:void(0);" onclick="performAction('delete');" >Yes</a></span>
	</div>
</div>
<h1 class="contentHeaderMargin"><?php echo $pageTitle ?></h1>
<?php echo form_open('', $frmAttributes); ?>
	<table class="frm full contentHeaderMargin" >	
		<tbody>
			<tr>
				<th><label for="firstName">First Name</label></th>
				<td><input type="text" name="firstName" id="firstName" size="25" maxlength="20"  value="<?php echo set_value('firstName', isset($athleteInfo->firstName) ? $athleteInfo->firstName : ''); ?>" />
						 Last Name: <input type="text" name="lastName" id="lastName" size="25" maxlength="20" value="<?php echo $lastName; ?>" />
						<?php echo '<div class="errMsg">'.form_error('firstName').form_error('lastName').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="dob">DOB</label></th>
				<td ><input type="text" name="dob" id="dob" size="9"  class="datePicker" value="<?php echo $dob; ?>" />
						Gender: <select name="gender" id="gender" ><option value="M">Male</option><option value="F">Female</option></select>
						Academic Year: <select name="academicYear" id="academicYear" ><option value="Freshman">Freshman</option><option value="Sophomore">Sophomore</option><option value="Junior">Junior</option><option value="Senior">Senior</option><option value="N/A">N/A</option></select>
						<?php echo '<div class="errMsg">'.form_error('dob').form_error('gender').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="contactEmail">Contact Email</label></th>
				<td ><input type="text" name="contactEmail" id="contactEmail" size="50"  maxlength="45" value="<?php echo $contactEmail; ?>" />
					<?php echo '<div class="errMsg">'.form_error('contactEmail').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="contactPhone">Contact Phone</label></th>
				<td ><input type="text" name="contactPhone" id="contactPhone" size="50"  maxlength="12" value="<?php echo $contactPhone; ?>" />
					<?php echo '<div class="errMsg">'.form_error('contactPhone').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="alternateContact">Alternate Contact</label></th>
				<td ><input type="text" name="alternateContact" id="alternateContact" size="30"  maxlength="45" value="<?php echo $alternateContact; ?>" />
						Relationship with Athlete: <select name="relationship" id="relationship" ><option value="">Select...</option><option value="parent">Parent</option><option value="grandparent">Grandparent</option><option value="Spouse">Spouse</option><option value="Other">Other</option></select>
					<?php echo '<div class="errMsg">'.form_error('alternateContact').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="alternateEmail">Alternate Email</label></th>
				<td ><input type="text" name="alternateEmail" id="alternateEmail" size="50"  maxlength="45" value="<?php echo $alternateEmail; ?>" />
					<?php echo '<div class="errMsg">'.form_error('alternateEmail').'</div>'; ?>
				</td>
			</tr>
			<tr>
				<th><label for="alternatePhone">Alternate phone</label></th>
				<td ><input type="text" name="alternatePhone" id="alternatePhone" size="50"  maxlength="12" value="<?php echo $alternatePhone; ?>" />
					<?php echo '<div class="errMsg">'.form_error('alternatePhone').'</div>'; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="athleteid" id="athleteid" value="<?php echo $athleteid; ?>" />
<?php echo form_close(); ?>
<!-- END: edit_athlete -->
