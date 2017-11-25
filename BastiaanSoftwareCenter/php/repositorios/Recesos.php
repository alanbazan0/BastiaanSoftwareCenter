<?php
use php\clases\AdministradorConexion;
use php\clases\JsonMapper;
use php\modelos\Receso;
use php\repositorios\RecesosRepositorio;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/JsonMapper.php';
include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/RecesosRepositorio.php';

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
        $repositorio = new RecesosRepositorio($conexion);
        switch ($accion)
        {
           
            case 'insertar':
                $json = json_decode(REQUEST('receso'));
                $mapper = new JsonMapper();
                $receso = $mapper->map($json, new Receso());            
                $resultado = $repositorio->insertar($receso);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            break;
            case 'actualizar':
                $json = json_decode(REQUEST('receso'));
                $mapper = new JsonMapper();
                $receso = $mapper->map($json, new Receso());
                $resultado = $repositorio->actualizar($receso) ;
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
            case 'consultar2':                
                $resultado = $repositorio->consultar2();
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'SolictarReceso':
                $NombreUsuario = REQUEST('NombreUsuario');
                $idTipoSolicitud = REQUEST('idTipoSolicitud');
                $DescTipoSolicitud = REQUEST('DescTipoSolicitud');
                $EstatusSolicitud = REQUEST('EstatusSolicitud');
                $LlamadaId = REQUEST('LlamadaId');
                
                $resultado= $repositorio->consultarIdUsuarioExt($NombreUsuario);
                if($resultado->valor)
                {
                    $resultado = $repositorio->ActuaizaSolictarReceso($NombreUsuario,$idTipoSolicitud,$DescTipoSolicitud,$EstatusSolicitud,$LlamadaId);
                }
                else  
                 {
                     $resultado = $repositorio->InsertarSolictarReceso($NombreUsuario,$idTipoSolicitud,$DescTipoSolicitud,$EstatusSolicitud,$LlamadaId);
                 }
                 
                
               
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'autoriza':
                $NombreUsuario = REQUEST('NombreUsuario');
                $EstatusSolicitud = REQUEST('EstatusSolicitud');
                $resultado= $repositorio->actualizaEstatusReceso($NombreUsuario,$EstatusSolicitud);       
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
               break;
            case 'consultaMovimientos':
                $NombreUsuario = REQUEST('NombreUsuario');
                $resultado= $repositorio->consultaMovimientos($NombreUsuario);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'ConsultarStatus':
                $NombreUsuario = REQUEST('NombreUsuario');
                $resultado= $repositorio->ConsultarStatus($NombreUsuario);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
                    break;
            case 'actualizarEstatus':
                $NombreUsuario = REQUEST('NombreUsuario');
                $EstatusSolicitud = REQUEST('EstatusSolicitud');
                $resultado= $repositorio->actualizarEstatus($NombreUsuario,$EstatusSolicitud);
                if($resultado!=null)
                    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
                    break;
            case 'insertarMovimiento':
                $NombreUsuario = REQUEST('NombreUsuario');
                $EstatusSolicitud = REQUEST('EstatusSolicitud');
                $idTipoReceso = REQUEST('idTipoReceso');
                $dscTipoSolicutd = REQUEST('dscTipoSolicutd');
                $resultado= $repositorio->insertarMovimientos($NombreUsuario,$idTipoReceso,$dscTipoSolicutd);
                $resultado2= $repositorio->consultaMovimientosInsert($NombreUsuario,$idTipoReceso,$resultado->valor);
                if($resultado!=null)
                    echo json_encode($resultado2, JSON_UNESCAPED_UNICODE);
                    break;
            case 'actualizarMovimientos':
                $NombreUsuario = REQUEST('NombreUsuario');
                $fechaInicialGuardada = REQUEST('fechaInicialGuardada');
                $horaInicialGuardada = REQUEST('horaInicialGuardada');
                $duracion = REQUEST('duracion');                
                $duracionSeg = REQUEST('duracionSeg');
                $resultado= $repositorio->actualizarMovimientos($NombreUsuario,$fechaInicialGuardada,$horaInicialGuardada,$duracion,$duracionSeg);
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


