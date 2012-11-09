<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Meetfinder extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url', 'html'));
		//$this->load->library('form_validation');
		date_default_timezone_set('America/Chicago');
		$this->load->model('Meetfinder_model', '', TRUE);
		if($this->session->userdata('device_type') == 'mobile')
		{
			$this->template->set('mNav_meetFinder', '');
			$this->template->set('mNav_teamFinder', '');
			$this->template->set('mNav_athleteFinder', '');
		}
	}

	function index()
	{
		if($this->session->userdata('device_type') == 'mobile')
		{
			$this->template->set('mNav_meetFinder', 'class="ui-btn-active ui-state-persist"');
			$this->template->load('tmpl_mobile', 'staticpages/incl_meetsearchform' );	
		}
		else
		{
			$this->template->set('leftColumn', 'staticpages/incl_meetsearchform');
			$this->template->load('tmpl_twocolumns', 'meetfinder/meet_search' );
		}
	}

	public function search_results()
	{	
		$data = array();
		$formData = array();
		
		if(isset($_POST['sMeetState']))
		{
			$formData = array(
				'sMeetTitle' => $this->input->post('sMeetTitle'),
				'sDateRange' => $this->input->post('sDateRange'),
				'sFirstDay' => $this->input->post('sFirstDay'),
				'sLastDay' => $this->input->post('sLastDay'),
				'sVenue' => $this->input->post('sMeetVenue'),
				'sCity' => $this->input->post('sMeetCity'),
				'sState' => $this->input->post('sMeetState')
			);
			$data['row'] = $this->Meetfinder_model->get_search_results($formData);
			if($this->session->userdata('device_type') == 'mobile')
			{
				$this->template->load('tmpl_mobile', 'meetfinder/meet_search_results', $data );	
			}
			else
			{
				$this->template->set('leftColumn', 'staticpages/incl_meetsearchform');
				$this->template->load('tmpl_twocolumns', 'meetfinder/meet_search_results', $data );
			}
		}
		else
		{
			redirect('meetfinder');
		}
		return;
	}

	public function view_meet()
	{	
		$data = array();
		$meetDaySched = array();
		$meetID = $this->uri->segment(3, 0);
		$meetDates = $this->Meetfinder_model->get_meet_dates($meetID);
		$data['meetInfo'] = $this->Meetfinder_model->get_meet_info($meetID)->row();
		$data['meetDivs'] = $this->Meetfinder_model->get_meet_divsions($meetID);
		$data['meetDayTab'] = $this->uri->segment(4, 1);
		$day = 1;
		foreach($meetDates as $tab)
		{
			$meetDaySched[] = array (
				'meetID' => $tab->meetID,
				'day' => $tab->day,
				'startDate' => $tab->startDate,
				'startTime' => $tab->startTime,
				'startTimeFE' => $tab->startTimeFE,
				'startTimeTE' => $tab->startTimeTE,
				'schedArr' => $this->Meetfinder_model->get_meet_schedule($tab->meetID, $tab->day)
			);
			$day++;
		}
		$data['meetDaySched'] = $meetDaySched;

		if($this->session->userdata('device_type') == 'mobile')
		{
			$this->template->load('tmpl_mobile', 'meetfinder/meet_report', $data );	
		}
		else
		{
			$this->template->set('leftColumn', 'staticpages/incl_meetsearchform');
			$this->template->load('tmpl_twocolumns', 'meetfinder/meet_report', $data );
		}
		return;
	}
}

/* End of file meetfinder.php */
/* Location: ./application/controllers/meetfinder.php */