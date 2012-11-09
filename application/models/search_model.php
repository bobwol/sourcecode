<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_meet_search_results($queryParams)
	{
		$queryString = "SELECT t1.meetID, t1.meetTitle, t1.venue, t1.city, t1.state, t1.zip, t2.day, t2.startDate, t2.startTime";
		$queryString = $queryString." FROM tblMeets t1 INNER JOIN tblDates t2 ON t1.meetid = t2.meetid";
		$queryString = $queryString." WHERE published = '1' and state = ".$this->db->escape($queryParams['sMeetState']);

		if(!empty($queryParams['sMeetTitle']))
		{
			$queryString = $queryString." and UPPER(meetTitle) LIKE UPPER('%".$this->db->escape_like_str($queryParams['sMeetTitle'])."%')";
    }
		if(!empty($queryParams['sMeetVenue']))
		{
			$queryString = $queryString." and UPPER(venue) LIKE UPPER('%".$this->db->escape_like_str($queryParams['sMeetVenue'])."%')";
    }
		if(!empty($queryParams['sMeetCity']))
		{
			$queryString = $queryString." and UPPER(city) LIKE UPPER('%".$this->db->escape_like_str($queryParams['sMeetCity'])."%')";
    }
		if($queryParams['sDateRange'] == 'month')
		{
			$queryString = $queryString." and startDate >= '".$this->db->escape_str($queryParams['sFirstDay'])."' and startDate <= '".$this->db->escape_str($queryParams['sLastDay'])."'";
    	}
    	else
    	{
    	$queryString = $queryString." and startDate = '".$this->db->escape_str($queryParams['sFirstDay'])."'";
   	}
    $queryString = $queryString." ORDER by t2.startDate limit 250";
		return $this->_setSearchResults($this->db->query($queryString));
	}

	
	function get_team_search_results($queryParams)
	{
		$searchResults = array();
		$queryString = "SELECT * ";
		$queryString = $queryString." FROM tblOrganizations";
		$queryString = $queryString." WHERE state = ".$this->db->escape($queryParams['sOrgState']);
		$queryString = $queryString." and type = ".$this->db->escape($queryParams['sOrgType']);
		if(!empty($queryParams['sMeetTitle']))
		{
			$queryString = $queryString." and UPPER(orgName) LIKE UPPER('%".$this->db->escape_like_str($queryParams['sOrgName'])."%')";
    }
		if(!empty($queryParams['sOrgCity']))
		{
			$queryString = $queryString." and UPPER(city) LIKE UPPER('%".$this->db->escape_like_str($queryParams['sOrgCity'])."%')";
    }
    $queryString = $queryString." ORDER by orgName limit 250";
		return $this->_setSearchResults($this->db->query($queryString));
	}


	function get_athlete_search_results($queryParams)
	{
		$queryString = "SELECT t1.athleteid, t1.teamid, t1.firstName, t1.lastName, t1.gender, t1.academicYear, t2.orgName, t2.type, t2.city, t2.state, t2.zip";
		$queryString = $queryString." FROM tblAthletes t1 INNER JOIN tblOrganizations t2 ON t1.teamid = t2.teamid";
		$queryString = $queryString." WHERE published = '1' and state = ".$this->db->escape($queryParams['sOrgAffilState']);
		$queryString = $queryString." and type = ".$this->db->escape($queryParams['sOrgAffilType']);
		$queryString = $queryString." and gender = ".$this->db->escape($queryParams['sGender']);
		if(!empty($queryParams['sOrgAffilName']))
		{
			$queryString = $queryString." and UPPER(orgName) LIKE UPPER('%".$this->db->escape_like_str($queryParams['sOrgAffilName'])."%')";
    }
		if(!empty($queryParams['sLastName']))
		{
			$queryString = $queryString." and UPPER(lastName) LIKE UPPER('%".$this->db->escape_like_str($queryParams['sLastName'])."%')";
    }
    	$queryString = $queryString." ORDER by lastName limit 250";
		return $this->_setSearchResults($this->db->query($queryString));
	}


	private function _setSearchResults($dbRecordSet)
	{
		$searchResults = array();
		if($dbRecordSet->num_rows() > 0)
		{
			foreach($dbRecordSet->result() as $row)
			{
				$searchResults[] = $row;
			}
		}
		return $searchResults;	
	}	

}
/* End of file search_model.php */
/* Location: ./application/model/search_model.php */