class PostalPresentador
{
	 constructor(vistas)
	 {
		this.vistas = vistas; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new PostalesRepositorio(this);		
		 repositorio.consultar(this,this.consultarResultado,this.vistas.id,this.vistas.estado,this.vistas.municipio);
	 }
	 
	 consultarResultado(resultado)
	 {
		// this.vistas.setDatos(resultado);
		 this.vistas.datos = resultado;
	 }
	 
	 insertar()
	 {
		 var repositorio = new PostalesRepositorio(this);		
		 repositorio.insertar(this,this.insertarResultado,this.vistas.id, this.vistas.asentamiento, this.vistas.municipio,this.vistas.estado,this.vistas.ciudad,this.vistas.nopostal);
	 }
	 
	 insertarResultado(resultado)
	 {
		if( resultado == "error" || resultado == false || resultado == "NO_OK"){
			this.vistas.resultado ="Error al agregar postal.";
			}else{
				this.vistas.resultado = "Postal guardado exitosamente. ";
			}
	 }
	 actualizar()
	 {
		 var repositorio = new PostalesRepositorio(this);		
		 repositorio.actualizar(this,this.actualizarResultado,this.vista.id,this.vista.asentamiento, this.vista.municipio, this.vista.estado,this.vista.ciudad,this.vista.nopostal);
	 }
	 
	 actualizarResultado(resultado)
	 {
		if( resultado == "error" || resultado == false || resultado == "NO_OK"){
			this.vista.resultado ="Error al agregar postal.";
			}else{
				this.vista.resultado = "postal actualizado exitosamente. ";
			}
	 }
	 
	 consultarPorId()
	 {
		 var repositorio = new PostalRepositorio(this);		
		 repositorio.consultarPorId(this,this.consultarPorIdResultado,this.vista.id);
	 }
	 consultarPorIdResultado(resultado)
	 {		
		 this.vista.resultadoActualizar = resultado;
	 }
	 
	 eliminar()
	 {
		 var repositorio = new PostalRepositorio(this);		
		 repositorio.eliminar(this,this.eliminarResultado,this.vista.id);
	 }
	 
	 eliminarResultado(resultado)
	 {
		if( resultado == "error" || resultado == false || resultado == "NO_OK"){
			this.vista.resultado ="Error al eliminar postal.";
			}else{
				this.vista.resultado = "postal eliminado exitosamente. ";
			}
	 }
	 
}