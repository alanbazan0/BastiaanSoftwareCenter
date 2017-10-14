<?php
namespace php\Interfaces;
use php\modelos\Usuario;

interface IUsuariosRepositorio
{   
    public function consultar($nombreUsuario, $contrasena);
    public function insertar(Usuario $usuario);
    public function actualizar(Usuario $usuario);
    public function eliminar(Usuario $usuario);
}

