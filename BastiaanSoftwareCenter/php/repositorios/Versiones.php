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
                $json = json_decode(REQUEST('version'));
                $mapper = new JsonMapper();
                $version = $mapper->map($json, new Version());            
                $resultado = $repositorio->insertar($version);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            break;
            
            case 'insertarGrid2':
                $json = json_decode(REQUEST('datosGrid2', true));
                
              //  var_dump(json_decode($json, true));
                $mapper = new JsonMapper();
                 
                /*
                 $jsondata = '';
                 $arr = json_decode($jsondata, true);
                 foreach ($arr as $k=>$v){
                 echo $v; // etc.
                 */
                
               // echo"<script type=\"text/javascript\">alert('$json'); </script>";
                
        //        print_r($json2);
        
                
                //aqui va foreach
                for($i=0; $i< 7; $i++)
                {
              //      echo "<script>alert(".$json.count().")</script>";
                    $datos = $mapper->map($json['datosGrid2'][$i], new Version());
                    
                    
                    
                    
                    $resultado = $repositorio->insertarGrid2($datos);
                    $resultado=$json;
                    if($resultado!=null)
                        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    
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


