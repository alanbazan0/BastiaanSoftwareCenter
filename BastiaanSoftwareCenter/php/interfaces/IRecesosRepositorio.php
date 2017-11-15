<?php
namespace php\interfaces;

use php\modelos\Receso;

interface IRecesosRepositorio
{
    public function insertar(Receso $receso);
    public function actualizar(Receso $receso);
    public function eliminar($id);
    
    public function consultarPorLlaves($id); 
    public function consultar($criteriosSeleccion);   
}

