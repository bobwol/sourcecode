<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- START: meet_search_results -->
<h1 class="contentHeaderMargin">Meet Search Results</h1> 
<?php if(sizeof($row) == 0) : ?>
	<p>There are no meets that match the specified criteria.</P>
<?php else : ?>
	<?php if($this->session->userdata('device_type') == 'mobile') : ?>
		
		<!-- list search results - mobile format -->
		<ul data-role="listview" data-filter="true" data-inset="true" class="schedOfEvents">
		<?php foreach($row as $r) : ?>
			<?php $suffix = '';
				if($r->day > 1) { $suffix = ' (day '.$r->day.')'; } 
			?>
	
			<li>
				<a href="/meetfinder/view_meet/<?php echo $r->meetID.'/'.$r->day; ?>" data-ajax="false">
				
					<span class="itemTitle"><?php echo $r->meetTitle.$suffix ; ?></span><br />
					<?php echo $r->venue; ?><br />
					<?php echo $r->city.' '.$r->state.' '.$r->zip; ?><br />
					<?php echo date('l, F j, Y', strtotime($r->startDate)).' - '.date('g:i a', strtotime($r->startTime)); ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php else : ?>
	
		<!-- list search results - desktop/laptop format -->
		<script>
		$(function(){
			// Used to make the search results table sortable and filterable.
			$('#tblSearchResults').dataTable({ 
				'sDom': 'f<"clear">t<"tblFooter"ip>',
				'iDisplayLength': 50,
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
		<table id="tblSearchResults" class="dataTable full" >
			<thead>
				<tr>
					<th class="stdHdr" >Start Date / Time</th>
					<th class="stdHdr" >Meet Name / Venue</th>
					<th class="stdHdr" >Location</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($row as $r) : ?>
				<?php $suffix = '';
					if($r->day > 1) { $suffix = ' (day '.$r->day.')'; } 
				?>
				
				<tr>
					<td><span title="'<?php echo date('d', strtotime($r->startDate)).'-'.date('H:i', strtotime($r->startTime));  ?>'"><?php echo date('l, F j, Y', strtotime($r->startDate)); ?><br />Starting at <?php echo date('g:i a', strtotime($r->startTime)); ?></td>
					<td><a href="/meetfinder/view_meet/<?php echo $r->meetID.'/'.$r->day; ?>" ><?php echo $r->meetTitle.$suffix ; ?></a><br/><?php echo $r->venue; ?></td>
					<td><?php echo $r->city.' '.$r->state.' '.$r->zip; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
<?php endif; ?>
<!-- END: meet_search_results -->
