<?php
use php\clases\AdministradorConexion;
use php\modelos\Cliente;
use php\repositorios\ClientesRepositorio;

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../clases/Utilidades.php';
include '../clases/AdministradorConexion.php';
include '../repositorios/ClientesRepositorio.php';



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
        $repositorio = new ClientesRepositorio($conexion);
        switch ($accion)
        {
            case 'consultarPorNombre':
                $nombre = REQUEST('nombre');
                
                $clientes = $repositorio->consultarPorNombre($nombre) ;
                if($clientes!=null)
                    echo json_encode($clientes);
                    break;
            case 'consultarPorId':
                $id = REQUEST('id');
                
                $clientes = $repositorio->consultarPorId($id) ;
                if($clientes!=null)
                    echo json_encode($clientes);
                    break;
            case 'insertar':
                $cliente = new Cliente();
                $cliente->nombre = utf8_encode(REQUEST('nombre'));
                $cliente->nombreSegundo = utf8_encode(REQUEST('nombreSegundo'));
                $cliente->apellidoPaterno = utf8_encode(REQUEST('apellidoPaterno'));
                $cliente->apellidoMaterno = utf8_encode(REQUEST('apellidoMaterno'));
                $cliente->nombreCompleto = utf8_encode(REQUEST('nombreCompleto'));
                $cliente->rfc = utf8_encode(REQUEST('rfc'));
                $cliente->nss = utf8_encode(REQUEST('nss'));
                $cliente->curp = utf8_encode(REQUEST('curp'));
                $cliente->cpId = utf8_encode(REQUEST('cpId'));
                $cliente->numExt = utf8_encode(REQUEST('numExt'));
                $cliente->numInt = utf8_encode(REQUEST('numInt'));
                $cliente->calle = utf8_encode(REQUEST('calle'));
                $cliente->colonia = utf8_encode(REQUEST('colonia'));
                $cliente->estado = utf8_encode(REQUEST('estado'));
                $cliente->pais = utf8_encode(REQUEST('pais'));
                $cliente->direccion = utf8_encode(REQUEST('direccion'));
                $cliente->correoElectronico = utf8_encode(REQUEST('correoElectronico'));
                $clientes = $repositorio->insertar($cliente) ;
                if($clientes!=null)
                    echo json_encode($clientes);
                    break;
            case 'eliminar':
                $cliente = new Cliente();
                $cliente->id = utf8_encode(REQUEST('id'));
                $clientes = $repositorio->eliminar($cliente) ;
                if($clientes!=null)
                    echo json_encode($clientes);
                    break;
            case 'actualizar':
                $cliente = new Cliente();
                $cliente->nombre = utf8_encode(REQUEST('nombre'));
                $cliente->nombreSegundo = utf8_encode(REQUEST('nombreSegundo'));
                $cliente->apellidoPaterno = utf8_encode(REQUEST('apellidoPaterno'));
                $cliente->apellidoMaterno = utf8_encode(REQUEST('apellidoMaterno'));
                $cliente->nombreCompleto = utf8_encode(REQUEST('nombreCompleto'));
                $cliente->rfc = utf8_encode(REQUEST('rfc'));
                $cliente->nss = utf8_encode(REQUEST('nss'));
                $cliente->curp = utf8_encode(REQUEST('curp'));
                $cliente->cpId = utf8_encode(REQUEST('cpId'));
                $cliente->numExt = utf8_encode(REQUEST('numExt'));
                $cliente->numInt = utf8_encode(REQUEST('numInt'));
                $cliente->calle = utf8_encode(REQUEST('calle'));
                $cliente->colonia = utf8_encode(REQUEST('colonia'));
                $cliente->estado = utf8_encode(REQUEST('estado'));
                $cliente->pais = utf8_encode(REQUEST('pais'));
                $cliente->direccion = utf8_encode(REQUEST('direccion'));
                $cliente->correoElectronico = utf8_encode(REQUEST('correoElectronico'));
                $cliente->id = utf8_encode(REQUEST('id'));
                $clientes = $repositorio->actualizar($cliente) ;
                if($clientes!=null)
                    echo json_encode($clientes);
                    break;
            case 'consultar':        
                $nombreCompleto=REQUEST('nombreCompleto');
                $rfc=REQUEST('rfc');
                $curp=REQUEST('curp');
                $clientes = $repositorio->consultar($nombreCompleto,$rfc,$curp ) ;
                if($clientes!=null)
                    echo json_encode($clientes);
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


