<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class loan_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	function searchcustomerprofile($param)
	{
		$this->db->where('a.branchareaid',$param); 
		$this->db->select('a.*,branchname,areaname');
		$this->db->from('tbl_customers a');
		$this->db->join('tbl_branches_areas b','a.branchareaid=b.branchareaid');
		$this->db->join('tbl_branches c','b.branchid=c.branchid');
		$this->db->join('tbl_areas d','b.areaid=d.areaid');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getcountloansperbrancharea($id)
	{
		$this->db->where('branchareaid', $id);
		$this->db->where('YEAR(entrydate)', date("Y"));
		$this->db->select('loanid');
		$this->db->from('tbl_loans');
		$result = $this->db->get();
		return $result->num_rows();
	}
	
	function checkreferencenumbernumber($refno)
	{
		$this->db->where('TRIM(referencenumber)', $refno);
		$this->db->select('loanid');
		$this->db->from('tbl_loans');
		$result = $this->db->get();
		return $result->num_rows();
	}
	
	function getloandetails($param)
	{

		$this->db->where('loanid', $param);
		$this->db->select('a.*,firstname,lastname,suffix,d.branchname,areacity,areaname');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->join('tbl_branches d','c.branchid=d.branchid');
		$this->db->join('tbl_areas e','c.areaid=e.areaid');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	
	function searchcustomerloan($brancharea,$sort)
	{

		$this->db->where('a.branchareaid',$brancharea);
		$this->db->where('a.status!=','Archived');
		$this->db->distinct();
		$this->db->select('loanid,referencenumber,oldreferencenumber,releaseddate,principalamount,interest,balance,status,firstname,lastname,suffix,d.branchname,areacity,areaname');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->join('tbl_branches d','c.branchid=d.branchid');
		$this->db->join('tbl_areas e','c.areaid=e.areaid');
		$this->db->join('tbl_useraccounts_branches f','c.branchid=f.branchid');
		
		if($sort=='2')
		{
			$this->db->order_by("releaseddate,lastname,firstname");
		}
		if($sort=='3')
		{
			$this->db->order_by("status,lastname,firstname");
		}		
		else 
		{
			$this->db->order_by("lastname,firstname");
		}
		
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getcustomerloanbybranchdate($branch,$date)
	{

		$this->db->where('c.branchid',$branch);
		$this->db->where('releaseddate',$date);
		$this->db->distinct();
		$this->db->select('loanid,referencenumber,oldreferencenumber,releaseddate,principalamount,interest,balance,status,firstname,lastname,suffix,d.branchname,areacity,areaname');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->join('tbl_branches d','c.branchid=d.branchid');
		$this->db->join('tbl_areas e','c.areaid=e.areaid');
		$this->db->join('tbl_useraccounts_branches f','c.branchid=f.branchid');
		$this->db->order_by("releaseddate,lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getcustomerloanbybranchduedate($branch,$date)
	{

		$this->db->where('c.branchid',$branch);
		$this->db->where('duedate',$date);
		$this->db->distinct();
		$this->db->select('loanid,referencenumber,oldreferencenumber,releaseddate,principalamount,interest,balance,status,firstname,lastname,suffix,d.branchname,areacity,areaname');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->join('tbl_branches d','c.branchid=d.branchid');
		$this->db->join('tbl_areas e','c.areaid=e.areaid');
		$this->db->join('tbl_useraccounts_branches f','c.branchid=f.branchid');
		$this->db->order_by("releaseddate,lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function searchcustomeractiveloan($param)
	{
		$this->db->where('balance >0'); 
		$this->db->where('a.branchareaid',$param); 
		$this->db->distinct();
		$this->db->select('loanid,referencenumber,oldreferencenumber,releaseddate,principalamount,interest,balance,status,firstname,lastname,suffix,d.branchname,areacity,areaname');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->join('tbl_branches d','c.branchid=d.branchid');
		$this->db->join('tbl_areas e','c.areaid=e.areaid');
		$this->db->join('tbl_useraccounts_branches f','c.branchid=f.branchid');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function searchcustomerbyareauseraccess($userid)
	{
		$this->db->where('f.userid',$userid); 
		$this->db->distinct();
		$this->db->select('loanid,referencenumber,oldreferencenumber,releaseddate,principalamount,interest,balance,status,firstname,lastname,suffix,d.branchname,areacity,areaname');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->join('tbl_branches d','c.branchid=d.branchid');
		$this->db->join('tbl_areas e','c.areaid=e.areaid');
		$this->db->join('tbl_useraccounts_areas f','a.branchareaid=f.branchareaid');
		$this->db->order_by("lastname,firstname");
	
		$result = $this->db->get();
		return $result->result_array();
	}
	
	
	
	function getcountpayment()
	{
		$this->db->where('date(entrydate)=CURDATE()');
		$this->db->select('loanpaymentid');
		$this->db->from('tbl_loans_payments');
		$result = $this->db->get();
		return $result->num_rows();
	}
	
	function getloanpayments($id)
	{
		$this->db->where('loanid',$id);
		$this->db->select("a.*,CONCAT(b.firstname,' ',b.lastname) as addedby",false);
		$this->db->from('tbl_loans_payments a');
		$this->db->join('tbl_user_accounts b','a.entryuserid=b.userid');
		$this->db->order_by("paymentdate,entrydate");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getloanpaymentdetails($id)
	{
		$this->db->where('loanpaymentid',$id);
		$this->db->select("*");
		$this->db->from('tbl_loans_payments');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function gettotalloanpayments($id)
	{
		$this->db->where('loanid',$id);
		$this->db->select("sum(paymentamount) as 'amount'",false);
		$this->db->from('tbl_loans_payments');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getloansbybranchdate($branch,$date)
	{
		$this->db->where('b.branchid', $branch);
		$this->db->where('releaseddate', $date);
		$this->db->select("SUM(principalamount) 'amountreleased'");
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_branches_areas b','a.branchareaid=b.branchareaid');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function getloanpaymentsby_customer($customer)
	{
		$this->db->where('b.customerid', $customer);
		$this->db->select("b.loanid,referencenumber,paymentdate,principalamount,interest,ornumber,paymenttype,paymentamount");
		$this->db->from('tbl_loans_payments a');
		$this->db->join('tbl_loans b','a.loanid=b.loanid');
		$this->db->join('tbl_customers c','b.customerid=c.customerid');
		$this->db->join('tbl_branches_areas d','b.branchareaid=d.branchareaid');
		$this->db->join('tbl_branches e','d.branchid=e.branchid');
		$this->db->join('tbl_areas f','d.areaid=f.areaid');
		$this->db->order_by("paymentdate");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function getloanpaymentsby_dates($branch,$datefrom,$dateto)
	{
		$this->db->where('d.branchid', $branch);
		$this->db->where('paymentdate >=', $datefrom);
		$this->db->where('paymentdate <=', $dateto);
		$this->db->distinct();
		$this->db->select("b.loanid,referencenumber,paymentdate,principalamount,interest,ornumber,paymenttype,paymentamount,firstname,lastname,suffix,branchname,areacity,areaname");
		$this->db->from('tbl_loans_payments a');
		$this->db->join('tbl_loans b','a.loanid=b.loanid');
		$this->db->join('tbl_customers c','b.customerid=c.customerid');
		$this->db->join('tbl_branches_areas d','b.branchareaid=d.branchareaid');
		$this->db->join('tbl_branches e','d.branchid=e.branchid');
		$this->db->join('tbl_areas f','d.areaid=f.areaid');
		
		
		$this->db->order_by("paymentdate,lastname,firstname");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function getloanpaymentsby_aresdates($brancharea,$datefrom,$dateto)
	{
		$this->db->where('b.branchareaid ', $brancharea);
		$this->db->where('paymentdate >=', $datefrom);
		$this->db->where('paymentdate <=', $dateto);
		$this->db->select("b.loanid,referencenumber,paymentdate,principalamount,interest,ornumber,paymenttype,paymentamount,firstname,lastname,suffix");
		$this->db->from('tbl_loans_payments a');
		$this->db->join('tbl_loans b','a.loanid=b.loanid');
		$this->db->join('tbl_customers c','b.customerid=c.customerid');
		$this->db->order_by("paymentdate,lastname,firstname");
		$query = $this->db->get();
		return $query->result_array();
	}


	
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	
	
	function saveloan($id,$branch,$brancharea,$date,$duedate,$amount,$interest,$sc,$dailydues
					,$holiday,$special,$passbook,$advance,$totalamount,$remarks,$userid)
	{
		$this->db->trans_start();
		
		$result=null;
		$refno=null;
		$result=1;
		$ctr=1;
		
		do 
		{
			$refno=$this->mylibraries->getloanreferencenumber($branch,$ctr);
			$result=$this->checkreferencenumbernumber(trim($refno));
			$ctr++;
		} while ($result > 0);


		$data = array(
			'branchid' 			=> $branch,
			'branchareaid' 		=> $brancharea,
			'customerid' 		=> $id,
			'referencenumber' 	=> $refno,
			'releaseddate' 		=> $date,
			'duedate' 			=> $duedate,
			'principalamount' 	=> $amount,
			'interest' 			=> $interest,
			'servicecharge' 	=> $sc,
			'dailyduesamount' 	=> $dailydues,
			'numholidays' 		=> $holiday,
			'specialpayment' 	=> $special,
			'passbookcharge' 	=> $passbook,
			'advancepayment' 	=> $advance,
			'amountreleased' 	=> $totalamount,
			'remarks' 			=> $remarks,
			'status'			=> 'Active',
			'balance' 			=> ($amount+$interest),
			'entryuserid' 		=> $userid,
			'entrydate' 		=> date("Y-m-d H:i:s")
		);

		$this->db->insert('tbl_loans',$data);
		$error = $this->db->error(); 
		if ($error['code']==0)
		{
			$returnid=$this->db->insert_id();
			$result=array(
				'returnid' 		=> $returnid,
				'error_number' 	=> 0,
				'error_message' => 'success'
			);
			
			if ($advance>0)
			{
				$this->savepayment($returnid,$date,'Advance',$advance,'New Loan', $userid);
			}
			
			if ($special>0)
			{
				$this->savepayment($returnid,$date,'Special',$special,'New Loan', $userid);
			}

			$this->inserttracer('Loan',$returnid,$this->db->last_query(),'Add',$userid);
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
	
	function savepayment($id,$date,$type,$amount,$remarks,$userid)
	{
		$this->db->trans_start();
		
		$result=null;
		$refno=null;
		$result=1;
		$ctr=1;
		
		do 
		{
			$refno=$this->mylibraries->getornumber($ctr);
			$result=$this->checkreferencenumbernumber(trim($refno));
			$ctr++;
		} while ($result > 0);
		

		$data = array(

			'loanid' 			=> $id,
			'ornumber' 			=> $refno,
			'paymentdate' 		=> $date,
			'paymenttype' 		=> $type,
			'paymentamount' 	=> $amount,
			'paymentremarks' 	=> $remarks,
			'entryuserid' 		=> $userid,
			'entrydate' 		=> date("Y-m-d H:i:s")
		);

		$this->db->insert('tbl_loans_payments',$data);
		$error = $this->db->error(); 
		if ($error['code']==0)
		{
			$returnid=$this->db->insert_id();
			$result=array(
				'error_number' 	=> 0,
				'error_message' => 'success'
			);
			
			$this->updatebalance($id);
			$this->inserttracer('Payment',$returnid,$this->db->last_query(),'Add',$userid);
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
	
	function updatepayment($id,$paymentid,$date,$type,$amount,$remarks,$userid)
	{
		$this->db->trans_start();
		
		
		$data = array(
			'paymentdate' 		=> $date,
			'paymenttype' 		=> $type,
			'paymentamount' 	=> $amount,
			'paymentremarks' 	=> $remarks
		);
		
		$this->db->where('loanpaymentid',$paymentid);
		$this->db->update('tbl_loans_payments',$data);
		$error = $this->db->error(); 
		if ($error['code']==0)
		{
			$result=array(
				'error_number' 	=> 0,
				'error_message' => 'success'
			);
			
			$this->updatebalance($id);
			$this->inserttracer('Payment',$paymentid,$this->db->last_query(),'Update',$userid);
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
	
	function updatebalance($loanid)
	{
		$this->db->where('loanid',$loanid);
		$this->db->select("sum(paymentamount) as 'amount'",false);
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
		
		if ($balance <=0)
		{
			$status='Paid';
		}
		
		if (date("Y-m-d")>$duedate)
		{
			$status='Overdue';
		}
		
		//2023-12-31 updates start
		$details = $this->updateLoanDetails($loanid);
		$data = array(
					'balance' 			=> $balance,
					'status'			=> $status,
					'lastpaymentdate'	=> $details[0]['lastpaymentdate'],
					'totalamountpaid'		=> $details[0]['totalpayment']
				);
		//2023-12-31 updates end
				
		$this->db->where('loanid',$loanid);
		$this->db->update('tbl_loans',$data);
	}
	
	function updateloanstatus()
	{
		$data = array(
					'status' => 'Default'
				);
				
		$this->db->where('duedate <',date("Y-m-d"));
		$this->db->where('balance >0');
		$this->db->where('status !=','Archived');
		$this->db->update('tbl_loans',$data);
		
		$sql = "UPDATE tbl_loans a
				INNER JOIN tbl_branches_areas b
				ON a.branchareaid=b.branchareaid
				SET a.branchid=b.branchid
				";		
		$this->db->query($sql);	
	}

	//2023-12-31 updates start
	function updateLoanDetails($id)
	{
		$this->db->where('loanid',$id);
		$this->db->select("ifnull(sum(paymentamount),0) as 'totalpayment', max(paymentdate) as 'lastpaymentdate'",false);
		$this->db->from('tbl_loans_payments');
		$result = $this->db->get();
		return $result->result_array();
	}
	//2023-12-31 updates end
	
	
	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	
	function deleteloan($id,$userid)
	{
		
		$this->db->trans_start();
		
		$result=null;
		if (empty($this->getloanpayments($id)))
		{
			$this->db->where('loanid',$id);
			$this->db->delete('tbl_loans');	
			
			
			$error = $this->db->error(); 
			if ($error['code']==0)
			{	
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				
				$this->updatebalance($loanid);
				
				$this->inserttracer('Loan',$id,$this->db->last_query(),'Delete',$userid);
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
				'error_message' => 'Unable to delete. Loan already with payment(s).'
				);
		}
		
		
	
		$this->db->trans_complete();
		return $result;	
	}
	
	
	function deletepayment($id,$loanid,$userid)
	{
		$this->db->trans_start();
		$this->db->where('loanpaymentid',$id);
		$this->db->delete('tbl_loans_payments');	
		
		$result=null;
		$error = $this->db->error(); 
		if ($error['code']==0)
		{	
			$result=array(
				'error_number' 	=> 0,
				'error_message' => 'success'
			);
			
			$this->updatebalance($loanid);
			
			$this->inserttracer('Payment',$id,$this->db->last_query(),'Delete',$userid);
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
	
		
	function get123456() 
	{
		$sql = "SELECT DISTINCT loanid
				FROM tbl_loans_payments a
				WHERE DATE(a.entrydate)='2021-07-22' ";		
		$result=$this->db->query($sql);	
		return $result->result_array();	

	}

	function updateTotalPaymentLastPaymentDate()
	{
		try{
			$sql = "SELECT loanid
					FROM tbl_loans a
					WHERE totalamountpaid is null
					order by loanid desc
					LIMIT 200";	

			$result=$this->db->query($sql);	
			$loans = $result->result_array();	

			foreach($loans as $loan)
			{
				$details=$this->updateLoanDetails($loan['loanid']);
				$data = array(
					'totalamountpaid' 	=> $details[0]['totalpayment'],
					'lastpaymentdate' 	=> $details[0]['lastpaymentdate']
				);
				$this->db->where('loanid',$loan['loanid']);
				$this->db->update('tbl_loans',$data);
			}
			return 'success';
		}
		catch(Exception $e){
			return $e->getMessage();
		}
	}
	
}
