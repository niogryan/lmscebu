	<?php
		$attributes = array('name' => 'frmindex','id'=>'frmindex');
		echo form_open('tools/branches/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Branches</h1>
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
									if ($accessmenu['toolsbranches']['isadd']=='T')			
									{
										echo '<a href="#AddEdit" class="btn btn-primary" data-toggle="modal">Add Branches</a>';
									}
								?>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							
							
							<table class="table table-bordered">
								<thead>                  
									<tr>
										<th style="text-align:center;">Name</th>
										<th style="text-align:center;">Short Description</th>
										<th style="text-align:center;">Address</th>
										<th style="text-align:center;">Contact Person</th>
										<th style="text-align:center;">Contact Number</th>
										<th style="text-align:center;">IP Address</th>
										<th style="text-align:center;"></th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($branches)
										{
											foreach($branches as $row)
											{
												echo '<tr>';
												echo '<td>'.$row['branchname'].'</td>';
												echo '<td style="text-align:center;">'.$row['branchshortdesc'].'</td>';
												echo '<td>'.$row['branchaddress'].'</td>';
												echo '<td style="text-align:center;">'.$row['branchcontactperson'].'</td>';
												echo '<td style="text-align:center;">'.$row['branchcontactnumber'].'</td>';
												echo '<td style="text-align:center;">'.$row['ipaddress'].'</td>';
												echo '<td style="text-align:center;">';
												if ($accessmenu['toolsbranches']['isedit']=='T')			
												{
													echo '<a href="#AddEdit" data-id="'.$row['branchid'].'" data-toggle="modal" class="btn btn-primary btneditbranch">Edit</a>';
												}
												echo anchor('tools/servicecharge/'.$row['branchid'].'/'.$this->mylibraries->encrypt('vsc'.$row['branchid']),'Service Charge Config','class="btn btn-warning ml-1"');
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
					<h4 class="modal-title"> Branches Maintenance</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="hid" id="hid"/>
					<div class="col-12">
						<div class="form-group">
							<label>Name <code>*</code></label>
							<input type="text" name="name" class="form-control required"/>
						</div>
						<div class="form-group">
							<label>Short Description <code>*</code></label>
							<input type="text" name="shortdesc" class="form-control required"/>
						</div>
						<div class="form-group">
							<label>Address <code>*</code></label>
							<input type="text" name="address" class="form-control required"/>
						</div>
						<div class="form-group">
							<label>Contact Person <code>*</code></label>
							<input type="text" name="contactperson" class="form-control required"/>
						</div>
						<div class="form-group">
							<label>Contact Number <code>*</code></label>
							<input type="text" name="contactnumber" class="form-control required"/>
						</div>
						<div class="form-group">
							<label>IP Address <code>*</code></label>
							<input type="text" name="ipaddress" class="form-control required"/>
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
	
