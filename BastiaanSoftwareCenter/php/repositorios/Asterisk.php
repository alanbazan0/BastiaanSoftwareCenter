<?php
use php\clases\AdministradorConexion;
use php\clases\JsonMapper;
use php\modelos\Resultado;
use php\repositorios\AsteriskRepositorio;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/AsteriskRepositorio.php';



header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

$administrador_conexion = new AdministradorConexion();

$conexion;
$resultado = new Resultado();
try
{
    $conexion = $administrador_conexion->abrir();
    if($conexion)
    {
        $accion = REQUEST('accion');
        $repositorio = new AsteriskRepositorio($conexion);
        switch ($accion)
        {
            case 'consultar':
                $extension = REQUEST('extension');
                if($resultado->mensajeError=='')
                {
                    $resultado = $repositorio->consultarIdLlamada($extension);
                }
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
    if($resultado!=null)
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    $administrador_conexion->cerrar($conexion);
}


