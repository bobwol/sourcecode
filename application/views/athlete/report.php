<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if(sizeof($athleteProfile) == 0) : ?>
	<p>An athlete with this ID does not exist</P>
<?php else : ?>

	<!-- START: athlete_report -->
		
	<!-- Page section: topRegion -->
	<?php if($this->session->userdata('user_id')) : ?>
		<div class="topRegion">
			<ul class="hList">
				<?php if($athleteProfile->teamid == $this->session->userdata('teamid')) : ?>
					<li><a href="/athlete/edit/<?php echo $athleteProfile->athleteid; ?>" >Edit Profile</a></li>
				<?php endif; ?>
			</ul>
		</div>
	<?php endif; ?>

	<!-- Page section: pgHeading -->
	<div class="pgHeading">
		<h1><?php echo $athleteProfile->firstName.' '.$athleteProfile->lastName.' ('.$athleteProfile->gender.')'; ?></h1>
		<p><?php echo '<a href="/team/report/'.$athleteProfile->teamid.'">'.$athleteProfile->orgName.'</a> - '.$athleteProfile->academicYear; ?></p>
	</div>

	<script>
		$(function(){
			$('#perfHistory').dataTable({ 
				'sDom': 'f<"clear">t<"tblFooter"ip>',
				'iDisplayLength': 100,
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
		});
	</script>

	<?php if(!$athleteProfile->published) : ?>
		<p>Information for this athlete has not been published.</p>
	<?php else : ?>
	
		<!-- Page section: rptDetails -->
		<div class=" rptDetails" >		
			<div id="tab-pb" class="athleteRptView" >
				<div class="innertube">
					<h4>Personal Best</h4>
					<div class="innertube">
						<table>
						<?php 
							foreach($personalBest as $pb)
							{
								$relayVar = '';
								if($pb->subCategory == 'Relays') $relayVar =' (split)';
								echo '<tr><th padding: 3px 0px;"><div class="alignRt">'.$pb->eventName.$relayVar.':</div></th><td style=" padding: 3px 10px;"><div class="alignRt">'.$pb->performance.'</div></td></tr>';
							}
						?>
						</table>
					</div>
					<h4>Performance History</h4>
					<table id="perfHistory" class="dataTable full">
						<thead>
							<tr>
								<th class="stdHdr" >Date</th>
								<th class="stdHdr" >Meet Name</th>
								<th class="stdHdr" >Event</th>
								<th class="stdHdr" >Performance</th>
								<th class="stdHdr" >Place</th>
							</tr>
						</thead>
						<tbody>
							<tr><td><span title="yymmdd"></span>Month day, year</td><td><a href="/meet/report/5101" >Harrison vs Allatoona dual meet</a></td><td>100m</td><td>12.27</td><td>2nd</td></tr>
							<tr><td><span title="yymmdd"></span>Month day, year</td><td><a href="/meet/report/5101" >Harrison vs Allatoona dual meet</a></td><td>200m</td><td>26.79</td><td>1st</td></tr>
							<tr><td><span title="yymmdd"></span>Month day, year</td><td><a href="/meet/report/5101" >Harrison vs Allatoona dual meet</a></td><td>4x200m</td><td>26.51(split)</td><td>2nd</td></tr>
							<tr><td><span title="yymmdd"></span>Month day, year</td><td><a href="/meet/report/5101" >Cobb County Invitational</a></td><td>200m</td><td>27.02</td><td>3rd</td></tr>
							<tr><td><span title="yymmdd"></span>Month day, year</td><td><a href="/meet/report/5101" >Cobb County Invitational</a></td><td>400m</td><td>60.31</td><td>1st</td></tr>
							<tr><td><span title="yymmdd"></span>Month day, year</td><td><a href="/meet/report/5101" >Cobb County Invitational</a></td><td>4x200m</td><td>27.15 (split)</td><td>2nd</td></tr>
							<tr><td><span title="yymmdd"></span>Month day, year</td><td><a href="/meet/report/5101" >Coaches Invitational</a></td><td>4x200m</td><td>26.11 (split)</td><td></td></tr>
							<tr><td><span title="yymmdd"></span>Month day, year</td><td><a href="/meet/report/5101" >Coaches Invitational</a></td><td>4x400m</td><td>61.24 (split)</td><td></td></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
	<?php endif; ?>		
<?php endif; ?>
<!-- END: athlete_report -->
