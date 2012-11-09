<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- START: team_search_results -->
<h1 class="contentHeaderMargin">Team Search Results</h1> 
<?php if(sizeof($row) == 0) : ?>
	<p>There are no meets that match the specified criteria.</P>
<?php else : ?>
	<?php if($this->session->userdata('device_type') == 'mobile') : ?>
		
		<!-- list search results - mobile format -->
		<ul data-role="listview" data-filter="true" data-inset="true" class="schedOfEvents">
		<?php foreach($row as $r) : ?>
	
			<li>
				<a href="/teamfinder/view_team/<?php echo $r->teamid; ?>" data-ajax="false">
				
					<span class="itemTitle"><?php echo $r->orgName; ?></span><br />
					<?php echo $r->city.' '.$r->state.' '.$r->zip; ?><br />
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
				'aaSorting': [[ 0, 'asc' ]]
			});
		});
		</script>
		<table id="tblSearchResults" class="dataTable full" >
			<thead>
				<tr>
					<th class="stdHdr" >Organization</th>
					<th class="stdHdr" >Location</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($row as $r) : ?>				
				<tr>
					<td><a href="/teamfinder/view_team/<?php echo $r->teamid ?>" ><?php echo $r->orgName; ?></a></td>
					<td><?php echo $r->city.' '.$r->state.' '.$r->zip; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
<?php endif; ?>
<!-- END: team_search_results -->
