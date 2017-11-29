<?php
namespace php\repositorios;



use php\interfaces\IClientesRepositorio;
use php\modelos\Cliente;
use php\modelos\Resultado;


include "../interfaces/IClientesRepositorio.php";
include "../modelos/Cliente.php";
//include "../clases/Resultado.php";
include "RepositorioBase.php";
require_once("../clases/Resultado.php");

class ClientesRepositorio extends RepositorioBase implements IClientesRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function calcularId()
    {   
        $resultado = new Resultado();
        $consulta =  "SELECT MAX(IFNULL(BTCLIENTENUMERO,0))+1 AS id FROM BSTNTRN.BTCLIENTE";
        if($sentencia = $this->conexion->prepare($consulta))
        {        
            if($sentencia->execute())
            {
                if ($sentencia->bind_result($id))
                {
                    if($sentencia->fetch())
                    {
                        $resultado->valor = $id;
                    }                   
                    else
                        $resultado->mensajeError = "No se encontró ningún resultado";
                }
                else
                    $resultado->mensajeError = "Falló el enlace del resultado";
            }
            else
                $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;                       
        }
        else
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error; 
        return $resultado;
    }
    

    private function buscarIndice($campos, $campoId)
    {
        for($i = 0; $i < count($campos); $i++)
        {
            $campo = $campos[$i];
            if($campo->campoId == $campoId)
                return $i;
        }
        return -1;
    }
    public function insertar(Cliente $cliente)
    {            
        $resultado =  $this->calcularId();
        if($resultado->mensajeError=="")
        {
            $id = $resultado->valor;
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
                if( $sentencia->bind_param("isssssssssssssssss",$id, $cliente->primerNombre,
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
                    $cliente->correoElectronico))
                {
                    if(!$sentencia->execute())                
                        $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;                       
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";   
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;   
        }   
        return $resultado;
    }
    
    public function eliminar($llaves)
    {
        $resultado = new Resultado();
        $consulta = " DELETE FROM BSTNTRN.BTCLIENTE "
                    . "  WHERE BTCLIENTENUMERO  = ? ";
         if($sentencia = $this->conexion->prepare($consulta))
         {
             if($sentencia->bind_param("i",$llaves->id))
             {
                if($sentencia->execute())     
                {
                    $resultado->valor = $llaves->id;    
                }
                else
                    $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;                       
             }
             else
                 $resultado->mensajeError = "Falló el enlace de parámetros";    
         }
         else
             $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;     
         
        return $resultado;
    }

    public function actualizar(Cliente $cliente)
    {     
        $resultado = new Resultado();
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
            if($sentencia->bind_param("ssssssssssssssssss",$cliente->primerNombre,
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
                                                    $cliente->correoElectronico,
                                                    $cliente->id))
            {
               if($sentencia->execute())
               {
                   $resultado->valor=true;
               }
               else
                   $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;  
            }
            else  $resultado->mensajeError = "Falló el enlace de parámetros";  
        }
        else
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;   
        return $resultado;        
    }
    
    public function consultar($criteriosSeleccion)
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
                    . " BTCLIENTECORRELEC correoElectronico,"
                    . " BTCLIENTEREGIMEN regimen"
                    . " FROM BSTNTRN.BTCLIENTE  "
                    . " WHERE BTCLIENTENCOMPLETO like  CONCAT('%',?,'%') "
                    . " AND BTCLIENTERFC like  CONCAT('%',?,'%') "
                    . " AND BTCLIENTECURP like  CONCAT('%',?,'%') ";

        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("sss",$criteriosSeleccion->nombreCompleto,$criteriosSeleccion->rfc,$criteriosSeleccion->curp))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, $primerNombre, $segundoNombre, $apellidoPaterno, $apellidoMaterno,  $rfc, $nss, $curp, $codigoPostal, $numeroExterior, $numeroInterior, $calle, $colonia, $estado, $pais,  $correoElectronico, $regimen)  )
                    {                    
                        while($row = $sentencia->fetch())
                        {
                            $cliente = (object) [
                                'id' =>  utf8_encode($id),
                                'primerNombre' => utf8_encode($primerNombre),
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
                                'correoElectronico' => utf8_encode($correoElectronico),
                                'regimen' => utf8_encode($regimen)
                            ];  
                            array_push($clientes,$cliente);
                        }
                        $resultado->valor = $clientes; 
                    }           
                    else
                        $resultado->mensajeError = "Falló el enlace del resultado.";       
                }       
                else 
                    $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;                       
            }
            else
                $resultado->mensajeError = "Falló el enlace de parámetros";    
        }
        else                 
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;        
        
       
        return $resultado;     
    }    

    public function consultarPorLlaves($llaves)
    {
        $resultado = new Resultado();       
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
            if($sentencia->bind_param("i",$llaves->id))
            {
                if($sentencia->execute())
                {                    
                    if ($sentencia->bind_result($id, $primerNombre, $segundoNombre, $apellidoPaterno, $apellidoMaterno, $nombreCompleto, $rfc, $nss, $curp, $codigoPostal, $numeroExterior, $numeroInterior, $calle, $colonia, $estado, $pais, $direccion , $correoElectronico ))
                    {                        
                        if($sentencia->fetch())
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
                            $cliente->codigoPostal = utf8_encode($codigoPostal);
                            $cliente->numeroExterior = utf8_encode($numeroExterior);
                            $cliente->numeroInterior = utf8_encode($numeroInterior);
                            $cliente->calle = utf8_encode($calle);
                            $cliente->colonia = utf8_encode($colonia);
                            $cliente->estado = utf8_encode($estado);
                            $cliente->pais = utf8_encode($pais);
                            $cliente->direccion = utf8_encode($direccion);
                            $cliente->correoElectronico = utf8_encode($correoElectronico);
                            $resultado->valor = $cliente;
                        }
                        else
                            $resultado->mensajeError = "No se encontró ningún resultado.";
                    }
                    else
                        $resultado->mensajeError = "Falló el enlace del resultado";
                }
                else
                    $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;  
            }
            else
                $resultado->mensajeError = "Falló el enlace de parámetros";    
        } 
        else
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;     
       return $resultado;
    }

    public function consultarDinamicamente($filtros, $campos)
    {
        $resultado = new Resultado();
        $clientes = array();        
        
        $consulta = $this->select($campos);
        $consulta .= " FROM BSTNTRN.BTCLIENTE ";
     /*   $consulta =   " SELECT "
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
                        . " FROM BSTNTRN.BTCLIENTE  ";*/
        
        $consulta .= $this->where($filtros);               
        
     
        if($sentencia = $this->conexion->prepare($consulta))
        {     
           if($this->bind_param($sentencia,$filtros))
            {
                if($sentencia->execute())
                {
                    $resultado->valor = $this->get_result($sentencia);
                    
                
                    
                   /* if ($sentencia->bind_result($id, $primerNombre, $segundoNombre, $apellidoPaterno, $apellidoMaterno,  $rfc, $nss, $curp, $codigoPostal, $numeroExterior, $numeroInterior, $calle, $colonia, $estado, $pais,  $correoElectronico )  )
                    {
                        while($row = $sentencia->fetch())
                        {
                            $cliente = (object) [
                                'id' =>  utf8_encode($id),
                                'primerNombre' => utf8_encode($primerNombre),
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
                        */
                }
                else
                    $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
            }
            else
                $resultado->mensajeError = "Falló el enlace de parámetros";
        }
        else
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        return $resultado;
    }    

    public function insertarDinamicamente($filtros, $campos)
    {
        $resultado =  $this->calcularId();
        $llave = (object) [
            'campoId' =>  'BTCLIENTENUMERO'
        ];
        array_push($campos,$llave);
        if($resultado->mensajeError=="")
        {
            $id = $resultado->valor;
            $consulta = $this->insert('BTCLIENTE', $campos);
            
            if($sentencia = $this->conexion->prepare($consulta))
            {
                $llave = (object) [
                    'valor' =>  $id,
                    'tipoDato' => 'decimal'
                ];
                array_push($filtros,$llave);
                if($this->bind_param($sentencia,$filtros))
                {
                    if($sentencia->execute())
                        $resultado->valor = $id;
                        else
                            $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        return $resultado;
    }

    public function consultarDinamicamenteTelefono($numero, $campos)
    {
        $resultado = new Resultado();
        $clientes = array();
        
        $consulta = $this->select($campos);
        $consulta .= " FROM BSTNTRN.BTCLIENTE ";
        /*   $consulta =   " SELECT "
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
         . " FROM BSTNTRN.BTCLIENTE  ";*/
        $consulta .= " INNER JOIN BSTNTRN.BTCLIENTETEL on BTCLIENTE.BTCLIENTENUMERO = BTCLIENTETEL.BTCLIENTETELNOCTEID ";
        $consulta .= " where BTCLIENTETEL.BTCLIENTETELNO = ? ";
       //$consulta .= $this->where($filtros);
        
        
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$numero))
            {
                if($sentencia->execute())
                {
                    $resultado->valor = $this->get_result($sentencia);
                    
                    
                    
                    /* if ($sentencia->bind_result($id, $primerNombre, $segundoNombre, $apellidoPaterno, $apellidoMaterno,  $rfc, $nss, $curp, $codigoPostal, $numeroExterior, $numeroInterior, $calle, $colonia, $estado, $pais,  $correoElectronico )  )
                     {
                     while($row = $sentencia->fetch())
                     {
                     $cliente = (object) [
                     'id' =>  utf8_encode($id),
                     'primerNombre' => utf8_encode($primerNombre),
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
                     */
                }
                else
                    $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
            }
            else
                $resultado->mensajeError = "Falló el enlace de parámetros";
        }
        else
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
            return $resultado;
    }
    
    public function consultarDinamicamenteIdCliente($idCliente, $campos)
    {
        $resultado = new Resultado();
        $consulta = $this->select($campos);
        $consulta .= " FROM BSTNTRN.BTCLIENTE ";
        $consulta .= " where BTCLIENTE.BTCLIENTENUMERO = ? ";
                
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("s",$idCliente))
            {
                if($sentencia->execute())
                {
                    $clientes = $this->get_result($sentencia);
                    if(count($clientes) > 0)
                        $resultado->valor = $clientes[0];
                    
                }
                else
                    $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
            }
            else
                $resultado->mensajeError = "Falló el enlace de parámetros";
        }
        else
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
            return $resultado;
    }
    
    public function actualizarDinamicamente($valoresCampos)
    {
        $resultado = new Resultado();
    
        $indice = $this->buscarIndice($valoresCampos, "BTCLIENTENUMERO" );
        if($indice != -1)
        {
            $id = $valoresCampos[$indice]->valor;
            array_splice($valoresCampos,$indice,1);
            //unset($valoresCampos[$indice]);
            
            $consulta = $this->update('BTCLIENTE', $valoresCampos);
            $consulta .= " where BTCLIENTENUMERO = ? ";
            
            
            if($sentencia = $this->conexion->prepare($consulta))
            {
                $llave = (object) [
                    'valor' =>  $id,
                    'tipoDato' => 'decimal'
                ];
                array_push($valoresCampos,$llave);
                if($this->bind_param($sentencia,$valoresCampos))
                {
                    if($sentencia->execute())
                        $resultado->valor = $id;
                        else
                            $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;
                            
                }
                else
                    $resultado->mensajeError = "Falló el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        }
        else
            $resultado->mensajeError = "No se ha configurado el campo llave " . $this->conexion->error;
        
        return $resultado;
        
    }
    
}

