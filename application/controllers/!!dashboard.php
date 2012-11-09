<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	private $csrf_threat = NULL;

	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('device_type') == 'mobile')
			header('Location: http://nallitrack.com/search');
		if(!$this->session->userdata('user_id'))
			redirect('/go/register');
 		$this->load->library('form_validation');
		$this->load->library('template');
		$this->load->helper(array('form', 'url'));
		$this->load->helper('html');
		date_default_timezone_set('America/Chicago');
		$this->load->model('Dashboard_model', '', TRUE);		
		$this->load->model('Meetfinder_model', '', TRUE);
	}
	
	public function index()
	{
		$data = array();
		$data['generalInfo'] = $this->Dashboard_model->get_general_info()->row();
		$this->session->set_userdata('teamid', $data['generalInfo']->teamid);
		$this->session->set_userdata('venue', $data['generalInfo']->venue);
		$this->session->set_userdata('address1', $data['generalInfo']->address1);
		$this->session->set_userdata('address2', $data['generalInfo']->address2);
		$this->session->set_userdata('city', $data['generalInfo']->city);
		$this->session->set_userdata('state', $data['generalInfo']->state);
		$this->session->set_userdata('zip', $data['generalInfo']->zip);
		$this->session->set_userdata('contactName', $data['generalInfo']->contactName);
		$this->session->set_userdata('contactEmail', $data['generalInfo']->contactEmail);
		$this->session->set_userdata('contactPhone', $data['generalInfo']->contactPhone);
		$this->session->set_userdata('teamSchedule', '');
		$this->session->set_userdata('maxDays', $this->Dashboard_model->get_max_days());
		$this->session->set_userdata('maxDivs', $this->Dashboard_model->get_max_divs());

		$data['meetInfo'] = $this->Dashboard_model->get_meet_info($this->session->userdata('teamid'));
		$data['roster'] = $this->Dashboard_model->get_roster($this->session->userdata('teamid'));
		$this->template->load('tmpl_onecolumn', 'dashboard/dashboard_home', $data );
	}	

	function edit_generalinfo()
	{	
		$data = array();
		if(isset($_POST['teamid']))
		{
			if ($this->form_validation->run() == FALSE)
			{
				$this->template->load('tmpl_onecolumn', 'dashboard/edit_generalinfo');
			}
			else
			{
	    	$data['orgName'] = $this->input->post('orgName');
				$data['type'] = $this->input->post('type');
				$data['mascot'] = $this->input->post('mascot');
				$data['venue'] = $this->input->post('venue');
				$data['address1'] = $this->input->post('address1');
				$data['address2'] = $this->input->post('address2');
				$data['city'] = $this->input->post('city');
				$data['state'] = $this->input->post('state');
				$data['zip'] = $this->input->post('zip');
				$data['contactName'] = $this->input->post('contactName');
				$data['contactEmail'] = $this->input->post('contactEmail');
				$data['contactPhone'] = $this->input->post('contactPhone');
				$pk = array( 'teamid' => $this->session->userdata('teamid'));
				if($this->Dashboard_model->update_rec('tblOrganizations', $pk, $data))
				{
					$msg = 'Your update was successfully saved...';
				}
				else
				{
					$msg = '**ERROR: Could not save the changes...';
				}
				$this->session->set_flashdata('flash_message', $msg );
				redirect('dashboard');
			}
		}
		else
		{
			$data['generalInfo'] = $this->Dashboard_model->get_general_info()->row();
			$this->template->load('tmpl_onecolumn', 'dashboard/edit_generalinfo', $data );
		}
	}

	function edit_meet()
	{
		$data = array();
		$dv = array();
		$dt = array();
		if(isset($_POST['meetID']))
		// submitted for validation and insert/update int DB
		{
			if ($this->form_validation->run() == FALSE)
			{
				// invalid so return to edit the form
				$this->template->load('tmpl_onecolumn', 'dashboard/edit_meet' );
			}
			else
			{
				// form validates so grab form variables and prepare for insert/update
				$meetID = $this->input->post('meetID');
				$data['meetTitle'] = $this->input->post('meetTitle');
				$data['meetType'] = $this->input->post('meetType');
				$data['venue'] = $this->input->post('venue');
				$data['address1'] = $this->input->post('address1');
				$data['address2'] = $this->input->post('address2');
				$data['city'] = $this->input->post('city');
				$data['state'] = $this->input->post('state');
				$data['zip'] = $this->input->post('zip');
				$data['contactName'] = $this->input->post('contactName');
				$data['contactPhone'] = $this->input->post('contactPhone');
				$data['contactEmail'] = $this->input->post('contactEmail');
				$data['points1st'] = $this->input->post('points1st');
				$data['points2nd'] = $this->input->post('points2nd');
				$data['points3rd'] = $this->input->post('points3rd');
				$data['points4th'] = $this->input->post('points4th');
				$data['points5th'] = $this->input->post('points5th');
				$data['points6th'] = $this->input->post('points6th');
				$data['points7th'] = $this->input->post('points7th');
				$data['points8th'] = $this->input->post('points8th');
				$data['points9th'] = $this->input->post('points9th');
				$data['points10th'] = $this->input->post('points10th');
				$data['scores'] = $this->input->post('scores');
				$data['participantInfo'] = $this->input->post('participantInfo');
				$data['spectatorInfo'] = $this->input->post('spectatorInfo');
				$data['published'] = $this->input->post('published');
				$msg = '**ERROR: Could not save the meet...';
				if($meetID == 0) 
				{
					//meetID = 0 means it's a new meet so do an INSERT
					$data['user_id'] = $this->session->userdata('user_id');
					if($newID = $this->Dashboard_model->insert_rec('tblMeets', $data))
					{
						//Insert divisions
						for($i=1; $i <= $this->input->post('numOfDivs'); $i++)
						{
							$dv['meetID'] = $newID;
							$dv['divisionID'] = $i;
							$dv['gender'] = $this->input->post('genderDiv'.$i);
							$dv['description'] = $this->input->post('divName'.$i);
							$this->Dashboard_model->insert_rec('tblDivisions', $dv);
						}	
						// Insert dates	
						for($i=1; $i<= $this->input->post('numOfDays'); $i++)
						{
							$dt['meetID'] = $newID;
							$dt['day'] = $i;
							$dt['startDate'] = strftime("%Y-%m-%d ", strtotime($this->input->post('meetDay'.$i)));
							$startTimeTE = strtotime($this->input->post('startTimeTRACKDay'.$i).' '.$this->input->post('startTimeTRACKDay'.$i.'_AMPM'));
							$dt['startTimeTE'] = strftime("%H:%M ", $startTimeTE);
							$startTimeFE = strtotime($this->input->post('startTimeFIELDDay'.$i).' '.$this->input->post('startTimeFIELDDay'.$i.'_AMPM'));
							$dt['startTimeFE'] = strftime("%H:%M ", $startTimeFE);
							if($startTimeTE > $startTimeFE)
							{
								$dt['startTime'] = strftime("%H:%M ", $startTimeFE);
							}
							else
							{
								$dt['startTime'] = strftime("%H:%M ", $startTimeTE);
							}
							$this->Dashboard_model->insert_rec('tblDates', $dt);
						}
						// also, automatically INSERT it to the owner's season schedule 	
						$pk = array('meetID' => $newID ,'teamID' => $this->session->userdata('teamid'));
						if($this->Dashboard_model->insert_rec('tblSeasonSchedules', $pk))
						$msg = 'Your new meet was successfully added...';
					}
				}
				else
				{
					//Update meet information
					$pk = array( 'meetID' => $meetID);
					if($this->Dashboard_model->update_rec('tblMeets', $pk, $data))
					{

						// ** handle divisions
						$numOfDivs = $this->input->post('numOfDivs');  
						$orgNumOfDivs = $this->input->post('orgNumOfDivs');  
						$numUpdates = min($orgNumOfDivs, $numOfDivs);
						$topRec = max($orgNumOfDivs, $numOfDivs);
						for ($i = 1; $i <= $numUpdates; $i++ )
						{
							$pk = array( 'meetID' => $meetID, 'divisionID' => $i );
							$dv['gender'] = $this->input->post('genderDiv'.$i);
							$dv['description'] = $this->input->post('divName'.$i);
							$this->Dashboard_model->update_rec('tblDivisions', $pk, $dv);
						}
						for ($i = ($numUpdates+1); $i <= $topRec; $i++)
						{
							if($orgNumOfDivs > $numOfDivs)
							{
								$pk = array( 'meetID' => $meetID, 'divisionID' => $i );
								$this->Dashboard_model->delete_rec('tblDivisions',$pk);
							}
							else
							{
								$dv['meetID'] = $meetID;
								$dv['divisionID'] = $i;
								$dv['gender'] = $this->input->post('genderDiv'.$i);
								$dv['description'] = $this->input->post('divName'.$i);
								$this->Dashboard_model->insert_rec('tblDivisions', $dv);				
							}
						}
			
						// ** handle dates
						$numOfDays = $this->input->post('numOfDays');  
						$orgNumOfDays = $this->input->post('orgNumOfDays');  
						$numUpdates = min($orgNumOfDays, $numOfDays);
						$topRec = max($orgNumOfDays, $numOfDays);
						for ($i = 1; $i <= $numUpdates; $i++)
						{
							$pk = array( 'meetID' => $meetID, 'day' => $i );
							$dt['startDate'] = strftime("%Y-%m-%d ", strtotime($this->input->post('meetDay'.$i)));
							$startTimeTE = strtotime($this->input->post('startTimeTRACKDay'.$i).' '.$this->input->post('startTimeTRACKDay'.$i.'_AMPM'));
							$dt['startTimeTE'] = strftime("%H:%M ", $startTimeTE);
							$startTimeFE = strtotime($this->input->post('startTimeFIELDDay'.$i).' '.$this->input->post('startTimeFIELDDay'.$i.'_AMPM'));
							$dt['startTimeFE'] = strftime("%H:%M ", $startTimeFE);
							if($startTimeTE > $startTimeFE)
							{
								$dt['startTime'] = strftime("%H:%M ", $startTimeFE);
							}
							else
							{
								$dt['startTime'] = strftime("%H:%M ", $startTimeTE);
							}
							$this->Dashboard_model->update_rec('tblDates', $pk, $dt);
						}
						for ($i = ($numUpdates+1); $i <= $topRec; $i++) 
						{
							if($orgNumOfDays > $numOfDays) {
								$pk = array( 'meetID' => $meetID, 'day' => $i );
								$this->Dashboard_model->delete_rec('tblDates',$pk);
							} 
							else
							{
								$dt['meetID'] = $meetID;
								$dt['day'] = $i;
								$dt['startDate'] = strftime("%Y-%m-%d ", strtotime($this->input->post('meetDay'.$i)));
								$startTimeTE = strtotime($this->input->post('startTimeTRACKDay'.$i).' '.$this->input->post('startTimeTRACKDay'.$i.'_AMPM'));
								$dt['startTimeTE'] = strftime("%H:%M ", $startTimeTE);
								$startTimeFE = strtotime($this->input->post('startTimeFIELDDay'.$i).' '.$this->input->post('startTimeFIELDDay'.$i.'_AMPM'));
								$dt['startTimeFE'] = strftime("%H:%M ", $startTimeFE);
								if($startTimeTE > $startTimeFE)
								{
									$dt['startTime'] = strftime("%H:%M ", $startTimeFE);
								}
								else
								{
									$dt['startTime'] = strftime("%H:%M ", $startTimeTE);
								}
								$this->Dashboard_model->insert_rec('tblDates', $dt);
							}
						}
						$msg = 'Your update was successfully saved...';
					}
				}					
				$this->session->set_flashdata('flash_message', $msg );
				redirect('dashboard');
			}
		}
		else
		{
			$meetID = $this->uri->segment(3, 0);
			if($meetID == 0)
			{
				$this->template->load('tmpl_onecolumn', 'dashboard/edit_meet', $data );
			}
			else
			{
				$data['hasEventsScheduled'] = $this->Dashboard_model->has_events_scheduled($meetID);
				$data['meetDates'] = $this->Meetfinder_model->get_meet_dates($meetID);
				$data['meetDivs'] = $this->Meetfinder_model->get_meet_divsions($meetID);
				$rs = $this->Meetfinder_model->get_meet_info($meetID);
				if($rs->num_rows() > 0)
				{
					$data['meetInfo'] = $rs->row();
					if($this->session->userdata('user_id') == $data['meetInfo']->user_id)
					{
						$this->template->load('tmpl_onecolumn', 'dashboard/edit_meet', $data );
					}
					else
					{
						$msg = '**ERROR: Meet '.$meetID.' does not belong to you...';
						$this->session->set_flashdata('flash_message', $msg );
						redirect('dashboard');
					}
				}
				else
				{
					$msg = '**ERROR: Meet '.$meetID.' does not exist...';
					$this->session->set_flashdata('flash_message', $msg );
					redirect('dashboard');
				}
			}
		}
	}

	function remove_from_schedule()
	{	
		$meetID = $this->uri->segment(3, 0);
		if(!$meetID)
		{
			$msg = '**ERROR: A meet ID was not specified...';
		}
		else
		{
			if($this->Dashboard_model->is_my_meet($meetID))
			{
				$msg = '**ERROR: To remove your own meet from your own schedule you must delete it. ';
			}
			else
			{
				if(!$this->Dashboard_model->meet_exists_and_published($meetID))
				{
					$msg = '**ERROR: This meet does not exist or isn\'t published. ';
				}
				else
				{
					$pk = array('meetID' => $meetid ,'teamID' => $this->session->userdata('teamid'));
					if($this->Dashboard_model->delete_rec('tblSeasonSchedules', $pk))
					{
						$msg = 'Meet '.$meetID.' removed from your schedule...';
					}
					else
					{
						$msg = '**ERROR: Could not remove meet '.$meetID.' from your schedule...';
					}
				}
			}
		}
		$this->session->set_flashdata('flash_message', $msg );
		redirect('dashboard');
	}

	function add_to_schedule()
	{	
		$meetID = $this->uri->segment(3, 0);
		if(!$meetID)
		{
			$msg = '**ERROR: A meet ID was not specified...';
		}
		else
		{
			if($this->Dashboard_model->is_my_meet($meetID))
			{
				$msg = '**ERROR: Your own meet is always on your own schedule. It can\'t be added again. ';
			}
			else
			{
				if(!$this->Dashboard_model->meet_exists_and_published($meetID))
				{
					$msg = '**ERROR: This meet does not exist or isn\'t published. ';
				}
				else
				{
					$pk = array('meetID' => $meetid ,'teamID' => $this->session->userdata('teamid'));
					if($this->Dashboard_model->insert_rec('tblSeasonSchedules', $pk))
					{
						$msg = 'Meet '.$meetID.' added to your schedule...';
					}
					else
					{
						$msg = '**ERROR: Could not add meet '.$meetID.' to your schedule...';
					}
				}
			}
		}
		$this->session->set_flashdata('flash_message', $msg );
		redirect('dashboard');
	}

	function delete_meet()
	{	
		$data = array();
		if(!isset($_POST['meetID']))
		{
			$msg = "**ERROR: A meet ID was not specified...";			
		}
		else
		{
			$meetID = $_POST['meetID'];
			if(!$this->Dashboard_model->is_my_meet($meetID))
			{
				$msg = '**ERROR: Meet '.$meetID.' does not belong to you...';			
			}
			else
			{
				$pk = array('meetID' => $meetID);
				if($this->Dashboard_model->delete_rec('tblMeets', $pk))
				{
					$msg = 'Meet '.$meetID.' deleted...';
				}
				else
				{
				$msg = '**Error: Could not delete meet '.$meetID.'...';
				}
			}
		}
		$this->session->set_flashdata('flash_message', $msg );
		redirect('dashboard');
	}

	function generate_schedule()
	{	
		$data = array();
		if(!isset($_POST['meetID']))
		{
			$msg = "**ERROR: A meet ID was not specified...";			
			$this->session->set_flashdata('flash_message', $msg );
			redirect('dashboard');
		}
		else
		{	
			$meetID = $this->input->post('meetID');
			if(!$this->Dashboard_model->is_my_meet($meetID))
			{
				$msg = '**ERROR: Meet '.$meetID.' does not belong to you...';			
				$this->session->set_flashdata('flash_message', $msg );
				redirect('dashboard');
			}
			else
			{
				$data['meetID'] = $meetID;
				$data['meetTitle'] = $this->input->post('meetTitle');
				$data['meetType'] = $this->input->post('meetType');
				$data['hasEventsScheduled'] = $this->Dashboard_model->has_events_scheduled($meetID);
				$data['meetDivs'] = $this->Meetfinder_model->get_meet_divsions($meetID);
				$data['noOfDays'] = sizeof($this->Meetfinder_model->get_meet_dates($meetID));
				$data['trackEvent'] = $this->Dashboard_model->get_eventlist('TRACK');
				$data['fieldEvent'] = $this->Dashboard_model->get_eventlist('FIELD');
				$this->template->load('tmpl_onecolumn', 'dashboard/generate_schedule', $data );
			}
		}
	}

	function adjust_schedule()
	{	
		$data = array();
		if(!isset($_POST['meetID']))
		{
			$msg = "**ERROR: A meet ID was not specified...";			
			$this->session->set_flashdata('flash_message', $msg );
			redirect('dashboard');
		}
		else
		{	
			$meetID = $this->input->post('meetID');
			if(!$this->Dashboard_model->is_my_meet($meetID))
			{
				$msg = '**ERROR: Meet '.$meetID.' does not belong to you...';			
				$this->session->set_flashdata('flash_message', $msg );
				redirect('dashboard');
			}
			else
			{
				$data['meetID'] = $meetID;
				$data['meetTitle'] = $this->input->post('meetTitle');
				$data['meetType'] = $this->input->post('meetType');
				$data['hasEventsScheduled'] = $this->Dashboard_model->has_events_scheduled($meetID);
				$this->template->load('tmpl_onecolumn', 'dashboard/adjust_schedule', $data );
			}
		}
	}

	function regenerate_schedule()
	{	
		$data = array();
		if(!isset($_POST['meetID']))
		{
			$msg = "**ERROR: A meet ID was not specified...";			
		}
		else
		{
			$meetID = $_POST['meetID'];
			if(!$this->Dashboard_model->is_my_meet($meetID))
			{
				$msg = '**ERROR: Meet '.$meetID.' does not belong to you...';			
			}
			else
			{
				$data['meetEvents'] = $this->input->post('meetEvents');
				$data['schedEntries'] = $this->input->post('schedEntries');
				$pk = array( 'meetID' => $meetID );
				$this->Dashboard_model->delete_rec('tblMeetEvents', $pk);
				if($this->Dashboard_model->ins_meet_events($data))
				{
					$this->Dashboard_model->delete_rec('tblScheduleEntries', $pk);
					if($this->Dashboard_model->ins_meet_schedule($data))
					{
						$msg = 'A new schedule was generate for '.$this->input->post('meetTitle').'...';
					}
					else
					{
						$msg = '**ERROR: Could not generate schedule...';
					}
				}
				else 
				{
					$msg = '**ERROR: Could not generate schedule...';
				}				
			}
		}
		$this->session->set_flashdata('flash_message', $msg );
		redirect('dashboard');
	}

	function assign_athletes()
	{	
		$data = array();
		if(!isset($_POST['meetID']))
		{
			$msg = "**ERROR: A meet ID was not specified...";			
		}
		else
		{
			$meetID = $_POST['meetID'];
			if(!$this->Dashboard_model->is_my_meet($meetID))
			{
				$msg = '**ERROR: Meet '.$meetID.' does not belong to you...';			
			}
			else
			{
				$this->template->load('tmpl_onecolumn', 'dashboard/assign_athletes', $data );
			}
		}
	}

	function edit_athlete()
	{	
		$data = array();
		if(isset($_POST['athleteid']))
		{
			if ($this->form_validation->run() == FALSE)
			{
				$this->template->load('tmpl_onecolumn', 'dashboard/edit_athlete' );
			}
			else
			{
				$athleteid = $this->input->post('athleteid');
				$data['firstName'] = $this->input->post('firstName');
				$data['lastName'] = $this->input->post('lastName');
				$data['gender'] = $this->input->post('gender');
				$data['dob'] = strftime("%Y-%m-%d ", strtotime($this->input->post('dob')));
				$data['academicYear'] = $this->input->post('academicYear');
				$data['contactEmail'] = $this->input->post('contactEmail');
				$data['contactPhone'] = $this->input->post('contactPhone');
				$data['alternateContact'] = $this->input->post('alternateContact');
				$data['alternateEmail'] = $this->input->post('alternateEmail');
				$data['alternatePhone'] = $this->input->post('alternatePhone');
				$data['relationship'] = $this->input->post('relationship');
				$msg = '**ERROR: Could not save this profile...';
				if($athleteid == 0) 
				{
					//Insert athlete information
					$data['teamid'] = $this->session->userdata('teamid');
					if($this->Dashboard_model->insert_rec('tblAthletes', $data))
					{
						$msg = 'A new athlete was successfully added to your roster...';
					}
				}
				else
				{
					//Update meet information
					$pk = array( 'athleteid' => $athleteid);
					if($this->Dashboard_model->update_rec('tblAthletes', $pk, $data))
					{
						$msg = 'Athlete data was successfully saved...';
					}
				}
				$this->session->set_flashdata('flash_message', $msg );
				redirect('dashboard');
			}
		}
		else
		{
			$athleteid = $this->uri->segment(3, 0);
			if($athleteid == 0)
			{
				$this->template->load('tmpl_onecolumn', 'dashboard/edit_athlete', $data );
			}
			else
			{			
				$rs = $this->Dashboard_model->get_athlete($athleteid);
				if($rs->num_rows() > 0)
				{
					$data['athleteInfo'] = $rs->row();
					if($this->session->userdata('teamid') == $data['athleteInfo']->teamid)
					{
						$this->template->load('tmpl_onecolumn', 'dashboard/edit_athlete', $data );
					}
					else
					{
						$msg = '**ERROR: Athlete '.$athleteInfo.' isn\'t a member of your team...';
						$this->session->set_flashdata('flash_message', $msg );
						redirect('dashboard');
					}
				}
				else
				{
					$msg = '**ERROR: Athlete with an ID of '.$athleteid.' does not exist...';
					$this->session->set_flashdata('flash_message', $msg );
					redirect('dashboard');
				}
			}
		}
	}

	function edit_athlete_pb()
	{	
		$data = array();
		if(!isset($_POST['athleteid']))
		{
			$msg = "**ERROR: An athlete ID was not specified...";			
		}
		else
		{	
			$athleteid = $this->input->post('athleteid');
			if(!$this->Dashboard_model->is_on_myteam($athleteid))
			{
				$msg = '**ERROR: Athlete '.$athleteid.' is not on your team...';			
				$this->session->set_flashdata('flash_message', $msg );
				redirect('dashboard');
			}
			else
			{
				if(isset($_POST['personalBests']) && isset($_POST['mySpecialties'])) {
					$data['personalBests'] = $this->input->post('personalBests');
					$data['mySpecialties'] = $this->input->post('mySpecialties');
					$pk = array( 'athleteid' => $athleteid );
					$msg = '';
					$this->Dashboard_model->delete_rec('tblPB', $pk);
					if($this->Dashboard_model->ins_personal_best($data)) 
					{
						$msg = $msg.' Athlete personal best successfully saved...';
					}
					else
					{
						$msg = $msg.' **ERROR: saving personal best...';
					}
					$this->Dashboard_model->delete_rec('tblAthleteEvents', $pk);
					if($this->Dashboard_model->ins_athlete_events($data)) 
					{
						$msg = $msg.' Athlete specialties successfully saved...';
					}
					else
					{
						$msg = $msg.' **ERROR: saving personal event specialties...';
					}
					$this->session->set_flashdata('flash_message', $msg );
					redirect('dashboard');
				} else {
					$data['athleteid'] = $athleteid;
					$data['subTitle'] = $this->input->post('firstName').' '.$this->input->post('lastName') .' - '.$this->input->post('academicYear');
					$data['trackEvent'] = $this->Dashboard_model->get_eventlist('TRACK');
					$data['fieldEvent'] = $this->Dashboard_model->get_eventlist('FIELD');
					$data['specialties'] = $this->Dashboard_model->get_athlete_events($athleteid);						
					$data['personalBest'] = $this->Dashboard_model->get_athlete_pb($athleteid);						
					$this->template->load('tmpl_onecolumn', 'dashboard/edit_athlete_pb', $data );
				}
			}
		}
	}

	function delete_athlete()
	{	
		$data = array();
		if(!isset($_POST['athleteid']))
		{
			$msg = "**ERROR: An athlete ID was not specified...";			
		}
		else
		{
			$athleteid = $_POST['athleteid'];
			if(!$this->Dashboard_model->is_on_myteam($athleteid))
			{
				$msg = '**ERROR: Athlete '.$athleteid.' is not on your team...';			
			}
			else
			{
				$pk = array('athleteid' => $athleteid);
				if($this->Dashboard_model->delete_rec('tblAthletes', $pk))
				{
					$msg = 'Athlete '.$athleteid.' deleted...';
				}
				else
				{
				$msg = '**Error: Could not delete athlete '.$athleteid.'...';
				}
			}
		}
		$this->session->set_flashdata('flash_message', $msg );
		redirect('dashboard');
	}

}
/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */