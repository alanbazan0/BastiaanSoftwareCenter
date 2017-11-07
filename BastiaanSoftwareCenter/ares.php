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
<title>Catalogo de areas</title>
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
    
   
    <script language="JavaScript" type="text/JavaScript" src="js/repositorios/ares_repositorio.js"></script>
    <script language="JavaScript" type="text/JavaScript" src="js/presentadores/ares_presentador.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/vistas/ares_vista.js"></script>

    
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
				<img src='assets/pantalla/logoTipo.png' style="position:absolute; "/>
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
						<div id="titulo" style="margin-left:280px;" class="tituloIEC">Estrectura de areas</div>
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
									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">Nombre</label></td>									
									<td style="padding:6px 0px 4px 10px;">		<input  id='idAreaCriterioInput' type='text' style='height: 20px; width:200px;'/></input></td>
									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">Descripcion</label></td>
									<td style="padding:6px 0px 4px 10px;">		<input  id='nombreAreaCriterioInput' type='text' style='height: 20px; width:200px;'/></input></td>			
								</tr>
								<tr>
									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">Tipo estructura</label></td>									
									<td style="padding:6px 0px 4px 10px;">		<select   id='tipoEstructura' type='text' style='height: 20px; width:200px;'/></select></td>		
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
				<img class='logoBAS' style='float: left;' id='logoFRM' src='assets/pantalla/logoTipo.png'  />
				<span id="txtTitulo" style="float:left;margin-top: 20px;margin-left: 15px;color: #FFFFFF;float: left;font-family: Verdana;font-size: 11px;font-weight: bold;">Estructuras de areas</span>
				<img style="padding: 2px;" class='imgTipoBoton' id='btnGuardarFormulario' src='assets/botones/imgGuardar.png' onclick='vista.btnGuardarFormulario_onClick();' title='Guardar' />
				<img style="padding: 2px;" class='imgTipoBoton' id='btnSalirFormulario' src='assets/botones/btnSalir.png' onClick="vista.btnSalirFormulario_onClick();" title='Salir'  />
			</div>
<!--
  barra de men�...fin
 -->
			
