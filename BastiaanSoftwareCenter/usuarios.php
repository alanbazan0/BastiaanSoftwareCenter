<?php
include 'php/clases/Utilidades.php';

$modulo = REQUEST('CNMDLSID');
$opcionTerminal = REQUEST('CNOTRMID');
$version = REQUEST('CNOTRMVER');
$usuario = REQUEST('CNUSERID');
$nomTrabajador = REQUEST('CNUSERDESC');
$usuarioDsc = REQUEST('CNUSERDESC');
$CNUSERDESC = REQUEST('CNUSERDESC');


?>
<html> 
<title>Catalogo de usuarios</title>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<script language="JavaScript" type="text/javascript" src="js/librerias/jquery-1.6.2.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="js/librerias/jquery-ui-1.8.16.custom.min.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/librerias/json2.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/librerias/AjaxContextHandler.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/librerias/Ajaxv2.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/librerias/prototype.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/librerias/funcionesFechas.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/librerias/funciones.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/librerias/funcionesColores.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/librerias/constantes.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/librerias/Eventos.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/librerias/Base.js"></script> 

	<script language="JavaScript" type="text/JavaScript" src="js/librerias/cargador.js"></script>
<!-- 	<script language="JavaScript" type="text/JavaScript" src="js/librerias/jquery.min.js"></script> -->
 	<script language="JavaScript" type="text/JavaScript" src='js/librerias/Datapickerjs/ui.core.js'></script>
	<script language="JavaScript" type="text/JavaScript" src='js/librerias/Datapickerjs/ui.datepicker.js'></script>
	<script language="JavaScript" type="text/JavaScript" src='js/librerias/Datapickerjs/ui.datepicker-es.js'></script> 
	
	<script language="JavaScript" type="text/JavaScript" src="js/componentes/GridReg.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/componentes/Combo.js"></script>
	
	<!-- Llamado de prompts
	<script language="JavaScript" type="text/javascript" src="../GV/prompts/PromptConcepto.js">  </script>
	<script language="JavaScript" type="text/javascript" src="../GV/prompts/PromptVerficador.js"></script>
	 
	-->
	<script language="JavaScript" type="text/javascript" src="prompts/PromptPostales.js"></script>
	
	<link type='text/css' href='js/librerias/Datapickerjs/ui.datepicker.css' rel='stylesheet' />
	<link type='text/css' href='js/librerias/Datapickerjs/demos.css' rel='stylesheet' />
	<link type='text/css' href='js/librerias/Datapickerjs/ui.all.css' rel='stylesheet' />

	<!--Estilo-->
    <link href="css/estilo.css" media="handheld, screen" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="css/imagenes/faviSIO.png">
    
   
    <script language="JavaScript" type="text/JavaScript" src="js/repositorios/usuarios_repositorio.js"></script>
    <script language="JavaScript" type="text/JavaScript" src="js/presentadores/usuarios_presentador.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/vistas/usuarios_vista.js"></script>

</head>

