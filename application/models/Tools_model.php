<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class tools_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	function getareas()
	{
		$this->db->select('*');
		$this->db->from('tbl_areas');
		$this->db->order_by("areacity,areaname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getareasdetails($id)
	{
		$this->db->where('areaid', $id);
		$this->db->select('*');
		$this->db->from('tbl_areas');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getbranches()
	{
		$this->db->select('*');
		$this->db->from('tbl_branches');
		$this->db->order_by("branchname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	
	function getbranchesdetails($id)
	{
		$this->db->where('branchid', $id);
		$this->db->select('*');
		$this->db->from('tbl_branches');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getbranchesareas()
	{

		$this->db->select("a.*,b.branchname,c.areacity,c.areaname");
		$this->db->from('tbl_branches_areas a');
		$this->db->join('tbl_branches b','a.branchid=b.branchid');
		$this->db->join('tbl_areas c','a.areaid=c.areaid');
		$this->db->order_by("b.branchname,c.areacity,c.areaname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getbranchesareasactive()
	{
	
		$this->db->where('a.isactive', 'T');
		$this->db->select("a.*,b.branchname,c.areacity,c.areaname");
		$this->db->from('tbl_branches_areas a');
		$this->db->join('tbl_branches b','a.branchid=b.branchid');
		$this->db->join('tbl_areas c','a.areaid=c.areaid');
		$this->db->order_by("b.branchname,c.areacity,c.areaname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getbranchesareasactivebyuser($id)
	{
		$this->db->where('d.userid',$id); 
		$this->db->where('a.isactive', 'T');
		$this->db->select("a.*,b.branchname,c.areacity,c.areaname");
		$this->db->from('tbl_branches_areas a');
		$this->db->join('tbl_branches b','a.branchid=b.branchid');
		$this->db->join('tbl_areas c','a.areaid=c.areaid');
		$this->db->join('tbl_useraccounts_branches d','a.branchid=d.branchid');
		$this->db->order_by("b.branchname,c.areaname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getcollectorsbranchesareasactivebyuser($branch,$userid)
	{
		$this->db->where('d.userid',$userid); 
		$this->db->where('a.branchid',$branch); 
		$this->db->where('a.isactive', 'T');
		$this->db->select("a.*,b.branchname,c.areacity,c.areaname");
		$this->db->from('tbl_branches_areas a');
		$this->db->join('tbl_branches b','a.branchid=b.branchid');
		$this->db->join('tbl_areas c','a.areaid=c.areaid');
		$this->db->join('tbl_useraccounts_areas d','a.branchareaid=d.branchareaid');
		$this->db->order_by("b.branchname,c.areaname");
		$result = $this->db->get();
		

		return $result->result_array();
	}
	
	function getbranchesareacityactivebyuser($id)
	{
		$this->db->where('d.userid',$id); 
		$this->db->where('a.isactive', 'T');
		$this->db->distinct();
		$this->db->select("a.branchareaid,b.branchname,c.areaname");
		$this->db->from('tbl_branches_areas a');
		$this->db->join('tbl_branches b','a.branchid=b.branchid');
		$this->db->join('tbl_areas c','a.areaid=c.areaid');
		$this->db->join('tbl_useraccounts_areas d','a.branchareaid=d.branchareaid');
		$this->db->order_by("b.branchname,c.areacity");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	
	function branchesareasdetails($id)
	{

		$this->db->where('branchareaid', $id);
		$this->db->select("a.*,b.branchname,c.areacity,c.areaname");
		$this->db->from('tbl_branches_areas a');
		$this->db->join('tbl_branches b','a.branchid=b.branchid');
		$this->db->join('tbl_areas c','a.areaid=c.areaid');
		$this->db->order_by("b.branchname,c.areacity,c.areaname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	
	function getareasbybranch($id)
	{

		$this->db->where('a.branchid', $id);
		$this->db->select("a.branchareaid,a.areaid,b.branchname,c.areaname");
		$this->db->from('tbl_branches_areas a');
		$this->db->join('tbl_branches b','a.branchid=b.branchid');
		$this->db->join('tbl_areas c','a.areaid=c.areaid');
		$this->db->order_by("c.areaname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getservicecharge($id)
	{

		$this->db->where('branchid', $id);
		$this->db->select("*");
		$this->db->from('tbl_service_charges a');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getholidays()
	{
		$this->db->select("*");
		$this->db->from('tbl_holidays');
		$this->db->order_by("holidaydate desc");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getholidaydetails($id)
	{
		$this->db->where('holidayid', $id);
		$this->db->select("*");
		$this->db->from('tbl_holidays');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getholidaybranches($id)
	{
		$this->db->where('holidayid', $id);
		$this->db->select("branchid");
		$this->db->from('tbl_holiday_branches');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	
	function getnumberofholidays($branch,$paramfrom,$paramto)
	{
		$this->db->where('holidaydate >=', $paramfrom);
		$this->db->where('holidaydate <=', $paramto);
		$this->db->where('c.branchareaid ',$branch);
		$this->db->select("a.holidayid");
		$this->db->from('tbl_holidays a');
		$this->db->join('tbl_holiday_branches b','a.holidayid=b.holidayid');
		$this->db->join('tbl_branches_areas c','b.branchid=c.branchid');
		$result = $this->db->get();
		return $result->num_rows();
	}

	function getservicechargebybranchamount($branch,$amount)
	{
		$this->db->where('servicechargefrom <=', $amount);
		$this->db->where('servicechargeto >=', $amount);
		$this->db->where('b.branchareaid ',$branch);
		$this->db->select("a.servicechargeamount");
		$this->db->from('tbl_service_charges a');
		$this->db->join('tbl_branches_areas b','a.branchid=b.branchid');
		$result = $this->db->get();
		return $result->result_array();
	}	
	
	function getroles()
	{
		$this->db->select("*");
		$this->db->from('tbl_roles');
		$this->db->order_by("role");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getroledetails($id)
	{
		$this->db->where('roleid', $id);
		$this->db->select("*");
		$this->db->from('tbl_roles');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getactiveroles()
	{
		$this->db->where('isactive ', 'T');
		$this->db->select("*");
		$this->db->from('tbl_roles');
		$this->db->order_by("role");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getmenus()
	{
		$this->db->select("*");
		$this->db->from('tbl_menus');
		$this->db->order_by("category");
		$result = $this->db->get();
		
		return $result->result_array();
	}
	
	function getuseraccessmenu($id)
	{
		$this->db->select('a.menuid,category,pathname,menuname,hasadd,hasedit,hasdelete,IFNULL(b.menuid, "F") isaccess,IFNULL(b.isedit, "F") isedit,IFNULL(b.isdelete, "F") isdelete,IFNULL(b.isadd, "F") isadd',false);
		$this->db->from('tbl_menus a');
		$this->db->join('(SELECT * FROM `tbl_roles_menus` WHERE `roleid` = '.$id.') b','a.menuid=b.menuid','left');
		$this->db->order_by("orderby");
		$query = $this->db->get();
		$result=array();
		foreach($query->result_array() as $row)
		{
			$result[$row['pathname']]=array('menuid'=>$row['menuid']
							,'category'	=>$row['category']
							,'pathname'	=>$row['pathname']
							,'menuname'	=>$row['menuname']
							,'isaccess'	=>$row['isaccess']
							,'isedit'  	=>$row['isedit']
							,'isdelete'	=>$row['isdelete']
							,'isadd'	=>$row['isadd']
							,'hasadd'	=>$row['hasadd']
							,'hasedit'	=>$row['hasedit']
							,'hasdelete'=>$row['hasdelete']
							);
		}	
		return $result;
	}
	
	function getuseraccounts()
	{
		$this->db->select("a.*,b.role,c.branchname");
		$this->db->from('tbl_user_accounts a');
		$this->db->join('tbl_roles b','a.roleid=b.roleid','left');
		$this->db->join('tbl_branches c','a.branch=c.branchid','left');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getuseraccountsdetails($id)
	{
		$this->db->where('userid ', $id);
		$this->db->select("a.*,b.role");
		$this->db->from('tbl_user_accounts a');
		$this->db->join('tbl_roles b','a.roleid=b.roleid');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getuseraccessbranches($id)
	{
		$this->db->where('userid',$id);
		$this->db->select('branchid');
		$this->db->from('tbl_useraccounts_branches');
		$query = $this->db->get();
		$result=array();
		foreach($query->result_array() as $row)
		{
			array_push($result,$row['branchid']);
		}	
		return $result;
	}
	
	function getuseraccessareas($id)
	{
		$this->db->where('userid',$id);
		$this->db->select('branchareaid');
		$this->db->from('tbl_useraccounts_areas');
		$query = $this->db->get();
		$result=array();
		foreach($query->result_array() as $row)
		{
			array_push($result,$row['branchareaid']);
		}	
		return $result;
	}
	
	
	
	function getuseraccessbranchesarea($id)
	{
		$this->db->where('userid',$id);
		$this->db->select('branchareaid,branchname,areaname');
		$this->db->from('tbl_useraccounts_branches a');
		$this->db->join('tbl_branches_areas b','a.branchid=b.branchid');
		$this->db->join('tbl_branches c','b.branchid=c.branchid');
		$this->db->join('tbl_areas d','b.areaid=d.areaid');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getuserbranches($id)
	{
		$this->db->where('userid',$id);
		$this->db->select('a.branchid,branchname,ipaddress');
		$this->db->from('tbl_useraccounts_branches a');
		$this->db->join('tbl_branches b','a.branchid=b.branchid');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	
	
	
	
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	
	
	function saveareas($id,$city,$name,$status,$userid)
	{
		$this->db->trans_start();
		$result=null;

		if ($id==0)
		{
			$data = array(
				'areacity' 		=>  $city,
				'areaname' 		=> 	$name,
				'isactive' 		=> $status
			);

			$this->db->insert('tbl_areas',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$returnid=$this->db->insert_id();
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Areas',$returnid,$this->db->last_query(),'Add',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		else
		{
			$data = array(
				'areacity' 		=>  $city,
				'areaname' 		=>	$name,
				'isactive' 		=> $status
			);

			$this->db->where('areaid',$id);
			$this->db->update('tbl_areas',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Areas',$returnid,$this->db->last_query(),'Update',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		
		$this->db->trans_complete();
		return $result;	
	}
	
	function savebranches($id,$name,$short,$address,$contactperson,$contactnumber,$ipaddress,$userid)
	{
		$this->db->trans_start();
		$result=null;

		if ($id==0)
		{
			$data = array(
				'branchname' 			=>$name,
				'branchshortdesc' 		=>$short,
				'branchaddress' 		=>$address,
				'branchcontactperson' 	=>$contactperson,
				'branchcontactnumber' 	=>$contactnumber,
				'ipaddress' 			=>$ipaddress
				
			);

			$this->db->insert('tbl_branches',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$returnid=$this->db->insert_id();
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				
				$sql = "INSERT INTO tbl_service_charges
				(branchid,servicechargename,servicechargefrom,servicechargeto,servicechargeamount,servicechargeremarks)
				SELECT ".$returnid.",
				servicechargename,servicechargefrom,servicechargeto,servicechargeamount,servicechargeremarks
				FROM tbl_service_charges
				WHERE branchid=1";
		
				$this->db->query($sql);	
				
				
				$this->inserttracer('Branch',$returnid,$this->db->last_query(),'Add',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		else
		{
			$data = array(
				'branchname' 			=>$name,
				'branchshortdesc' 		=>$short,
				'branchaddress' 		=>$address,
				'branchcontactperson' 	=>$contactperson,
				'branchcontactnumber' 	=>$contactnumber,
				'ipaddress' 			=>$ipaddress
				
			);

			$this->db->where('branchid',$id);
			$this->db->update('tbl_branches',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Branches',$returnid,$this->db->last_query(),'Update',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		
		$this->db->trans_complete();
		return $result;	
	}
	
	function savebranchesareas($id,$branch,$area,$address,$contactperson,$contactnumber,$status,$userid)
	{
		$this->db->trans_start();
		$result=null;

		if ($id==0)
		{
			$data = array(
				'branchid' 			=> $branch,
				'areaid' 			=> $area,
				'address' 			=>	$address,
				'contactperson' 	=>	$contactperson,
				'contactnumber' 	=>	$contactnumber,
				'isactive' 			=> $status
			);

			$this->db->insert('tbl_branches_areas',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$returnid=$this->db->insert_id();
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Branch Area',$returnid,$this->db->last_query(),'Add',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		else
		{
			$data = array(
				'branchid' 			=> $branch,
				'areaid' 			=> $area,
				'address' 			=> $address,
				'contactperson' 	=> $contactperson,
				'contactnumber' 	=> $contactnumber,
				'isactive' 			=> $status
			);

			$this->db->where('branchareaid',$id);
			$this->db->update('tbl_branches_areas',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Branch Area',$returnid,$this->db->last_query(),'Update',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		
		$this->db->trans_complete();
		return $result;	
	}
	
		
	function saveholiday($id,$date,$name,$isnational,$remarks,$userid)
	{
		$this->db->trans_start();
		$result=null;

		if ($id==0)
		{
			$data = array(
				'holidaydate' 		=> $date,
				'holidayname' 		=> $name,
				'isnational' 		=>	$isnational,			
				'holidayremarks' 	=>	$remarks,				
				'entryuserid' 		=>	$userid,
				'entrydate' 		=>  date("Y-m-d H:i:s")
			);

			$this->db->insert('tbl_holidays',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$returnid=$this->db->insert_id();
				$result=array(
					'returnid' 		=> $returnid,
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Holiday',$returnid,$this->db->last_query(),'Add',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		else
		{
			$data = array(
				'holidaydate' 		=> $date,
				'holidayname' 		=> $name,
				'isnational' 		=>	$isnational,	
				'holidayremarks' 	=>	$holidayremarks,
				'entryuserid' 		=>	$userid,
				'entrydate' 		=>  date("Y-m-d H:i:s")
			);

			$this->db->where('holidayid',$id);
			$this->db->update('tbl_holidays',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Holiday',$returnid,$this->db->last_query(),'Update',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		
		$this->db->trans_complete();
		return $result;	
	}
	
	function saveholidaybranch($id,$branch,$ctr)
	{
		$this->db->trans_start();
		if ($ctr==0)
		{
			$this->db->where('holidayid',$id);
			$this->db->delete('tbl_holiday_branches');	
		}
		
		if (!empty($branch))
			{
			$data = array(
				'holidayid' 	=> $id,
				'branchid' 	=> $branch
			);
			$this->db->insert('tbl_holiday_branches',$data);
		}
		$this->db->trans_complete();
	}
	
	function saverole($id,$name,$status,$remarks,$userid)
	{
		$this->db->trans_start();
		$result=null;

		if ($id==0)
		{
			$data = array(
				'role' 			=> 	$name,
				'isactive' 		=> $status,
				'remarks' 		=>  $remarks,
				'entryuserid' 	=>	$userid,
				'entrydate' 	=>  date("Y-m-d H:i:s")
			);

			$this->db->insert('tbl_roles',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$returnid=$this->db->insert_id();
				$result=array(
					'returnid' 		=> $returnid,
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Roles',$returnid,$this->db->last_query(),'Add',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		else
		{
			$data = array(
				'role' 			=> 	$name,
				'isactive' 		=>  $status,
				'remarks' 		=>  $remarks
			);

			$this->db->where('roleid',$id);
			$this->db->update('tbl_roles',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Roles',$returnid,$this->db->last_query(),'Update',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		
		$this->db->trans_complete();
		return $result;	
	}
	
	function saveuseraccessmenu($ctr,$menu,$role,$isadd,$isedit,$isdelete)
	{
		$this->db->trans_start();
		if($ctr==0)
		{
			$this->db->where('roleid',$role);
			$this->db->delete('tbl_roles_menus');	
		}
		
		if($ctr==2)
		{
			$this->db->where('roleid',$role);
			$this->db->delete('tbl_roles_menus');	
		}
		else
		{
			$data = array(
			'menuid' 			=> $menu,
			'isedit' 			=> $isedit,
			'isdelete' 			=> $isdelete,
			'isadd' 			=> $isadd,
			'roleid' 			=> $role
			);
				
			$this->db->insert('tbl_roles_menus',$data);
		}

		$this->db->trans_complete();
	}
	
	function saveuseraccount($id,$email,$password,$fname,$mi,$lname,$mobile,$address,$role,$status,$remarks,$dateaccess,$ipaddress,$branch,$userid)
	{
		$result=null;
		$this->db->trans_start();
		
		if ($id==0)
		{
			$this->db->where('emailaddress', trim($email));
			$this->db->select('*');
			$this->db->from('tbl_user_accounts');
			
			$query = $this->db->get();
			
			if ($query->num_rows()<1)
			{
				$data = array(
				'emailaddress' 		=> $email,
				'password' 			=> $this->mylibraries->encrypt($password),
				'lastname' 			=> $lname,
				'firstname' 		=> $fname,
				'middleinitial' 	=> $mi,
				'mobilenumber' 		=> $mobile,
				'address' 			=> $address,
				'roleid' 			=> $role,
				'isactive' 			=> $status,
				'remarks' 			=> $remarks,
				'dateaccess'		=> $dateaccess,
				'ipaddress'			=> $ipaddress,
				'branch'			=> $branch,
				'entryuserid' 		=>	$userid,
				'entrydate' 		=>  date("Y-m-d H:i:s")
				);
					
				$this->db->insert('tbl_user_accounts',$data);
				$error = $this->db->error(); 
				if ($error['code']==0)
				{
					$returnid=$this->db->insert_id();
					$result=array(
						'returnid' 		=> $returnid,
						'error_number' 	=> 0,
						'error_message' => 'success'
					);
					$this->inserttracer('User Account',$returnid,$this->db->last_query(),'Add',$userid);
				}
				else
				{
					$result=array(
					'error_number' 	=> $error['code'],
					'error_message' => $error['message']
					);
				}
			}
			else
			{
				$result=array(
				'error_number' 	=> 1,
				'error_message' => 'exists'
				);
			}
		}
		else
		{
			$this->db->where('userid !=', $id);
			$this->db->where('emailaddress', trim($email));
			$this->db->select('*');
			$this->db->from('tbl_user_accounts');
			
			$query = $this->db->get();
			
			if ($query->num_rows()<1)
			{
				$data = array(
				'emailaddress' 		=> $email,
				'lastname' 			=> $lname,
				'firstname' 		=> $fname,
				'middleinitial' 	=> $mi,
				'mobilenumber' 		=> $mobile,
				'address' 			=> $address,
				'roleid' 			=> $role,
				'isactive' 			=> $status,
				'dateaccess'		=> $dateaccess,
				'ipaddress'			=> $ipaddress,
				'branch'			=> $branch,
				'remarks' 			=> $remarks,
				);
				
				if($password!='')
				{
					$data['password'] = $this->mylibraries->encrypt($password);
				}
				
					
				$this->db->where('userid',$id);
				$this->db->update('tbl_user_accounts',$data);	
				$error = $this->db->error(); 
				if ($error['code']==0)
				{
					$returnid=$this->db->insert_id();
					$result=array(
						'error_number' 	=> 0,
						'error_message' => 'success'
					);
					$this->inserttracer('User Account',$returnid,$this->db->last_query(),'Update',$userid);
				}
				else
				{
					$result=array(
					'error_number' 	=> $error['code'],
					'error_message' => $error['message']
					);
				}
			}
			else
			{
				$result=array(
				'error_number' 	=> 1,
				'error_message' => 'exists'
				);
			}
		}
		

		$this->db->trans_complete();
		return $result;
	}
	
	
	function saveuseraccessbranch($ctr,$branch,$user)
	{
		$this->db->trans_start();
		if($ctr==0)
		{
			$this->db->where('userid',$user);
			$this->db->delete('tbl_useraccounts_branches');	
		}
		
		if($ctr==2)
		{
			$this->db->where('userid',$user);
			$this->db->delete('tbl_useraccounts_branches');	
		}
		else
		{
			$data = array(
					'branchid' 		=> $branch,
					'userid' 	=> $user
					);
					
			$this->db->insert('tbl_useraccounts_branches',$data);
		}
		
		$this->db->trans_complete();
	}
	
	function saveuseraccessarea($ctr,$area,$user)
	{
		$this->db->trans_start();
		if($ctr==0)
		{
			$this->db->where('userid',$user);
			$this->db->delete('tbl_useraccounts_areas');	
		}
		
		if($ctr==2)
		{
			$this->db->where('userid',$user);
			$this->db->delete('tbl_useraccounts_areas');	
		}
		else
		{
			$data = array(
					'branchareaid' 		=> $area,
					'userid' 			=> $user
					);
					
			$this->db->insert('tbl_useraccounts_areas',$data);
		}
		
		$this->db->trans_complete();
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
	
	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	
	function deleteholidaybranchareas($id)
	{
		$this->db->trans_start();
	
		$this->db->where('holidayid',$id);
		$this->db->delete('tbl_holiday_branches');	
		$this->db->trans_complete();
	}
	
}
