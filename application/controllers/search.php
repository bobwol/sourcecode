<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller
{
	private $pageContent = array(  
		'meet'  => array( 'searchForm' => 'search/incl_meetsearchform', 'searchResults' => 'search/meet_search_results', 'blankPage' => 'search/meet_search'),
		'team' => array( 'searchForm' => 'search/incl_teamsearchform', 'searchResults' => 'search/team_search_results', 'blankPage' => 'search/team_search'),
		'athlete' => array( 'searchForm' => 'search/incl_athletesearchform', 'searchResults' => 'search/athlete_search_results', 'blankPage' => 'search/athlete_search')
    );

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'html'));
		$this->load->model('Search_model', '', TRUE);
		date_default_timezone_set('America/Chicago');
	}

	function index()
	{
		if($this->session->userdata('device_type') == 'mobile')
		{
			$this->meets();
		}
		else
		{
			$this->template->loadTemplate('stdOneColumn', 'search/search_forms' );
		}
	}

	public function meet_search_results()
	{
		if(!isset($_POST['sMeetState']))
			redirect('/search/');
		
		$searchCriteria = $_POST;
		$data['searchResult'] = $this->Search_model->get_meet_search_results($searchCriteria);
		$this->template->set('leftColumn', $this->pageContent['meet']['searchForm']);
		$this->template->loadTemplate('stdTwoColumns', $this->pageContent['meet']['searchResults'], $data);
	}
	
	public function team_search_results()
	{
		if(!isset($_POST['sOrgState']))
			redirect('/search/');

		$searchCriteria = $_POST;
		$data['searchResult'] = $this->Search_model->get_team_search_results($searchCriteria);
		$this->template->set('leftColumn', $this->pageContent['team']['searchForm']);
		$this->template->loadTemplate('stdTwoColumns', $this->pageContent['team']['searchResults'], $data);
	}

	public function athlete_search_results()
	{		
		if(!isset($_POST['sOrgAffilState']))
			redirect('/search/');
			
		$searchCriteria = $_POST;
		$data['searchResult']  = $this->Search_model->get_athlete_search_results($searchCriteria);
		$data['orgType'] = array('HS' => 'High School', 'IC' => 'College','TC' => 'Track Club');
		$this->template->set('leftColumn', $this->pageContent['athlete']['searchForm']);
		$this->template->loadTemplate('stdTwoColumns', $this->pageContent['athlete']['searchResults'], $data);
	}

	function meets()
	{
		$contentArea = $this->pageContent['meet']['blankPage'];
		if($this->session->userdata('device_type') == 'mobile')
			$contentArea = $this->pageContent['meet']['searchForm'];
		$this->template->set('leftColumn', $this->pageContent['meet']['searchForm']);
		$this->template->loadTemplate('stdTwoColumns', $contentArea);
	}

	function teams()
	{
		$contentArea = $this->pageContent['team']['blankPage'];
		if($this->session->userdata('device_type') == 'mobile')
			$contentArea = $this->pageContent['team']['searchForm'];
		$this->template->set('leftColumn', $this->pageContent['team']['searchForm']);
		$this->template->loadTemplate('stdTwoColumns', $contentArea);
	}

	function athletes()
	{
		$contentArea = $this->pageContent['athlete']['blankPage'];
		if($this->session->userdata('device_type') == 'mobile')
			$contentArea = $this->pageContent['athlete']['searchForm'];
		$this->template->set('leftColumn', $this->pageContent['athlete']['searchForm']);
		$this->template->loadTemplate('stdTwoColumns', $contentArea);
	}
}
/* End of file search.php */
/* Location: ./application/controllers/search.php */