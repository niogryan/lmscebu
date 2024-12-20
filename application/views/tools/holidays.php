	<?php
		$attributes = array('name' => 'frmindex','id'=>'frmindex');
		echo form_open('tools/holidays/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Holidays</h1>
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
									if ($accessmenu['toolsholidays']['isadd']=='T')			
									{
										echo '<a href="#AddEdit" class="btn btn-primary" data-toggle="modal">Add Holiday</a>';
									}
								?>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							
							
							<table class="table table-bordered">
								<thead>                  
									<tr>
										<th style="text-align:center;">Date</th>
										<th style="text-align:center;">Holiday Name</th>
										<th style="text-align:center;">Is National Holiday</th>
										<th style="text-align:center;">Remarks</th>
										<th style="text-align:center;"></th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($holidays)
										{
											foreach($holidays as $row)
											{
												echo '<tr>';
												echo '<td style="text-align:center;">'.$row['holidaydate'].'</td>';
												echo '<td style="text-align:center;">'.$row['holidayname'].'</td>';
												echo '<td style="text-align:center;">'.($row['isnational']=='Y' ? 'Yes' : 'No').'</td>';
												echo '<td style="text-align:center;">'.$row['holidayremarks'].'</td>';
												echo '<td style="text-align:center;">';
												if ($accessmenu['toolsholidays']['isedit']=='T')			
												{
													echo '<a href="#AddEdit" data-id="'.$row['holidayid'].'" data-toggle="modal" class="btn btn-primary btneditholiday">Edit</a>';
												}
												echo anchor('tools/holidaydetails/'.$row['holidayid'].'/'.$this->mylibraries->encrypt('vh'.$row['holidayid']),'Branches','class="btn btn-warning ml-1"');
												
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
	
	
	<div class="modal fade" id="AddEdit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Holiday Maintenance</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="hid" id="hid"/>
					<div class="col-12">
						<div class="form-group">
							<label>Date <code>*</code></label>
							<input type="text" name="date" class="form-control required datefield" autocomplete="Off"/>
						</div>
						<div class="form-group">
							<label>Holiday Name <code>*</code></label>
							<input type="text" name="holidayname" class="form-control required" autocomplete="Off"/>
						</div>
						<div class="form-group">
							<label>National Holiday <code>*</code></label>
							<select name="isnational" class="form-control">
								<option value="N">NO</option>
								<option value="Y">YES</option>
							</select>
						</div>
						<div class="form-group">
							<label>Remarks </label>
							<input type="text" name="remarks" class="form-control required" autocomplete="Off" />
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
	
