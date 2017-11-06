<?php
namespace php\repositorios;

class RepositorioBase
{
    public function where($filtros)
    {
        $texto = "";
        if($filtros)
        {
            $texto = " WHERE ";
            for($i = 0; $i < count($filtros); $i++)
            {
                $filtro = $filtros[$i];
                if($this->esCadena($filtro->tipoDato))
                    $texto .= trim($filtro->tablaId) . "." . trim($filtro->campoId) . " LIKE CONCAT('%',?,'%') ";
                else 
                    $texto .= trim($filtro->tablaId) . "." . trim($filtro->campoId) . " = ? ";
                if($i < count($filtros) - 1)
                    $texto .= " AND ";
                    
            }
        } 
        return $texto;
    }
    
    public function types($filtros)
    {
        $texto = "";
        if($filtros)
        {           
            for($i = 0; $i < count($filtros); $i++)
            {
                $filtro = $filtros[$i];
                if($this->esCadena($filtro->tipoDato))
                    $texto .= "s";
                else
                    $texto .= "i";
            }
        }
        return $texto;
    }
    
    public function esCadena($tipoDato)
    {
        if(strtolower($tipoDato) == 'varchar')
            return true;
        else 
            return false;
    }
}

