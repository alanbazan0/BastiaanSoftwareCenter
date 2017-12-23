class DinamicosPresentador
{
	 constructor(vista)
	 {
		this.vista = vista; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new DinamicosRepositorio(this);		
		 repositorio.consultar(this,this.consultarResultado,this.vista.criteriosSeleccion);
	 }
	 consultarResultado(resultado)
	 {
		if(resultado.mensajeError=="")
			this.vista.datos = resultado.valor;
		else
			this.vista.mostrarMensaje("Error",resultado.mensajeError);
	 }
	 
	 
	 //===============================================================================
	 /* grid3*/ //ahora es  grid 2
	 consultarPorCampo()
	 {
		 var repositorio = new DinamicosRepositorio(this);		
		 repositorio.consultarPorCampo(this,this.consultarPorCampoResultado,this.vista.criteriosCampos);
	 }
	 consultarPorCampoResultado(resultado)
	 {
		if(resultado.mensajeError=="")
			this.vista.datosCampos = resultado.valor;
		else
			this.vista.mostrarMensaje("Error",resultado.mensajeError);
	 }
	 

	 //===============================================================================
	
	 /* grid2 */
	 consultarPorDinamico()
	 {
		 var repositorio = new DinamicosRepositorio(this);		
		 repositorio.consultarPorDinamico(this,this.consultarPorDinamicoResultado,this.vista.criteriosDinamico);
	 }
	 
	 consultarPorDinamicoResultado(resultado)
	 {
		if(resultado.mensajeError=="")
			this.vista.datosCriterios = resultado.valor;
		else
			this.vista.mostrarMensaje("Error",resultado.mensajeError);
	 }
	 /* */
	 insertar()
	 {
		 var repositorio = new DinamicosRepositorio(this);			 
		 repositorio.insertar(this,this.insertarResultado,this.vista.dinamico);	
	 }
	 
	 insertarResultado(resultado)
	 {
		if(resultado.mensajeError=="")
		{	
			this.vista.mostrarMensaje("Aviso","La información se guardó correctamente. Id: " + resultado.valor);
			this.vista.salirFormulario();
			this.consultar();
		}
		else
			this.vista.mostrarMensaje("Error","Ocurrió un error al guardar el registro. " + resultado.mensajeError);			
			
	 }	
	 
	 /* inserta grid2 */
	 insertarGrid2()
	 {
		 var repositorio = new DinamicosRepositorio(this);			 
		 repositorio.insertarGrid2(this,this.insertarResultado2,this.vista.insertarGrid2);	
	 }
	 insertarResultado2(resultado)
	 {
		if(resultado.mensajeError=="")
		{	
			this.vista.mostrarMensaje("Aviso","La información se guardó IdCriterio: " + resultado.valor);
			//this.vista.salirFormulario();
			//this.consultarPorVersion();
		}
		else
			this.vista.mostrarMensaje("Error","Ocurrió un error al guardar el registro. " + resultado.mensajeError);			
	 }	
	 
	 actualizar()
	 {
		 var repositorio = new DinamicosRepositorio(this);		
		 repositorio.actualizar(this,this.actualizarResultado,this.vista.dinamico);
	 }
	 
	 actualizarResultado(resultado)
	 {
		 if(resultado.mensajeError=="")
		 {	
			this.vista.mostrarMensaje("Aviso","La información se actualizó correctamente.");
			this.vista.salirFormulario();
			this.consultar();
		 }
		 else
			this.vista.mostrarMensaje("Error","Ocurrió un error al actualizar el registro. " + resultado.mensajeError);			
	 }
	   
	 consultarPorLlaves()
	 {
		 var repositorio = new DinamicosRepositorio(this);		
		 repositorio.consultarPorLlaves(this,this.consultarPorLlavesResultado,this.vista.llaves);
	 }
	 
	 consultarPorLlavesResultado(resultado)
	 {		
		 if(resultado.mensajeError=="")
		 {
			 this.vista.dinamico = resultado.valor;
		 }
		 else
			 this.vista.mostrarMensaje("Error","Ocurrió un error al consultar el registro. " + resultado.mensajeError);
	 }
	 	 

	 eliminar()
	 {
		 var repositorio = new DinamicosRepositorio(this);		
		 repositorio.eliminar(this,this.eliminarResultado,this.vista.llaves);		
	 }
	 
	 eliminarResultado(resultado)
	 {
		if(resultado.mensajeError=="")
		{
			//this.vista.mostrarMensaje("Aviso", "El registro se eliminó correctamente.");
			//this.consultar();
		}
		else
			this.vista.mostrarMensaje("Error","Ocurrió un error al eliminar el registro. " + resultado.mensajeError);		
	 }
	 
}