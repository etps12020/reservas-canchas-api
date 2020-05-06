<?php
    include_once 'DBHorarioReservacion.php';
    include_once 'Mensajes.php';

    class ApiHorariosReservacion                        
    {

        //lista todos los datos
        function getAll()
        {
            $mensaje = new Mensajes_JSON();
            
            //creo un objeto de la clase estadoUsuaario, donde esta la consulta
            $horario = new horarioReservacion();
            $horarios = array();

            $res = $horario->obtenerHorarios();

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {
                    $item = array(
                        'id'            =>$row['idHorarioReservacion'],
                        'horaInicio'   =>$row['horaInicio'],
                        'horaFin'       =>$row['horaFin']
                    );
                    array_push($horarios, $item);
                }
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($horarios);
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
            $horario = new horarioReservacion();
            $horarios = array();

            $res = $horario->obtenerHorario($id);
 
            if($res->rowCount() == 1)
            {
                $row = $res->fetch();

                $item = array(
                    'id'           =>$row['idHorarioReservacion'],
                    'horaInicio'   =>$row['horaInicio'],
                    'horaFin'      =>$row['horaFin']
                );
                array_push($horarios, $item);
                
                header("HTTP/1.1 200 OK");
                $mensaje->printJSON($horarios);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }

        //registrar nuevo estado
        function add($item)
        {
            $horario = new horarioReservacion();
            $res = $horario->nuevoHorario($item);

            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos registrados');
        }

        //actualizar estado
        function update($item)
        {
           
            $horario = new horarioReservacion();
            $res = $horario->actualizarHorario($item);
            
            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos actualizados');
        }

        //eliminar estado
        function delete($id)
        {
            $mensaje = new Mensajes_JSON();
            $horario = new horarioReservacion();

            //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
            $res = $horario->validarHorarioID($id);
            
            $row = $res->fetch();
            //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
            if($row['cantidad'] == 0)
            {
                $res = $horario->eliminarHorario($id);
                $mensaje->exito('Datos eliminados con exito');
            }
            else
            {
                $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
            }
            
        }

    }

?>