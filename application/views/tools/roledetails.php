	<?php
		$attributes = array('name' => 'roledetails','id'=>'roledetails');
		echo form_open('tools/roledetails/'.$param1.'/'.$param2,$attributes);
	?>
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Role Details: <?php echo $details[0]['role'];?></h1>
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
							<h3 class="card-title">Menu Access</h3>
							<div class="card-tools">
								<?php 
									if ($accessmenu['toolsroles']['isedit']=='T')			
									{
										echo form_submit('btnSave','Save','class="btn btn-success buttonclick"');
									}
								?>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table class="table table-bordered table-striped">
								<thead>                  
									<tr>
										<th style="text-align:center;"></th>
										<th style="text-align:center;">Category</th>
										<th style="text-align:center;">Menu Name</th>
										<th style="text-align:center;">Add</th>
										<th style="text-align:center;">Edit</th>
										<th style="text-align:center;">Delete</th>
									</tr>
								</thead>
								<tbody>
									<?php
										if ($usermenu)
										{
											foreach($usermenu as $row)
											{
												echo '<tr>';
												echo '<td style="text-align:center;"><input type="checkbox" name="menu[]" value="'.$row['menuid'].'" '.($row['isaccess']!='F' ? 'checked' : null).' class="chkbox"/></td>';
												echo '<td style="text-align:center;">'.$row['category'].'</td>';
												echo '<td >'.$row['menuname'].'</td>';
												echo '<td style="text-align:center;">'.($row['hasadd']=='T' ? '<input type="checkbox" name="isadd[]" value="'.$row['menuid'].'" '.($row['isadd']!='F' ? 'checked' : null).' class="chkbox"/>' :null).'</td>';
												echo '<td style="text-align:center;">'.($row['hasedit']=='T' ? '<input type="checkbox" name="isedit[]" value="'.$row['menuid'].'" '.($row['isedit']!='F' ? 'checked' : null).' class="chkbox"/>' :null).'</td>';
												echo '<td style="text-align:center;">'.($row['hasdelete']=='T' ? '<input type="checkbox" name="isdelete[]" value="'.$row['menuid'].'" '.($row['isdelete']!='F' ? 'checked' : null).' class="chkbox"/>' :null).'</td>';
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
	
	