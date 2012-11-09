<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- START: meet_search_results -->
<div class="pgHeading">
	<h1>Meet Search Results</h1> 
</div>
<?php 
if(sizeof($searchResult) == 0)
{
	echo '<p>There are no meets that match the specified criteria.</p>';
}
else
{
	include(APPPATH.'/views/incl_listformat.php');
	if($this->session->userdata('device_type') != 'mobile')
	{
		echo "\n<script>$(function(){ $('.dataTable').dataTable({ ";
		echo "'sDom': 'f<\"clear\">t<\"tblFooter\"ip>','iDisplayLength': 50, 'bRetrieve': true, 'bPaginate': true, 'bLengthChange': false, 'bFilter': true, 'bSort': true, 'bInfo': true, 'bAutoWidth': false, 'bJQueryUI': true,'aaSorting': [[ 0, 'asc' ]]";
		echo ", 'aoColumnDefs': [ { 'sType': 'title-string', 'aTargets': [ 0 ] } ]";
		echo "}); })</script>\n";
		$listHeader='<thead><tr><th class="stdHdr" >Start Date / Time</th><th class="stdHdr" >Meet Name / Venue</th><th class="stdHdr" >Location</th></tr></thead>';
	}
	echo "\n".$listBegin.$listHeader.$listBodyBegin."\n";
	foreach($searchResult as $sr)
	{
		$suffix = '';		
		if($sr->day > 1)
			$suffix = ' (day '.$sr->day.')';
		echo $rowBegin;
		if($this->session->userdata('device_type') != 'mobile')
			echo $cellBegin.'<span title="'.date('d', strtotime($sr->startDate)).'-'.date('H:i', strtotime($sr->startTime)).'"></span>'.date('l, F j, Y', strtotime($sr->startDate)).'<br />Starting at '.date('g:i a', strtotime($sr->startTime)).$cellEnd;
		echo $cellBegin.'<a href="/meet/report/'.$sr->meetID.'/'.$sr->day.'" data-ajax="false"><span class="itemTitle">'.$sr->meetTitle.$suffix.'</span>'.$nonMobileAnchorClose.'<br />'.$sr->venue.$cellEnd;
		echo $cellBegin.$sr->city.' '.$sr->state.' '.$sr->zip.$cellEnd;
		if($this->session->userdata('device_type') == 'mobile')
			echo $cellBegin.date('l, F j, Y', strtotime($sr->startDate)).' - '.date('g:i a', strtotime($sr->startTime)).$cellEnd;
		echo $mobileAnchorClose;
		echo $rowEnd."\n";
	}
	echo $listBodyEnd.$listEnd."\n";
}
?>
<!-- END: meet_search_results -->

