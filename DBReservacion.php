<?php

include_once 'conexion.php';

class reservacion extends ConexionDB
{

    function validarDisponibilidad($reserva)
    {
        $query = $this->connect()->prepare('Call getDisponibilidadReserva(:fecha, :hora, :cancha)');
        $query->execute(['fecha'=>$reserva['fecha'], 'hora'=>$reserva['hora'], 'cancha'=>$reserva['cancha']]);

        return $query;
    }

    //insert usuario nivel 1 y 2
    function registrarReserva($reserva)
    {
        
        $query = $this->connect()->prepare('Call InsertReservacionAdmin 
        (:fechayhora, :fecha, :usuarioAd, :usuario, :hora, :cancha, :estado, :tipo, :qr)');

        $query->execute([   'fechayhora'    =>$reserva['fechayhora'], 
                            'fecha'         =>$reserva['fecha'], 
                            'usuarioAd'     =>$reserva['usuarioAd'],
                            'usuario'       =>$reserva['usuario'], 
                            'hora'          =>$reserva['hora'],
                            'cancha'        =>$reserva['cancha'], 
                            'estado'        =>$reserva['estado'], 
                            'tipo'          =>$reserva['tipo'], 
                            'qr'            =>$reserva['qr'] 
                        ]);
        return $query;
    }

    //insert usuario final
    function nuevaReserva($reserva)
    {
        $query = $this->connect()->prepare('Call InsertReservacion(:fechayhora, :fecha, :usuario, :hora, :cancha, :estado, :tipo, :qr)');

        $query->execute([   'fechayhora'    =>$reserva['fechayhora'], 
                            'fecha'         =>$reserva['fecha'],
                            'usuario'       =>$reserva['usuario'], 
                            'hora'          =>$reserva['hora'],
                            'cancha'        =>$reserva['cancha'], 
                            'estado'        =>$reserva['estado'], 
                            'tipo'          =>$reserva['tipo'], 
                            'qr'            =>$reserva['qr'] 
                        ]);
        return $query;
    }

    
    function validarEstado($reserva)
    {
        $query = $this->connect()->prepare('Call DatosReserva(:numReserva)');
        $query->execute(['numReserva'=>$reserva['numReserva']]);
        return $query;
    }

    function consultaCancelReserva($id)
    {
        $query = $this->connect()->prepare('Call getNumCancelaciones(:id)');
        $query->execute(['id'=>$id]);
        return $query;
    }
    

    function UpdateReserva($reserva)
    {

        $query = $this->connect()->prepare('Call SetUpdateReserva(:id, :usuario, :estado, :comentario, :fechayhora)');
        $query->execute([   'id'          =>$reserva['id'],  
                            'usuario'     =>$reserva['usuario'], 
                            'estado'      =>$reserva['estado'],
                            'comentario'  =>$reserva['comentario'],
                            'fechayhora'  =>$reserva['fechayhora']
                        ]);        

        return $query;
    }

    function validarDisponibilidadActual($item)
    {
        $query = $this->connect()->prepare('Call getAllDisponibilidadHorarios(:cancha, :fecha)');
        $query->execute([ 'cancha'=>$item['cancha'], 'fecha'=>$item['fecha'] ]);

        return $query;
    }

}
?>