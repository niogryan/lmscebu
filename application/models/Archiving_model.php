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
			$sql = "SELECT COUNT(loanid) as cnt FROM temp_loan";
			$result = $this->db->query($sql);
			$row = $result->row_array();
			if ($row['cnt']>0){
				$processResult =  $this->process();
			}
			else{

				$sql = "INSERT INTO temp_loan
				SELECT DISTINCT loanid
				FROM tbl_loans a
				WHERE a.balance<=0 AND a.duedate< DATE(NOW()-INTERVAL 1 YEAR)
				AND loanid NOT IN (SELECT DISTINCT loanid FROM tbl_loans_archived)
				AND loanid NOT IN (SELECT DISTINCT loanid FROM tbl_loans_payments WHERE YEAR(paymentdate)>=YEAR(NOW()))
				LIMIT 100";			
				$this->db->query($sql);	

				$processResult =  $this->process();
			}

			return $processResult;
		}
		catch(Exception $e){
			return $e->getMessage();
		}
	
	}

	function process(){
		try {

			$sql = "SELECT loanid FROM temp_loan";			
			$result = $this->db->query($sql);	

			foreach($result->result_array() as $loan){

				if (empty($loan['loanid'])){
					continue;
				}

				$sql = "INSERT INTO tbl_loans_payments_archived
							(loanid,ornumber,paymenttype,paymentdate,paymentamount,paymentremarks,entryuserid,entrydate,isfinal)
							SELECT loanid,ornumber,paymenttype,paymentdate,paymentamount,paymentremarks,entryuserid,entrydate,'F'
							FROM tbl_loans_payments
							WHERE  loanid =".$loan['loanid']."
							";			
				$this->db->query($sql);

				//check if loanid not in tbl_loans_archived
				$sql = "SELECT loanid FROM tbl_loans_archived WHERE loanid=".$loan['loanid'];
				$result = $this->db->query($sql);
				$temp = $result->row_array();
				if (empty($temp)){
					$sql = "INSERT INTO tbl_loans_archived
							(loanid)
							values
							(".$loan['loanid'].")
						";			
					$this->db->query($sql);	
				}

				$sql = "DELETE FROM tbl_loans_payments WHERE loanid=".$loan['loanid'];
				$this->db->query($sql);

				$sql = "DELETE FROM temp_loan WHERE loanid=".$loan['loanid'];			
				$this->db->query($sql);			
			}
		
			return "Archiving completed.";
		}
		catch(Exception $e){
			return $e->getMessage();
		}
	}


	function status(){
		
		$sql = 'select count(loanid) as count FROM tbl_loans_payments
			where loanid in (
				SELECT loanid
				FROM tbl_loans a
				WHERE a.balance<=0 AND a.duedate< DATE(NOW()-INTERVAL 1 YEAR)
				AND loanid NOT IN (SELECT loanid FROM tbl_loans_archived)
				AND loanid NOT IN (SELECT loanid FROM tbl_loans_payments WHERE YEAR(paymentdate)>=YEAR(NOW()))
			)
		';

		$result = $this->db->query($sql);
		$outputdata['paymemntcount']  = $result->row_array()['count'];

		$sql = 'select count(loanid) as count FROM tbl_loans
			where loanid in (
				SELECT loanid
				FROM tbl_loans a
				WHERE a.balance<=0 AND a.duedate< DATE(NOW()-INTERVAL 1 YEAR)
				AND loanid NOT IN (SELECT loanid FROM tbl_loans_archived)
				AND loanid NOT IN (SELECT loanid FROM tbl_loans_payments WHERE YEAR(paymentdate)>=YEAR(NOW()))
			)
		';

		$result = $this->db->query($sql);
		$outputdata['loancount']  = $result->row_array()['count'];

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