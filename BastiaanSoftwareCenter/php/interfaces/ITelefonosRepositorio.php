<?php
namespace php\interfaces;

use php\modelos\Telefono;

interface ITelefonosRepositorio
{
    public function insertar(Telefono $telefono);
    public function actualizar(Telefono $telefono);
    public function eliminar($id);
    
    public function consultarPorLlaves($id);
    public function consultar($criteriosSeleccion);  
    
}

