	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo lang('deactivate_heading');?>
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
						<div id="infoMessage"><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></div>
						<?php echo form_open("auth/deactivate/".$user->id);?>

							<p>
								<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
							<input type="radio" name="confirm" value="yes" checked="checked" />
							<?php echo lang('deactivate_confirm_n_label', 'confirm');?>
							<input type="radio" name="confirm" value="no" />
							</p>

							<?php echo form_hidden($csrf); ?>
							<?php echo form_hidden(array('id'=>$user->id)); ?>

							<p><?php echo form_submit('submit', lang('deactivate_submit_btn'));?></p>

						<?php echo form_close();?>
					</div>
				</div>
			</section>
		</div>
	</section>