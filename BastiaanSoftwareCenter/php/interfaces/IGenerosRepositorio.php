<?php
namespace php\interfaces;

use php\modelos\Genero;

interface IGenerosRepositorio
{
    public function insertar(Genero $genero);
    public function actualizar(Genero $genero);
    public function eliminar($id);
    
    public function consultarPorLlaves($id);
    public function consultar($criteriosSeleccion);   
    
}