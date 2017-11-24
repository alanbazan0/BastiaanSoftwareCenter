<?php
namespace php\interfaces;

use php\modelos\Movimiento;

interface IMovimientosRepositorio
{
    public function insertar(Movimiento $movimiento);
    public function actualizar(Movimiento $movimiento);
    public function eliminar($id);
    
    public function consultarPorLlaves($id); 
    public function consultar($criteriosSeleccion);   
    public function consultarPorReceso();   
    public function consultarPorUsuario($criteriosUsuarios);  
}

