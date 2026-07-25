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
			font-family: "Raleway", sans-serif;	
			font-size: 16px;
			font-weight: bold;
			font-weight: 700;
			font-family: "Raleway", sans-serif;
		}
		.txtdetalle, .txtdetalle span{
			font-size: 11px;
			font-family: "Raleway", sans-serif;
			line-height: 2em;
		}
		.tablealma{
			background-color: #ffffff;
	        border-radius: 45px;
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
			width: 70%;
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
			font-size: 12px;
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
							<td style="background-color:#231B71; color: white; text-align: center; vertical-align: middle; padding: 40px 0; ">
								<img src="{{ asset('images/logo-alma-linea-empresas.png') }}" width="25%">
							</td>
						</tr>
						<tr>
							<td style="text-align: center; vertical-align: middle; padding: 40px 0 20px 0;">
								<h3>¡Hola {{ $data['name'] }}!</h3>
							</td>
						</tr>
						<tr>
							<td>
								<center>
									<table style="width: 90%;">
										<tr>
											<td align="center" style="background-color:#ffffff; font-family: 'Raleway', sans-serif;">
												Hemos recibido tu solicitud de cotizacion y nos encontramos trabajando en ella.
												<br>
												Tu cotizacion será enviada por este mismo medio en un plazo máximo de 12 horas
												<br><br>
												Si tienes alguna duda o requieres ayuda de nuestra parte, puedes dar clic al botón para comuncarte con nuestro equipo. 
											</td>
										</tr>
									</table>
								</center>
							</td>
						</tr>
						<tr><td colspan="2" style="height:30px;">&nbsp;</td></tr>
						<tr>
							<td style="text-align: center; vertical-align: middle; background-color:#ffffff;">
								<a class="button-3" href="https://wa.me/573502045177">Contactar</a>
							</td>
						</tr>
						<tr><td colspan="2" style="height:30px;">&nbsp;</td></tr>
						<tr>
							<td style="background-color:#ffffff; text-align: center;">
								<center>
									<table width="90%" class="tablealmainterna" cellspacing="0" cellpadding="0">
										<tr>
											<td width="10%" style="background-color:#CDCBCB;"></td>
											<td width="70%" style="background-color:#CDCBCB; vertical-align: middle;"><h3>Número de Solicitud:</h3></td>
											<td width="20%"style="background-color:#CDCBCB; vertical-align: middle;"><h3>#{{ $data['idsolicitud'] }}</h3></td>
										</tr>
									</table>
								</center>
							</td>
						</tr>
						<tr>
							<td style="background-color:#ffffff;">
								<center>
									<table width="90%" class="tablealmainterna">
										@foreach($producto as $item)
										<tr>
											<td width="30%" style="text-align: center; vertical-align: middle;">
											@php
											$imagen = $item['urlfoto'];
											@endphp
												<img class="imagenpro" src="{{ asset('images/products/'.$imagen.'') }}" /> 
											</td>
											<td width="70%" style="vertical-align: top;">
												<span class="titprod">{{ $item['name'] }}</span>
												<br>
												<span class="txtdetalle">
													Fecha de entrega: <span style="color:#1FD161">{{ $data['fecha'] }}</span>
													<br>
													Cantidad a cotizar: <span style="color:#1FD161">{{ $item['quantity'] }}</span>
												</span>
											</td>
										</tr>
										@endforeach
										<tr><td colspan="2" style="height:30px;">&nbsp;</td></tr>
										<tr>
											<td colspan="2">
												<span class="obser"><b>Observaciones: </b> {{ $data['observations'] }}</span> 
											</td>
										</tr>
									</table>
								</center>
							</td>
						</tr>
						<tr><td style="height:80px;">&nbsp;</td></tr>
					</table>
				</center>

				<!-- FINAL PLANTILLA -->
				
			</td>
		</tr>
		
	</table>
	
</body>
</html>