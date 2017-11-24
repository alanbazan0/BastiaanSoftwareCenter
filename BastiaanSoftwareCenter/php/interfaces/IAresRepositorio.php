<?php
namespace php\interfaces;

use php\modelos\Area;


interface IAresRepositorio
{
    public function insertar(Area $area);
    public function actualizar(Area $area);
    public function eliminar($id);
    
    public function consultarPorLlaves($id);
    public function consultar($criteriosSeleccion);
    
    public function consultarTipoEstructura();
    public function consultarListaAreas();
}

