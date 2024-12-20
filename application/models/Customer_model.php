<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class customer_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	function getcustomerprofile()
	{
		$this->db->select('*');
		$this->db->from('tbl_customers');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function searchcustomerprofile($brancharea)
	{
		$this->db->where('b.branchareaid',$brancharea);
		$this->db->select('a.*,branchname,areaname');
		$this->db->from('tbl_customers a');
		$this->db->join('tbl_branches_areas b','a.branchareaid=b.branchareaid');
		$this->db->join('tbl_branches c','b.branchid=c.branchid');
		$this->db->join('tbl_areas d','b.areaid=d.areaid');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getcustomerbybranch($branch)
	{
		$this->db->where('b.branchid',$branch);
		$this->db->select('a.*,branchname,areaname');
		$this->db->from('tbl_customers a');
		$this->db->join('tbl_branches_areas b','a.branchareaid=b.branchareaid');
		$this->db->join('tbl_branches c','b.branchid=c.branchid');
		$this->db->join('tbl_areas d','b.areaid=d.areaid');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function searchbadaccounts($param)
	{

		$this->db->where("(lastname LIKE '%$param%' OR firstname LIKE '%$param%')");
		$this->db->where('a.balance >0');
		$this->db->where('a.duedate <',date("Y-m-d"));
		$this->db->distinct();
		$this->db->select('a.*,firstname,lastname,middlename,suffix,branchname,areaname');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->join('tbl_branches d','c.branchid=d.branchid');
		$this->db->join('tbl_areas e','c.areaid=e.areaid');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function searchcustomerbyareauseraccess($userid)
	{
		$this->db->where('e.userid',$userid); 
		$this->db->distinct();
		$this->db->select('customerid,refnumber,firstname,lastname,suffix,branchname,areacity,areaname');
		$this->db->from('tbl_customers a');
		$this->db->join('tbl_branches_areas b','a.branchareaid=b.branchareaid');
		$this->db->join('tbl_branches c','b.branchid=c.branchid');
		$this->db->join('tbl_areas d','b.areaid=d.areaid');
		$this->db->join('tbl_useraccounts_areas e','b.branchareaid=e.branchareaid');
		$this->db->order_by("lastname,firstname");
	
		$result = $this->db->get();
		return $result->result_array();
	}
	

	
	
	function getcustomerprofiledetails($id)
	{
		$this->db->where('customerid', $id);
		$this->db->select("a.*,CONCAT(b.firstname,' ',b.lastname) as addedby,d.branchname,areaname",false);
		$this->db->from('tbl_customers a');
		$this->db->join('tbl_user_accounts b','a.entryuserid=b.userid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->join('tbl_branches d','c.branchid=d.branchid');
		$this->db->join('tbl_areas e','c.areaid=e.areaid');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getcountcustomerprofile()
	{
		$this->db->select('customerid');
		$this->db->from('tbl_customers');
		$result = $this->db->get();
		return $result->num_rows();
	}
	
	function getcustomerprofileimage($id)
	{
		$this->db->where('customerid', $id);
		$this->db->select('*');
		$this->db->from('tbl_customers_images');
		$this->db->order_by("sequence");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getcustomerdocuments($id)
	{
		$this->db->where('customerid', $id);
		$this->db->select('*');
		$this->db->from('tbl_customers_documents');
		$this->db->order_by("documentname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	
	function getcustomerdocumentsdetails($id)
	{
		$this->db->where('documentid', $id);
		$this->db->select('*');
		$this->db->from('tbl_customers_documents');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getcustomerdocumentschuck($id)
	{
		$this->db->where('documentid', $id);
		$this->db->select('*');
		$this->db->from('tbl_customers_documents_chunk');
		$this->db->order_by("sequence");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function checkreferencenumbernumber($refno)
	{
		$this->db->where('TRIM(refnumber)', $refno);
		$this->db->select('customerid');
		$this->db->from('tbl_customers');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function validatenewprofile($firstname,$lastname,$bday)
	{
		$this->db->where('lastname', $lastname);
		$this->db->where('firstname', $firstname);
		$this->db->where('bday', $bday);
		$this->db->select('*');
		$this->db->from('tbl_customers');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getcustomerloan($param)
	{

		$this->db->where('a.customerid', $param);
		$this->db->select('loanid,referencenumber,releaseddate,principalamount,interest,balance,status,firstname,lastname,suffix,d.branchname,areacity,areaname');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->join('tbl_branches d','c.branchid=d.branchid');
		$this->db->join('tbl_areas e','c.areaid=e.areaid');
		$this->db->order_by("releaseddate desc");
		$result = $this->db->get();
		return $result->result_array();
	}
		
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	
	
	function savenew($firstname,$lastname,$bday,$userid)
	{
		$this->db->trans_start();
		
		$result=null;
		$refno=null;
		$result=1;
		$ctr=1;
		
		do 
		{
			$refno=$this->mylibraries->getcustomerreferencenumber($ctr);
			$result=$this->checkreferencenumbernumber(trim($refno));
			$ctr++;
		} while ($result > 0);
		
		$data = array(
			'refnumber' 		=> $refno,
			'lastname' 			=> $this->mylibraries->replacespecialcharacter($lastname),
			'firstname' 		=> $this->mylibraries->replacespecialcharacter($firstname),
			'bday' 				=> $bday,
			'isactive' 			=> 'T',
			'entryuserid' 		=> $userid,
			'entrydate' 		=>  date("Y-m-d H:i:s")
		);

		$this->db->insert('tbl_customers',$data);
		$error = $this->db->error(); 
		if ($error['code']==0)
		{
			$returnid=$this->db->insert_id();
			$result=array(
				'returnid' 		=> $returnid,
				'error_number' 	=> 0,
				'error_message' => 'success'
			);
			$this->inserttracer('Customer Profile',$returnid,$this->db->last_query(),'Add',$userid);
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
	
	function saveprofile($id,$branch,$firstname,$middlename,$suffix,$lastname,$bday,$bplace,$gender,$address,$cellphonenumber,$telephonenumber,$emailaddress,$maritalstatus,$empstatus,$tinnumber,$remarks,$userid)
	{
		$result=null;
		$this->db->trans_start();
		
		if ($id==0)
		{
			$refno=null;
			$resultctr=1;
			$ctr=1;
			
			do 
			{
				$refno=$this->mylibraries->getcustomerreferencenumber($ctr);
				$resultctr=$this->checkreferencenumbernumber(trim($refno));
				$ctr++;
			} while ($resultctr > 0);
			
			
			$this->db->where('lastname', $lastname);
			$this->db->where('firstname', $firstname);
			$this->db->where('branchareaid', $branch);
			
			$this->db->select('*');
			$this->db->from('tbl_customers');
			$query = $this->db->get();
			
			if ($query->num_rows()<1)
			{
				$data = array(
					'refnumber' 		=> $refno,
					'branchareaid' 		=> $branch,
					'lastname' 			=> $lastname,
					'firstname' 		=> $firstname,
					'middlename' 		=> $middlename,
					'suffix' 			=> $suffix,
					'bday' 				=> $bday,
					'birthplace' 		=> $bplace,
					'gender' 			=> $gender,
					'address' 			=> $address,
					'cellphonenumber' 	=> $cellphonenumber,
					'telephonenumber' 	=> $telephonenumber,
					'emailaddress' 		=> $emailaddress,
					'maritalstatus' 	=> $maritalstatus,
					'employmentstatus' 	=> $empstatus,
					'tinnumber' 		=> $tinnumber,
					'remarks' 			=> $remarks,
					'isactive' 			=> 'T',
					'entryuserid' 		=> $userid,
					'entrydate' 		=>  date("Y-m-d H:i:s")
				);
					

				$this->db->insert('tbl_customers',$data);
				$error = $this->db->error(); 
				if ($error['code']==0)
				{	
					$returnid=$this->db->insert_id();
					$result=array(
						'returnid' 		=> $returnid,
						'error_number' 	=> 0,
						'error_message' => 'success'
					);
					
					$this->inserttracer('Customer Profile',$id,$this->db->last_query(),'Add',$userid);
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
			$this->db->where('customerid !=',$id);
			$this->db->where('lastname', $lastname);
			$this->db->where('firstname', $firstname);
			$this->db->where('branchareaid', $branch);
			
			$this->db->select('*');
			$this->db->from('tbl_customers');
			$query = $this->db->get();
			
			if ($query->num_rows()<1)
			{
				$data = array(
						'branchareaid' 		=> $branch,
						'lastname' 			=> $lastname,
						'firstname' 		=> $firstname,
						'middlename' 		=> $middlename,
						'suffix' 			=> $suffix,
						'bday' 				=> $bday,
						'birthplace' 		=> $bplace,
						'gender' 			=> $gender,
						'address' 			=> $address,
						'cellphonenumber' 	=> $cellphonenumber,
						'telephonenumber' 	=> $telephonenumber,
						'emailaddress' 		=> $emailaddress,
						'maritalstatus' 	=> $maritalstatus,
						'employmentstatus' 	=> $empstatus,
						'tinnumber' 		=> $tinnumber,
						'remarks' 			=> $remarks,
					);
					
				$this->db->where('customerid',$id);
				$this->db->update('tbl_customers',$data);
				$error = $this->db->error(); 
				if ($error['code']==0)
				{	
					$result=array(
						'error_number' 	=> 0,
						'error_message' => 'success'
					);
					
					$this->inserttracer('Customer Profile',$id,$this->db->last_query(),'Update',$userid);
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
	
	function savedocuattachment($id,$name,$type,$userid)
	{
		$this->db->trans_start();
		$result=null;
		
		$data = array(
			'customerid' 		=> $id,
			'documentname' 		=> $name,
			'documenttype' 		=> $type,
			'entryuserid' 		=> $userid,
			'entrydate' 		=>  date("Y-m-d H:i:s")
		);

		$this->db->insert('tbl_customers_documents',$data);
		$error = $this->db->error(); 
		if ($error['code']==0)
		{
			$returnid=$this->db->insert_id();
			$result=array(
				'returnid' 		=> $returnid,
				'error_number' 	=> 0,
				'error_message' => 'success'
			);
			$this->inserttracer('Customer Documents',$returnid,$this->db->last_query(),'Add',$userid);
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
	
	function savedocumentchunk($id,$sequence,$content)
	{
		$this->db->trans_start();
		$result=null;

		$data = array(
			'documentid' 		=> $id,
			'sequence' 			=> $sequence,
			'content' 			=> $content
		);

		$this->db->insert('tbl_customers_documents_chunk',$data);
		$this->db->trans_complete();
	}
	
	function saveimagechunk($id,$imagetype,$sequence,$content)
	{
		$this->db->trans_start();
		$result=null;
		if ($sequence==1)
		{
			$this->db->where('customerid',$id);
			$this->db->delete('tbl_customers_images');	
		}

		$data = array(
			'customerid' 		=> $id,
			'imagetype' 		=> $imagetype,
			'sequence' 			=> $sequence,
			'content' 			=> $content
		);

		$this->db->insert('tbl_customers_images',$data);
		$this->db->trans_complete();
	}
	
	function migrateprofile($dbase,$id,$oldrefno,$fname,$mname,$lname,$address,$gender,$mobile,$bday,$bplace,$mstatus,
			$telno,$tin,$empstatus,$remarks,$areaid,$areaname,$createuser,$created,$userid)
	{
		$this->db->trans_start();
		
		$result=null;
		$refno=null;
		$result=1;
		$ctr=1;
		
		// $this->db->where('lastname', $lname);
		// $this->db->where('firstname', $fname);
		// $this->db->where('bday', $bday);
		// $this->db->select('customerid');
		// $this->db->from('tbl_customers');
		// $query = $this->db->get();
		
		// if ($query->num_rows()<1)
		// {
			do 
			{
				$refno=$this->mylibraries->getcustomerreferencenumber($ctr);
				$result=$this->checkreferencenumbernumber(trim($refno));
				$ctr++;
			} while ($result > 0);
			
			$data = array(
				'refnumber' 		=> $refno,
				'oldrefnumber'		=> $oldrefno,
				'lastname' 			=> $this->mylibraries->replacespecialcharacter($lname),
				'firstname' 		=> $this->mylibraries->replacespecialcharacter($fname),
				'middlename' 		=> $this->mylibraries->replacespecialcharacter($mname),
				'bday' 				=> $bday,
				'birthplace' 		=> $this->mylibraries->replacespecialcharacter($bplace),
				'gender' 			=> $gender,
				'maritalstatus' 	=> $this->mylibraries->replacespecialcharacter($mstatus),
				'address' 			=> $this->mylibraries->replacespecialcharacter($address),
				'cellphonenumber'	=> $this->mylibraries->replacespecialcharacter($mobile),
				'telephonenumber'	=> $this->mylibraries->replacespecialcharacter($telno),
				'tinnumber'			=> $this->mylibraries->replacespecialcharacter($tin),
				'employmentstatus'	=> $this->mylibraries->replacespecialcharacter($empstatus),
				'remarks'			=> $this->mylibraries->replacespecialcharacter($remarks),
				'isactive' 			=> 'T',
				'entryuserid' 		=> $userid,
				'entrydate' 		=>  date("Y-m-d H:i:s")
			);

			$this->db->insert('tbl_customers',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$returnid=$this->db->insert_id();
				
				$this->inserttracer('Customer Profile Migrated',$returnid,$this->db->last_query(),'Add',$userid);
			
				$data = array(
					'customerid' 		=> $returnid,
					'servername'		=> $dbase,
					'cust_id'			=> $id,
					'oldrefnumber'		=> $oldrefno,
					'cust_area_id'		=> $areaid,
					'cust_area_name'	=> $areaname,
					'entryby'			=> $createuser,
					'entrydate'			=> $created,
					'migratedby'		=> $userid,
					'migratedstamp'		=> date("Y-m-d H:i:s"),
					'status'			=> 'OK',
					'dateattempt'		=>  date("Y-m-d H:i:s"),
				);

				$this->db->insert('tbl_migrated_customers',$data);
			
			}
			else
			{
				$data = array(
					'servername'		=> $dbase,
					'cust_id'			=> $id,
					'oldrefnumber'		=> $oldrefno,
					'cust_area_id'		=> $areaid,
					'cust_area_name'	=> $areaname,
					'entryby'			=> $createuser,
					'entrydate'			=> $created,
					'migratedby'		=> $userid,
					'migratedstamp'		=> date("Y-m-d H:i:s"),
					'status'			=> $error['message'],
					'dateattempt'		=> date("Y-m-d H:i:s"),
				);

				$this->db->insert('tbl_migrated_customers',$data);
			}
		// }
		// else
		// {
			// $data = array(
				// 'servername'		=> $dbase,
				// 'cust_id'			=> $id,
				// 'oldrefnumber'		=> $oldrefno,
				// 'cust_area_id'		=> $areaid,
				// 'cust_area_name'	=> $areaname,
				// 'entryby'			=> $createuser,
				// 'entrydate'			=> $created,
				// 'migratedby'		=> $userid,
				// 'migratedstamp'		=> date("Y-m-d H:i:s"),
				// 'status'			=> 'Exists',
				// 'dateattempt'		=> date("Y-m-d H:i:s"),
			// );

			// $this->db->insert('tbl_migrated_customers',$data);
		// }
		
		$this->db->trans_complete();
		return $result;	
	}
	

	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	
	function deleteprofile($id,$userid)
	{
		$this->db->trans_start();
		$result=null;
		if (empty($this->getcustomerloan($id)))
		{
			
			$this->deletedocument($id,$userid);
			
			$this->db->where('customerid',$id);
			$this->db->delete('tbl_customers');	
			
			
			$error = $this->db->error(); 
			if ($error['code']==0)
			{	
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				
				$this->inserttracer('Profile',$id,$this->db->last_query(),'Delete',$userid);
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
				'error_message' => 'Unable to delete. Customer has loan(s) transaction(s).'
				);
		}
		
		
		
		$this->db->trans_complete();
		return $result;	
	}
	
	
	function deletedocument($id,$userid)
	{
		$this->db->trans_start();
		$this->db->where('documentid',$id);
		$this->db->delete('tbl_customers_documents');	
		
		$result=null;
		$error = $this->db->error(); 
		if ($error['code']==0)
		{	
			$result=array(
				'error_number' 	=> 0,
				'error_message' => 'success'
			);
			
			$this->db->where('documentid',$id);
			$this->db->delete('tbl_customers_documents_chunk');	
			
			$this->inserttracer('Customer Document',$id,$this->db->last_query(),'Delete',$userid);
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