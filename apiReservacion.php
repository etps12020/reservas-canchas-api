<?php
    include_once 'Permisos.php';
    include_once 'DBReservacion.php';
    include_once 'DBHorarioReservacion.php';
    include_once 'Mensajes.php';

    class ApiReservacion                       
    {
        function add($item)
        {
            $perm = new permisos();
            $reserva = new reservacion();
            $mensaje = new Mensajes_JSON();

            //Agrega el estado por defecto a la reservacion
            $item['fechayhora'] = $mensaje->obtenerFecha();
            $item['estado'] = 1;
            $item['qr'] = "";

            //consultar el estado del usuario que solicita la reservacion
            $id = $item['usuario'];
            $res = $perm->getEstadoUsuario($id);
            $row = $res->fetch(); 

            if ($row['estado'] == 1)
            {
                $res = $reserva->validarDisponibilidad($item);
                $row = $res->fetch();
                //validar disponibilidad de cancha, fecha y hora            
                if($row['var'] == 0)
                {
                    $res = $perm->validarFechaRol($item);
                    $row = $res->fetch();
                    //validar que un usuario final no tenga una reserva en esa fecha
                    if($row['var'] == 0)
                    {
                        //usuario que esta realizando la reserva
                        if(array_key_exists('usuarioAd', $item))
                        {
                            $res = $reserva->registrarReserva($item);
                            $mensaje->exito('Datos registrados ADMIN');
                        }
                        else
                        {
                            $res = $reserva->nuevaReserva($item);
                            $mensaje->exito('Datos registrados Usuario final');
                        }
                    }
                    else
                    {
                        $mensaje->error('posee una reservacion para esa fecha');
                    }
                }
                else
                {
                    $mensaje->error('ya existe una reservacion aprobada para esa hora y fecha');
                }
            }
            else
            {
                $mensaje->error('El usuario no puede realizar ninguna reservacion, consulte con Admin Academica');
            }
            
        }


        function update($item)
        {
            $perm = new permisos();
            $mensaje = new Mensajes_JSON();
            $reserva = new reservacion();

            $this->obtenerID($item);
            $estadoActual = $this->idEstado;
            $item['id'] = $this->idReserva;
            $usu = $this->idUsu;

            $nuevoEstado = $item['estado'];
            
            //consultar el nivel de usuario que esta modificando el estado
            $id = $item['usuario'];
            $res = $perm->getRolUsuario($id);
            $row = $res->fetch(); 
            $rol = $row['var'];

            //solo el usuario final puede cancelar la reservacion
            if($nuevoEstado == 4)
            {
                if($estadoActual == 1 or $estadoActual == 3)
                {
                    //llama a la funcion update
                   $this->updateEstado($item);

                    //llama a la funcion para contar el numero de cancelaciones realizadas
                    $this->numCancelaciones($usu);
                }
                else
                {
                    $mensaje->error('esta reservacion no puede ser cancelada');
                }
            }
            //solo el admin y encargado pueden cambiar los demas estados
            else if($rol == 1 or $rol == 2)
            {
                if($estadoActual == 1 && ($nuevoEstado == 2 or $nuevoEstado == 3))
                {
                    $this->updateEstado($item);
                }
                else if($estadoActual == 3 && ($nuevoEstado == 5 or $nuevoEstado == 6))
                {
                    $this->updateEstado($item);
                }
                else if($estadoActual == 6 && $nuevoEstado == 7)
                {
                    $this->updateEstado($item);
                }
                else 
                {
                    $mensaje->error('No se puede actualizar el estado');
                }
            }
            else
            {
                $mensaje->error('No tiene permisos de edicion');
            }
        }

        function updateEstado($item)
        {   
            $mensaje = new Mensajes_JSON();
            $reserva = new reservacion();
            unset($item['numReserva']);

            $res = $reserva->UpdateReserva($item);
            $row = $res->fetch();
            $mensaje->exito('Reservacion '. $row['estado']);
        }   

        function numCancelaciones($usu)
        {   
            $perm = new permisos();
            $mensaje = new Mensajes_JSON();
            $reserva = new reservacion();

            $res = $reserva->consultaCancelReserva($usu);
            $row = $res->fetch();

            if($row['num'] == 3)
            {
                $res = $perm->bloquearUsuario($usu);
                $mensaje->exito('Su usuario ha sido bloqueado, comuniquese con Administracion Academica');
            }
            else
            {
                $mensaje->exito('Posee '. $row['num'] . ' de 3 Cancelaciones posibles');
            }
        }

        //obtener Usuario
        function obtenerIdUsuario($usu)
        {
            $perm = new permisos();
            $res = $perm->getIdUsuario($usu);
            $row = $res->fetch();
            $id = $row['id'];

            return $this->id = $id;
        }

        //consultar datos de la reservacion
        function obtenerID($id)
        {
            $reserva = new reservacion();
            $res = $reserva->validarEstado($id);
            $row = $res->fetch();
            $this->idEstado  = $idEstado = $row['idE'];
            $this->idReserva = $idReserva = $row['idR'];
            $this->idUsu = $idUsu = $row['usu'];
        }

    }
?>