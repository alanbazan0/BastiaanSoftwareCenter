class ClientesPresentador
{
	 constructor(vista)
	 {
		this.vista = vista; 
	 }
	 
	 consultar()
	 {
		 var repositorio = new ClientesRepositorio(this);		
		 repositorio.consultar(this,this.consultarResultado,this.vista.nombreCompleto,this.vista.rfc,this.vista.curp);
	 }
	 
	 consultarResultado(resultado)
	 {
		// this.vista.setDatos(resultado);
		 this.vista.datos = resultado;
	 }
	 
	
	 
}