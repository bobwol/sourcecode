<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	$sOrgNameDefault = 'Enter the name...';
	$sOrgCityDefault = 'Enter the city...';
	$frmAttributes = array('id' => 'teamSearchForm', 'name' => 'teamSearchForm');
	$otherForms = '';
	if($this->uri->segment(2) != '')
		$otherForms = '<div class="verticalMenu"><ul style="margin-top: 15px; border-top: 1px solid #bbb; padding: 15px 0px; "><li><a href="/search/meets/">Find a Meet</a></li><li><a href="/search/athletes/">Find an Athlete</a></li></ul></div>';
?>

<!-- START: incl_teamSearchForm -->
<script>
	$(function(){
		<?php if($this->uri->segment(2) == 'team_search_results') : ?>

			setSelect(document.getElementById('sOrgType'), "<?php echo $this->input->post('sOrgType'); ?>");
			setSelect(document.getElementById('sOrgState'), "<?php echo $this->input->post('sOrgState'); ?>");
		<?php else : ?>	

			reset_teamSearchForm();
		<?php endif; ?>
		
	});
	
	function reset_teamSearchForm() {
		document.getElementById('sOrgName').value = '<?php echo $sOrgNameDefault; ?>';
		setSelect(document.getElementById('sOrgType'), '');
		$('#sOrgType').selectmenu('refresh');
		document.getElementById('sOrgCity').value = '<?php echo $sOrgCityDefault; ?>';
		setSelect(document.getElementById('sOrgState'), '');
		$('#sOrgState').selectmenu('refresh');
		$('#teamSearchFormWarningMsg').hide('slow');
	}

	function submit_teamSearchForm() {
		if((getSelect(document.getElementById('sOrgState')) == '') || (getSelect(document.getElementById('sOrgType')) == '')) {
			$('#teamSearchFormWarningMsg').show('fast');
		} else {
			if(document.getElementById('sOrgName').value == '<?php echo $sOrgNameDefault; ?>') document.getElementById('sOrgName').value = '';
			if(document.getElementById('sOrgCity').value == '<?php echo $sOrgCityDefault; ?>') document.getElementById('sOrgCity').value = '';
			document.getElementById('teamSearchForm').submit(); 
		}
	}
	
</script>
<?php if($this->session->userdata('device_type') != 'mobile') : ?>
<div class="subheadingPurple roundedCorners" ><span>Find</span> a Team</div> 
<?php endif; ?>
<?php echo validation_errors(); ?>
<div id="teamSearchFormWarningMsg" class="errorMsg hide">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>The organization type and state are required.</p>
</div>
<?php echo form_open('/search/team_search_results', $frmAttributes); ?>
	<div data-role="fieldcontain">
		<div class="fldLabel">Organization Info:</div>
		<input type="text" name="sOrgName" id="sOrgName" size="18" data-theme="c" value="<?php echo set_value('sOrgCity', $sOrgNameDefault); ?>" />
		<select name="sOrgType" id="sOrgType" >
			<option value="">Select type...</option>
			<option value="HS">High School</option>
			<option value="IC">Intercollegiate</option>
			<option value="TC">Track Club</option>
		</select>
		<input type="text" name="sOrgCity" id="sOrgCity" size="18" data-theme="c" value="<?php echo set_value('sOrgCity', $sOrgCityDefault); ?>" />
		<select id="sOrgState" name="sOrgState" >
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
		<a href="JavaScript:void(0);" onclick="submit_teamSearchForm();" class="btn" data-role="button" data-theme="a"><span>Search</span></a>
		<a href="JavaScript:void(0);" onclick="reset_teamSearchForm();" class="btn" data-role="button" data-theme="a"><span>Reset</span></a>
	</div>
<?php echo form_close(); ?>
<?php echo $otherForms; ?>
<!-- END: incl_teamSearchForm -->
