<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Team_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_my_teamid()
	{
		$teamid = 0;
		$queryString = 'SELECT teamid FROM tblOrganizations WHERE user_id = "'.$this->db->escape_str($this->session->userdata('user_id')).'" limit 1';
		$rs = $this->db->query($queryString);
		if($rs->num_rows() > 0)
			$teamid = $rs->row()->teamid;
		return $teamid;		
	}
	
	function get_team_info($teamid)
	{
		$queryString = 'SELECT * FROM tblOrganizations WHERE teamid = "'.$this->db->escape_str($teamid).'" limit 1';
		return $this->db->query($queryString);		
	}

	function get_schedule($teamid)
	{
		$data = array();
		$queryString ='SELECT t1.meetID, t1.user_id as owner, t1.meetTitle, t1.venue, t1.city, t1.state, min(t2.startDate) as firstDay';
		$queryString = $queryString.' FROM tblMeets t1';
		$queryString = $queryString.' LEFT JOIN tblDates t2 ON t1.meetID = t2.meetID';
		$queryString = $queryString.' LEFT JOIN tblSeasonSchedules t3 ON t1.meetID = t3.meetID';
		$queryString = $queryString.' WHERE t3.teamID = "'.$this->db->escape_str($teamid).'"';
		$queryString = $queryString.' GROUP BY t1.meetid, t1.user_id, t1.meetTitle, t1.venue, t1.city, t1.state ORDER BY firstDay';
		return $this->_setSelectResults($this->db->query($queryString));
	}

	function get_roster($teamid)
	{
		$data = array();
		$queryString = "SELECT * FROM tblAthletes WHERE teamid = '".$this->db->escape_str($teamid)."'";
		return $this->_setSelectResults($this->db->query($queryString));
	}

	private function _setSelectResults($dbRecordSet)
	{
		$results = array();
		if($dbRecordSet->num_rows() > 0)
		{
			foreach($dbRecordSet->result() as $row)
			{
				$results[] = $row;
			}
		}
		return $results;	
	}	

}
/* End of file teamfinder_model.php */
/* Location: ./application/model/teamfinder_model.php */