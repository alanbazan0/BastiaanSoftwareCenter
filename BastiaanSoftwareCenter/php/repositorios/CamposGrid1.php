<?php
use php\clases\AdministradorConexion;
use php\repositorios\CamposGrid1Repositorio;
use php\modelos\Resultado;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/CamposGrid1Repositorio.php';



header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

$administrador_conexion = new AdministradorConexion();
$resultado = new Resultado();
$conexion;
try
{
    $conexion = $administrador_conexion->abrir();
    if($conexion)
    {
        $accion = REQUEST('accion');
        $repositorio = new CamposGrid1Repositorio($conexion);
        switch ($accion)        
        {    
            case 'consultarPorVersion':
                $version =REQUEST('version');
                $resultado = $repositorio->consultarPorVersion($version);                
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


