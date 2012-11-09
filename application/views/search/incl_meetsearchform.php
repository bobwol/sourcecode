<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	$sMeetTitleDefault = 'Enter a keyword...';
	$sMeetVenueDefault = 'Enter the venue...';
	$sMeetCityDefault = 'Enter the city...';
	$frmAttributes = array('id' => 'meetSearchForm', 'name' => 'meetSearchForm', 'class' => 'searchForm');
	$otherForms = '';
	if($this->uri->segment(2) != '')
		$otherForms = '<div class="verticalMenu"><ul style="margin-top: 15px; border-top: 1px solid #bbb; padding: 15px 0px; "><li><a href="/search/teams/">Find a Team</a></li><li><a href="/search/athletes/">Find an Athlete</a></li></ul></div>';
?>

<!-- START: incl_meetSearchForm -->
<script>
	$(function(){
		$('#sDateRange').bind( 'change', function(event, ui) {
			displayDateFields();
		});
		<?php if($this->uri->segment(2) == 'meet_search_results') : ?>

			setSelect(document.getElementById('sYear'), "<?php echo $this->input->post('sYear'); ?>");
			setSelect(document.getElementById('sMonth'), "<?php echo $this->input->post('sMonth'); ?>");
			setSelect(document.getElementById('sDateRange'), "<?php echo $this->input->post('sDateRange'); ?>");
			displayDateFields();
			setSelect(document.getElementById('sMeetState'), "<?php echo $this->input->post('sMeetState'); ?>");
		<?php else : ?>	

			reset_meetSearchForm();
		<?php endif; ?>

	});

	
	function reset_meetSearchForm() {
		var dt=new Date();
		var sMonth = dt.getMonth()+1;
		var sYear = dt.getFullYear();
		var sDay = dt.getDate();
		if(sMonth < 10) sMonth = '0' + sMonth;
		if(sDay < 10) sDay = '0' + sDay;
		document.getElementById('sMeetTitle').value = '<?php echo $sMeetTitleDefault; ?>';
		setSelect(document.getElementById('sYear'), sYear );
		setSelect(document.getElementById('sMonth'), sMonth);
		document.getElementById('sDay').value = sMonth+'/'+sDay+'/'+sYear;
		setSelect(document.getElementById('sMeetState'), '');
		setSelect(document.getElementById('sDateRange'), 'day');
		displayDateFields();
		document.getElementById('sMeetVenue').value = '<?php echo $sMeetVenueDefault; ?>';
		document.getElementById('sMeetCity').value = '<?php echo $sMeetCityDefault; ?>';
		$('#sMeetState').selectmenu('refresh');
		$('#meetSearchFormWarningMsg').hide('slow');
	}

	function submit_meetSearchForm() {
		var searchYear = 2012;
		var arrDate = [];
		var eomLookup = ['00','31','28','31','30','31','30','31','31','30','31','30','31'];
		var eom = '';
		var is_leap_year = false;
		if((getSelect(document.getElementById('sMeetState')) == '') || ((getSelect(document.getElementById('sDateRange')) == 'day') && (!isValidDate(document.getElementById('sDay').value))))
		{
			$('#meetSearchFormWarningMsg').show('fast');
		} 
		else 
		{
			if(document.getElementById('sMeetTitle').value == '<?php echo $sMeetTitleDefault; ?>') document.getElementById('sMeetTitle').value = '';
			if(document.getElementById('sMeetVenue').value == '<?php echo $sMeetVenueDefault; ?>') document.getElementById('sMeetVenue').value = '';
			if(document.getElementById('sMeetCity').value == '<?php echo $sMeetCityDefault; ?>') document.getElementById('sMeetCity').value = '';
			if(getSelect(document.getElementById('sDateRange')) == 'day') {
				arrDate = document.getElementById('sDay').value.split("/",3);
				document.getElementById('sFirstDay').value = arrDate[2]+'-'+arrDate[0]+'-'+arrDate[1];
				document.getElementById('sLastDay').value = arrDate[2]+'-'+arrDate[0]+'-'+arrDate[1];
			} else {
				if(isLeapYear(parseInt(document.getElementById('sYear').value))) eomLookup[2] = '29'; // account for leap year
				eom = eomLookup[parseInt(document.getElementById('sMonth').value)];		
				document.getElementById('sFirstDay').value = document.getElementById('sYear').value+'-'+document.getElementById('sMonth').value+'-'+'01';
				document.getElementById('sLastDay').value = document.getElementById('sYear').value+'-'+document.getElementById('sMonth').value+'-'+eom;
			}
			document.getElementById('meetSearchForm').submit(); 
		}
	}
	
	function displayDateFields(){
		if(getSelect(document.getElementById('sDateRange')) == 'day'){
			document.getElementById('sMonthWrapper').style.display = 'none';		
			document.getElementById('sDayWrapper').style.display = 'block';
		} else { 
			document.getElementById('sMonthWrapper').style.display = 'block';	
			document.getElementById('sDayWrapper').style.display = 'none';	
			<?php if($this->session->userdata('device_type') == 'mobile') : ?>
			
				<!-- use the refresh method to tell the jQuery mobile enhanced control to update itself to match the new state. -->
				$('#sMonth').selectmenu('refresh');
				$('#sYear').selectmenu('refresh');
			<?php endif; ?>

		}
	}
