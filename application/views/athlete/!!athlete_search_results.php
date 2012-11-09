<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- START: athlete_search_results -->
<h1 class="contentHeaderMargin">Athlete Search Results!!</h1> 
<?php if(sizeof($row) == 0) : ?>
	<p>There are no athletes that match the specified criteria.</P>
<?php else : ?>
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
	<?php
		$orgType = array(
			'HS' => 'High School',
			'IC' => 'College',
			'TC' => 'Track Club',
		);		
		if($this->session->userdata('device_type') == 'mobile')
		{
			$listBegin ='<ul data-role="listview" data-filter="true" data-inset="true" class="">';
			$listEnd='</ul>';
			$rowBegin='<li>';
			$rowEnd='</li>';
			$cellBegin='';
			$cellEnd='<br />';
		}
		else
		{
			$listegin='<table id="tblSearchResults" class="dataTable full" ><thead><tr><th class="stdHdr" >Athlete</th><th class="stdHdr" >Organization Affiliation</th></tr></thead><tbody>';
			$listEnd='</tbody></table>';
			$rowBegin='<tr>';
			$rowEnd='</tr>';
			$cellBegin='<td>';
			$cellEnd='<td>';
		}
		
		echo $listBegin;
		foreach($row as $r)
		{				
			echo $rowBegin;
			echo $cellBegin.'<a href="/athletefinder/view_athlete/'.$r->athleteid.' data-ajax="false">';
			echo '<span class="itemTitle">'.$r->lastName.', '.$r->firstName.' ('.$r->gender.')</span><br />';
			echo $orgType[$r->type];
			if($r->type != 'TC') 
				echo ' '.$r->academicYear;
			echo '</a>'.$cellEnd;
			echo $cellBegin.$r->orgName.'<br />'.$r->city.' '.$r->state.' '.$r->zip.$cellEnd;
			echo $rowEnd;
		}
		$echo $listEnd;
	?>
<?php endif; ?>
<!-- END: athlete_search_results -->
