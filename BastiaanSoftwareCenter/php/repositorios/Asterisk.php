<?php
use php\clases\AdministradorConexionMarcador;
use php\clases\JsonMapper;
use php\modelos\Resultado;
use php\repositorios\AsteriskRepositorio;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexionMarcador.php';
include '../repositorios/AsteriskRepositorio.php';



header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

$administrador_conexion = new AdministradorConexionMarcador();

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
                $extension = json_decode(REQUEST('extension'));
                $resultado = $repositorio->consultarIdLlamada($extension);
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


