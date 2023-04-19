<?php
	
	//Aqui va el código PHP del Vídeo
	
/*	require 'funcs/conexion.php';
	include 'funcs/funcs.php';
	session_start();
	if(isset($_SESSION["id_usuario"])){
		header("Location: welcome.php");
	} 
	$errors = array();
	if(!empty($_POST)) {
		$email = $mysqli->real_escape_string($_POST['email']);
		if(!isEmail($email)) {
			$errors[] = "Debe ingresar un correo electronico valido";
			} 
			if(emailExiste($email)) 
			{ 
				$idusuario = getValor('idusuario', 'email', $email);
				$nombre = getValor('nombre', 'email', $email);
				$token = generaTokenPass($idusuario);
				$url = 'http://'.$_SERVER["SERVER_NAME"].'/login/cambia_pass.php?idusuario='.$idusuario.'&token='.$token; 
				$asunto = 'Recuperar Password - Sistema de Insumos';
				$cuerpo = "Hola $nombre: <br /><br />Se ha solicitado un reinicio de contraseña <br/><br/>Para restaurarla visite la siguiente
				direccion: <a href='$url'>$url</a>"; 
				if(enviarEmail($email, $nombre, $asunto, $cuerpo)){
					echo "Hemos enviado un correo electronico a las direcion $email para recuperar la contraseña";
					echo "<a href='index.php' >Iniciar Sesion</a>";
					exit; 
					} 
				} else { $errors[] = "La direccion de correo electronico no existe"; } */
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Recuperar Password</title>

		<link rel="stylesheet" href="../public/css/bootstrap.min.css">
		<!--<link rel="stylesheet" href="css/bootstrap.min.css" >-->
		<link rel="stylesheet" href="../public/css/bootstrap-theme.min.css" >
		<script src="../public/js/bootstrap.min.js" ></script>
		
	</head>
	
	<body class="hold-transition login-page">
		
		<div class="container">    
			<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
					<div class="panel-heading">
						<div class="panel-title">Recuperar Password</div>
						<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="index.php">Iniciar Sesi&oacute;n</a></div>
					</div>     
					
					<div style="padding-top:30px" class="panel-body" >
						
						<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
						
						<form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
							
							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input id="email" type="email" class="form-control" name="email" placeholder="email" required>                                        
							</div>
							
							<div style="margin-top:10px" class="form-group">
								<div class="col-sm-12 controls">
									<button id="btn-login" type="submit" class="btn btn-success">Enviar</a>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12 control">
									<!--<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
										No tiene una cuenta! <a href="registro.php">Registrate aquí</a>
									</div>-->
								</div>
							</div>    
						</form>
					</div>                     
				</div>  
			</div>
		</div>
	</body>
</html>						