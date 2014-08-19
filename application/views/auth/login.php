<!DOCTYPE html>
<html lang="es">
<head>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../assets/ico/favicon.ico">

	<title>Login</title>

	<!-- Bootstrap core CSS -->
	<link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">

	<!-- Icons for this template -->
	<!-- <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> -->
	<link href="<?php echo base_url('css/font-awesome.min.css'); ?>" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="<?php echo base_url('assets/css/signin.css'); ?>" rel="stylesheet">

	<!-- Just for debugging purposes. Don't actually copy this line! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>

	<script type="text/javascript">
		function check_values()
		{
			if ( $("#identity").val().length != 0 && $("#password").val().length != 0 )
			{
				$("#button1").removeClass("hidden").animate({ left: '250px' });;
				$("#lock1").addClass("hidden").animate({ left: '250px' });;
			}
			else
			{
				$("#button1").addClass("hidden").animate({ left: '250px' });;
				$("#lock1").removeClass("hidden").animate({ left: '250px' });;
			}
		}
	</script>
</head>
<body>
	<?php 

	$form_attributes = array(
							'class' => 'form-signin', 
							'role' 	=> 'form'
						);

	$identity = array(
					'id' 			=> 'identity',
					'name' 			=> 'identity',
					'value' 		=> '',
					'class'			=> 'form-control',
					'placeholder' 	=> 'RUC',
					'required'		=> 'true',
					'autofocus'		=> 'true',
					'onkeyup'		=> 'check_values()',
					'maxlength'		=> 11
				);

	$password = array(
					'id' 			=> 'password',
					'name' 			=> 'password',
					'class'			=> 'form-control',
					'placeholder' 	=> 'Clave',
					'required'		=> 'true',
					'onkeyup'		=> 'check_values()',
					'maxlength'		=> 11
				);

	?>
	<div class="container">

	<?php 
		echo form_open("auth/login", $form_attributes);
	?>
		<div class="row colored">
			<div id="contentdiv" class="contcustom">
				<span class="fa fa-spinner bigicon"></span>
				<h2>
					<?php echo lang('login_heading');?>
				</h2>
				<div id="infoMessage">
					<?php echo $message;?>
				</div>
				<div>
					<?php echo form_input($identity); ?>
					<?php echo form_password($password); ?>
					<button id="button1" class="btn btn-default wide hidden"><span class="fa fa-check med"></span></button>
					<span id="lock1" class="fa fa-lock medhidden redborder"></span>
				</div>
			</div>
		</div>
	<?php 
		echo form_close();
	?>
	</div> <!-- /container -->
</body>
</html>