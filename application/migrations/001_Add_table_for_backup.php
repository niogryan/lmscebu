<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_table_for_backup extends CI_Migration {

    public function up() {
        
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
				) ;
				";
		$this->db->query($sql);

		$sql = "CREATE TABLE IF NOT EXISTS temp_loan(
			loanid int(11) NOT NULL,
			status varchar(50) NOT NULL DEFAULT 0);
			";

		$this->db->query($sql);


		$sql = "ALTER TABLE tbl_loans_archived MODIFY COLUMN loanid INT UNIQUE;";
		$this->db->query($sql);


		$sql = "CREATE TABLE IF NOT EXISTS `tbl_loans_archived` (
					`loanid` int(11) DEFAULT NULL,
					`branchid` int(11) NOT NULL,
					`branchareaid` int(11) DEFAULT NULL,
					`customerid` int(11) DEFAULT NULL,
					`oldreferencenumber` varchar(11) DEFAULT NULL,
					`referencenumber` varchar(11) DEFAULT NULL,
					`releaseddate` date DEFAULT NULL,
					`duedate` date DEFAULT NULL,
					`principalamount` decimal(10,2) DEFAULT NULL,
					`interest` decimal(10,2) DEFAULT NULL,
					`servicecharge` decimal(10,2) DEFAULT NULL,
					`dailyduesamount` decimal(10,2) DEFAULT NULL,
					`numholidays` int(11) DEFAULT NULL,
					`specialpayment` decimal(10,2) DEFAULT NULL,
					`passbookcharge` decimal(10,2) DEFAULT NULL,
					`advancepayment` decimal(10,2) DEFAULT NULL,
					`amountreleased` decimal(10,2) DEFAULT NULL,
					`remarks` varchar(2000) DEFAULT NULL,
					`status` varchar(10) DEFAULT NULL,
					`balance` decimal(10,2) DEFAULT NULL,
					`entryuserid` int(11) DEFAULT NULL,
					`entrydate` datetime DEFAULT NULL,
					`isfinal` char(1) DEFAULT 'F'
					);";
		$this->db->query($sql);

		$sql ="CREATE TABLE IF NOT EXISTS `tbl_loans_payments_archived` (
			`loanpaymentid` int(11) NOT NULL AUTO_INCREMENT,
			`loanid` int(11) DEFAULT NULL,
			`ornumber` varchar(20) DEFAULT NULL,
			`paymenttype` varchar(20) DEFAULT NULL,
			`paymentdate` date DEFAULT NULL,
			`paymentamount` decimal(10,2) DEFAULT NULL,
			`paymentremarks` varchar(2000) DEFAULT NULL,
			`entryuserid` int(11) DEFAULT NULL,
			`entrydate` datetime DEFAULT NULL,
			`isfinal` char(1) NOT NULL DEFAULT 'F',
			PRIMARY KEY (`loanpaymentid`)
		  );
		  ";
		$this->db->query($sql);
    }

    public function down() {
       
    }
}
