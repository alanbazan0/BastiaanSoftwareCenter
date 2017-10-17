<?php
namespace php\interfaces;

use php\modelos\Cliente;

interface IClientesRepositorio
{
    public function insertar(Cliente $cliente);
    public function actualizar(Cliente $cliente);
    public function eliminar(Cliente $cliente);
    
    public function consultarPorId($id);
    public function consultarPorNombre($nombre);
    public function consultar($nombreCompleto, $rfc, $curp);
    
}

