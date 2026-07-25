<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet"> 
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap');

		@font-face {
		  	font-family: "Raleway", sans-serif;
			src: url('<?=url('css/raleway/raleway-regular.eot')?>'); /* IE9 Compat Modes */
		    src: url('<?=url('css/raleway/raleway-regular.eot')?>?#iefix') format('embedded-opentype'), /* IE6-IE8 */
		         url('<?=url('css/raleway/raleway-bold.woff')?>') format('woff'), /* Modern Browsers */
		         url('<?=url('css/raleway/Raleway-VariableFont_wght.ttf')?>')  format('truetype'); /* Safari, Android, iOS */
		}
		body{
			font-family: "Raleway", sans-serif;
			background-color: #EFEFEF;
			font-size: 15px;
			
			color: #5F5F5F;
		}

		table tr td, table tr td h3, table tr td h4, table tr td p, table tr td span{
			font-family: "Raleway", sans-serif;	
			font-size: 15px;
			
		}
		.titprod{
			font: normal normal bold 22px/18px Raleway;
			letter-spacing: 1px;
			color: #5F5F5F;
		}
		.txtdetalle, .txtdetalle span{
			color: #5F5F5F;
    		font: normal normal normal 14px/18px Raleway;
		}
		.tablealma{
			background-color: #ffffff;
	        -moz-border-radius: 45px;
	        overflow:hidden;
	        border: 0px;
	        font-family: "Raleway", sans-serif;
		}
		.tablealmainterna{
			padding: 10px 0;
			font-family: "Raleway", sans-serif;	
		}

		.button-3 {
			width: 50%;
		  	appearance: none;
		  	background-color: #2ea44f;
		  	border-radius: 25px;
		  	box-sizing: border-box;
		  	color: #fff;
		  	cursor: pointer;
		  	display: inline-block;
		  	font-family: "Raleway", sans-serif;
		  	font-weight: 700;
		  	line-height: 20px;
		 	padding: 15px 0;
		  	position: relative;
		  	text-align: center;
		  	text-decoration: none;
		  	user-select: none;
		  	-webkit-user-select: none;
		  	touch-action: manipulation;
		  	vertical-align: middle;
		  	white-space: nowrap;

		}

		.button-3:focus:not(:focus-visible):not(.focus-visible) {
		  box-shadow: none;
		  outline: none;
		}

		.button-3:hover {
		  background-color: #2c974b;
		}

		.imagenpro{
			max-height: 80px; 
			max-width:85px;
			border-radius: 15px;
	        -moz-border-radius: 15px;
		}
		.obser{
			color: #707070;
    		font-size: 16px;
		}
		.btn-4{
		    width: 50%;
    appearance: none;
    border-radius: 25px;
    box-sizing: border-box;
    color: #ffff;
    cursor: pointer;
    display: inline-block;
    font-family: "Raleway", sans-serif;
    font-weight: 700;
    line-height: 20px;
    padding: 15px 0;
    position: relative;
    text-align: center;
    text-decoration: none;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    vertical-align: middle;
    white-space: nowrap;
    border: solid 2px #1FD161;
    background: #1FD161;
		}

		.button-k {
		width: 50%;
		appearance: none;
		background-color: #6658FC;
		border-radius: 25px;
		box-sizing: border-box;
		color: #ffff;
		cursor: pointer;
		display: inline-block;
		font-family: "Raleway", sans-serif;
		font-weight: 700;
		line-height: 20px;
		padding: 15px 0;
		position: relative;
		text-align: center;
		text-decoration: none;
		user-select: none;
		-webkit-user-select: none;
		touch-action: manipulation;
		vertical-align: middle;
		white-space: nowrap;
	}

	</style>
</head>

