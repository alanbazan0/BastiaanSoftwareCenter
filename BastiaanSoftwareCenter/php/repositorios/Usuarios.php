<?php
use php\clases\AdministradorConexion;
use php\clases\JsonMapper;
use php\modelos\Usuario;
use php\repositorios\UsuariosRepositorio;
use php\modelos\Resultado;

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/UsuariosRepositorio.php';

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
        $repositorio = new UsuariosRepositorio($conexion);
        switch ($accion)
        {
            
            case 'insertar':
                $json = json_decode(REQUEST('usuario'));
                $mapper = new JsonMapper();
                $usuario = $mapper->map($json, new Usuario());
                $resultado = $repositorio->insertar($usuario);    
                if($resultado!=null)
             //       echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
                    
                
            case 'actualizar':
                $json = json_decode(REQUEST('usuario'));
                $mapper = new JsonMapper();
                $usuario = $mapper->map($json, new Usuario());
                $resultado = $repositorio->actualizar($usuario) ;              
                if($resultado!=null)
           //         echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
                    
            case 'eliminar':
                $llaves = json_decode(REQUEST('llaves'));
                $resultado = $repositorio->eliminar($llaves);               
                if($resultado!=null)
            //        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
                    
            case 'consultarPorLlaves':
                $llaves = json_decode(REQUEST('llaves'));
                $resultado = $repositorio->consultarPorLlaves($llaves);     
                if($resultado!=null)
          //          echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
                
            case 'consultar':
                $criteriosSeleccion = json_decode(REQUEST('criteriosSeleccion'));
                $resultado = $repositorio->consultar($criteriosSeleccion);   
                if($resultado!=null)
        //            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                break;
                
                
            case 'consultarPorPostal':
                    $criteriosPostales = json_decode(REQUEST('criteriosPostales'));
                    $resultado = $repositorio->consultarPorPostal($criteriosPostales);
                    if($resultado!=null)
    //                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                        break;
            case 'consultarPorIdContrasena':
                    $id = REQUEST('id');
                    $contrasena = REQUEST('contrasena');
                    $resultado = $repositorio->consultarPorIdContrasena($id, $contrasena) ; 
                    if($resultado->valor!="")
                    {
                        // $repositorio->insertarMovimientos($id);
                    }
                    
            break;
            case 'InsertarSesionTrabajo':
                $idHardware = REQUEST('idHardware');
                $ip = REQUEST('ip');
                $idUsuario = REQUEST('nombre');
                $resultado = $repositorio->consultarSesionTrabajo($idUsuario) ;
                if($resultado->valor=="")
                {
                    $resultado=$repositorio->InsertarSesionTrabajo($idUsuario,$ip,$idHardware);
                    $repositorio->insertarMovimientos($idUsuario);
                    $resultado= $repositorio->InsertarSesionTrabajoHistorial($idUsuario,$ip,'4',$idHardware);
                }
                else 
                {
                    $resultado->valor=false;
                }
                
                break;
                
            case 'CerrarSesion':
                    $idUsuario = REQUEST('idNombre');
                    $idHardware = REQUEST('idHardware');
                    $ip = REQUEST('ip');
                    $resultado=$repositorio->CerrarSesion($idUsuario);   
                    $repositorio->updateMovimientosUsuario($idUsuario);  
                    $repositorio->InsertarSesionTrabajoHistorial($idUsuario,$ip,'2',$idHardware);
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
    if($resultado!=null)
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
}

