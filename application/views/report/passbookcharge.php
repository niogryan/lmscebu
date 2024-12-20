	<?php
		$attributes = array('name' => 'passbookcharge','id'=>'form1');
		echo form_open('rpt/passbookcharge/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Passbook Charge</h1>
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
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">
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
								<div class="col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">
										<label>Area <code>*</code></label>
										
										<select name="area" id="areaselection" class="form-control required">
											<option value="">Select an Option</option>
											
											<?php
												if ($areas)
												{
													echo '<option value="ALL" '.($this->session->userdata('selectedarea')=='ALL' ? 'selected' : null).'>ALL</option>';
													foreach($areas as $row)
													{
														echo '<option value="'.$row['areaid'].'" '.($this->session->userdata('selectedarea')==$row['areaid'] ? 'selected' : null).'>'.$row['areaname'].'</option>';
													}
												}
											?>
										</select>	
									</div>
								</div>
							</div>	
							<div class="row">	
								<div class="col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">	
										<label for="datefrom">Date From <code>Required</code></label>
										<input type="text" name="datefrom" class="form-control" placeholder="Date From" value="<?php echo $this->session->userdata('selectedfrom'); ?>" autocomplete="off"/>
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">	
										<label for="dateto">Date To <code>Required</code></label>
										<input type="text" name="dateto" class="form-control" placeholder="Date To" value="<?php echo $this->session->userdata('selectedto'); ?>" autocomplete="off"/>
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3">
									<div class="form-group">
										<label>&nbsp;</label>
										<?php echo form_submit('btnView','View','class="btn btn-primary btn-block"'); ?>	
									</div>
								</div>
							</div>
						</div>	
					</div>	
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">&nbsp;</h3>
							<div class="card-tools">
								<?php 
									if ($list)
									{
										echo anchor('rptprint/passbookcharge/'.$this->session->userdata('selectedbranch').'/'.$this->session->userdata('selectedarea').'/'.$this->session->userdata('selectedfrom').'/'.$this->session->userdata('selectedto'),'Print','class="btn btn-success ml-1" target="_BLANK"');
									}
								?>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">		
							<table class="table table-bordered">
								<thead>                  
									<tr>
										<th style="text-align:center;">#</th>
										
										<th style="text-align:center;">Customer Name</th>
										<th style="text-align:center;">Loan No.</th>
										<th style="text-align:center;">Released Date</th>
										<th style="text-align:center;">Principal Amount</th>
										<th style="text-align:center;">Interest</th>
										<th style="text-align:center;">Passbook Charge</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($list)
										{
											$totalloan=$totalinterest=$totalpassbookcharge=0;
											$ctr=1;
											foreach($list as $row)
											{
												echo '<t>';
												echo '<td style="text-align:center;">'.$ctr.'</td>';
												
												echo '<td>'.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname'].' '.$row['middlename']).'</td>';
												echo '<td style="text-align:center;">'.$row['referencenumber'].'</td>';
												echo '<td style="text-align:center;">'.($row['releaseddate']!='0000-00-00' ? date("F j, Y", strtotime($row['releaseddate'])) : '&nbsp;').'</td>';
												echo '<td style="text-align:right;">Php '.number_format($row['principalamount'], 2, '.', ',').'</td>';
												echo '<td style="text-align:right;">Php '.number_format($row['interest'], 2, '.', ',').'</td>';
												echo '<td style="text-align:right;">Php '.number_format($row['passbookcharge'], 2, '.', ',').'</td>';
												
												echo '</tr>';
												$totalloan +=$row['principalamount'];
												$totalinterest +=$row['interest'];
												$totalpassbookcharge +=$row['passbookcharge'];
												$ctr++;
											}
											
											echo '<tr>';
											echo '<th style="text-align:right;" colspan="4">Total</th>';
											echo '<th style="text-align:right;">Php '.number_format($totalloan, 2, '.', ',').'</th>';
											echo '<th style="text-align:right;">Php '.number_format($totalinterest, 2, '.', ',').'</th>';
											echo '<th style="text-align:right;">Php '.number_format($totalpassbookcharge, 2, '.', ',').'</th>';
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

	
	<?php 	
		echo form_close();
	?>
	
