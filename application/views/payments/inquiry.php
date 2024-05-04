<?php
	$attributes = array('name' => 'rptsummary','id'=>'rptsummary');
	echo form_open('payment/inquiry/',$attributes);
?>
	
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Inquiries</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title">
								Search Configuration
							</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">
										<label>Type <code>*</code></label>
										<select name="searchtype" class="form-control required">
											<option value="">Select an Option</option>
											<option value="1" <?php echo ($selectedsearchtype==1 ? 'selected' : null);?>>Search by Customer</option>
											<option value="2" <?php echo ($selectedsearchtype==2 ? 'selected' : null);?>>Search by Dates</option>
											<option value="3" <?php echo ($selectedsearchtype==3 ? 'selected' : null);?>>Search by Area & Dates</option>
										</select>	
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3 branchselection1">
									<div class="form-group">
										<label>Branch <code>*</code></label>
										<select name="paymentinquiry1branch" id="paymentinquiry1branch" class="form-control required">
											<option value="">Select an Option</option>
											<?php
												foreach($branches as $row)
												{
													echo '<option value="'.$row['branchid'].'" '.($selectedbranch1==$row['branchid'] ? 'selected' : null).'>'.$row['branchname'].'</option>';
												}
											?>
										</select>	
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3 branchselection2">
									<div class="form-group">
										<label>Branch <code>*</code></label>
										<select name="paymentinquiry2branch" id="paymentinquiry2branch" class="form-control required">
											<option value="">Select an Option</option>
											<?php
												foreach($branches as $row)
												{
													echo '<option value="'.$row['branchid'].'" '.($selectedbranch2==$row['branchid'] ? 'selected' : null).'>'.$row['branchname'].'</option>';
												}
											?>
										</select>	
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3 searchcustomer">
									<div class="form-group">
										<label>Customer <code>*</code></label>
										<select name="customer" id="customer" class="form-control required select2"  style="width:100%;">
											<option value="">Select an Option</option>
											<?php
												foreach($customers as $row)
												{
													echo '<option value="'.$row['customerid'].'" '.($selectedcustomer==$row['customerid'] ? 'selected' : null).'>'.$row['refnumber'].' - '.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).' '.$row['areaname'].'</option>';
												}
											?>
										</select>	
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-sm-12 col-md-3 col-lg-3 branchareaselection">
									<div class="form-group">
										<label>Branch <code>*</code></label>
										<select name="branch" id="branchajxselection" class="form-control required">
											<option value="">Select an Option</option>
											<?php
												foreach($branches as $row)
												{
													echo '<option value="'.$row['branchid'].'" '.($selectedbranch==$row['branchid'] ? 'selected' : null).'>'.$row['branchname'].'</option>';
												}
											?>
										</select>	
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3 branchareaselection">
									<div class="form-group">
										<label>Area <code>*</code></label>
										
										<select name="area" id="areaajxselection" class="form-control required">
											<option value="">Select an Option</option>
											
											<?php
												if ($areas)
												{
													foreach($areas as $row)
													{
														echo '<option value="'.$row['branchareaid'].'" '.($selectedarea==$row['branchareaid'] ? 'selected' : null).'>'.$row['areaname'].'</option>';
													}
												}
											?>
										</select>	
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3 daterange">
									<div class="form-group">	
										<label for="datefrom">Date From <code>Required</code></label>
										<input type="text" name="datefrom" class="form-control datefield" placeholder="Date From" value="<?php echo $selectedfrom; ?>" autocomplete="off"/>
									</div>
								</div>
								<div class="col col-sm-6 col-md-3 col-lg-3 daterange">
									<div class="form-group">	
										<label for="dateto">Date To <code>Required</code></label>
										<input type="text" name="dateto" class="form-control datefield" placeholder="Date To" value="<?php echo $selectedto; ?>" autocomplete="off"/>
									</div>
								</div>
							</div>

								

						</div>
						<div class="card-footer">
							<div class="col-sm-12 col-md-3 col-lg-3">
									<?php echo form_submit('btnView','View','class="btn btn-primary btn-block"'); ?>	
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="card card-primary card-outline">
						<div class="card-body">
							<table class="table table-bordered table2">
								
								<thead>
									<tr>
										<th style="text-align:center;">#</th>
										<th style="text-align:center;">Date</th>
										<?php
											if ($selectedsearchtype==2)
											{
												echo '<th style="text-align:center;">Customer</th>';
												echo '<th style="text-align:center;">Area</th>';
											}
											else if ($selectedsearchtype==3)
											{
												echo '<th style="text-align:center;">Customer</th>';
											}
										?>
										
										
										<th style="text-align:center;">Loan Number</th>
										<th style="text-align:center;">Loan Amount</th>
										<th style="text-align:center;">Loan Interest</th>
										<th style="text-align:center;">Payment No</th>
										<th style="text-align:center;">Type</th>
										<th style="text-align:center;">Amount Paid</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$totalpayments=$regular=$advance=$special=0;
										if($searchlist)
										{
											
											$ctr=1;
											foreach($searchlist as $row)
											{
												echo '<tr>';
												echo '<td style="text-align:center;">'.$ctr.'</td>';
												echo '<td  style="text-align:center;">'.($row['paymentdate']!='0000-00-00' ? date("F j, Y", strtotime($row['paymentdate'])) : '&nbsp;').'</td>';
												if ($selectedsearchtype==2)
												{
													echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).'</td>';
													echo '<td>'.$row['areaname'].'</td>';
												}
												else if ($selectedsearchtype==3)
												{
													echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).'</td>';
												}
														
												echo '<td  style="text-align:center;">'.$row['referencenumber'].'</td>';
												echo '<td style="text-align:right;">'.number_format($row['principalamount']).'</td>';
												echo '<td style="text-align:right;">'.number_format($row['interest']).'</td>';
												echo '<td style="text-align:center;">'.$row['ornumber'].'</td>';
												echo '<td style="text-align:center;">'.$row['paymenttype'].'</td>';
												echo '<td style="text-align:right;">'.number_format($row['paymentamount']).'</td>';
												echo '</tr>';
												$ctr++;
												if ($row['paymenttype']=='Advance')
												{
													$advance +=$row['paymentamount'];
												}
												else if ($row['paymenttype']=='Special')
												{
													$special +=$row['paymentamount'];
												}
												else
												{
													$regular +=$row['paymentamount'];
												}
												
												$totalpayments +=$row['paymentamount'];
											}
										}
									
									?>
								</tbody>
							</table>
							
							<h1>Total Payments: <?php echo number_format($totalpayments); ?></h1>
							<?php
								if($selectedsearchtype==3)
								{
							?>
									<h2>Total Regular Payments: <?php echo number_format($regular); ?></h2>
									<h2>Total Advance Payments: <?php echo number_format($advance); ?></h2>
									<h2>Total Special Payments: <?php echo number_format($special); ?></h2>
							<?php			
								}
							?>
						</div>
					</div>
				</div>
			</div>
					
		
		</div>
	 </section>	
	 
