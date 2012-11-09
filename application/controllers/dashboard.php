<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	private $csrf_threat = NULL;
	private $dashboardData = array();

	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('device_type') == 'mobile')
			header('Location: http://nallitrack.com/search');
		if(!$this->session->userdata('user_id'))
			header('Location: http://nallitrack.com/go/register');
		$this->load->helper(array('form', 'url', 'html'));
		$this->load->library('template');
		$this->load->model('Team_model', '', TRUE);		
		date_default_timezone_set('America/Chicago');
	}
	
	public function index()
	{
		$teamid = $this->Team_model->get_my_teamid();
		$this->session->set_userdata('teamid', $teamid); 
		$this->dashboardData['teamInfo'] = $this->Team_model->get_team_info($teamid)->row();
		$this->dashboardData['schedule'] = $this->Team_model->get_schedule($teamid);
		$this->dashboardData['roster'] = $this->Team_model->get_roster($teamid);
		$this->template->load('tmpl_onecolumn', 'dashboard/dashboard_home', $this->dashboardData );
	}	
}
/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */