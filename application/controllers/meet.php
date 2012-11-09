<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Meet extends CI_Controller
{
	private $meetData = array();

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'html'));
 		$this->load->library('form_validation');
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
		$meetDaySched = array();
		$meetID = $this->uri->segment(3, 0);
		$meetDates = $this->Meet_model->get_meet_dates($meetID);
		$this->meetData['meetInfo'] = $this->Meet_model->get_meet_info($meetID)->row();
		$this->meetData['meetDivs'] = $this->Meet_model->get_meet_divisions($meetID);
		$this->meetData['meetDayTab'] = $this->uri->segment(4, 1);
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
				'schedArr' => $this->Meet_model->get_meet_schedule($tab->meetID, $tab->day)
			);
			$day++;
		}
		$this->meetData['meetDaySched'] = $meetDaySched;
		$this->template->set('leftColumn', 'search/incl_meetsearchform');
		$this->template->loadTemplate('stdTwoColumns', 'meet/report', $this->meetData);
	}
	
	
	public function edit()
	{
		$dv = array();
		$dt = array();
		$mi = array();
		if(!isset($_POST['frmAction']))
		{
			$meetID = $this->uri->segment(3, 0);
			if($meetID == 0)
			{
				$this->meetData['frmAction'] = 'Insert';
				$this->meetData['numberOfEvents'] = 0;
				$this->meetData['meetInfo'] = $this->Meet_model->get_meet_defaults()->row();
				$this->meetData['maxDays'] = $this->Meet_model->get_max_days();
				$this->meetData['maxDivs'] = $this->Meet_model->get_max_divs();
			}
			else
			{
				if(!$this->Meet_model->is_my_meet($meetID))
				{
					$this->Crud_model->set_transaction_message('This meet doesn\'t belong to you.', 0); 
					redirect('/dashboard/');
				}
				else
				{
					$this->meetData['frmAction'] = 'Update';
					$this->meetData['numberOfEvents'] = $this->Meet_model->number_of_events($meetID);
					$this->meetData['meetDates'] = $this->Meet_model->get_meet_dates($meetID);
					$this->meetData['meetDivs'] = $this->Meet_model->get_meet_divisions($meetID);
					$this->meetData['meetInfo'] = $this->Meet_model->get_meet_info($meetID)->row();
					$this->meetData['maxDays'] = $this->Meet_model->get_max_days();
					$this->meetData['maxDivs'] = $this->Meet_model->get_max_divs();
				}
			}
			$this->template->load('tmpl_onecolumn', 'meet/edit_form', $this->meetData );
		}
		else
		{
			if ($this->form_validation->run() == FALSE)
			{
				// invalid so return to edit the form
				$this->template->load('tmpl_onecolumn', 'meet/edit_form' );
			}
			else
			{
				// form validates so grab form variables and prepare for insert/update
				$this->meetData['meetTitle'] = $this->input->post('meetTitle');
				$this->meetData['meetType'] = $this->input->post('meetType');
				$this->meetData['venue'] = $this->input->post('venue');
				$this->meetData['address1'] = $this->input->post('address1');
				$this->meetData['address2'] = $this->input->post('address2');
				$this->meetData['city'] = $this->input->post('city');
				$this->meetData['state'] = $this->input->post('state');
				$this->meetData['zip'] = $this->input->post('zip');
				$this->meetData['contactName'] = $this->input->post('contactName');
				$this->meetData['contactPhone'] = $this->input->post('contactPhone');
				$this->meetData['contactEmail'] = $this->input->post('contactEmail');
				$this->meetData['points1st'] = $this->input->post('points1st');
				$this->meetData['points2nd'] = $this->input->post('points2nd');
				$this->meetData['points3rd'] = $this->input->post('points3rd');
				$this->meetData['points4th'] = $this->input->post('points4th');
				$this->meetData['points5th'] = $this->input->post('points5th');
				$this->meetData['points6th'] = $this->input->post('points6th');
				$this->meetData['points7th'] = $this->input->post('points7th');
				$this->meetData['points8th'] = $this->input->post('points8th');
				$this->meetData['points9th'] = $this->input->post('points9th');
				$this->meetData['points10th'] = $this->input->post('points10th');
				$this->meetData['scores'] = $this->input->post('scores');
				$this->meetData['participantInfo'] = $this->input->post('participantInfo');
				$this->meetData['spectatorInfo'] = $this->input->post('spectatorInfo');
				$this->meetData['published'] = $this->input->post('published');
				if(strtoupper($this->input->post('frmAction')) == 'UPDATE')
				{
					$meetID = $this->input->post('meetID');
					$pk = array( 'meetID' => $meetID);
					$successful = $this->Crud_model->update_rec('tblMeets', $pk, $this->meetData);
					if($successful)
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
							$this->Crud_model->update_rec('tblDivisions', $pk, $dv);
						}
						for ($i = ($numUpdates+1); $i <= $topRec; $i++)
						{
							if($orgNumOfDivs > $numOfDivs)
							{
								$pk = array( 'meetID' => $meetID, 'divisionID' => $i );
								$this->Crud_model->delete_rec('tblDivisions',$pk);
							}
							else
							{
								$dv['meetID'] = $meetID;
								$dv['divisionID'] = $i;
								$dv['gender'] = $this->input->post('genderDiv'.$i);
								$dv['description'] = $this->input->post('divName'.$i);
								$this->Crud_model->insert_rec('tblDivisions', $dv);				
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
							$this->Crud_model->update_rec('tblDates', $pk, $dt);
						}
						for ($i = ($numUpdates+1); $i <= $topRec; $i++) 
						{
							if($orgNumOfDays > $numOfDays) {
								$pk = array( 'meetID' => $meetID, 'day' => $i );
								$this->Crud_model->delete_rec('tblDates',$pk);
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
								$this->Crud_model->insert_rec('tblDates', $dt);
							}
						}
					}
				}
				else
				{
					$this->meetData['user_id'] = $this->session->userdata('user_id');
					$successful = $this->Crud_model->insert_rec('tblMeets', $this->meetData);
					if($successful)
					{
						$newID = $successful;
						//Insert divisions
						for($i=1; $i <= $this->input->post('numOfDivs'); $i++)
						{
							$dv['meetID'] = $newID;
							$dv['divisionID'] = $i;
							$dv['gender'] = $this->input->post('genderDiv'.$i);
							$dv['description'] = $this->input->post('divName'.$i);
							$this->Crud_model->insert_rec('tblDivisions', $dv);
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
							$this->Crud_model->insert_rec('tblDates', $dt);
						}
						// also, automatically INSERT it to the owner's season schedule 	
						$pk = array('meetID' => $newID ,'teamID' => $this->session->userdata('teamid'));
						if($this->Crud_model->insert_rec('tblSeasonSchedules', $pk))
						$msg = 'Your new meet was successfully added...';
					}
				}
				$this->Crud_model->set_transaction_message($this->input->post('frmAction'), $successful); 
				redirect('/dashboard/');
			}
		}
	}

	public function remove_from_schedule()
	{
		$meetID = $this->uri->segment(3, 0);
		if(!$meetID)
		{
			$this->Crud_model->set_transaction_message('A meet ID was not specified.', 0); 
		}
		else
		{
			if($this->Meet_model->is_my_meet($meetID))
			{
				$this->Crud_model->set_transaction_message('To remove your own meet from your own schedule you must delete it.', 0);
			}
			else
			{
				if(!$this->Meet_model->meet_exists_and_published($meetID))
				{
					$this->Crud_model->set_transaction_message('This meet does not exist or hassn\'t been published.', 0);
				}
				else
				{
					$pk = array('meetID' => $meetID ,'teamID' => $this->session->userdata('teamid'));
					$successful = $this->Crud_model->delete_rec('tblSeasonSchedules', $pk);
					$this->Crud_model->set_transaction_message('Removal', $successful);
				}
			}
		}
		redirect('dashboard');
	}

	public function add_to_schedule()
	{	
		if($meetID = $this->_retrieve_meetid('get'))
		{
			if($this->Meet_model->is_my_meet($meetID))
			{
				$this->Crud_model->set_transaction_message('Your own meet is always on your own schedule. It can\'t be added again.', 0);
			}
			else
			{
				if(!$this->Meet_model->meet_exists_and_published($meetID))
				{
					$this->Crud_model->set_transaction_message('This meet does not exist or hassn\'t been published.', 0);
				}
				else
				{
					$pk = array('meetID' => $meetID ,'teamID' => $this->session->userdata('teamid'));
					$successful = $this->Crud_model->insert_rec('tblSeasonSchedules', $pk);
					// codeingighter active record record function to retreive the Pk of a newly inserted record doesn't
					// seem to work for tables that have compound primary keys. So, set transaction message to TRUE
					$this->Crud_model->set_transaction_message('Addition', 1);
				}
			}
		}
		redirect('dashboard');
	}

	public function delete()
	{	
		$successful = false;
		if($meetID = $this->_retrieve_meetid('post'))
		{
			if($this->Meet_model->is_my_meet($meetID))
			{
				$pk = array('meetID' => $meetID);
				$successful = $this->Crud_model->delete_rec('tblMeets', $pk);
			}
		}
		$this->Crud_model->set_transaction_message('Deletion', $successful);			
		redirect('/dashboard/');
	}

	public function generate_event_sched()
	{	
		if($meetID = $this->_retrieve_meetid('post'))
		{
			if($this->Meet_model->is_my_meet($meetID))
			{
				$this->meetData['meetID'] = $meetID;
				$this->meetData['meetTitle'] = $this->input->post('meetTitle');
				$this->meetData['meetType'] = $this->input->post('meetType');
				$this->meetData['numberOfEvents'] = $this->Meet_model->number_of_events($meetID);
				$this->meetData['meetDivs'] = $this->Meet_model->get_meet_divisions($meetID);
				$this->meetData['noOfDays'] = sizeof($this->Meet_model->get_meet_dates($meetID));
				$this->meetData['trackEvent'] = $this->Meet_model->get_eventlist('TRACK');
				$this->meetData['fieldEvent'] = $this->Meet_model->get_eventlist('FIELD');
				$this->template->load('tmpl_onecolumn', 'meet/generate_event_sched', $this->meetData );
			}
			else
			{
				$this->Crud_model->set_transaction_message('This is not your meet.', 0);
				redirect('/dashboard/');		
			}
		}
		else
		{
			$this->Crud_model->set_transaction_message('A meet ID was not specified.', 0);
			redirect('/dashboard/');
		}
	}

	public function adjust_event_sched()
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
			if(!$this->Meet_model->is_my_meet($meetID))
			{
				$msg = '**ERROR: Meet '.$meetID.' does not belong to you...';			
				$this->session->set_flashdata('flash_message', $msg );
				redirect('dashboard');
			}
			else
			{
				$this->meetData['meetID'] = $meetID;
				$this->meetData['meetTitle'] = $this->input->post('meetTitle');
				$this->meetData['meetType'] = $this->input->post('meetType');
				$this->meetData['numberOfEvents'] = $this->Meet_model->has_events_scheduled($meetID);
				$this->template->load('tmpl_onecolumn', 'dashboard/adjust_schedule', $data );
			}
		}
	}

	public function regenerate_event_sched()
	{	
		$successful = false;
		if($meetID = $this->_retrieve_meetid('post'))
		{
			if($this->Meet_model->is_my_meet($meetID))
			{
				$this->meetData['meetEvents'] = $this->input->post('meetEvents');
				$this->meetData['schedEntries'] = $this->input->post('schedEntries');
				$pk = array( 'meetID' => $meetID );
				$this->Crud_model->delete_rec('tblMeetEvents', $pk);
				if($successful = $this->Meet_model->ins_meet_events($this->meetData))
				{
					$this->Crud_model->delete_rec('tblScheduleEntries', $pk);
					$successful = $this->Meet_model->ins_meet_schedule($this->meetData);
				}
			}
		}
		$this->Crud_model->set_transaction_message('Event schedule generation', $successful); 
		redirect('/dashboard/');
	}


	public function record_results()
	{	

	}


	public function archive()
	{	

	}


	public function restore_archive()
	{	

	}

	private function _retrieve_meetid($passedVia)
	{	
		$meetID = $this->uri->segment(3, 0);
		if(strtoupper($passedVia) == 'POST')
		{
			$meetID = 0;		
			if(isset($_POST['meetID']))
				$meetID = $this->input->post('meetID');		
		}
		return $meetID;
	}
}
/* End of file meet_controller.php */
/* Location: ./application/controllers/meet_controller.php */