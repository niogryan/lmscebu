<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class system_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	function validateuseraccount($emailaddress,$password)
	{	
		$DB = $this->load->database('dbconn', TRUE);	
		$DB->where('emailaddress', $emailaddress);
		$DB->where('password', $this->mylibraries->encrypt($password));
		$DB->where('a.isactive', 'T');
		$DB->select('userid,emailaddress,lastname,firstname,middleinitial,b.role,a.roleid,ipaddress,isstrictmachineaccess');
		$DB->from('tbl_user_accounts a');
		$DB->join('tbl_roles b','a.roleid=b.roleid');
		$result = $DB->get();
		return $result->result_array();
	}

	function getUserDetails($id){	
		$DB = $this->load->database('dbconn', TRUE);	
		$DB->where('userid', $id);
		$DB->select('userid,emailaddress,lastname,firstname,middleinitial,b.role,a.roleid,ipaddress,isstrictmachineaccess');
		$DB->from('tbl_user_accounts a');
		$DB->join('tbl_roles b','a.roleid=b.roleid');
		$result = $DB->get();
		return ($result->num_rows() > 0) ? $result->row_array() : null;
	}
	
	function loginas()
	{	
		$DB = $this->load->database('dbconn', TRUE);	
		$DB->where('a.roleid', '1');
		$DB->where('a.isactive', 'T');
		$DB->select('userid,emailaddress,lastname,firstname,middleinitial,b.role,a.roleid');
		$DB->from('tbl_user_accounts a');
		$DB->join('tbl_roles b','a.roleid=b.roleid');
		$result = $DB->get();
		return $result->result_array();
	}
	
	function signinas($id)
	{	
		$DB = $this->load->database('dbconn', TRUE);	
		$DB->where('userid', $id);
		$DB->select('userid,emailaddress,lastname,firstname,middleinitial,b.role,a.roleid');
		$DB->from('tbl_user_accounts a');
		$DB->join('tbl_roles b','a.roleid=b.roleid');
		$result = $DB->get();
		return $result->result_array();
	}
	

	function changepassword($id,$password)
	{	
		$result=null;
		$this->db->trans_start();
		
		$data = array(
			'password' => $this->mylibraries->encrypt($password)
		);
			
		$this->db->where('userid',$id);
		$this->db->update('tbl_user_accounts',$data);	
		$error = $this->db->error(); 
		if ($error['code']==0)
		{
			$result=array(
				'error_number' 	=> 0,
				'error_message' => 'success'
			);
			$this->inserttracer('Change Password',$id,$this->db->last_query(),'Update',$userid);
		}
		else
		{
			$result=array(
			'error_number' 	=> $error['code'],
			'error_message' => $error['message']
			);
		}
		
		$this->db->trans_complete();
		return $result;		
				
	}
	
	function inserttracer($category,$id,$description,$transtype,$userid)
	{
		$data = array(
		'category' 			=> $category,
		'identifierid'		=> $id,
		'description' 		=> $description,
		'transtype' 		=> $transtype,
		'transdate' 		=> date("Y-m-d H:i:s"),
		'transuserid' 		=> $userid
		);
		$this->db->insert('tbl_tracer',$data);
	}
		
	
	
	
	
}