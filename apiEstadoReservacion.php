<?php
    include_once 'DBEstadoReservacion.php';
    include_once 'Mensajes.php';

    class ApiEstadosReservacion                        
    {

        //lista todos los datos
        function getAll()
        {
            $mensaje = new Mensajes_JSON();
            
            //creo un objeto de la clase estadoUsuaario, donde esta la consulta
            $estado = new estadoReservacion();
            $estados = array();

            $res = $estado->obtenerEstados();

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {
                    $item = array(
                        'id'        =>$row['idEstado'],
                        'estado'    =>$row['estado']
                    );
                    array_push($estados, $item);
                }
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($estados);
            }
            else
            {

                $mensaje->error('No hay elementos seleccionados');
               
            }
        }

        //consulta solo el id solicitado
        function getById($id)
        {
            
            //creo un objeto de la clase estadoUsuaario, donde esta la consulta
            $mensaje = new Mensajes_JSON();
            $estado = new estadoReservacion();
            $estados = array();
            $res = $estado->obtenerEstado($id);
 
            if($res->rowCount() == 1)
            {
                $row = $res->fetch();

                $item = array(
                    'id'      =>$row['idEstado'],
                    'estado'  =>$row['estado']
                );
                array_push($estados, $item);
                
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($estados);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }

        //registrar nuevo estado
        function add($item)
        {
            $estado = new estadoReservacion();
            $res = $estado->nuevoEstado($item);

            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos registrados');
        }

        //actualizar estado
        function update($item)
        {
           
            $estado = new estadoReservacion();
            $res = $estado->actualizarEstado($item);
            
            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos actualizados');
        }

        //eliminar estado
        function delete($id)
        {
            $mensaje = new Mensajes_JSON();
            $estado = new estadoReservacion();

            //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
            $res = $estado->validarEstadoID($id);
            
            $row = $res->fetch();
            //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
            if($row['cantidad'] == 0)
            {
                $res = $estado->eliminarEstado($id);
                $mensaje->exito('Datos eliminados con exito');
            }
            else
            {
                $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
            }
            
        }

    }

?>