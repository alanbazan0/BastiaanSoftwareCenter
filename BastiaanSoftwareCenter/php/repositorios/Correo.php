<?php
use php\clases\AdministradorConexion;
use php\clases\JsonMapper;
use php\modelos\Area;
use php\repositorios\AreasRepositorio;
use php\repositorios\CorreoRepositorio;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/CorreoRepositorio.php';



header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

$administrador_conexion = new AdministradorConexion();

$conexion;
try
{
    $conexion = $administrador_conexion->abrir();
    if($conexion)
    {
        $accion = REQUEST('accion');
        $repositorio = new CorreoRepositorio($conexion);
        switch ($accion)
        {            
            case 'consultarCorreoEntrada':
                $NombreUsuario = REQUEST('idNombre');
                $resultado = $repositorio->consultarCorreoEntrada($NombreUsuario);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
        }
    }
    
}
catch(Exception $e)
{
    echo $e->getMessage(), '\n';
}
finally
{
    $administrador_conexion->cerrar($conexion);
}


