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
    
    public function bind_param($sentencia, $filtros)
    {
        $bind = false;
        if(count($filtros)>0)
        {
            $types = $this->types($filtros);
            $bind_names[] = $types;
            for ($i=0; $i<count($filtros);$i++)
            {
                $bind_name = 'bind' . $i;
                $$bind_name = $filtros[$i]->valor;
                $bind_names[] = &$$bind_name;
            }
            $bind = call_user_func_array(array($sentencia,'bind_param'),$bind_names);
        }
        else
            $bind = true;
       return $bind;
    }
    
    public function get_result($sentencia)
    {
        $registros = array();
        $meta = $sentencia->result_metadata();        
        while ($field = $meta->fetch_field()) {
            $var = $field->name;
            $$var = null;
            $fields[$var] = &$$var;
        }
        $bind = call_user_func_array(array($sentencia, 'bind_result'), $fields);
        
        $i = 0;
        while ($sentencia->fetch()) 
        {
            $results[$i] = array();
            foreach($fields as $k => $v)
                $results[$i][$k] = $v;
            $i++;
        }    
        return $results;
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
    
    public function select($campos)
    {        
        $texto = "";
        if($campos)
        {
            $texto = "SELECT ";
            for($i = 0; $i < count($campos); $i++)
            {
                $campo = $campos[$i];
                $texto .= trim($campo->tablaId) . "." . trim($campo->campoId) . " AS C" . $campo->id ;
                if($i < count($campos) - 1)
                    $texto .= ", ";
            }
        }
       
        return $texto;
    }
    public function insert($tablaId, $campos)
    {
        $texto = "";
        if($campos)
        {
            $texto = "INSERT INTO ".$tablaId." ( ";
            for($i = 0; $i < count($campos); $i++)
            {
                $campo = $campos[$i];
                $texto .= trim($campo->campoId);
                if($i < count($campos) - 1)
                    $texto .= ", ";
            }
            $texto .= ') VALUES( ';
            for($i = 0; $i < count($campos); $i++)
            {
                $texto .= '?' ;
                if($i < count($campos) - 1)
                    $texto .= ", ";
            }
            $texto .= ')';
        }      
        
        return $texto;
    }
    
    public function update($tablaId, $campos)
    {
        $texto = "";
        if($campos)
        {
            $texto = "UPDATE ".$tablaId." SET ";
            for($i = 0; $i < count($campos); $i++)
            {
                $campo = $campos[$i];
                $texto .= trim($campo->campoId) ." = ? ";
                if($i < count($campos) - 1)
                    $texto .= ", ";
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

