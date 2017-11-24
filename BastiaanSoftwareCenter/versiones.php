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
<title>Catalogo de Versiones</title>
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
    
   
    <script language="JavaScript" type="text/JavaScript" src="js/repositorios/versiones_repositorio.js"></script>
    <script language="JavaScript" type="text/JavaScript" src="js/presentadores/versiones_presentador.js"></script>
	<script language="JavaScript" type="text/JavaScript" src="js/vistas/versiones_vista.js"></script>

    
</head>

<body  bgcolor="#e8e8e8" onLoad="vista.onLoad()" style="overflow: height: 400px;">
<div id="dialogo" title="Diï¿½logo" style="display:none;">  
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
								<!-- 	<td><img id="btnCambio" class="botonMenuIEC" title="Cambio" src="assets/botones/imgCambio.png" onClick="vista.btnCambio_onClick();"></td>	 -->								
									<td><img id="btncriterios" class="botonMenuIEC" title="Criterios" src="assets/botones/imgCambio.png" onClick="vista.btncriterios_onClick();"></td>
									<td><img id="btnSalir" class="botonMenuIEC" title="Salir"  src="assets/botones/btnSalir.png" onClick="vista.btnSalir_onClick();" ></td>
								</tr>
                             </table>   
						</div>
						<div id="titulo" style="margin-left:280px;" class="tituloIEC">Versiones</div>
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
									<td style="padding:6px 0px 4px 10px;">	<label  style="font-family: Verdana; font-size: 10px;">Versiones2</label></td>
									<td style="padding:6px 0px 4px 10px;">		<input  id='idCriterioInput' type='text' style='height: 20px; width:200px;'/></input></td>	
								</tr>
								
							</table>
						</div>
					</div>
					
			
                </div>
		  </div>
		   
	       <div id="cargador" style="position:absolute;"></div>
		
			<div id="Pcontenido" style="position:relative;">            
				<div id="tabs" class="PcontenComp" style="display:block;"></div>
				<div id="paneles" class="PcontenComp" style="margin: auto; padding-left: 10px; padding-top: 0px; width: 99.5%; height: 83%; overflow: visible; position: relative;">
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
    
    

<div id="formularioDiv" style="display:none ;height: 190px;">
		<div>
			
<!--  barra de menï¿½ para botones de la pantalla
 -->
			<div id="menuPrincipal"  align="right" class="contieneCriteriosAribaBtn" style="background-color: #6b6b6b;    height: 55px; " > 
				<img class='logoBAS' style='float: left;' id='logoFRM' src='assets/pantalla/logoTipo.png'  />
				<span id="txtTitulo" style="float:left;margin-top: 20px;margin-left: 15px;color: #FFFFFF;float: left;font-family: Verdana;font-size: 11px;font-weight: bold;">Criterios de Selecci&oacuten</span>
                <img style="padding: 2px;" class='imgTipoBoton' id="btnSubir" class="botonMenuIEC" title="Subir" src="assets/botones/imagen1.png" width="52" height="52" onClick="vista.btnSubir();"></td>
			    <img  style="padding: 2px;" class='imgTipoBoton'id="btnBajar" class="botonMenuIEC" title="Bajar" src="assets/botones/imagen2.png" width="52" height="52" onClick="vista.btnBajar();"></td>
                <img style="padding: 2px;" class='imgTipoBoton' id='btnGuardarFormulario' src='assets/botones/imgGuardar.png' onclick='vista.btnGuardarFormulario_onClick();' title='Guardar' />
				<img style="padding: 2px;" class='imgTipoBoton' id='btnSalirFormulario' src='assets/botones/btnSalir.png' onClick="vista.btnSalirFormulario_onClick();" title='Salir'  />
			</div>
<!--
  barra de menï¿½...fin
 -->
			
