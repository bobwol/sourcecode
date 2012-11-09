<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
	
</style>
<!-- START: meet_report -->
<?php if(sizeof($meetInfo) == 0) : ?>
 <p>A meet with this ID does not exist</p>
<?php else : ?>
	<?php
	include(APPPATH.'/views/incl_listformat.php');
	function isOnTeamSchedule($meetID, $teamSched)
	{
		$retval = false;
		$schedArr = explode('|', $teamSched);
		if(in_array($meetID, $schedArr))
		{
			$retval = true;
		}
		return $retval;
	}
	?>
				
	<!-- Page section: topRegion -->
	<?php if($this->session->userdata('user_id')) : ?>
		<div class="topRegion">
			<ul class="hList">
				<?php if($meetInfo->user_id == $this->session->userdata('user_id')) : ?>
					<li><a href="/meet/edit/<?php echo $meetInfo->meetID; ?>" >Edit Meet</a></li>
					<li><a href="/meet/assign_my_athletes/<?php echo $meetInfo->meetID; ?>">Assign Athletes</a></li>
				<?php else : ?>
					<?php if(isOnTeamSchedule($meetInfo->meetID, $this->session->userdata('teamSchedule'))) : ?>
						<li><a href="/meet/assign_my_athletes/<?php echo $meetInfo->meetID; ?>">Assign Athletes</a></li>
						<li><a href="JavaScript:void(0);" onclick="$('#delLink').fadeIn(2000);" >Remove From Schedule</a></li>
					<?php else : ?>
						<li><a href="/meet/add_to_schedule/<?php echo $meetInfo->meetID; ?>" onclick="performAction('save');" >Add To Schedule</a></li>
					<?php endif; ?>
				<?php endif; ?>
			</ul>
			<div id="delLink" class="confirm hide" style="margin-right: 10px;">Are you sure?&nbsp;
				<span><a href="JavaScript:void(0);" class="close" >No</a></span>&nbsp;&nbsp;
				<span><a href="/meet/remove_from_schedule/<?php echo $meetInfo->meetID; ?>" >Yes</a></span>
			</div>
		</div>
	<?php endif; ?>

	<!-- Page section: pgHeading -->
	<div class="pgHeading">
		<h1><?php echo $meetInfo->meetTitle; ?></h1>
		<p>
			<?php
				 echo write_field($meetInfo->venue, '');
				 echo write_field($meetInfo->address1, '<br />');
				 echo write_field($meetInfo->address2, '<br />');
				 echo write_field($meetInfo->city, '<br />');
				 echo write_field($meetInfo->state, ', ');
				 echo write_field($meetInfo->zip, ' ').'<br />';
			?>
		</p>
	</div>

	<?php if(!$meetInfo->published) : ?>
		<p>Information for this meet has not been published.</p>
	<?php else : ?>

		<?php
		$crlf   = array("\r\n", "\n", "\r");
		$numDays = sizeof($meetDaySched);
		if($meetDayTab > $numDays)
		{
			$meetDayTab = $numDays;
		}
		?>
	
		<script>
			var PARTICIPANTS = 0;
			var SPECTATORS = 1;
			var SCORES = 2;
			var meetInfoTitleArr = [];
			var meetInfoContentArr = [];
			meetInfoTitleArr[PARTICIPANTS] = 'Information for Participants';
			meetInfoTitleArr[SPECTATORS] = 'Information for Spectators';
			meetInfoTitleArr[SCORES] = 'Scores';
			meetInfoContentArr[PARTICIPANTS] = '<div class="infoPopup"><?php echo str_replace($crlf, "", $meetInfo->participantInfo) ?></div>';
			meetInfoContentArr[SPECTATORS] = '<div class="infoPopup"><?php echo str_replace($crlf, "", $meetInfo->spectatorInfo) ?></div>';
			meetInfoContentArr[SCORES] = '<div class="infoPopup"><?php echo str_replace($crlf, "", $meetInfo->scores); ?></div>';
		</script>
		
		
		<?php if($this->session->userdata('device_type') == 'mobile') : ?>
			<?php
				$spectatorLabel = 'Spectators';
				$participantLabel = 'Participants';
				$scoresLabel = 'Scores';
				$refreshLabel = 'Refresh';
				$voidLink = '#';
				$infoBarClass = '';
				if($numDays == 1)
				{
					$beginDayIdentifier = '<h3>';
					$endDayIdentifier = '</h3>';
				}
				else
				{
					$beginDayIdentifier = '<select id="daySelector" name="daySelector" >';
					$endDayIdentifier = '</select><br />';
				}
			?>
			<script>
				$(function(){
					$('select#daySelector').change(function() {
						setDay(getSelect(document.getElementById('daySelector')));
					});
					setSelect(document.getElementById('daySelector'), '<?php echo $meetDayTab; ?>');
					$('#daySelector').selectmenu('refresh');
					setDay(<?php echo $meetDayTab; ?>);
				});
				function setDay(mDay) {
					$('.dailySchedule').hide('slow');
					$('#tab-'+mDay).show('fast');
				}
				function showPopup(ndx) {
					$('#popupTitle').html('<h2>'+meetInfoTitleArr[ndx]+'</h2>');
					$('#popupContent').html(meetInfoContentArr[ndx]);
					$.mobile.changePage('#popup');
				}
			</script>
		<?php else : ?>
			<?php
				$spectatorLabel = 'Information for Spectators';
				$participantLabel = 'Information for Participants';
				$scoresLabel = 'Scores';
				$refreshLabel = 'Refresh this Report';
				$voidLink = 'javascript: void(0);';
				$infoBarClass = 'hList';
			?>
			<script>
				meetDayTab = '<?php echo $meetDayTab; ?>';
				$(function(){
					$('#popupContent').dialog({ autoOpen: false, width: 600, modal: true });
					
					// Used to make the schedule of events table sortable and filterable.
					var oTable =[];
					<?php for( $i=1; $i<=$numDays; $i++) : ?>
					
						oTable[<?php echo $i; ?>] = $('#tblDay<?php echo $i; ?>').dataTable({ 
							'sDom': 'tf<"clear">t<"tblFooter"ip>',
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
					<?php endfor; ?>

					// Used to show/hide the event summary of each event
				  $('.tblSchedule tbody td img').live( 'click', function () {
						var row = this.parentNode.parentNode;
						var ndx = parseInt(row.id.substr(3,1));
						if ( this.src.match('rtArrow') ) {
							this.src = '/images/dnArrow.png';
							oTable[ndx].fnOpen( row, document.getElementById('summary-'+row.id).innerHTML, 'details' );
						} else {
							this.src = '/images/rtArrow.png';
							oTable[ndx].fnClose( row );
						}
					});

					$('.tabs').tabs( "select" , <?php echo $meetDayTab-1; ?> );
				});
				function showPopup(ndx) {
					$("#popupContent").dialog("option", "title", meetInfoTitleArr[ndx]);
					$("#popupContent").html(meetInfoContentArr[ndx]);
					$("#popupContent").dialog("open");
				}
			</script>
		<?php endif; ?>
		
		<ul class="hList" >
			<?php
				echo write_field($meetInfo->contactName, 'li');
		 		echo write_field($meetInfo->contactPhone, 'li');
		 		echo write_field($meetInfo->contactEmail, 'li');
		 	?>
		</ul>
	    
		<div data-role="navbar" style="margin-bottom: 15px; text-align: center;" >
			<ul class="<?php echo $infoBarClass; ?>" >
				<?php if($meetInfo->spectatorInfo != '') : ?>
				<li class="mobileNavBtn1" ><a href="<?php echo $voidLink ?>" onclick="showPopup(SPECTATORS);" data-icon="info" data-rel="dialog" ><?php echo $spectatorLabel; ?></a></li>
				<?php endif; ?>
	
				<?php if($meetInfo->participantInfo != '') : ?>				
				<li class="mobileNavBtn1"><a href="<?php echo $voidLink ?>" onclick="showPopup(PARTICIPANTS);" data-icon="info" data-rel="dialog" ><?php echo $participantLabel; ?></a></li>
				<?php endif; ?>

				<?php if($meetInfo->scores != '') : ?>		
				<li class="mobileNavBtn1"><a href="<?php echo $voidLink ?>" onclick="showPopup(SCORES);" data-icon="grid" data-rel="dialog" ><?php echo $scoresLabel; ?></a></li>
				<?php endif; ?>

				<li><a href="/meet/report/<?php echo $meetInfo->meetID; ?>" data-ajax="false" data-icon="refresh"><?php echo $refreshLabel; ?></a></li>
			</ul>
		</div>

	
		<div class='tabs rptDetails'>
		<?php
			$schedReveal = '';
			if($this->session->userdata('device_type') == 'mobile')
			{
				echo $beginDayIdentifier;
				foreach($meetDaySched as $selOption)
				{
					if($numDays == 1)
					{
						echo strftime('%A, %B %e, %Y', strtotime($selOption['startDate']));
					}
					else
					{
						$schedReveal = 'hide';
						echo '<option value="'.$selOption['day'].'">'.strftime('%A, %B %e, %Y', strtotime($selOption['startDate'])).'</option>';
					}
				}
				echo $endDayIdentifier;
			}
			else
			{		
				echo '<div class="hide" id="popupContent" ></div>';
				echo '<ul>';
				foreach($meetDaySched as $tab)
				{
					echo '<li><a href="#tab-'.$tab['day'].'">'.strftime('%A, %B %e, %Y', strtotime($tab['startDate'])).'</a></li>';
				}
				echo '</ul>';
			}
	
			foreach($meetDaySched as $sched)
			{
				echo '<div id="tab-'.$sched['day'].'" class="dailySchedule '.$schedReveal.'">';
				echo '<h4 style="margin-top: 15px;" >Schedule of Events</h4>';
				echo '<h5>Events start at '.strftime('%l:%M %P', strtotime($sched['startTime'])).'</h5>';
				if($this->session->userdata('device_type') == 'mobile')
				{
					echo '<ul data-role="listview" data-filter="true" data-inset="true" data-divider-theme="a">';
					$endSched = '</ul>';
				}
				else
				{
					echo '<table id="tblDay'.$sched['day'].'" class="tblSchedule dataTable full">';
					echo '<thead><tr><th class="stdHdr" style="width: 85px;" >Start Time</th><th class="stdHdr" >Event</th><th class="stdHdr" >Division</th><th class="stdHdr" style="width:	115px;">Event Category</th></tr></thead>';
					echo '<tbody>';
					$endSched = '</tbody></table>';
				}
				$nextEventStartTimeTE = strtotime($sched['startTimeTE']);
				$nextEventStartTimeFE = strtotime($sched['startTimeFE']);
				$schedObj = $sched['schedArr']; 
				foreach($schedObj as $r)
				{
					if($r->eventCategory == 'TRACK') {
						$eventStartTime = $nextEventStartTimeTE;
						$nextEventStartTimeTE = $eventStartTime + ($r->allocatedTime * 60);
						$perfMeasurement = 'Time';
					} else {
						$eventStartTime = $nextEventStartTimeFE;
						$nextEventStartTimeFE = $eventStartTime + ($r->allocatedTime * 60);
						if(($r->eventID == '601') || ($r->eventID == '604'))
						{
							$perfMeasurement = 'Height';
						}
						else
						{
							$perfMeasurement = 'Distance';								
						}
					}
					if($this->session->userdata('device_type') == 'mobile')
					{
						if($r->eventOrder == 1)
						{ 
							echo '<li data-role="list-divider">'.$r->eventCategory.' EVENTS</li>'; 
						}
						$seSummary = '';
						if ($r->seSummary != '')
						{
							$seSummary = $r->seSummary;
							$seSummary = '<div class="alignCt">'.$meetInfo->meetTitle.'</div><table class="eventSummaryTable"><caption>'.$r->gender.' '.$r->description.'</caption><thead><tr><th></th><th>Athlete</th><th>Affiliation</th><th>'.$perfMeasurement.'</th></tr></thead><tbody>'.$seSummary.'</tbody></table>';
							$seSummary = '<ul data-inset="true" data-theme="c" ><li>'.$seSummary.'</li><li data-theme="a"><div style="text-align: center;" ><a href="#" data-rel="back" data-role="button" data-icon="delete" data-inline="true" data-theme="b">Exit</a></div></li></ul>';
						}						
						echo '<li><span class="itemTitle">'.$r->eventName.' '.$r->heatDesc.'</span><br />';
						echo '<span>'.$r->gender.' '.$r->description.'</span>';		
						echo '<span class="ui-li-aside" style="margin-right: 5px;">'.strftime("%l:%M %P", $eventStartTime).'<br />'.strtolower($r->eventCategory).' event</span>';
						echo $seSummary.'</li>';
					}
					else
					{
						$seSummary = '';
						if ($r->seSummary != '')
						{
							$seSummary = $r->seSummary;
							$seSummary = '<table class="eventSummaryTable"><thead><tr><th></th><th>Athlete</th><th>Affiliation</th><th>'.$perfMeasurement.'</th></tr></thead><tbody>'.$seSummary.'</tbody></table>';
							$seSummary = '<img src="/images/rtArrow.png" alt="event summary" /><div id="summary-day'.$sched['day'].'-seID'.$r->seID.'" class="summary hide" >'.$seSummary.'</div>';
						}
						echo '<tr id="day'.$sched['day'].'-seID'.$r->seID.'">';
						echo '<td><span title="\''.$eventStartTime.'\'"></span>'.strftime('%l:%M %P', $eventStartTime).'</td>';
						echo '<td>'.$r->eventName.' '.$r->heatDesc.$seSummary.'</td>';
						echo '<td>'.$r->gender.' '.$r->description.'</td>';
						echo '<td>'.$r->eventCategory.'</td></tr>';
					}
				}
				echo $endSched.'</div>';
			}
		?>
		</div>
	<?php endif; ?>
<?php endif; ?>
<!-- END: meet_report -->
