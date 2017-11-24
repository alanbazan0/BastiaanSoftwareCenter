<?php
namespace php\Interfaces;
use php\modelos\Usuario;

interface IUsuariosRepositorio
{   
    //data mapper
    public function insertar(Usuario $usuario);
    public function actualizar(Usuario $usuario);
    public function eliminar($id);
    
    public function consultarPorLlaves($id);
    public function consultar($criteriosSeleccion); 

    public function consultarPorPostal($criteriosPostales);  
}

