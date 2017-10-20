<?php
namespace php\interfaces;

use php\modelos\Portables;

interface IPortablesRepositorio
{
    public function insertar(Portables $portables);
    public function actualizar(Portables $portables);
    public function eliminar(Portables $portables);
    
    public function consultarPorId($id);
    public function consultarConsecutivo($consecutivo);
    public function consultar($id, $estado, $municipio);
    
}
