class VersionesPresentador
{
	 constructor(vista)
	 {
		this.vista = vista; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new VersionesRepositorio(this);		
		 repositorio.consultar(this,this.consultarResultado,this.vista.criteriosSeleccion);
	 }
	 
	 consultarResultado(resultado)
	 {
		if(resultado.mensajeError=="")
			this.vista.datos = resultado.valor;
		else
			this.vista.mostrarMensaje("Error",resultado.mensajeError);
	 }
	 /* grid3*/ 
	 consultarPorCampo()
	 {
		 var repositorio = new VersionesRepositorio(this);		
		 repositorio.consultarPorCampo(this,this.consultarPorCampoResultado,this.vista.criteriosCampos);
	 }
	 consultarPorCampoResultado(resultado)
	 {
		if(resultado.mensajeError=="")
			this.vista.datosCampos = resultado.valor;
		else
			this.vista.mostrarMensaje("Error",resultado.mensajeError);
	 }
	
	 /* grid2 */
	 consultarPorVersion()
	 {
		 var repositorio = new VersionesRepositorio(this);		
		 repositorio.consultarPorVersion(this,this.consultarPorVersionResultado,this.vista.criteriosVersion);
	 }
	 
	 consultarPorVersionResultado(resultado)
	 {
		if(resultado.mensajeError=="")
			this.vista.datosCriterios = resultado.valor;
		else
			this.vista.mostrarMensaje("Error",resultado.mensajeError);
	 }
	 /* */
	 insertar()
	 {
		 var repositorio = new VersionesRepositorio(this);			 
		 repositorio.insertar(this,this.insertarResultado,this.vista.version);	
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
		 var repositorio = new VersionesRepositorio(this);			 
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
		 var repositorio = new VersionesRepositorio(this);		
		 repositorio.actualizar(this,this.actualizarResultado,this.vista.version);
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
		 var repositorio = new VersionesRepositorio(this);		
		 repositorio.consultarPorLlaves(this,this.consultarPorLlavesResultado,this.vista.llaves);
	 }
	 
	 consultarPorLlavesResultado(resultado)
	 {		
		 if(resultado.mensajeError=="")
		 {
			 this.vista.version = resultado.valor;
		 }
		 else
			 this.vista.mostrarMensaje("Error","Ocurrió un error al consultar el registro. " + resultado.mensajeError);
	 }
	 	 

	 eliminar()
	 {
		 var repositorio = new VersionesRepositorio(this);		
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