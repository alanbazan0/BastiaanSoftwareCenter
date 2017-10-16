class ClientesPresentador
{
	 constructor(vista)
	 {
		this.vista = vista; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new ClientesRepositorio(this);		
		 repositorio.consultar(this,this.consultarResultado,this.vista.getNombreCompleto());
	 }
	 
	 consultarResultado(resultado)
	 {
		 this.vista.setDatos(resultado);
	 }
	 
	
	 
}