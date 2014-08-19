    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
	        <?php echo lang('create_group_heading');?>
	        <small><?php echo lang('create_group_subheading');?></small>
        </h1>
        <ol class="breadcrumb">
           	<li class="active"><?php echo lang('create_group_heading');?></li>
        </ol>
    </section><!-- /.Content Header -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
			<section class="col-lg-10">
				<div class="box">
					<div class="box-body table-responsive">
						<div id="infoMessage"><?php echo $message;?></div>

							<?php echo form_open("auth/create_group");?>

							      <p>
							            <?php echo lang('create_group_name_label', 'group_name');?> <br />
							            <?php echo form_input($group_name);?>
							      </p>

							      <p>
							            <?php echo lang('create_group_desc_label', 'description');?> <br />
							            <?php echo form_input($description);?>
							      </p>

							      <p><?php echo form_submit('submit', lang('create_group_submit_btn'));?></p>

							<?php echo form_close();?>
					</div>
				</div>
			</section>
        </div>
	</section>