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
			<?php
				if ( $user->type == 0 )
				{
					$class_section = 'col-lg-6';
				}
				else
				{
					$class_section = 'col-lg-10';
				}
			?>
			<section class="<?php echo $class_section; ?>">
				<!-- TO DO List -->
				<div class="box">
					<div class="box-header">
						<i class="ion ion-clipboard"></i>
						<h3 class="box-title">Mis Consultas</h3>
						<div class="box-tools pull-right">
							<?php 
								if ( $user->type == 0 )
								{
							?>
								<a href="<?php echo site_url('asuntos/nuevo_asunto').'/'.$categoria; ?>" class="btn btn-default pull-right">
									<i class="fa fa-plus"></i> Agregar Asunto
								</a>
							<?php
								}
							?>
						</div>
					</div><!-- /.box-header -->
					<div class="box-body table-responsive">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Codigo</th>
									<th>Asunto</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach ($contenido as $fila)
								{
							?>
								<tr>
									<td>
										<a href="<?php echo site_url('conversacion').'/'.$categoria.'/'.$fila->cod_consulta; ?>">
											<?php echo trim($fila->initial).'-'.trim($fila->cod_consulta); ?>
										</a>
									</td>
									<td>
										<?php 
											$class_text = ( $fila->estado == 0 ) ? 'text-muted' : 'text-light-blue';
										?>
										<span class="text <?php echo $class_text; ?>"><?php echo $fila->asunto; ?></span>
									</td>
								</tr>
							<?php
								}
							?>
							</tbody>
							<tfoot>
								<tr>
									<th>Codigo</th>
									<th>Asunto</th>
								</tr>
							</tfoot>
						</table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</section>
			<?php if ($user->type == 0): ?>
				<section class="<?php echo $class_section; ?>">
					<!-- TO DO List -->
					<div class="box">
						<div class="box-header">
							<i class="ion ion-clipboard"></i>
							<h3 class="box-title">Otras Consultas</h3>
						</div><!-- /.box-header -->
						<div class="box-body table-responsive">
							<table id="example2" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Codigo</th>
										<th>Asunto</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									foreach ($contenido_adicional as $fila)
									{
								?>
									<tr>
										<td>
											<a href="<?php echo site_url('conversacion').'/'.$categoria.'/'.$fila->cod_consulta; ?>">
												<?php echo trim($fila->initial).'-'.trim($fila->cod_consulta); ?>
											</a>
										</td>
										<td>
											<?php 
												$class_text = ( $fila->estado == 0 ) ? 'text-muted' : 'text-light-blue';
											?>
											<span class="text <?php echo $class_text; ?>"><?php echo $fila->asunto; ?></span>
										</td>
									</tr>
								<?php
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<th>Codigo</th>
										<th>Asunto</th>
									</tr>
								</tfoot>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</section>
			<?php endif ?>
		</div><!-- /.row -->
	</section>
	<!-- DATA TABES SCRIPT -->
	<script src="<?php echo base_url('js/plugins/datatables/jquery.dataTables.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('js/plugins/datatables/dataTables.bootstrap.js'); ?>" type="text/javascript"></script>

	<!-- page script -->
	<script type="text/javascript">
		$(function() {
			$("#example1").dataTable({
				"bAutoWidth": false,
				"aoColumns" : [
					{ sWidth: '2%' },
					{ sWidth: '50%' },
				]
			});

			$("#example2").dataTable({
				"bAutoWidth": false,
				"aoColumns" : [
					{ sWidth: '2%' },
					{ sWidth: '50%' },
				]
			});
		});
	</script>