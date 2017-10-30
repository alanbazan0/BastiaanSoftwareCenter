<?php
namespace php\interfaces;

use php\modelos\Baja;

interface IBajasRepositorio
{
    public function insertar(Baja $baja);
    public function actualizar(Baja $baja);
    public function eliminar($id);
    
    public function consultarPorLlaves($id);
    public function consultar($criteriosSeleccion);  
    
}

