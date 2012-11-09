<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Team extends CI_Controller
{
	private $teamData = array();

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'html'));
 		$this->load->library('form_validation');
		$this->load->model('Team_model', '', TRUE);
		$this->load->model('Crud_model', '', TRUE);
		date_default_timezone_set('America/Chicago');
	}

	public function index()
	{
		redirect('/search/');
	}


	/* REPORT
			Retrieves data about the team from the database and loads the report.
			The team to report on is specified as a URL parameter. 
	*/
	public function report()
	{	
		$teamid = $this->uri->segment(3, 0);
		$this->teamData['teamInfo'] = $this->Team_model->get_team_info($teamid)->row();
		$this->teamData['schedule'] = $this->Team_model->get_schedule($teamid);
		$this->teamData['roster'] = $this->Team_model->get_roster($teamid);
		$this->template->set('leftColumn', 'search/incl_teamsearchform');
		$this->template->loadTemplate('stdTwoColumns', 'team/report', $this->teamData);
	}

	/* EDIT
			Retrieves team general information from the database and loads the
			edit form with it. Accepts the submission of the form, validates it, 
			and if valid inserts or updates the db with the forms data
	*/
	public function edit()
	{	
		if(!isset($_POST['frmAction']))
		{
			$this->teamData['teamInfo'] = $this->Team_model->get_team_info($this->session->userdata('teamid'))->row();
			$this->teamData['frmAction'] = 'update';
			$this->template->load('tmpl_onecolumn', 'team/edit_form', $this->teamData );
		}
		else
		{
			if ($this->form_validation->run() == FALSE)
			{
				$this->template->load('tmpl_onecolumn', 'team/edit_form');
			}
			else
			{
		    $this->teamData['orgName'] = $this->input->post('orgName');
				$this->teamData['type'] = $this->input->post('type');
				$this->teamData['mascot'] = $this->input->post('mascot');
				$this->teamData['venue'] = $this->input->post('venue');
				$this->teamData['address1'] = $this->input->post('address1');
				$this->teamData['address2'] = $this->input->post('address2');
				$this->teamData['city'] = $this->input->post('city');
				$this->teamData['state'] = $this->input->post('state');
				$this->teamData['zip'] = $this->input->post('zip');
				$this->teamData['contactName'] = $this->input->post('contactName');
				$this->teamData['contactEmail'] = $this->input->post('contactEmail');
				$this->teamData['contactPhone'] = $this->input->post('contactPhone');
				if(strtoupper($this->input->post('frmAction')) == 'UPDATE')
				{
					$pk = array( 'teamid' => $this->session->userdata('teamid'));
					$successful = $this->Crud_model->update_rec('tblOrganizations', $pk, $this->teamData);
				}
				else
				{
					$this->teamData['user_id'] = $this->session->userdata('user_id');
					$successful = $this->Crud_model->insert_rec('tblOrganizations', $this->teamData);
				}
				$this->Crud_model->set_transaction_message($this->input->post('frmAction'), $successful); 
				redirect('/dashboard/');
			}
		}
	}
}
/* End of file team_controller.php */
/* Location: ./application/controllers/team_controller.php */