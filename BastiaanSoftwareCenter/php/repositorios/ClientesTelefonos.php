<?php
use php\clases\AdministradorConexion;
use php\clases\JsonMapper;
use php\modelos\Correos;
use php\modelos\Resultado;
use php\modelos\ClienteTelefono;
use php\repositorios\ClientesTelefonosRepositorio;
use php\modelos\Receso;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/ClientesTelefonosRepositorio.php';



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
        $repositorio = new ClientesTelefonosRepositorio($conexion);
        switch ($accion)
        {
            
           /* case 'insertar':
                
                $json = json_decode(REQUEST('clientetelefono'));
                $mapper = new JsonMapper();
                $clientetelefono = $mapper->map($json, new ClienteTelefono());
                $resultado = $repositorio->insertar($clientetelefono);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;*/
            case 'insertar':
                $string =REQUEST('clientetelefono');
                $arrayData = json_decode($string, true);
                $mapper = new JsonMapper();
                
                $arr=json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                $arrayData2= (array)json_decode($arr, true);
                
                if (isset($arrayData2))
                {
                    
                    //print_r("'".$campoID."'");
                    //echo json_encode($arrayData2[0]['id'], JSON_UNESCAPED_UNICODE);
                    for($i=0; $i< count($arrayData2); $i++)
                    {                       
                        $object= new ClienteTelefono();
                        
                        $object->id=             $arrayData2[$i]['Id'];
                        $object->nir=            $arrayData2[$i]['Nir'];
                        $object->serie=          $arrayData2[$i]['Serie'];
                        $object->telefonoCliente=$arrayData2[$i]['TelefonoCliente'];
                        $object->compania=       $arrayData2[$i]['Compania'];
                        $object->tipoTelefono=   $arrayData2[$i]['TipoTelefono'];
                        $object->numeracion=     $arrayData2[$i]['Numeracion'];
                        
                        $resultado = $repositorio->insertar($object);
                       
                    }
                    if($resultado!=null)
                        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                }
                break;
            case 'actualizar':
                $json = json_decode(REQUEST('clientetelefono'));
                $mapper = new JsonMapper();
                $clientetelefono = $mapper->map($json, new ClienteTelefono());
                
                $resultado = $repositorio->actualizar($clientetelefono) ;
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
            case 'consultar':
                $criteriosSeleccion = json_decode(REQUEST('criteriosSeleccion'));
                $resultado = $repositorio->consultar($criteriosSeleccion);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;                   
            case 'consultarPorNumero':
                $numeroEntrante= REQUEST('NumeroEntrante');
                $resultado = $repositorio->consultarPorNumero($numeroEntrante);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'insertarCorreo':
                $string =REQUEST('clienteCorreo');
                $idCliente =REQUEST('idCliente');
                $arrayData = json_decode($string, true);
                $mapper = new JsonMapper();
                
                $arr=json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                $arrayData2= (array)json_decode($arr, true);
                
                if (isset($arrayData2))
                { 
                    for($i=0; $i< count($arrayData2); $i++)
                    {
                        $object= new ClienteTelefono();
                        
                        $object->Correo=             $arrayData2[$i]['Correo'];
                        $object->Origen=            $arrayData2[$i]['Origen'];
                        $object->id=$idCliente;
                        $resultado= $repositorio->insertarAltaCorreo($object);
                    }
                    if($resultado!=null)
                        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
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
    $administrador_conexion->cerrar($conexion);
}



