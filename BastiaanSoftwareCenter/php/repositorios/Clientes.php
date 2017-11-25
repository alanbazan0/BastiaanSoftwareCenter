<?php
use php\clases\AdministradorConexion;
use php\clases\JsonMapper;
use php\modelos\Cliente;
use php\repositorios\CamposGrid1Repositorio;
use php\repositorios\ClientesRepositorio;
use php\modelos\Resultado;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/ClientesRepositorio.php';
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
        $repositorio = new ClientesRepositorio($conexion);
        switch ($accion)
        {           
            case 'insertar':
                $json = json_decode(REQUEST('cliente'));
                $mapper = new JsonMapper();
                $cliente = $mapper->map($json, new Cliente());            
                $resultado = $repositorio->insertar($cliente);                
            break;
            case 'actualizar':
                $json = json_decode(REQUEST('cliente'));
                $mapper = new JsonMapper();
                $cliente = $mapper->map($json, new Cliente());
                $resultado = $repositorio->actualizar($cliente) ;
            break;
            case 'eliminar':               
               $llaves = json_decode(REQUEST('llaves'));
               $resultado = $repositorio->eliminar($llaves); 
            break;           
            case 'consultarPorLlaves':
                $llaves = json_decode(REQUEST('llaves'));
                $resultado = $repositorio->consultarPorLlaves($llaves);              
            break;
            case 'consultar':
                $criteriosSeleccion = json_decode(REQUEST('criteriosSeleccion'));
                $resultado = $repositorio->consultar($criteriosSeleccion);               
            break;
            case 'consultarDinamicamente':
                $filtros = json_decode(REQUEST('filtros'));
                $version = REQUEST('version');                
                $camposRepositorio = new CamposGrid1Repositorio($conexion);
                $resultado = $camposRepositorio->consultarPorVersion($version);
                if($resultado->mensajeError=='')
                {
                    $campos = $resultado->valor; 
                    $resultado = $repositorio->consultarDinamicamente($filtros,$campos); 
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


