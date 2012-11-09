<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Athlete_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_athlete($athleteid)
	{
		$data = array();
		$queryString = "SELECT t1.*, t2.teamid, t2.orgName, t2.city, t2.state";
		$queryString = $queryString." FROM tblAthletes t1";
		$queryString = $queryString." JOIN tblOrganizations t2 ON t1.teamid = t2.teamid";
		$queryString = $queryString." WHERE athleteid = '".$this->db->escape_str($athleteid)."' limit 1";
		return $this->db->query($queryString);		
	}

	function get_athlete_personal_recs($athleteid)
	{
		$data = array();
		$queryString = 'SELECT t1.athleteid, t1.eventID, t1.performance, t2.eventName, t2.eventCategory, t2.subCategory';
		$queryString = $queryString.' FROM tblPB t1';
		$queryString = $queryString.' JOIN tblAllEvents t2 ON t1.eventID = t2.eventID';
		$queryString = $queryString." WHERE athleteid = '".$this->db->escape_str($athleteid)."'";
		return $this->_setSelectResults($this->db->query($queryString));
	}

	function get_athlete_events($athleteid)
	{
		$data = array();
		$queryString = "SELECT * FROM tblAthleteEvents WHERE athleteid = '".$this->db->escape_str($athleteid)."'";
		return $this->_setSelectResults($this->db->query($queryString));
	}

	function ins_personal_best($data)
	{
		$queryString = 'INSERT INTO tblPB (`athleteid`, `eventID`, `performance`) VALUES ';
		$queryString = $queryString.$data['personalBests'];
		return $this->db->query($queryString);
	}

	function ins_athlete_events($data)
	{
		$queryString = 'INSERT INTO tblAthleteEvents (`athleteid`, `eventID`) VALUES ';
		$queryString = $queryString.$data['mySpecialties'];
		return $this->db->query($queryString);
	}

	function on_my_team($athleteid)
	{
		$data = array();
		$retval = false;
		$queryString = "SELECT athleteid FROM tblAthletes";
		$queryString = $queryString." WHERE athleteid = '".$this->db->escape_str($athleteid)."'";
		$queryString = $queryString." and teamid = '".$this->session->userdata('teamid')."' limit 1";
		$rs = $this->db->query($queryString);
		return $rs->num_rows();
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
/* End of file athlete_model.php */
/* Location: ./application/model/athlete_model.php */