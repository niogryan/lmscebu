	<?php
		$attributes = array('name' => 'frmindex','id'=>'frmindex');
		echo form_open('loan/index/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Loans</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">List of Customers Loan</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-4 col-lg-4">
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
								<div class="col-sm-12 col-md-4 col-lg-4">
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
								<div class="col-sm-12 col-md-4 col-lg-4">
									<div class="form-group">
										<label>Sort By <code>*</code></label>
										
										<select name="sortby" id="sortby" class="form-control required">
											<option value="1" <?php echo ($selectedsortby==1 ? 'selected' : null); ?>>Last Name, First Name</option>
											<option value="2" <?php echo ($selectedsortby==2 ? 'selected' : null); ?>>Released Date</option>
											<option value="3" <?php echo ($selectedsortby==3 ? 'selected' : null); ?>>Status</option>
										</select>	
									</div>
								</div>
								<div class="col-sm-12  col-md-4 col-lg-2">
									<div class="form-group">
										<label>&nbsp;</label>
										<?php	echo form_submit('btnView', 'View', 'class="btn btn-primary btn-block"');?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-body">		
							
							<table class="table table-bordered table1">
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
											}
										}
									?>
								</tbody>
							</table>
					  </div>
					  <!-- /.card-body -->
					</div>
				</div>
            <!-- /.card -->
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<?php 	
		echo form_close();
	?>