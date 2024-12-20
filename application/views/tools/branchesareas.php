	<?php
		$attributes = array('name' => 'branchesareas','id'=>'branchesareas');
		echo form_open('tools/branchesareas/',$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Branches Areas</h1>
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
									if ($accessmenu['toolsbranchesareas']['isadd']=='T')			
									{
										echo '<a href="#AddEdit" class="btn btn-primary" data-toggle="modal">Add Branch Area</a>';
									}
								?>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							
							
							<table class="table table-bordered">
								<thead>                  
									<tr>
										<th style="text-align:center;">Branch</th>
										<th style="text-align:center;">City/Municipality</th>
										<th style="text-align:center;">Area Name</th>
										<th style="text-align:center;"></th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($branchesareas)
										{
											foreach($branchesareas as $row)
											{
												echo '<tr class="'.($row['isactive']!='T' ? 'table-danger' : null).'">';
												echo '<td>'.$row['branchname'].'</td>';
												echo '<td style="text-align:center;">'.$row['areacity'].'</td>';
												echo '<td style="text-align:center;">'.$row['areaname'].'</td>';
												echo '<td style="text-align:center;">';
												if ($accessmenu['toolsbranchesareas']['isedit']=='T')			
												{
													echo '<a href="#AddEdit" data-id="'.$row['branchareaid'].'" data-toggle="modal" class="btn btn-primary btneditbranchareas">Edit</a>';
												}
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
					<h4 class="modal-title">Branch Area Maintenance</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="hid" id="hid"/>
					<div class="col-12">
						<div class="form-group">
							<label>Branch <code>*</code></label>
							<select name="branch" class="form-control">
								<?php
									foreach($branches as $row)
									{
										echo '<option value="'.$row['branchid'].'">'.$row['branchname'].'</option>';
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Area <code>*</code></label>
							<select name="area" class="form-control">
								<?php
									foreach($areas as $row)
									{
										echo '<option value="'.$row['areaid'].'">['.$row['areacity'].'] '.$row['areaname'].'</option>';
									}
								?>
							</select>
						</div>
						<!--
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
						-->
						<div class="form-group">
							<label>Status <code>*</code></label>
							<select name="status" class="form-control">
								<option value="T">Active</option>
								<option value="F">Inactive</option>
							</select>
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
	
