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
<title>Cat�logo de clientes</title>
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
	
	<link type='text/css' href='js/librerias/Datapickerjs/ui.datepicker.css' rel='stylesheet' />
	<link type='text/css' href='js/librerias/Datapickerjs/demos.css' rel='stylesheet' />
	<link type='text/css' href='js/librerias/Datapickerjs/ui.all.css' rel='stylesheet' />

	<!--Estilo-->
    <link href="css/estilo.css" media="handheld, screen" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="css/imagenes/faviSIO.png">
    
   
    <script language="JavaScript" type="text/JavaScript" src="js/repositorios/clientes_repositorio.js"></script>
    <script language="JavaScript" type="text/JavaScript" src="js/presentadores/clientes_presentador.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/vistas/clientes_vista.js"></script>

    
</head>

<body  bgcolor="#e8e8e8" onLoad="vista.onLoad()" style="overflow: auto;height: 89%;">
<div id="dialogo" title="Di�logo" style="display:none;">
</div>
<form id="form">
	<div id="principal">
		
		<div id="debug" width="100%" style="display:none">
				<input type="hidden" id="RPFREPFINCNMDLSID"  name="RPFREPFINCNMDLSID"   value ='<?php echo $modulo; ?>'/>
				<input type="hidden" id="RPFREPFINCNOTRMID"  name="RPFREPFINCNOTRMID"   value ='<?php echo $opcionTerminal; ?>'/> 
				<input type="hidden" id="RPFREPFINCNOTRMVER" name="RPFREPFINCNOTRMVER"  value ='<?php echo $version; ?>'/>
				<input type="hidden" id="CNUSERID"           name="CNUSERID"            value ='<?php  echo $usuario; ?>>'/> 
				<input type="hidden" id="CNUSERDESC"           name="CNUSERDESC"            value ='<?php  echo $CNUSERDESC; ?>'/>    
		</div>
		
		<div id="estiloBotonesPeque" class="estiloBotonesPeque">
			<div id="contieneTuberiaIzq" class="contieneTuberiaIzq">
				<img src='assets/pantalla/imgCabecero.png' style="position:absolute; "/>
			</div>
			<div id="contieneCriteriosAriba" class="contieneCriteriosAriba">
				<div id="contieneCriteriosAribaBtn" class="contieneCriteriosAribaBtn">
					<div id="PMenu" align="center">
						<div id="botones" style="width:auto;overflow:auto;">
							<table class="tablaBotonesIEC">
								<tr>
									<td><img id="btnAlta" class="botonMenuIEC" title="Alta" src="assets/botones/imgAlta.png" onClick="btnAlta_onClick();"></td>
									<td><img id="btnBaja" class="botonMenuIEC" title="Baja" src="assets/botones/imgBaja.png" onClick="btnBaja_onClick();"></td>
									<td><img id="btnCambio" class="botonMenuIEC" title="Cambio" src="assets/botones/imgCambio.png" onClick="btnCambio_onClick();"></td>
									<td><img id="btnConsulta" class="botonMenuIEC" title="Consulta" src="assets/botones/imgConsulta.png" onClick="vista.btnConsulta_onClick();"></td>
									<td><img id="btnSalir" class="botonMenuIEC" title="Salir"  src="assets/botones/btnSalir.png" onClick="btnSalir_onClick();" ></td>
								</tr>
                             </table>   
						</div>
						<div id="titulo" style="margin-left:280px;" class="tituloIEC">Cat�logo de clientes</div>
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
									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">  Id </label></td>									
									<td style="padding:6px 0px 4px 10px;">		<input  id='idInput' type='text' style='height: 20px; width:200px;'/></input></td>
									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">Nombre</label></td>
									<td style="padding:6px 0px 4px 10px;">		<input  id='nombreInput' type='text' style='height: 20px; width:200px;'/></input></td>
									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">Apellido paterno</label></td>
									<td style="padding:6px 0px 4px 10px;">		<input  id='apellidoPaternoInput' type='text' style='height: 20px; width:200px;'/></input></td>			
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
    
    

<div id="altaCambioDiv" style="display:none ;height: 90%;">
		<div>
			
<!--  barra de men� para botones de la pantalla
 -->
			<div id="menuPrincipal"  align="right" class="contieneCriteriosAribaBtn" style="background-color: #6b6b6b;    height: 56px; " > 
				<img class='logoBAS' style='float: left;' id='logoFRM' src='assets/pantalla/imgCabecero.png'  />
				<span id="txtTitulo" style="float:left;margin-top: 20px;margin-left: 15px;color: #FFFFFF;float: left;font-family: Verdana;font-size: 11px;font-weight: bold;">VERIFICADOR</span>
				<img style="padding: 2px;" class='imgTipoBoton' id='btnGuardarAltaSol' src='assets/botones/imgGuardar.png' onclick='guardarViaticosVerificar();' title='Guardar y aprobar' />
				<img style="padding: 2px;" class='imgTipoBoton' id='btnSalirAltaSol' src='assets/botones/btnSalir.png' onClick="salirSolicitante();" title='Salir'  />
			</div>
