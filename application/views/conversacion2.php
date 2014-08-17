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
				<!-- Chat box -->
				<div class="box box-success">
					<div class="box-header">
						<i class="fa fa-comments-o"></i>
						<h3 class="box-title">Chat</h3>
						<h3 class="box-title">( <?php echo $cabecera->asunto; ?> )</h3>
						<div class="box-tools pull-right" data-toggle="tooltip" title="Status">
							<div class="btn-group" data-toggle="btn-toggle" >
								<!-- <button type="button" class="btn btn-default btn-sm active">
									<i class="fa fa-square text-green"></i>
								</button> -->
								<?php
									$disabled = '';
									if ( $cabecera->estado == 0 )
									{
										$disabled = 'disabled="true"';
									}
								?>
								<button type="button" id="end" name="end" <?php echo $disabled; ?> class="btn btn-default btn-sm">
									<i class="fa fa-square text-red"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="box-body chat" id="chat-box">
					<?php 
						foreach ($contenido as $fila)
						{
					?>
						<!-- chat item -->
						<div class="item">
						<?php 
							if ( $fila->tipo == 0 )
							{
						?>
							<img src="<?php echo base_url('img/avatar04.png'); ?>" alt="usuario" class="offline"/>
						<?php 
							}
							else
							{
						?>
							<img src="<?php echo base_url('img/avatar.png'); ?>" alt="consultor" class="online"/>
						<?php
							}
						?>
							<p class="message">
								<a href="#" class="name">
									<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 
										<?php 
											$date = date_create($fila->fecha);
											echo date_format($date, 'd/m/Y H:i'); 
										?>
									</small>
									<?php echo $fila->first_name; ?>
								</a>
								<?php echo $fila->mensaje; ?>
							</p>
						</div><!-- /.item -->
					<?php
						}
					?>
					</div><!-- /.chat -->
					<div class="box-footer">
						<div class="input-group">
							<input id="mensaje" name="mensaje" <?php echo $disabled; ?> class="form-control" placeholder="Type message..." required/>
							<div class="input-group-btn">
								<button id="enviar" name="enviar" <?php echo $disabled; ?> class="btn btn-success">
									<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<input type="hidden" id="consulta" name="consulta" value="<?php echo $consulta; ?>" />
						<input type="hidden" id="categoria" name="categoria" value="<?php echo $categoria; ?>" />
					</div>
				</div><!-- /.box (chat box) -->
			</section>
		</div>
	</section>

	<script type="text/javascript">

		$(document).ready(function() {
			view_chat();
		});


		function view_chat()
		{
			var button_form = $('#enviar');
			button_form.attr('disabled','disabled');

			var new_data = [];
			new_data.push(
				{ name: 'cod_consulta', value: $('#consulta').val() },
				{ name: 'group_id', value: $('#categoria').val() }
			);

			var html = '';
			
			$.ajax({
				url: CI.site_url + '/conversacion/view_chat',
				type: 'POST',
				data: new_data,
				dataType: 'json',
				success:function(json_data) 
				{
					if (json_data.contenido.length == 0 ) { return; }

					$.each( json_data.contenido, 
							function(i, datos)
							{
								// chat item
								html += '<div class="item">';
											if ( datos.tipo == 0 )
											{
												name_image = 'avatar04.png';
												class_image = 'offline';
											}
											else
											{
												name_image = 'avatar.png';
												class_image = 'online';
											}

									html += '<img src="'+ CI.base_url +'img/'+ name_image +'" alt="usuario" class="'+ class_image +'"/>' +
											'<p class="message">' +
											'<a href="#" class="name">' +
												'<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> ' +
													datos.fecha +
												'</small>' +
												datos.first_name +
											'</a>' +
											datos.mensaje +
											'</p>' +
										'</div>';
								//.item
							}
						);
					$('#chat-box').html( html );
				}
			});
		}

		$('#enviar').click(function (event) {
			
			mensaje = $("#mensaje").val();

			var container = $('#chat-box');
			height_value = container[0].scrollHeight;

			$(".slimScrollBar").css({ top: height_value + 'px' });
			container[0].scrollTop = height_value;
			
			if (mensaje.trim() != '')
			{
				var new_data = [];

				var button_form = $('#enviar');
				button_form.attr('disabled','disabled');


				new_data.push(
					{ name: 'cod_consulta', value: $('#consulta').val() },
					{ name: 'group_id', value: $('#categoria').val() },
					{ name: 'mensaje', value: mensaje }				
				);
				
				$.ajax({
					url: CI.site_url + '/conversacion/mensajes',
					type: 'POST',
					data: new_data,
					dataType: 'json',
					success:function(json) 
					{
						if ( json.estado == 1 )
						{
							add_mensaje( mensaje );
						} else {
							alert(json.msg);
						}
						button_form.removeAttr('disabled');
						$("#mensaje").val('');
					}
				});
			}

		});

		$('#mensaje').keypress(function (e) 
		{
			var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
			if(key == 13)
			$('#enviar').trigger('click');
		});

		function add_mensaje( mensaje )
		{

			var currentdate = new Date();
			var fomat_date = currentdate.getDate() + "/"
							+ (currentdate.getMonth()+1)  + "/" 
							+ currentdate.getFullYear() + " "  
							+ currentdate.getHours() + ":"  
							+ currentdate.getMinutes();

			var tipo = '<?php echo $user->type; ?>';
			image = ( parseInt(tipo) == 0) ? 'avatar04.png' : 'avatar.png';

			var html = '';
					/** chat item **/
			html = '<div class="item">' +
						'<img src="'+ CI.base_url + 'img/'+ image +'" alt="user image" class="offline"/>' +
						'<p class="message">' +
							'<a href="#" class="name">' +
								'<small class="text-muted pull-right"><i class="fa fa-clock-o"></i>'+ fomat_date +'</small>' +
								'<?php echo $user->first_name; ?>' +
							'</a>' +
							mensaje + 
						'</p>' +
					'</div>';
					/** /.item **/

			$('#chat-box').append(html);

			var container = $('#chat-box');
			height_value = container[0].scrollHeight;

			$(".slimScrollBar").css({ top: height_value + 'px' });
			container[0].scrollTop = height_value;
		}

		$('#end').click(function (event) {
			
			var button_close = $('#end');
			var button_send = $('#enviar');
			var input_message = $('#mensaje');

			button_close.attr('disabled','disabled');
			button_send.attr('disabled','disabled');
			input_message.attr('disabled','disabled');

			var new_data = [];
			new_data.push(
				{ name: 'cod_consulta', value: $('#consulta').val() },
				{ name: 'group_id', value: $('#categoria').val() }
			);
			
			$.ajax({
				url: CI.site_url + '/asuntos/close_chat',
				type: 'POST',
				data: new_data,
				dataType: 'json',
				success:function(json) 
				{
					alert(json.msg);
				}
			});
			

		});

	</script>