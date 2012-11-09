<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	$sLastNameDefault = 'Enter a last name...';
	$sOrgAffilNameDefault = 'Enter the name...';
	$frmAttributes = array('id' => 'athleteSearchForm', 'name' => 'athleteSearchForm');
	$otherForms = '';
	if($this->uri->segment(2) != '')
		$otherForms = '<div class="verticalMenu"><ul style="margin-top: 15px; border-top: 1px solid #bbb; padding: 15px 0px; "><li><a href="/search/meets/">Find a Meet</a></li><li><a href="/search/teams/">Find a Team</a></li></ul></div>';
?>

<!-- START: incl_athleteSearchForm -->
<script>
	$(function(){
		<?php if($this->uri->segment(2) == 'athlete_search_results') : ?>

			setSelect(document.getElementById('sGender'), "<?php echo $this->input->post('sGender'); ?>");
			setSelect(document.getElementById('sOrgAffilType'), "<?php echo $this->input->post('sOrgAffilType'); ?>");
			setSelect(document.getElementById('sOrgAffilState'), "<?php echo $this->input->post('sOrgAffilState'); ?>");
		<?php else : ?>	

			reset_athleteSearchForm();
		<?php endif; ?>

	});

	
	function reset_athleteSearchForm() {
		document.getElementById('sLastName').value = '<?php echo $sLastNameDefault; ?>';
		setSelect(document.getElementById('sGender'), '');
		$('#sGender').selectmenu('refresh');
		document.getElementById('sOrgAffilName').value = '<?php echo $sOrgAffilNameDefault; ?>';
		setSelect(document.getElementById('sOrgAffilType'), '');
		$('#sOrgAffilType').selectmenu('refresh');
		setSelect(document.getElementById('sOrgAffilState'), '');
		$('#sOrgAffilState').selectmenu('refresh');
		$('#athleteSearchFormWarningMsg').hide('slow');
	}

	function submit_athleteSearchForm() {
		var tempLastName = document.getElementById('sLastName').value;
		if(tempLastName == '<?php echo $sLastNameDefault; ?>') tempLastName = '';
		if((getSelect(document.getElementById('sGender')) == '') || (getSelect(document.getElementById('sOrgAffilState')) == '') || (getSelect(document.getElementById('sOrgAffilType')) == '') || (tempLastName == '') || (tempLastName.length < 2)) {
			$('#athleteSearchFormWarningMsg').show('fast');
		} else {
			if(document.getElementById('sLastName').value == '<?php echo $sLastNameDefault; ?>') document.getElementById('sLastName').value = '';
			if(document.getElementById('sOrgAffilName').value == '<?php echo $sOrgAffilNameDefault; ?>') document.getElementById('sOrgAffilName').value = '';
			document.getElementById('athleteSearchForm').submit(); 
		}
	}
	
</script>
<?php if($this->session->userdata('device_type') != 'mobile') : ?>
<div class="subheadingPurple roundedCorners" ><span>Find</span> an Athlete</div> 
<?php endif; ?>
<?php echo validation_errors(); ?>
<div id="athleteSearchFormWarningMsg" class="errorMsg hide">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>The athlete's last name (minimum 2 characters), gender, organization type and state are required.</p>
</div>
<?php echo form_open('/search/athlete_search_results', $frmAttributes); ?>
	<div data-role="fieldcontain">
		<div class="fldLabel">Athlete Information:</div>
		<input type="text" name="sLastName"  id="sLastName" size="18" data-theme="c" value="<?php echo set_value('sLastName', $sLastNameDefault); ?>"  />
		<select id="sGender" name="sGender" >
			<option value="" selected="selected">Select gender...</option>
			<option value="F">Female</option>
			<option value="M">Male</option>
		</select>
	</div>
	<div data-role="fieldcontain">
		<div class="fldLabel">Organization Affiliation:</div>
		<input type="text" name="sOrgAffilName" id="sOrgAffilName" size="18" data-theme="c" value="<?php echo set_value('sCity', $sOrgAffilNameDefault); ?>" />
		<select name="sOrgAffilType" id="sOrgAffilType" >
			<option value="">Select type...</option>
			<option value="HS">High School</option>
			<option value="IC">Intercollegiate</option>
			<option value="TC">Track Club</option>
		</select>
		<select id="sOrgAffilState" name="sOrgAffilState" >
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
	</div>

	<div class="btnGroup" data-role="controlgroup" data-type="horizontal">
		<a href="JavaScript:void(0);" onclick="submit_athleteSearchForm();" class="btn" data-role="button" data-theme="a"><span>Search</span></a>
		<a href="JavaScript:void(0);" onclick="reset_athleteSearchForm();" class="btn" data-role="button" data-theme="a"><span>Reset</span></a>
	</div>
<?php echo form_close(); ?>
<?php echo $otherForms; ?>
<!-- END: incl_athleteSearchForm -->
