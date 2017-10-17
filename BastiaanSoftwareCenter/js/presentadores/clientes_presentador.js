class ClientesPresentador
{
	 constructor(vista)
	 {
		this.vista = vista; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new ClientesRepositorio(this);		
//		 repositorio.consultar(this,this.consultarResultado,this.vista.getNombreCompleto());
		 repositorio.consultar(this,this.consultarResultado,this.vista.nombreCompleto);
	 }
	 
	 consultarResultado(resultado)
	 {
		// this.vista.setDatos(resultado);
		 this.vista.datos = resultado;
	 }
	 
	
	 
}