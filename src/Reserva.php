<?php
//Mirar si las consultas sql estan bien
//Mirar si los %d, %f, %s estan bien escritos
//en el actualiza comprobar que la clave primaria esta bien, seguro que noç
//la funcion borra como hacemos para identificar la reserva? 
namespace ClaseReserva;

class Reserva{
    use MagicProperties;

	private $vehicle;
    private $user;
    private $state;
    private $pickupLocation;
    private $returnLocation;
    private $pickupTime;
    private $returnTime;
    private $price;

    const RESERVED = 0;

    const PENDING = 1;

    const CANCELLED = 2;

    const TYPES_STATE = [self::RESERVED => 'Reservado', self::PENDING => 'Pendiente', self::CANCELLED => 'Cancelado'];

    public static function getStringEnumState($enum){
        if($enum < sizeof(self::TYPES_STATE) && $enum >= 0){
            return self::TYPES_STATE[$enum];
        }
        else{
            return null;
        }
    }

    public static function crea($vehicle, $user, $pickupLocation, $returnLocation, $pickupTime, $returnTime, $price)
    {
        $reserva = new Reserva($vehicle, $user, $pickupLocation, $returnLocation, $pickupTime, $returnTime, $price, self::PENDING);
        return $reserva;
    }

    public function __construct($vehicle, $user, $pickupLocation, $returnLocation, $pickupTime, $returnTime, $price, $state){
        //hay que asegurarse de que las variables enumeradas toman los valores permitidos y eso se hace antes de llamar a la funcion crea()
        $this->vehicle = intval($vehicle);
        $this->user = intval($user);
        $this->pickupLocation = $pickupLocation;
        $this->returnLocation = $returnLocation;
        $this->pickupTime = $pickupTime;
        $this->returnTime = $returnTime;
        $this->price = floatval($price);
        $this->state = intval($state);
    }

    private static function getReservas($opciones = array())
    {
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = 'SELECT * FROM Reserve'; 

        if(!empty($opciones)){
            if($array_key_exists('pickupLocation', $opciones)){
                $opciones['pickupLocation'] = $conn->real_escape_string($opciones['pickupLocation']);
            }
            if($array_key_exists('returnLocation', $opciones)){
                $opciones['returnLocation'] = $conn->real_escape_string($opciones['returnLocation']);
            }
            if($array_key_exists('pickupTime', $opciones)){
                $opciones['pickupTime'] = $conn->real_escape_string($opciones['pickupTime']);
            }
            if($array_key_exists('returnTime', $opciones)){
                $opciones['returnTime'] = $conn->real_escape_string($opciones['returnTime']);
            }
            $query .= 'WHERE ';
            $contadorFiltros = 0;
            foreach ($opciones as $columna => $valor){
                if($columna != null && $contadorFiltros == 0){
                    $query .= $columna.' = '.$valor;
                }
                else if($columna != null && $contadorFiltros > 0){
                    $query .= 'AND '.$columna.' = '.$valor;
                }
                $contadorFiltros++;
            }
        }

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Reserva($fila['vehicle'], $fila['user'], $fila['pickupLocation'], $fila['returnLocation'], $fila['pickupTime'], $fila['returnTime'], $fila['price'], $fila['state']);
            } 
            $rs->free();
        } else {
            error_log($conn->error);
        }

        return $result; 
    }

    public static function listaReservas()
    {
        return self::getReservas();
    }

    public static function buscaPorFiltros($opciones = array())
    {
        return self::getReservas($opciones);
    }

    private static function inserta($reserva)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO Reserve (vehicle, user, pickupLocation, returnLocation, pickupTime, returnTime, price, state) VALUES (%d, %d, '%s', '%s', '%s', '%s', %f, %d)",
            $reserva->vehicle,
            $conn->real_escape_string($reserva->pickupLocation), 
            $conn->real_escape_string($reserva->returnLocation), 
            $conn->real_escape_date($reserva->pickupTime), // duda en como insertar los datetime
            $conn->real_escape_string($reserva->returnTime), 
            $reserva->price,
            $reserva->state,
        );

        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log(__CLASS__ . ": Se han insertado '$conn->affected_rows' !");
        }
        return $result;
    }

    private static function actualiza($reserva)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE Reserve SET pickupLocation = '%s', returnLocation = '%s', returnTime = '%s', price = %f, state = %d WHERE vehicle = %d AND user = %d AND pickupTime = '%s'",
            $conn->real_escape_string($reserva->pickupLocation), 
            $conn->real_escape_string($reserva->returnLocation),
            $conn->real_escape_string($reserva->returnTime), 
            $reserva->price,
            $reserva->state,
            $reserva->vehicle,
            $reserva->user, 
            $conn->real_escape_string($reserva->pickupTime)
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log(__CLASS__ . ": Se han actualizado '$conn->affected_rows' !");
        }
        return $result;
    }

    private static function borra($reserva)
    {
        return self::borraPorClavePrimaria($reserva);
    }

    private static function borraPorCalvePrimaria($reserva)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Vehicle WHERE vehicle = %d AND user = %d AND pickupTime = '%s'",
        $reserva->vehicle,
        $reserva->user, 
        $conn->real_escape_string($reserva->pickupTime)
    );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log(__CLASS__ . ": Se han borrado '$conn->affected_rows' !");
        }
        return $result;
    }
}