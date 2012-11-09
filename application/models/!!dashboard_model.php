<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
	const MAXDAYS = 4;
	const MAXDIVISIONS = 12;
	const DEFAULTHEIGHT = 2000;
	const DEFAULTWIDTH = 700;

	function __construct()
	{
		parent::__construct();
	}
	
	function get_general_info()
	{
		$queryString = 'SELECT * FROM tblOrganizations WHERE user_id = "'.$this->db->escape_str($this->session->userdata('user_id')).'" limit 1';
		return $this->db->query($queryString);		
	}

	function get_meet_info($teamid)
	{
		$data = array();
		$queryString ='SELECT t1.meetID, t1.user_id as owner, t1.meetTitle, t1.venue, t1.city, t1.state, min(t2.startDate) as firstDay';
		$queryString = $queryString.' FROM tblMeets t1';
		$queryString = $queryString.' LEFT JOIN tblDates t2 ON t1.meetID = t2.meetID';
		$queryString = $queryString.' LEFT JOIN tblSeasonSchedules t3 ON t1.meetID = t3.meetID';
		$queryString = $queryString.' WHERE t3.teamID = "'.$this->db->escape_str($teamid).'"';
		$queryString = $queryString.' GROUP BY t1.meetid, t1.user_id, t1.meetTitle, t1.venue, t1.city, t1.state ORDER BY firstDay';
		$rs = $this->db->query($queryString);
		if($rs->num_rows() > 0)
		{
			foreach($rs->result() as $row)
			{
				$data[] = $row;
			}
		}
		return $data;
	}

	function is_my_meet($meetID)
	{
		$data = array();
		$retval = false;
		$queryString = "SELECT * FROM tblMeets WHERE meetID = '".$this->db->escape_str($meetID)."' limit 1";
		$rs = $this->db->query($queryString);
		if($rs->num_rows() > 0)
		{
			$row = $rs->row();
			if($row->user_id == $this->session->userdata('user_id'))
				$retval = true;		
		}
		return $retval;
	}

	function meet_exists_and_published($meetID)
	{
		$data = array();
		$retval = false;
		$queryString = "SELECT * FROM tblMeets WHERE meetID = '".$this->db->escape_str($meetID)."' limit 1";
		$rs = $this->db->query($queryString);
		if($rs->num_rows() > 0)
		{
			$row = $rs->row();
			if($row->published)
				$retval = true;		
		}
		return $retval;
	}

	function is_on_myteam($athleteid)
	{
		$data = array();
		$retval = false;
		$queryString = "SELECT * FROM tblAthletes WHERE athleteid = '".$this->db->escape_str($athleteid)."' limit 1";
		$rs = $this->db->query($queryString);
		if($rs->num_rows() > 0)
		{
			$row = $rs->row();
			if($row->teamid == $this->session->userdata('teamid'))
				$retval = true;		
		}
		return $retval;
	}

	function has_events_scheduled($meetID)
	{
		$retval = false;
		$queryString = "SELECT * FROM tblMeetEvents WHERE meetID = '".$this->db->escape_str($meetID)."'";
		$rs = $this->db->query($queryString);
		if($rs->num_rows() > 0)
		{
				$retval = true;		
		}
		return $retval;
	}

	function ins_meet_events($data)
	{
		$queryString = 'INSERT INTO tblMeetEvents (`meetID`, `eventID`) VALUES ';
		$queryString = $queryString.$data['meetEvents'];
		//echo $queryString;
		$rs = $this->db->query($queryString);
		return $rs;
	}

	function ins_meet_schedule($data)
	{
		$queryString = 'INSERT INTO tblScheduleEntries (`meetID`, `day`, `eventOrder`, `allocatedTime`, `eventID`, `divisionID`) VALUES ';
		$queryString = $queryString.$data['schedEntries'];
		//echo $queryString;
		$rs = $this->db->query($queryString);
		return $rs;
	}

	function get_athlete($athleteid)
	{
		$data = array();
		$queryString = "SELECT * FROM tblAthletes WHERE athleteid = '".$this->db->escape_str($athleteid)."' limit 1";
		return $this->db->query($queryString);		
	}
	

	function get_roster($teamid)
	{
		$data = array();
		$queryString = "SELECT * FROM tblAthletes WHERE teamid = '".$this->db->escape_str($teamid)."'";
		$rs = $this->db->query($queryString);
		if($rs->num_rows() > 0)
		{
			foreach($rs->result() as $row)
			{
				$data[] = $row;
			}
		}
		return $data;
	}

	function get_eventlist($eventCategory)
	{
		$data = array();
		$this->db->where('eventCategory', strtoupper($eventCategory));
		$this->db->order_by('order');
		$rs = $this->db->get('tblAllEvents');
		if($rs->num_rows() > 0)
		{
			foreach($rs->result() as $row)
			{
				$data[] = $row;
			}
		}
		return $data;				
	}

	function insert_rec($tbl, $data)
	{
		if($this->db->insert($tbl, $data))
		{
    	return $this->db->insert_id();
		} 
		else
		{
    	return false;
  	}
	}

	function update_rec($tbl, $pk, $data)
	{
		foreach ($pk as $fld => $val)
		{
			$this->db->where($fld, $val);
		}
		$result = $this->db->update($tbl, $data);
		if($result)
		{
    		return $val;
		} 
		else
		{
    		return false;
  		}
	}

	function delete_rec($tbl, $pk)
	{
		foreach ($pk as $fld => $val)
		{
			$this->db->where($fld, $val);
		}
		$result = $this->db->delete($tbl);
		if($result)
		{
    		return true;
		} 
		else
		{
    		return false;
  		}
	}

	function get_max_days() {
		return self::MAXDAYS;
	}
	function get_max_divs() {
		return self::MAXDIVISIONS;
	}
	function get_default_height() {
		return self::DEFAULTHEIGHT;
	}
	function get_default_width() {
		return self::DEFAULTWIDTH;
	}
}
/* End of file dashboard_model.php */
/* Location: ./application/model/dashboard_model.php */