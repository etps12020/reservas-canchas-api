<?php
    include_once 'DBEdificio.php';
    include_once 'Mensajes.php';

    class ApiEdificios                        
    {

        //lista todos los datos
        function getAll()
        {
            $mensaje = new Mensajes_JSON();
            
            $edificio = new edificio();
            $edificios = array();

            $res = $edificio->obtenerEdificios();

            if($res->rowCount())
            {
                while($row = $res->fetch(PDO::FETCH_ASSOC))
                {
                    $item = array(
                        'id'            =>$row['idEdificio'],
                        'nombre'        =>$row['nombre'],
                        'direccion'     =>$row['direccion'],
                        'estado'        =>$row['estado'],
                        'descripcion'   =>$row['descripcion'],
                        'imagen'        =>base64_encode($row['imagen'])
                    );
                    array_push($edificios, $item);
                }
                $mensaje->printJSON($edificios);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }

        //consulta solo el id solicitado
        function getById($id)
        {
            $mensaje = new Mensajes_JSON();

            $edificio = new edificio();
            $item = ['id'=>$id, 'accion'=>'buscar'];
            $res = $edificio->obtenerEdificio($item);
            $edificios = array();
 
            if($res->rowCount() == 1)
            {
                $row = $res->fetch();

                $item = array(
                    'id'            =>$row['idEdificio'],
                    'nombre'        =>$row['nombre'],
                    'direccion'     =>$row['direccion'],
                    'estado'        =>$row['estado'],
                    'descripcion'   =>$row['descripcion'],
                    'imagen'        =>base64_encode($row['imagen']),
                );
                array_push($edificios, $item);
 
                $mensaje->printJSON($edificios);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }


        //registrar
        function add($item)
        {
            $edificio = new edificio();
            $res = $edificio->nuevoEdificio($item);

            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos registrados');
        }

        //actualizar
        function update($item)
        {
           
            $edificio = new edificio();
            $res = $edificio->actualizarEdificio($item);
            
            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos actualizados');
        }

         //eliminar
         function delete($id)
         {
             $mensaje = new Mensajes_JSON();
             $edificio = new edificio();
             //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
             $res = $edificio->validarEdificioID($id);
             
             $row = $res->fetch();

             //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
             if($row['cantidad'] == 0)
             {
                $item = ['id'=>$id, 'accion'=>'eliminar'];
                $res = $edificio->eliminarEdificio($item);
                $mensaje->exito('Datos eliminados con exito');

             }
             else
             {
                 $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
             }
             
         }

    }

?>