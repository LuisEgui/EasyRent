<?php

namespace FlejeMascarillas;

class Vehiculo{
	private $vin;
    private $licensePlate;
    private $model;
    private $fuelType;
    private $seatCount;
    private $state;

    const AVAILABLE = 0;

    const UNAVAILABLE = 1;

    const RESERVED = 2;

    const TYPES_STATE = [self::AVAILABLE, self::UNAVAILABLE, self::RESERVED];

    public static function crea($vin, $licensePlate, $model, $fuelType, $seatCount, $state)
    {
        $vehiculo = new Vehiculo($vin, $licensePlate, $model, $fuelType, $seatCount, $state = self::AVAILABLE);
        return $vehiculo;
    }

    public function __construct($vin, $licensePlate, $model, $fuelType, $seatCount, $state){
        $this->vin = $vin;
        $this->licensePlate = $licensePlate;
        $this->model = $model;
        $this->fuelType = $fuelType;
        $this->seatCount = $seatCount;
        if (!in_array($state, self::TYPES_STATE)) {
            throw new Exception("$state no es un tipo de acceso válido");
        }
        $this->state = intval($state);
    }

	public function registrar($_params){
        $sql="INSERT INTO Vehicle (vin, licensePlate, model, fuelType, seatCount, state) 
        VALUES ('$vin', '$licensePlate', '$model', '$fuelType', '$seatCount', '$state')";
    }

    public function actualizar($_params){
        $sql = "UPDATE `mascarillas` SET `producto`=:producto,`descripcion`=:descripcion,`foto`=:foto,`precio`=:precio,`categoria_id`=:categoria_id,`fecha`=:fecha  WHERE `id`=:id";

        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ":producto" => $_params['producto'],
            ":descripcion" => $_params['descripcion'],
            ":foto" => $_params['foto'],
            ":precio" => $_params['precio'],
            ":categoria_id" => $_params['categoria_id'],
            ":fecha" => $_params['fecha'],
            ":id" =>  $_params['id']
        );

        if($resultado->execute($_array))
            return true;

        return false;
    }

    public function eliminar($id){
        $sql = "DELETE FROM `mascarillas` WHERE `id`=:id ";

        $resultado = $this->cn->prepare($sql);
        
        $_array = array(
            ":id" =>  $id
        );

        if($resultado->execute($_array))
            return true;

        return false;
    }

    public function mostrar(){
        $sql = "SELECT mascarillas.id, producto, descripcion,foto,precio,nombre,fecha,estado FROM mascarillas 
        
        INNER JOIN categorias
        ON mascarillas.categoria_id = categorias.id ORDER BY mascarillas.id DESC
        ";
        
        $resultado = $this->cn->prepare($sql);

        if($resultado->execute())
            return $resultado->fetchAll();

        return false;
    }

    public function mostrarPorId($id){
        
        $sql = "SELECT * FROM `mascarillas` WHERE `id`=:id ";
        
        $resultado = $this->cn->prepare($sql);
        $_array = array(
            ":id" =>  $id
        );

        if($resultado->execute($_array))
            return $resultado->fetch();

        return false;
    }


}