<!--
  barra de men�...fin
 -->
			
<!--barra principal -->
			<div id="cargador" class="cargadorFRM2"></div>
				<div class="pContenido" id="estadoEstructura" >
						<div class="contenidoNormalUS">
					 		<div class="explicacionFRM" >
								<div id="filtros " class="contenedorIEC" style="overflow: auto; position: relative; width: 100%; display: block;">
								 <div style="width: 80%; display: block; height: 133px;  padding-top: 10px; padding-left: 34px;">
									<table style="margin-left: 5px; position:relative;left:0px; text-align:left;">
										<tr>
										 <td><label style="position: relative; left: 3px">No. Solicitud</label>
	                        				<span style="position: relative; left: 2px">
	                        					<input class="input" id="noSolicitud" type="text" maxlength="20" value="" style="width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;" disabled />
	                            			</span></td>
	                                   		 <td><label style="position: relative; left: 6px; padding-left: 35px;">Tipo de movimiento</label>
	                        				<span style="position: relative; left: 2px">
	                        					<input class="input" id="tipoMovimientoAltaSol" type="text" value="" maxlength="180"  style="width:100px; font-family:Verdana; font-size:9px; margin-left: 8px; text-align:left; color:#006699;" disabled/>
	                            			</span>
	                            			<span style="position: relative; left: 2px">
	                        						<input class="input" id="desMovimientoAltaSol" type="text" value="" maxlength="180" style="width:180px; font-family:Verdana; font-size:9px; margin-left: 11px; text-align:left; color:#006699;" disabled/>
	                            			</span>
	                            			</td>	                               									
											<td>
												
	                            			</td>
										</tr>
										<tr>
													 <td> <p></p><p></p><p></p></td> 
										</tr>
										<tr>
										 <td><label style="position: relative; left: 3px; ">Solicitante</label>
	                        				<span style="position: relative; left: 11px">
	                        					<input class="input" id="noCliente" type="text" maxlength="20" value='<%= usuario %>' style="width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;" disabled/>
	                            			</span>
	                            		 </td>
	                                   	 <td>
	                                   		 <label style="position: relative; left: 3px; padding-left: 35px;">Nombre</label>
	                        				<span style="position: relative; left: 60px">
	                        					<input class="input" id="desTrabajador" type="text" value='<%= nomTrabajador %>' maxlength="180" style="width:250px; font-family:Verdana; font-size:9px; margin-left: 8px; text-align:left; color:#006699;" disabled/>
	                            			</span>
	                            			
	                            			</td>	                               									
											<td>
											    <label style="position: relative; left: 3px; padding-left: 0px">Estatus</label>
												<span style="position: relative; left: 55px">
	                        						<input class="input" id="tipEstatus" type="text" value="SOLICITADO" maxlength="180" style="width:100px; font-family:Verdana; font-size:9px; margin-left: 11px; text-align:left; color:#006699;" disabled/>
	                            				</span>
	                            			</td>
										</tr>
										<tr>
													 <td> <p></p><p></p><p></p></td> 
										</tr>
										<tr>
										 <td><label style="position: relative; left: 6px;">Fecha inicio</label>
	                        				<span style="position: relative; left: 5px">
	                        					<input class="input" id="fechaInicioAltaSol" type="text" maxlength="20" value="" style="width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;"/>
	                            			</span></td>
	                                   		 <td><label style="position: relative; left: 3px; padding-left: 35px">Fecha final</label>
	                        				<span style="position: relative; left: 44px">
	                        					<input class="input" id="fechafinAltaSol" type="text" value="" maxlength="180" style="width:130px; font-family:Verdana; font-size:9px; margin-left: 8px; text-align:left; color:#006699;"/>
	                            			</span>
	                            				
	                            			
	                            			</td>	                               									
											<td>
											   <label style="position: relative; left: 3px; padding-left: 0px">Fecha transaccion</label>
												<span style="position: relative; left: 2px">
	                        						<input class="input" id="fechaTransaccionAltaSol" type="text" value="" maxlength="180" style="width:130px; font-family:Verdana; font-size:9px; margin-left: 11px; text-align:left; color:#006699;" disabled/>
	                            				</span>
	                            			</td>
										</tr>
										<tr>
													 <td> <p></p><p></p><p></p></td> 
										</tr>
										<tr>
										 <td>
										   <label style="position: relative; left: 3px; ">Origen</label>
	                        				<span style="position: relative; left: 30px">
	                        					<select class="input" id="ciudadOrigenAltaSol" type="text" maxlength="20" value="" style="width:180px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;"/>
	                            			</span>
	                            		 </td>
	                                   		                                									
										<td><label style="position: relative; left: 3px; margin-left: 35px;">Destino</label>
												<span style="position: relative; left: 58px">
	                        						<select class="input" id="ciudadDestinoAltaSol" type="text" value="" maxlength="180" style="width:180px; font-family:Verdana; font-size:9px; margin-left: 11px; text-align:left; color:#006699;"/>
	                            				</span>      				
	                            				                        				
	                            		</td>
	                            			<td>
	                            			    <label style="position: relative; left: 3px; padding-left: 0px;">Verificador</label>
												<span style="position: relative; left: 38px">
													<input class="input" id="txtVerificador" type="text" value='<%= usuario %>'maxlength="180" style="width:130px; font-family:Verdana; font-size:9px; margin-left: 11px; text-align:left; color:#006699;" disabled/>
	                        					</span>  
	                        					<span style="position: relative; left: 37px">
	                        						<input class="input" id="txtVerificadorDsc" type="text" value='<%= nomTrabajador %>' maxlength="180" style="width:150px; font-family:Verdana; font-size:9px; margin-left: 11px; text-align:left; color:#006699;" disabled/>
	                        						
	                            				</span> 
	                            			</td>
										</tr>
									</table>
									
								 </div>
								</div>
								<div id="panelGridAltaSolicitud" class=" PMenuAsistente" style="padding-top: 17px; margin-top: 12px; position: relative;  width:100%;display: block; float: left; height:78%; ">
										<div id="panelGridAltaSolicitud" style="float:left; overflow: auto; position:static; height:53%; width:100%; display: block; top:10px;left:3px;"></div>
								 </div>					  	
							</div>
						</div>
				</div>
		</div>
		<div class='ventana' id='PromptConcepto' style='display: none;'>
			<div class='panelAsistenteFRM' style=' width:650px;   height: 500px;  margin-left: 325px; left: 50%; top: 50%;'> 
				<div style='display: block; margin-top: 8px; width: 100%;'> 
							<img id='btnSalirConceptos' onClick='salirConceptos();' src='assets/botones/btnSalir.png'> 
						</div> 
						<div id='panelCarArchivo' class='' style='position: relative; width: 100%; display: block;  height: 94%; margin-top: 9px;'> 
							<div id='panelCarArchivoLD' style=' overflow: auto; position:static;height:94%; width:100%; display: block; top:10px;left:3px;'> 
								<div class='PMenuAsistente' style='width: 99%;  margin-top: 0px; text-align: center; height: 99%;'> 
									<span style='font-size: 14px;'>Conceptos</span> 
										<div class='fondoPlata' style='overflow: auto; width: 99%; display: block ;margin-top:1px;margin-left:5px;'> 
											<div id='areaConcepto' style='    display: block;'> 
												<div id="dgConceptosAltaSolicitud" style="float:left; overflow: auto; position:static; height:53%; width:100%; display: block; top:10px;left:3px;"></div>
											</div> 
										</div> 
								</div> 
							</div> 
						</div> 
				</div>  
		</div>
		<div class='ventana' id='PromptSubConcepto' style='display: none;'>
			<div class='panelAsistenteFRM' style=' width:650px;   height: 500px;  margin-left: 325px; left: 50%; top: 50%;'> 
				<div style='display: block; margin-top: 8px; width: 100%;'> 
							<img id='btnSalirSubConceptos' onClick='salirSubConceptos();' src='assets/botones/btnSalir.png'> 
						</div> 
						<div id='panelCarArchivoSbCon' class='' style='position: relative; width: 100%; display: block;  height: 94%; margin-top: 9px;'> 
							<div id='panelCarArchivoLDSbCon' style=' overflow: auto; position:static;height:94%; width:100%; display: block; top:10px;left:3px;'> 
								<div class='PMenuAsistente' style='width: 99%;  margin-top: 0px; text-align: center; height: 99%;'> 
									<span style='font-size: 14px;'>Sub Conceptos</span> 
										<div class='fondoPlata' style='overflow: auto; width: 99%; display: block ;margin-top:1px;margin-left:5px;'> 
											<div id='areaSubConcepto' style='    display: block;'> 
												<div id="dgSbConceptosAltaSolicitud" style="float:left; overflow: auto; position:static; height:53%; width:100%; display: block; top:10px;left:3px;"></div>
											</div> 
										</div> 
								</div> 
							</div> 
						</div> 
				</div> 
		
		</div>
		<div class='ventana' id='PromptListaDistribucion' style='display: none; z-index:9001;'></div>
		<div class='ventana' id='_promptRelacionReporte' style='display: none;'></div>
		<div class='ventana' id='PromptCalendario' style='display: none; z-index:9001;'></div>  
		<div class='ventana' id='promptListaRelaciones' style='display: none;'></div>
		<div class='ventana' id='PromptPlantilla' style='display: none; z-index:9001;'></div>
		<div class='ventana' id='PromptCorreo' style='display: none;'></div>
		<div class='ventana' id='PromptSentencia' style='display:none; z-index:9001;'></div>
		<div class='ventana' id='PromptCriterioSeleccion' style='display:none; z-index:9001;'></div>    
</div>

    
    
    
    
    
    
    
    
</form>
</body>
</html>