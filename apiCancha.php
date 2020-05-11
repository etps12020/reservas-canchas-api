<?php
    include_once 'DBCancha.php';
    include_once 'Mensajes.php';

    class ApiCanchas                       
    {
        function getById($item)
        {
            $mensaje = new Mensajes_JSON();
            
            if($item['cancha'])
            {
                $item = ['id'=>$item['cancha'], 'accion'=>'cancha'];
                $this->listarCanchas($item);
            }
            else if($item['edificio'])
            {
                $item = ['id'=>$item['edificio'], 'accion'=>'edificio'];
                $this->listarCanchas($item);
            }
            else if($item['tipo'])
            {
                $item = ['id'=>$item['tipo'], 'accion'=>'tipo'];
                $this->listarCanchas($item);
            }
            else
            {
                $this->listarCanchas($item);
            }
            
        }

        //consulta solo el id solicitado
        function listarCanchas($item)
        {
            
            //creo un objeto de la clase estadoEdificio, donde esta la consulta
            $mensaje = new Mensajes_JSON();
            $cancha = new Cancha();
            $canchas = array();
            $res = $cancha->obtenerCanchas($item);
 
            if($res->rowCount() == 1)
            {
                $row = $res->fetch();
                $item = array(
                        'cancha'                =>$row['cancha'],
                        'nombre' 				=>$row['nombre'],
                        'descripcion'           =>$row['descripcion'],
						'telefonoContacto' 		=>$row['telefonoContacto'],
						'horaInicio' 			=>$row['horaInicio'],	
                        'horaFin' 				=>$row['horaFin'],
                        'idEdificio'            =>$row['idEdificio'],
						'edificio' 				=>$row['edificio'],						
						'idTipoCancha' 			=>$row['idTipoCancha'],	
                        'tipo' 				    =>$row['tipo'],
                        'idEstado' 				=>$row['idEstado'],
                        'estado'                =>$row['estado'],
                        'imagen'  =>base64_encode($row['imagen']),
                        'fechaCreacion'         =>$row['fechaCreacion']
                        );
                array_push($canchas, $item);
 
                $mensaje->printJSON($canchas);
            }
            else
            {
                $mensaje->error('No hay elementos seleccionados');
            }
        }

        //registrar nuevo estado
        function add($item)
        {
            $cancha = new Cancha();
            $res = $cancha->nuevoCancha($item);

            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos registrados');
        }

        //actualizar estado
        function update($item)
        {
           
            $cancha = new Cancha();
            $res = $cancha->actualizarCancha($item);
            
            //imprimir mensajes
            $mensaje = new Mensajes_JSON();
            $mensaje->exito('Datos actualizados');
        }

        //eliminar estado
        function delete($id)
        {
            $mensaje 	= new Mensajes_JSON();
            $cancha 	= new Cancha();

            //se realiza una consulta previa validando que el ID no este siendo utilizado en otra tabla
            $res = $cancha->validarCanchaID($id);
            
            $row = $res->fetch();
            //si la consulta retorna 0 se procede a eliminar sino muestra el mensaje de error
            
            if($row['cantidad'] == 0)
            {
                $item = ['id'=>$id, 'accion'=>'eliminar'];
                $res = $cancha->eliminarCancha($item);
                $mensaje->exito('Datos eliminados con exito');
            }
            else
            {
                $mensaje->error('No se puede eliminar este dato ya que esta siendo utilizado');
            }
            
        }

    }
?>