<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class report_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	
	function getbranchloanpayments($branch,$period,$date,$month,$year,$datefrom,$dateto)
	{
		if($period=='D')
		{
			$this->db->where('paymentdate', $date);
		}	
		else if($period=='M')
		{
			$this->db->where('MONTH(paymentdate)', $month);
			$this->db->where('YEAR(paymentdate)', $year);
		}
		else if($period=='R')
		{
			$this->db->where('paymentdate >=', $datefrom);
			$this->db->where('paymentdate <=', $dateto);
		}
		
		$this->db->where('b.branchareaid', $branch);
		$this->db->select("SUM(IFNULL(a.paymentamount,0)) as amount",false);
		$this->db->from('tbl_loans_payments a');
		$this->db->join('tbl_loans b','a.loanid=b.loanid');
		$result = $this->db->get();

		return $result->result_array();

	}
	
	function getbranchreleasedloans($branch,$period,$date,$month,$year,$datefrom,$dateto)
	{
		if($period=='D')
		{
			$this->db->where('releaseddate', $date);
		}	
		else if($period=='M')
		{
			$this->db->where('MONTH(releaseddate)', $month);
			$this->db->where('YEAR(releaseddate)', $year);
		}
		else if($period=='R')
		{
			$this->db->where('releaseddate >=', $datefrom);
			$this->db->where('releaseddate <=', $dateto);
		}
		
		$this->db->where('a.branchareaid', $branch);
		$this->db->select("SUM(IFNULL(a.amountreleased,0)) as amount",false);
		$this->db->from('tbl_loans a');
		$result = $this->db->get();

		return $result->result_array();

	}
	
	function getbranchreleasedloansdetails($branch,$period,$date,$month,$year,$datefrom,$dateto)
	{
		if($period=='D')
		{
			$this->db->where('releaseddate', $date);
		}	
		else if($period=='M')
		{
			$this->db->where('MONTH(releaseddate)', $month);
			$this->db->where('YEAR(releaseddate)', $year);
		}
		else if($period=='R')
		{
			$this->db->where('releaseddate >=', $datefrom);
			$this->db->where('releaseddate <=', $dateto);
		}
		
		$this->db->where('a.branchareaid', $branch);
		$this->db->select('a.*,firstname,lastname,suffix');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->order_by("releaseddate");
		$result = $this->db->get();

		return $result->result_array();

	}
	
	function getbranchloanpaymentsdetails($branch,$period,$date,$month,$year,$datefrom,$dateto)
	{
		if($period=='D')
		{
			$this->db->where('paymentdate', $date);
		}	
		else if($period=='M')
		{
			$this->db->where('MONTH(paymentdate)', $month);
			$this->db->where('YEAR(paymentdate)', $year);
		}
		else if($period=='R')
		{
			$this->db->where('paymentdate >=', $datefrom);
			$this->db->where('paymentdate <=', $dateto);
		}
		
		$this->db->where('b.branchareaid', $branch);
		$this->db->select("a.*,b.*,firstname,lastname,suffix");
		$this->db->from('tbl_loans_payments a');
		$this->db->join('tbl_loans b','a.loanid=b.loanid');
		$this->db->join('tbl_customers c','b.customerid=c.customerid');
		$this->db->order_by("paymentdate");
		$result = $this->db->get();

		return $result->result_array();

	}
	
	function getsummarycollectionsreport($brancharea, $date) 
	{ 
		$this->db->where('a.branchareaid',$brancharea);
		$this->db->where("('{$date}' BETWEEN releaseddate AND duedate)");
		$this->db->where("releaseddate < '{$date}'");
		$this->db->select('a.loanid,a.principalamount,a.interest,a.duedate,a.customerid,a.referencenumber,a.dailyduesamount');
		$this->db->from('tbl_loans a');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getsummarycollectionsreport2($branch, $date) 
	{ 
		$result = null; 
		// $sql = "	SELECT a.loanid,a.branchareaid,a.principalamount,a.interest,a.duedate,a.customerid,a.referencenumber,a.dailyduesamount
					// ,(SELECT IFNULL(SUM(paymentamount),0) 'amount' FROM tbl_loans_payments WHERE loanid=a.loanid AND paymentdate <='{$date}') 'totalamountpaid'
					// ,(SELECT MAX(paymentdate) FROM tbl_loans_payments WHERE loanid=a.loanid)  'lastpaymentdate'
					// FROM `tbl_loans` `a` 
					// INNER JOIN tbl_branches_areas b
					// ON a.branchareaid=b.branchareaid
					// WHERE `a`.`branchid` = '{$branch}' AND ('{$date}' BETWEEN `releaseddate` AND duedate) AND `releaseddate` < '{$date}'
				// ";	
		$sql="SELECT a.loanid,a.branchareaid,a.principalamount,a.interest,a.duedate,a.customerid,a.referencenumber,a.dailyduesamount 
				,IFNULL(c.paymentamount,0) 'totalamountpaid' 
				,d.paymentdate 'lastpaymentdate' 
				FROM `tbl_loans` `a` 
				INNER JOIN tbl_branches_areas b ON a.branchareaid=b.branchareaid 
				LEFT JOIN ( SELECT loanid,SUM(paymentamount) 'paymentamount' FROM tbl_loans_payments WHERE paymentdate<='{$date}' GROUP BY loanid ) AS c ON a.loanid=`c`.loanid 
				LEFT JOIN ( SELECT loanid,MAX(paymentdate) 'paymentdate' FROM tbl_loans_payments GROUP BY loanid) AS d ON a.loanid=`d`.loanid
				WHERE `a`.`branchid` = '{$branch}' AND ('{$date}' BETWEEN `releaseddate` AND duedate) AND `releaseddate` < '{$date}'";
				
		// echo $sql;
		// die();
		$result=$this->db->query($sql);	
		
		return $result->result_array();	
	}
	

	
	function getsummarycollectionbybranch($branch, $date) 
	{ 
		$result = null; 

		$sql = "SELECT a.branchareaid,b.branchid,b.areaid,c.branchname,d.areaname, IFNULL(SUM(dailyduesamount),0) 'totaldailydues'
				FROM tbl_loans a
				INNER JOIN tbl_branches_areas b
				ON a.branchareaid=b.branchareaid
				INNER JOIN tbl_branches c
				ON b.branchid=c.branchid
				INNER JOIN tbl_areas d
				ON b.areaid=d.areaid
				WHERE ('{$date}' BETWEEN releaseddate AND duedate)
				AND releaseddate<'{$date}' and b.branchid={$branch}
				GROUP BY a.branchareaid,c.branchname,d.areaname
				ORDER BY d.areaname
				";		
		
		$result=$this->db->query($sql);	
		return $result->result_array();	
	}
	
	function getlenderscollection_fullypaid($branch,$area,$date)
	{
		$this->db->where('c.branchid',$branch);
		
		if ($area!='ALL')
		{
			$this->db->where('c.areaid',$area);
		}
		
		$this->db->where('f.paymentdate',$date);
		$this->db->where("balance <= 0");
		$this->db->distinct();
		$this->db->select('a.*,firstname,lastname,middlename,suffix,f.paymentamount');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->join('tbl_loans_payments f','a.loanid=f.loanid');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();

	}
	
	function getlenderscollection_allbadaccounts($branch,$area,$date,$sort)
	{
		$date_yesterday = date("Y-m-d", strtotime($date . "-1 days")); 
		
		// $this->db->where('c.branchid',$branch);
		
		// if ($area!='ALL')
		// {
			// $this->db->where('c.areaid',$area);
		// }
		
		// $this->db->where("duedate < '{$date}' AND balance>0");
		// $this->db->distinct();
		// $this->db->select("a.*,firstname,lastname,middlename,suffix,IFNULL(d.paymentamount,0) paidamount",false);
		// $this->db->from('tbl_loans a');
		// $this->db->join('tbl_customers b','a.customerid=b.customerid');
		// $this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		// $this->db->join('tbl_loans_payments d','a.loanid=d.loanid and d.paymentdate="'.$date.'"','left');
		// if ($sort==2)
		// {
			// $this->db->order_by("duedate,lastname,firstname");
		// }
		// else
		// {
			// $this->db->order_by("lastname,firstname");
		// }
		
		// $result = $this->db->get();
		// echo $this->db->last_query();
		// die();
		
		$sql="SELECT DISTINCT a.*, firstname, lastname, middlename, suffix
				,IFNULL(d.paymentamount,0) 'TotalPaymentYesterday' 
				,IFNULL(e.paymentamount,0) 'paidamount' 
				FROM `tbl_loans` `a` 
				JOIN `tbl_customers` `b` ON `a`.`customerid`=`b`.`customerid` 
				JOIN `tbl_branches_areas` `c` ON `a`.`branchareaid`=`c`.`branchareaid` 
				LEFT JOIN ( SELECT loanid,SUM(paymentamount) 'paymentamount' FROM tbl_loans_payments WHERE paymentdate<='{$date_yesterday}' GROUP BY loanid ) AS d ON a.loanid=`d`.loanid 
				LEFT JOIN ( SELECT loanid,SUM(paymentamount) 'paymentamount' FROM tbl_loans_payments WHERE paymentdate='{$date}' GROUP BY loanid ) AS e ON a.loanid=`e`.loanid 
				WHERE `c`.`branchid` = '{$branch}' AND `duedate` < '{$date}' AND `balance` >0 AND a.status != 'Archived' ";
		
		if ($area!='ALL')
		{
			$sql .=" AND `c`.`areaid` = '{$area}' ";
		}	
			
		if ($sort==2)
		{
			$sql .=" ORDER BY duedate,lastname,firstname";
		}
		else
		{
			$sql .=" ORDER BY lastname,firstname";
		}
		
		$result=$this->db->query($sql);	
		return $result->result_array();	

	}
	
	function getlenderscollection_badaccounts($branch,$area,$date,$sort)
	{
		// $this->db->where('c.branchid',$branch);
		
		// if ($area!='ALL')
		// {
			// $this->db->where('c.areaid',$area);
		// }
		
		// $this->db->where('f.paymentdate',$date);
		// $this->db->where("duedate < '{$date}'");
		// $this->db->distinct();
		// $this->db->select('a.*,firstname,lastname,middlename,suffix,f.paymentamount,f.paymentdate');
		// $this->db->from('tbl_loans a');
		// $this->db->join('tbl_customers b','a.customerid=b.customerid');
		// $this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		// $this->db->join('tbl_loans_payments f','a.loanid=f.loanid');
		// if ($sort==2)
		// {
			// $this->db->order_by("duedate,lastname,firstname");
		// }
		// else
		// {
			// $this->db->order_by("lastname,firstname");
		// }
		
		// $result = $this->db->get();
		// echo $this->db->last_query();
		// die();
		
		$sql="SELECT DISTINCT `a`.*, `firstname`, `lastname`, `middlename`, `suffix`, `d`.`paymentamount`, `d`.`paymentdate` 
		,IFNULL(e.paymentamount,0) 'PaymentAsOf' 
		FROM `tbl_loans` `a` 
		JOIN `tbl_customers` `b` ON `a`.`customerid`=`b`.`customerid` 
		JOIN `tbl_branches_areas` `c` ON `a`.`branchareaid`=`c`.`branchareaid` 
		JOIN `tbl_loans_payments` `d` ON `a`.`loanid`=`d`.`loanid` 
		LEFT JOIN ( SELECT loanid,SUM(paymentamount) 'paymentamount' 
				FROM tbl_loans_payments WHERE paymentdate<'{$date}' GROUP BY loanid ) AS e ON a.loanid=`e`.loanid
		WHERE `c`.`branchid` = '{$branch}' AND `d`.`paymentdate` = '{$date}' AND `duedate` < '{$date}' and a.status != 'Archived' ";
		
		if ($area!='ALL')
		{
			$sql .=" AND `c`.`areaid` = '{$area}' ";
		}
		
		if ($sort==2)
		{
			$sql .=" ORDER BY duedate, `lastname`, `firstname` ";
		}
		else
		{
			$sql .=" ORDER BY `lastname`, `firstname` ";
		}
		
		
		$result=$this->db->query($sql);	
		return $result->result_array();	
		
		return $result->result_array();

	}
	
	
	function getlenderscollection($branch,$area,$date,$sort)
	{
		$date_yesterday = date("Y-m-d", strtotime($date . "-1 days")); 
		// $this->db->where('c.branchid',$branch);
		
		// if ($area!='ALL')
		// {
			// $this->db->where('c.areaid',$area);
		// }
		
		// $this->db->where("('{$date}' BETWEEN releaseddate AND duedate)");
		// $this->db->where("releaseddate < '{$date}'");
		// $this->db->distinct();
		// $this->db->select('a.loanid,a.releaseddate,a.dailyduesamount,a.principalamount,a.interest,a.duedate,a.dailyduesamount,a.customerid,a.referencenumber,a.advancepayment,firstname,lastname,middlename,suffix');
		// $this->db->from('tbl_loans a');
		// $this->db->join('tbl_customers b','a.customerid=b.customerid');
		// $this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		
		
		// $result = $this->db->get();

		// $sql = "SELECT DISTINCT `a`.`loanid`, `a`.`releaseddate`, `a`.`dailyduesamount`, `a`.`principalamount`, `a`.`interest`, `a`.`duedate`, `a`.`dailyduesamount`, `a`.`customerid`, `a`.`referencenumber`
			// , `a`.`advancepayment`, `firstname`, `lastname`, `middlename`, `suffix` 
			// FROM `tbl_loans` `a` 
			// JOIN `tbl_customers` `b` ON `a`.`customerid`=`b`.`customerid` 
			// JOIN `tbl_branches_areas` `c` ON `a`.`branchareaid`=`c`.`branchareaid` 
			// WHERE `c`.`branchid` = '{$branch}'  AND ('{$date}' BETWEEN `releaseddate` AND duedate) AND `releaseddate` < '{$date}' ";
			
		$sql= "SELECT DISTINCT `a`.`loanid`, `a`.`releaseddate`, `a`.`dailyduesamount`, `a`.`principalamount`, `a`.`interest`, `a`.`duedate`, `a`.`dailyduesamount`
			, `a`.`customerid`, `a`.`referencenumber` , `a`.`advancepayment`, `firstname`, `lastname`, `middlename`, `suffix` 
			,IFNULL(d.paymentamount,0) 'TotalPaymentYesterday' 
			,IFNULL(e.paymentamount,0) 'TotalPaymentToday' 
			,IFNULL(f.paymentamount,0) 'TotalPaymentByDate' 
			,g.paymentdate 'LastPaymentDate' 
			FROM `tbl_loans` a
			 JOIN  `tbl_customers` `b` ON `a`.`customerid`=`b`.`customerid` 
			 JOIN  `tbl_branches_areas` `c` ON `a`.`branchareaid`=`c`.`branchareaid` 
			 LEFT JOIN (
				SELECT loanid,SUM(paymentamount) 'paymentamount' 
				FROM tbl_loans_payments 
				WHERE paymentdate<='{$date_yesterday}'
				GROUP BY loanid
				) AS d
			 ON a.loanid=`d`.loanid
			 LEFT JOIN (
				SELECT loanid,SUM(paymentamount) 'paymentamount' 
				FROM tbl_loans_payments 
				WHERE paymentdate='{$date}'
				GROUP BY loanid
				) AS e
			  ON a.loanid=`e`.loanid
			 LEFT JOIN (
				SELECT loanid,SUM(paymentamount) 'paymentamount' 
				FROM tbl_loans_payments 
				WHERE paymentdate<='{$date}'
				GROUP BY loanid
			) AS f
			ON a.loanid=`f`.loanid
			LEFT JOIN ( SELECT loanid,MAX(paymentdate) 'paymentdate' FROM tbl_loans_payments GROUP BY loanid) AS g ON a.loanid=`g`.loanid 
			 
			WHERE `c`.`branchid` = '{$branch}'  AND ('{$date}' BETWEEN `releaseddate` AND duedate) AND `releaseddate` < '{$date}' ";
			
		
		if ($area!='ALL')
		{
			$sql .=" AND `c`.`areaid` = '{$area}' ";
		}	
			
			
		if ($sort==2)
		{
			$sql .=" ORDER BY duedate,lastname,firstname";
		}
		else
		{
			$sql .=" ORDER BY lastname,firstname";
		}	
			
		$result=$this->db->query($sql);	
		// echo $this->db->last_query();
		// die();
		return $result->result_array();

	}
	
	function getlenderscollectionpayments($loanid,$date)
	{
		// $date_yesterday = date("Y-m-d", strtotime($date . "-1 days")); 
		// $sql = "
		// SELECT
		// (SELECT IFNULL(SUM(paymentamount),0) FROM tbl_loans_payments WHERE paymentdate<='{$date_yesterday}' AND loanid={$loanid}) AS 'TotalPaymentYesterday' 
		// ,(SELECT IFNULL(SUM(paymentamount),0) FROM tbl_loans_payments WHERE paymentdate='{$date}' AND loanid={$loanid}) AS 'TotalPaymentToday' 
		// ,(SELECT IFNULL(SUM(paymentamount),0) FROM tbl_loans_payments WHERE paymentdate<='{$date}' AND loanid={$loanid}) AS 'TotalPaymentByDate'
		// ,(SELECT MAX(paymentdate) FROM tbl_loans_payments WHERE loanid={$loanid}) AS 'LastPaymentDate'";
		// $result=$this->db->query($sql);	
		//return $result->result_array();
		//$result[0]=array('TotalPaymentYesterday'=>0,'TotalPaymentToday'=>0,'TotalPaymentByDate'=>0,'LastPaymentDate'=>null)
		

	}
	
	
	function getlenderscollection_badaccount_withpayment($branch,$area,$date)
	{
		$this->db->where('c.branchid',$branch);
		if ($area!='ALL')
		{
			$this->db->where('c.areaid',$area);
		}
		
		$this->db->where('paymentdate',$date);
		$this->db->where("duedate < '{$date}' AND balance>0");
		$this->db->distinct();
		$this->db->select("b.paymentdate,IFNULL(SUM(b.paymentamount),0) 'amount'",false);
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_loans_payments b','a.loanid=b.loanid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$result = $this->db->get();
		
		return $result->result_array();
		
		// $sql="	SELECT b.paymentdate,IFNULL(SUM(b.paymentamount),0) 'amount'
				// FROM tbl_loans a
				// INNER JOIN tbl_loans_payments b
				// ON a.loanid=b.loanid AND paymentdate='{$date}'
				// INNER JOIN tbl_branches_areas c
				// on a.branchareaid=c.branchareaid
				// WHERE duedate < '{$date}' AND balance>0 AND c.branchid={$branch} AND c.areaid={$area}";
				
		// $result=$this->db->query($sql);	
		// return $result->result_array();			
	}
	
	function getloanlastpaymentdate($id)
	{
		$this->db->where('loanid',$id);
		$this->db->select("paymentdate");
		$this->db->from('tbl_loans_payments a');
		$this->db->order_by("paymentdate desc");
		$this->db->limit(1);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getrecentloanbycustomeranddate($id = 0, $date = "") 
	{
		$this->db->where('customerid',$id);
		$this->db->where('releaseddate <',$date);
		$this->db->select("*");
		$this->db->from('tbl_loans a');
		$this->db->order_by("releaseddate desc");
		$this->db->limit(1);
		$result = $this->db->get();
		return $result->result_array();

	}
	
	function getrecentloanbycustomeranddate2($id = 0, $date = "") 
	{
		$sql = "SELECT a.*
				FROM 
					tbl_loans a
				
				WHERE 
					a.customerid = '{$id}' AND  
					a.releaseddate <= '{$date}'
				ORDER BY 
					a.releaseddate DESC 
				LIMIT 1";		
		$result=$this->db->query($sql);	
		return $result->result_array();	

	}
	
	function getsecondrecentloanbycustomeranddate2($id = 0, $date = "") 
	{
		$sql = "SELECT 
					a.*
				FROM 
					tbl_loans  a
				WHERE 
					a.customerid = '{$id}' AND  
					a.releaseddate < '{$date}'
				ORDER BY 
					a.releaseddate DESC 
				LIMIT 2 
				OFFSET 1";		
		
		$result=$this->db->query($sql);	
		return $result->result_array();	


	}
	


	
	function getnewloanperdateandbrancharea($area,$date)
	{
		$this->db->where('releaseddate', $date);
		$this->db->where('a.branchareaid', $area);
		$this->db->select('a.dailyduesamount,a.referencenumber,a.principalamount,a.interest,advancepayment,firstname,lastname,suffix');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getnewloanperdateandbrancharea2($branch,$area,$date)
	{
		$this->db->where('releaseddate', $date);
		$this->db->where('c.branchid', $branch);
		$this->db->where('c.areaid', $area);
		$this->db->select('a.loanid,a.dailyduesamount,a.referencenumber,a.principalamount,interest,advancepayment,duedate,firstname,middlename,lastname,suffix');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getnewbadaccounts($branch,$area,$date)
	{
		$this->db->where('duedate', $date);
		$this->db->where('c.branchid', $branch);
		$this->db->where('c.areaid', $area);
		$this->db->select('a.loanid,a.interest,a.referencenumber,a.principalamount,duedate,firstname,middlename,lastname,suffix');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getloanduedateperdaybrancharea($area,$date)
	{
		$this->db->where('a.balance>0');
		$this->db->where('duedate', $date);
		$this->db->where('a.branchareaid', $area);
		$this->db->distinct();
		$this->db->select('a.referencenumber,a.dailyduesamount,firstname,lastname,middlename,suffix');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->order_by("lastname,firstname");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getsummaryreport_loanduedateperdaybrancharea($area,$date)
	{
		$sql = "SELECT DISTINCT `a`.`referencenumber`, `a`.`dailyduesamount`, `firstname`, `lastname`, `middlename`, `suffix`,(a.principalamount+a.interest)-IFNULL(b.paymentamount,0) 'BalanceasOf'
				FROM `tbl_loans` `a` 
				JOIN `tbl_customers` `b` ON `a`.`customerid`=`b`.`customerid` 
				 LEFT JOIN (
					SELECT loanid,SUM(paymentamount) 'paymentamount' 
					FROM tbl_loans_payments 
					WHERE paymentdate='{$date}'
					GROUP BY loanid
				) AS b
			  ON a.loanid=`b`.loanid
		WHERE `duedate` = '{$date}' AND `a`.`branchareaid` = '{$area}' 
		ORDER BY `lastname`, `firstname`";
		$result=$this->db->query($sql);	
		return $result->result_array();			
		
	}
	
	
	function getloanlfullypaidbypaymentbydate($area,$date)
	{
		$sql = "SELECT distinct aa.*,firstname,lastname,middlename,suffix 
		FROM 
		(SELECT distinct b.loanid,b.customerid,b.branchareaid,b.dailyduesamount,b.referencenumber,(b.principalamount+b.interest)-
		(SELECT IFNULL(SUM(paymentamount),0) FROM tbl_loans_payments WHERE loanid=a.loanid AND  paymentdate<='{$date}') 'balance'
		FROM tbl_loans_payments a
		INNER JOIN tbl_loans b
		ON a.loanid=b.loanid
		WHERE b.branchareaid={$area} AND paymentdate='{$date}' and b.duedate >= '{$date}') aa
		INNER JOIN tbl_customers bb
		ON aa.customerid=bb.customerid
		WHERE  aa.balance<=0 and aa.branchareaid={$area}";
		$result=$this->db->query($sql);	
		return $result->result_array();	
	}

	function getloanlfullypaidbypaymentbydate_enhance($area,$date)
	{
		$sql = "SELECT distinct aa.loanid,aa.customerid,aa.branchareaid,aa.dailyduesamount,aa.referencenumber,firstname,lastname,middlename,suffix 
		FROM tbl_loans aa
		INNER JOIN tbl_customers bb
		ON aa.customerid=bb.customerid
		WHERE  aa.balance<=0 and aa.branchareaid={$area} and aa.lastpaymentdate='{$date}' and aa.duedate >= '{$date}'";
		$result=$this->db->query($sql);	
		return $result->result_array();	
	}
	
	function getcollectionlist($brancharea,$status,$sort)
	{

		$this->db->where('a.branchareaid',$brancharea);
		$this->db->where('a.status !=', 'Archived');
		if ($status!='Active')
		{
			$this->db->where('a.duedate <',date("Y-m-d"));
		}
		else
		{
			$this->db->where('a.duedate >=',date("Y-m-d"));
		}
		
		$this->db->where('a.balance >0');
		$this->db->distinct();
		$this->db->select('a.loanid,a.totalamountpaid,a.releaseddate,a.dailyduesamount,a.referencenumber,a.balance,a.duedate,
							a.principalamount,firstname,lastname,middlename,suffix');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		if ($sort==2)
		{
			$this->db->order_by("duedate,lastname,firstname");
		}
		else
		{
			$this->db->order_by("lastname,firstname");
		}
		
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getloancharge($branch,$area,$datefrom,$dateto)
	{

		$this->db->where('c.branchid',$branch);
		
		if ($area!='ALL')
		{
			$this->db->where('c.areaid',$area);
		}
		
		$this->db->where('releaseddate >=', $datefrom);
		$this->db->where('releaseddate <=', $dateto);
		
		$this->db->distinct();
		$this->db->select('a.*,firstname,lastname,middlename,suffix,branchname,areaname');
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_customers b','a.customerid=b.customerid');
		$this->db->join('tbl_branches_areas c','a.branchareaid=c.branchareaid');
		$this->db->join('tbl_branches d','c.branchid=d.branchid');
		$this->db->join('tbl_areas e','c.areaid=e.areaid');
		$this->db->order_by("lastname,firstname,releaseddate");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function gettotalamountbydate($id,$date)
	{
		$this->db->where('paymentdate', $date);
		$this->db->where('loanid', $id);
		
		$this->db->distinct();
		$this->db->select('IFNULL(SUM(paymentamount),0) amount');
		$this->db->from('tbl_loans_payments a');
		$result = $this->db->get();
		return $result->result_array()[0]['amount'];
	}
	
	function getoverallloanpayments($id)
	{
		$this->db->where('loanid',$id);
		$this->db->select("IFNULL(sum(paymentamount),0) as 'amount'",false);
		$this->db->from('tbl_loans_payments');
		$result = $this->db->get();
		return $result->result_array()[0]['amount'];
	}
	
	function gettotalpaymentsasbydate($id,$date)
	{
		$this->db->where('paymentdate <=',$date);
		$this->db->where('loanid',$id);
		$this->db->select("IFNULL(sum(paymentamount),0) as 'amount'",false);
		$this->db->from('tbl_loans_payments');
		$result = $this->db->get();
		return $result->result_array()[0]['amount'];
	}

}
