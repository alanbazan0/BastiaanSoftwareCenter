<?php
use php\clases\AdministradorConexion;
use php\clases\JsonMapper;
use php\repositorios\CamposRepositorio;
use php\modelos\Resultado;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/CamposRepositorio.php';

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
        $repositorio = new CamposRepositorio($conexion);
        switch ($accion)        
        {    
            case 'consultarPorTablas':
                $tablas =REQUEST('tablas');
                $resultado = $repositorio->consultarPorTablas($tablas);                
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


