<?php
namespace php\repositorios;

use Exception;
use php\interfaces\IClientesRepositorio;
use php\modelos\Cliente;
use php\modelos\Resultado;


include "../interfaces/IClientesRepositorio.php";
include "../modelos/Cliente.php";
include "../clases/Resultado.php";

class ClientesRepositorio implements IClientesRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function calcularId()
    {       
        $consulta =  "SELECT MAX(IFNULL(BTCLIENTENUMERO,0))+1 AS id FROM BSTNTRN.BTCLIENTE";
        if($sentencia = $this->conexion->prepare($consulta))
        {        
            if($sentencia->execute())
            {
                if ($sentencia->bind_result($id))
                {
                    if($row = $sentencia->fetch())
                    {
                        return $id;
                    }
                }
            }
        }
        else
        {
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }       
        return '0';
    }
    
    public function insertar(Cliente $cliente)
    {     
       
        $resultado = "";
        $id = $this->calcularId();
       
        $consulta = " INSERT INTO BSTNTRN.BTCLIENTE "
                    . " (BTCLIENTENUMERO, "
                    . " BTCLIENTEPNOMBRE, "
                    . " BTCLIENTESNOMBRE, "
                    . " BTCLIENTEAPATERNO, "
                    . " BTCLIENTEAMATERNO, "
                    . " BTCLIENTENCOMPLETO, "
                    . " BTCLIENTERFC, "
                    . " BTCLIENTENSS, "
                    . " BTCLIENTECURP, "
                    . " BTCLIENTECPID, "
                    . " BTCLIENTENEXTERIOR, "
                    . " BTCLIENTENINTERIOR, "
                    . " BTCLIENTECALLE, "
                    . " BTCLIENTECOLONIA, "
                    . " BTCLIENTEESTADO, "
                    . " BTCLIENTEPAIS, "
                    . " BTCLIENTEDCOMPLETA, "
                    . " BTCLIENTECORRELEC) "
                    . " VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             $sentencia->bind_param("isssssssssssssssss",$id,
                                                        $cliente->primerNombre,
                                                        $cliente->segundoNombre, 
                                                        $cliente->apellidoPaterno,
                                                        $cliente->apellidoMaterno,
                                                        $cliente->nombreCompleto,
                                                        $cliente->rfc,
                                                        $cliente->nss,
                                                        $cliente->curp,
                                                        $cliente->codigoPostal,
                                                        $cliente->numeroExterior,
                                                        $cliente->numeroInterior,
                                                        $cliente->calle,
                                                        $cliente->colonia,
                                                        $cliente->estado,
                                                        $cliente->pais,
                                                        $cliente->direccion,
                                                        $cliente->correoElectronico);                
             $resultado = $sentencia->execute();           
         }
         else
         {
             echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
         }
        return $id;
    }
    
    public function eliminar(Cliente $cliente)
    {
        $resultado = "";
        $consulta = " DELETE FROM BSTNTRN.BTCLIENTE "
                    . "  WHERE BTCLIENTENUMERO  = ? ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             $sentencia->bind_param("i",$cliente->id);
             $resultado = $sentencia->execute();           
         }else{
             echo "Fall� la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
         }
        return $resultado;
    }

    public function actualizar(Cliente $cliente)
    {     
        $resultado = "";
        $consulta = " UPDATE BSTNTRN.BTCLIENTE SET"
                    . " BTCLIENTEPNOMBRE = ?, "
                    . " BTCLIENTESNOMBRE = ?, "
                    . " BTCLIENTEAPATERNO = ?, "
                    . " BTCLIENTEAMATERNO = ?, "
                    . " BTCLIENTENCOMPLETO = ?, "
                    . " BTCLIENTERFC = ?, "
                    . " BTCLIENTENSS = ? ,"
                    . " BTCLIENTECURP = ?, "
                    . " BTCLIENTECPID = ?, "
                    . " BTCLIENTENEXTERIOR = ?, "
                    . " BTCLIENTENINTERIOR = ?, "
                    . " BTCLIENTECALLE = ?, "
                    . " BTCLIENTECOLONIA = ?, "
                    . " BTCLIENTEESTADO = ?, "
                    . " BTCLIENTEPAIS = ?, "
                    . " BTCLIENTEDCOMPLETA = ?, "
                    . " BTCLIENTECORRELEC = ?  "
                    . " WHERE BTCLIENTENUMERO = ? ";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("ssssssssssssssssss",$cliente->primerNombre,
                                                    $cliente->segundoNombre, 
                                                    $cliente->apellidoPaterno,
                                                    $cliente->apellidoMaterno,
                                                    $cliente->nombreCompleto,
                                                    $cliente->rfc,
                                                    $cliente->nss,
                                                    $cliente->curp,
                                                    $cliente->codigoPostal,
                                                    $cliente->numExt,
                                                    $cliente->numInt,
                                                    $cliente->calle,
                                                    $cliente->colonia,
                                                    $cliente->estado,
                                                    $cliente->pais,
                                                    $cliente->direccion,
                                                    $cliente->correoElectronico,
                                                    $cliente->id);                
            $resultado = $sentencia->execute();           
        }
        else
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;         
        return $resultado;        
    }
    
    public function consultar($nombreCompleto,$rfc,$curp)
    {
        $resultado = new Resultado();
        $clientes = array();     
       
        $consulta =   " SELECT "
                    . " BTCLIENTENUMERO id, "
                    . " BTCLIENTEPNOMBRE primerNombre, "
                    . " BTCLIENTESNOMBRE segundoNombre, "
                    . " BTCLIENTEAPATERNO apellidoPaterno, "
                    . " BTCLIENTEAMATERNO apellidoMaterno, "
                    . " BTCLIENTERFC rfc, "
                    . " BTCLIENTENSS nss, "
                    . " BTCLIENTECURP curp, "
                    . " BTCLIENTECPID codigoPostal, "
                    . " BTCLIENTENEXTERIOR numeroExterior, "
                    . " BTCLIENTENINTERIOR numeroInterior, "
                    . " BTCLIENTECALLE calle, "
                    . " BTCLIENTECOLONIA colonia, "
                    . " BTCLIENTEESTADO estado, "
                    . " BTCLIENTEPAIS pais, "
                    . " BTCLIENTECORRELEC correoElectronico "
                    . " FROM BSTNTRN.BTCLIENTE  "
                    . " WHERE BTCLIENTENCOMPLETO like  CONCAT('%',?,'%') "
                    . " AND BTCLIENTERFC like  CONCAT('%',?,'%') "
                    . " AND BTCLIENTECURP like  CONCAT('%',?,'%') ";

        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("sss",$nombreCompleto,$rfc,$curp))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, $primerNombre, $segundoNombre, $apellidoPaterno, $apellidoMaterno,  $rfc, $nss, $curp, $codigoPostal, $numeroExterior, $numeroInterior, $calle, $colonia, $estado, $pais,  $correoElectronico )  )
                    {                    
                        while($row = $sentencia->fetch())
                        {
                            $cliente = (object) [
                                'id' =>  utf8_encode($id),
                                'nombre' => utf8_encode($primerNombre),
                                'segundoNombre' => utf8_encode($segundoNombre),
                                'apellidoPaterno' => utf8_encode($apellidoPaterno),
                                'apellidoMaterno' => utf8_encode($apellidoMaterno),
                                'rfc' => utf8_encode($rfc),
                                'nss' => utf8_encode($nss),
                                'curp' => utf8_encode($curp),
                                'codigoPostal' => utf8_encode($codigoPostal),
                                'numeroExterior' => utf8_encode($numeroExterior),
                                'numeroInterior' => utf8_encode($numeroInterior),
                                'calle' => utf8_encode($calle),
                                'colonia' => utf8_encode($colonia),
                                'estado' => utf8_encode($estado),
                                'pais' => utf8_encode($pais),
                                'correoElectronico' => utf8_encode($correoElectronico)
                            ];  
                            array_push($clientes,$cliente);
                        }
                        $resultado->valor = $clientes; 
                    }           
                    else
                        $resultado->mensajeError = "Falló el enlace del resultado";       
                }       
                else 
                    $resultado->mensajeError = "Falló la ejecución";    
            }
            else
                $resultado->mensajeError = "Falló el enlace de parámetros";    
        }
        else                 
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;        
        
       
        return $resultado;     
    }    

    public function consultarPorId($id)
    {
        $cliente = null;
        $consulta =   " SELECT "
                    . " BTCLIENTENUMERO id, "
                    . " BTCLIENTEPNOMBRE primerNombre, "
                    . " BTCLIENTESNOMBRE segundoNombre, "
                    . " BTCLIENTEAPATERNO apellidoPaterno, "
                    . " BTCLIENTEAMATERNO apellidoMaterno, "
                    . " BTCLIENTENCOMPLETO nombreCompleto, "
                    . " BTCLIENTERFC rfc, "
                    . " BTCLIENTENSS nss, "
                    . " BTCLIENTECURP curp, "
                    . " BTCLIENTECPID codigoPostal, "
                    . " BTCLIENTENEXTERIOR numeroExterior, "
                    . " BTCLIENTENINTERIOR numeroInterior, "
                    . " BTCLIENTECALLE calle, "
                    . " BTCLIENTECOLONIA colonia, "
                    . " BTCLIENTEESTADO estado, "
                    . " BTCLIENTEPAIS pais, "
                    . " BTCLIENTEDCOMPLETA direccion, "
                    . " BTCLIENTECORRELEC correoElectronico "
                    . " FROM BTCLIENTE " 
                    . " WHERE BTCLIENTENUMERO  = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            $sentencia->bind_param("i",$id);
            if($sentencia->execute())
            {
                
                if ($sentencia->bind_result($id, $primerNombre, $segundoNombre, $apellidoPaterno, $apellidoMaterno, $nombreCompleto, $rfc, $nss, $curp, $codigoPostal, $numeroExterior, $numeroInterior, $calle, $colonia, $estado, $pais, $direccion , $correoElectronico ))
                {
                    
                    while($row = $sentencia->fetch())
                    {
                        $cliente = new Cliente();
                        $cliente->id = utf8_encode($id);
                        $cliente->primerNombre = utf8_encode($primerNombre);
                        $cliente->segundoNombre = utf8_encode($segundoNombre);
                        $cliente->apellidoPaterno = utf8_encode($apellidoPaterno);
                        $cliente->apellidoMaterno = utf8_encode($apellidoMaterno);
                        $cliente->nombreCompleto = utf8_encode($nombreCompleto);
                        $cliente->rfc = utf8_encode($rfc);
                        $cliente->nss = utf8_encode($nss);
                        $cliente->curp = utf8_encode($curp);
                        $cliente->cpId = utf8_encode($codigoPostal);
                        $cliente->numExt = utf8_encode($numeroExterior);
                        $cliente->numInt = utf8_encode($numeroInterior);
                        $cliente->calle = utf8_encode($calle);
                        $cliente->colonia = utf8_encode($colonia);
                        $cliente->estado = utf8_encode($estado);
                        $cliente->pais = utf8_encode($pais);
                        $cliente->direccion = utf8_encode($direccion);
                        $cliente->correoElectronico = utf8_encode($correoElectronico);                        
                       
                    }
                }
                
            }
            
        }else{
            echo "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return $cliente;
    }



    
}

