	<?php
		$attributes = array('name' => 'badaccounts','id'=>'badaccounts');
		echo form_open('app/badaccounts/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Search Bad Accounts</h1>
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
							<h3 class="card-title"&nbsp;</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-8 col-lg-6">
									<div class="form-group">
										<label>Enter the  keyword below: (Last Name or First Name)</label>
										<input type="text" name="searchtext" class="form-control" autocomplete="off" value="<?php echo $this->session->userdata('searchtext'); ?>"placeholder="Enter your keyword here" />
									</div>
								</div>
								<div class="col-sm-12  col-md-4 col-lg-2">
									<div class="form-group">
										<label>&nbsp;</label>
										<?php	echo form_submit('btnSearch', 'Advanced Search', 'class="btn btn-primary btn-block"');?>
									</div>
								</div>
							</div>
							
							<table class="table table-bordered table1">
								<thead>                  
									<tr>
										<th style="text-align:center;">Branch</th>
										<th style="text-align:center;">Area</th>
										<th style="text-align:center;">Customer Name</th>
										<th style="text-align:center;">Loan Ref. No.</th>
										<th style="text-align:center;">Released Date</th>
										<th style="text-align:center;">Due Date</th>
										<th style="text-align:center;">Amount</th>
										<th style="text-align:center;">Interest</th>
										<th style="text-align:center;">Balance</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($loans)
										{
											foreach($loans as $row)
											{
												echo '<tr>';
												echo '<td style="text-align:center;">'.$row['branchname'].'</td>';
												echo '<td style="text-align:center;">'.$row['areaname'].'</td>';
												echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname'].' '.$row['middlename']).'</td>';
												echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
												
												echo '<td style="text-align:center;">'.($row['releaseddate']!='0000-00-00' ? date("F j, Y", strtotime($row['releaseddate'])) : '&nbsp;').'</td>';
												echo '<td style="text-align:center;">'.($row['duedate']!='0000-00-00' ? date("F j, Y", strtotime($row['duedate'])) : '&nbsp;').'</td>';
												echo '<td style="text-align:right;">Php '.number_format($row['principalamount'], 2, '.', ',').'</td>';
												echo '<td style="text-align:right;">Php '.number_format($row['interest'], 2, '.', ',').'</td>';
												echo '<td style="text-align:right;">Php '.number_format($row['balance'], 2, '.', ',').'</td>';
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