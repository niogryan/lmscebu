	<?php
		$CI=& get_instance();
		$CI->load->model("loan_model");
		$CI->load->model("tools_model");
	?>
<html lang="en-ph">
	<head>
		<title>Daily Collection Report</title>
		<meta content="text/html; charset=utf-8" http-equiv="content-type" />
		<style>
			 #header { position: fixed; top: -120px; left: 0px; right: 0px; height: 100px; }
			 @page { margin-top: 150px; }
			 body
			 {
				 font-size:12pt;
			 }
			 
			 
			

		</style>
	</head>
	<body>
		<div id="header"  style="width:100%; text-align:center; margin-top:-20px;">
			<p style="font-size:12pt; font-weight:bold;">Lending Management System</p>
			<p style="font-size:12pt; margin-top:-10px;">Daily Collection Report</p>
			<p style="font-size:12pt; margin-top:-10px;"><?php echo $branch[0]['branchname']; ?></p>
			<p style="font-size:12pt; margin-top:-10px;">
				<?php if(strtolower(date("l", strtotime($selecteddate))) == "saturday")
					{
						echo 'Period: '.date("F j, Y", strtotime($selecteddate )).' to '.date("F j, Y", strtotime($selecteddate. "+1 days"));
					}
					else
					{
						echo 'Period: '.date("F j, Y", strtotime($selecteddate));
					} 
				?>
			</p>
		</div>
		<div style="clear:both; margin-left:750px;">Date Genereated: <?php echo date("F d, Y"); ?></div>
		<br />
		<div id="body" style="clear:both;"> 
				<?php
						
						
					$areas=$this->tools_model->getareasbybranch($selectedbranch);
					$list=$CI->report_model->getsummarycollectionsreport2($selectedbranch,$selecteddate);
					
					
					if ($areas)
					{
						$totalcollection=$totalnewreleases=0;
						
						// echo count($areas);
						// print_r($areas);
						// die();
						
						
						for($ctr=0;$ctr<=(count($areas)-1);$ctr++)
						{
							//$list=$CI->report_model->getsummarycollectionsreport2($selectedbranch,$areas[$ctr]['areaid'],$selecteddate);
							$totaldues=$totalnew=$totalduetoday=0;
							// foreach($list as $row)
							// {

								// $totalpaymentsasoftoday=$CI->report_model->gettotalpaymentsasbydate($row['loanid'],$selecteddate);
								
								
								// $last_payment_date = $CI->report_model->getloanlastpaymentdate($row['loanid']); 
								// $loan_balance = ($row['principalamount'] + $row['interest']) - $totalpaymentsasoftoday; 
								
								// $is_advanced_fully_paid = FALSE;
								
								// if(strtotime($selecteddate) > strtotime($row['duedate'])) continue;
				
								// // nag advance fully paid
								// $temp_lastpaymentdate = $temp_selecteddate=null;
								
								// if($loan_balance <= 0 && strtotime($last_payment_date[0]['paymentdate']) < strtotime($row['duedate'])) 
								// {
									// $temp_lastpaymentdate = new DateTime($last_payment_date[0]['paymentdate']);
									// $temp_selecteddate = new DateTime($selecteddate);
									
									// //if(strtotime($last_payment_date[0]['paymentdate']. "+1 days") >= strtotime($selecteddate))
									// if ($temp_lastpaymentdate->diff($temp_selecteddate)->format("%a")>0)
									// {		
										// $is_advanced_fully_paid = true;
									// }
									// else 
									// { 
										// // $recent_customer_loan = get_recent_loan_by_customer_id_and_date($loan->loan_cust_id, $date); 
										// $recent_customer_loan = $CI->report_model->getrecentloanbycustomeranddate($row['customerid'], $selecteddate); 
										
										// if ($recent_customer_loan)
										// {
											// if($recent_customer_loan[0]['referencenumber'] == $row['referencenumber']) 
											// {
												
											// } 
											// else 
											// {
												// continue;  
											// }
										// }
									// }
								// }
								
								// if ($is_advanced_fully_paid==false)
								// {
									// $totaldues += $row['dailyduesamount'];
								// }
							// }
							
							foreach($list as $row)
							{
								if ($row['branchareaid']==$areas[$ctr]['branchareaid'])
								{
									$totalpaymentsasoftoday=$row['totalamountpaid'];
									$last_payment_date = $row['lastpaymentdate']; 
									$loan_balance = ($row['principalamount'] + $row['interest']) - $totalpaymentsasoftoday; 
									
									$is_advanced_fully_paid = FALSE;
									
									if(strtotime($selecteddate) > strtotime($row['duedate'])) continue;
					
									// nag advance fully paid
									$temp_lastpaymentdate = $temp_selecteddate=null;
									
									if ($last_payment_date)
									{
										if($loan_balance <= 0 && strtotime($last_payment_date) < strtotime($row['duedate'])) 
										{
											
											$temp_lastpaymentdate = new DateTime($last_payment_date);
											$temp_selecteddate = new DateTime($selecteddate);

											if ($temp_lastpaymentdate->diff($temp_selecteddate)->format("%a")>0)
											{		
												$is_advanced_fully_paid = true;
											}
										}
									}
									
									if ($is_advanced_fully_paid==false)
									{
										$totaldues += $row['dailyduesamount'];
									}
								}
							}
							
							echo '<table class="table table-bordered">';
							echo '<tr>';
							echo '<td style="width:500px;" valign="top">';
								echo '<br /><span style="font-weight:bold; vertical-align:top"><u>'.trim($areas[$ctr]['areaname']).' - '.number_format($totaldues, 2, '.', ',').'</u></span>
								<br />';
								echo '<br /><span style="margin-left:30px;">Add: Releases</span><br />';
									$newloan=$CI->report_model->getnewloanperdateandbrancharea($areas[$ctr]['branchareaid'],$selecteddate);
									if ($newloan)
									{
										foreach($newloan as $newrow)
										{
											
											echo '
												<span  style="margin-left:60px;">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
												- '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</span><br />
											';
											$totalnew +=$newrow['dailyduesamount'];
											$totalnewreleases += $newrow['principalamount'];
										}
									}
								echo '<span  style="margin-left:60px;">Total: '.number_format($totalnew+$totaldues, 2, '.', ',').'</span><br />';
								
								echo '<br /><span style="margin-left:30px;">Less: Due Date</span><br />';
								$loanduedatetoday_plusone=null;
								
								if(strtolower(date("l", strtotime($selecteddate))) != "sunday")
								{
									$loanduedatetoday=$CI->report_model->getloanduedateperdaybrancharea($areas[$ctr]['branchareaid'],$selecteddate);
									
									if(strtolower(date("l", strtotime($selecteddate))) == "saturday")
									{
										$loanduedatetoday_plusone=$CI->report_model->getloanduedateperdaybrancharea($areas[$ctr]['branchareaid'],date("Y-m-d", strtotime($selecteddate . "+1 days")));	
									}
									
									$output =null;
									foreach($loanduedatetoday as $newrow)
									{
										
										// $recent_loan = $CI->report_model->getrecentloanbycustomeranddate2($newrow['customerid'],$selecteddate);
										// $second_recent_loan =  $CI->report_model->getsecondrecentloanbycustomeranddate2($newrow['customerid'],$selecteddate);
									
										
										// if ($second_recent_loan)
										// {
											// if($second_recent_loan[0]['loanid'] == $newrow['loanid']) 
											// { 
												// if(strtotime($second_recent_loan[0]['duedate']) == strtotime($selecteddate)) 
												// { 
													// if(strtotime($recent_loan[0]['releaseddate']) < strtotime($second_recent_loan[0]['duedate'])) 
													// { 
														// continue;
													// }
												// }
											// }
										// }
										
										
										$output .='
											<span style="margin-left:60px;">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
											- '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</span><br />
										';
										$totalduetoday +=$newrow['dailyduesamount'];
									}
									
									if ($loanduedatetoday_plusone)
									{
										foreach($loanduedatetoday_plusone as $newrow)
										{
											
											$output .='
												<span style="margin-left:60px;">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
												- '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</span><br />
											';
											$totalduetoday +=$newrow['dailyduesamount'];
										}	
									}
								

									$loanfullypaidtoday=$CI->report_model->getloanlfullypaidbypaymentbydate($areas[$ctr]['branchareaid'],$selecteddate);
									if ($loanfullypaidtoday)
									{
										foreach($loanfullypaidtoday as $newrow)
										{
											
											$output .='
												<span style="margin-left:60px;">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
												- '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</span><br />
											';
											$totalduetoday +=$newrow['dailyduesamount'];
										}
										
									}								

											
									if (!empty($output))
									{
										echo $output;	
									}
								}
								
								
								echo '<span style="margin-left:30px; border-bottom:4px double black !important;">Total: '.number_format(($totaldues+$totalnew)-$totalduetoday, 2, '.', ',').'</span><br />';
								echo '</td>';
								
								$totalcollection +=($totaldues+$totalnew)-$totalduetoday ;
								
								if (array_key_exists(($ctr+1), $areas)) 
								{
									$ctr +=1;
									
									//$list=$CI->report_model->getsummarycollectionsreport2($areas[$ctr]['areaid'],$selecteddate);
									$totaldues1=$totalnew1=$totalduetoday1=0;
									// foreach($list as $row)
									// {

										// $totalpaymentsasoftoday=$CI->report_model->gettotalpaymentsasbydate($row['loanid'],$selecteddate);
										
										
										// $last_payment_date = $CI->report_model->getloanlastpaymentdate($row['loanid']); 
										// $loan_balance = ($row['principalamount'] + $row['interest']) - $totalpaymentsasoftoday; 
										
										// $is_advanced_fully_paid = FALSE;
										
										// if(strtotime($selecteddate) > strtotime($row['duedate'])) continue;
						
										// // nag advance fully paid
										// $temp_lastpaymentdate = $temp_selecteddate=null;
											
										// if($loan_balance <= 0 && strtotime($last_payment_date[0]['paymentdate']) < strtotime($row['duedate'])) 
										// {
											// // if ang last payment date + 1 day 
											// $temp_lastpaymentdate = new DateTime($last_payment_date[0]['paymentdate']);
											// $temp_selecteddate = new DateTime($selecteddate);
															
											// //if(strtotime($last_payment_date[0]['paymentdate']. "+1 days") >= strtotime($selecteddate))
											// if ($temp_lastpaymentdate->diff($temp_selecteddate)->format("%a")>0)
											// {		
												// $is_advanced_fully_paid = true;
											// }
											// else 
											// { 
												// // $recent_customer_loan = get_recent_loan_by_customer_id_and_date($loan->loan_cust_id, $date); 
												// $recent_customer_loan = $CI->report_model->getrecentloanbycustomeranddate($row['customerid'], $selecteddate); 
												
												// if ($recent_customer_loan)
												// {
													// if($recent_customer_loan[0]['referencenumber'] == $row['referencenumber']) 
													// {
														
													// } 
													// else 
													// {
														// continue;  
													// }
												// }
											// }
										// }
									
										// if ($is_advanced_fully_paid==false)
										// {
											// $totaldues1 += $row['dailyduesamount'];
										// }
									// }
									
									foreach($list as $row)
									{
										if ($row['branchareaid']==$areas[$ctr]['branchareaid'])
										{
											$totalpaymentsasoftoday=$row['totalamountpaid'];
											$last_payment_date = $row['lastpaymentdate']; 
											$loan_balance = ($row['principalamount'] + $row['interest']) - $totalpaymentsasoftoday; 
											
											$is_advanced_fully_paid = FALSE;
											
											if(strtotime($selecteddate) > strtotime($row['duedate'])) continue;
							
											// nag advance fully paid
											$temp_lastpaymentdate = $temp_selecteddate=null;
											
											if ($last_payment_date)
											{
												if($loan_balance <= 0 && strtotime($last_payment_date) < strtotime($row['duedate'])) 
												{
													
													$temp_lastpaymentdate = new DateTime($last_payment_date);
													$temp_selecteddate = new DateTime($selecteddate);

													if ($temp_lastpaymentdate->diff($temp_selecteddate)->format("%a")>0)
													{		
														$is_advanced_fully_paid = true;
													}
												}
											}
											
											if ($is_advanced_fully_paid==false)
											{
												$totaldues1 += $row['dailyduesamount'];
											}
										}
									}
									
									
									echo '<td  style="width:500px;"  valign="top">';
									echo '<br /><span  style="font-weight:bold; vertical-align:top;"><u>'.$areas[$ctr]['areaname'].' - '.number_format($totaldues1, 2, '.', ',').'</u></span>
									<br />';
									echo '<br /><span style="margin-left:30px;">Add: Releases</span><br />';
										$newloan=$CI->report_model->getnewloanperdateandbrancharea($areas[$ctr]['branchareaid'],$selecteddate);
										if ($newloan)
										{
											foreach($newloan as $newrow)
											{
												
												echo '
													<span  style="margin-left:60px;">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
													- '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</span><br />
												';
												$totalnew1 +=$newrow['dailyduesamount'];
												$totalnewreleases += $newrow['principalamount'];
											}
										}
									echo '<span  style="margin-left:60px;">Total: '.number_format($totalnew1+$totaldues1, 2, '.', ',').'</span><br />';
									
									echo '<br /><span style="margin-left:30px;">Less: Due Date</span><br />';
									$loanduedatetoday_plusone=null;
									$loanduedatetoday=$CI->report_model->getloanduedateperdaybrancharea($areas[$ctr]['branchareaid'],$selecteddate);
									
									if(strtolower(date("l", strtotime($selecteddate))) != "sunday")
									{
										if(strtolower(date("l", strtotime($selecteddate))) == "saturday")
										{
											$loanduedatetoday_plusone=$CI->report_model->getloanduedateperdaybrancharea($areas[$ctr]['branchareaid'],date("Y-m-d", strtotime($selecteddate . "+1 days")));	
										}
										
										$output =null;
										foreach($loanduedatetoday as $newrow)
										{
											
											// $recent_loan = $CI->report_model->getrecentloanbycustomeranddate2($newrow['customerid'],$selecteddate);
											// $second_recent_loan =  $CI->report_model->getsecondrecentloanbycustomeranddate2($newrow['customerid'],$selecteddate);
										
											
											// if ($second_recent_loan)
											// {
												// if($second_recent_loan[0]['loanid'] == $newrow['loanid']) 
												// { 
													// if(strtotime($second_recent_loan[0]['duedate']) == strtotime($selecteddate)) 
													// { 
														// if(strtotime($recent_loan[0]['releaseddate']) < strtotime($second_recent_loan[0]['duedate'])) 
														// { 
															// continue;
														// }
													// }
												// }
											// }
											
											
											$output .='
												<span style="margin-left:60px;">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
												- '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</span><br />
											';
											$totalduetoday1 +=$newrow['dailyduesamount'];
										}
										
										if ($loanduedatetoday_plusone)
										{
											foreach($loanduedatetoday_plusone as $newrow)
											{
												
												$output .='
													<span style="margin-left:60px;">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
													- '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</span><br />
												';
												$totalduetoday1 +=$newrow['dailyduesamount'];
											}	
										}

										$loanfullypaidtoday=$CI->report_model->getloanlfullypaidbypaymentbydate($areas[$ctr]['branchareaid'],$selecteddate);
										if ($loanfullypaidtoday)
										{
											foreach($loanfullypaidtoday as $newrow)
											{
												
												
												$output .='
													<span style="margin-left:60px;">'.$newrow['lastname'].', '.$newrow['firstname'].' - '.$newrow['referencenumber'].'
													- '.number_format($newrow['dailyduesamount'], 2, '.', ',').'</span><br />
												';
												$totalduetoday1 +=$newrow['dailyduesamount'];
											}
											
										}
																		
										
												
										if (!empty($output))
										{
											echo $output;	
										}
									}
									
									echo '<span style="margin-left:30px; border-bottom:4px double black !important;">Total: '.number_format(($totaldues1+$totalnew1)-$totalduetoday1, 2, '.', ',').'</span><br />';
									echo '</td>';
									
									$totalcollection +=($totaldues1+$totalnew1)-$totalduetoday1 ;
								}
							echo '</tr>';	
							echo '</table>';

								  							
						}
					}
				?>
					<h2>DAILY COLLECTION: Php <?php echo number_format($totalcollection, 2, '.', ','); ?> 
						<br />TOTAL RELEASES: Php <?php echo number_format($totalnewreleases, 2, '.', ','); ?> 
					</h2>
			</div>
		</div>
	</body>
</html>