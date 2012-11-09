<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	function insert_rec($tbl, $data)
	{
		$this->db->insert($tbl, $data);
		return $this->db->insert_id();
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
	
	function set_transaction_message($frmActionMsg, $successful)
	{ 
		$msg = $frmActionMsg.' successful...';
		if(!$successful)
			$msg = '**'.$frmActionMsg.' Error - transaction failed...';
		$this->session->set_flashdata('flash_message', $msg );
		redirect('/dashboard/');
	}
}
/* End of file crud_model.php */
/* Location: ./application/model/crud_model.php */