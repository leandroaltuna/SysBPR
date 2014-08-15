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
			<li>
				<a href="<?php echo site_url('asuntos/categoria').'/'.$categoria; ?>">
					<i class="fa fa-dashboard"></i> Consultas
				</a>
			</li>
			<li class="active"><?php echo $title; ?></li>
		</ol>
	</section><!-- /.Content Header -->
	<section class="content">
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<section class="col-lg-10">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Nueva Consulta</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form id="newchat" role="form">
						<div class="box-body">
							<div class="form-group">
								<label for="asunto">Asunto</label>
								<input type="text" id="asunto" name="asunto" class="form-control" maxlength="150" placeholder="Escribe el asunto...">
								<div class="help-block error"></div>
							</div>
							<div class="form-group">
								<label for="mensaje">Mensaje</label>
								<input type="text" id="mensaje" name="mensaje" class="form-control" maxlength="500" placeholder="Escribe tu mensaje...">
								<div class="help-block error"></div>
							</div>
							<input type="hidden" id="categoria" name="categoria" value="<?php echo $categoria; ?>" />
						</div><!-- /.box-body -->
						<div class="box-footer">
							<button id="enviar" name="enviar" type="submit" class="btn btn-primary">Enviar</button>
						</div>
					</form>
				</div><!-- /.box -->
			</section>
		</div>
	</section>
	<script type="text/javascript">
		// Form 1B_100 //
		$('#newchat').validate({
				rules : 
				{
					asunto: 
					{
						required: true,
						maxlength: 150
					},
					mensaje: 
					{
						required: true,
						maxlength: 500
					}
				},
				messages : 
				{

				},
				errorPlacement: function(error, element) {
					$(element).next().after(error);
				},
				invalidHandler: function(form, validator) {
					var errors = validator.numberOfInvalids();
					if (errors) {
						var message = errors == 1
						? 'Por favor corrige estos errores:\n'
						: 'Por favor corrige los ' + errors + ' errores.\n';
						var errors = "";
						if (validator.errorList.length > 0) {
							for (x=0;x<validator.errorList.length;x++) {
								errors += "\n\u25CF " + validator.errorList[x].message;
							}
						}
						alert(message + errors);
					}
					validator.focusInvalid();
				},
				submitHandler: function(form)
				{
					var new_data = $('#newchat').serializeArray();

					var button_form = $('#newchat').find(':submit');
					button_form.attr('disabled','disabled');

					new_data.push(
						{ name: 'group_id', value: $("#categoria").val() }
					);
					
					$.ajax({
						url: CI.site_url + '/asuntos/create_chat',
						type: 'POST',
						data: new_data,
						dataType: 'json',
						success:function(json) 
						{
							alert(json.msg);
							button_form.removeAttr('disabled');
							$('#newchat')[0].reset();
						}
					});
				}
			}
		);
	</script>