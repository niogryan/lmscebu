<?php
	$attributes = array('name' => 'loaninquiry','id'=>'loaninquiry');
	echo form_open('loan/inquiry/',$attributes);
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
											<option value="1" <?php echo ($selectedsearchtype==1 ? 'selected' : null);?>>Search by Released Dates</option>
										</select>	
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3 ">
									<div class="form-group">
										<label>Branch <code>*</code></label>
										<select name="branch" id="branch" class="form-control required">
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
								<div class="col col-sm-6 col-md-3 col-lg-3">
									<div class="form-group">	
										<label for="date">Date<code>Required</code></label>
										<input type="text" name="date" class="form-control datefield" placeholder="Date" value="<?php echo $selecteddate; ?>" autocomplete="off"/>
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
										<th style="text-align:center;">Reference Number</th>
										<th style="text-align:center;">Name</th>
										<th style="text-align:center;">Date</th>
										<th style="text-align:center;">Loan Amount</th>
										<th style="text-align:center;">Branch</th>
										<th style="text-align:center;">Area</th>
										<th style="text-align:center;">Status</th>
										<th style="text-align:center;">Balance</th>
										<th style="text-align:center;"></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$totalloan=0;
										if ($loans)
										{
											
											foreach($loans as $row)
											{
												echo '<tr class="'.($row['status']=='Overdue' ? 'bg-overdue' : ($row['status']=='Paid' ? 'bg-paid' : ($row['status']=='Default' ? 'bg-default' : null))).'">';
												echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
												echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).'</td>';
												echo '<td style="text-align:center;">'.($row['releaseddate']!='0000-00-00' ? date("F j, Y", strtotime($row['releaseddate'])) : '&nbsp;').'</td>';
												echo '<td style="text-align:right;">Php '.number_format(($row['principalamount']+$row['interest']), 2, '.', ',').'</td>';
												echo '<td style="text-align:center;">'.$this->mylibraries->returnreplacespecialcharacter($row['branchname']).'</td>';
												echo '<td style="text-align:center;">'.$this->mylibraries->returnreplacespecialcharacter($row['areacity'].' '.$row['areaname']).'</td>';
												echo '<td style="text-align:center;">'.$row['status'].'</td>';
												echo '<td style="text-align:right;">Php '.number_format($row['balance'], 2, '.', ',').'</td>';
												echo '<td style="text-align:center">';
												echo anchor('loan/details/'.$row['loanid'].'/'.$this->mylibraries->encrypt('v'.$row['loanid']),'View','class="btn btn-primary btn-sm"');
												echo '</td>';
												echo '</tr>';
												$totalloan += $row['principalamount']+$row['interest'];
											}								
										}
									?>
								</tbody>
							</table>
							<h1>Total Amount Loan Released (Principal + Interest): <?php echo number_format($totalloan); ?></h1>
						</div>
					</div>
				</div>
			</div>
					
		
		</div>
	 </section>	
	 
