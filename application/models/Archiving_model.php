<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class archiving_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	
	function index()
	{	
		try{
				$sql = "	update tbl_loans
set `status` ='Archived'
where loanid in(
82424,96182,98420,98422)
						";


			// $sql = "SELECT COUNT(loanid) as cnt FROM temp_loan";
			$result = $this->db->query($sql);
			print_r($result );
			die();
			// $row = $result->row_array();
			// if ($row['cnt'] > 0) {
			// 	$processResult = $this->process();
			// }
			// else{

			// 	$sql = "INSERT INTO temp_loan
			// 	SELECT DISTINCT loanid,0
			// 	FROM tbl_loans a
			// 	WHERE a.balance<=0 AND a.duedate < DATE(NOW()-INTERVAL 1 YEAR)
			// 	AND loanid NOT IN (SELECT DISTINCT loanid FROM tbl_loans_archived)
			// 	AND loanid NOT IN (SELECT DISTINCT loanid FROM tbl_loans_payments WHERE YEAR(paymentdate)>=YEAR(NOW()))";			
			// 	$this->db->query($sql);	

			// 	$processResult =  $this->process();
			// }

			// return $processResult;
		}
		catch(Exception $e){
			return $e->getMessage();
		}
	
	}

	function process(){

		try {
			//$this->benchmark->mark('code_start');


			$sql = "SELECT loanid
					FROM tbl_loans_archived
					WHERE isfinal <> 'x'
					order by 1 desc
					limit 500
					";			
			$result = $this->db->query($sql);	
			
			foreach($result->result_array() as $loan){
				$loanid = $loan['loanid'];
				$this->db->set('status', 'Archived');
				$this->db->where('loanid', $loanid);
				$this->db->update('tbl_loans');

				$this->db->set('isfinal', 'x');
				$this->db->where('loanid', $loanid);
				$this->db->update('tbl_loans_archived');
			}


			// $sql = "SELECT loanid FROM temp_loan where status=0 LIMIT 100";			
			// $result = $this->db->query($sql);	
			
			// foreach($result->result_array() as $loan){
			// 	$loanid = $loan['loanid'];
			// 	$this->db->set('status', 1);
			// 	$this->db->where('loanid', $loanid);
			// 	$this->db->update('temp_loan');
			// }
			

			// foreach($result->result_array() as $loan){

			// 	if (empty($loan['loanid'])){
			// 		continue;
			// 	}

			// 	$sql = "INSERT INTO tbl_loans_payments_archived
			// 		(loanid,ornumber,paymenttype,paymentdate,paymentamount,paymentremarks,entryuserid,entrydate,isfinal)
			// 		SELECT loanid,ornumber,paymenttype,paymentdate,paymentamount,paymentremarks,entryuserid,entrydate,'F'
			// 		FROM tbl_loans_payments
			// 		WHERE loanid = ".$loan['loanid']."
			// 		LIMIT 1";			
			// 	$this->db->query($sql);

			// 	//check if loanid not in tbl_loans_archived
			// 	$sql = "SELECT loanid FROM tbl_loans_archived WHERE loanid=".$loan['loanid']." LIMIT 1";
			// 	$result = $this->db->query($sql);
			// 	if ($result->num_rows() == 0){
			// 		$this->db->insert('tbl_loans_archived', array('loanid' => $loan['loanid']));
			// 	}

			// 	$sql = "DELETE FROM tbl_loans_payments WHERE loanid=".$loan['loanid'];
			// 	$this->db->query($sql);

			// 	$sql = "UPDATE temp_loan SET STATUS=2 WHERE loanid=".$loan['loanid'];            
			// 	$this->db->query($sql);
			// }
			
			$result = $this->status();
			// $this->benchmark->mark('code_end');
			// //get elapsed time
			// $elapsed_time = $this->benchmark->elapsed_time('code_start', 'code_end');
			// //elapsed time in minutes and seconds
			// $elapsed_time = gmdate("H:i:s", $elapsed_time);
			// $result['elapsed_time'] = $elapsed_time;
			return $result;

		}
		catch(Exception $e){
			return $e->getMessage();
		}
	}


	function status(){
		
		// $sql = 'select count(loanid) as count FROM tbl_loans_payments
		// 	where loanid in (
		// 		SELECT loanid
		// 		FROM tbl_loans a
		// 		WHERE a.balance<=0 AND a.duedate< DATE(NOW()-INTERVAL 1 YEAR)
		// 		AND loanid NOT IN (SELECT loanid FROM tbl_loans_archived)
		// 		AND loanid NOT IN (SELECT loanid FROM tbl_loans_payments WHERE YEAR(paymentdate)>=YEAR(NOW()))
		// 	)
		// ';

		// $result = $this->db->query($sql);
		// $outputdata['paymemntcount']  = $result->row_array()['count'];

		// $sql = 'select count(loanid) as count FROM temp_loan';
		// $result = $this->db->query($sql);
		// $outputdata['totalloan']  = $result->row_array()['count'];

		// $sql = 'select count(loanid) as count FROM temp_loan where status=0';
		// $result = $this->db->query($sql);
		// $outputdata['loancount']  = $result->row_array()['count'];

		// $sql = "select count(loanid) as count FROM temp_loan where status=2";
		// $result = $this->db->query($sql);
		// $outputdata['loancountcompleted']  = $result->row_array()['count'];

		$sql = "SELECT count(loanid) as count
		FROM tbl_loans_archived
			where isfinal <>'x'";
		$result = $this->db->query($sql);
		$outputdata['count']  = $result->row_array()['count'];
		return $outputdata;
	}

	function backup(){

		$sql = "CREATE TABLE IF NOT EXISTS bkp_loans_payments_".date('Ymd')."
				(
					loanid int(11) NOT NULL,
					ornumber varchar(50) NOT NULL,
					paymenttype varchar(50) NOT NULL,
					paymentdate date NOT NULL,
					paymentamount decimal(10,2) NOT NULL,
					paymentremarks varchar(500) NOT NULL,
					entryuserid int(11) NOT NULL,
					entrydate datetime NOT NULL,
					isfinal char(1) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				";
		$this->db->query($sql);

		$sql = "INSERT INTO bkp_loans_payments_".date('Ymd')."
				SELECT loanid,ornumber,paymenttype,paymentdate,paymentamount,paymentremarks,entryuserid,entrydate,isfinal
				FROM tbl_loans_payments
				";
		$this->db->query($sql);


	}


	
	
}