<!--barra principal -->
	<div id="cargador" class="cargadorFRM2"></div>
				<div class="pContenido" id="estadoEstructura" >
						<div class="contenidoNormalUS">
					 		<div class="explicacionFRM" >
								<div id="filtros " class="contenedorIEC" style="overflow: auto; position: relative; width: 100%; display: block;">
								 <div style="width: 80%; display: block; height: 48%;  padding-top: 1px; padding-left: 34px;">								 	
								   <table WIDHT=25%; HEIGHT=25%;  CELLPADDING=0; cellspacing="10" style="padding-top: 5px; padding-left: 1%; position:relative;  ">
								    	<td >
								     		 <label style=" width:130px; position: relative; left: 3px; ">Id</label>
								   		</td>
								   		<td >
								     		<input class="input" id="idFormularioInput" descripcion="id" type="text" maxlength="20" value="" style="width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px;" disabled />
								   		</td>
								   	
								    	<td >
								     		<label style="position: relative; left: 15px; ">Version descripciÃ³n corta</label>
								   		</td>
								   		<td >
								     		<input class="input" id="descripcionCortaFormularioInput" descripcion="Descripciòn corta" style=" width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 22px "/>
								   		</td>
								   		<td >
								     		<label style="position: relative; left: 40px; ">Version descripciÃ³n Larga</label>
								   		</td>
								  		
								   		<td >
								     		<input class="input" id="descripcionLargaFormularioInput" descripcion="Descripciòn larga" style=" width:275px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 52px "/>
								   		</td>
							
								   <tr>
								   </tr>
								   		
								   		<td >
								     		<label style="position: relative; left: 3px; ">Nombre Pila</label>
								   		</td>
								   		<td >
								     		<input class="input" id="nombrePilaFormularioInput" descripcion="Nombre pila" style=" width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: 6px "/>
								   		</td>
								   		<td >
								     		<label style="position: relative; left: 15px; ">Fecha </label>
								   		</td>
								   		<td >
								     		<input class="input" id="fechaFormularioInput" descripcion="Fecha" style=" width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: -66px "/>
								   		</td>
								   		<td >
								     		<label style="position: relative; left: -41px; ">Hora</label>
								   		</td>
								   		<td >
								     		<input class="input" id="horaFormularioInput" descripcion="Hora " style=" width:130px; font-family:Verdana; font-size:9px;text-align:left; color:#006699;position: relative; left: -128px "/>
								   		</td>							
								   		</table>	    
								    	
									</div>
									
								 </div>
								</div>				  	
							</div>
						</div>
				</div>
</div>
<div id="criteriosDiv" style="display: none">
	           <div id="panelesArea0" style="margin-left: 12px;float:left; height:85%; width:76.5%;">
						<div id="panelesArea0paneles" class="PcontenComp" style="">
							<div id="panelesArea0panel0" class="contenedorIEC" style="width: 100%; height: 85%; z-index: 1; float: left; margin-right: 2px; margin-bottom: 2px; margin-left: 2px; overflow: hidden;">
								<div id="panelesArea0panel0barra" class="barracomandosContenedorIEC" style="position:relative;">
									<span id="panelesArea0panel0Titulo" class="tituloContenedorIEC"></span>	
								</div>
								<div id="panelesArea0panel0componentes" style="width:99%;height:85%;overflow:hidden;position:relative;">
                                	<div id="panelesArea0panel0componente0"   style='overflow: auto; position:static;height:98%; width:100%; top:10px;left:3px;'>
                               <!-- 
                                	<img id="btnBajar" class="botonMenuIEC" title="Bajar" src="assets/botones/imagen1.png" width="42" height="42" onClick="vista.btnBajar;">
                                	<img id="btnSubir" class="botonMenuIEC" title="Subir" src="assets/botones/imagen2.png" width="42" height="42" onClick="vista.btnSubir();">
                                	 -->
                                	 <div id="grid2" style="float:left; overflow: auto; position:static; height:95%; width:100%; display: block; top:5px;left:3px;"></div>                						
                            		</div>
                           		</div>                                
							</div>
						</div>
			</div>	
			 <div id="panelesArea1" style="margin-left: 12px;float:left; height:85%; width:20.5%;">
				  <div id="panelesArea1paneles" class="PcontenComp" style="">
					    <div id="panelesArea1panel0" class="contenedorIEC" style="width: 100%; height: 85%; z-index: 1; float: left; margin-right: 2px; margin-bottom: 2px; margin-left: 2px; overflow: hidden;">
							              <div id="panelesArea1panel0barra" class="barracomandosContenedorIEC" style="position:relative;">
									          <span id="panelesArea0panel0Titulo" class="tituloContenedorIEC"></span>	
								         </div>
								          <div id="panelesArea1panel0componentes" style="width:99%;height:85%;overflow:hidden;position:relative;">
                                	             <div id="panelesArea1panel0componente0" style='overflow: auto; position:static;height:98%; width:100%; top:10px;left:3px;'>
                                	                  <div id="grid3" style="float:left; overflow: auto; position:static; height:95%; width:100%; display: block; top:5px;left:3px;"></div>                						
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

</form>
</body>
</html>