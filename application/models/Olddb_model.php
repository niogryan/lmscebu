<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class olddb_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	function getbranch()
	{
		$DB = $this->load->database('migrationdb', TRUE);	
		$DB->select("*");
		$DB->from('_migrated_branches_areas');
		$result = $DB->get();
		return $result->result_array();
	}
	
	
	function migrationprofile()
	{	
		$DB = $this->load->database('migrationdb', TRUE);	
		$DB->where('migrationstatus', 'Pending');
		$DB->distinct();
		$DB->select('*');
		$DB->from('_migrated_customers');
		$result = $DB->get();
		return $result->result_array();
	}
	
	function migrationprofilestatus()
	{	
		$db = $this->load->database('migrationdb', TRUE);	
		$sql = "SELECT migrationstatus 'Status',count(customerid) 'Count'
				FROM _migrated_customers  a
				GROUP BY migrationstatus
				";			
		$result=$db->query($sql);	
		
		$newarray['Profile']=$result->result_array();
		
		$sql = "SELECT migrationstatus 'Status',count(migratedloanid) 'Count'
				FROM _migrated_loans  a
				GROUP BY migrationstatus
				";			
		$result=$db->query($sql);

		$newarray['Loan']=$result->result_array();
		
		$sql = "SELECT migrationstatus 'Status',count(loanpaymentid) 'Count'
				FROM _migrated_loans_payments  a
				GROUP BY migrationstatus
				";			
		$result=$db->query($sql);

		$newarray['Payments']=$result->result_array();
		
		return $newarray;	
	}
	
	function migrationloan($id)
	{	
		$returnresult=null;
		$DB = $this->load->database('migrationdb', TRUE);	
		$DB->where('customerid', $id);
		$DB->distinct();
		$DB->select('*');
		$DB->from('_migrated_loans');
		$result = $DB->get();
		return $result->result_array();
	}
	
	function migrationloanpayments($id)
	{	
		$DB = $this->load->database('migrationdb', TRUE);	
		$DB->where('loanid', $id);
		$DB->distinct();
		$DB->select('*');
		$DB->from('_migrated_loans_payments');
		$result = $DB->get();
		return $result->result_array();
	}
	
	function migrationprocess($profile,$loans,$payments)
	{	

		$this->db->trans_start();
		
		$result=null;
		$refno=null;
		$resultctr=1;
		$ctr=1;
		$error=0;
		
		do 
		{
			$refno=$this->mylibraries->getcustomerreferencenumber($ctr);
			$resultctr=$this->customer_model->checkreferencenumbernumber(trim($refno));
			$ctr++;
		} while ($resultctr > 0);
			
		$data = array(
			'branchareaid'		=> $profile['branchareaid'],
			'refnumber' 		=> $refno,
			'oldrefnumber'		=> $profile['oldrefnumber'],
			'lastname' 			=> $profile['lastname'],
			'firstname' 		=> $profile['firstname'],
			'middlename' 		=> $profile['middlename'],
			'bday' 				=> $profile['bday'],
			'birthplace' 		=> $profile['birthplace'],
			'gender' 			=> $profile['gender'],
			'maritalstatus' 	=> $profile['maritalstatus'],
			'address' 			=> $profile['address'],
			'cellphonenumber'	=> $profile['cellphonenumber'],
			'telephonenumber'	=> $profile['telephonenumber'],
			'tinnumber'			=> $profile['tinnumber'],
			'employmentstatus'	=> $profile['employmentstatus'],
			'remarks'			=> $profile['remarks'],
			'isactive' 			=> 'T',
			'entryuserid' 		=> 1,
			'entrydate' 		=> $profile['entrydate']
		);

		$this->db->insert('tbl_customers',$data);
		$error = $this->db->error(); 
		if ($error['code']==0)
		{	
			$returnid=$this->db->insert_id();
			foreach($loans as $row)
			{
				$returnidloan=null;
				$dataloan = array(
				'branchareaid' 		=>  $row['branchareaid'],
				'customerid' 		=>  $returnid,
				'referencenumber' 	=>  $row['referencenumber'],
				'releaseddate' 		=>  $row['releaseddate'],
				'duedate' 			=>  $row['duedate'],
				'principalamount' 	=>  $row['principalamount'],
				'interest' 			=>  $row['interest'],
				'servicecharge' 	=>  $row['servicecharge'],
				'dailyduesamount' 	=>  $row['dailyduesamount'],
				'numholidays' 		=>  $row['numholidays'],
				'specialpayment' 	=>  $row['specialpayment'],
				'passbookcharge' 	=>  $row['passbookcharge'],
				'advancepayment' 	=>  $row['advancepayment'],
				'amountreleased' 	=>  $row['amountreleased'],
				'remarks' 			=> 	$row['remarks'],
				'status'			=> 'Active',
				'entryuserid' 		=> 1,
				'entrydate' 		=> $row['entrydate']
				);
				
				$this->db->insert('tbl_loans',$dataloan);
				$errorloan = $this->db->error(); 
				if ($errorloan['code']==0 )
				{	
					$returnidloan=$this->db->insert_id();

					if ($row['status']=='OK')
					{
						foreach($payments[$row['loanid']] as $rowpayment)
						{
							$data = array(
								'loanid' 			=> $returnidloan,
								'ornumber' 			=> $rowpayment['ornumber'],
								'paymentdate' 		=> $rowpayment['paymentdate'],
								'paymenttype' 		=> ucfirst($rowpayment['paymenttype']),
								'paymentamount' 	=> $rowpayment['paymentamount'],
								'paymentremarks' 	=> $rowpayment['paymentremarks'],
								'entryuserid' 		=> 1,
								'entrydate' 		=> $rowpayment['entrydate']
							);

							$this->db->insert('tbl_loans_payments',$data);
						}
					}
					
				}
				
				$this->updatebalance($returnidloan);
			}
			
			$DB = $this->load->database('migrationdb', TRUE);	
			$data = array(
						'migrationstatus' 	=> 'OK'
					);
					
			$DB->where('customerid',$profile['customerid']);
			$DB->update('_migrated_customers',$data);
			
		}
		
		
		$this->db->trans_complete();
	}
	
	function updatebalance($loanid)
	{
		$this->db->where('loanid',$loanid);
		$this->db->select("IFNULL(sum(paymentamount),0) as 'amount'",false);
		$this->db->from('tbl_loans_payments');
		$result = $this->db->get();
		
		$totalpayment=$result->result_array()[0]['amount'];
		
		$this->db->where('loanid',$loanid);
		$this->db->select("principalamount,duedate,interest");
		$this->db->from('tbl_loans');
		$result = $this->db->get();

		$totalloan=($result->result_array()[0]['principalamount']+$result->result_array()[0]['interest']);
		$duedate=$result->result_array()[0]['duedate'];
		$balance = ($totalloan-$totalpayment);
		$status='Active';
		
		$this->db->where('loanid',$loanid);
		$this->db->select("paymentdate");
		$this->db->from('tbl_loans_payments');
		$this->db->order_by("paymentdate desc");
		$this->db->limit(1); 
		$lastpaymentdate = $this->db->get();
		
		
		
		if ($balance <=0)
		{
			$status='Paid';
		}
		
		if ($totalpayment>0)
		{
			if ($lastpaymentdate->result_array()[0]['paymentdate']>$duedate &&  $balance>0)
			{
				$status='Default';
			}
		}
		
		if ($totalpayment>0)
		{
			if ($lastpaymentdate->result_array()[0]['paymentdate']>$duedate && $balance<=0)
			{
				$status='Overdue';
			}
		}
		
		if (date("Y-m-d")>$duedate && $totalpayment==0) 
		{
			$status='Default';
		}
		
		
		$data = array(
					'balance' 			=> $balance,
					'status'			=> $status
				);
				
		$this->db->where('loanid',$loanid);
		$this->db->update('tbl_loans',$data);
	}
	
	function updatebranch($param1,$param2)
	{
		$DB = $this->load->database('migrationdb', TRUE);	
		$data = array(
				'mbranchareaid' 	=> $param2
				);

		$DB->where('uqid',$param1);
		$DB->update('_migrated_branches_areas',$data);	
	}
			
	
}