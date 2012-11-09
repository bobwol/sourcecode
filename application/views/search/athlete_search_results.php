<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- START: athlete_search_results -->
<div class="pgHeading">
	<h1>Athlete Search Results</h1> 
</div>
<?php 
if(sizeof($searchResult) == 0)
{
	echo '<p>There are no athletes that match the specified criteria.</p>';
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
		$listHeader='<thead><tr><th class="stdHdr" >Athlete</th><th class="stdHdr" >Organization Affiliation</th></tr></thead>';
	}
	echo "\n".$listBegin.$listHeader.$listBodyBegin."\n";
	foreach($searchResult as $sr)
	{				
		echo $rowBegin;
		echo $cellBegin.'<a href="/athlete/report/'.$sr->athleteid.'" data-ajax="false">';
		echo '<span class="itemTitle">'.$sr->lastName.', '.$sr->firstName.' ('.$sr->gender.')</span>'.$nonMobileAnchorClose.'<br />';
		echo $orgType[$sr->type];
		if($sr->type != 'TC') 
			echo ' '.$sr->academicYear;
		echo $cellEnd;
		echo $cellBegin.$sr->orgName.'<br />'.$sr->city.' '.$sr->state.' '.$sr->zip.$cellEnd;
		echo $mobileAnchorClose;
		echo $rowEnd."\n";
	}
	echo $listBodyEnd.$listEnd."\n";
}
?>
<!-- END: athlete_search_results -->

