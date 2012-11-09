<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	$listHeader = '';
	if($this->session->userdata('device_type') == 'mobile')
	{
		$listBegin ='<ul data-role="listview" data-filter="true" data-inset="true" class="">';
		$listEnd='</ul>';
		$listBodyBegin ='';
		$listBodyEnd ='';
		$rowBegin='<li>';
		$rowEnd='</li>';
		$cellBegin='';
		$cellEnd='<br />';
		$mobileAnchorClose='</a>';
		$nonMobileAnchorClose='';
	}
	else
	{
		$listBegin='<table class="dataTable full" >';
		$listEnd='</table>';
		$listBodyBegin ='<tbody>';
		$listBodyEnd ='</tbody>';
		$rowBegin='<tr>';
		$rowEnd='</tr>';
		$cellBegin='<td>';
		$cellEnd='</td>';
		$mobileAnchorClose='';
		$nonMobileAnchorClose='</a>';
	}

	function write_field($fldData, $divider) 
	{
		$tmp = '';
		if($fldData != '' )
		{
			switch($divider)
			{
				case 'li':
					$tmp = '<li>'.$fldData.'</li>';
					break;
				case '()':
					$tmp = '('.$fldData.')';
					break;
				case '[]':
					$tmp = '['.$fldData.']';
					break;
				case '{}':
					$tmp = '{'.$fldData.'}';
					break;
				default:
					$tmp = $divider.$fldData;
			}		
		}
		return $tmp;
	}
?>