<body  bgcolor="#e8e8e8" onLoad="vista.onLoad()" style="overflow: auto;height: 89%;">
<div id="dialogo" title="Di�logo" style="display:none;">
</div>
<form id="form">
	<div id="principalDiv">
		
		<div id="debug" width="100%" style="display:none">
				<input type="hidden" id="RPFREPFINCNMDLSID"  name="RPFREPFINCNMDLSID"   value ='<?php echo $modulo; ?>'/>
				<input type="hidden" id="RPFREPFINCNOTRMID"  name="RPFREPFINCNOTRMID"   value ='<?php echo $opcionTerminal; ?>'/> 
				<input type="hidden" id="RPFREPFINCNOTRMVER" name="RPFREPFINCNOTRMVER"  value ='<?php echo $version; ?>'/>
				<input type="hidden" id="CNUSERID"           name="CNUSERID"            value ='<?php  echo $usuario; ?>>'/> 
				<input type="hidden" id="CNUSERDESC"           name="CNUSERDESC"            value ='<?php  echo $CNUSERDESC; ?>'/>    
		</div>
		
		<div id="estiloBotonesPeque" class="estiloBotonesPeque">
			<div id="contieneTuberiaIzq" class="contieneTuberiaIzq">
				<img src='assets/pantalla/logotipo.png' style="position:absolute; "/>
			</div>
			<div id="contieneCriteriosAriba" class="contieneCriteriosAriba">
				<div id="contieneCriteriosAribaBtn" class="contieneCriteriosAribaBtn">
					<div id="PMenu" align="center">
						<div id="botones" style="width:auto;overflow:auto;">
							<table class="tablaBotonesIEC">
								<tr>
									<td><img id="btnAlta" class="botonMenuIEC" title="Alta" src="assets/botones/imgAlta.png" onClick="vista.btnAlta_onClick();"></td>
									<td><img id="btnBaja" class="botonMenuIEC" title="Baja" src="assets/botones/imgBaja.png" onClick="vista.btnBaja_onClick();"></td>
									<td><img id="btnCambio" class="botonMenuIEC" title="Cambio" src="assets/botones/imgCambio.png" onClick="vista.btnCambio_onClick();"></td>
									<td><img id="btnConsulta" class="botonMenuIEC" title="Consulta" src="assets/botones/imgConsulta.png" onClick="vista.btnConsulta_onClick();"></td>
									<td><img id="btnSalir" class="botonMenuIEC" title="Salir"  src="assets/botones/btnSalir.png" onClick="vista.btnSalir_onClick();" ></td>
								</tr>
                             </table>   
						</div>
						<div id="titulo" style="margin-left:280px;" class="tituloIEC">Catálogo de usuarios</div>
					</div>
				</div>
            </div>        
	     </div>
	     
		 <div id="estiloBotonesInferior" class="estiloBotonesInferior" align="center">
				<div id="criteriosMetaT2" class="criteriosMeta">
					<div id="criteriosSeleccion0_t2" style="float:left; margin-top: 6px; margin-left: 10px;">
						<div>
							<table style="position:relative;left:40px; text-align:left; margin-top:10px; margin-bottom:10px;">
								<tr>
									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;"> Nombre completo</label></td>									
									<td style="padding:6px 0px 4px 10px;">		<input  id='nombreCompletoCriterioInput' type='text' style='height: 20px; width:200px;'/></input></td>
									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">RFC</label></td>
									<td style="padding:6px 0px 4px 10px;">		<input  id='rfcCriterioInput' type='text' style='height: 20px; width:200px;'/></input></td>	
									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">CURP</label></td>
									<td style="padding:6px 0px 4px 10px;">		<input  id='curpCriterioInput' type='text' style='height: 20px; width:200px;'/></input></td>		
								</tr>
								
							</table>
						</div>
					</div>
					
			
                </div>
		  </div>
		  
	       <div id="cargador" style="position:absolute;"></div>
		
			<div id="Pcontenido" style="position:relative;">            
				<div id="tabs" class="PcontenComp" style="display:block;"></div>
				<div id="paneles" class="PcontenComp" style="margin: auto; padding-left: 10px; padding-top: 0px; width: 99.5%; height: 90%; overflow: visible; position: relative;">
					<div id="panelesArea0" style="float:left; height:98%; width:98.5%;">
						<div id="panelesArea0paneles" class="PcontenComp" style="">
							<div id="panelesArea0panel0" class="contenedorIEC" style="width: 100%; height: 99.5%; z-index: 1; float: left; margin-right: 2px; margin-bottom: 2px; margin-left: 2px; overflow: hidden;">
								<div id="panelesArea0panel0barra" class="barracomandosContenedorIEC" style="position:relative;">
									<span id="panelesArea0panel0Titulo" class="tituloContenedorIEC"></span>	
								</div>
								<div id="panelesArea0panel0componentes" style="width:99%;height:99%;overflow:hidden;position:relative;">
                                	<div id="panelesArea0panel0componente0" style='overflow: auto; position:static;height:98%; width:100%; top:10px;left:3px;'>
                                	 		<div id="grid" style="float:left; overflow: auto; position:static; height:95%; width:100%; display: block; top:5px;left:3px;"></div>                						
                            		</div>
                           		</div>                                
							</div>
						</div>
					</div>					
				</div>								
			</div>	
    </div>
    
    

<div id="formularioDiv" style="display:none ;height: 90%;">
		<div>
			
<!--  barra de men� para botones de la pantalla
 -->
			<div id="menuPrincipal"  align="right" class="contieneCriteriosAribaBtn" style="background-color: #6b6b6b;    height: 56px; " > 
				<img class='logoBAS' style='float: left;' id='logoFRM' src='assets/pantalla/logotipo.png'  />
				<span id="txtTitulo" style="float:left;margin-top: 20px;margin-left: 15px;color: #FFFFFF;float: left;font-family: Verdana;font-size: 11px;font-weight: bold;">Catálogo de usuarios</span>
				<img style="padding: 2px;" class='imgTipoBoton' id='btnGuardarFormulario' src='assets/botones/imgGuardar.png' onclick='vista.btnGuardarFormulario_onClick();' title='Guardar' />
				<img style="padding: 2px;" class='imgTipoBoton' id='btnSalirFormulario' src='assets/botones/btnSalir.png' onClick="vista.btnSalirFormulario_onClick();" title='Salir'  />
			</div>
