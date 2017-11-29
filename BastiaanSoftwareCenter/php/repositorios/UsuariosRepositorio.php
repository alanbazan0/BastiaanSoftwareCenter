<?php
namespace php\repositorios;

use Exception;
use php\interfaces\IUsuariosRepositorio;
use php\modelos\Usuario;
use php\modelos\Resultado;

include "../interfaces/IUsuariosRepositorio.php";
include "../modelos/Usuario.php";
include "../clases/Resultado.php";

class UsuariosRepositorio implements IUsuariosRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
    public function insertar(Usuario $usuario)
    {
        $resultado =  "";
       
            $consulta = " INSERT INTO BSTNTRN.SIOUSUARIO "
                . " (SIOUSUARIOID, "
                . " SIOUSUARIOPSW, "
                . " SIOUSUARIOPNOMBRE, "
                . " SIOUSUARIOSNOMBRE, "
                . " SIOUSUARIOAPATERNO, "
                . " SIOUSUARIOAMATERNO, "
                . " SIOUSUARIONCOMPLETO, "
                . " SIOUSUARIOGENEROID, "
                . " SIOUSUARIONAL, "
                . " SIOUSUARIOFNAC, "
                . " SIOUSUARIORFC, "
                . " SIOUSUARIONSS, "
                . " SIOUSUARIOCURP, "
                . " SIOUSUARIOCPOSTAL, "
                . " SIOUSUARIONOEXT, "
                . " SIOUSUARIONOINT, "
                . " SIOUSUARIOCALLE, "
                . " SIOUSUARIOCOL, "
                . " SIOUSUARIOEDO, "
                . " SIOUSUARIOPAIS, "
                . " SIOUSUARIOCD, "
                . " SIOUSUARIODCOMPLETA, "
                . " SIOUSUARIOCEPER, "
                . " SIOUSUARIOCEEMP, "
                . " SIOUSUARIOTELCEL, "
                . " SIOUSUARIOTELCASA, "
                . " SIOUSUARIOTELCONT, "
                . " SIOUSUARIONOEMP, "
                . " SIOUSUARIOFING, "
                . " SIOUSUARIOBANCO, "
                . " SIOUSUARIOCBEBANC, "
                . " SIOUSUARIOSUELDO, "
                . " SIOUSUARIOFBAJA, "
                . " SIOUSUARIOMBAJAID, "
                . " SIOUSUARIOEXTENSION) "
                . " VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
     if($sentencia = $this->conexion->prepare($consulta))
        {
         if( $sentencia->bind_param("sssssssssssssssssssssssssssssssssss",$usuario->id, 
            $usuario->password,
            $usuario->primerNombre,
            $usuario->segundoNombre,
            $usuario->apellidoPaterno,
            $usuario->apellidoMaterno,
            $usuario->nombreCompleto,
            $usuario->idGenero,
            $usuario->nacionalidad,
            $usuario->fechaNacimiento,
            $usuario->rfc,
            $usuario->nss,
            $usuario->curp,
            $usuario->codigoPostal,
            $usuario->numeroExterior,
            $usuario->numeroInterior,
            $usuario->calle,
            $usuario->colonia,
            $usuario->estado,
            $usuario->pais,
            $usuario->ciudad,
            $usuario->direccion,
            $usuario->correoElectronicoPersonal,
            $usuario->correoElectronicoEmpresa,
            $usuario->telefonoCelular,
            $usuario->telefonoCasa,
            $usuario->telefonoContacto,
            $usuario->numeroEmpleado,
            $usuario->fechaIngreso,
            $usuario->tipoBanco,
            $usuario->claveBancaria,
            $usuario->sueldo,
            $usuario->fechaBaja,
            $usuario->idBaja,
            $usuario->extensionUsuario))
     {
       if(!$sentencia->execute())
     $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
      }
  else
       $resultado->mensajeError = "Fall� el enlace de par�metros";
       }
         else
   $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
        
        return $resultado;
    }
    
    public function eliminar($llaves)
    {
        $resultado = new Resultado();
        $consulta = " DELETE FROM BSTNTRN.SIOUSUARIO "
            . "  WHERE SIOUSUARIOID  = ? ";
            if($sentencia = $this->conexion->prepare($consulta))
            {
                if($sentencia->bind_param("s",$llaves->id))
                {
                    if($sentencia->execute())
                    {
                        $resultado->valor = $llaves->id;
                    }
                    else
                        $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
                }
                else
                    $resultado->mensajeError = "Fall� el enlace de par�metros";
            }
            else
                $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
                
                return $resultado;
    }
    
    public function actualizar(Usuario $usuario)
    {
        $resultado = new Resultado();
        $consulta = " UPDATE BSTNTRN.SIOUSUARIO SET"
        . " SIOUSUARIOPSW = ?, "
        . " SIOUSUARIOPNOMBRE = ?, "
        . " SIOUSUARIOSNOMBRE = ?, "
        . " SIOUSUARIOAPATERNO = ?, "
        . " SIOUSUARIOAMATERNO = ?, "
        . " SIOUSUARIONCOMPLETO = ?, "
        . " SIOUSUARIOGENEROID = ?, "
        . " SIOUSUARIONAL = ?, "
        . " SIOUSUARIOFNAC = ?, "
        . " SIOUSUARIORFC = ?, "
        . " SIOUSUARIONSS = ?, "
        . " SIOUSUARIOCURP = ?, "
        . " SIOUSUARIOCPOSTAL = ?, "
        . " SIOUSUARIONOEXT = ?, "
        . " SIOUSUARIONOINT = ?, "
        . " SIOUSUARIOCALLE = ?, "
        . " SIOUSUARIOCOL = ?, "
        . " SIOUSUARIOEDO = ?, "
        . " SIOUSUARIOPAIS = ?, "
        . " SIOUSUARIOCD = ?, "
        . " SIOUSUARIODCOMPLETA = ?, "
        . " SIOUSUARIOCEPER = ?, "
        . " SIOUSUARIOCEEMP = ?, "
        . " SIOUSUARIOTELCEL = ?, "
        . " SIOUSUARIOTELCASA = ?, "
        . " SIOUSUARIOTELCONT = ?, "
        . " SIOUSUARIONOEMP = ?, "
        . " SIOUSUARIOFING = ?, "
        . " SIOUSUARIOBANCO = ?, "
        . " SIOUSUARIOCBEBANC = ?, "
        . " SIOUSUARIOSUELDO = ?, "
        . " SIOUSUARIOFBAJA = ?, "
        . " SIOUSUARIOMBAJAID = ?, "
        . " SIOUSUARIOEXTENSION = ? "
        . " WHERE SIOUSUARIOID = ? ";
  if($sentencia = $this->conexion->prepare($consulta))
  {
      if($sentencia->bind_param("sssssssssssssssssssssssssssssssssss",
          $usuario->password,
          $usuario->primerNombre,
          $usuario->segundoNombre,
          $usuario->apellidoPaterno,
          $usuario->apellidoMaterno,
          $usuario->nombreCompleto,
          $usuario->idGenero,
          $usuario->nacionalidad,
          $usuario->fechaNacimiento,
          $usuario->rfc,
          $usuario->nss,
          $usuario->curp,
          $usuario->codigoPostal,
          $usuario->numeroExterior,
          $usuario->numeroInterior,
          $usuario->calle,
          $usuario->colonia,
          $usuario->estado,
          $usuario->pais,
          $usuario->ciudad,
          $usuario->direccion,
          $usuario->correoElectronicoPersonal,
          $usuario->correoElectronicoEmpresa,
          $usuario->telefonoCelular,
          $usuario->telefonoCasa,
          $usuario->telefonoContacto,
          $usuario->numeroEmpleado,
          $usuario->fechaIngreso,
          $usuario->tipoBanco,
          $usuario->claveBancaria,
          $usuario->sueldo,
          $usuario->fechaBaja,
          $usuario->idBaja,
          $usuario->extensionUsuario,
          $usuario->id))
   {
    if($sentencia->execute())
   {
   $resultado->valor=true;
   }
 else
  $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
   }
 else  $resultado->mensajeError = "Fall� el enlace de par�metros";
  }
  else
  $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
   return $resultado;
    }
    
    public function consultar($criteriosSeleccion)
    {
        $resultado = new Resultado();
        $usuarios = array();
        
        $consulta =   " SELECT "
        . " SIOUSUARIOID id, "
        . " SIOUSUARIOPSW password, "
        . " SIOUSUARIOPNOMBRE primerNombre, "
        . " SIOUSUARIOSNOMBRE segundoNombre, "
        . " SIOUSUARIOAPATERNO apellidoPaterno, "
        . " SIOUSUARIOAMATERNO apellidoMaterno, "
        . " SIOUSUARIONCOMPLETO nombreCompleto, "
        . " SIOUSUARIOGENEROID idGenero, "
        . " SIOUSUARIONAL nacionalidad, "
        . " DATE_FORMAT(SIOUSUARIOFNAC,'%d/%m/%Y') fechaNacimiento, "
        . " SIOUSUARIORFC rfc, "
        . " SIOUSUARIONSS nss, "
        . " SIOUSUARIOCURP curp, "
        . " SIOUSUARIOCPOSTAL codigoPostal, "
        . " SIOUSUARIONOEXT numeroExterior, "
        . " SIOUSUARIONOINT numeroInterior, "
        . " SIOUSUARIOCALLE calle, "
        . " SIOUSUARIOCOL colonia, "
        . " SIOUSUARIOEDO estado, "
        . " SIOUSUARIOPAIS pais, "
        . " SIOUSUARIOCD ciudad, "
        . " SIOUSUARIODCOMPLETA direccion, "
        . " SIOUSUARIOCEPER correoElectronicoPersonal, "
        . " SIOUSUARIOCEEMP correoElectronicoEmpresa, "
        . " SIOUSUARIOTELCEL telefonoCelular, "
        . " SIOUSUARIOTELCASA telefonoCasa, "
        . " SIOUSUARIOTELCONT telefonoContacto, "
        . " SIOUSUARIONOEMP numeroEmpleado, "
        . " SIOUSUARIOFING fechaIngreso, "
        . " SIOUSUARIOBANCO tipoBanco, "
        . " SIOUSUARIOCBEBANC claveBancaria, "
        . " SIOUSUARIOSUELDO sueldo, "
        . " SIOUSUARIOFBAJA fechaBaja, "
        . " SIOUSUARIOMBAJAID idBaja, "
        . " SIOUSUARIOEXTENSION extensionUsuario "
        . " FROM BSTNTRN.SIOUSUARIO  "
        . " WHERE SIOUSUARIONCOMPLETO like  CONCAT('%',?,'%') "
        . " AND SIOUSUARIORFC like  CONCAT('%',?,'%') "
        . " AND SIOUSUARIOCURP like  CONCAT('%',?,'%') ";
        
if($sentencia = $this->conexion->prepare($consulta))
  {
    if($sentencia->bind_param("sss",$criteriosSeleccion->nombreCompleto,$criteriosSeleccion->rfc,$criteriosSeleccion->curp))
       {
         if($sentencia->execute())
           {
               if ($sentencia->bind_result($id,$password, $primerNombre, $segundoNombre, $apellidoPaterno, $apellidoMaterno, $nombreCompleto, $idGenero, $nacionalidad, $fechaNacimiento, $rfc, $nss, $curp, $codigoPostal, $numeroExterior, $numeroInterior, $calle, $colonia, $estado, $pais, $ciudad, $direccion, $correoElectronicoPersonal, $correoElectronicoEmpresa, $telefonoCelular, $telefonoCasa, $telefonoContacto, $numeroEmpleado, $fechaIngreso, $tipoBanco, $claveBancaria, $sueldo, $fechaBaja, $idBaja, $extensionUsuario  )  )
                {
                  while($row = $sentencia->fetch())
                    {
                      $usuario = (object) [
                 'id' =>  utf8_encode($id),
                 'password' =>  utf8_encode($password),
                 'primerNombre' => utf8_encode($primerNombre),
                 'segundoNombre' => utf8_encode($segundoNombre),
                 'apellidoPaterno' => utf8_encode($apellidoPaterno),
                 'apellidoMaterno' => utf8_encode($apellidoMaterno),
                 'nombreCompleto' => utf8_encode($nombreCompleto),
                 'idGenero' => utf8_encode($idGenero),
                 'nacionalidad' => utf8_encode($nacionalidad),
                 'fechaNacimiento' => utf8_encode($fechaNacimiento),
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
                 'ciudad' => utf8_encode($ciudad),
                 'direccion' => utf8_encode($direccion),
                 'correoElectronicoPersonal' => utf8_encode($correoElectronicoPersonal),
                 'correoElectronicoEmpresa' => utf8_encode($correoElectronicoEmpresa),
                 'telefonoCelular' => utf8_encode($telefonoCelular),
                 'telefonoCasa' => utf8_encode($telefonoCasa),
                 'telefonoContacto' => utf8_encode($telefonoContacto),
                 'numeroEmpleado' => utf8_encode($numeroEmpleado),
                 'fechaIngreso' => utf8_encode($fechaIngreso),
                 'tipoBanco' => utf8_encode($tipoBanco),
                 'claveBancaria' => utf8_encode($claveBancaria),
                 'sueldo' => utf8_encode($sueldo),
                 'fechaBaja' => utf8_encode($fechaBaja),
                 'idBaja' => utf8_encode($idBaja),
                 'extensionUsuario' => utf8_encode($extensionUsuario)
                  ];
 array_push($usuarios,$usuario);
  }
  $resultado->valor = $usuarios;
  }
           else
       $resultado->mensajeError = "Fall� el enlace del resultado.";
         }
     else
   $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
      }
   else
 $resultado->mensajeError = "Fall� el enlace de par�metros";
 }
  else
 $resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
        return $resultado;
    }
    //prompt
    public function consultarPorPostal($criteriosPostales)
    
    {
        $resultado = new Resultado();
        $postales = array();
        
        $consulta = " SELECT BTCPOSTALIDN idPostal, BTCPOSTALID nirPostal, BTCPOSTALASENT asentamientoPostal, BTCPOSTALMPIO municipioPostal, BTCPOSTALESTADO estadoPostal, BTCPOSTALCIUDAD ciudadPostal ".
          " FROM BSTNTRN.BTCPOSTAL "
           ." WHERE BTCPOSTALIDN like CONCAT ('%',?,'%')"
           ." AND BTCPOSTALID like CONCAT ('%',?,'%')";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("ss",$criteriosPostales->idPostal,
                $criteriosPostales->nirPostal))
            {
                if($sentencia->execute())
                {
                    if ($sentencia->bind_result($idPostal, $nirPostal, $asentamientoPostal, $municipioPostal, $estadoPostal, $ciudadPostal)  )
                    {
                        while($row = $sentencia->fetch())
                        {
                            $postal = (object) [
                                'idPostal' => utf8_encode($idPostal),
                                'nirPostal' =>  utf8_encode($nirPostal),
                                'asentamientoPostal' => utf8_encode($asentamientoPostal),
                                'municipioPostal' => utf8_encode($municipioPostal),
                                'estadoPostal' => utf8_encode($estadoPostal),
                                'ciudadPostal' => utf8_encode($ciudadPostal)
                            ];
                            array_push($postales,$postal);
                        }
                        $resultado->valor = $postales; 
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
        . " SIOUSUARIOID id, "
        . " SIOUSUARIOPSW password, "
        . " SIOUSUARIOPNOMBRE primerNombre, "
        . " SIOUSUARIOSNOMBRE segundoNombre, "
        . " SIOUSUARIOAPATERNO apellidoPaterno, "
        . " SIOUSUARIOAMATERNO apellidoMaterno, "
        . " SIOUSUARIONCOMPLETO nombreCompleto, "
        . " SIOUSUARIOGENEROID idGenero, "
        . " SIOUSUARIONAL nacionalidad, "
        . " SIOUSUARIOFNAC fechaNacimiento, "
        . " SIOUSUARIORFC rfc, "
        . " SIOUSUARIONSS nss, "
        . " SIOUSUARIOCURP curp, "
        . " SIOUSUARIOCPOSTAL codigoPostal, "
        . " SIOUSUARIONOEXT numeroExterior, "
        . " SIOUSUARIONOINT numeroInterior, "
        . " SIOUSUARIOCALLE calle, "
        . " SIOUSUARIOCOL colonia, "
        . " SIOUSUARIOEDO estado, "
        . " SIOUSUARIOPAIS pais, "
        . " SIOUSUARIOCD ciudad, "
        . " SIOUSUARIODCOMPLETA direccion, "
        . " SIOUSUARIOCEPER correoElectronicoPersonal, "
        . " SIOUSUARIOCEEMP correoElectronicoEmpresa, "
        . " SIOUSUARIOTELCEL telefonoCelular, "
        . " SIOUSUARIOTELCASA telefonoCasa, "
        . " SIOUSUARIOTELCONT telefonoContacto, "
        . " SIOUSUARIONOEMP numeroEmpleado, "
        . " SIOUSUARIOFING fechaIngreso, "
        . " SIOUSUARIOBANCO tipoBanco, "
        . " SIOUSUARIOCBEBANC claveBancaria, "
        . " SIOUSUARIOSUELDO sueldo, "
        . " SIOUSUARIOFBAJA fechaBaja, "
        . " SIOUSUARIOMBAJAID idBaja, "
        . " SIOUSUARIOEXTENSION extensionUsuario "
        . " FROM BSTNTRN.SIOUSUARIO  "
        . " WHERE SIOUSUARIOID  = ?";
     if($sentencia = $this->conexion->prepare($consulta))
        {
         if($sentencia->bind_param("s",$llaves->id))
           {
            if($sentencia->execute())
              {
                  if ($sentencia->bind_result($id,$password, $primerNombre, $segundoNombre, $apellidoPaterno, $apellidoMaterno, $nombreCompleto, $idGenero, $nacionalidad,$fechaNacimiento, $rfc, $nss, $curp, $codigoPostal, $numeroExterior, $numeroInterior, $calle, $colonia, $estado, $pais, $ciudad, $direccion, $correoElectronicoPersonal, $correoElectronicoEmpresa, $telefonoCelular, $telefonoCasa, $telefonoContacto, $numeroEmpleado, $fechaIngreso, $tipoBanco, $claveBancaria, $sueldo, $fechaBaja, $idBaja, $extensionUsuario  ))
                   {
                     if($sentencia->fetch())
                       {
                        $usuario = new Usuario();
                        $usuario-> id =  utf8_encode($id);
                        $usuario-> password =  utf8_encode($password);
                        $usuario->primerNombre = utf8_encode($primerNombre);
                        $usuario->segundoNombre = utf8_encode($segundoNombre);
                        $usuario->apellidoPaterno = utf8_encode($apellidoPaterno);
                        $usuario-> apellidoMaterno = utf8_encode($apellidoMaterno);
                        $usuario-> nombreCompleto = utf8_encode($nombreCompleto);
                        $usuario->idGenero = utf8_encode($idGenero);
                        $usuario->nacionalidad = utf8_encode($nacionalidad);
                        $usuario->fechaNacimiento= utf8_encode($fechaNacimiento);
                        $usuario->rfc = utf8_encode($rfc);
                        $usuario->nss = utf8_encode($nss);
                        $usuario-> curp = utf8_encode($curp);
                        $usuario->codigoPostal = utf8_encode($codigoPostal);
                        $usuario->numeroExterior = utf8_encode($numeroExterior);
                        $usuario->numeroInterior = utf8_encode($numeroInterior);
                        $usuario->calle = utf8_encode($calle);
                        $usuario->colonia = utf8_encode($colonia);
                        $usuario->estado = utf8_encode($estado);
                        $usuario->pais = utf8_encode($pais);
                        $usuario->ciudad = utf8_encode($ciudad);
                        $usuario->direccion = utf8_encode($direccion);
                        $usuario->correoElectronicoPersonal = utf8_encode($correoElectronicoPersonal);
                        $usuario->correoElectronicoEmpresa = utf8_encode($correoElectronicoPersonal);
                        $usuario->telefonoCelular = utf8_encode($telefonoCelular);
                        $usuario->telefonoCasa = utf8_encode($telefonoCasa);
                        $usuario->telefonoContacto = utf8_encode($telefonoContacto);
                        $usuario->numeroEmpleado = utf8_encode($numeroEmpleado);
                        $usuario->fechaIngreso = utf8_encode($fechaIngreso);
                        $usuario->tipoBanco = utf8_encode($tipoBanco);
                        $usuario->claveBancaria = utf8_encode($claveBancaria);
                        $usuario->sueldo = utf8_encode($sueldo);
                        $usuario->fechaBaja = utf8_encode($fechaBaja);
                        $usuario->idBaja = utf8_encode($idBaja);
                        $usuario->extensionUsuario = utf8_encode($extensionUsuario);
                        $resultado->valor = $usuario;
  }
       else
    $resultado->mensajeError = "No se encontr� ning�n resultado.";
     }
      else
   $resultado->mensajeError = "Fall� el enlace del resultado";
     }
   else
  $resultado->mensajeError = "Fall� la ejecuci�n (" . $this->conexion->errno . ") " . $this->conexion->error;
   }
   else
  $resultado->mensajeError = "Fall� el enlace de par�metros";
 }
  else
$resultado->mensajeError = "Fall� la preparaci�n: (" . $this->conexion->errno . ") " . $this->conexion->error;
 return $resultado;
    }
    
    
    public function consultarPorIdContrasena($id, $contrasena)
    {
        $resultado = new Resultado();
        $consulta = "SELECT SIOUSUARIOID id, SIOUSUARIONCOMPLETO nombre, SIOUSUARIOEXTENSION extension " .
            "FROM SIOUSUARIO " .
            "WHERE SIOUSUARIOID = ? AND SIOUSUARIOPSW = ?";
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("ss",$id,$contrasena))
            {
                if($sentencia->execute())
                {
                    
                    if ($sentencia->bind_result($id, $nombre, $extension))
                    {                        
                        if ($sentencia->fetch())
                        {
                            $usuario = (object) [
                                'id' =>  utf8_encode($id),
                                'nombre' => utf8_encode($nombre),
                                'extension' => utf8_encode($extension)
                            ];
                            $resultado->valor = $usuario;
                        }
                        else
                            $resultado->mensajeError = "La combinación de usuario y contraseña es incorrecta.";
                    }
                    else
                        $resultado->mensajeError = "Falló el enlace del resultado";
                }
                else 
                    $resultado->mensajeError = "Falló el enlace de parámetros";
            }
            else
                $resultado->mensajeError = "Falló el enlace de parámetros";
        }
        else
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;
        return $resultado;
    }   
    
    
    
}

