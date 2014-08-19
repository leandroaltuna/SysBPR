	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo lang('index_heading');?>
			<small><?php echo lang('index_subheading');?></small>
		</h1>
		<ol class="breadcrumb">
			<li class="active"><?php echo lang('index_heading');?></li>
		</ol>
	</section><!-- /.Content Header -->
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<section class="col-lg-10">
				<div class="box">
					<div class="box-body table-responsive">
						<div id="infoMessage"><?php echo $message;?></div>
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th><?php echo lang('index_fname_th');?></th>
									<th><?php echo lang('index_lname_th');?></th>
									<th><?php echo lang('index_email_th');?></th>
									<th><?php echo lang('index_groups_th');?></th>
									<th><?php echo lang('index_status_th');?></th>
									<th><?php echo lang('index_action_th');?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($users as $user):?>
									<tr>
										<td><?php echo $user->first_name;?></td>
										<td><?php echo $user->last_name;?></td>
										<td><?php echo $user->email;?></td>
										<td>
											<?php foreach ($user->groups as $group):?>
												<?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />
							                <?php endforeach?>
										</td>
										<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
										<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						<p><?php echo anchor('auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('auth/create_group', lang('index_create_group_link'))?></p>
					</div>
				</div>
            </section>
		</div>
    </section>
      <!-- DATA TABES SCRIPT -->
		<script src="<?php echo base_url('js/plugins/datatables/jquery.dataTables.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo base_url('js/plugins/datatables/dataTables.bootstrap.js'); ?>" type="text/javascript"></script>
		<!-- page script -->
		<script type="text/javascript">
			$(function() {
				$("#example1").dataTable();
			});
		</script>