</script>
<?php if($this->session->userdata('device_type') != 'mobile') : ?>
<div class="subheadingPurple roundedCorners" ><span>Find</span> a Meet</div> 
<?php endif; ?>
<?php echo validation_errors(); ?>
<div id="meetSearchFormWarningMsg" class="errorMsg hide">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>A valid date range and state are required.</p>
</div>
<?php echo form_open('/search/meet_search_results', $frmAttributes); ?>
	<div data-role="fieldcontain">
		<div class="fldLabel">Meet Title:</div>
		<div class="fld">
			<input type="text" name="sMeetTitle"  id="sMeetTitle" size="18" data-theme="c" value="<?php echo set_value('sMeetTitle', $sMeetTitleDefault); ?>"  />
		</div>
	</div>

	<!-- When is the meet? -->
	<div data-role="fieldcontain">
		<div class="fldLabel">Date Range:</div>
		<div class="fld">
			<select id="sDateRange" name="sDateRange" data-role="slider">
				<option value="day">Select day</option>
				<option value="month">Select month</option>
			</select>
			<div id="sDayWrapper">
				<input type="date" name="sDay"  id="sDay" size="18" data-theme="c" value="<?php echo set_value('sDay', 'mm/dd/yyyy'); ?>" class="datePicker" />
			</div>
			<fieldset id="sMonthWrapper" data-role="controlgroup" data-type="horizontal">
				<select id="sMonth" name="sMonth" >
					<option value="01">Jan</option>
					<option value="02">Feb</option>
					<option value="03">Mar</option>
					<option value="04">Apr</option>
					<option value="05">May</option>
					<option value="06">Jun</option>
					<option value="07">Jul</option>
					<option value="08">Aug</option>
					<option value="09">Sep</option>
					<option value="10">Oct</option>
					<option value="11">Nov</option>
					<option value="12">Dec</option>
				</select>
				<select id="sYear" name="sYear" >
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
					<option value="2016">2016</option>
				</select>
			</fieldset>
		</div>
	</div>

	<!-- Where is the meet? -->
	<div data-role="fieldcontain">
		<div class="fldLabel">Location:</div>
		<input type="text" name="sMeetVenue" id="sMeetVenue" size="18" data-theme="c" value="<?php echo set_value('sMeetVenue', $sMeetVenueDefault); ?>" />
		<input type="text" name="sMeetCity" id="sMeetCity" size="18" data-theme="c" value="<?php echo set_value('sMeetCity', $sMeetCityDefault); ?>" />
		<select id="sMeetState" name="sMeetState" >
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
		<a href="JavaScript:void(0);" onclick="submit_meetSearchForm();" class="btn" data-role="button" data-theme="a"><span>Search</span></a>
		<a href="JavaScript:void(0);" onclick="reset_meetSearchForm();" class="btn" data-role="button" data-theme="a"><span>Reset</span></a>
	</div>
	<input type="hidden" name="sFirstDay"  id="sFirstDay" value="" />
	<input type="hidden" name="sLastDay"  id="sLastDay" value="" />
<?php echo form_close(); ?>
<?php echo $otherForms; ?>
<!-- END: incl_meetSearchForm -->
