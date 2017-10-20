<?php
namespace php\interfaces;

use php\modelos\Postales;

interface IPostalesRepositorio
{
    public function insertar(Postales $postales);
    public function actualizar(Postales $postales);
    public function eliminar(Postales $postales);
    
    public function consultarPorId($id);
    public function consultarNoPostal($noPostal);
    public function consultar($id, $estado, $municipio);
    
}
