<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Meet_model extends CI_Model
{
	const MAXDAYS = 4;
	const MAXDIVISIONS = 12;
	const DEFAULTHEIGHT = 2000;
	const DEFAULTWIDTH = 700;

	function __construct()
	{
		parent::__construct();
	}

	
	function get_meet_info($meetID)
	{
		$data = array();
		$queryString = "SELECT * FROM tblMeets WHERE meetID = '".$this->db->escape_str($meetID)."' limit 1";
		return $this->db->query($queryString);		
	}
				
	function get_meet_defaults()
	{
		$queryString = "SELECT venue, address1, address2, city, state, zip, contactName, contactEmail, contactPhone FROM tblOrganizations";
		$queryString = $queryString." WHERE user_id = '".$this->db->escape_str($this->session->userdata('user_id'))."' limit 1";
		return $this->db->query($queryString);	
	}

	function get_meet_dates($meetID)
	{
		$data = array();
		$queryString = "SELECT * FROM tblDates WHERE meetID = '".$this->db->escape_str($meetID)."' ORDER BY day";
		return $this->_setSelectResults($this->db->query($queryString));
	}

	function get_meet_divisions($meetID)
	{
		$data = array();
		$queryString = "SELECT * FROM tblDivisions WHERE meetID = '".$this->db->escape_str($meetID)."' ORDER BY divisionID";
		return $this->_setSelectResults($this->db->query($queryString));		
	}
	
	function get_meet_schedule($meetID, $day)
	{
		$data = array();
		$queryString = 'SELECT t1.seID, t1.eventID, t1.eventOrder, t1.allocatedTime, t1.heatDesc, t1.seSummary, t2.gender, t2.description, t3.eventName, t3.eventCategory';
		$queryString = $queryString." FROM tblScheduleEntries t1, tblDivisions t2, tblAllEvents t3"; 
		$queryString = $queryString." WHERE t1.divisionID = t2.divisionID and t1.eventID = t3.eventID"; 
		$queryString = $queryString." and t1.meetID = '".$this->db->escape_str($meetID)."'";
		$queryString = $queryString." and t2.meetID = '".$this->db->escape_str($meetID)."'";
		$queryString = $queryString." and t1.day = '".$this->db->escape_str($day)."'";
		$queryString = $queryString." ORDER by t3.eventCategory desc, t1.eventOrder";
		return $this->_setSelectResults($this->db->query($queryString));			
	}

	function get_eventlist($eventCategory)
	{
		$data = array();
		$this->db->where('eventCategory', strtoupper($eventCategory));
		$this->db->order_by('order');
		return $this->_setSelectResults($this->db->get('tblAllEvents'));						
	}

	function is_my_meet($meetID)
	{
		$queryString = "SELECT meetid FROM tblMeets";
		$queryString = $queryString." WHERE meetID = '".$this->db->escape_str($meetID)."'";
		$queryString = $queryString." and user_id = '".$this->session->userdata('user_id')."' limit 1";
		$rs = $this->db->query($queryString);
		return $rs->num_rows();
	}

	function number_of_events($meetID)
	{
		$queryString = "SELECT meetID FROM tblMeetEvents WHERE meetID = '".$this->db->escape_str($meetID)."'";
		$rs = $this->db->query($queryString);
		return $rs->num_rows();
	}

	function meet_exists_and_published($meetID)
	{
		$queryString = "SELECT meetID FROM tblMeets";
		$queryString = $queryString." WHERE meetID = '".$this->db->escape_str($meetID)."'";
		$queryString = $queryString." and published = '1' limit 1";
		$rs = $this->db->query($queryString);
		return $rs->num_rows();
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
/* End of file meetfinder_model.php */
/* Location: ./application/model/meetfinder_model.php */