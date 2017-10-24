<?php
namespace php\interfaces;

use php\modelos\Generos;

interface IGenerosRepositorio
{
    public function insertar(Generos $generos);
    public function actualizar(Generos $generos);
    public function eliminar(Generos $generos);
    
    public function consultarPorId($id);
    public function consultargcorto($gcorto);
    public function consultar($id, $gcorto, $glargo);   
    
}