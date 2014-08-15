	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<!-- Escritorio -->
			<?php echo $title; ?>
			<small><!-- Panel de Control --><?php echo $description; ?></small>
		</h1>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url(); ?>">
					<i class="fa fa-dashboard"></i> Inicio
				</a>
			</li>
			<li>
				<a href="<?php echo site_url('contactos'); ?>">
					<i class="fa fa-dashboard"></i> Contactos
				</a>
			</li>
			<li class="active"><?php echo $title; ?></li>
		</ol>
	</section><!-- /.Content Header -->
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<section class="col-lg-10">
				<!-- TO DO List -->
				<div class="box box-primary">
					<div class="box-header">
						<i class="ion ion-clipboard"></i>
						<h3 class="box-title">Lista de Asuntos</h3>
						<!-- <div class="box-tools pull-right">
							<ul class="pagination pagination-sm inline">
								<li><a href="#">&laquo;</a></li>
								<li><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">&raquo;</a></li>
							</ul>
						</div> -->
					</div><!-- /.box-header -->
					<div class="box-body">
						<ul class="todo-list">
					<?php 
						foreach ($contenido as $fila)
						{
					?>
							<li class="active">
								<!-- drag handle -->
								<!-- <span class="handle"> -->
								<span>
									<i class="fa fa-ellipsis-v"></i>
									<i class="fa fa-ellipsis-v"></i>
								</span>
								<!-- checkbox -->
								<!-- <input type="checkbox" value="" name="" checked="true" /> -->
								<!-- todo text -->
								<?php 
									$class_text = ( $fila->estado == 0 ) ? 'text-muted' : 'text-light-blue';
								?>
								<span class="text <?php echo $class_text; ?>"><?php echo $fila->asunto; ?></span>
								<!-- Emphasis label -->
								<!-- <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small> -->
								<!-- General tools such as edit or delete-->
								<div class="tools">
									<a href="<?php echo site_url('conversacion').'/'.$categoria.'/'.$fila->cod_consulta; ?>">
										<i class="fa fa-edit"></i>
									</a>
									<!-- <a href="#">
										<i class="fa fa-power-off"></i>
									</a> -->
								</div>
							</li>
					<?php
						}
					?>
					</div><!-- /.box-body -->
					<div class="box-footer clearfix no-border">
						<a href="<?php echo site_url('asuntos/nuevo_asunto').'/'.$categoria; ?>" class="btn btn-default pull-right">
							<i class="fa fa-plus"></i> Agregar Asunto
						</a>
					</div>
				</div><!-- /.box -->
			</section>
		</div><!-- /.row -->
	</section>