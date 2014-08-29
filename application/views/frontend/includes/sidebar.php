			<!-- Left side column. contains the logo and sidebar -->
			<aside class="left-side sidebar-offcanvas">
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">
					<!-- Sidebar user panel -->
					<div class="user-panel">
						<div class="pull-left image">
							<img src="<?php echo base_url('img').'/'.$user->image; ?>" class="img-circle" alt="User Image" />
						</div>
						<div class="pull-left info">
							<p>Hola, <?php echo $user->first_name; ?></p>

							<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
						</div>
					</div>
					<!-- search form -->
					<!-- /.search form -->
					<!-- sidebar menu: : style can be found in sidebar.less -->
					<ul class="sidebar-menu">
						<li class="active">
							<a href="<?php echo base_url(); ?>">
								<i class="fa fa-dashboard"></i> <span>Escritorio</span>
							</a>
						</li>
					</ul>
				</section>
				<!-- /.sidebar -->
			</aside>