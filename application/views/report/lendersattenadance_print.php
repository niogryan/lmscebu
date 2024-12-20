	<?php
		$CI=& get_instance();
		$CI->load->model("report_model");
	?>
<html lang="en-ph">
	<head>
		<title><?php echo $date; ?> LENDER'S ATTENDANCE REPORT</title>
		<meta content="text/html; charset=utf-8" http-equiv="content-type" />
		<style>
			 #header { position: fixed; top: -100px; left: 0px; right: 0px; height: 100px; }
			 @page { margin-top: 100px; }
			.table {
				width: 1280px;
				margin-bottom: 1rem;
				font-family: arial, sans-serif;
			}
			
			thead {
				display: table-header-group;
				vertical-align: middle;
				font-size:9pt;
			}
						
			tbody {
				display: table-row-group;
				vertical-align: middle;
				font-size:10pt;
			}
			
			.table-bordered 
			{
				border: 1px solid #637383;
			}
			
			.table-striped tbody tr:nth-of-type(odd) 
			{
				background-color: rgba(0,0,0,.05);
			}
			
			.table1, .table1 td, .table1 th 
			{
				border-collapse: collapse;
				border: 1px solid  #637383;
			}
			
				.table1, .table1 td, .table1 th 
			{
				padding-left:2px;
				padding-right:2px;
			}
		</style>
	</head>
	<body>
		<div id="header" style="width:100%; text-align:center;">
			<p style="font-size:12pt; font-weight:bold;">Lending Management System</p>
			<p style="font-size:12pt; margin-top:-15px;">LENDER'S ATTENDANCE REPORT</p>
			<p style="font-size:12pt; margin-top:-15px; "><?php echo $branch[0]['branchname'].' '.$area; ?></p>
			<p style="font-size:12pt; margin-top:-15px;"><?php echo $date.' '.($param4=='BadWithPayment' ? 'Bad Accounts with Payment' : ($param4=='Paid' ? 'Fully Paid' : 'Active Accounts')); ?> </p>
		</div>
		
		<div id="body" style="clear:both;"> 
					<table class="table table-bordered table-striped table1" id="">
								<tbody>
									<?php
										$totaldues=$totalbuhopayments=$total_new_advance_payments=$total_bad_accounts_payments=$total_daily_absent=$total_balanceadvancededuction=0;
										$totalprincipal=$totalinterest=$total_buho_payments=$total_dailyabsentbalance_asofyesterday=$total_advancepayment_asofyesterday=0;
										
										if ($list)
										{
											// echo '<pre>';
											// print_r($list);
											// die();
											
											$ctr=1;
										
											foreach($list as $row)
											{
												$dailyabsent=$buhobalance=$dailyabsentbalance_asofyesterday=$advancepayment_asofyesterday=$remainingadvancepayment=0;
												//yesterday
												$date_yesterday = date("Y-m-d", strtotime($selecteddate . "-1 days")); 
												//$paymentyesterday=$CI->report_model->gettotalpaymentsasbydate($row['loanid'],$date_yesterday);
												//$overallpaymentsasofyesterday=$CI->report_model->gettotalpaymentsasbydate($row['loanid'],$date_yesterday);
												$overallpaymentsasofyesterday=$row['TotalPaymentYesterday'];
												
												$no_of_days_to_be_paid=$this->mylibraries->no_of_days_to_be_paid($row['releaseddate'],$date_yesterday);
												$total_ideal_payments_asofyesterday = $no_of_days_to_be_paid * $row['dailyduesamount'];
												$dailyabsentbalance_asofyesterday=$total_ideal_payments_asofyesterday-$overallpaymentsasofyesterday;
												$remainingadvancepayment=$overallpaymentsasofyesterday-$total_ideal_payments_asofyesterday;
												
												if($remainingadvancepayment<0)
												{
													$remainingadvancepayment=0;
												}
												
												if ($dailyabsentbalance_asofyesterday < 0)
												{
													$dailyabsentbalance_asofyesterday=0;
												}
												
												if ($overallpaymentsasofyesterday>$total_ideal_payments_asofyesterday)
												{
													$advancepayment_asofyesterday=$overallpaymentsasofyesterday-$total_ideal_payments_asofyesterday;
												}
												
												
												//today
												$no_of_days_to_be_paid=$this->mylibraries->no_of_days_to_be_paid($row['releaseddate'],$selecteddate);
												$total_ideal_payments_asoftoday = $no_of_days_to_be_paid * $row['dailyduesamount'];

												$paymenttoday=$newadvancepayment=$balanceadvancededuction=$buho_payments=0;
												//$paymenttoday=$CI->report_model->gettotalamountbydate($row['loanid'],$selecteddate);
												//$totalpaymentsasoftoday=$CI->report_model->gettotalpaymentsasbydate($row['loanid'],$selecteddate);
												
												$paymenttoday=$row['TotalPaymentToday'];
												$totalpaymentsasoftoday=$row['TotalPaymentByDate'];
												
												//$last_payment_date = $CI->report_model->getloanlastpaymentdate($row['loanid']); 
												//$last_payment_date =$last_payment_date[0]['paymentdate'];
												$last_payment_date =$row['LastPaymentDate'];
												
												$loan_balance = ($row['principalamount'] + $row['interest']) - $totalpaymentsasoftoday; 
												
												if(strtotime($selecteddate) > strtotime($row['duedate']))
												{
													continue;
												}
												
												$is_advanced_fully_paid = FALSE;
												// nag advance fully paid
												$temp_lastpaymentdate = $temp_selecteddate=null;
												
												if($loan_balance <= 0 && strtotime($last_payment_date) < strtotime($row['duedate'])) 
												{
													// if ang last payment date + 1 day 
													$temp_lastpaymentdate = new DateTime($last_payment_date);
													$temp_selecteddate = new DateTime($selecteddate);
													
													//if(strtotime($last_payment_date[0]['paymentdate']. "+1 days") >= strtotime($selecteddate))
													if ($temp_lastpaymentdate->diff($temp_selecteddate)->format("%a")>0)
													{	
														$is_advanced_fully_paid = true;
													}
													else 
													{ 
														// $recent_customer_loan = get_recent_loan_by_customer_id_and_date($loan->loan_cust_id, $date); 
														$recent_customer_loan = $CI->report_model->getrecentloanbycustomeranddate($row['customerid'], $selecteddate); 
														if ($recent_customer_loan)
														{
															if($recent_customer_loan[0]['referencenumber'] == $row['referencenumber']) 
															{
																
															} 
															else 
															{
																continue;  
															}
														}
														
													}
												}
												
												$loan_balance_yesterday = ($row['principalamount'] + $row['interest']) - $overallpaymentsasofyesterday; 
												
												if(strtotime($selecteddate) > strtotime($row['duedate']) && $loan_balance_yesterday > 0) 
												{ 
													echo $loan_balance_yesterday;
													
													//$total_bad_accounts_payments += $paymenttoday; 
												} 
															
											
												if ($paymenttoday==0)
												{
													$dailyabsent=$row['dailyduesamount'];
												}
												else if ($paymenttoday<$row['dailyduesamount'])
												{
													$dailyabsent=$row['dailyduesamount']-$paymenttoday;
												}
												
												
												if ($paymenttoday>$row['dailyduesamount'])
												{
													$newadvancepayment=$paymenttoday-$row['dailyduesamount'];
												}
			
												
												if ($dailyabsent>0 && $remainingadvancepayment>0)
												{
													if($dailyabsent >= $remainingadvancepayment) 
													{ 
														$balanceadvancededuction = $remainingadvancepayment; 
														$dailyabsent = $dailyabsent - $remainingadvancepayment;
														$remainingadvancepayment = 0; 
													} 
													else 
													{
														$balanceadvancededuction = $dailyabsent; 
														$remainingadvancepayment = $remainingadvancepayment - $dailyabsent; 
														$dailyabsent = 0;
													}
												}
												
												
												
												if($dailyabsentbalance_asofyesterday > 0 && $newadvancepayment > 0) 
												{ 
													if($dailyabsentbalance_asofyesterday >= $newadvancepayment) 
													{ 
														$buho_payments = $newadvancepayment; 
														$dailyabsentbalance_asofyesterday = $dailyabsentbalance_asofyesterday - $newadvancepayment;
														$newadvancepayment = 0; 
													} 
													else 
													{
														$buho_payments = $dailyabsentbalance_asofyesterday; 
														$newadvancepayment = $newadvancepayment - $dailyabsentbalance_asofyesterday; 
														$dailyabsentbalance_asofyesterday = 0;
													}
												} 
												
												$totalbuhopayments +=$buho_payments;
												
												if($buho_payments > 0) $dailyabsentbalance_asofyesterday += $buho_payments;					
												

												if ($is_advanced_fully_paid==false)
												{
													$totaldues +=$row['dailyduesamount'];
													$total_new_advance_payments += $newadvancepayment;
													$total_buho_payments += $buho_payments;
													$total_daily_absent += $dailyabsent; 
													$total_advancepayment_asofyesterday +=$advancepayment_asofyesterday;
													$total_balanceadvancededuction +=$balanceadvancededuction;
													$total_dailyabsentbalance_asofyesterday +=$dailyabsentbalance_asofyesterday;
													$ctr++;
													
													$totalprincipal +=$row['principalamount'];
													$totalinterest +=$row['interest'];
												}
												
												// $totalservicecharge +=$row['servicecharge'];
											}
									
											
										}
										
										if (!empty($badaccountwithpayments))
										{
											if ($param4=='BadWithPayment')
											{
												echo '
												<tr>
													<th style="text-align:center;" valign="middle">#</th>
														<th style="text-align:center; width:200px;" valign="middle">Customer Name</th>
														<th style="text-align:center; width:80px;">Loan No.</th>';
												 
														if ($this->session->userdata('role')=='Administrator')
														{
												
																echo '<th style="text-align:center;">Principal Amount</th>
															<th style="text-align:center;">Interest</th>';
												 
														}
												echo '
													<th style="text-align:center;">Loan Balance</th>
													<th style="text-align:center;">Daily Payment</th>
													<th style="text-align:center;">B/A <br />Balance</th>

													<th style="text-align:center;">Balance <br />Advance <br />Payment</th>
													<th style="text-align:center;">Balance <br />Advance <br />Deduction</th>
													<th style="text-align:center;">New <br />Advance <br />Payment</th>
													<th style="text-align:center;">Special  <br />Payment</th>
													<th style="text-align:center; width:80px;">Due Date</th>
												</tr>';
											}
											
											
											$ctr=1;
											
											$balance=$totaldues_bad=$totalprincipal_bad=$totalinterest_bad=$total_daily_absent_bad=$totalactual_bad=0;
											
											
											
											foreach($badaccountwithpayments as $row)
											{
												if ($param4=='BadWithPayment')
												{
													echo '<tr>';
													echo '<td style="text-align:center;">'.$ctr.'</td>';
													echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname'].' '.$row['middlename']).'</td>';
													echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
												
													if ($this->session->userdata('role')=='Administrator')
													{
									
														echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($row['principalamount']).'</td>';
														echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($row['interest']).'</td>';
													}
													
													$balance=($row['principalamount']+$row['interest'])-$row['PaymentAsOf'];
													echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($balance).'</td>';
													echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($row['paymentamount']).'</td>';
													echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($balance-$row['paymentamount']).'</td>';
													echo '<td style="text-align:right;"></td>';
													
													echo '<td style="text-align:right;"></td>';
													echo '<td style="text-align:right;"></td>';
													echo '<td style="text-align:right;"></td>';
													echo '<td style="text-align:center;">'.($row['duedate']!='0000-00-00' ? date("Y-m-d", strtotime($row['duedate'])) : '&nbsp;').'</td>';
													echo '</tr>';
												}
												
												$totaldues_bad +=$row['dailyduesamount'];
												
												$ctr++;
												
												$totalprincipal_bad +=$row['principalamount'];
												$totalinterest_bad +=$row['interest'];
												$total_daily_absent_bad +=$balance;
												$totalactual_bad +=$row['paymentamount'];
											}
											
												if ($param4=='BadWithPayment')
												{
													
													
													
													
													
													echo '<tr>';
													echo '<th style="text-align:left;" colspan="3">Total</th>';
												
													if ($this->session->userdata('role')=='Administrator')
													{
														echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($totalprincipal_bad).'</th>';
														echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($totalinterest_bad).'</th>';
													}
													
													echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($total_daily_absent_bad).'</th>';
													echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($totalactual_bad).'</th>';
													echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($total_daily_absent_bad-$totalactual_bad).'</th>';
													echo '<th style="text-align:right;"></th>';
													echo '<th style="text-align:right;"></th>';
													echo '<th style="text-align:right;"></th>';
													echo '<th style="text-align:right;"></th>';
													echo '<th style="text-align:right;"></th>';
													echo '</tr>';
												}
											
											
										}
										
										if (!empty($listpaid) && $param4=='Paid')
										{
											$ctr=1;
											
											$totaldues_bad=$totalprincipal_bad=$totalinterest_bad=$total_daily_absent_bad=0;
											
												echo '<tr>
														<th style="text-align:center;" valign="middle">#</th>
														<th style="text-align:center; width:200px;" valign="middle">Customer Name</th>
														<th style="text-align:center; width:80px;">Loan No.</th>
														';
															if ($this->session->userdata('role')=='Administrator')
															{
																	echo '<th style="text-align:center;">Principal Amount</th>
																	<th style="text-align:center;">Interest</th>';
															}
															
															
													echo '	
														<th style="text-align:center;">Accts Payment</th>
														<th style="text-align:center;">Daily Absent</th>
														<th style="text-align:center;">Buho Payment</th>
														<th style="text-align:center;">Total Daily <br />Absent <br />Balance</th>
														<th style="text-align:center;">Balance <br />Advance <br />Payment</th>
														<th style="text-align:center;">Balance <br />Advance <br />Deduction</th>
														<th style="text-align:center;">New <br />Advance <br />Payment</th>
														<th style="text-align:center;">Special  <br />Payment <br />Deduction</th>
														<th style="text-align:center;">Special  <br />Payment <br />Advance</th>
														<th style="text-align:center; width:80px;">Due Date</th>
													</tr>';
											
											
											
											foreach($listpaid as $row)
											{
												echo '<tr>';
												echo '<td style="text-align:center;">'.$ctr.'</td>';
												echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname'].' '.$row['middlename']).'</td>';
												echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
											
												if ($this->session->userdata('role')=='Administrator')
												{
								
													echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($row['principalamount']).'</td>';
													echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($row['interest']).'</td>';
												}
												
												echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($row['dailyduesamount']).'</td>';
												echo '<td style="text-align:right;"></td>';
												echo '<td style="text-align:right;"></td>';
												echo '<td style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($row['balance']).'</td>';
												echo '<td style="text-align:right;"></td>';
												echo '<td style="text-align:right;"></td>';
												
												echo '<td style="text-align:right;"></td>';
												echo '<td style="text-align:right;"></td>';
												echo '<td style="text-align:right;"></td>';
												echo '<td style="text-align:center;">'.($row['duedate']!='0000-00-00' ? date("Y-m-d", strtotime($row['duedate'])) : '&nbsp;').'</td>';
												echo '</tr>';
												
												$totaldues_bad +=$row['dailyduesamount'];
												
												$ctr++;
												
												$totalprincipal_bad +=$row['principalamount'];
												$totalinterest_bad +=$row['interest'];
												$total_daily_absent_bad +=$row['balance'];
												//$totalactual_bad +=$row['paymentamount'];
											}
											
											echo '<tr>';
											echo '<th style="text-align:left;" colspan="3">Total</th>';
										
											if ($this->session->userdata('role')=='Administrator')
											{
												echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($totalprincipal_bad).'</th>';
												echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($totalinterest_bad).'</th>';
											}
											
											echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($totaldues_bad).'</th>';
											echo '<th style="text-align:right;"></th>';
											echo '<th style="text-align:right;"></th>';
											echo '<th style="text-align:right;">'.$this->mylibraries->replaceszerotoblank($total_daily_absent_bad).'</th>';
											echo '<th style="text-align:right;"></th>';
											echo '<th style="text-align:right;"></th>';
											echo '<th style="text-align:right;"></th>';
											echo '<th style="text-align:right;"></th>';
											echo '<th style="text-align:right;"></th>';
											echo '<th style="text-align:right;"></th>';
											echo '</tr>';
											
											
										}
									?>
								</tbody>
							</table>
					
					
					<?php 
						$badpayment = $CI->report_model->getlenderscollection_badaccount_withpayment($param1,$param2,$param3,$param4);
						$totalnewloanadvancepayment=0;
					?>
				<div style="page-break-after: always;"></div>
						<h3>Summary</h3>
						<table class="table table-bordered" style="font-size:12pt !important;  border:1px solid white !important; width:600px;">
							<tr>
								<td colspan="3">Summary of Daily Collection</td>
								<td style="text-align:right; padding-right:50px;">=</th>
								<td style="text-align:center; width:100px;"> <?php echo number_format($totaldues);?></td>
							</tr>
							<tr>
								<td style="text-align:center">Add</td>
								<td colspan="4"></td>
							</tr>
							<tr>
								<td></td>
								<td style="width:200px;">Buho Payment</td>
								<td style="text-align:center">:</td>
								<td style="text-align:right; width:100px; padding-right:50px;"> <?php echo number_format($totalbuhopayments);?> </td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>New Advance Payment</td>
								<td style="text-align:center">:</td>
								<td style="text-align:right; width:100px; padding-right:50px;"> <?php echo number_format($total_new_advance_payments);?></td>
								<td></td>
							</tr>

							<tr>
								<td></td>
								<td>Bad Accounts Payment</td>
								<td style="text-align:center">:</td>
								<td style="text-align:right; width:100px; padding-right:50px;"> <?php echo number_format($totalactual_bad);?></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td>Special  Payment</td>
								<td style="text-align:center">:</td>
								<td style="text-align:right; width:100px; padding-right:50px;"> <?php echo number_format(0);?></td>
								<td style="text-align:center; border-bottom:2px solid black !important;"> <?php echo number_format($totalbuhopayments+$total_new_advance_payments+$totalactual_bad+$totalnewloanadvancepayment);?></td>
							</tr>
							<tr>
								<td></td>
								<th></th>
								<td style="text-align:center; width:200px;">Sub-Total</td>
								<th></th>
								<td style="text-align:center"> <?php echo number_format($totaldues+$totalbuhopayments+$total_new_advance_payments+$totalactual_bad+$totalnewloanadvancepayment);?></td>
							</tr>
							<tr>
								<td style="text-align:center">Less</td>
								<td colspan="4"></td>
							</tr>
							<tr>
								<td></td>
								<td>Daily Absent</td>
								<td style="text-align:center">:</td>
								<td style="text-align:right; width:100px; padding-right:50px;"> <?php echo number_format($total_daily_absent);?></td>
								<td></td>
								
								
								
							</tr>
							<tr>
								<td></td>
								<td>Balance Advance Payment</td>
								<td style="text-align:center">:</td>
								<td style="text-align:right; width:100px; padding-right:50px;"> <?php echo number_format($total_balanceadvancededuction);?></td>
								<td style="text-align:center; border-bottom:2px solid black !important;"><?php echo number_format($total_daily_absent+$total_balanceadvancededuction);?></td>
							</tr>
							<tr>
								<td></td>
								<th></th>
								<td style="text-align:center; width:200px; vertical-align: bottom !important;">Total Collection</td>
								<th></th>
								<td style="text-align:center; border-bottom:4px double black !important; height:50px; vertical-align: bottom !important;"> 
									<?php echo number_format(($totaldues+$totalbuhopayments+$total_new_advance_payments+$totalactual_bad+$totalnewloanadvancepayment)-($total_balanceadvancededuction+$total_daily_absent));?>
								</td>
							</tr>
						</table>
						
					
		</div>
	</body>
</html>