		<!-- header logo: style can be found in header.less -->
		<header class="header">
			<a href="<?php echo base_url(); ?>" class="logo">
				<!-- Add the class icon to your logo image or logo icon to add the margining -->
				BPR - INEI
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<div class="navbar-right">
					<ul class="nav navbar-nav">
						<!-- Messages: style can be found in dropdown.less-->
						<li id="alert_messages" name="alert_messages" class="dropdown messages-menu">
							<!-- AJAX -->
						</li>
						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="glyphicon glyphicon-user"></i>
								<span><?php echo $user->first_name; ?> <i class="caret"></i></span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header bg-light-blue">
									<img src="<?php echo base_url('img').'/'.$user->image; ?>" class="img-circle" alt="User Image" />
									<p>
										<?php echo $user->first_name.' '.$user->last_name; ?> - <?php echo $user->company; ?>
										<!-- <small>Member since Nov. 2012</small> -->
									</p>
								</li>
								<!-- Menu Body -->
								<!-- <li class="user-body">
									<div class="col-xs-4 text-center">
										<a href="#">Followers</a>
									</div>
									<div class="col-xs-4 text-center">
										<a href="#">Sales</a>
									</div>
									<div class="col-xs-4 text-center">
										<a href="#">Friends</a>
									</div>
								</li> -->
								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<a href="<?php echo site_url('auth/change_password'); ?>" class="btn btn-default btn-flat">Cambiar Clave</a>
									</div>
									<div class="pull-right">
										<a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-default btn-flat">Salir</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<script type="text/javascript">
			
			$(document).ready(function() {

				new_message();

				setInterval(function() {
					new_message();
				}, 7000);

				function new_message ()
				{
					var html = '';
			
					$.ajax({
						url: CI.site_url + '/conversacion/new_message',
						type: 'POST',
						dataType: 'json',
						success:function(json_data) 
						{
							number = (json_data.alert == 0) ? '' : json_data.alert;

							html += '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' +
										'<i class="fa fa-envelope"></i>' +
										'<span class="label label-success">'+ number +'</span>' +
									'</a>';
							html += '<ul class="dropdown-menu">' +
										'<li class="header"> Ud. tiene ' + json_data.alert + ' mensajes </li>' +
										'<li>' +
											// inner menu: contains the actual data //
											'<ul class="menu">';
											$.each( json_data.contenido, 
													function(i, datos)
													{
														html += description_message( datos.group_id, datos.name, datos.cod_consulta, datos.asunto);
													}
												);
							html +=			'</ul>' +
										'</li>' +
										'<li class="footer">' +
											// '<a href="#">See All Messages</a>' +
										'</li>' +
									'</ul>';

							$('#alert_messages').html( html );
						}
					});
				}

				function description_message ( categoria, name_categoria, consulta, issues )
				{
					
					// start message //
					contenido = '<li>' +
									'<a href="'+ CI.site_url +'/conversacion/'+ categoria +'/'+ consulta +'">' +
										// '<div class="pull-left">' +
										// 	'<img src="'+ CI.base_url +'img/' + user_image + '" class="img-circle" alt="User Image"/>' +
										// '</div>' +
										'<h4>' +
											name_categoria +
											//'<small><i class="fa fa-clock-o"></i> 5 mins</small>' +
										'</h4>' +
										'<p>'+ issues +'</p>' +
									'</a>' +
								'</li>';
					// end message //

					return contenido;
				}

			});

		</script>