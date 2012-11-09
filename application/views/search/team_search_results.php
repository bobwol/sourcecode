<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- START: team_search_results -->
<div class="pgHeading">
	<h1>Team Search Results</h1> 
</div>
<?php 
if(sizeof($searchResult) == 0)
{
	echo '<p>There are no teams that match the specified criteria.</p>';
}
else
{
	include(APPPATH.'/views/incl_listformat.php');
	if($this->session->userdata('device_type') != 'mobile')
	{
		echo "\n<script>$(function(){ $('.dataTable').dataTable({ ";
		echo "'sDom': 'f<\"clear\">t<\"tblFooter\"ip>','iDisplayLength': 50, 'bRetrieve': true, 'bPaginate': true, 'bLengthChange': false, 'bFilter': true, 'bSort': true, 'bInfo': true, 'bAutoWidth': false, 'bJQueryUI': true,'aaSorting': [[ 0, 'asc' ]]";
		echo "";
		echo "}); })</script>\n";
		$listHeader='<thead><tr><th class="stdHdr" >Organization</th><th class="stdHdr" >Location</th></tr></thead>';
	}
	echo "\n".$listBegin.$listHeader.$listBodyBegin."\n";
	foreach($searchResult as $sr)
	{				
		echo $rowBegin;
		echo $cellBegin.'<a href="/team/report/'.$sr->teamid.'" data-ajax="false"><span class="itemTitle">'.$sr->orgName.'</span>'.$nonMobileAnchorClose.$cellEnd;
		echo $cellBegin.$sr->city.' '.$sr->state.' '.$sr->zip.$cellEnd;
		echo $mobileAnchorClose;
		echo $rowEnd."\n";
	}
	echo $listBodyEnd.$listEnd."\n";
}
?>	
<!-- END: team_search_results -->

