<?php

    include_once 'conexion.php';

    class estadoEdificio extends ConexionDB
    {
        //consulta para listar todos los datos
        function obtenerEstados()
        {
            $id=0;
            $accion = "listar";
            $var = "null";
          
            $query = $this->connect()->prepare('Call getAllEstadoEdificio(:id, :accion, :var)');
            $query->execute(['id'=>$id, 'accion'=>$accion, 'var'=>$var]);
            return $query;
        }

        //se realiza la consulta en base al id solicitado
        function obtenerEstado($estado)
        {
 
            $query = $this->connect()->prepare('Call getAllEstadoEdificio(:id, :accion, :var)');
            $query->execute(['id'=>$estado['id'], 'accion'=>$estado['accion'], 'var'=>$estado['var']]);

            return $query;
        }

        //$estado es array de objetos que traera los datos a insertar
        function nuevoEstado($estado)
        {

            $query = $this->connect()->prepare('Call getAllEstadoEdificio(:id, :accion, :estado)');
            $query->execute(['id'=>$estado['id'], 'accion'=>$estado['accion'], 'estado'=>$estado['estado']]);

            return $query;
        }

        //consulta update
        function actualizarEstado($estado)
         {
            $query = $this->connect()->prepare('Call getAllEstadoEdificio(:id, :accion, :estado)');
            $query->execute(['id'=>$estado['id'], 'accion' =>$accion, 'estado'=>$estado['estado']]);

             return $query;
         }

         //antes de elimininar un estado se valida si este no a sido ocupado
         function validarEstadoID($id)
         {
            
            $query = $this->connect()->prepare('SELECT count(estado_edificio.idEstado) AS cantidad FROM edificio INNER JOIN estado_edificio
                                                ON edificio.idEstado = estado_edificio.idEstado
                                                WHERE estado_edificio.idEstado = :id');
            $query->execute(['id' =>$id]);
            
            return $query;
 
         }

         //una ves se ha validado que no el ID no esta siendo utilizado
         function eliminarEstado($estado)
         {
      
            $query = $this->connect()->prepare('Call getAllEstadoEdificio(:id, :accion, :var)');
            $query->execute(['id'=>$estado['id'], 'accion'=>$estado['accion'], 'var'=>$estado['var']]);

             return $query;
    
         }

        
    }


?>