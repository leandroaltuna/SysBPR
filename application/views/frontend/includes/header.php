<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>BPR OTED</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- bootstrap 3.0.2 -->
		<link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
		<!-- font Awesome -->
		<link href="<?php echo base_url('css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
		<!-- Ionicons -->
		<link href="<?php echo base_url('css/ionicons.min.css'); ?>" rel="stylesheet" type="text/css" />
		
		<!-- DATA TABLES -->
        <link href="<?php echo base_url('css/datatables/dataTables.bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
		
		<!-- Theme style -->
		<link href="<?php echo base_url('css/Admin.css'); ?>" rel="stylesheet" type="text/css" />

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

		<!-- jQuery 2.0.2 -->
		<script src="<?php echo base_url('js/jquery.min.js'); ?>" type="text/javascript"></script>

		<!-- jQuery Validation -->
		<script src="<?php echo base_url('js/jquery.validate.min.js'); ?>" type="text/javascript"></script>

		<script type="text/javascript">
			<!--
			var CI = {
				'base_url': '<?php echo base_url(); ?>',
				'site_url': '<?php echo site_url(); ?>',
				'year': <?php echo date("Y"); ?>
			};
			-->
		</script>
		<script type="text/javascript">
		
		$.extend(jQuery.validator.messages, {
			required: "Campo obligatorio",
			// remote: "Please fix this field.",
			email: "Ingrese un email válido",
			// url: "Please enter a valid URL.",
			date: "Ingrese una fecha válida",
			// dateISO: "Please enter a valid date (ISO).",
			number: "Solo se permiten números enteros o decimlaes",
			digits: "Solo se permiten números",
			range: jQuery.validator.format("Por favor ingrese un valor  entre {0} y {1}."),
			// creditcard: "Please enter a valid credit card number.",
			// equalTo: "Please enter the same value again.",
			// accept: "Please enter a value with a valid extension.",
			maxlength: jQuery.validator.format("Por favor no ingrese mas de {0} caracteres."),
			// minlength: jQuery.validator.format("Please enter at least {0} characters."),
			// rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
			// range: jQuery.validator.format("Please enter a value between {0} and {1}."),
			// max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
			// min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
		});
		
	</script>

	</head>
	<body class="skin-blue">