<!--
  barra de men�...fin
 -->
			
<!--barra principal -->
			<div id="cargador" class="cargadorFRM2" ></div>
				<div class="pContenido" id="estadoEstructura" >
						<div class="contenidoNormalUS">
					 		<div class="explicacionFRM" >
								<div id="filtros " class="contenedorIEC" style="overflow: auto; position: relative; width: 100%; display: block;">
								 <div style="width: 96%; display: block; height: 100%;  padding-top: 10px; padding-left: 34px;">								 	
								   <tr>
								   <table WIDHT=25%; HEIGHT=35%;  CELLPADDING=0; cellspacing="10" style="padding-top: 12px; padding-left: 1%; position:relative;display:inline-block; border: #ff6600 1px solid;">										
								 	   <td>
								   		<label style="position: relative; left: 180%; " >Datos del usuario</label>
								   		</td>
								   		<tr>
								   		<tr>
								    	 <td colspan = 18 style="border-top: #ff6600 1px solid;">
								    	 </td>
								    	 </tr>
								    	 <td>
								     		<label style="position: relative; left: 3px; ">Id de usuario</label>
								   		</td>
								   		<td>
								     		<input class="input" id="idFormularioInput" descripcion="Id usuario" style="width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		<td>
								     		<label style="position: relative; left: 3px; "><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Contraseña de usuario</font></font></label>
								   		</td>
								   		<td>
								     		<input class="input" id="passwordFormularioInput" descripcion="Password usuario" style=" width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999; "/>
								   		</td>
								        </tr>
								   		<tr>
								    	<td >
								     		<label style="position: relative; left: 3px; "> Primer nombre</label>
								   		</td>
								   		<td >
								     		<input class="input" id="primerNombreFormularioInput" descripcion="Primer nombre" style="width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		<td>						    
								    		<label style="position: relative; left: 3px; ">Segundo nombre</label>
								   		</td>
								   		<td>						    
								    		<input class="input" id="segundoNombreFormularioInput" style="width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								  		<td>	
								    		<label style="position: relative; left: 3px; ">Apellido Paterno</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="apellidoPaternoFormularioInput" style="width:135px; font-family:Verdana; font-size:9px; text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		<td>	
								    		<label style="position: relative; left: 3px;  ">Apellido Materno</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="apellidoMaternoFormularioInput" style=" width:135px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; right: 3px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		<tr>
								   		<td>	
								    		<label style="position: relative; left: 3px; ">Nombre completo</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="nombreCompletoFormularioInput" style=" width:300%; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;" disabled/>
								   		</td>
								   		</tr>
								   		<tr>
								   		<td >
								     		<label style="position: relative; left: 3px; ">Genero</label>
								   		</td>
								   		<td >
								     		<select class="input" id="idGeneroFormularioInput" descripcion="Id genero" style=" width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999; "/>
								     		<OPTION VALUE="Seleccionar">Seleccionar genero</OPTION>
											<OPTION VALUE="H">H</OPTION>
											<OPTION VALUE="M">M</OPTION>
											</select>
								   		</td>
								        <td>	
								    		<label style="position: relative; left: 3px;">Nacionalidad</label>
								   		</td>
								   		<td>
								    		<select class="input" id="nacionalidadFormularioInput" style="width:150px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; right: 34%; box-shadow: 2px 2px 5px #999;"/>
								   			<OPTION VALUE="Seleccionar">Seleccionar nacionalidad</OPTION>
											<OPTION VALUE="MEXICANA">MEXICANA</OPTION>
											<OPTION VALUE="EXTRANJERA">EXTRANJERA</OPTION>
											</select>
								   		</td>
								   		<td>	
								    		<label style="position: relative; left: 3px;">Fecha de nacimiento</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="fechaNacimientoFormularioInput" style="width:80px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		</tr>
								   		</table>
    								    <table WIDHT=25px; HEIGHT=35%;  CELLPADDING=0; cellspacing="10" style="top: 2px; padding-left: 1%; position:relative;display:inline-block; border: #ff6600 1px solid  ">								  								   
    								    <td>
								   		<label style="position: relative; left: 130%;">Datos para contactar al usuario</label></tr>
								   		</td>
								   		<tr>
								    	 <td colspan = 18 style="border-top: #ff6600 1px solid;">
								    	 </td>
								    	 </tr>
    								    <tr>
    								    <td>
    								    	<label style="position: relative; left: 3px; ">Correo electronico de empresa</label>
    								    </td>
    								     <td>
    								    	<input class="input" id="correoElectronicoEmpresaFormularioInput" style="width:250%; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
    								    </td>
    								    </tr>
    								    <tr>
    								    <td>
    								    	<label style="position: relative; left: 3%; ">Correo electronico personal</label>
    								    </td>
    								     <td>
    								    	<input class="input" id="correoElectronicoPersonalFormularioInput" style="width:250%; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
    							  	    </td>
								        </tr>
								        <tr>
								        <td>
    								    	<label style="position: relative; left: 3px; ">Numero de telefono celular</label>
    								    </td>
    								    <td>
    								    	<input class="input" id="telefonoCelularFormularioInput" style=" width:169px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
    								    </td>
    								    <td>
    								    <td>
    								    	<label style="position: relative; left: 3px; ">Numero de telefono de casa</label>
    								    </td>
    								    <td>
    								    	<input class="input" id="telefonoCasaFormularioInput" style=" width:165px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
    								    </td>
    								    <td>
    								    	<label style="position: relative; left: 3px; ">Numero de telefono de contacto</label>
    								    </td>
    								    <td>
    								    	<input class="input" id="telefonoContactoFormularioInput" style=" width:161px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; right: 3px; box-shadow: 2px 2px 5px #999;"/>
    								    </td>
    								    </tr>
								   </table>
								   </tr>
								   <tr>
								   <table WIDHT=25%; HEIGHT=30%;  CELLPADDING=0; cellspacing="10" style="top: 6px; padding-left: 1%; position:relative;display:inline-block;  border:#ff6600 1px solid ">								  		
								    	<td>
								   		<label style="position: relative; left: 130%;">Dirección del usuario</label></tr>
								   		</td>
								   		<tr>
								    	 <td colspan = 18 style="border-top: #ff6600 1px solid;">
								    	 </td>
								    	 </tr>
								   		<tr>
								   		<td>
								   			<label style="position: relative; left: 3px; ">Calle</label>
								   		</td>
								   		<td>
								   			<input class="input" id="calleFormularioInput" style="width:130px; font-family:Verdana; font-size:9px; text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>	
								   		<td>		
								    		<label style="position: relative; left: 3px;">Numero exterior</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="numeroExteriorFormularioInput" style="width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		<td>
								   			 <label style="position: relative; left: 3px; ">Numero interior</label>
								   		</td>
								   		<td>
								   			 <input class="input" id="numeroInteriorFormularioInput" style="width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>	
								   		<td>
								   			<label style="position: relative; left: 3px; ">Colonia</label>
								   		</td>
								   		<td>
								   			<input class="input" id="coloniaFormularioInput" style=" width:148px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; right: 3px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		<tr>
								    	<td>	
								    	<label style="position: relative; left: 3px;">Codigo Postal</label>
								    	<img src='css/imagenes/asisFRM.png' onClick="vista.verDatosAsis();" title='Asistente Postales'> 
								   		</td>
								   		<td>	
								    		<input class="input" id="codigoPostalFormularioInput" style="width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>								   		
								   		</td>
    								    <td>
    								    	<label style="position: relative; left: 3px; ">Estado</label>
    								    </td>
    								    <td>
    								    	<input class="input" id="estadoFormularioInput" style=" width:230px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
    								    </td>
    								     <td>
    								    	<label style="position: relative; left: 3px; ">Ciudad</label>
    								    </td>
    								    <td>
    								    	<input class="input" id="ciudadFormularioInput" style=" width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; right: 30%; box-shadow: 2px 2px 5px #999;"/>
    								    </td>
    								    <td>
    								    	<label style="position: relative; left: 3px; ">Pais</label>
    								    </td>
    								    <td>
    								    	<input class="input" id="paisFormularioInput" style=" width:80px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
    								    </td>
    								    </tr>
    								    <tr>
    								     <td>
    								    	<label style="position: relative; left: 3px; ">Dirección completa</label>
    								    </td>
    								     <td>
    								    	<input class="input" id="direccionFormularioInput" style=" width:500%; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
    								    </td>
    								    </tr>
    								    </table>
    								    </tr>
    								    <tr>
    								    <tr>
    								    <table WIDHT=25%; HEIGHT=35%;  CELLPADDING=0; cellspacing="10" style="top: 10px; padding-left: 1%; position:relative;display:inline-block; border: #ff6600 1px solid;"> 
								   		<tr>
								   		<td>
								   		<label style="position: relative; left: 100%;">Datos de identificación del usuario</label></tr>
								   		</td>
								   		<tr>
								    	 <td colspan = 18 style="border-top: #ff6600 1px solid;">
								    	 </td>
								    	 </tr>
								  		<td>	
								    		<label style="position: relative; right:120px;">RFC</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="rfcFormularioInput" style="width:250px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; right: 50%; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		</tr>
								   		<tr>
								   		<td>	
								    		<label style="position: relative; right:100px;">NSS</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="nssFormularioInput" style="width:250px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; right: 50%; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		</tr>
								   		<tr>
								   		<td>	
								    		<label style="position: relative; left: 3px;">CURP</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="curpFormularioInput" style=";width:250px; font-family:Verdana; font-size:9px; text-align:left; color:#006699;position: relative; right: 50%; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								     	</tr>
								    	</table>
								    	<table WIDHT=25%; HEIGHT=35%;  CELLPADDING=0; cellspacing="10" style="top: 10px; left: 1px; position:relative;display:inline-block; border: #ff6600 1px solid;"> 
								    	<td>
    								    	<label style="position: relative; left: 130%;text-align:center;">Datos para la empresa</label>
    								    </td>
    								    <tr>
								    	 <td colspan = 18 style="border-top: #ff6600 1px solid;">
								    	 </td>
								    	 </tr>
								    	<tr>
    								    <td>
    								    	<label style="position: relative; left: 3px; ">Numero de empleado</label>
    								    </td>
    								    <td>
    								    	<input class="input" id="numeroEmpleadoFormularioInput" style=" width:155px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
    								    </td>
    								    <td>	
								    		<label style="position: relative; left: 6px;">Fecha de ingreso</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="fechaIngresoFormularioInput" style="width:151px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; right: 3px; box-shadow: 2px 2px 5px #999; "/>
								   		</td>
								   		</tr>
								   		<tr>
								   		<td>	
								    		<label style="position: relative; left: 3px;">Tipo de banco</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="tipoBancoFormularioInput" style="width:155px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		<td>	
								    		<label style="position: relative; left: 6px;">Clave bancaria</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="claveBancariaFormularioInput" style="width:151px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative;  right: 3px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		</tr>
								   		<tr>
								   		<td>	
								    		<label style="position: relative; left: 3px;">Sueldo</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="sueldoFormularioInput" style="width:155px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999; "/>
								   		</td>
								   		<td>	
								    		<label style="position: relative; left: 6px;">Extensión de usuario</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="extensionUsuarioFormularioInput" style="width:151px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; right: 3px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		</tr>
								   		<tr>
								   		 <td>	
								    		<label style="position: relative; left: 3px;">Id de baja</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="idBajaFormularioInput" style="width:155px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								   		<td>	
								    		<label style="position: relative; padding-left: 6px;">Fecha de baja</label>
								   		</td>
								   		<td>	
								    		<input class="input" id="fechaBajaFormularioInput" style="width:151px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; right: 3px; box-shadow: 2px 2px 5px #999;"/>
								   		</td>
								    </tr>
								    </table>
									</div>
								 </div>
								</div>				  	
							</div>
						</div>
				</div>
</div>
		<div class='ventana' id='PromptPostal' style='display: none;'></div>
		<div class='ventana' id='PromptListaDistribucion' style='display: none; z-index:9001;'></div>
		<div class='ventana' id='_promptRelacionReporte' style='display: none;'></div>
		<div class='ventana' id='PromptCalendario' style='display: none; z-index:9001;'></div>  
		<div class='ventana' id='promptListaRelaciones' style='display: none;'></div>
		<div class='ventana' id='PromptPlantilla' style='display: none; z-index:9001;'></div>
		<div class='ventana' id='PromptCorreo' style='display: none;'></div>
		<div class='ventana' id='PromptSentencia' style='display:none; z-index:9001;'></div>
		<div class='ventana' id='PromptCriterioSeleccion' style='display:none; z-index:9001;'></div>
</form>
</body>
</html>