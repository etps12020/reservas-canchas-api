<?php

include_once 'conexion.php';

class rolUsuario extends ConexionDB
{
    //consulta para listar todos los datos
    function obtenerRoles()
    {
        $id=0;
        $accion = "listar";
        $var = "null";
        
        $query = $this->connect()->prepare('Call getAllRolUsuario(:id, :accion, :var)');
        $query->execute(['id'=>$id, 'accion'=>$accion, 'var'=>$var]);
        return $query;
    }

    //se realiza la consulta en base al id solicitado
    function obtenerRol($id)
    {
        $accion = "buscar";
        $var = "null";
        
        $query = $this->connect()->prepare('Call getAllRolUsuario(:id, :accion, :var)');
        $query->execute(['id'=>$id, 'accion'=>$accion, 'var'=>$var]);

        return $query;
    }

    //$rol es array de objetos que traera los datos a insertar
    function nuevoRol($rol)
    {
        $id = 0;
        $accion = "insertar";

        $query = $this->connect()->prepare('Call getAllRolUsuario(:id, :accion, :rol)');
        $query->execute(['id'=>$id, 'accion' =>$accion, 'rol'=>$rol['rol']]);

        return $query;
    }

    //consulta update
    function actualizarRol($rol)
    {
        $accion = "update";
        
        $query = $this->connect()->prepare('Call getAllRolUsuario(:id, :accion, :rol)');
        $query->execute(['id' => $rol['id'], 'accion'=>$accion, 'rol'=>$rol['rol']]);

        return $query;
     }

     //antes de elimininar un estado se valida si este no a sido ocupado
     function validarRolID($id)
     {
        
        $query = $this->connect()->prepare('SELECT COUNT(idUsuario) AS cantidad FROM usuario INNER JOIN rol_usuario
        ON rol_usuario.idRolUsuario = usuario.idRol WHERE idRolUsuario = :id');
        $query->execute(['id' =>$id]);
        
        return $query;

     }

     //una ves se ha validado que no el ID no esta siendo utilizado
     function eliminarRol($id)
     {
        $accion = "eliminar";
        $var = "null";
        
        $query = $this->connect()->prepare('Call getAllRolUsuario(:id, :accion, :var)');
        $query->execute(['id'=>$id, 'accion'=>$accion, 'var'=>$var]);

         return $query;

     }

    
}
?>