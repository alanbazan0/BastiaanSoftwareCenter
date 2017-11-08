<?php
namespace php\interfaces;

use php\modelos\Cliente;

interface IClientesRepositorio
{
    public function insertar(Cliente $cliente);
    public function actualizar(Cliente $cliente);
    public function eliminar($id);
    
    public function consultarPorLlaves($id); 
    public function consultar($criteriosSeleccion);   
    public function consultarDinamicamente($filtros,$campos);
}

