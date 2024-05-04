	<?php
		$attributes = array('name' => 'frmexpenses','id'=>'form1');
		echo form_open('transaction/expenses/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Branch Expenses</h1>
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
							<h3 class="card-title">&nbsp;</h3>
							<div class="card-tools">
							    <?php 
									if ($accessmenu['transexpenses']['isadd']=='T')			
									{
										echo '<a href="#AddEdit" class="btn btn-primary" data-toggle="modal">Add Expenses</a>';
									}
								?>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-8 col-lg-6">
									<div class="form-group">
										<!--<label>Enter the  keyword below: (Reference Number or Last Name or First Name)</label>
										<input type="text" name="searchtext" class="form-control" autocomplete="off" value="<?php //echo $this->session->userdata('searchtext'); ?>"placeholder="Enter your keyword here" />
										-->
										<label>Branch <code>*</code></label>
										<select name="branch" id="branchselection" class="form-control required">
											<option value="">Select an Option</option>
											<?php
												foreach($branches as $row)
												{
													echo '<option value="'.$row['branchid'].'" '.($this->session->userdata('selectedbranch')==$row['branchid'] ? 'selected' : null).'>'.$row['branchname'].'</option>';
												}
											?>
										</select>	
									</div>
								</div>
							</div>
						</div>	
					</div>	
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Recent Expenses</h3>
							<div class="card-tools">
								<?php 
									if ($expenses)
									{
										echo anchor('rptprint/expenses/'.$this->session->userdata('selectedbranch'),'Print','class="btn btn-success ml-1" target="_BLANK"');
									}
								?>
							</div>
						</div>		
						<div class="card-body">	
							<table class="table table-bordered">
								<thead>                  
									<tr>
										<th style="text-align:center;">#</th>
										<th style="text-align:center;">Date</th>
										<th style="text-align:center;">Branch</th>
									
										<th style="text-align:center;">Type</th>
										<th style="text-align:center;">Voucher</th>
										<th style="text-align:center;">Payee</th>
										<th style="text-align:center;">Description</th>
										<th style="text-align:center;">Amount</th>
										<th style="text-align:center;">Remarks</th>
										<th style="text-align:center;">Entry By</th>
										<th style="text-align:center;"></th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($expenses)
										{
											$ctr=1;
											foreach($expenses as $row)
											{
												echo '<t>';
												echo '<td style="text-align:center;">'.$ctr.'</td>';
												echo '<td style="text-align:center;">'.($row['expensedate']!='0000-00-00' ? date("F j, Y", strtotime($row['expensedate'])) : '&nbsp;').'</td>';
												echo '<td style="text-align:center;">'.$row['branchname'].'</td>';
												echo '<td style="text-align:center;">'.$row['expensestype'].'</td>';
												echo '<td style="text-align:center;">'.$row['voucher'].'</td>';
												echo '<td style="text-align:center;">'.$row['payee'].'</td>';
												echo '<td style="text-align:center;">'.$row['description'].'</td>';
												echo '<td style="text-align:right;">Php '.number_format(($row['amount']), 2, '.', ',').'</td>';
												
												echo '<td style="text-align:center;">'.$row['remarks'].'</td>';
												echo '<td style="text-align:center;">'.$row['addedby'].'</td>';
												echo '<td style="text-align:center;">';
												if ($accessmenu['transexpenses']['isedit']=='T')			
												{
													echo '<a href="#AddEdit" data-id="'.$row['expensesid'].'" data-toggle="modal" class="btn btn-primary btneditexpenses">Edit</a>';
												}
												if ($accessmenu['transexpenses']['isdelete']=='T')			
												{
													echo anchor('transaction/expenses/d/'.$row['expensesid'].'/'.$this->mylibraries->encrypt('dexs'.$row['expensesid']),'Delete','class="btn btn-danger ml-1 buttonclick"');
												}
												
												echo '</td>';
												echo '</tr>';
												$ctr++;
											}
										}
									?>
								</tbody>
							</table>
					  </div>

					  <!-- /.card-body -->
					</div>
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Expenses Summary</h3>
							<div class="card-tools">
								<?php 
									if ($expenses)
									{
										echo anchor('rptprint/expenses/'.$this->session->userdata('selectedbranch'),'Print','class="btn btn-success ml-1" target="_BLANK"');
									}
								?>
							</div>
						</div>		
						<div class="card-body">	
							<table class="table table-bordered">
								<thead>                  
									<tr>
										<th style="text-align:center;">#</th>
										<th style="text-align:center;">Year</th>
										<th style="text-align:center;">Month</th>
										<th style="text-align:center;">Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($summary)
										{
											$ctr=1;
											$totalexpenses=0;
											foreach($summary as $row)
											{
												echo '<tr>';
												echo '<td style="text-align:center;">'.$ctr.'</td>';
												echo '<td style="text-align:center;">'.$row['Year'].'</td>';
												echo '<td style="text-align:center;">'.$row['Month'].'</td>';
												echo '<td style="text-align:right;">Php '.number_format(($row['Amount']), 2, '.', ',').'</td>';
												echo '</tr>';
												$ctr++;
												$totalexpenses +=$row['Amount'];
											}
											
											echo '<tr>';
											echo '<th style="text-align:right;" colspan="3">Total</th>';
											echo '<th style="text-align:right;">Php '.number_format($totalexpenses, 2, '.', ',').'</th>';
											echo '</tr>';
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
	
	
	<div class="modal fade" id="AddEdit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Expenses Maintenance</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="hid" id="hid" value="0"/>
					<div class="col-12">
						<div class="form-group">
							<label>Branch <code>*</code></label>
							<select name="optionbranch" class="form-control required">
								<option value="">Select an Option</option>
								<?php
									foreach($branches as $row)
									{
										echo '<option value="'.$row['branchid'].'" '.($this->session->userdata('selectedbranch')==$row['branchid'] ? 'selected' : null).'>'.$row['branchname'].'</option>';
									}
								?>
							</select>	
						</div>
						
						<div class="form-group">
							<label>Type <code>*</code></label>
							<select name="type" class="form-control required">
								<option value="">Select an Option</option>
								<?php
									foreach($expensestype as $row)
									{
										echo '<option value="'.$row['expensestypeid'].'">'.$row['expensestype'].'</option>';
									}
								?>
							</select>	
						</div>
						<div class="form-group">
							<label>Date <code>*</code></label>
							<input type="text" name="date" class="form-control required datefield" autocomplete="Off"/>
						</div>
						
						<div class="form-group">
							<label>Voucher No. </label>
							<input type="text" name="voucher" class="form-control required"/>
						</div>
						
						<div class="form-group">
							<label>Payee <code>*</code></label>
							<input type="text" name="payee" class="form-control required"/>
						</div>
						
						<div class="form-group">
							<label>Description <code>*</code></label>
							<input type="text" name="description" class="form-control required"/>
						</div>
						
						<div class="form-group">
							<label>Amount <code>*</code></label>
							<input type="text" name="amount" class="form-control required"/>
						</div>
						
						<div class="form-group">
							<label>Remarks </label>
							<input type="text" name="remarks" class="form-control required"/>
						</div>
						
						
					</div>
				</div>		
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<?php echo form_submit('btnSave','Save','class="btn btn-success buttonclick"');?>
				</div>
			</div>
		</div>
	</div>
	
	<?php 	
		echo form_close();
	?>
	
