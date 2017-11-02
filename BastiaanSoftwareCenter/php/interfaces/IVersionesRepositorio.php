<?php
namespace php\interfaces;

use php\modelos\Version;

interface IVersionesRepositorio
{
    public function insertar(Version $version);
    public function actualizar(Version $version);
    public function eliminar($id);
    
    public function consultarPorLlaves($id);
    public function consultar($criteriosSeleccion);
    
}
