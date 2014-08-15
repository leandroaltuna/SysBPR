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
			<li class="active"><?php echo $title; ?></li>
		</ol>
	</section><!-- /.Content Header -->
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
		<?php 
			$i = 0;
			foreach ($contactos as $fila)
			{
		?>
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box <?php echo $fila->back; ?>">
					<div class="inner">
						<h3>
							<?php echo $issues[$i]['number']; ?>
						</h3>
						<p>
							<?php echo $fila->name; ?>
						</p>
					</div>
					<div class="icon">
						<i class="ion <?php echo $fila->icon; ?>"></i>
					</div>
					<a href="<?php echo site_url('asuntos/categoria').'/'.$fila->id; ?>" class="small-box-footer">
						Ver todos <i class="fa fa-arrow-circle-right"></i>
					</a>
				</div>
			</div><!-- ./col -->
		<?php
				$i++;
			}
		?>
		</div><!-- /.row -->
	</section>