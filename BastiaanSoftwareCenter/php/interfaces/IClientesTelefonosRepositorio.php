<?php
namespace php\interfaces;

use php\modelos\ClienteTelefono;

interface IClientesTelefonosRepositorio
{
    public function insertar(ClienteTelefono $clientetelefono);
    public function actualizar(ClienteTelefono $clientetelefono);
    public function eliminar($id);
    
    public function consultarPorLlaves($id);
    public function consultar($criteriosSeleccion);  
    
}

