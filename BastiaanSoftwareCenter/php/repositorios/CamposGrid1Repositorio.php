<?php
namespace php\repositorios;


use php\interfaces\ICamposGrid1Repositorio;
use php\modelos\Resultado;

include "../interfaces/ICamposGrid1Repositorio.php";
//include "../clases/Resultado.php";
require_once("../clases/Resultado.php");

class CamposGrid1Repositorio implements ICamposGrid1Repositorio
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
       
        $consulta =   " SELECT BTGRID1ID id, CR.BTCAMPOID campoId, BTGRID1ORDEN orden, BTGRID1PRESENTACION presentacion, BTGRID1TITULO titulo, BTTABLAID tablaId, BTCAMPOTIPO tipoDato, BTCAMPOTAMANO tamano " .
                        "FROM BSTNTRN.BTGRID1 CR ".
                        "   INNER JOIN BSTNTRN.BTCAMPO C ON CR.BTCAMPOID = C.BTCAMPOID " .
                        "WHERE BTVERSIONID = ? ".
                        "ORDER BY BTGRID1ORDEN";
     
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
                $resultado->mensajeError = "Falló el enlace de parámetros";    
        }
        else                 
            $resultado->mensajeError = "Falló la preparación: (" . $this->conexion->errno . ") " . $this->conexion->error;        
        
       
        return $resultado;     
    }        
}

