<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
	var $template_data = array();
	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('session');
	}
	
	function set($name, $value)
	{
		$this->template_data[$name] = $value;
	}

	function load($template = '', $view = '' , $view_data = array(), $return = FALSE)
	{
		$this->set('contents', $this->ci->load->view($view, $view_data, TRUE));			
		return $this->ci->load->view($template, $this->template_data, $return);
	}

	function loadTemplate($template = '', $view = '' , $view_data = array(), $return = FALSE)
	{               
		if($this->ci->session->userdata('device_type') == 'mobile')
		{
			$template = 'tmpl_mobile';	
		}
		else
		{
			switch (strtoupper($template))
			{
				case 'STDONECOLUMNS':
					$template = 'tmpl_onecolumn';
					break;	
				case 'STDTWOCOLUMNS':
					$template = 'tmpl_twocolumns';
					break;	
				case 'FEATURE':
					$template = 'tmpl_feature';
					break;
				default:
					$template = 'tmpl_onecolumn';
			}
		}
		$this->set('contents', $this->ci->load->view($view, $view_data, TRUE));			
		return $this->ci->load->view($template, $this->template_data, $return);
	}
}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */