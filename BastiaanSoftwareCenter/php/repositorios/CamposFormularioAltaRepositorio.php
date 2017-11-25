<?php
namespace php\repositorios;


use php\interfaces\ICamposFormularioAltaRepositorio;
use php\modelos\Resultado;

include "../interfaces/ICamposFormularioAltaRepositorio.php";
//include "../clases/Resultado.php";
require_once("../clases/Resultado.php");

class CamposFormularioAltaRepositorio implements ICamposFormularioAltaRepositorio
{
    protected $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    
   
    public function consultarPorVersion($version)
    {     
        $resultado = new Resultado();
        $registros = array();     
       
        $consulta =   " SELECT BTFRMALTID id, CR.BTCAMPOID campoId, BTFRMALTORDEN orden, BTFRMALTPRESENTACION presentacion, BTFRMALTTITULO titulo, BTTABLAID tablaId, BTCAMPOTIPO tipoDato, BTCAMPOTAMANO tamano ".
                      "  FROM BSTNTRN.BTFRMALT CR". 
                          " INNER JOIN BSTNTRN.BTCAMPO C ON CR.BTCAMPOID = C.BTCAMPOID ".  
                       " WHERE BTVERSIONID =  ? ".
                       " ORDER BY BTFRMALTORDEN ";
     
        if($sentencia = $this->conexion->prepare($consulta))
        {
            if($sentencia->bind_param("i",$version))
            {
                if($sentencia->execute())
                {                
                    if ($sentencia->bind_result($id, $campoId, $orden, $presentacion, $titulo,  $tablaId, $tipoDato, $tamano))
                    {                    
                        while($sentencia->fetch())
                        {
                            $registro = (object) [
                                'id' =>  utf8_encode($id),
                                'campoId' => utf8_encode($campoId),
                                'orden' => utf8_encode($orden),
                                'presentacion' => utf8_encode($presentacion),
                                'titulo' => utf8_encode($titulo),
                                'tablaId' => utf8_encode($tablaId),
                                'tipoDato' => utf8_encode($tipoDato),
                                'tamano' => utf8_encode($tamano)                                
                            ];  
                            array_push($registros,$registro);
                        }
                        $resultado->valor = $registros; 
                    }           
                    else
                        $resultado->mensajeError = "Falló el enlace del resultado.";       
                }       
                else 
                    $resultado->mensajeError = "Falló la ejecución (" . $this->conexion->errno . ") " . $this->conexion->error;                       
            }
            else
                $resultado->mensajeError = "Falló el enlace de parémetros";    
        }
        else                 
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;        
        
       
        return $resultado;     
    }        
}