<body>
	<table width="100%">
		<tr>
			<td style="background-color:#EFEFEF;">
				<!-- INICIO PLANTILLA -->

				<center>
					<table width="90%" class="tablealma">
						<tr>
							<td style="color: white; text-align: center; vertical-align: middle; padding: 40px 0; ">
								<img src="{{ asset('images/logo/logo-kanbai-color.png') }}" width="25%"> 
							</td>
						</tr>
						<tr>
							<td style="text-align: center; vertical-align: middle; padding: 40px 0 20px 0;">
								<h3 style="font: normal normal 600 20px/24px Montserrat;letter-spacing: 0px;color: #707070;opacity: 1;font-size: 20px;">¡Hola {{$user->name}} {{$user->lastname}}!</h3>
							</td>
						</tr>
						<tr>
							<td>
								<center>
									<table style="width: 90%;">
										<tr>
											<td align="center" style="background-color:#ffffff; font-family: 'Raleway', sans-serif;">
												<p style="color: #616161;font-size: 16px; margin-bottom: 0px;font-weight: 900;">Recibimos tu solicitud para restablecer la contraseña de tu cuenta en Kanbai.</p>
												<br>
												<p style="color: #616161;font-size: 16px;">Para crear una nueva contraseña y seguir disfrutando de una experiencia de compras corporativas más fácil y rápida, haz clic en el siguiente botón:</p>
												<br>
											</td>
										</tr>
									</table>
								</center>
							</td>
						</tr>
						
						<tr><td colspan="2" style="height:30px;">&nbsp;</td></tr>
						<tr>
							<td style="text-align: center; vertical-align: middle; background-color:#ffffff;">
								<a class="button-k" href="{{ $url }}" target="_blank" rel="noopener noreferrer" style="color: #fff !important; text-decoration: none;">Reestablecer contraseña</a>
							</td>
						</tr>
                        <tr><td colspan="2" style="height:30px;">&nbsp;</td></tr>
                        <tr>
							<td>
								<center>
									<table style="width: 90%;">
										<tr>
											<td align="center" style="background-color:#EFEFEF;border-radius: 18px; font-family: 'Raleway', sans-serif;">
												<p style="color: #616161;font-size: 16px; margin-bottom: 0px;font-weight: 900;">Importante:</p>
												<br>
												<p style="color: #616161;font-size: 16px;">Por tu seguridad, este enlace estará disponible solo por las próximas 24 horas. Si no solicitaste este cambio, simplemente ignora este mensaje.</p>
												<br>
											</td>
										</tr>
									</table>
								</center>
							</td>
						</tr>
						<tr>
							<td>
								<center>
									<table style="width: 90%;">
										<tr>
											<td align="center" style="background-color:#ffffff; font-family: 'Raleway', sans-serif;">												
												<p style="color: #616161;font-size: 16px;">¿Necesitas ayuda? Nuestro equipo de soporte está listo para asistirte.</p>
												<br>
											</td>
										</tr>
									</table>
								</center>
							</td>
						</tr>
						
						<tr>
							<td style="text-align: center; vertical-align: middle; background-color:#ffffff;">							
								<a class="btn-4" href="https://api.whatsapp.com/send?phone=3502045177&text=Hola, ..." target="_blank" rel="noopener noreferrer" style="color: #fff !important; text-decoration: none;">Contactar</a>							
							</td>
						</tr>
						<tr>
							<td>
								<center>
									<table style="width: 90%;">
										<tr>
											<td align="center" style="background-color:#ffffff; font-family: 'Raleway', sans-serif;">
												<p style="color: #616161;font-size: 16px; margin-bottom: 0px;">¡Gracias por confiar en Kanbai!</p>
												
												<p style="color: #616161;font-size: 16px;">Estamos aquí para hacer que tu gestión de compras sea más simple que nunca.</p>
												
												<p style="color: #616161;font-size: 16px;">Un saludo,</p>
												<p style="color: ##616161;font-size: 16px;font-weight: 900;">El equipo de Kanbai</p>
												
											</td>
										</tr>
									</table>
								</center>
							</td>
						</tr>
						<tr><td colspan="2" style="height:30px;">&nbsp;</td></tr>	
					</table>
				</center>

				<!-- FINAL PLANTILLA -->
				
			</td>
		</tr>
		
	</table>
	
</body>
</html>