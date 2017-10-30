<?php
namespace php\interfaces;

use php\modelos\Postal;

interface IPostalesRepositorio
{
    public function insertar(Postal $postal);
    public function actualizar(Postal $postal);
    public function eliminar($id);
    
    public function consultarPorLlaves($id);
    public function consultar($criteriosSeleccion);
    
}
