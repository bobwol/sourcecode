<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Athlete extends CI_Controller
{
	private $athleteData = array();

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'html'));
 		$this->load->library('form_validation');
		$this->load->model('Athlete_model', '', TRUE);
		$this->load->model('Meet_model', '', TRUE);
		$this->load->model('Crud_model', '', TRUE);
		date_default_timezone_set('America/Chicago');
	}

	public function index()
	{
			redirect('/search/');
	}


	public function report()
	{	
		$athleteid = $this->uri->segment(3, 0);
		$rs = $this->Athlete_model->get_athlete($athleteid);
		$this->athleteData['athleteProfile'] = $rs->row();
		$this->athleteData['personalBest'] = $this->Athlete_model->get_athlete_personal_recs($athleteid);		
		$this->template->set('leftColumn', 'search/incl_athletesearchform');
		$this->template->loadTemplate('stdTwoColumns', 'athlete/report', $this->athleteData);
	}
	
	
	public function edit()
	{		
		if(!isset($_POST['frmAction']))
		{
			$athleteid = $this->uri->segment(3, 0);
			if($athleteid == 0)
			{
				$this->athleteData['frmAction'] = 'Insert';
				$this->athleteData['athleteInfo'] = array();
			}
			else
			{
				if(!$this->Athlete_model->on_my_team($athleteid))
				{
					$this->Crud_model->set_transaction_message('This athlete isn\'t a member of your team.', 0); 
					redirect('/dashboard/');
				}
				else
				{
					$this->athleteData['frmAction'] = 'Update';
					$this->athleteData['athleteInfo'] = $this->Athlete_model->get_athlete($athleteid)->row();	
				}
			}
			$this->template->load('tmpl_onecolumn', 'athlete/edit_form', $this->athleteData );
		}
		else
		{
			if ($this->form_validation->run() == FALSE)
			{
				$this->template->load('tmpl_onecolumn', 'athlete/edit_form');
			}
			else
			{
				$this->athleteData['firstName'] = $this->input->post('firstName');
				$this->athleteData['lastName'] = $this->input->post('lastName');
				$this->athleteData['gender'] = $this->input->post('gender');
				$this->athleteData['dob'] = strftime("%Y-%m-%d ", strtotime($this->input->post('dob')));
				$this->athleteData['academicYear'] = $this->input->post('academicYear');
				$this->athleteData['contactEmail'] = $this->input->post('contactEmail');
				$this->athleteData['contactPhone'] = $this->input->post('contactPhone');
				$this->athleteData['alternateContact'] = $this->input->post('alternateContact');
				$this->athleteData['alternateEmail'] = $this->input->post('alternateEmail');
				$this->athleteData['alternatePhone'] = $this->input->post('alternatePhone');
				$this->athleteData['relationship'] = $this->input->post('relationship');
				$this->athleteData['published'] = $this->input->post('published');
				if(strtoupper($this->input->post('frmAction')) == 'UPDATE')
				{
					$athleteid = $this->input->post('athleteid');
					if(!$this->Athlete_model->on_my_team($athleteid))
					{
						$this->Crud_model->set_transaction_message('This athlete isn\'t a member of your team.', 0); 
						redirect('/dashboard/');
					}
					else
					{
						$pk = array( 'athleteid' => $athleteid);
						$successful = $this->Crud_model->update_rec('tblAthletes', $pk, $this->athleteData);
					}
				}
				else
				{
					$this->athleteData['teamid'] = $this->session->userdata('teamid');
					$successful = $this->Crud_model->insert_rec('tblAthletes', $this->athleteData);
				}
				$this->Crud_model->set_transaction_message($this->input->post('frmAction'), $successful); 
				redirect('/dashboard/');
			}
		}
	}

	public function delete()
	{
		if(!isset($_POST['athleteid']))
		{
			$this->Crud_model->set_transaction_message('Athlete not specified.', 0); 
		}
		else
		{
			$athleteid = $this->input->post('athleteid');
			if(!$this->Athlete_model->on_my_team($athleteid))
			{
				$this->Crud_model->set_transaction_message('This athlete isn\'t a member of your team.', 0);
			}
			else
			{
				$pk = array('athleteid' => $athleteid);
				$successful = $this->Crud_model->delete_rec('tblAthletes', $pk);
				$this->Crud_model->set_transaction_message('Deletion', $successful);
			}
		}
		redirect('dashboard');
	}

	public function edit_events()
	{	
		if(!isset($_POST['athleteid']))
		{
			$this->Crud_model->set_transaction_message('Athlete not specified.', 0); 
		}
		else
		{	
			$athleteid = $this->input->post('athleteid');
			if(!$this->Athlete_model->on_my_team($athleteid))
			{
				$this->Crud_model->set_transaction_message('This athlete isn\'t a member of your team.', 0);
				redirect('dashboard');
			}
			else
			{
				if(isset($_POST['personalBests']) && isset($_POST['mySpecialties'])) {
					$this->athleteData['personalBests'] = $this->input->post('personalBests');
					$this->athleteData['mySpecialties'] = $this->input->post('mySpecialties');
					$pk = array( 'athleteid' => $athleteid );
					$delSuccess1 = $this->Crud_model->delete_rec('tblPB', $pk);
					$insSuccess1 = $this->Athlete_model->ins_personal_best($this->athleteData);
					$delSuccess2 = $this->Crud_model->delete_rec('tblAthleteEvents', $pk);
					$insSuccess2 = $this->Athlete_model->ins_athlete_events($this->athleteData); 
					if($delSuccess1 && $insSuccess1 && $delSuccess2 && $insSuccess2)
					{
						$this->Crud_model->set_transaction_message('Transaction.', 1); 
					}
					else
					{
						$this->Crud_model->set_transaction_message('Transaction.', 0); 
					}
					redirect('dashboard');			
				} else {
					$this->athleteData['athleteid'] = $athleteid;
					$this->athleteData['subTitle'] = $this->input->post('firstName').' '.$this->input->post('lastName') .' - '.$this->input->post('academicYear');
					$this->athleteData['trackEvent'] = $this->Meet_model->get_eventlist('TRACK');
					$this->athleteData['fieldEvent'] = $this->Meet_model->get_eventlist('FIELD');
					$this->athleteData['specialties'] = $this->Athlete_model->get_athlete_events($athleteid);						
					$this->athleteData['personalBest'] = $this->Athlete_model->get_athlete_personal_recs($athleteid);						
					$this->template->load('tmpl_onecolumn', 'athlete/edit_events_form', $this->athleteData );
				}
			}
		}
	}

}
/* End of file athlete_controller.php */
/* Location: ./application/controllers/athlete_controller.php */