<!--barra principal -->
			<div id="cargador" class="cargadorFRM2"></div>
				<div class="pContenido" id="estadoEstructura" >
				
				 <div id="estiloBotonesInferior" class="estiloBotonesInferior" align="center">
        				<div id="criteriosMetaT2" class="criteriosMeta">
        					<div id="criteriosSeleccion0_t2" style="float:left; margin-top: 6px; margin-left: 10px;width:99%;">
        						<div >
        							<div class="tab">
                                      <button class="tablinks" onclick="vista.abirTab(event, 'Basico')">Basico</button>
                                      <button class="tablinks" onclick="vista.abirTab(event, 'BPM')">Clasificadores para BPM</button>
                                    </div>
                                    
                                    <div id="Basico" class="tabcontent">
                                      <div id="estiloBotonesInferior" class="estiloBotonesInferior" align="center">
                                		  <div id="criteriosMetaT2" class="criteriosMeta">
                                					<div id="criteriosSeleccion0_t2" style="float:left; margin-top: 6px; margin-left: 10px;">
                                						<div>
                                							<table style="position:relative;left:40px; text-align:left; margin-top:10px; margin-bottom:10px;">
                                								<tr>
                                									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">Nombre largo</label></td>									
                                									<td style="padding:6px 0px 4px 10px;">		<input  id='idAreaCriterioInput2' type='text' style='height: 20px; width:200px;'/></input></td>
                                									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">Nombre corto</label></td>
                                									<td style="padding:6px 0px 4px 10px;">		<input  id='nombreAreaCriterioInput2' type='text' style='height: 20px; width:200px;'/></input></td>			
                                								</tr>
                                								<tr>
                                								    <td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">Estructura vertical apartir del nivel</label></td>									
                                									<td style="padding:6px 0px 4px 10px;">		<input  id='idNivel' type='text' style='height: 20px; width:80px;'/></input></td>
                                									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">Tipo estructura</label></td>									
                                									<td style="padding:6px 0px 4px 10px;">		<select   id='tipoEstructura2' type='text' style='height: 20px; width:200px;'/></select></td>		
                                								</tr>                                								
                                							</table>
                                						</div>
                                					</div>                                					
                                			</div>
                                		  </div>
                                    </div>
                                    
                                    <div id="BPM" class="tabcontent">
                                      <h3>PBPM</h3>
                                      <p>Paris is the capital of France.</p> 
                                    </div>
        						</div>
        					</div>       			
                          </div>
		  			</div>
		  
						<div class="contenidoNormalUS">
					 		<div class="explicacionFRM" >
								<div id="filtros " class="contenedorIEC" style="overflow: auto; position: relative; width: 100%; display: block;">
								 <div style="width: 97%; display: block; height: 86%;  padding-top: 0px; padding-left: 34px;">
								 							  
								    	   <div id="panelesArea0" style="float:left; height:98%; width: 50%;margin-left: -25px;">
                        						<div id="panelesArea0paneles" class="PcontenComp" style="">
                        							<div id="panelesArea0panel0" class="contenedorIEC" style="width: 100%; height: 99.5%; z-index: 1; float: left; margin-right: 2px; margin-bottom: 2px; margin-left: 2px; overflow: hidden;">
                        								<div id="panelesArea0panel0barra" class="barracomandosContenedorIEC" style="position:relative;">
                        									<span id="panelesArea0panel0Titulo" class="tituloContenedorIEC">Estructuras areas</span>	
                        								</div>
                        								<div id="panelesArea0panel0componentes" style="width:99%;height:99%;overflow:hidden;position:relative;">
                                                        	<div id="panelesArea0panel0componente0" style='overflow: auto; position:static;height:98%; width:100%; top:10px;left:3px;'>
                                                        	 		             						
                                                    		</div>
                                                   		</div>                                
                        							</div>
                        						</div>
                        					</div> 	
                        					<div id="panelesArea1" style="float:left; height:98%; width: 50%;margin-left: 23px;">
                        						<div id="panelesArea0paneles" class="PcontenComp" style="">
                        							<div id="panelesArea0panel0" class="contenedorIEC" style="width: 100%; height: 99.5%; z-index: 1; float: left; margin-right: 2px; margin-bottom: 2px; margin-left: 2px; overflow: hidden;">
                        								<div id="panelesArea0panel0barra" class="barracomandosContenedorIEC" style="position:relative;">
                        									<span id="panelesArea0panel0Titulo" class="tituloContenedorIEC">Lista de areas de trabajo</span>	
                        								</div>
                        								<div id="panelesArea0panel0componentes" style="width:99%;height:99%;overflow:hidden;position:relative;">
                                                        	<div id="panelesArea0panel0componente0" style='overflow: auto; position:static;height:98%; width:100%; top:10px;left:3px;'>
                                                        	     <table style="position:relative;left:40px; text-align:left; margin-top:10px; margin-bottom:10px;">
                                        								<tr>
                                        									<td style="padding:6px 0px 4px 10px;">		<label  style="font-family: Verdana; font-size: 10px;">Nombre</label>
                                        																				<input  id='idAreaCriterioInput' type='text' style='height: 20px; width:200px;'/></input></td>									
                                        									<td style="padding:6px 0px 4px 10px;">		<img id="btnConsulta" class="botonMenuIEC" title="Consulta" src="assets/botones/imgConsulta.png" onClick="vista.btnConsulta_onClick();"></td>			
                                        								</tr>
                                        								<tr>
                                        									<td style="padding:6px 0px 4px 10px;">		
                                                                                                                		<label class='label'>Tipo de area</label>
                                                                                                                    	<input id ='asis' type='text' class = 'inputGenerico' title='Tipo area'  />
                                                                                                                    	<img style='padding-right: 1px; padding-left: 5px;'  id='btnConsultar' src='assets/botones/btnAsis.PNG' onclick='vista.verDatosAsis();' title='Ver datos'/> 
                                                                                                                    	</td>	
                                                                             <td style="padding:6px 0px 4px 10px;">		                                   		
                                                                                                                		<input id ='asisDsc' type='text' class = 'inputGenerico'    style ='margin-left:-17px;'disabled/> </td>										
                                        									
                                        								</tr>                                								
                                							    </table>  
                                							    <div id="gridListaArea" style="float:left; overflow: auto; position:static; height:83%; width:100%; display: block; top:5px;left:3px;"></div>       						
                                                    		</div>
                                                   		</div>                                
                        							</div>
                        						</div>
                        					</div> 									    	
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
		<div class='Ventana' id='Prompt' style='display: none;'></div>  
</div>

    
    
    
    
    
    
    
    
</form>
</body>
</html>