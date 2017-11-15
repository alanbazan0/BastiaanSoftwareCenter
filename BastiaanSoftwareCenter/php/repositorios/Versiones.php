<?php
use php\clases\AdministradorConexion;
use php\clases\JsonMapper;
use php\modelos\Version;
use php\repositorios\VersionesRepositorio;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/VersionesRepositorio.php';



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
        $repositorio = new VersionesRepositorio($conexion);
        switch ($accion)
        {
           
            case 'insertar':
                $json = json_decode(REQUEST('version'),true);
                $mapper = new JsonMapper();
                $version = $mapper->map($json, new Version());            
                $resultado = $repositorio->insertar($version);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            break;
            
            case 'insertarGrid2':
                $string =REQUEST('datosGrid2');               
                $arrayData = json_decode($string, true); 
                $mapper = new JsonMapper();
                
                $idVersion=json_encode($arrayData['versionId'], JSON_UNESCAPED_UNICODE);
                $arr=json_encode($arrayData['datosGrid2'], JSON_UNESCAPED_UNICODE);                
                $arrayData2= (array)json_decode($arr, true); 
                
                if (isset($arrayData2))
                {
                    
                    //print_r("'".$campoID."'"); 
                    //echo json_encode($arrayData2[0]['id'], JSON_UNESCAPED_UNICODE);
                    for($i=0; $i< count($arrayData2); $i++)                    
                    {                
                        $campoID=$arrayData2[$i]['campoId'];
                        $object= new Version();
                        $object->version=     $idVersion;
                        $object->campoId=     $campoID;
                        $object->presentacion=$arrayData2[$i]['presentacion'];
                        $object->titulo=      $arrayData2[$i]['titulo'];
                        $object->orden=       $arrayData2[$i]['orden'];
                        echo count($arrayData2[$i]);
                        $resultado = $repositorio->insertarGrid2($object);
                        if($resultado!=null)
                            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    }
                }
                    break;
                    
            case 'actualizar':
                $json = json_decode(REQUEST('version'));
                $mapper = new JsonMapper();
                $version = $mapper->map($json, new Version());
                $resultado = $repositorio->actualizar($version) ;
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            break;
            case 'eliminar':               
               $llaves = json_decode(REQUEST('llaves'));
               $resultado = $repositorio->eliminar($llaves);           
               if($resultado!=null)
                   echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            break;           
            case 'consultarPorLlaves':
                $llaves = json_decode(REQUEST('llaves'));
                $resultado = $repositorio->consultarPorLlaves($llaves);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            break;
            case 'consultarPorVersion':
                $criteriosVersion = json_decode(REQUEST('criteriosVersion'));
                $resultado = $repositorio->consultarPorVersion($criteriosVersion);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultarPorCampo':
                $resultado = $repositorio->consultarPorCampo();
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'consultar':    // printf("<script type='text/javascript'>alert('Lo estamos redireccionando'); </script>");
                $criteriosSeleccion = json_decode(REQUEST('criteriosSeleccion'));
                $resultado = $repositorio->consultar($criteriosSeleccion);
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


